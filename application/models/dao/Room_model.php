<?php
/*
-- sp_room Table Create SQL
CREATE TABLE sp_room
(
    `sid`               INT             NOT NULL    AUTO_INCREMENT COMMENT '시퀀스 아이디',
    `url_name`          VARCHAR(255)    NULL        COMMENT 'url 이름',
    `master`            INT             NOT NULL    COMMENT '방장',
    `title`             VARCHAR(255)    NOT NULL    COMMENT '방 제목',
    `deleted`           TINYINT(1)      NOT NULL    DEFAULT 0 COMMENT '삭제 여부',
    `user_name_type`    INT             NOT NULL    COMMENT '참여자 실명/닉네임 여부',
    `vote_create_auth`  INT             NOT NULL    COMMENT '투표 생성권한',
    PRIMARY KEY (sid)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE sp_room COMMENT '방';

ALTER TABLE sp_room
    ADD CONSTRAINT FK_sp_room_master_sp_user_sid FOREIGN KEY (master)
        REFERENCES sp_user (sid) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_room
    ADD UNIQUE UK_sp_room_url_name (url_name);

*/
class Room_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
        insert_no_deadline
        room 생성 - deadline이 있는 경우.
        param: 방(array)
    */
    function insert_room($room){
        $sql = "INSERT INTO sp_room (`url_name`,`master`,`title`,`user_name_type`,`vote_create_auth`) VALUES (?,?,?,?,?)";

        // $query is TRUE or FALSE
        $query = $this->db->query($sql, array($room['url_name'],$room['master'],$room['title'], $room['user_name_type'], $room['vote_create_auth']));

        if($query)
            return $query;
        else
            return false;
            // return $this->db->error();
            // array(2) { ["code"]=> int(1062) ["message"]=> string(62) "Duplicate entry 'id@example.com' for key 'UK_sp_user_email'" }
    }

    /*
        duplicate
        room_id 만들 때, room_id가 이미 존재하는지 판별하는 함수.
        param: 방 아이디 (네글자)
        return:중복되는 room_id 가 없으면 true 반환, 아니면 false를 반환한다.
    */
    function duplicate($room_id){
        $sql  = "SELECT room_id";
        $sql .= " FROM sp_room";
        $sql .= " WHERE room_id = ?";

        $result = $this->db->query($sql, array($room_id))->row();
        if(!empty($result)) return false;
        else return true;
    }

    /*
        find_sid
        room_id를 이용해서 sp_room의 sid를 반환한다.
        param: 방 아이디 (네글자)
        return: 방 시퀀스 아이디
    */
    function find_sid($master){
        $sql = "SELECT * FROM sp_room  WHERE master = ? ORDER BY sid DESC limit 1";
        $result = $this->db->query($sql, array($master))->row_array();
        return $result['sid'];
    }

    /*
        insert_sp_room_user
        room_sid와 방장의 sid를 sp_room_user에 추가한다.
        param: 방 시퀀스 아이디, 방장
    */
    function insert_sp_room_user($room_sid, $user, $auth) {
        $sql = "INSERT INTO sp_room_user (`room_id`,`user_id`,`auth`) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($room_sid,$user,$auth));
    }

    /*
        select_sp_room_user_by_room_and_user_id
        방 아이디와 유저 아이디로 해당 방에 포함된 사람을 반환한다.
        param: 방 시퀀스 아이디, 유저 아이디
    */
    function select_sp_room_user_by_room_and_user_id($room_id, $user_id){
        $sql = "SELECT * FROM sp_room_user  WHERE room_id = ? AND user_id=?";
        $query = $this->db->query($sql, array($room_id,$user_id));

        if($query == false)
            return null;
        else
            return $query->row_array();
    }

    /*
        get_room
        room_sid를 이용해서 sp_room의 모든 정보를 반환한다.
        param: 방 시퀀스 아이디
        return: 방 정보 array
    */
    function get_room($room_sid){
        $sql = "SELECT * FROM sp_room WHERE sid = ? AND deleted=0";
        $result = $this->db->query($sql, array($room_sid))->row_array();
        return $result;
    }
    /*
        speacker_room_list
        $user_id가 master로 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function speacker_room_list($user_id){
        $sql = "SELECT sp_room.sid as sid, sp_room.url_name as url_name, sp_user.nickname as master_nickname, sp_room.title as title, ";
        $sql .= "sp_room.part_num as part_num ";
        $sql .= "FROM sp_room INNER JOIN sp_user ON sp_room.master = sp_user.sid ";
        $sql .= "WHERE sp_room.master=? AND sp_room.deleted=0 ORDER BY sp_room.sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    /*
        audience_room_list
        $user_id에 해당하는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function audience_room_list($user_id) {
        $sql = "SELECT sp_room.sid as sid, sp_room.url_name as url_name, sp_room.title as title, ";
        $sql .= "sp_room.part_num as part_num ";
        $sql .= "FROM sp_room INNER JOIN sp_room_user ON sp_room.sid = sp_room_user.room_id ";
        $sql .= "WHERE sp_room_user.user_id=? AND sp_room.deleted=0 ORDER BY sp_room.sid DESC";

        $result = $this->db->query($sql, array($user_id))->result_array();
        return $result;
    }
}
?>
