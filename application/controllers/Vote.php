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
        if(!empty($this->input->post('title'))){
            // post 요청 받기
            $title = $this->input->post('title');
            $url_name = $this->input->post('url_name');
            $contents = $this->input->post('contents');
            $comment_check = $this->input->post('comment_check');
            $anonymous_check = $this->input->post('anonymous_check');
            $vote_type = $this->input->post('vote_type');
            $part_auth = $this->input->post('part_auth');
            $vote_end_date = $this->input->post('vote_end_date');
            $vote_end_time = $this->input->post('vote_end_time');
            $room_id = $this->input->post('room_id');
            $choice_count = (int)$this->input->post('cho_cnt');
            $user_id =  $this->session->userdata('sid');
            

            // post 요청 파싱
            if(empty($comment_check)) $comment_check = "0";
            if(empty($anonymous_check)) $anonymous_check = "0";
            if(empty($vote_type)) $vote_type = "0";

            // make deadline
            // 32400 = 60*60*9 -> timezone offset, 86400 = 60*60*24
            $deadline = date("Y-m-d A h:i",strtotime($vote_end_date)+(strtotime($vote_end_time)+60*60*9)%(60*60*24));
            
            $vote = array('title'=>$title, 'contents'=>$contents, 'comment_check'=>$comment_check, 'anonymous_check'=>$anonymous_check,
                    'vote_type'=>$vote_type, 'part_auth'=>$part_auth, 'room_id'=>$room_id, 'user_id'=>$user_id, 'deadline'=>$deadline);
            // service 에 vote 생성 요청

            // 성공시
            // 실패시

            $this->load->view('debug', array('debug'=>var_dump($vote)));


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
}
?>
