<?php

class Group_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/group_model');
    }

    function register($group){
        $this->group_model->insertOne($group);
        $group = $this->group_model->selectListByUserId($group['user_id'])[0];

        return $group['sid'];
    }

    function getGroupById($sid){
        return $this->group_model->selectOneById($sid);
    }

    // 유저가 투표한 vote는 voted: true,
    // 투표하지 않은 voted는 voted: false
    function getGroupListWithVotedListByRoomIdAndUserId($room_id,$user_id){
        $list = $this->group_model->selectListWithVoteByRoomId($room_id);
        $votedList = $this->group_model->selectListWithVoteAndChoiceByRoomIdAndUserId($room_id,$user_id);
        
        if(empty($votedList)){
            for($i=0;$i<count($list);$i++){
                $list[$i]['voted'] = false;
            }
        }else{
            for($i=0,$j=0;$i<count($list);$i++){
                if($list[$i]['vote_id'] == $votedList[$j]['vote_id']){
                    $list[$i]['voted'] = true;
                    $j++;
                }else{
                    $list[$i]['voted'] = false;
                }
            }
        }

        return $list;
    }

    function getGroupListWithVoteListByRoomId($room_id){
        return $this->group_model->selectListWithVoteByRoomId($room_id);
    }

    /*
        getGroupByUrl
        입력받은 URL에 매칭되는 방을 찾는다
        param: 방 url
        return: 성공시 방(array) 실패시 NULL
    */
    function getGroupByUrl($url){
        return $this->group_model->selectOneByUrl($url);
    }

    function updateGroup($group){
        return $this->group_model->updateOne($group);
    }

    function deleteGroup($sid){
        return $this->group_model->deleteOne($sid);
    }
}
?>
