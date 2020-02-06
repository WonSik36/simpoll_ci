<?php
/*
-- sp_room_user Table Create SQL
CREATE TABLE sp_room_user
(
    `room_id`  VARCHAR(4)    NOT NULL    COMMENT '방 아이디 (네글자)', 
    `user_id`  INT           NOT NULL    COMMENT '사용자 아이디', 
    PRIMARY KEY (room_id, user_id)
);

ALTER TABLE sp_room_user COMMENT '방:사용자 매칭 테이블';

ALTER TABLE sp_room_user
    ADD CONSTRAINT FK_sp_room_user_user_id_sp_user_id FOREIGN KEY (user_id)
        REFERENCES sp_user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_room_user
    ADD CONSTRAINT FK_sp_room_user_room_id_sp_room_id FOREIGN KEY (room_id)
        REFERENCES sp_room (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Room_User_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }

?>