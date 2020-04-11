<?php

class Option_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/option_model');
    }


    /*
        voting
        parameter: 투표(배열)와 유저의 선택지("|"로 나누어져있음)
    */
    // 검증 과정 필요
    function voting($option_id,$user_id){
        $result = false;
        $this->load->model('dao/user_model');
        $this->load->model('dao/question_model');
        $this->load->model('dao/simpoll_model');
        $user = $this->user_model->selectOneById($user_id);
        $option1 = $this->option_model->selectOneById($option_id[0]);
        $question = $this->question_model->selectOneById($option1['question_id']);
        $simpoll = $this->simpoll_model->selectOneById($question['simpoll_id']);

        $is_anonymous = $simpoll['is_anonymous'];
        $part_auth = $simpoll['part_auth'];
        for($i=0;$i<count($option_id);$i++){
            $option = $this->option_model->selectOneById($option_id[$i]);
            // case1: 실명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = name
            if($is_anonymous==0 && $part_auth==0){
                // 검증 과정 필요
                $inputs = $this->makeOption($option_id[$i], $option['name'], $option['question_id'], $option['user_id'], $user_id, $option['user_nickname'], $user['name'], $option['count']);
                $result = $this->option_model->updateOne($inputs);

            // case2: 익명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = nickname
            }else if($is_anonymous==1 && $part_auth==0){
                // 검증 과정 필요
                $inputs = $this->makeOption($option_id[$i], $option['name'], $option['question_id'], $option['user_id'], $user_id, $option['user_nickname'], $user['nickname'], $option['count']);
                $result = $this->option_model->updateOne($inputs);

            // case3: 익명이면서 링크를 가진 누구나 투표 가능 -> user_id = NULL, cur_name = 'anonymous'
            }else if($is_anonymous==1 && $part_auth==1){
                $inputs;
                if(empty($user)){
                    $inputs = $this->makeOption($option_id[$i], $option['name'], $option['question_id'], $option['user_id'], null, $option['user_nickname'], null, $option['count']);
                }else{
                    $inputs = $this->makeOption($option_id[$i], $option['name'], $option['question_id'], $option['user_id'], $user_id, $option['user_nickname'], $user['nickname'], $option['count']);
                }
                
                $result = $this->option_model->updateOne($inputs);

            // case4: 실명이면서 링크를 가진 누구나 투표 가능 -> 불가능한 경우
            }else{
                return false;
            }
        }


        // 로그인 한 경우이므로 사용자를 방에 추가한다
        if(!empty($user_id)){
            $this->load->model('dao/room_model');

            // 방에 포함되어 있지 않은 경우 방에 추가한다
            if(empty($this->room_model->selectOneByRoomIdAndUserId($simpoll['room_id'], $user['sid'])))
                $this->room_model->insertUser2Room($simpoll['room_id'], $user['sid'], 2);
        }

        return $result;
    }

    function makeOption($option_id, $option_name, $question_id, $user_id, $new_user_id, $user_nickname, $new_user_nickname, $count){

        if(empty($new_user_id) && empty($new_user_nickname)){
            // dont change current user id list and user nickname list
        }else if(!empty($user_id)||!empty($user_nickname)){
            $array = array($user_id,$new_user_id);
            $user_id = implode('|', $array);
            $array2 = array($user_nickname,$new_user_nickname);
            $user_nickname = implode('|', $array2);
        }else{
            $user_id = $new_user_id;
            $user_nickname = $new_user_nickname;
        }

        $count = ((int)$count)+1;
        $inputs = array(
            'sid' => $option_id,
            'name' => $option_name,
            'user_id' => $user_id,
            'user_nickname' => $user_nickname,
            'question_id' => $question_id,
            'count' => $count
        );

        return $inputs;
    }

/*    function getOptionResult($question) {
        $result = array();
        $options = explode('|',$question['options']);
        $result['label'] = $options;

        $sum = array();
        for($i=0;$i<count($options);$i++){
            array_push($sum,0);
        }

        $list = $this->option_model->selectListByQuestionId($question['sid']);
        for($i=0;$i<count($list);$i++){
            $option_no = explode('|',$list[$i]['option_no']);
            for($j=0;$j<count($option_no);$j++){
                $sum[(int)$option_no[$j]-1]++;
            }
        }

        $result['data'] = $sum;
        $result['part_num'] = count($list);

        return $result;
    }
*/
    /*
        getoptionByQuestionIdAndUserId
        parameter: 투표 아이디(sid)와 유저 아이디(sid)
        return: sp_user_question_option의 배열 (값이 하나여도 배열로 리턴)
                NULL (결과 값이 없는 경우)
    */
    /*
    function getOptionByQuestionIdAndUserId($question_id, $user_id){
        if(empty($user_id))
            return NULL;

        return $this->option_model->selectOneByQuestionIdAndUserId($question_id, $user_id);
    }

    function getOptionById($question_id){
        return $this->option_model->selectOneById($question_id);
    }
*/
    /*
        registerOption
        option 항목당 table 생성
    */
    function registerOption($option){
        return $this->option_model->insertOne($option);
    }

    /*
        getParti_forOption
        return question의 option에 대한 user들을 선택 결과.
    */
    function getParti_forOption($question){
        $optionList = $this->option_model->selectListByQuestionId($question['sid']);
        $option_no = $question['choice_no'];
        $participant = array();

        for($i=0;$i<$option_no;$i++){
            array_push($participant,array());
        }

        for($i=0;$i<count($optionList);$i++){
            $userOption = count(explode('|',$optionList[$i]['user_nickname']));
            for($j=0;$j<$option_no;$j++){
                array_push($participant[j],$userOption);
            }
        }

        return $participant;
    }

    function updateOption($option){
        return $this->option_model->updateOne($option);
    }

    function deleteOption($sid){
        return $this->option_model->deleteOne($sid);
    }
}
?>
