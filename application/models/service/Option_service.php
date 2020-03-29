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
    function voting($option){
        $this->load->model('dao/user_model');
        $this->load->model('dao/question_model');
        $this->load->model('dao/simpoll_model');

        $user = null;
        if(!empty($option['user_id']))
            $user = $this->user_model->selectOneById($option['user_id']);
        $question = $this->question_model->selectOneById($option['question_id']);
        $simpoll = $this->simpoll_model->selectOneById($question['simpoll_id']);

        $is_anonymous = $simpoll['is_anonymous'];
        $part_auth = $simpoll['part_auth'];

        // case1: 실명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = name
        if($is_anonymous==0 && $part_auth==0){
            $inputs = $this->makeOption($option['option_no'], $question['sid'], $user['sid'], $user['name']);
            $result = $this->option_model->insertOne($inputs);

        // case2: 익명이면서 로그인 한 사람만 참여 가능 -> user_id = 사용자 id, cur_name = nickname
        }else if($is_anonymous==1 && $part_auth==0){
            $inputs = $this->makeOption($option['option_no'], $question['sid'], $user['sid'], $user['nickname']);
            $result = $this->option_model->insertOne($inputs);

        // case3: 익명이면서 링크를 가진 누구나 투표 가능 -> user_id = NULL, cur_name = 'anonymous'
        }else if($is_anonymous==1 && $part_auth==1){
            $inputs;
            if(empty($user))
                $inputs = $this->makeOption($option['option_no'], $question['sid'], null, 'anonymous');
            else
                $inputs = $this->makeOption($option['option_no'], $question['sid'], $user['sid'], $user['nickname']);
            $result = $this->option_model->insertOne($inputs);

        // case4: 실명이면서 링크를 가진 누구나 투표 가능 -> 불가능한 경우
        }else{
            return false;
        }

        // 로그인 한 경우이므로 사용자를 방에 추가한다
        if(!empty($option['user_id'])){
            $this->load->model('dao/room_model');

            // 방에 포함되어 있지 않은 경우 방에 추가한다
            if(empty($this->room_model->selectOneByRoomIdAndUserId($simpoll['room_id'], $user['sid'])))
                $this->room_model->insertUser2Room($simpoll['room_id'], $user['sid'], 2);
        }

        return $result;
    }

    function makeOption($option_no, $question_id, $user_id, $user_nickname){
        $inputs = array(
            'user_id' => $user_id,
            'user_nickname' => $user_nickname,
            'question_id' => $question_id,
            'option_no' => $option_no
        );

        return $inputs;
    }

    function getOptionResult($question) {
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

    /*
        getoptionByQuestionIdAndUserId
        parameter: 투표 아이디(sid)와 유저 아이디(sid)
        return: sp_user_question_option의 배열 (값이 하나여도 배열로 리턴)
                NULL (결과 값이 없는 경우)
    */
    function getOptionByQuestionIdAndUserId($question_id, $user_id){
        if(empty($user_id))
            return NULL;

        return $this->option_model->selectOneByQuestionIdAndUserId($question_id, $user_id);
    }

    function getOptionById($question_id){
        return $this->option_model->selectOneById($question_id);
    }

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
            $userOption = count(explode('|',$optionList[$i]['user_id']));
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
