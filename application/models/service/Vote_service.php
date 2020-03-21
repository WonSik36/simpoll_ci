<?php

class Vote_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/vote_model');
    }

    function register($vote) {
        return $this->vote_model->insertOne($vote);
    }

    function getVoteById($sid) {
        return $this->vote_model->selectOneById($sid);
    }

    function getVoteListByGroupId($group_id){
        return $this->vote_model->selectListByGroupId($group_id);
    }

    function updateVote($vote){
        return $this->vote_model->updateOne($vote);
    }

    function deleteVote($sid){
        return $this->vote_model->deleteOne($sid);
    }
}
?>
