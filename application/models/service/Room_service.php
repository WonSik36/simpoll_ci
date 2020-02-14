<?php

class Room_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/room_model');
        $this->load->model('dao/vote_model');
    }

    /*
        register
        param: 배열(방)
        성공시 : room_id를 return 한다.
        실패시 : NULL을 return 한다.
    */
    function register($room){
        //dao에 room insert를 요청한다.
        $this->room_model->insert_room($room);
        $master = $room['master'];
        //master를 이용해서 해당 방의 sid를 검색한다.
        $room_sid = $this->room_model->find_sid($master);
        //room의 sid와 user_id를 이용해서 방장을 해당 방에 넣어준다.
        $this->room_model->insert_sp_room_user($room_sid, $master);
        return $room_sid;
    }

    /*
        get_room_and_list
        param: room_id (네글자 방 코드)
        return: array('room'=>$room, 'list'=>$list)
    */
    function get_room_and_list($room_sid) {
        //room_sid를 이용해서 방 제목, 방 id, 기간 가져오기 -> $room
        $room = $this->room_model->get_room($room_sid);
        $list = $this->vote_model->get_list($room_sid);
        return array('room'=>$room, 'list'=>$list);
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
