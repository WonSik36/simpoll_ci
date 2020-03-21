<?php
class Choice_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
        $this->load->database();
    }

    function insertOne($choice){
        $sql = "INSERT INTO sp_choice (user_id, user_nickname, vote_id, choice_no) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($choice['user_id'],$choice['user_nickname'],$choice['vote_id'],$choice['choice_no']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_choice WHERE sid=? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectOneByVoteIdAndUserId($vote_id, $user_id){
        $sql = "SELECT * FROM sp_choice WHERE vote_id=? AND user_id=? AND is_deleted=0";
        
        return $this->db->query($sql, array($vote_id, $user_id))->row_array();
    }

    function selectListByVoteId($vote_id){
        $sql = "SELECT * FROM sp_choice WHERE vote_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($vote_id))->result_array();
    }

    function selectListByUserId($user_id){
        $sql = "SELECT * FROM sp_choice WHERE user_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    function updateOne($choice){
        $sql = "UPDATE sp_choice SET user_id=?, user_nickname=?, vote_id=?, choice_no=? WHERE sid=?";
        $query = $this->db->query($sql, array($choice['user_id'],$choice['user_nickname'],$choice['vote_id'],$choice['choice_no'],$choice['sid']));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_choice SET is_deleted=? WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_choice";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_choice";
        return $this->db->query($sql);
    }

    function insertOneForTest($choice){
        $sql = "INSERT INTO sp_choice (user_id, user_nickname, vote_id, choice_no, sid) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($choice['user_id'],$choice['user_nickname'],$choice['vote_id'],$choice['choice_no'],$choice['sid']));

        return $query;
    }
}
?>