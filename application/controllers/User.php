<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topic extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
    }

    function login(){
        // login 요청 -> login 검증 실행
        if(!empty($this->input->post('email'))){
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
            $this->load->view('login');
        }
    }

    function signup(){
      if(!empty($this->input->post('email'))){
          $email = $this->input->post('email');
          $pw = $this->input->post('password');
          $name = $this->input->post('name');
          $nickname = $this->input->post('nickname');

          $user = array('email'=> $email, 'password'=> $password, 'name'=> $name, 'nickname'=> $nickname);
          $result = $this->user_service->signup($user);
          // 성공
          if($result){
              $this->load->view('result.php',array('message'=>"회원가입이 되었습니다."));
          // 실패
          }else{
              $this->load->view('sign_up.php');
          }

      // login page 요청 -> login page 리턴
      }else{
          $this->load->view('sign_up.php');
      }
    }
    function index(){
        echo '
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8"/>
            </head>
            <body>
                토픽 메인 페이지
            </body>
        </html>
        ';
    }
}
?>
