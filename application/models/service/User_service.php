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
        $this->user_model->insert($user);
    }

    /*
        login
        param: 유저 email, password
        return: 유저 object
    */
    function login($email, $pw){
        return $this->user_model->login($email, $pw);
    }
}
?>
