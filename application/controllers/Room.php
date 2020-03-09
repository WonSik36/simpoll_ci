<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Room extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/room_service');
        $this->load->library('session');
    }

    /* need to fix it */
    /*
    function url($url) {
        //url을 기준으로 sid를 찾아준다
        $vote = $this->vote_service->searchVoteByUrl($url);

        // $this->load->view('debug',array('debug'=>var_dump($vote)));

        // 검색 성공
        if(!empty($vote)){
            // need to fix it
            // it call same logic one more
            $sid = $vote['sid'];
            $this->page($sid);

        // 검색 실패
        }else{
            $this->load->view('result',array('message'=>"해당하는 Simpoll을 찾지 못하였습니다."));
        }
    }

    function page($sid) {
        $nickname = $this->session->userdata('nickname');
        // 로그인 되어 있지 않다면
        if(empty($nickname)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }
        $this->load->model('service/vote_service');
        // 참여 인원 구하기. (sp_vote, sp_user_vote_choice)
        $part_num = $this->vote_service->get_part_num($sid);
        // 제목, 선택지, 마감일자 구하기. (sp_vote)
        // array로 반환.
        $vote = $this->vote_service->get_vote($sid);
        $vote['part_num'] = $part_num;
        $user_choice = $this->vote_service->get_choice_by_vote_id_and_user_id($sid, $this->session->userdata('sid'));
        $result = $this->room_service->get_room_and_list($sid);
        //$this->load->view('my_room_audience', $result, array('vote'=>$vote,'user_choice'=>$user_choice));
    }
    */

    /* need to fix it */
    /* not matching controller */
    function vote_ajax() {
        $this->load->model('service/vote_service');

        $vote_choice = file_get_contents('php://input'); //($_POST doesn't work here)
        $response = json_decode($vote_choice,true);
        $contents_number = $response['contents_number'];
        $vote_id = $response['vote_id'];


        // 해당하는 시퀀스 아이디를 찾지 못한 경우
        $vote = $this->vote_service->get_vote($vote_id);
        if(empty($vote)){
            echo '{"result": "fail"}';
            return;
        }

        // 로그인 한 경우에만 투표가 가능한 경우
        $nickname = $this->session->userdata('nickname');
        if($vote['part_auth'] == 0 && empty($nickname)){
            echo '{"result": "fail"}';
            return;
        }

        $userdata = $this->session->userdata();
        $result = $this->vote_service->voting($vote, $contents_number, $userdata);
        // 투표 성공
        if($result){
            echo '{"result": "success"}';

        // 투표 실패
        }else{
            echo '{"result": "fail"}';
        }
    }

    function register() {
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
            $url_name = $this->input->post('url_name');
            if(strlen($url_name)==0) $url_name = NULL;
            $vote_create_auth = $this->input->post('vote_create_auth');
            $user_name_type= $this->input->post('user_name_type');
            $master = $this->session->userdata('sid');

            $room = array('master'=>$master, 'title'=> $title, 'url_name'=>$url_name, 'vote_create_auth'=> $vote_create_auth, 'user_name_type'=> $user_name_type);
            $result = $this->room_service->register($room);

            //$this->load->view('debug', array('debug'=>var_dump($result)));

            // 성공시 $result는 방 아이디를 반환한다.
            if(!empty($result)){
                $this->load->view('result',array('message'=>"방이 생성되었습니다.",'location'=>"/index.php/room/speacker_myroom/".$result));
            // 실패
            }else{
                $this->load->view('make_room');
            }


        // get 요청 - 사용자가 방 생성 페이지를 요청시
        }else{
            $this->load->view('make_room');
        }
    }

    // 방 생성 후 강연자 시점 페이지
    function speacker_myroom($room_sid) {
        $nickname = $this->session->userdata('nickname');
        // 로그인 되어 있지 않다면
        if(empty($nickname)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }
        // $room_id로 array('room'=>$room, 'list'=>$list)를 가져오기.
        $result = $this->room_service->get_room_and_list($room_sid);
        //$this->load->view('debug',array('debug'=>var_dump($result)));
        $this->load->view('my_room',$result);
    }

    // 자신이 개설한 방 목록
    function speacker(){
        $user_id = $this->session->userdata('sid');
        // 로그인 되어 있지 않다면
        if(empty($user_id)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        $room_list = $this->room_service->speacker_room_list($user_id);
        // $this->load->view('debug',array('debug'=>var_dump($room_list)));
        $this->load->view('room_speacker_list',array('list'=>$room_list));
    }

    // 청중이 참여한 방 목록.
    function audience(){
        $user_id = $this->session->userdata('sid');
        // 로그인 되어 있지 않다면
        if(empty($user_id)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        $room_list = $this->room_service->audience_room_list($user_id);
        //$this->load->view('debug',array('debug'=>var_dump($room_list)));
        $this->load->view('room_audience_list',array('list'=>$room_list));
    }
}
?>
