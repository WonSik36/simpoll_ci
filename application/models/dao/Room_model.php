<?php
class Room_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function insertOne($room){
        $sql = "INSERT INTO sp_room (`url_name`,`master`,`master_nickname`,`title`,`user_name_type`,`vote_create_auth`) VALUES (?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($room['url_name'],$room['master'],$room['master_nickname'],$room['title'], $room['user_name_type'], $room['vote_create_auth']));

        return $query;
    }

    function selectOneById($sid){
        $sql = "SELECT * FROM sp_room WHERE sid=? AND is_deleted=0";

        return $this->db->query($sql, array($sid))->row_array();
    }

    function selectOneByUrl($url) {
        $sql = "SELECT * FROM sp_room WHERE url_name=? AND is_deleted=0";

        return $this->db->query($sql, array($url))->row_array();
    }

    /*
        select_sp_room_user_by_room_and_user_id
        방 아이디와 유저 아이디로 해당 방에 포함된 사람을 반환한다.
        param: 방 시퀀스 아이디, 유저 아이디
    */
    function selectOneByRoomIdAndUserId($room_id, $user_id){
        $sql = "SELECT * FROM sp_room_user  WHERE room_id = ? AND user_id=? AND is_deleted=0";

        return $this->db->query($sql, array($room_id,$user_id))->row_array();
    }

    // 본인이 방장인 방 리스트 검색
    function selectListByMaster($user_id){
        $sql  = "SELECT * FROM sp_room WHERE master=? AND is_deleted=0 ORDER BY sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    // 본인이 포함된 방 검색
    function selectListByUserId($user_id){
        $sql = "SELECT sp_room.sid as sid, sp_room.url_name as url_name, sp_room.title as title, ";
        $sql .= "sp_room.master as master, sp_room.master_nickname as master_nickname, ";
        $sql .= "sp_room.part_num as part_num, sp_room.status as status, ";
        $sql .= "sp_room.vote_create_auth as vote_create_auth, sp_room.user_name_type as user_name_type, ";
        $sql .= "sp_room.create_date as create_date, sp_room.edit_date as edit_date ";
        $sql .= "FROM sp_room INNER JOIN sp_room_user ON sp_room.sid = sp_room_user.room_id ";
        $sql .= "WHERE sp_room_user.user_id=? AND sp_room.is_deleted=0 ORDER BY sp_room.sid DESC";

        return $this->db->query($sql, array($user_id))->result_array();
    }

    function updateOne($room){
        $sql = "UPDATE sp_room SET url_name=?,master=?,master_nickname=?,title=?,user_name_type=?,vote_create_auth=? ";
        $sql .= "WHERE sid=?";
        $query = $this->db->query($sql, array($room['url_name'],$room['master'],$room['master_nickname'],$room['title'],$room['user_name_type'],$room['vote_create_auth'],$room['sid']));

        return $query;
    }

    function addPartNum($sid){
        $sql = "UPDATE sp_room SET part_num = part_num+1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }

    function deleteOne($sid){
        $sql = "UPDATE sp_room SET is_deleted=1 WHERE sid=?";
        $query = $this->db->query($sql, array($sid));

        return $query;
    }    

    /*
        insert_sp_room_user
        room_sid와 방장의 sid를 sp_room_user에 추가한다.
        param: 방 시퀀스 아이디, 유저 아이디, 권한(방장:1, 일반:2)
        return: true or false
    */
    function insertUser2Room($room_id, $user_id, $auth) {
        $sql = "INSERT INTO sp_room_user (`room_id`,`user_id`,`auth`) VALUES (?,?,?)";
        $query = $this->db->query($sql, array($room_id,$user_id,$auth));

        return $query;
    }

    function count(){
        $sql = "SELECT COUNT(*) as num FROM sp_room";
        $result = $this->db->query($sql)->row_array();
        return $result['num'];
    }

    function deleteAll(){
        $sql = "DELETE FROM sp_room";
        return $this->db->query($sql);
    }

    function insertOneForTest($room){
        $sql = "INSERT INTO sp_room (`sid`,`url_name`,`master`,`master_nickname`,`title`,`user_name_type`,`vote_create_auth`) VALUES (?,?,?,?,?,?,?)";
        $query = $this->db->query($sql, array($room['sid'],$room['url_name'],$room['master'],$room['master_nickname'],$room['title'], $room['user_name_type'], $room['vote_create_auth']));

        return $query;
    }
}
?>
