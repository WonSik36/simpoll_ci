<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
        $this->load->library('session');
    }

    function login(){
        // login 요청 -> login 검증 실행
        if(!empty($this->input->post('email'))){
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->user_service->login($email, $password);
            //$this->load->view('debug',array('debug'=>var_dump($user)));
            // 성공
            if(!empty($user)){
                $this->load->view('result',array('message'=>"로그인 성공",'location'=>"/index.php/home"));
                $this->session->set_userdata(array('email'=>$user->email, 'sid'=>$user->sid, 'name'=>$user->name, 'nickname'=>$user->nickname));
            // 실패
            }else{
                $this->load->view('login');
            }

        // login page 요청 -> login page 리턴
        }else{
            $this->load->view('login');
        }
    }

    function signup(){
      if(!empty($this->input->post('email'))){
          $email = $this->input->post('email');
          $password= $this->input->post('password');
          $name = $this->input->post('name');
          $nickname = $this->input->post('nickname');

          $user = array('email'=> $email, 'password'=> $password, 'name'=> $name, 'nickname'=> $nickname);
          $result = $this->user_service->signup($user);

          // $this->load->view('debug', array('debug'=>var_dump($result)));
          // 성공
          if($result){
              $this->load->view('result',array('message'=>"회원가입이 되었습니다.",'location'=>"/index.php/user/login"));
          // 실패
          }else{
              $this->load->view('sign_up');
          }*/

      // login page 요청 -> login page 리턴
      }else{
          $this->load->view('sign_up');
      }
    }

    function logout(){
        $this->session->sess_destroy();
        $this->load->view('result',array('message'=>"로그아웃 되었습니다.", 'location'=>"/index.php/home"));
    }
}
?>
