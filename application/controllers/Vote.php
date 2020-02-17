<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vote extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/vote_service');
        $this->load->library('session');
    }

    function make_vote(){
        $nickname = $this->session->userdata('nickname');
        // 로그인 되어 있지 않다면
        if(empty($nickname)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        // 로그인 되어 있으면
        // post 요청 - 사용자가 투표 생성 요청시

        if(!empty($this->input->post('pollName'))){

            // $title = $this->input->post('title');
            // $vote_create_auth = $this->input->post('vote_create_auth');
            // $user_name_type= $this->input->post('user_name_type');
            // $deadline_check = $this->input->post('deadline_check');
            // if(empty($deadline_check)) $deadline_check = 0;
            // $deadline = $this->input->post('deadline');
            // $master = $this->session->userdata('sid');

            // $room = array('master'=>$master, 'title'=> $title, 'vote_create_auth'=> $vote_create_auth, 'user_name_type'=> $user_name_type, 'deadline_check'=> $deadline_check, 'deadline'=>$deadline);
            // $result = $this->room_service->register($room);

            $this->load->view('debug', array('debug'=>var_dump($this->input->post)));


            // if(!empty($result)){
            //     $this->load->view('result',array('message'=>"방이 생성되었습니다.",'location'=>"/index.php/room/speacker_myroom/".$result));

            // }else{
            //     $this->load->view('make_vote');
            // }



        // get 요청 - 사용자가 투표 생성 페이지를 요청시
        }else{
            $this->load->model('service/room_service');
            $room = $this->room_service->get_room_by_sid($this->input->get("room_id"));
            if(!$room)
                $this->load->view('result',array("message"=>"존재하지 않는 방입니다."));
            else
                $this->load->view('make_vote',array("room"=>$room));
        }
    }
    function vote_result($sid) {
        //투표가 존재하면 array('result'=>$result, 'label'=>$label, 'data'=>$data);
        //투표가 존재하지 않으면 array('result'=>$result, 'errormsg'=>'There are no vote in this room.');
        //를 결과 값으로 받는다.
        $res = $this->vote_service->vote_result($sid);
        //$this->load->view('debug', array('debug'=>var_dump($res)));

        if(!empty($res)) {
            //return json_encode($res); //string
            $this->load->view('debug', array('debug'=>json_encode($res)));
        }else {
            //return json_encode($res); //string
            $this->load->view('debug', array('debug'=>json_encode($res)));
        }

    }
}
?>
