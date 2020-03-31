<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Simpoll extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/simpoll_service');
    }

    function restWithParam($param){
        $method = $this->input->method(TRUE);

        if($method == "GET"){
            if(!empty($this->input->get('type'))) $this->_getSimpoll($param);
            else _getSimpollById($param);
        }
        else if($method == "DELETE"){
            $this->_deleteSimpoll($param);
        }
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
        $simpoll = $this->simpoll_service->getSimpollById($idOrUrl);

        if(empty($simpoll)){
            $this->response_json(null,false,"No Simpoll for ".$idOrUrl);
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

    /* need to fix: Transaction */
    /* need to fix: Deal with multiple questions */
    // URL:
    // POST /api/simpoll
    function makeSimpoll(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
    /*    $simpoll = $this->_makeSimpoll($jsonArray);

        $simpoll_id = $this->simpoll_service->register($simpoll);

        $question = array(
            'simpoll_id'=>$simpoll_id,
            'title'=>$jsonArray['question_title'],
            'choice_no'=>$jsonArray['choice_no'],
            'question_type'=>$jsonArray['question_type']
        );
        $this->load->model('service/question_service');
        $bool = $this->question_service->register($question);
*/      
        // $user_id = $this->session->userdata('sid');
        // $user_nickanme = $this->session->userdata('nickname');
        // $jsonArray['user_id'] = $user_id;
        // $jsonArray['user_nickname'] = $user_nickname;
        $jsonArray['user_id'] = "1";
        $jsonArray['user_nickname'] = "nickname";
        $bool = $this->simpoll_service->createSimpoll($jsonArray);
        if($bool){
            $this->response_json(null,true,"Make Simpoll Success!");
        }else{
            $this->response_json(null,true,"Make Simpoll Failed...");
        }
    }

    /* need to fix: input format */
    function _makeSimpoll($jsonArray){
        if(empty($jsonArray['room_id']) || empty($jsonArray['simpoll_title']) || empty($jsonArray['user_id']) || empty($jsonArray['user_nickname'])
                || empty($jsonArray['deadline']))
            $this->response_json(null, false, "Not right format");

        $url_name = null;
        if(!empty($jsonArray['url_name']))
            $url_name = $jsonArray['url_name'];
        $simpoll_title = null;
        if(!empty($jsonArray['title']))
            $simpoll_title = $jsonArray['simpoll_title'];
        $is_comment_enable = 1;
        if(empty($jsonArray['is_comment_enable']))
            $is_comment_enable = 0;
        $is_anonymous = 1;
        if(empty($jsonArray['is_anonymous']))
            $is_anonymous = 0;

        $simpoll = array(
            'room_id'=>$jsonArray['room_id'],
            'title'=>$simpoll_title,
            'url_name'=>$url_name,
            'user_id'=>$jsonArray['user_id'],
            'user_nickname'=>$jsonArray['user_nickname'],
            'deadline'=>$jsonArray['deadline'],
            'is_comment_enable'=>$is_comment_enable,
            'is_anonymous'=>$is_anonymous,
            'part_auth'=>$jsonArray['part_auth']
        );

        return $simpoll;
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
