<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Simpoll extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/simpoll_service');
        $this->load->library('session');
    }

    function restWithParam($param){
        $method = $this->input->method(TRUE);

        if($method == "GET"){
            if(!empty($this->input->get('type'))) $this->_getSimpoll($param);
            else $this->_getSimpollById($param);
        }
        else if($method == "DELETE"){
            $this->_deleteSimpoll($param);
        }
    }

    function id($simpoll_id){
        $simpoll = $this->simpoll_service->getSimpollListWithQuestionListBySimpollId($simpoll_id);
        // 로그인 여부 필요할시 검증 절차
        $this->load->view('simpoll_page',array('simpoll'=>$simpoll));
    }

    function url($url){
        $simpollList = $this->getSimpollByUrl($url);
        $this->id($simpollList['sid']);
    }

    // URL:
    // GET /api/room/{roomId}/question?userId=?     -> audience
    // GET /api/room/{roomId}/question              -> speacker
    function getSimpollList($room_id){
        $user_id = $this->input->get('userId');

        $list = null;

        // speacker, audience
        if(empty($user_id)){
            $list = $this->simpoll_service->getSimpollListWithQuestionListByRoomId($room_id);
        }

        $this->response_json($list,true,null);
    }

    // URL:
    // GET /api/simpoll/{simpollId}?type=id
    // GET /api/simpoll/{simpollUrl}?type=url
    function _getSimpoll($idOrUrl){
        $type = $this->input->get('type');

        $simpoll = null;
        if($type == "id"){
            $simpoll = $this->simpoll_service->getSimpollById($idOrUrl);
        }else if($type == "url"){
            $simpoll = $this->simpoll_service->getSimpollByUrl($idOrUrl);
        }else{
            $this->response_json(null,false,"Wrong Type");
        }

        if(empty($simpoll)){
            $this->response_json(null,false,"No Simpoll for ".$idOrUrl);
        }else{
            $this->response_json($simpoll,true,null);
        }
    }

    function _getSimpollById($id){
        $type = $this->input->get('type');

        $simpoll = null;
        $simpoll = $this->simpoll_service->getSimpollListWithQuestionListBySimpollId($id);

        if(empty($simpoll)){
            $this->response_json(null,false,"No Simpoll for ".$id);
        }else{
            $this->response_json($simpoll,true,null);
        }
    }

    // URL:
    // DELETE /api/simpoll/{simpollId}
    function _deleteSimpoll($simpoll_id){
        $bool = $this->simpoll_service->deleteSimpoll($simpoll_id);

        if($bool)
            $this->response_json(null, true, "Delete Simpoll Success!");
        else
            $this->response_json(null, false, "Delete Simpoll Failed...");
    }

    // URL:
    // POST /api/simpoll
    function makeSimpoll(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);

        $user_id = $this->session->userdata('sid');
        $user_nickname = $this->session->userdata('nickname');
        $jsonArray['user_id'] = $user_id;
        $jsonArray['user_nickname'] = $user_nickname;
        //$jsonArray['user_id'] = "1";
        //$jsonArray['user_nickname'] = "nickname";
        $bool = $this->simpoll_service->createSimpoll($jsonArray);
        if($bool){
            $this->response_json(null,true,"Make Simpoll Success!");
        }else{
            $this->response_json(null,true,"Make Simpoll Failed...");
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
