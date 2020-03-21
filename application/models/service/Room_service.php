<?php

class Room_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/room_model');
    }

    /*
        register
        param: 배열(방)
        성공시 : room_id를 return 한다.
        실패시 : NULL을 return 한다.
    */
    function register($room) {
        $this->db->trans_start();

        // dao에 room insert를 요청한다.
        $this->room_model->insertOne($room);
        
        // master를 이용해서 해당 방의 sid를 검색한다.
        $user_id = $room['master'];
        $newRoom = $this->room_model->selectListByMaster($user_id)[0];
        $room_id = $newRoom['sid'];

        // room의 sid와 user_id를 이용해서 방장을 해당 방에 넣어준다. $auth:1
        $this->room_model->insertUser2Room($room_id, $user_id, 1);

        // room의 part_num을 1 올려준다
        $this->room_model->addPartNum($room_id);

        $this->db->trans_complete();
        return $room_id;
    }

    /*
        addAudience2Room
        param: 방아이디, 유저아이디, 권한(1:방장, 2:일반)
    */
    function addAudience2Room($room_id, $user_id){
        $this->room_model->insertUser2Room($room_id, $user_id, 2);
        $this->room_model->addPartNum($room_id);
    }

    /*
        getRoomById
        param: sid (방 시퀀스 아이디)
        return: 방(array)
    */
    function getRoomById($sid) {
        return $this->room_model->selectOneById($sid);
    }

    /*
        getMasterRoomList
        자신이 강연자로 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function getMasterRoomList($user_id) {
        return $this->room_model->selectListByMaster($user_id);
    }

    /*
        getAudienceRoomList
        자신이 참여하고 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function getAudienceRoomList($user_id) {
        return $this->room_model->selectListByUserId($user_id);
    }

    /*
        getRoomByUrl
        입력받은 URL에 매칭되는 방을 찾는다
        param: 방 url
        return: 성공시 방(array) 실패시 NULL
    */
    function getRoomByUrl($url){
        return $this->room_model->selectOneByUrl($url);
    }

    function updateRoom($room){
        return $this->room_model->updateOne($room);
    }

    function deleteRoom($sid){
        return $this->room_model->deleteOne($sid);
    }
}
?>
