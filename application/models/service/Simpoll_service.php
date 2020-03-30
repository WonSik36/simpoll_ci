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

    // 투표 결과 (청중, 강연자)
   function getSimpollListWithQuestionListBySimpollId($simpoll_id){
        return $this->simpoll_model->selectListWithQuestionAndOptionBySimpollId($simpoll_id);

    }
    // simpll list 요구시 (청중, 강연자)
    function getSimpollListWithQuestionListByRoomId($room_id){
        return $this->simpoll_model->selectListWithQuestionByRoomId($room_id);
    }

    function createSimpoll($input){
        $this->load->model('service/question_service');
        $this->load->model('service/option_service');
        $this->db->trans_start();
            // 심폴 생성
            // 문항 생성
            for($i=0; $i<count($input['question']); $i++){
                $question = $input['questions'][$i];
                $question_service->register($question);
                for($j=0; $i<count($input['question'][$i]['options']); $j++){
                    $option = $input['question'][$i]['options'][$j];
                    $option_service->registerOption($option);
                }
            }

        $this->db->trans_complete();
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
