<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topic extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
    }

    function login(){
        // login 요청 -> login 검증 실행
        if(!empty($this->input->post('email')){
            $email = $this->input->post('email');
            $pw = $this->input->post('password');

            $user = $this->user_service->login($email, $pw);
            // 성공
            if(!empty($user)){
                
            // 실패
            }else{

            }

        // login page 요청 -> login page 리턴
        }else{
            $this->load->view('login')
        }
    }

    function signup{

    }
}
?>