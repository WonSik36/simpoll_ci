<?php
/*
-- sp_user Table Create SQL
CREATE TABLE sp_user
(
    `id`       INT            NOT NULL    AUTO_INCREMENT COMMENT '사용자 아이디', 
    `email`    VARCHAR(45)    NOT NULL    COMMENT '사용자 이메일', 
    `name`     VARCHAR(45)    NOT NULL    COMMENT '사용자 이름', 
    `password` VARCHAR(255)   NOT NULL    COMMENT '사용자 비밀번호',    -- need to be reconsider
    `deleted`  TINYINT(1)     NOT NULL    DEFAULT 0 COMMENT '삭제 여부', 
    PRIMARY KEY (id)
);

ALTER TABLE sp_user COMMENT '사용자';

ALTER TABLE sp_user 
    ADD UNIQUE UK_sp_user_email (email);
*/
class User_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }

    /*
        insert
        param: 배열(사용자)
    */
    function insert($user){
        $sql = "INSERT INTO sp_user (`email`,`name`,`password`) VALUES (?,?,?)";
        $this->db->query($sql, array($user['email'], $user['name'], $user['password']));
    }

    /*
        selectRoomUserList
        해당 방에 포함되어있는 유저 반환
        param: 방 아이디
        return: 유저 배열
    */
    function selectRoomUserList($room_id){
        $sql  = "SELECT sp_room_user.room_id, sp_room_user.user_id, sp_user.email, sp_user.name"
        $sql .= " FROM sp_room_user INNER JOIN sp_user ON sp_room_user.user_id = sp_user.id"
        $sql .= " WHERE sp_room_user.room_id = ?";
        
        return $this->db->query($sql, array($room_id))->result_array();
    }


    /*
        login
        param: 유저 email, password
        return: 유저 object
    */
    function login($email, $pw){
        $sql = "SELECT * FROM sp_user WHERE email=? AND password=?";
        return $this->db->query($sql,array($email,$pw))->row();
    }
    
    
    /*
        update
        param: 배열(사용자)
    */
    function update($user){
        $sql = "UPDATE sp_user SET email = ?, name = ?, password =? WHERE id=?";
        $this->db->query($sql, array($user['email'],$user['name'],$user['password'],$user['id']));
    }

    /*
        delete
        사용자 삭제(update)
        param: 사용자 id
    */
    function delete($user_id){
        $sql = "UPDATE sp_user SET deleted=1 WHERE id=?";
        $this->db->query($sql, array($user_id));
    }
}
?>