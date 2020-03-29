<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Api extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('service/user_service');
        $this->load->model('service/room_service');
        $this->load->model('service/option_service');
        $this->load->library('session');
    }

    function test($param){
        $method = $this->input->method(true);

        switch($method){
            case 'GET':
                $this->_get($param);
                break;
            case 'POST':
                $this->_post($param);
                break;
            case 'PUT':
                $this->_put($param);
                break;
            case 'DELETE':
                $this->_delete($param);
                break;
        }
    }

    function _get($param){
        echo "get";
        echo $param;
    }

    function _post($param){
        echo "post";
        echo $param;
    }

    function _put($param){
        echo "put";
        echo $param;
    }

    function _delete($param){
        echo "delete";
        echo $param;
    }

    function vote_url($url){
        //url을 기준으로 sid를 찾아준다
        $vote = $this->vote_service->searchVoteByUrl($url);

        // $this->load->view('debug',array('debug'=>var_dump($vote)));

        // 검색 성공
        if(!empty($vote)){
            /* need to fix it */
            /*
                it call same logic one more
            */
            $sid = $vote['sid'];
            $this->vote_page($sid);

        // 검색 실패
        }else{
            $this->response_json(null,false,"No Matching URL");
        }
    }

    function vote_page($sid){
        $vote = $this->vote_service->get_vote($sid);
        $nickname = $this->session->userdata('nickname');

        // 해당하는 시퀀스 아이디를 찾지 못한 경우
        if(empty($vote)){
            $this->response_json(null,false,"No Matching Vote");
        }

        // 로그인 한 경우에만 투표가 가능한 경우
        if($vote['part_auth'] == 0 && empty($nickname)){
            $this->response_json(null,false,"Login Please");
        }

        // 참여 인원 구하기. (sp_vote, sp_user_vote_choice)
        $part_num = $this->vote_service->get_part_num($sid);
        // array로 반환.
        $vote['part_num'] = $part_num;
        $this->response_json($vote,true,null);
    }

    function room_url($url) {
        //url을 기준으로 sid를 찾아준다
        $room = $this->room_service->searchRoomByUrl($url);

        // 검색 성공
        if(!empty($room)){
            /* need to fix it */
            /*
                it call same logic one more
            */
            $sid = $room['sid'];
            $this->room_page($sid);

        // 검색 실패
        }else{
            $this->response_json(null,false,"No Matching URL");
        }
    }

    function room_page($sid) {
        $room = $this->room_service->get_room_by_sid($sid);

        // 해당하는 방이 존재하지 않는다면
        if(empty($room)){
            $this->response_json($room,true,"No Matching Room");
        }

        $this->response_json($room,true,null);
    }

    function find_user_rooms() {
        $user_id = $this->session->userdata('sid');
        if(empty($user_id)){
            $this->response_json(null,false,"Login Please");
        }

        $roomList = $this->room_service->audience_room_list($user_id);
        $this->response_json($roomList, true, null);
    }

    function find_room_votes($room_id) {
        $user_id = $this->session->userdata('sid');

        if(empty($user_id)){
            $this->response_json(null,false,"Login Please");
        }

        $voteList = $this->vote_service->get_list_by_room_id($room_id,$user_id);
        $this->response_json($voteList,true,null);
    }

    function return_vote_result($sid) {
        $voteResult = $this->vote_service->vote_result($sid);
        $voteResult['voted'] = true;
        $this->response_json($voteResult,true,null);
    }

    function voting() {
        $request = json_decode(file_get_contents('php://input'),true);
        $contents_number = $request['contents_number'];
        $vote_id = $request['vote_id'];

        // 해당하는 시퀀스 아이디를 찾지 못한 경우
        $vote = $this->vote_service->get_vote($vote_id);
        if(empty($vote)){
            $this->response_json(null, false, "Could not find the corresponding simpoll");
        }

        /* test start */
        $userdata = array();
        $userdata['sid'] = 1;
        $userdata['name'] = "test";
        $userdata['nickname'] = "test";
        /* test end */
        // 로그인 한 경우에만 투표가 가능한 경우
        // $nickname = $this->session->userdata('nickname');
        // if($vote['part_auth'] == 0 && empty($nickname)){
        //     $this->response_json(null, false, "Login Please");
        // }

        // 투표 실행
        // $userdata = $this->session->userdata();
        $result = $this->option_service->voting($vote, $contents_number, $userdata);

        // 투표 성공
        if($result){
            $this->response_json(null, true, "Simpoll complete");
            // 투표 실패
        }else{
            $this->response_json(null, false, "Simpoll is not complete");
        }
    }

    function response_json($data, $isSucceed, $message){
        $res = array();

        // success
        if($isSucceed){
            $res['result'] = 'success';
            $res['data'] = $data;
            $res['message'] = $message;

        // fail
        }else{
            $res['result'] = 'fail';
            $res['message'] = $message;
        }

        echo json_encode($res);
        exit;
    }

    function user(){
        if(empty($this->session->userdata('nickname'))){
            $this->response_json(null, false, "Login Please");
        }

        $user = array();
        $user['nickname'] = $this->session->userdata('nickname');
        $user['email'] = $this->session->userdata('email');
        $user['sid'] = $this->session->userdata('sid');
        $user['name'] = $this->session->userdata('name');
        $this->response_json($user, true, null);
    }
}
?>
