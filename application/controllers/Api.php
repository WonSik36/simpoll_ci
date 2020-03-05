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
            $this->page($sid);

        // 검색 실패
        }else{
            $this->load->view('result',array('message'=>"해당하는 Simpoll을 찾지 못하였습니다."));
        }
    }

    function vote_page($sid){
        $vote = $this->vote_service->get_vote($sid);
        $nickname = $this->session->userdata('nickname');

        // 해당하는 시퀀스 아이디를 찾지 못한 경우
        if(empty($vote)){
            $this->load->view('result',array('message'=>"해당하는 Simpoll을 찾지 못하였습니다."));
            return;
        }

        // 로그인 한 경우에만 투표가 가능한 경우
        if($vote['part_auth'] == 0 && empty($nickname)){
            $this->load->view('result',array('message'=>"로그인하시기 바랍니다.",'location'=>"/index.php/user/login"));
            return;
        }

        // post 요청 - 사용자가 투표를 제출 한 후
        if(!empty($this->input->post('contents_number'))){
            $contents_number = $this->input->post('contents_number');
            $userdata = $this->session->userdata();

            $result = $this->vote_service->voting($vote, $contents_number, $userdata);

            // $this->load->view('debug',array('debug'=>var_dump($this->input->post(NULL))));
            // $this->load->view('debug',array('debug'=>var_dump($userdata)));

            // 투표 성공
            if($result){

                // 로그인 여부에 따라 방 혹은 홈페이지로 리다이렉션
                // 로그인 되어 있지 않다면
                if(empty($nickname)){
                    $this->load->view('result',array('message'=>"투표가 완료되었습니다.",'location'=>"/index.php/home"));
                }else{
                    $room_id = $vote['room_id'];
                    $this->load->view('result',array('message'=>"투표가 완료되었습니다.",'location'=>"/index.php/room/page/".$room_id));
                }

            // 투표 실패
            }else{
                $this->load->view('result',array('message'=>"투표가 실패하였습니다.",'location'=>"/index.php/vote/page/".$sid));
            }

        // get 요청 - 사용자가 투표 페이지를 요청시
        }else{
            // 참여 인원 구하기. (sp_vote, sp_user_vote_choice)
            $part_num = $this->vote_service->get_part_num($sid);
            // 제목, 선택지, 마감일자 구하기. (sp_vote)
            // array로 반환.
            $vote['part_num'] = $part_num;
            $user_choice = $this->vote_service->get_choice_by_vote_id_and_user_id($sid, $this->session->userdata('sid'));
            $this->load->view('vote_page', array('vote'=>$vote,'user_choice'=>$user_choice));
        }
    }

    function room_url($url) {
        //url을 기준으로 sid를 찾아준다
        $vote = $this->vote_service->searchVoteByUrl($url);

        // $this->load->view('debug',array('debug'=>var_dump($vote)));

        // 검색 성공
        if(!empty($vote)){
            $sid = $vote['sid'];
            $this->page($sid);

        // 검색 실패
        }else{
            $this->load->view('result',array('message'=>"해당하는 Simpoll을 찾지 못하였습니다."));
        }
    }

    function room_page($sid) {
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
}
?>
