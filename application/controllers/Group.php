<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Group extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/group_service');
    }

    function getVoteList($room_id){
        $user_id = $this->input->get('userId');
        if(empty($user_id)){
            $this->response_json(null,false,"Need userID");
        }

        $list = $this->group_service->getGroupListWithVotedList($room_id, $user_id);
        $this->response_json($list,true,null);
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
