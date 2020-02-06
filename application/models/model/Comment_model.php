<?php
/*
-- sp_comment Table Create SQL
CREATE TABLE sp_comment
(
    `vote_id`   VARCHAR(6)    NOT NULL    COMMENT '투표 아이디 (여섯글자)', 
    `user_id`   INT           NOT NULL    COMMENT '사용자 아이디', 
    `contents`  TEXT          NOT NULL    COMMENT '내용', 
    `deleted`   TINYINT(1)    NOT NULL    DEFAULT 0 COMMENT '삭제 여부', 
    `mod_date`  TIMESTAMP     NOT NULL    DEFAULT CURRENT_TIMESTAMP COMMENT '수정 날짜', 
    PRIMARY KEY (vote_id, user_id)
);

ALTER TABLE sp_comment COMMENT '댓글';

ALTER TABLE sp_comment
    ADD CONSTRAINT FK_sp_comment_vote_id_sp_vote_id FOREIGN KEY (vote_id)
        REFERENCES sp_vote (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_comment
    ADD CONSTRAINT FK_sp_comment_user_id_sp_user_id FOREIGN KEY (user_id)
        REFERENCES sp_user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Comment_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }

?>