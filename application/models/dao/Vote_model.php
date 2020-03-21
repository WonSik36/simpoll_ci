<?php
class Vote_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($vote) {
        $sql = "INSERT INTO sp_vote (`group_id`,`title`,`choices`, `vote_type`) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($vote['group_id'],$vote['title'],$vote['choices'],$vote['vote_type']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_vote WHERE sid = ? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectListByGroupId($group_id) {
        $sql = "SELECT * FROM sp_vote WHERE group_id = ? AND is_deleted=0 ORDER BY sid ASC";
        
        return $this->db->query($sql, array($group_id))->result_array();
    }

    function updateOne($vote){
        $sql = "UPDATE sp_vote SET group_id=?,title=?,choices=?, vote_type=? ";
        $sql .= "WHERE sid=?";
        $query = $this->db->query($sql, array($vote['group_id'],$vote['title'],$vote['choices'],$vote['vote_type'],$vote['sid']));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_vote SET is_deleted=1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    } 

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_vote";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_vote";
        return $this->db->query($sql);
    }

    function insertOneForTest($vote) {
        $sql = "INSERT INTO sp_vote (`sid`,`group_id`,`title`,`choices`, `vote_type`) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($vote['sid'],$vote['group_id'],$vote['title'],$vote['choices'],$vote['vote_type']));

        return $query;
    }
}
?>
