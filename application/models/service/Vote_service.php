<?php

class Vote_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/vote_model');
    }

    function vote_result($sid) {
        $label = $this->vote_model->get_contents($sid);
        $label = explode ("|" , $label);
        $count = $this->vote_model->get_contents_number($sid);
        $contents = [];
        $data = [];

        if(empty($count)) {
            for($i=0;$i<count($label);$i++){
                $data[$i] = 0;
            }
        }else {
            $index = 0;
            $offset = 0;
            if((int)$count[0]['cn'] == 0){
                $index = 1;
                $offset = -1;
            }
            for($i = 1; $i <= count($label); $i++) {
                $index = $i-1-$offset;
                if($index<count($count)) {
                    if((int)$count[$index]['cn'] == $i) {
                        $data[$i-1] = (int)$count[$index]['count'];
                    }else {
                        $data[$i-1] = 0;
                        $offset++;
                    }
                }else {
                    $data[$i-1] = 0;
                }
            }
        }



/*
        $offset = 0;
        if((int)$count[0]['cn'] == 0)
        $offset = 1;
        for($i = 1; $i <= count($label); $i++) {
            if($i-1+$offset<count($count)){
                if((int)$count[$i-1+$offset]['cn'] == $i){
                    $data[$i-1] = (int)$count[$i+$offset-1]['count'];
                }else{
                    $data[$i-1] = 0;
                    $offset--;
                }
            }else{
                $data[$i-1] = 0;
                $offset--;
            }

        }
*/

        if(!empty($label)) {
            return array('result'=>"success", 'label'=>$label,'data'=>$data);
            //return $data;
        }
        else {
            return array('result'=>"fail", 'errormsg'=>'There are no vote in this room.');
            //return $data;
        }

    }

    function vote_register($vote) {
        $result = $this->vote_model->insert_vote($vote);
        return $result;
    }

    function searchVoteByUrl($url){
        return $this->vote_model->selectVoteByUrl($url);
    }
    function get_part_num($sid) {
        $part_num = $this->vote_model->get_part_num($sid);
        return $part_num;
    }

    function get_vote($sid) {
        return $this->vote_model->get_title_deadline($sid);
    }

    function get_contents($sid) {
        $contents = $this->vote_model->get_contents($sid);
        return $contents;
    }

    /*
        get_choice_by_vote_id_and_user_id
        parameter: 투표 아이디(sid)와 유저 아이디(sid)
        return: sp_user_vote_choice의 배열 (값이 하나여도 배열로 리턴)
                NULL (결과 값이 없는 경우)
    */
    function get_choice_by_vote_id_and_user_id($vote_id, $user_id){
        if(empty($user_id))
            return NULL;

        return $this->vote_model->get_choice_by_vote_id_and_user_id($vote_id, $user_id);
    }

    /*
        voting
        parameter: 투표(배열)와 유저의 선택지("|"로 나누어져있음)
    */
    function voting($vote, $contents_number, $user){
        $anonymous_check = $vote['anonymous_check'];
        $part_auth = $vote['part_auth'];
        $contents_number = explode("|",$contents_number);

        // case1: 실명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = name
        if($anonymous_check==0 && $part_auth==0){
            $inputs = $this->makeInputs($contents_number, $vote['sid'], $user['sid'], $user['name']);
            $result = $this->vote_model->voting($inputs);

        // case2: 익명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = nickname
        }else if($anonymous_check==1 && $part_auth==0){
            $inputs = $this->makeInputs($contents_number, $vote['sid'], $user['sid'], $user['nickname']);
            $result = $this->vote_model->voting($inputs);
        
        // case3: 익명이면서 아무나 투표 가능 -> user_id = NULL, cur_name = 'anonymous' 
        }else if($anonymous_check==1 && $part_auth==1){
            $inputs = $this->makeInputs($contents_number, $vote['sid'], NULL, 'anonymous');
            $result = $this->vote_model->voting($inputs);

        // case4: 실명이면서 아무나 투표 가능 -> 불가능한 경우
        }else{
            return false;
        }

        // 로그인 한 경우이므로 사용자를 방에 추가한다
        if($part_auth == 0){
            $this->load->model('dao/room_model');

            // 방에 포함되어 있지 않은 경우
            if(empty($this->room_model->select_sp_room_user_by_room_and_user_id($vote['room_id'], $user['sid'])))
                $this->room_model->insert_sp_room_user($vote['room_id'], $user['sid'], 2);
        }

        return $result;
    }

    function makeInputs($contents_number, $vote_id, $user_id, $cur_name){
        $inputs = array();
        foreach($contents_number as $cn){
            array_push($inputs, array(
                'user_id' => $user_id,
                'cur_name' => $cur_name,
                'vote_id' => $vote_id,
                'contents_number' => $cn
            ));
        }

        return $inputs;
    }
}
?>
