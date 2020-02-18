<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vote extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/vote_service');
        $this->load->library('session');
    }

    function url($url){
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

    function page($sid){
        // post 요청 - 사용자가 투표를 제출 한 후
        if(!empty($this->input->post('contents_number'))){


            
            $nickname = $this->session->userdata('nickname');

            // $this->load->view('debug',array('debug'=>var_dump($this->input->post(NULL))));
            // 로그인 되어 있지 않다면
            if(empty($nickname)){
                $this->load->view('result',array('message'=>"투표가 완료되었습니다.",'location'=>"/index.php/home"));
            }else{
                $room_id = $this->vote_service->get_vote($sid)['room_id'];
                $this->load->view('result',array('message'=>"투표가 완료되었습니다.",'location'=>"/index.php/room/page/".$room_id));
            }

        // get 요청 - 사용자가 투표 페이지를 요청시
        }else{
            // 참여 인원 구하기. (sp_vote, sp_user_vote_choice)
            $part_num = $this->vote_service->get_part_num($sid);
            // 제목, 선택지, 마감일자 구하기. (sp_vote)
            // array로 반환.
            $vote = $this->vote_service->get_vote($sid);
            $vote['part_num'] = $part_num;
            $this->load->view('vote_page', array('vote'=>$vote));
            return $vote;
        }
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
            // contents 합치기
            $contents = "";
            for($i=0;$i<$choice_count;$i++){
                $content = $this->input->post("content_".$i);
                if(!empty($content))
                    $contents = $contents.$content."|";
            }
            $contents = substr($contents,0,strlen($contents)-1);

            // make deadline
            // 32400 = 60*60*9 -> timezone offset, 86400 = 60*60*24
            $deadline = date("Y-m-d A h:i",strtotime($vote_end_date)+(strtotime($vote_end_time)+32400)%(86400));

            $vote = array('title'=>$title, 'url_name'=>$url_name, 'contents'=>$contents, 'comment_check'=>$comment_check, 'anonymous_check'=>$anonymous_check,
                    'vote_type'=>$vote_type, 'part_auth'=>$part_auth, 'room_id'=>$room_id, 'user_id'=>$user_id, 'deadline'=>$deadline);
            // service 에 vote 생성 요청
            $result = $this->vote_service->vote_register($vote);
            if($result){
                // 성공시 $result는 true를 반환한다.
                // 방에 투표 목록이 추가가 된다.
                $this->load->view('result',array("message"=>"투표가 생성되었습니다.", "location"=>"/index.php/room/speacker_myroom/".$room_id));
            }else{
                // 실패시 $result는 false를 반환한다.
                // 다시 투표 생성페이지.
                $this->load->view('result',array("message"=>"투표 생성에 실패하였습니다.", "location"=>"/index.php/vote/make_vote?room_id=".$room_id));
            }
            //$this->load->view('debug', array('debug'=>var_dump($result)));


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
            echo json_encode($res); //string
            // $this->load->view('debug', array('debug'=>json_encode($res)));
        }else {
            echo json_encode($res); //string
            // $this->load->view('debug', array('debug'=>json_encode($res)));
        }

    }
}
?>
