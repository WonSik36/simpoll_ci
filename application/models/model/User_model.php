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
}
?>