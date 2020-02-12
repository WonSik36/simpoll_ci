<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/room_service');
        $this->load->library('session');
    }

    function register(){

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
