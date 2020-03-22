<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/room_service');
        $this->load->library('session');
    }

    function getRoomList($user_id){
        if($this->input->get('persontype')=="audience"){
            $roomList = $this->room_service->getAudienceRoomList($user_id);
            $this->response_json($roomList,true,null);
        }else if($this->input->get('persontype')=="speacker"){
            /* need to create */
        }else{
            $this->response_json(null,false,"Wrong Peron Type");
        }
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
