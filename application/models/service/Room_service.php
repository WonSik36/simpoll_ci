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
        speacker_room_list
        자신이 강연자로 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function speacker_room_list($user_id){
        return $this->room_model->speacker_room_list($user_id);
    }
}
?>
