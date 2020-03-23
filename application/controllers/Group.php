<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Group extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/group_service');
    }

    function restWithParam($param){
        $method = $this->input->method(TRUE);

        if($method == "GET")
            $this->_getGroup($param);
        else if($method == "DELETE"){
            $this->_deleteGroup($param);
        }
    }

    // URL:
    // GET /api/room/{roomId}/vote?userId=?     -> audience
    // GET /api/room/{roomId}/vote              -> speacker
    function getVoteList($room_id){
        $user_id = $this->input->get('userId');
        
        $list = null;

        // speacker
        if(empty($user_id)){
            $list = $this->group_service->getGroupListWithVoteListByRoomId($room_id);

        // audience 
        }else{
            $list = $this->group_service->getGroupListWithVotedListByRoomIdAndUserId($room_id, $user_id);
        }

        $this->response_json($list,true,null);
    }

    // URL:
    // GET /api/group/{groupId}?type=id
    // GET /api/group/{groupUrl}?type=url
    function _getGroup($idOrUrl){
        $type = $this->input->get('type');
        
        $group = null;
        if($type == "id"){
            $group = $this->group_service->getGroupById($idOrUrl);
        }else if($type == "url"){
            $group = $this->group_service->getGroupByUrl($idOrUrl);
        }else{
            $this->response_json(null,false,"Wrong Type");
        }

        if(empty($group)){
            $this->response_json(null,false,"No Group for ".$idOrUrl);
        }else{
            $this->response_json($group,true,null);
        }
    }

    // URL:
    // DELETE /api/group/{groupId}
    function _deleteGroup($group_id){
        $bool = $this->group_service->deleteGroup($group_id);

        if($bool)
            $this->response_json(null, true, "Delete Group Success!");
        else
            $this->response_json(null, false, "Delete Group Failed...");
    }

    /* need to fix: Transaction */
    /* need to fix: Deal with multiple votes */
    // URL:
    // POST /api/group
    function makeGroup(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        $group = $this->_makeGroup($jsonArray);

        $group_id = $this->group_service->register($group);

        $vote = array(
            'group_id'=>$group_id,
            'title'=>$jsonArray['vote_title'],
            'choices'=>$jsonArray['choices'],
            'vote_type'=>$jsonArray['vote_type']
        );
        $this->load->model('service/vote_service');
        $bool = $this->vote_service->register($vote);
        
        if($bool){
            $this->response_json(null,true,"Make Simpoll Success!");
        }else{
            $this->response_json(null,true,"Make Simpoll Failed...");
        }
    }
    
    /* need to fix: input format */
    function _makeGroup($jsonArray){
        if(empty($jsonArray['room_id']) || empty($jsonArray['vote_title']) || empty($jsonArray['user_id']) || empty($jsonArray['user_nickname']) 
                || empty($jsonArray['deadline']) || empty($jsonArray['choices']))
            $this->response_json(null, false, "Not right format");

        $url_name = null;
        if(!empty($jsonArray['url_name']))
            $url_name = $jsonArray['url_name'];
        $group_title = null;
        if(!empty($jsonArray['group_title']))
            $group_title = $jsonArray['group_title'];
        $is_comment_enable = 1;
        if(empty($jsonArray['is_comment_enable']))
            $is_comment_enable = 0;
        $is_anonymous = 1;
        if(empty($jsonArray['is_anonymous']))
            $is_anonymous = 0;
        
        $group = array(
            'room_id'=>$jsonArray['room_id'],
            'title'=>$group_title,
            'url_name'=>$url_name,
            'user_id'=>$jsonArray['user_id'],
            'user_nickname'=>$jsonArray['user_nickname'],
            'deadline'=>$jsonArray['deadline'],
            'is_comment_enable'=>$is_comment_enable,
            'is_anonymous'=>$is_anonymous,
            'part_auth'=>$jsonArray['part_auth']
        );

        return $group;
    }

    function response_json($data, $isSucceed, $message){
        $res = array();

        // success
        if($isSucceed){
            $res['result'] = 'success';
            $res['data'] = $data;
            $res['message'] = $message;

        // fail
        }else{
            $res['result'] = 'fail';
            $res['message'] = $message;
        }

        echo json_encode($res); 
        exit;
    }
}
?>
