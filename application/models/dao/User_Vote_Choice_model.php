<?php
/*
-- sp_user_vote_choice Table Create SQL
CREATE TABLE sp_user_vote_choice
(
    `user_id`    INT           NOT NULL    COMMENT '사용자 아이디', 
    `vote_id`    VARCHAR(6)    NOT NULL    COMMENT '투표 아이디 (여섯글자)', 
    `choice_id`  INT           NOT NULL    COMMENT '선택지 아이디', 
    PRIMARY KEY (user_id, vote_id, choice_id)
);

ALTER TABLE sp_user_vote_choice COMMENT '사용자:선택지 매칭 테이블';

ALTER TABLE sp_user_vote_choice
    ADD CONSTRAINT FK_sp_user_vote_choice_user_id_sp_user_id FOREIGN KEY (user_id)
        REFERENCES sp_user (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_user_vote_choice
    ADD CONSTRAINT FK_sp_user_vote_choice_vote_id_sp_vote_id FOREIGN KEY (vote_id)
        REFERENCES sp_vote (id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sp_user_vote_choice
    ADD CONSTRAINT FK_sp_user_vote_choice_choice_id_sp_choice_id FOREIGN KEY (choice_id)
        REFERENCES sp_choice (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class User_Vote_Choice_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }
}
?>