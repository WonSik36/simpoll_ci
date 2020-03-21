<?php
class User_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($user){
        $sql = "INSERT INTO sp_user (`email`,`password`,`name`,`nickname`) VALUES (?,?,?,?)";
        $query = $this->db->query($sql, array($user['email'], $user['password'], $user['name'], $user['nickname']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_user WHERE sid=? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectListByRoomId($room_id){
        $sql = "SELECT sp_user.sid as sid, sp_user.email as email, sp_user.name as name, sp_user.nickname as nickname ";
        $sql .= "FROM sp_user INNER JOIN sp_room_user ON sp_user.sid = sp_room_user.user_id WHERE sp_room_user.room_id=? AND sp_user.is_deleted=0 ";
        $sql .= "ORDER BY sp_user.sid DESC";

        return $this->db->query($sql, array($room_id))->result_array();
    }


    function selectOneByEmailAndPW($email, $pw){
        $sql = "SELECT * FROM sp_user WHERE email=? AND password=? AND is_deleted=0";

        return $this->db->query($sql,array($email,$pw))->row_array();
    }

    function updateOne($user){
        $sql = "UPDATE sp_user SET email = ?, name = ?, nickname=?, password =? WHERE sid=?";
        $query = $this->db->query($sql, array($user['email'],$user['name'],$user['nickname'],$user['password'],$user['sid']));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_user SET is_deleted=1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_user";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_user";
        return $this->db->query($sql);
    }

    function insertOneForTest($user){
        $sql = "INSERT INTO sp_user (`email`,`password`,`name`,`nickname`,`sid`) VALUES (?,?,?,?,?)";
        $query = $this->db->query($sql, array($user['email'], $user['password'], $user['name'], $user['nickname'],$user['sid']));

        return $query;
    }
}
?>
