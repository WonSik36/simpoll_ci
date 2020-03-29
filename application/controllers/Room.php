<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/room_service');
        $this->load->library('session');
    }

    function restWithParam($param){
        $method = $this->input->method(TRUE);

        if($method == "GET")
            $this->_getRoom($param);
        else if($method == "DELETE"){
            $this->_deleteRoom($param);
        }
    }

    // URL:
    // GET /api/user/{userId}/room?persontype=audience
    // GET /api/user/{userId}/room?persontype=speacker
    function getRoomList($user_id){
        if($this->input->get('persontype')=="audience"){
            $roomList = $this->room_service->getAudienceRoomList($user_id);
            $this->response_json($roomList,true,null);
        }else if($this->input->get('persontype')=="speacker"){
            $roomList = $this->room_service->getMasterRoomList($user_id);
            $this->response_json($roomList,true,null);
        }else{
            $this->response_json(null,false,"Wrong Peron Type");
        }
    }

    // URL:
    // GET /api/room/{roomId}?type=id
    // GET /api/room/{roomUrl}?type=url
    function _getRoom($idOrUrl){
        $type = $this->input->get('type');

        $room = null;
        if($type == "id"){
            $room = $this->room_service->getRoomById($idOrUrl);
        }else if($type == "url"){
            $room = $this->room_service->getRoomByUrl($idOrUrl);
        }else{
            $this->response_json(null,false,"Wrong Type");
        }

        if(empty($room)){
            $this->response_json(null,false,"No Room for ".$idOrUrl);
        }else{
            $this->response_json($room,true,null);
        }
    }

    // URL:
    // DELETE /api/room/{roomId}
    function _deleteRoom($room_id){
        $bool = $this->room_service->deleteRoom($room_id);

        if($bool)
            $this->response_json(null, true, "Delete Room Success!");
        else
            $this->response_json(null, false, "Delete Room Failed...");
    }

    // URL:
    // POST /api/room
    function makeRoom(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        if(empty($jsonArray['title']) || empty($jsonArray['master']) || empty($jsonArray['master_nickname']))
            $this->response_json(null, false, "Not right format");

        $url_name = null;
        if(!empty($jsonArray['url_name']))
            $url_name = $jsonArray['url_name'];

        $room = array(
            'url_name'=>$url_name,
            'title'=>$jsonArray['title'],
            'master'=>$jsonArray['master'],
            'master_nickname'=>$jsonArray['master_nickname'],
            'user_name_type'=>$jsonArray['user_name_type'],
            'vote_create_auth'=>$jsonArray['poll_create_auth']
        );

        $room_id = $this->room_service->register($room);
        if(is_numeric($room_id))
            $this->response_json(null, true, "Make Room Success!");
        else
            $this->response_json(null, true, "Make Room Failed...");
    }

    // URL:
    // POST /api/room/{roomId}/user
    function addAudience2Room($room_id){
        $jsonArray = json_decode(file_get_contents('php://input'),true);

        if(empty($jsonArray['user_id']))
            $this->response_json(null, false, "Not right format");

        if(!empty($this->room_service->getRoomUserByRoomIdAndUserId($room_id, $jsonArray['user_id'])))
            $this->response_json(null, false, "Already User is in The Room");

        $this->room_service->addAudience2Room($room_id, $jsonArray['user_id']);
        $this->response_json(null, true, "Add Audience to Room Success!");
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
