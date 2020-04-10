<?php
class Option_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($option){
        $sql = "INSERT INTO sp_option (name,user_id,user_nickname,question_id) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($option['name'],$option['user_id'],$option['user_nickname'],$option['question_id']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_option WHERE sid=?";

        return $this->db->query($sql, array($sid))->row_array();
    }


    function selectOneByquiestionIdAndUserId($quiestion_id, $user_id){
        $sql = "SELECT * FROM sp_option WHERE quiestion_id=? AND user_id=? AND is_deleted=0";

        return $this->db->query($sql, array($quiestion_id, $user_id))->row_array();
    }

    function selectListByquiestionId($quiestion_id){
        $sql = "SELECT * FROM sp_option WHERE quiestion_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($quiestion_id))->result_array();
    }


    function selectListByUserId($user_id){
        $sql = "SELECT * FROM sp_option WHERE user_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    function updateOne($option){
        $sql = "UPDATE sp_option SET user_id=?, user_nickname=?, question_id=? WHERE sid=?";
        $query = $this->db->query($sql, array($option['user_id'],$option['user_nickname'],$option['question_id'],$option['sid']));

        return $query;
    }
    
    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_option";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_option";
        return $this->db->query($sql);
    }

    function insertOneForTest($option){
        $sql = "INSERT INTO sp_option (sid,name,user_id,user_nickname,question_id) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($option['sid'],$option['name'],$option['user_id'],$option['user_nickname'],$option['question_id']));

        return $query;
    }
}
?>
