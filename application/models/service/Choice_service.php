<?php

class Choice_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/choice_model');
    }

    /*
        voting
        parameter: 투표(배열)와 유저의 선택지("|"로 나누어져있음)
    */
    function voting($choice){
        $this->load->model('dao/user_model');
        $this->load->model('dao/vote_model');
        $this->load->model('dao/group_model');

        $user = null;
        if(!empty($choice['user_id']))
            $user = $this->user_model->selectOneById($choice['user_id']);
        $vote = $this->vote_model->selectOneById($choice['vote_id']);
        $group = $this->group_model->selectOneById($vote['group_id']);

        $is_anonymous = $group['is_anonymous'];
        $part_auth = $group['part_auth'];

        // case1: 실명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = name
        if($is_anonymous==0 && $part_auth==0){
            $inputs = $this->makeChoice($choice['choice_no'], $vote['sid'], $user['sid'], $user['name']);
            $result = $this->choice_model->insertOne($inputs);

        // case2: 익명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = nickname
        }else if($is_anonymous==1 && $part_auth==0){
            $inputs = $this->makeChoice($choice['choice_no'], $vote['sid'], $user['sid'], $user['nickname']);
            $result = $this->choice_model->insertOne($inputs);

        // case3: 익명이면서 링크를 가진 누구나 투표 가능 -> user_id = NULL, cur_name = 'anonymous'
        }else if($is_anonymous==1 && $part_auth==1){
            $inputs;
            if(empty($user))
                $inputs = $this->makeChoice($choice['choice_no'], $vote['sid'], null, 'anonymous');
            else
                $inputs = $this->makeChoice($choice['choice_no'], $vote['sid'], $user['sid'], $user['nickname']);
            $result = $this->choice_model->insertOne($inputs);

        // case4: 실명이면서 링크를 가진 누구나 투표 가능 -> 불가능한 경우
        }else{
            return false;
        }

        // 로그인 한 경우이므로 사용자를 방에 추가한다
        if(!empty($choice['user_id'])){
            $this->load->model('dao/room_model');

            // 방에 포함되어 있지 않은 경우 방에 추가한다
            if(empty($this->room_model->selectOneByRoomIdAndUserId($group['room_id'], $user['sid'])))
                $this->room_model->insertUser2Room($group['room_id'], $user['sid'], 2);
        }

        return $result;
    }

    function makeChoice($choice_no, $vote_id, $user_id, $user_nickname){
        $inputs = array(
            'user_id' => $user_id,
            'user_nickname' => $user_nickname,
            'vote_id' => $vote_id,
            'choice_no' => $choice_no
        );

        return $inputs;
    }

    function getVoteResult($vote) {
        $result = array();
        $choices = explode('|',$vote['choices']);
        $result['label'] = $choices;
        
        $sum = array();
        for($i=0;$i<count($choices);$i++){
            array_push($sum,0);
        }

        $list = $this->choice_model->selectListByVoteId($vote['sid']);
        for($i=0;$i<count($list);$i++){
            $choice_no = explode('|',$list[$i]['choice_no']);
            for($j=0;$j<count($choice_no);$j++){
                $sum[(int)$choice_no[$j]-1]++;
            }
        }

        $result['data'] = $sum;
        $result['part_num'] = count($list);

        return $result;
    }

    function getParticipant($vote){
        $choiceList = $this->choice_model->selectListByVoteId($vote['sid']);
        $choice_no = count(explode('|',$vote['choices']));
        $participant = array();
    
        for($i=0;$i<$choice_no;$i++){
            array_push($participant,array());
        }

        for($i=0;$i<count($choiceList);$i++){
            $userChoice = explode('|',$choiceList[$i]['choice_no']);
            for($j=0;$j<count($userChoice);$j++){
                array_push($participant[(int)$userChoice[$j]-1], $choiceList[$i]['user_nickname']);
            }
        }

        return $participant;
    }

    /*
        getChoiceByVoteIdAndUserId
        parameter: 투표 아이디(sid)와 유저 아이디(sid)
        return: sp_user_vote_choice의 배열 (값이 하나여도 배열로 리턴)
                NULL (결과 값이 없는 경우)
    */
    function getChoiceByVoteIdAndUserId($vote_id, $user_id){
        if(empty($user_id))
            return NULL;

        return $this->choice_model->selectOneByVoteIdAndUserId($vote_id, $user_id);
    }

    function updateChoice($choice){
        return $this->choice_model->updateOne($choice);
    }

    function deleteChoice($sid){
        return $this->choice_model->deleteOne($sid);
    }
}
?>