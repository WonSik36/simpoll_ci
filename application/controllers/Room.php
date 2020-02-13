<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/room_service');
        $this->load->library('session');
    }

    function register(){
        $nickname = $this->session->userdata('nickname');
        // 로그인 되어 있지 않다면
        if(empty($nickname)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        // 로그인 되어 있으면
        // post 요청 - 사용자가 방 생성 요청시
        if(!empty($this->input->post('title'))){
            $title = $this->input->post('title');
            $vote_create_auth = $this->input->post('vote_create_auth');
            $user_name_type= $this->input->post('user_name_type');
            $deadline_check = $this->input->post('deadline_check');
            if(empty($deadline_check)) $deadline_check = 0;
            $deadline = $this->input->post('deadline');
            $master = $this->session->userdata('sid');

            $room = array('master'=>$master, 'title'=> $title, 'vote_create_auth'=> $vote_create_auth, 'user_name_type'=> $user_name_type, 'deadline_check'=> $deadline_check, 'deadline'=>$deadline);
            $result = $this->room_service->register($room);

            //$this->load->view('debug', array('debug'=>var_dump($result)));

            // 성공
            if($result){
                $this->load->view('result',array('message'=>"방이 생성되었습니다.",'location'=>"/index.php/room/myroom"));
            // 실패
            }else{
                $this->load->view('make_room');
            }


        // get 요청 - 사용자가 방 생성 페이지를 요청시
        }else{
            $this->load->view('make_room', array('nickname'=>$nickname));
        }
    }

    // 방 생성 후 강연자 시점 페이지
    function myroom() {
        // 방 제목, room_id, 
        $this->load->view('my_room',array('nickname'=>$nickname));
    }

    // 자신이 개설한 방 목록
    function speacker(){
        $user_id = $this->session->userdata('sid');
        $nickname = $this->session->userdata('nickname');

        // 로그인 되어 있지 않다면
        if(empty($user_id)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        $room_list = $this->room_service->speacker_room_list($user_id);
        // $this->load->view('debug',array('debug'=>var_dump($room_list)));
        $this->load->view('room_speacker_list',array('list'=>$room_list, 'nickname'=>$nickname));
    }
}
?>
