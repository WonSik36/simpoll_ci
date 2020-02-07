<?php
/*
-- sp_choice Table Create SQL
CREATE TABLE sp_choice
(
    `id`        INT            NOT NULL    AUTO_INCREMENT COMMENT '선택지 아이디', 
    `vote_id`   VARCHAR(6)     NOT NULL    COMMENT '투표 아이디 (여섯글자)', 
    `contents`  VARCHAR(45)    NOT NULL    COMMENT '내용', 
    `deleted`   TINYINT(1)     NOT NULL    DEFAULT 0 COMMENT '삭제 여부', 
    PRIMARY KEY (id)
);

ALTER TABLE sp_choice COMMENT '선택지';

ALTER TABLE sp_choice
    ADD CONSTRAINT FK_sp_choice_vote_id_sp_vote_id FOREIGN KEY (vote_id)
        REFERENCES sp_vote (id) ON DELETE RESTRICT ON UPDATE RESTRICT;
*/
class Choice_model extends CI_Model {
    function __construct()
    {       
        parent::__construct();
    }

    /* 
        insertList
        등록된 선택지 목록(array) 삽입
        param: 선택지 array
        $choice_list = array(
            array(
                'vote_id' => '#ABCDEF' ,
                'contents' => 'choice 1'
            ),
            array(
                'vote_id' => '#ABCDEF' ,
                'contents' => 'choice 2'
            )
        );
    */
    function insertList($choice_list){
        $this->db->insert_batch('sp_choice',$choice_list);
    }

    /*  
        selectList
        특정 투표(vote_id)에 포함된 선택지 목록중 삭제되지 않은 것을 반환한다
        param: 투표 아이디
        return: 선택지 array
        $choice_list = array(
            array(
                'id' => '1' ,
                'vote_id' => '#ABCDEF' ,
                'contents' => 'choice 1',
                'deleted' => '0'
            ),
            array(
                'id' => '2' ,
                'vote_id' => '#ABCDEF' ,
                'contents' => 'choice 2',
                'deleted' => '0'
            )
        );
    */
    function selectList($vote_id){
        $sql = "SELECT * FROM sp_choice WHERE vote_id=? AND deleted=0 ORDER BY ASC";
        return $this->db->query($sql, array($vote_id))->result_array();
    }

    /*
        update
        특정 선택지의 내용(contents)을 업데이트 한다
        param: 선택지 array
        $choice_list = array(
            array(
                'id' => '1' ,
                'vote_id' => '#ABCDEF' ,
                'contents' => 'choice 1'
            ),
            array(
                'id' => '2' ,
                'vote_id' => '#ABCDEF' ,
                'contents' => 'choice 2'
            )
        );
    */
    function updateList($choice_list){
        $this->db->update_batch('sp_choice',$choice_list, 'id');
    }

    /* 
        delete
        특정 선택지를 삭제한다.(update)
        param: 선택지 아이디
    */
    function delete($id){
        $sql = "UPDATE sp_choice SET deleted=1 WHERE id=?";
        $this->db->query($sql, $id);
    }
?>