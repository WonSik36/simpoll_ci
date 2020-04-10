<?php

class Question_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/question_model');
    }

    function register($question) {
        return $this->question_model->insertOne($question);
    }

    function getQuestionById($sid) {
        return $this->question_model->selectOneById($sid);
    }

    function getQuestionListBySimpollId($simpoll_id){
        return $this->question_model->selectListBySimpollId($simpoll_id);
    }

    function updateQuestion($question){
        return $this->question_model->updateOne($question);
    }

    function deleteQuestion($sid){
        return $this->question_model->deleteOne($sid);
    }
}
?>
