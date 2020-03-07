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
            //$this->load->view('result',array('message'=>"해당하는 Simpoll을 찾지 못하였습니다."));
            //return;
            echo '{"result": "fail"}';
        }

        // 로그인 한 경우에만 투표가 가능한 경우
        if($vote['part_auth'] == 0 && empty($nickname)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        // get 요청 - 사용자가 투표 페이지를 요청시
        // 참여 인원 구하기. (sp_vote, sp_user_vote_choice)
        $part_num = $this->vote_service->get_part_num($sid);
        // 제목, 선택지, 마감일자 구하기. (sp_vote)
        // array로 반환.
        $vote['part_num'] = $part_num;
        //$user_choice = $this->vote_service->get_choice_by_vote_id_and_user_id($sid, $this->session->userdata('sid'));
        //$this->load->view('vote_page', array('vote'=>$vote,'user_choice'=>$user_choice));
        //$vote_page = array('vote'=>$vote,'user_choice'=>$user_choice);
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
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        $result = $this->room_service->get_room_by_sid($sid);
        echo json_encode($result);
    }

    function find_user_rooms() {
        $user_id = $this->session->userdata('sid');
        if(empty($user_id)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
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
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }
        $vote = $this->vote_service->get_list_by_room_id($room_id);
        // 해당하는 방을 찾지 못한 경우
        if(empty($vote)){
            echo '{"result": "noVote"}';
            return;
        }else {
            echo json_encode($vote);
        }
    }
}
?>
