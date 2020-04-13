<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
        $this->load->library('session');
    }
    public function google()
    {
        $this->load->library("google_login");
        $result = $this->google_login->get_profile();
        $result = json_decode($result);
        $email = $result->email;
        $name = $result->name;
        //print_r($result);
        //회원 가입 여부
        $user = $this->user_service->login($email,$name);
        if(!empty($user)){
            //회원가입이 되어있을 경우
            unset($user['password']);
            $this->session->set_userdata($user);
            $this->load->view('result',array('message'=>'로그인 되었습니다.','location'=>'/index.php/home/dashboard'));
        }else{
            //회원가입이 안되어있을 경우
            $this->session->set_userdata(array('sign_up_email'=>$email,'sign_up_name'=>$name));
            $this->load->view('result',array('message'=>'회원가입을 진행합니다.','location'=>'/index.php/user/signup'));
        }
    }
}
?>
