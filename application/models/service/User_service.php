<?php

class User_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/user_model');
    }

    /*
        insert
        param: 배열(사용자)
    */
    function signup($user){
        return $this->user_model->insertOne($user);
    }

    /*
        login
        param: 유저 email, password
        return: 유저 object
    */
    function login($email, $pw){
        return $this->user_model->selectOneByEmailAndPW($email, $pw);
    }

    /* 
        findAudiencesInRoom
        param: room id
        return 유저 리스트
    */
    function findAudiencesInRoom($room_id){
        return $this->user_model->selectListByRoomId($room_id);
    }
}
?>
