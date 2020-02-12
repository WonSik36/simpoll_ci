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
    function register($room){
        $room_id = "";
        for($j = 0; $j < 5; $j++){
            if($j == 4) return false;
            $arr = array();
            //room_id를 얻는다.
            $rand = mt_rand(0, 7311615); //52^4 = 7311616
            $arr[0] = $rand % 52;
            $rand = $rand / 52;
            $arr[1]  = $rand % 52;
            $rand = $rand / 52;
            $arr[2]  = $rand % 52;
            $arr[3]  = $rand / 52;

            for($i = 0; $i < 4; $i++){
                if($arr[$i] < 26) {
                    $arr[$i] = $arr[$i] + 97;
                }else {
                    $arr[$i] = $arr[$i] + 39;
                }
            }

            $room_id = "";
            for($i = 0; $i < 4; $i++){
                $room_id .= chr($arr[$i]);
            }
            //dao에 중복되는 room_id 가 있는지 물어본다.
            $duplicate = $this->room_model->duplicate($room_id);
            if($duplicate) break;
        }
        //room에 room_id를 넣어준다.
        $room['room_id']=$room_id;
        //return $room;

        //dao에 room insert를 요청한다.
        $result;
        if(empty($room['deadline'])){
            $result = $this->room_model->insert_no_deadline($room);
        }else{
            $result = $this->room_model->insert_deadline($room);
        }
        //room_id를 이용해서 해당 방의 sid를 검색한다.
        $room_sid = $this->room_model->find_sid($room_id);
        //room의 sid와 user_id를 이용해서 방장을 해당 방에 넣어준다.
        $master = $room['master'];
        $this->room_model->insert_sp_room_user($room_sid, $master);
        return $result;
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
