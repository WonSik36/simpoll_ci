<?php

class Simpoll_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/simpoll_model');
    }

    function register($simpoll){
        $this->simpoll_model->insertOne($simpoll);
        $simpoll = $this->simpoll_model->selectListByUserId($simpoll['user_id'])[0];

        return $simpoll['sid'];
    }

    function getSimpollById($sid){
        return $this->simpoll_model->selectOneById($sid);
    }

    // 유저가 투표한 vote는 voted: true,
    // 투표하지 않은 vote는 voted: false
    // 결과 중심이니 일단 사용 X
   function getSimpollListWithQuestionListByRoomIdAndQuestionId($room_id,$question_id){
        //$list = $this->simpoll_model->selectListWithQuestionByRoomId($room_id);
        return $this->simpoll_model->selectListWithQuestionAndOptionByRoomIdAndQuestionId($room_id,$question_id);

    }

    function getSimpollListWithQuestionListByRoomId($room_id){
        return $this->simpoll_model->selectListWithQuestionByRoomId($room_id);
    }

    /*
        getsimpollByUrl
        입력받은 URL에 매칭되는 방을 찾는다
        param: 방 url
        return: 성공시 방(array) 실패시 NULL
    */
    function getSimpollByUrl($url){
        return $this->simpoll_model->selectOneByUrl($url);
    }

    function updateSimpoll($simpoll){
        return $this->simpoll_model->updateOne($simpoll);
    }

    function deleteSimpoll($sid){
        return $this->simpoll_model->deleteOne($sid);
    }
}
?>
