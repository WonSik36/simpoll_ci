<?php
class Question_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($quiestion) {
        $sql = "INSERT INTO sp_question (`simpoll_id`,`title`,`choice_no`, `question_type`) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($quiestion['simpoll_id'],$quiestion['title'],$quiestion['choice_no'],$quiestion['question_type']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_question WHERE sid = ? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectListBysimpollId($simpoll_id) {
        $sql = "SELECT * FROM sp_question WHERE simpoll_id = ? AND is_deleted=0 ORDER BY sid ASC";

        return $this->db->query($sql, array($simpoll_id))->result_array();
    }

    function updateOne($quiestion){
        $sql = "UPDATE sp_question SET simpoll_id=?,title=?,choice_no=?, question_type=? ";
        $sql .= "WHERE sid=?";
        $query = $this->db->query($sql, array($quiestion['simpoll_id'],$quiestion['title'],$quiestion['choice_no'],$quiestion['question_type'],$quiestion['sid']));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_question SET is_deleted=1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_question";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_question";
        return $this->db->query($sql);
    }

    function insertOneForTest($quiestion) {
        $sql = "INSERT INTO sp_question (`sid`,`simpoll_id`,`title`,`choice_no`, `question_type`) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($quiestion['sid'],$quiestion['simpoll_id'],$quiestion['title'],$quiestion['choice_no'],$quiestion['question_type']));

        return $query;
    }
}
?>
