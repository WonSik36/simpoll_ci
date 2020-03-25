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

    /* need to fix */
    function selectOneByVoteIdAndUserId($vote_id, $user_id){
        $sql = "SELECT * FROM sp_option WHERE vote_id=? AND user_id=? AND is_deleted=0";
        
        return $this->db->query($sql, array($vote_id, $user_id))->row_array();
    }

    /* need to fix */
    function selectListByVoteId($vote_id){
        $sql = "SELECT * FROM sp_option WHERE vote_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($vote_id))->result_array();
    }

    /* need to fix */
    function selectListByUserId($user_id){
        $sql = "SELECT * FROM sp_option WHERE user_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    /* need to fix */
    function updateOne($option){
        $sql = "UPDATE sp_option SET user_id=?, user_nickname=?, vote_id=?, option_no=? WHERE sid=?";
        $query = $this->db->query($sql, array($option['user_id'],$option['user_nickname'],$option['vote_id'],$option['option_no'],$option['sid']));

        return $query;
    }

    /* need to fix */
    function deleteOne($sid){
        $sql = "UPDATE sp_option SET is_deleted=? WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

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