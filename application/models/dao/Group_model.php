<?php
class Group_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($group){
        $sql = "INSERT INTO sp_group (`room_id`,`title`,`url_name`,`user_id`,`user_nickname`,`deadline`,`is_comment_enable`, `is_anonymous`,`part_auth`) ";
        $sql .= "VALUES (?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($group['room_id'],$group['title'],$group['url_name'],$group['user_id'], 
                $group['user_nickname'], $group['deadline'], $group['is_comment_enable'], $group['is_anonymous'], $group['part_auth']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_group WHERE sid=? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectOneByUrl($url) {
        $sql = "SELECT * FROM sp_group WHERE url_name=? AND is_deleted=0";

        return $this->db->query($sql, array($url))->row_array();
    }

    function selectListByRoomId($room_id){
        $sql  = "SELECT * FROM sp_group WHERE room_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($room_id))->result_array();
    }

    function selectListByUserId($user_id){
        $sql  = "SELECT * FROM sp_group WHERE user_id=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    function selectListWithVoteByRoomId($room_id){
        $sql = "SELECT sp_group.sid as group_id, sp_group.room_id as room_id, sp_group.title as group_title, sp_group.url_name as url_name, ";
        $sql .= "sp_group.user_id as user_id, sp_group.user_nickname as user_nickname, sp_group.deadline as deadline, ";
        $sql .= "sp_group.is_comment_enable as is_comment_enable, sp_group.is_anonymous as is_anonymous, sp_group.part_auth as part_auth, ";
        $sql .= "sp_vote.sid as vote_id, sp_vote.title as vote_title, sp_vote.choices as choices, sp_vote.vote_type as vote_type ";
        $sql .= "FROM sp_group INNER JOIN sp_vote ON sp_group.sid = sp_vote.group_id ";
        $sql .= "WHERE sp_group.room_id=? AND sp_group.is_deleted=0 AND sp_vote.is_deleted=0 ";
        $sql .= "ORDER BY sp_vote.sid DESC";

        return $this->db->query($sql, array($room_id))->result_array();
    }

    function selectListWithVoteAndChoiceByRoomIdAndUserId($room_id, $user_id){
        $sql = "SELECT sp_group.sid as group_id, sp_group.room_id as room_id, sp_group.title as group_title, sp_group.url_name as url_name, ";
        $sql .= "sp_group.user_id as user_id, sp_group.user_nickname as user_nickname, sp_group.deadline as deadline, ";
        $sql .= "sp_group.is_comment_enable as is_comment_enable, sp_group.is_anonymous as is_anonymous, sp_group.part_auth as part_auth, ";
        $sql .= "sp_vote.sid as vote_id, sp_vote.title as vote_title, sp_vote.choices as choices, sp_vote.vote_type as vote_type ";
        $sql .= "FROM sp_group INNER JOIN sp_vote ON sp_group.sid = sp_vote.group_id INNER JOIN sp_choice ON sp_vote.sid=sp_choice.vote_id ";
        $sql .= "WHERE sp_group.room_id=? AND sp_choice.user_id=? ";
        $sql .= "AND sp_group.is_deleted=0 AND sp_vote.is_deleted=0 AND sp_choice.is_deleted=0 ";
        $sql .= "ORDER BY sp_vote.sid DESC";

        return $this->db->query($sql, array($room_id,$user_id))->result_array();
    }

    function updateOne($group){
        $sql = "UPDATE sp_group SET room_id=?,title=?,url_name=?,user_id=?,user_nickname=?,deadline=?,is_comment_enable=?, is_anonymous=?, part_auth=? ";
        $sql .= "WHERE sid=?";
        $query = $this->db->query($sql, array($group['room_id'],$group['title'],$group['url_name'],$group['user_id'], $group['user_nickname'], 
                $group['deadline'], $group['is_comment_enable'], $group['is_anonymous'], $group['part_auth'], $group['sid']));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_group SET is_deleted=1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }    

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_group";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_group";
        return $this->db->query($sql);
    }

    function insertOneForTest($group){
        $sql = "INSERT INTO sp_group (`sid`,`room_id`,`title`,`url_name`,`user_id`,`user_nickname`,`deadline`,`is_comment_enable`, `is_anonymous`,`part_auth`) ";
        $sql .= "VALUES (?,?,?,?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($group['sid'],$group['room_id'],$group['title'],$group['url_name'],$group['user_id'], 
                $group['user_nickname'], $group['deadline'], $group['is_comment_enable'], $group['is_anonymous'], $group['part_auth']));

        return $query;
    }
}
?>
