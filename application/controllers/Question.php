<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Question extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/question_service');
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
