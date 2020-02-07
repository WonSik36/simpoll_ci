<?php
/*
-- sp_like Table Create SQL
CREATE TABLE sp_like
(
    `vote_id`  VARCHAR(6)    NOT NULL    COMMENT '투표 아이디 (여섯글자)', 
    `user_id`  INT           NOT NULL    COMMENT '사용자 아이디', 
    `type`     INT           NOT NULL    COMMENT '좋아요 유형', 
    PRIMARY KEY (vote_id, user_id)
);

ALTER TABLE sp_like COMMENT '좋아요';

ALTER TABLE sp_like
    ADD CONSTRAINT FK_sp_like_vote_id_sp_vote_id FOREIGN KEY (vote_id)
        REFERENCES sp_vote (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_like
    ADD CONSTRAINT FK_sp_like_user_id_sp_user_id FOREIGN KEY (user_id)
        REFERENCES sp_user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Like_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }
}
?>