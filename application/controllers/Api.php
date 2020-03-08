<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
        $this->load->model('service/room_service');
        $this->load->model('service/vote_service');
        $this->load->library('session');
    }


    function vote_url($url){
        //url을 기준으로 sid를 찾아준다
        $vote = $this->vote_service->searchVoteByUrl($url);

        // $this->load->view('debug',array('debug'=>var_dump($vote)));

        // 검색 성공
        if(!empty($vote)){
            $sid = $vote['sid'];
            $this->vote_page($sid);

        // 검색 실패
        }else{
            echo '{"result": "fail"}';
        }
    }

    function vote_page($sid){
        $vote = $this->vote_service->get_vote($sid);
        $nickname = $this->session->userdata('nickname');

        // 해당하는 시퀀스 아이디를 찾지 못한 경우
        if(empty($vote)){
            echo '{"result": "fail"}';
        }

        // 로그인 한 경우에만 투표가 가능한 경우
        if($vote['part_auth'] == 0 && empty($nickname)){
            echo '{"result": "Login Please"}';
        }

        // get 요청 - 사용자가 투표 페이지를 요청시
        // 참여 인원 구하기. (sp_vote, sp_user_vote_choice)
        $part_num = $this->vote_service->get_part_num($sid);
        // array로 반환.
        $vote['part_num'] = $part_num;
        echo json_encode($vote);

    }

    function room_url($url) {
        //url을 기준으로 sid를 찾아준다
        $vote = $this->vote_service->searchVoteByUrl($url);

        // 검색 성공
        if(!empty($vote)){
            $sid = $vote['sid'];
            $this->room_page($sid);

        // 검색 실패
        }else{
            echo '{"result": "fail"}';
        }
    }

    function room_page($sid) {
        $nickname = $this->session->userdata('nickname');
        // 로그인 되어 있지 않다면
        if(empty($nickname)){
            echo '{"result": "Login Please"}';
        }

        $result = $this->room_service->get_room_by_sid($sid);
        echo json_encode($result);
    }

    function find_user_rooms() {
        $user_id = $this->session->userdata('sid');
        if(empty($user_id)){
            echo '{"result": "Login Please"}';
        }
        $room = $this->room_service->audience_room_list($user_id);
        // 해당하는 방을 찾지 못한 경우
        if(empty($room)){
            echo '{"result": "noRoom"}';
            return;
        }else {
            echo json_encode($room);
        }
    }

    function find_room_votes($room_id) {
        $user_id = $this->session->userdata('sid');
        if(empty($user_id)){
            echo '{"result": "Login Please"}';
        }
        $vote = $this->vote_service->get_list_by_room_id($room_id,$user_id);
        // 해당하는 방을 찾지 못한 경우
        if(empty($vote)){
            echo '{"result": "noVote"}';
            return;
        }else {
            echo json_encode($vote);
        }
    }

    function return_vote_result($sid) {
        $res = $this->vote_service->vote_result($sid);
        //$this->load->view('debug', array('debug'=>var_dump($res)));

        if(!empty($res)) {
            echo json_encode($res); //string
            // $this->load->view('debug', array('debug'=>json_encode($res)));
        }else {
            echo json_encode($res); //string
            // $this->load->view('debug', array('debug'=>json_encode($res)));
        }
    }

    function voting($sid) {
        $vote = $this->vote_service->get_vote($sid);
        $nickname = $this->session->userdata('nickname');

        // 해당하는 시퀀스 아이디를 찾지 못한 경우
        if(empty($vote)){
            echo '{"result": "Could not find the corresponding simpoll."}'
        }

        // 로그인 한 경우에만 투표가 가능한 경우
        if($vote['part_auth'] == 0 && empty($nickname)){
            echo '{"result": "Login Please"}';
        }

        // post 요청 - 사용자가 투표를 제출 한 후
        if(!empty($this->input->post('contents_number'))){
            $contents_number = $this->input->post('contents_number');
            $userdata = $this->session->userdata();

            $result = $this->vote_service->voting($vote, $contents_number, $userdata);

            // 투표 성공
            if($result){
                echo '{"result": "Simpoll complete."}';
            // 투표 실패
            }else{
                echo '{"result": "Simpoll is not complete."}';
            }
        }
    }
}
?>
