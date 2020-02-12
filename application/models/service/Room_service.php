<?php

class Room_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/room_model');
    }

    /*
        insert
        param: 배열(사용자)
    */
    function register($user){
        return $this->room_model->insert($user);
    }

    /*
        login
        param: 유저 email, password
        return: 유저 object
    */
    function speacker_room_list($email, $pw){
        return $this->user_model->login($email, $pw);
    }
}
?>
