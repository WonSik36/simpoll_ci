<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Choice extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/choice_service');
    }

    function rest(){
        $method = $this->input->method(TRUE);

        if($method == "GET")
            $this->_getVoteResult();
        else if($method == "POST"){
            $this->_submitVote();
        }
    }

    // URL: 
    // GET /api/choice?voteId=?&userId=?&persontype=audience
    // GET /api/choice?voteId=?&userId=?&persontype=speacker
    function _getVoteResult(){
        $vote_id = $this->input->get('voteId');
        if(empty($vote_id)){
            $this->response_json(null,false,"Need voteID");
        }

        $user_id = $this->input->get('userId');
        if(empty($user_id)){
            $this->response_json(null,false,"Need userID");
        }

        $personType = $this->input->get('persontype');
        if(empty($personType)){
            $this->response_json(null,false,"Need person type");
        }

        $this->load->model('service/vote_service');
        $vote = $this->vote_service->getVoteById($vote_id);
        $voteResult = $this->choice_service->getVoteResult($vote);
        if($personType == "audience"){
            $userChoice = $this->choice_service->getChoiceByVoteIdAndUserId($vote_id, $user_id);
            $voteResult['sid'] = $userChoice['sid'];
            $voteResult['choice_no'] = $userChoice['choice_no'];
            $this->response_json($voteResult, true, null);
        }else if($personType == "speacker"){
            $participant = $this->choice_service->getParticipant($vote);
            $voteResult['participant'] = $participant;
            $this->response_json($voteResult, true, null);
        }

        $this->response_json(null,false,"Not matching person type");
    }

    // URL:
    // POST /api/choice
    function _submitVote(){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        if(empty($jsonArray['user_id']) || empty($jsonArray['vote_id']) || empty($jsonArray['choice_no']))
            $this->response_json(null, false, "Not right format");

        $choice = array(
            'user_id'=> $jsonArray['user_id'],
            'vote_id'=> $jsonArray['vote_id'],
            'choice_no'=> $jsonArray['choice_no']
        );

        $bool = $this->choice_service->voting($choice);
        
        if($bool){
            $this->response_json(null, true, "Simpolling Success!");
        }else{
            $this->response_json(null, true, "Simpolling Failed...");
        }
    }

    // URL:
    // PUT /api/choice/{choiceId}
    function updateChoice($choice_id){
        $jsonArray = json_decode(file_get_contents('php://input'),true);
        if(empty($jsonArray['user_id']) || empty($jsonArray['vote_id']) || empty($jsonArray['choice_no']))
            $this->response_json(null, false, "Not right format");

        $choice = $this->choice_service->getChoiceById($choice_id);

        if($choice['user_id'] != $jsonArray['user_id'])
            $this->response_json(null, true, "No authorization Error");
            
        $choice['choice_no'] = $jsonArray['choice_no'];
        $bool = $this->choice_service->updateChoice($choice);
        if($bool){
            $this->response_json(null, true, "Simpoll Update Success!");
        }else{
            $this->response_json(null, true, "Simpoll Update Failed...");
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
