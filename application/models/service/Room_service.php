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
        //dao에 room insert를 요청한다.
        $this->room_model->insert_room($room);
        $master = $room['master'];
        //master를 이용해서 해당 방의 sid를 검색한다.
        $room_sid = $this->room_model->find_sid($master);
        //room의 sid와 user_id를 이용해서 방장을 해당 방에 넣어준다.
        $this->room_model->insert_sp_room_user($room_sid, $master,1);
        return $room_sid;
    }

    /*
        get_room_and_list
        param: room_sid (방 시퀀스 아이디)
        return: array('room'=>$room, 'list'=>$list)
    */
    function get_room_and_list($room_sid) {
        $this->load->model('dao/vote_model');
        //room_sid를 이용해서 방 제목, 방 id, 기간 가져오기 -> $room
        $room = $this->room_model->get_room($room_sid);
        $list = $this->vote_model->get_list($room_sid);
        return array('room'=>$room, 'list'=>$list);
    }

    /*
        get_room_and_list
        param: room_sid (방 시퀀스 아이디)
        return: all_list
    */
    function get_list_by_room_id($room_sid) {
        $this->load->model('dao/vote_model');
        $all_list = $this->vote_model->get_all_list($room_sid);
        $voted_list = $this->vote_model->get_voted_list($room_sid);

        for($i = 0; $i < count($all_list); $i++) {
            for($j = 0; $j < count($voted_list); $j++){
                if((int)$all_list[$i]['sid'] == (int)$voted_list[$j]['sid']) {
                    // 투표했으면 true, 아직 안했으면 false를 voted라는 항목에 넣어준다.
                    $all_list[$i]['voted'] = "TRUE";
                }else {
                    $all_list[$i]['voted'] = "FALSE";
                }
            }
        }
        return $all_list;
        //return array('all_list'=>$all_list, 'voted_list'=>$voted_list);
    }

    /*
        get_room_by_sid
        param: sid (방 시퀀스 아이디)
        return: 방(array)
    */
    function get_room_by_sid($sid) {
        return $this->room_model->get_room($sid);
    }

    /*
        speacker_room_list
        자신이 강연자로 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function speacker_room_list($user_id) {
        return $this->room_model->speacker_room_list($user_id);
    }

    /*
        audience_room_list
        자신이 참여하고 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function audience_room_list($user_id) {
        return $this->room_model->audience_room_list($user_id);
        //return array('room'=>$room, 'master'=>$master);
    }
}
?>
