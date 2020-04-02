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

    function getSimpollWithOptionById($sid){
        return $this->simpoll_model->selectSimpollById($sid);
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
            $bool = $this->simpoll_model->insertOne($input);
            if($bool){
                $simpoll = $this->simpoll_model->selectListByRoomId($input['room_id'])[0];

                for($i=0; $i<count($input['questions']); $i++){
                    $question = $input['questions'][$i];
                    $question['simpoll_id'] = $simpoll['sid'];

                    $this->question_service->register($question);
                    $questionList = $this->question_model->selectListBySimpollId($simpoll['sid']);
                    $question = $questionList[count($questionList)-1];

                    for($j=0; $j<count($input['questions'][$i]['options']); $j++){
                        $option = array(
                            'name'=>$input['questions'][$i]['options'][$j]
                        );
                        $option['question_id'] = $question['sid'];
                        $option['user_id'] = '';
                        $option['user_nickname'] = '';
                        $this->option_service->registerOption($option);
                    }
                }
            }else{
                return false;
            }
            // 문항 생성


        $this->db->trans_complete();
        return true;
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
