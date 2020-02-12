<?php
/*
-- sp_room Table Create SQL
CREATE TABLE sp_room
(
    `sid`               INT            NOT NULL    AUTO_INCREMENT COMMENT '시퀀스 아이디',
    `room_id`           VARCHAR(4)     NOT NULL    COMMENT '방 아이디 (네글자)',
    `master`            INT            NOT NULL    COMMENT '방장',
    `title`             VARCHAR(45)    NOT NULL    COMMENT '방 제목',
    `deleted`           TINYINT(1)     NOT NULL    DEFAULT 0 COMMENT '삭제 여부',
    `user_name_type`    INT            NOT NULL    COMMENT '참여자 실명/닉네임 여부',
    `vote_create_auth`  INT            NOT NULL    COMMENT '투표 생성권한',
    `deadline_check`    TINYINT(1)     NOT NULL    COMMENT '마감날짜 설정여부',
    `deadline`          TIMESTAMP      NULL        COMMENT '마감날짜',
    PRIMARY KEY (sid)
);

ALTER TABLE sp_room COMMENT '방';

ALTER TABLE sp_room
    ADD CONSTRAINT FK_sp_room_master_sp_user_sid FOREIGN KEY (master)
        REFERENCES sp_user (sid) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_room
    ADD UNIQUE UK_sp_room_room_id (room_id);

*/
class Room_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //room 생성 - deadline이 있는 경우.
    function insert_deadline($room){
        $sql = "INSERT INTO sp_room (`room_id`,`master`,`title`,`user_name_type`,`vote_create_auth`,`deadline_check`,`deadline`) VALUES (?,?,?,?,?,?,?)";

        // $query is TRUE or FALSE
        $query = $this->db->query($sql, array($room['room_id'],$room['master'],$room['title'], $room['user_name_type'], $room['vote_create_auth'], $room['deadline_check'], $room['deadline']));

        if($query)
            return $query;
        else
            return false;
            // return $this->db->error();
            // array(2) { ["code"]=> int(1062) ["message"]=> string(62) "Duplicate entry 'id@example.com' for key 'UK_sp_user_email'" }
    }

    //room 생성 - deadline이 없는 경우.
    function insert_no_deadline($room){
        $sql = "INSERT INTO sp_room (`room_id`,`master`,`title`,`user_name_type`,`vote_create_auth`,`deadline_check`) VALUES (?,?,?,?,?,?)";

        // $query is TRUE or FALSE
        $query = $this->db->query($sql, array($room['room_id'],$room['master'],$room['title'], $room['user_name_type'], $room['vote_create_auth'], $room['deadline_check']));

        if($query)
            return $query;
        else
            return false;
            // return $this->db->error();
            // array(2) { ["code"]=> int(1062) ["message"]=> string(62) "Duplicate entry 'id@example.com' for key 'UK_sp_user_email'" }
    }

    //room_id 만들 때, room_id가 이미 존재하는지 판별하는 함수.
    //중복되는 room_id 가 없으면 true 반환
    //아니면 false를 반환한다.
    function duplicate($room_id){
        $sql  = "SELECT room_id";
        $sql .= " FROM sp_room";
        $sql .= " WHERE room_id = ?";

        $result = $this->db->query($sql, array($room_id))->row();
        if(!empty($result)) return false;
        else return true;
    }

    //room_id를 이용해서 sp_room의 sid를 반환한다.
    function find_sid($room_id){
        $sql = "SELECT sid FROM sp_room WHERE room_id = ?";
        $result = $this->db->query($sql, array($room_id))->row();
        return $result->sid;
    }

    //room_sid와 방장의 sid를 sp_room_user에 추가한다.
    function insert_sp_room_user($room_sid, $master) {
        $sql = "INSERT INTO sp_room_user (`room_id`,`user_id`) VALUES (?,?)";
        $query = $this->db->query($sql, array($room_sid,$master));
    }
}
?>
