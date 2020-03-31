<?php
class Simpoll_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($simpoll){
        $sql = "INSERT INTO sp_simpoll (`room_id`,`title`,`url_name`,`user_id`,`user_nickname`,`deadline`,`is_comment_enable`, `is_anonymous`,`part_auth`) ";
        $sql .= "VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($simpoll['room_id'],$simpoll['title'],$simpoll['url_name'],$simpoll['user_id'],
                $simpoll['user_nickname'], $simpoll['deadline'], $simpoll['is_comment_enable'], $simpoll['is_anonymous'], $simpoll['part_auth']));

        return $query;
    }

    function selectSimpollById($sid){
        $sql = "SELECT sp_simpoll.sid as simpoll_id, sp_simpoll.room_id as room_id, sp_simpoll.title as simpoll_title, sp_simpoll.url_name as url_name, ";
        $sql .= "sp_simpoll.user_id as user_id, sp_simpoll.user_nickname as user_nickname, sp_simpoll.deadline as deadline, ";
        $sql .= "sp_simpoll.is_comment_enable as is_comment_enable, sp_simpoll.is_anonymous as is_anonymous, sp_simpoll.part_auth as part_auth, ";
        $sql .= "sp_question.sid as question_id, sp_question.title as question_title, sp_question.choice_no as question_choice_no, sp_question.question_type as question_type, ";
        $sql .= "sp_option.sid as option_id, sp_option.name as option_name, sp_option.user_id as option_user_id, sp_option.user_nickname as option_user_nickname, sp_option.count as option_count ";
        $sql .= "FROM sp_simpoll INNER JOIN sp_question ON sp_simpoll.sid = sp_question.simpoll_id LEFT JOIN sp_option ON sp_question.sid=sp_option.question_id ";
        $sql .= "WHERE sp_simpoll.sid=? AND sp_simpoll.is_deleted=0 AND sp_question.is_deleted=0 ";
        $sql .= "ORDER BY sp_question.sid DESC";

        return $this->db->query($sql, array($sid))->result_array();
    }
    function selectOneById($sid){
        $sql = "SELECT * FROM sp_simpoll WHERE sid=? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectOneByUrl($url) {
        $sql = "SELECT * FROM sp_simpoll WHERE url_name=? AND is_deleted=0";

        return $this->db->query($sql, array($url))->row_array();
    }

    function selectListByRoomId($room_id){
        $sql  = "SELECT * FROM sp_simpoll WHERE room_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($room_id))->result_array();
    }

    function selectListByUserId($user_id){
        $sql  = "SELECT * FROM sp_simpoll WHERE user_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }
// Simpoll과 Question과 Option을 담은 array 반환 (simpoll 전체)
    function selectListWithQuestionByRoomId($room_id){
        $sql = "SELECT sp_simpoll.sid as simpoll_id, sp_simpoll.room_id as room_id, sp_simpoll.title as simpoll_title, sp_simpoll.url_name as url_name, ";
        $sql .= "sp_simpoll.user_id as user_id, sp_simpoll.user_nickname as user_nickname, sp_simpoll.deadline as deadline, ";
        $sql .= "sp_simpoll.is_comment_enable as is_comment_enable, sp_simpoll.is_anonymous as is_anonymous, sp_simpoll.part_auth as part_auth, ";
        $sql .= "sp_question.sid as question_id, sp_question.title as question_title, sp_question.choice_no as question_choice_no, sp_question.question_type as question_type, ";
        $sql .= "sp_option.sid as option_id, sp_option.name as option_name, sp_option.user_id as option_user_id, sp_option.user_nickname as option_user_nickname, sp_option.count as option_count ";
        $sql .= "FROM sp_simpoll INNER JOIN sp_question ON sp_simpoll.sid = sp_question.simpoll_id LEFT JOIN sp_option ON sp_question.sid=sp_option.question_id ";
        $sql .= "WHERE sp_simpoll.room_id=? AND sp_simpoll.is_deleted=0 AND sp_question.is_deleted=0 ";
        $sql .= "ORDER BY sp_question.sid DESC";

        return $this->db->query($sql, array($room_id))->result_array();
    }

// Simpoll과 Question과 Option을 담은 array 반환(simpoll 하나)
    function selectListWithQuestionAndOptionBySimpollId($simpoll_id){
        $sql = "SELECT sp_simpoll.sid as simpoll_id, sp_simpoll.room_id as room_id, sp_simpoll.title as simpoll_title, sp_simpoll.url_name as url_name, ";
        $sql .= "sp_simpoll.user_id as user_id, sp_simpoll.user_nickname as user_nickname, sp_simpoll.deadline as deadline, ";
        $sql .= "sp_simpoll.is_comment_enable as is_comment_enable, sp_simpoll.is_anonymous as is_anonymous, sp_simpoll.part_auth as part_auth, ";
        $sql .= "sp_question.sid as question_id, sp_question.title as question_title, sp_question.question_type as question_type, ";
        $sql .= "sp_option.sid as option_id, sp_option.name as option_name, sp_option.user_id as option_user_id, sp_option.user_nickname as option_user_nickname, sp_option.count as option_count ";
        $sql .= "FROM sp_simpoll INNER JOIN sp_question ON sp_simpoll.sid = sp_question.simpoll_id INNER JOIN sp_option ON sp_question.sid=sp_option.question_id ";
        $sql .= "WHERE sp_question.simpoll_id=? ";
        $sql .= "AND sp_simpoll.is_deleted=0 AND sp_question.is_deleted=0 ";
        $sql .= "ORDER BY sp_question.sid DESC";

        return $this->db->query($sql, $simpoll_id)->result_array();
    }

    function updateOne($simpoll){
        $sql = "UPDATE sp_simpoll SET room_id=?,title=?,url_name=?,user_id=?,user_nickname=?,deadline=?,is_comment_enable=?, is_anonymous=?, part_auth=? ";
        $sql .= "WHERE sid=?";
        $query = $this->db->query($sql, array($simpoll['room_id'],$simpoll['title'],$simpoll['url_name'],$simpoll['user_id'], $simpoll['user_nickname'],
                $simpoll['deadline'], $simpoll['is_comment_enable'], $simpoll['is_anonymous'], $simpoll['part_auth'], $simpoll['sid']));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_simpoll SET is_deleted=1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_simpoll";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_simpoll";
        return $this->db->query($sql);
    }

    function insertOneForTest($simpoll){
        $sql = "INSERT INTO sp_simpoll (`sid`,`room_id`,`title`,`url_name`,`user_id`,`user_nickname`,`deadline`,`is_comment_enable`, `is_anonymous`,`part_auth`) ";
        $sql .= "VALUES (?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($simpoll['sid'],$simpoll['room_id'],$simpoll['title'],$simpoll['url_name'],$simpoll['user_id'],
                $simpoll['user_nickname'], $simpoll['deadline'], $simpoll['is_comment_enable'], $simpoll['is_anonymous'], $simpoll['part_auth']));

        return $query;
    }
}
?>
