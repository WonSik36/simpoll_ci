<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Option extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/option_service');
        $this->load->library('session');
    }

    function rest(){
        $method = $this->input->method(TRUE);

        if($method == "POST"){
            $this->_submitQuestion();
        }
    }

    // URL:
    // GET /api/option?questionId=?&userId=?&persontype=audience
    // GET /api/option?questionId=?&userId=?&persontype=speacker

    function _getQuestionResult(){
        $question_id = $this->input->get('questionId');
        if(empty($question_id)){
            $this->response_json(null,false,"Need questionID");
        }

        $user_id = $this->input->get('userId');
        if(empty($user_id)){
            $this->response_json(null,false,"Need userID");
        }

        $personType = $this->input->get('persontype');
        if(empty($personType)){
            $this->response_json(null,false,"Need person type");
        }

        $this->load->model('service/question_service');
        $this->load->model('service/simpoll_service');
        $question = $this->question_service->getQuestionById($question_id);
        $questionResult = $this->question_service->getQusetionResult($question);
        if($personType == "audience"){
            $userOption = $this->simpoll_service->getSimpollListWithQuestionListBySimpollId($simpoll_id);
            $questionResult['sid'] = $userOPtion['sid'];
            $questionResult['option_no'] = $userChoice['option_no'];
            $this->response_json($questionResult, true, null);
        }else if($personType == "speacker"){
            $participant = $this->choice_service->getParticipant($question);
            $questionResult['participant'] = $participant;
            $this->response_json($questionResult, true, null);
        }

        $this->response_json(null,false,"Not matching person type");
    }

    // URL:
    // POST /api/option
    function _submitQuestion(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        if(empty($jsonArray['option_id']))
            $this->response_json(null, false, "Not right format");

        $user_id = $this->session->userdata('sid');
        $option_id = $jsonArray['option_id'];


        $bool = $this->option_service->voting($option_id,$user_id);

        if($bool){
            $this->response_json(null, true, "Simpolling Success!");
        }else{
            $this->response_json(null, true, "Simpolling Failed...");
        }
    }
/*
    // URL:
    // PUT /api/option/{optionId}
    //사용 X
    function updateOption($option_id){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        if(empty($jsonArray['user_id']) || empty($jsonArray['option_id']))
            $this->response_json(null, false, "Not right format");

        $option = $this->option_service->getOptionById($option_id);

        if($option['option_id'] != $jsonArray['option_id'])
            $this->response_json(null, true, "No authorization Error");

        $bool = $this->option_service->updateOption($option);
        if($bool){
            $this->response_json(null, true, "Simpoll Update Success!");
        }else{
            $this->response_json(null, true, "Simpoll Update Failed...");
        }
    }
*/
    // simpoll 생성시, 만들어지는 선택지 한 개 한 개를 저장.
    function registerOption($question_id){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        if(empty($jsonArray['user_id']) || empty($jsonArray['name']))
            $this->response_json(null, false, "Not right format");
        $user_id = null;
        $user_nickname = null;
        $option = array(
            'name'=>$jsonArray['name'],
            'user_id'=>$user_id,
            'user_nickname'=>$user_nickname,
            'question_id'=>$jsonArray['question_id']
        );
        $result = $this->option_service->registerOption($option);

        if($result){
            $this->response_json(null, true, "Simpoll Create Success!");
        }else{
            $this->response_json(null, true, "Simpoll Create Failed...");
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
