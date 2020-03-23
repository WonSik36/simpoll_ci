<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vote extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/vote_service');
    }

    // URL:
    // DELETE /api/vote/{voteId}
    function deleteVote($vote_id){
        $bool = $this->vote_service->deleteVote($vote_id);

        if($bool)
            $this->response_json(null, true, "Delete Vote Success!");
        else
            $this->response_json(null, false, "Delete Vote Failed...");
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
