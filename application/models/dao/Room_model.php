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
    `part_num`          INT            NOT NULL    DEFAULT 1 COMMENT '참여 인원', 
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

    /*
        speacker_room_list
        $user_id가 master로 있는 방 목록 반환
        param: 유저 시퀀스 아이디
        return: 방(array) array
    */
    function speacker_room_list($user_id){
        $sql = "SELECT sp_room.sid as sid, sp_room.room_id as room_id, sp_user.nickname as master_nickname, sp_room.title as title, ";
        $sql .= "sp_room.deadline_check as deadline_check, DATE_FORMAT(sp_room.deadline, '%Y-%m-%d') as deadline, sp_room.part_num as part_num ";
        $sql .= "FROM sp_room INNER JOIN sp_user ON sp_room.master = sp_user.sid ";
        $sql .= "WHERE sp_room.master=? AND sp_room.deleted=0 ORDER BY sp_room.sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }
}
?>