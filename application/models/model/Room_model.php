<?php
/*
-- sp_room Table Create SQL
CREATE TABLE sp_room
(
    `id`          VARCHAR(4)     NOT NULL    COMMENT '방 아이디 (네글자)', 
    `master`      INT            NOT NULL    COMMENT '방장', 
    `title`       VARCHAR(45)    NOT NULL    COMMENT '방 제목', 
    `start_date`  TIMESTAMP      NOT NULL    COMMENT '시작일', 
    `end_date`    TIMESTAMP      NOT NULL    COMMENT '종료일', 
    `deleted`     TINYINT(1)     NOT NULL    DEFAULT 0 COMMENT '삭제 여부', 
    PRIMARY KEY (id)
);

ALTER TABLE sp_room COMMENT '방';

ALTER TABLE sp_room
    ADD CONSTRAINT FK_sp_room_master_sp_user_id FOREIGN KEY (master)
        REFERENCES sp_user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Room_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }

?>