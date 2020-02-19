<?php
/*
-- sp_vote Table Create SQL
CREATE TABLE sp_vote
(
    `id`          VARCHAR(6)     NOT NULL    COMMENT '투표 아이디 (여섯글자)',
    `room_id`     VARCHAR(4)     NOT NULL    COMMENT '방 아이디 (네글자)',
    `user_id`     INT            NOT NULL    COMMENT '사용자 아이디',
    `title`       VARCHAR(45)    NOT NULL    COMMENT '투표 제목',
    `start_date`  TIMESTAMP      NOT NULL    COMMENT '시작일',
    `end_date`    TIMESTAMP      NOT NULL    COMMENT '종료일',
    `type`        INT            NOT NULL    COMMENT '투표 유형',
    `deleted`     TINYINT(1)     NOT NULL    DEFAULT 0 COMMENT '삭제 여부',
    PRIMARY KEY (id)
);

ALTER TABLE sp_vote COMMENT '투표';

ALTER TABLE sp_vote
    ADD CONSTRAINT FK_sp_vote_room_id_sp_room_id FOREIGN KEY (room_id)
        REFERENCES sp_room (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_vote
    ADD CONSTRAINT FK_sp_vote_user_id_sp_user_id FOREIGN KEY (user_id)
        REFERENCES sp_user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Vote_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /*
        get_list
        room_sid를 이용해서 sp_vote의 모든 정보를 반환한다.
        param: 방 시퀀스 아이디
        return: 투표 정보 array
    */
    function get_list($room_sid) {
        $sql = "SELECT * FROM sp_vote WHERE room_id = ?";
        $result = $this->db->query($sql, array($room_sid))->result_array();
        return $result;
    }

    function get_contents($sid) {
        $sql = "SELECT * FROM sp_vote WHERE sid = ?";
        $result = $this->db->query($sql, array($sid))->row_array();
        return $result['contents'];
    }

    function get_contents_number($sid) {
        $sql = "SELECT contents_number as cn, COUNT(Contents_number) as count ";
        $sql .="FROM sp_user_vote_choice ";
        $sql .="WHERE vote_id = ? GROUP BY contents_number";
        $result = $this->db->query($sql, array($sid))->result_array();
        return $result;
    }

    function insert_vote($vote) {
        $sql = "INSERT INTO sp_vote (`title`,`url_name`,`contents`, `comment_check`,`anonymous_check`,`vote_type`,`part_auth`,`user_id`,`room_id`,`deadline`) VALUES (?,?,?,?,?,?,?,?,?,?)";

        // $query is TRUE or FALSE
        $query = $this->db->query($sql, array($vote['title'],$vote['url_name'],$vote['contents'],$vote['comment_check'],$vote['anonymous_check'],$vote['vote_type'],$vote['part_auth'],$vote['user_id'],$vote['room_id'],$vote['deadline']));

        if($query)
            return $query;
        else
            return false;
    }

    function selectVoteByUrl($url) {
        $sql = "SELECT * FROM sp_vote WHERE url_name=? AND deleted=0";

        $query = $this->db->query($sql, array($url));

        if($query == false)
            return null;
        else
            return $query->row_array();
    }

    function get_part_num($sid) {
        $sql = "SELECT COUNT(Contents_number) as count ";
        $sql .="FROM sp_user_vote_choice ";
        $sql .="WHERE vote_id = ?";
        $result = $this->db->query($sql, array($sid))->row_array();
        return $result['count'];
    }

    function get_title_deadline($sid) {
        $sql = "SELECT * FROM sp_vote WHERE sid = ?";
        $result = $this->db->query($sql, array($sid))->row_array();
        return $result;
    }

    /*
        get_choice_by_vote_id_and_user_id
        parameter: 투표 아이디(sid)와 유저 아이디(sid)
        return: sp_user_vote_choice의 배열 (값이 하나여도 배열로 리턴)
                NULL (결과 값이 없는 경우)
    */
    function get_choice_by_vote_id_and_user_id($vote_id, $user_id){
        $sql = "SELECT * FROM sp_user_vote_choice WHERE vote_id=? AND user_id=?";
        $query = $this->db->query($sql, array($vote_id, $user_id));
        
        if($query == false)
            return NULL;
        else
            return $query->result_array();
    }
}
?>
