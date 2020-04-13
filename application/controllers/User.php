<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
        $this->load->library('session');
    }

    // URL:
    // GET /api/user
    function mockIndex(){
        $user = $this->user_service->getUserById(1);
        $user = array(
            'sid' => $user['sid'],
            'email' => $user['email'],
            'name' => $user['name'],
            'nickname' => $user['nickname']
        );

        $this->response_json($user,true,null);
    }

    // URL:
    // GET /api/user
    function index(){
        if(empty($this->session->userdata('sid')))
            $this->response_json(null,false,"Login Please");

        $sid = $this->session->userdata('sid');
        $email = $this->session->userdata('email');
        $name = $this->session->userdata('name');
        $nickname = $this->session->userdata('nickname');

        $user = array(
            'sid' => $sid,
            'email' => $email,
            'name' => $name,
            'nickname' => $nickname
        );

        $this->response_json($user,true,null);
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
                $this->session->set_userdata(array('email'=>$user['email'], 'sid'=>$user['sid'], 'name'=>$user['name'], 'nickname'=>$user['nickname']));
                $this->load->view('result',array('message'=>"로그인 성공",'location'=>"/index.php/home/dashboard"));
            // 실패하는 경우는 없음.
            }

        // login page 요청 -> login page 리턴
        }else{
            $this->load->config('oauth');
            $this->google_setting = $this->config->item('google_login');
            $param = array(
                'response_type' => 'code',
                'client_id' => $this->google_setting['client_id'],
                'redirect_uri' => $this->google_setting['redirect_uri'],
                'access_type' => "offline",
                'scope' => "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email"
            );

            $authUrl = $this->google_setting['authorize_url'].'?'.http_build_query($param);
            $this->load->view('login', array('authUrl'=>$authUrl));
        }
    }


    function signup(){
        if(!$this->session->has_userdata('sign_up_email')||!$this->session->has_userdata('sign_up_name')){
             $this->load->view('result',array('message'=>"비정상적인 접근입니다.",'location'=>"/index.php/home"));
             return;
        }

        $email = $this->session->userdata('sign_up_email');
        $name = $this->session->userdata('sign_up_name');

        if(!empty($this->input->post('nickname'))){
          $password= $name;
          $nickname = $this->input->post('nickname');

          $user = array('email'=> $email, 'password'=> $password, 'name'=> $name, 'nickname'=> $nickname);
          $result = $this->user_service->signup($user);

          // $this->load->view('debug', array('debug'=>var_dump($result)));
          // 성공
          if($result){
              $user = $this->user_service->login($email, $password);
              unset($user['password']);
              $this->session->set_userdata($user);
              $this->load->view('result',array('message'=>'회원가입 되었습니다.','location'=>'/index.php/home/dashboard'));
          // 실패
          }else{
              $this->load->view('sign_up');
          }
          $this->session->unset_userdata('sign_up_email');
          $this->session->unset_userdata('sign_up_name');
      // login page 요청 -> login page 리턴
      }else{
          $this->load->view('sign_up',array('email'=>$email,'name'=>$name));
      }
    }

    function logout(){
        $this->session->sess_destroy();
        $this->load->view('result',array('message'=>"로그아웃 되었습니다.", 'location'=>"/index.php/home"));
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
