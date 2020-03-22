<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Choice extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/choice_service');
    }

    function getVoteResult($vote_id){
        $user_id = $this->input->get('userId');
        if(empty($user_id)){
            $this->response_json(null,false,"Need userID");
        }

        $this->load->model('service/vote_service');
        $vote = $this->vote_service->getVoteById($vote_id);
        $voteResult = $this->choice_service->getVoteResult($vote);
        $userChoice = $this->choice_service->getChoiceByVoteIdAndUserId($vote_id, $user_id);

        $voteResult['sid'] = $userChoice['sid'];
        $voteResult['choice_no'] = $userChoice['choice_no'];
        $this->response_json($voteResult, true, null);
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
