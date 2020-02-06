<?php
/*
-- sp_vote Table Create SQL
CREATE TABLE sp_vote
(
    `id`          VARCHAR(6)     NOT NULL    COMMENT '투표 아이디 (여섯글자)', 
    `room_id`     VARCHAR(4)     NOT NULL    COMMENT '방 아이디 (네글자)', 
    `title`       VARCHAR(45)    NOT NULL    COMMENT '투표 제목', 
    `start_date`  TIMESTAMP      NOT NULL    COMMENT '시작일', 
    `end_date`    TIMESTAMP      NOT NULL    COMMENT '종료일', 
    `type`        INT            NOT NULL    COMMENT '투표 유형', 
    `deleted`     TINYINT(1)     NOT NULL    DEFAULT 0 COMMENT '삭제 여부', 
    PRIMARY KEY (id)
);

ALTER TABLE sp_vote COMMENT '투표';

ALTER TABLE sp_vote
    ADD CONSTRAINT FK_sp_vote_room_id_sp_room_id FOREIGN KEY (room_id)
        REFERENCES sp_room (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Vote_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }

?>