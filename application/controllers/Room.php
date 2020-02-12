<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/room_service');
        $this->load->library('session');
    }

    function register(){
        if(!empty($this->input->post('c_auth'))){
            $c_auth = $this->input->post('c_auth');
            $nick_check= $this->input->post('nick_check');
            $d_check = $this->input->post('d_check');

            $room = array('c_auth'=> $c_auth, 'nick_check'=> $nick_check, 'd_check'=> $d_check);
            $result = $this->room_service->register($room);

            // $this->load->view('debug', array('debug'=>var_dump($result)));
            // 성공
            if($result){
                $this->load->view('result',array('message'=>"방이 생성되었습니다.",'location'=>"/index.php/home"));
            // 실패
            }else{
                $this->load->view('make_room');
            }

        // login page 요청 -> login page 리턴
        }else{
            $this->load->view('make_room');
        }
    }

    function speacker(){
        $user_id = $this->session->userdata('id');

        // 로그인 되어 있지 않다면
        if(empty($user_id)){
            $this->load->view('login');
            return;
        }

        $room_list = $this->room_service->speacker_room_list($user_id);
        $this->load->view('room_speacker_list',array('list'=>$room_list));
    }
}
?>
