<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Debug extends CI_Controller {
    private $userList = array(
        array('email'=>'email1@email.com','name'=>'name1','nickname'=>'nickname1','password'=>'pw1','sid'=>'1'),
        array('email'=>'email2@email.com','name'=>'name2','nickname'=>'nickname2','password'=>'pw2','sid'=>'2'),
        array('email'=>'email3@email.com','name'=>'name3','nickname'=>'nickname3','password'=>'pw3','sid'=>'3'),
        array('email'=>'email4@email.com','name'=>'name4','nickname'=>'nickname4','password'=>'pw4','sid'=>'4'),
        array('email'=>'email5@email.com','name'=>'name5','nickname'=>'nickname5','password'=>'pw5','sid'=>'5')
    );

    private $roomList = array(
        array('url_name'=>'url1','title'=>'title1','master'=>'1','master_nickname'=>'nickname1','user_name_type'=>'0','poll_create_auth'=>'0','sid'=>'1','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url2','title'=>'title2','master'=>'2','master_nickname'=>'nickname2','user_name_type'=>'0','poll_create_auth'=>'0','sid'=>'2','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url3','title'=>'title3','master'=>'3','master_nickname'=>'nickname3','user_name_type'=>'0','poll_create_auth'=>'0','sid'=>'3','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url4','title'=>'title4','master'=>'4','master_nickname'=>'nickname4','user_name_type'=>'0','poll_create_auth'=>'0','sid'=>'4','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url5','title'=>'title5','master'=>'5','master_nickname'=>'nickname5','user_name_type'=>'0','poll_create_auth'=>'0','sid'=>'5','part_num'=>'0','status'=>'0')
    );

    private $simpollList = array(
        array('room_id'=>'1','title'=>'simpoll1','url_name'=>'url1','user_id'=>'1','user_nickname'=>'nickname1','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'1'),
        array('room_id'=>'1','title'=>'simpoll2','url_name'=>'url2','user_id'=>'2','user_nickname'=>'nickname2','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'1','part_auth'=>'0','sid'=>'2'),
        array('room_id'=>'3','title'=>'simpoll3','url_name'=>'url3','user_id'=>'3','user_nickname'=>'nickname3','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'1','part_auth'=>'1','sid'=>'3'),
        array('room_id'=>'4','title'=>'simpoll4','url_name'=>'url4','user_id'=>'4','user_nickname'=>'nickname4','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'1','sid'=>'4'),
        array('room_id'=>'5','title'=>'simpoll5','url_name'=>'url5','user_id'=>'5','user_nickname'=>'nickname5','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'5')
    );

    private $questionList = array(
        array('simpoll_id'=>'1','title'=>'simpoll1','choice_no'=>'4','question_type'=>'0','sid'=>'1'),
        array('simpoll_id'=>'1','title'=>'simpoll2','choice_no'=>'3','question_type'=>'0','sid'=>'2'),
        array('simpoll_id'=>'1','title'=>'simpoll3','choice_no'=>'4','question_type'=>'0','sid'=>'3'),
        array('simpoll_id'=>'1','title'=>'simpoll4','choice_no'=>'4','question_type'=>'0','sid'=>'4'),
        array('simpoll_id'=>'1','title'=>'simpoll5','choice_no'=>'3','question_type'=>'0','sid'=>'5'),
        array('simpoll_id'=>'2','title'=>'simpoll1','choice_no'=>'3','question_type'=>'0','sid'=>'6'),
        array('simpoll_id'=>'2','title'=>'simpoll2','choice_no'=>'3','question_type'=>'0','sid'=>'7'),
        array('simpoll_id'=>'2','title'=>'simpoll3','choice_no'=>'3','question_type'=>'0','sid'=>'8'),
        array('simpoll_id'=>'2','title'=>'simpoll4','choice_no'=>'2','question_type'=>'0','sid'=>'9'),
        array('simpoll_id'=>'2','title'=>'simpoll5','choice_no'=>'2','question_type'=>'0','sid'=>'10')
    );

    private $optionList = array(
        array('user_id'=>'1|2','user_nickname'=>'nickname1|nickname2','question_id'=>'1','name'=>'A','sid'=>'1'),
        array('user_id'=>'2|3','user_nickname'=>'nickname2|nickname3','question_id'=>'1','name'=>'B','sid'=>'2'),
        array('user_id'=>'3|2','user_nickname'=>'nickname3|nickname2','question_id'=>'1','name'=>'C','sid'=>'3'),
        array('user_id'=>'4|2','user_nickname'=>'nickname4|nickname2','question_id'=>'1','name'=>'D','sid'=>'4'),
        array('user_id'=>'5|2','user_nickname'=>'nickname5|nickname2','question_id'=>'2','name'=>'A','sid'=>'5'),
        array('user_id'=>'1|2','user_nickname'=>'nickname1|nickname2','question_id'=>'2','name'=>'B','sid'=>'6'),
        array('user_id'=>'1|2','user_nickname'=>'nickname1|nickname2','question_id'=>'2','name'=>'C','sid'=>'7')
    );


    function __construct(){
        parent::__construct();
        $this->load->model('dao/option_model');
        $this->load->model('dao/user_model');
        $this->load->model('dao/room_model');
        $this->load->model('dao/simpoll_model');
        $this->load->model('dao/question_model');
        $this->load->model('service/user_service');
        $this->load->model('service/room_service');
        $this->load->model('service/simpoll_service');
        $this->load->model('service/question_service');
        $this->load->model('service/option_service');
        $this->load->library('unit_test');
        $this->load->database();
    }

    function index(){
        $this->db->trans_start(TRUE);
        $this->_init();
        echo $this->unit->run($this->user_model->count(),count($this->userList),"user insert test");
        echo $this->unit->run($this->room_model->count(),count($this->roomList),"room insert test");
        echo $this->unit->run($this->simpoll_model->count(),count($this->simpollList),"simpoll insert test");
        echo $this->unit->run($this->question_model->count(),count($this->questionList),"question insert test");
        echo $this->unit->run($this->option_model->count(),count($this->optionList),"option insert test");
        $this->db->trans_complete();
    }

    function usermodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->compareUser($this->user_model->selectOneById(1), $this->userList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->user_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectOneByEmailAndPW
        echo $this->unit->run($this->compareUser($this->user_model->selectOneByEmailAndPW("email1@email.com","pw1"), $this->userList[0]), true, "selectOneByEmailAndPW Test");

        // selectListByRoomId
        echo $this->unit->run($this->compareUser($this->user_model->selectListByRoomId('1')[0], $this->userList[4]), true, "selectListByRoomId Test");
        echo $this->unit->run(count($this->user_model->selectListByRoomId('1')), 5, "selectListByRoomId Test");
        echo $this->unit->run(empty($this->user_model->selectListByRoomId(100)), true, "selectListByRoomId Test");   // no result: empty array

        // updateOne
        $user = array('email'=>'update@email.com','name'=>'update3','nickname'=>'update3','password'=>'update','sid'=>3);
        echo $this->unit->run($this->user_model->updateOne($user), true, "updateOne Test");
        echo $this->unit->run($this->compareUser($this->user_model->selectOneById(3), $user), true, "updateOne Test");
        $user = array('email'=>'email3@email.com','name'=>'name3','nickname'=>'nickname3','password'=>'pw3','sid'=>300);
        echo $this->unit->run($this->user_model->updateOne($user), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");
        $this->db->trans_complete();
    }

    function roommodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->compareRoom($this->room_model->selectOneById(1), $this->roomList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->room_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectOneByUrl
        echo $this->unit->run($this->compareRoom($this->room_model->selectOneByUrl("url3"), $this->roomList[2]), true, "selectOneByUrl Test");
        echo $this->unit->run($this->room_model->selectOneByUrl("wrong url"), null, "selectOneByUrl Test");   // no result

        // selectOneByRoomIdAndUserId
        echo $this->unit->run(empty($this->room_model->selectOneByRoomIdAndUserId(1,3)), false, "selectOneByRoomIdAndUserId Test");
        echo $this->unit->run(empty($this->room_model->selectOneByRoomIdAndUserId(1,100)), true, "selectOneByRoomIdAndUserId Test");   // no result

        // selectListByMaster
        echo $this->unit->run(count($this->room_model->selectListByMaster(1)),1,"selectListByMaster Test");
        echo $this->unit->run($this->compareRoom($this->room_model->selectListByMaster(1)[0],$this->roomList[0]),true,"selectListByMaster Test");

        // selectListByUserId
        echo $this->unit->run(count($this->room_model->selectListByUserId(5)), 5, "selectListByUserId Test");
        echo $this->unit->run($this->compareRoom($this->room_model->selectListByUserId(1)[0],$this->roomList[4]),true,"selectListByUserId Test");
        echo $this->unit->run(empty($this->room_model->selectListByUserId(6)), true, "selectListByUserId Test");   // no result

        // updateOne
        $room = array('url_name'=>'update1','title'=>'update1','master'=>'1','master_nickname'=>'nickname1','user_name_type'=>'0','poll_create_auth'=>'0','sid'=>'1','part_num'=>'0','status'=>'0');
        echo $this->unit->run($this->room_model->updateOne($room),true, "updateOne Test");
        echo $this->unit->run($this->compareRoom($this->room_model->selectOneById(1), $room), true, "updateOne Test");
        $room['sid'] = '1000';
        echo $this->unit->run($this->room_model->updateOne($room), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");


        $this->db->trans_complete();
    }

    function simpollmodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->comparesimpoll($this->simpoll_model->selectOneById(1), $this->simpollList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->simpoll_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectOneByUrl
        echo $this->unit->run($this->comparesimpoll($this->simpoll_model->selectOneByUrl("url4"), $this->simpollList[3]), true, "selectOneByUrl Test");
        echo $this->unit->run($this->simpoll_model->selectOneByUrl("wrong url"), null, "selectOneByUrl Test");   // no result

        // selectListByRoomId
        echo $this->unit->run(count($this->simpoll_model->selectListByRoomId(5)), 1, "selectListByRoomId Test");
        echo $this->unit->run($this->comparesimpoll($this->simpoll_model->selectListByRoomId(3)[0],$this->simpollList[2]), true, "selectListByRoomId Test");

        // updateOne
        $simpoll = array('room_id'=>'4','title'=>'simpoll4','url_name'=>'url4','user_id'=>'4','user_nickname'=>'nickname4','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'4');
        echo $this->unit->run($this->simpoll_model->updateOne($simpoll),true, "updateOne Test");
        echo $this->unit->run($this->comparesimpoll($this->simpoll_model->selectOneById(4), $simpoll), true, "updateOne Test");
        $simpoll['sid'] = '1000';
        echo $this->unit->run($this->simpoll_model->updateOne($simpoll), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");

        // deleteOne
        $this->simpoll_model->deleteOne('3');
        echo $this->unit->run($this->simpoll_model->selectOneById('3'),null,"deleteOne test");

        // selectListWithVoteByRoomId
        $simpollWithQuestion = $this->simpoll_model->selectListWithQuestionByRoomId('1');
        echo "<h3>selectListWithSimpollByRoomId Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>simpoll_id</th><th>room_id</th><th>simpoll_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>question_id</th><th>question_title</th>";
        echo "<th>question_choice_no</th><th>question_type</th>";
        echo "</tr>";
        for($i=0;$i<count($simpollWithQuestion);$i++){
            echo "<tr>";
            echo "<td>".$simpollWithQuestion[$i]['simpoll_id']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['room_id']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['simpoll_title']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['url_name']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['user_id']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['user_nickname']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['deadline']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['is_comment_enable']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['is_anonymous']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['part_auth']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['question_id']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['question_title']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['question_choice_no']."</td>";
            echo "<td>".$simpollWithQuestion[$i]['question_type']."</td>";
            echo "</tr>";
        }
        echo "</table>";

        // selectListWithVoteAndChoiceByRoomIdAndUserId
        $simpollWithQuestionAndOption = $this->simpoll_model->selectListWithQuestionAndOptionByRoomIdAndQuestionId('1','1');
        echo "<h3>selectListWithVoteAndChoiceByRoomIdAndQuestionId Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>room_id</th><th>simpoll_id</th><th>simpoll_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>question_id</th><th>question_title</th>";
        echo "<th>question_type</th><th>option_id</th><th>option_name</th><th>option_user_id</th><th>option_user_nickname</th>";
        echo "</tr>";
        for($i=0;$i<count($simpollWithQuestionAndOption);$i++){
            echo "<tr>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['room_id']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['simpoll_id']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['simpoll_title']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['url_name']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['user_id']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['user_nickname']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['deadline']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['is_comment_enable']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['is_anonymous']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['part_auth']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['question_id']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['question_title']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['question_type']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['option_id']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['option_name']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['option_user_id']."</td>";
            echo "<td>".$simpollWithQuestionAndOption[$i]['option_user_nickname']."</td>";
            echo "</tr>";
        }
        echo "</table>";

        $this->db->trans_complete();
    }

    function questionmodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->compareQuestion($this->question_model->selectOneById(1), $this->questionList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->question_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectListBysimpollId
        echo $this->unit->run(count($this->question_model->selectListBySimpollId(1)), 5, "selectListBySimpollId Test");
        echo $this->unit->run(count($this->question_model->selectListBySimpollId(3)), 0, "selectListBySimpollId Test");
        echo $this->unit->run($this->compareQuestion($this->question_model->selectListBySimpollId(1)[1],$this->questionList[1]), true, "selectListBySimpollId Test");

        // updateOne
        $question = array('simpoll_id'=>'1','title'=>'question50','choice_no'=>'3','question_type'=>'0','sid'=>'5');
        echo $this->unit->run($this->question_model->updateOne($question),true, "updateOne Test");
        echo $this->unit->run($this->compareQuestion($this->question_model->selectOneById(5), $question), true, "updateOne Test");
        $question['sid'] = '1000';
        echo $this->unit->run($this->question_model->updateOne($question), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");

        $this->db->trans_complete();
    }

    function optionmodel(){
        $this->db->trans_start(TRUE);

        $this->option_model->deleteAll();
        echo $this->unit->run($this->option_model->count(),0,"deleteAll Test");

        $option = array('user_id'=>"",'user_nickname'=>"",'question_id'=>"1",'name'=>"option1",'sid'=>'12');
        $this->option_model->insertOneForTest($option);
        echo $this->unit->run($this->option_model->count(),1,"insertOne Test");

        $this->db->trans_complete();
    }

    function userservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // signup
        $user = array('email'=>'email50@email.com','name'=>'name50','nickname'=>'nickname50','password'=>'pw50');
        $this->user_service->signup($user);
        echo $this->unit->run($this->user_model->count(), 6, "signup Test");

        // login
        echo $this->unit->run($this->compareUser($this->user_service->login('email50@email.com','pw50'),$user), true, "login Test");

        // findAudiencesInRoom
        echo $this->unit->run(count($this->user_service->findAudiencesInRoom('1')), 5, "findAudiencesInRoom Test");
        echo $this->unit->run(count($this->user_service->findAudiencesInRoom('1')), 5, "findAudiencesInRoom Test");
        $this->db->trans_complete();
    }

    function roomservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // register
        $user = array('email'=>'email6@email.com','name'=>'name6','nickname'=>'nickname6','password'=>'pw6','sid'=>6);
        $this->user_model->insertOneForTest($user);
        $room = array('url_name'=>'url100','title'=>'title100','master'=>'6','master_nickname'=>'nickname6','user_name_type'=>'0','poll_create_auth'=>'0');
        $this->room_service->register($room);
        $roomList = $this->room_service->getMasterRoomList(6);
        echo $this->unit->run(count($roomList), 1, "register Test");
        echo $this->unit->run($roomList[0]['part_num'], "1", "register Test");
        $room_id = $roomList[0]['sid'];

        // getRoomUserByRoomIdAndUserId
        echo $this->unit->run(empty($this->room_service->getRoomUserByRoomIdAndUserId($room_id,5)),true, "getRoomUserByRoomIdAndUserId Test");

        // addAudience2Room
        for($i=1;$i<=5;$i++){
            $this->room_service->addAudience2Room($room_id,$i);
        }

        // getRoomUserByRoomIdAndUserId
        echo $this->unit->run(empty($this->room_service->getRoomUserByRoomIdAndUserId($room_id,5)),false, "getRoomUserByRoomIdAndUserId Test");

        $roomList = $this->room_service->getAudienceRoomList(1);
        echo count($roomList);
        echo $this->unit->run(count($roomList), 6, "addAudience2Room Test");
        $roomList = $this->room_service->getMasterRoomList(6);
        echo $this->unit->run($roomList[0]['part_num'], 6, "addAudience2Room Test");

        // getRoomByUrl
        echo $this->unit->run($this->compareRoom($this->room_service->getRoomByUrl("url100"),$room), true, "getRoomByUrl Test");
        echo $this->unit->run($this->room_service->getRoomByUrl("wrong url"), null, "getRoomByUrl Test");

        // deleteRoom
        $this->room_service->deleteRoom($room_id);
        $roomList = $this->room_service->getMasterRoomList(6);
        echo $this->unit->run(count($roomList), 0, "deleteRoom Test");

        $this->db->trans_complete();
    }

    function simpollservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // register
        $simpoll = array('room_id'=>'1','title'=>'simpoll13','url_name'=>'url500','user_id'=>'5','user_nickname'=>'nickname5','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'5');
        $simpoll_id = $this->simpoll_service->register($simpoll);
        echo $this->unit->run($this->simpoll_model->count(),count($this->simpollList)+1,"register Test");

        // getsimpollById
        echo $this->unit->run($this->compareSimpoll($this->simpoll_service->getSimpollById($simpoll_id),$simpoll),true,"getSimpollById Test");

        // getSimpollByUrl
        echo $this->unit->run($this->compareSimpoll($this->simpoll_service->getSimpollByUrl('url500'),$simpoll),true,"getSimpollByUrl Test");

        // deleteSimpoll
        $this->simpoll_service->deleteSimpoll($simpoll_id);
        echo $this->unit->run($this->simpoll_service->getSimpollById($simpoll_id),null,"deleteSimpoll Test");

        // getSimpollByUrlListWithVotedListByRoomIdAndUserId
        $simpollWithQuestionList = $this->simpoll_service->getSimpollListWithQuestionListByRoomIdAndQuestionId('1','1');
        echo "<h3>selectListWithQuestionAndOptionByRoomIdAndQuestionId Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>room_id</th><th>simpoll_id</th><th>simpoll_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>question_id</th><th>question_title</th>";
        echo "<th>question_type</th><th>option_id</th><th>option_name</th><th>option_user_id</th><th>option_user_nickname</th>";
        echo "</tr>";
        for($i=0;$i<count($simpollWithQuestionList);$i++){
            echo "<tr>";
            echo "<td>".$simpollWithQuestionList[$i]['room_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['simpoll_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['simpoll_title']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['url_name']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['user_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['user_nickname']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['deadline']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['is_comment_enable']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['is_anonymous']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['part_auth']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_title']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_type']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['option_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['option_name']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['option_user_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['option_user_nickname']."</td>";
        }
        echo "</table>";


        // getsimpollListWithVoteListByRoomId
        $simpollWithQuestionList = $this->simpoll_service->getsimpollListWithQuestionListByRoomId('1');
        echo "<h3>selectListWithSimpollByRoomId Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>simpoll_id</th><th>room_id</th><th>simpoll_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>question_id</th><th>question_title</th>";
        echo "<th>question_choice_no</th><th>question_type</th>";
        echo "</tr>";
        for($i=0;$i<count($simpollWithQuestionList);$i++){
            echo "<tr>";
            echo "<td>".$simpollWithQuestionList[$i]['simpoll_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['room_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['simpoll_title']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['url_name']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['user_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['user_nickname']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['deadline']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['is_comment_enable']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['is_anonymous']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['part_auth']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_id']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_title']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_choice_no']."</td>";
            echo "<td>".$simpollWithQuestionList[$i]['question_type']."</td>";
            echo "</tr>";
        }
        echo "</table>";


        $this->db->trans_complete();
    }

    function questionservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // register
        $question = array('simpoll_id'=>'1','title'=>'vote2','choice_no'=>'4','question_type'=>'0');
        $this->question_service->register($question);
        $list = $this->question_service->getQuestionListBySimpollId(1);
        echo $this->unit->run(count($list), 6, "register Test");

        // getQuestionById
        $question_id = $list[count($list)-1]['sid'];
        echo $this->unit->run($this->compareQuestion($this->question_service->getQuestionById($question_id),$question), true, "getQuestionById Test");

        // updateQuestion
        $question['sid'] = $question_id;
        $question['title'] = "update title";
        $this->question_service->updateQuestion($question);
        echo $this->unit->run($this->question_service->getQuestionById($question_id)['title'], "update title", "updateQuestion Test");

        // deleteQuestion
        $this->question_service->deleteQuestion($question_id);
        echo $this->unit->run($this->question_service->getQuestionById($question_id), null, "deleteQuestion Test");

        $this->db->trans_complete();
    }

    function optionservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        $user = array('email'=>'email500@email.com','name'=>'name500','nickname'=>'nickname500','password'=>'pw500');
        $this->user_model->insertOne($user);
        $user = $this->user_model->selectOneByEmailAndPW("email500@email.com","pw500");

        $vote1 = array('simpoll_id'=>'1','title'=>'vote2','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'101');
        $vote2 = array('simpoll_id'=>'2','title'=>'vote3','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'102');
        $vote3 = array('simpoll_id'=>'3','title'=>'vote4','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'103');
        $vote4 = array('simpoll_id'=>'4','title'=>'vote5','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'104');
        $this->vote_model->insertOneForTest($vote1);
        $this->vote_model->insertOneForTest($vote2);
        $this->vote_model->insertOneForTest($vote3);
        $this->vote_model->insertOneForTest($vote4);

        // getChoiceById
        $choice = $this->choice_service->getChoiceById(1);
        echo $this->unit->run($this->compareChoice($choice,$this->choiceList[0]),true,"getChoiceById Test");

        // voting - is_anonymous:0, part_auth:0
        $choice = array('user_id'=>$user['sid'],'vote_id'=>'101','choice_no'=>'1');
        $this->choice_service->voting($choice);
        echo $this->unit->run($this->choice_model->count(),count($this->choiceList)+1, "voting Test");
        $choice = $this->choice_service->getChoiceByVoteIdAndUserId('101',$user['sid']);
        echo $this->unit->run($this->compareChoice($choice, array('user_id'=>$user['sid'],'user_nickname'=>'name500','vote_id'=>'101','choice_no'=>'1')), true, "voting Test");
        echo $this->unit->run(empty($this->room_model->selectOneByRoomIdAndUserId('1', $user['sid'])),false,"voting Test");

        // voting - is_anonymous:1, part_auth:0
        $choice = array('user_id'=>$user['sid'],'vote_id'=>'102','choice_no'=>'1','user');
        $this->choice_service->voting($choice);
        echo $this->unit->run($this->choice_model->count(),count($this->choiceList)+2, "voting Test");
        $choice = $this->choice_service->getChoiceByVoteIdAndUserId('102',$user['sid']);
        echo $this->unit->run($this->compareChoice($choice, array('user_id'=>$user['sid'],'user_nickname'=>'nickname500','vote_id'=>'102','choice_no'=>'1')), true, "voting Test");
        echo $this->unit->run(empty($this->room_model->selectOneByRoomIdAndUserId('1', $user['sid'])),false,"voting Test");

        // voting - is_anonymous:1, part_auth:1
        $choice = array('user_id'=>$user['sid'],'vote_id'=>'103','choice_no'=>'1');
        $this->choice_service->voting($choice);
        echo $this->unit->run($this->choice_model->count(),count($this->choiceList)+3, "voting Test");
        $choice = $this->choice_service->getChoiceByVoteIdAndUserId('103',$user['sid']);
        echo $this->unit->run($this->compareChoice($choice, array('user_id'=>$user['sid'],'user_nickname'=>'nickname500','vote_id'=>'103','choice_no'=>'1')), true, "voting Test");
        echo $this->unit->run(empty($this->room_model->selectOneByRoomIdAndUserId('3', $user['sid'])),false,"voting Test");

        // voting - is_anonymous:1, part_auth:1 with unlogin user
        $choice = array('vote_id'=>'103','choice_no'=>'1');
        $this->choice_service->voting($choice);
        echo $this->unit->run($this->choice_model->count(),count($this->choiceList)+4, "voting Test");

        // voting - is_anonymous:0, part_auth:1 unable situation
        $choice = array('user_id'=>$user['sid'],'vote_id'=>'104','choice_no'=>'1');
        $this->choice_service->voting($choice);
        echo $this->unit->run($this->choice_model->count(),count($this->choiceList)+4, "voting Test");
        $choice = $this->choice_service->getChoiceByVoteIdAndUserId('104',$user['sid']);
        echo $this->unit->run(empty($choice), true, "voting Test");
        echo $this->unit->run(empty($this->room_model->selectOneByRoomIdAndUserId('4', $user['sid'])),true,"voting Test");

        // getVoteResult
        $vote = array('simpoll_id'=>'1','title'=>'vote1','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'1');
        echo $this->unit->run($this->compareVoteResult($this->choice_service->getVoteResult($vote),
                array('label'=>["choice1","choice2","choice3","choice4"],'data'=>[2,1,2,2],'part_num'=>'5')),true,"getVoteResult Test");

        // updateChoice
        $choice = $this->choice_service->getChoiceByVoteIdAndUserId('101',$user['sid']);
        $choice['choice_no'] = '3';
        $this->choice_service->updateChoice($choice);
        $choice = $this->choice_service->getChoiceByVoteIdAndUserId('101',$user['sid']);
        $this->unit->run($choice['choice_no'],3,"updateChoice Test");

        // deleteChoice
        $choice = $this->choice_service->deleteChoice($choice['sid']);
        $this->unit->run(empty($this->choice_service->getChoiceByVoteIdAndUserId('101',$user['sid'])),true,"deleteChoice Test");

        // getParticipant
        $participant = $this->choice_service->getParticipant($vote);
        echo "<h3>getParticipant Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>#</th>";
        echo "<th>participant</th>";
        echo "</tr>";
        for($i=0;$i<count($participant);$i++){
            echo "<tr>";
            echo "<td>";
            echo ($i+1);
            echo "</td>";
            echo "<td>";
            for($j=0;$j<count($participant[$i]);$j++){
                echo $participant[$i][$j];
                echo " ";
            }
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";

        $this->db->trans_complete();
    }

    function _init(){
        $this->option_model->deleteAll();
        $this->question_model->deleteAll();
        $this->simpoll_model->deleteAll();
        $this->room_model->deleteAll();
        $this->user_model->deleteAll();

        foreach($this->userList as $user)
            $this->user_model->insertOneForTest($user);
        foreach($this->roomList as $room)
            $this->room_model->insertOneForTest($room);
        foreach($this->simpollList as $simpoll)
            $this->simpoll_model->insertOneForTest($simpoll);
        foreach($this->questionList as $question)
            $this->question_model->insertOneForTest($question);
        foreach($this->optionList as $option)
            $this->option_model->insertOneForTest($option);
        for($i=1;$i<=5;$i++){
            for($j=1;$j<=5;$j++){
                if($i == $j)
                    $this->room_model->insertUser2Room($i, $j, 1);
                else
                    $this->room_model->insertUser2Room($i, $j, 2);
            }
        }
    }

    function compareUser($user1, $user2){
        if($user1['email']==$user2['email'] && $user1['name']==$user2['name'] && $user1['nickname']==$user2['nickname'])
            return true;
        else
            return false;
    }

    function compareRoom($room1, $room2){
        if($room1['title']==$room2['title'] && $room1['url_name']==$room2['url_name'] && $room1['master']==$room2['master']
                && $room1['master_nickname']==$room2['master_nickname'] && $room1['poll_create_auth']==$room2['poll_create_auth']
                && $room1['user_name_type']==$room2['user_name_type'])
            return true;
        else
            return false;
    }

    function compareSimpoll($simpoll1, $simpoll2){
        if($simpoll1['room_id']==$simpoll2['room_id'] && $simpoll1['title']==$simpoll2['title'] && $simpoll1['url_name']==$simpoll2['url_name']
                && $simpoll1['user_id']==$simpoll2['user_id'] && $simpoll1['user_nickname']==$simpoll2['user_nickname'] && $simpoll1['deadline']==$simpoll2['deadline']
                && $simpoll1['is_comment_enable']==$simpoll2['is_comment_enable'] && $simpoll1['is_anonymous']==$simpoll2['is_anonymous'] && $simpoll1['part_auth']==$simpoll2['part_auth'] && $simpoll1['room_id']==$simpoll2['room_id'])
            return true;
        else
            return false;
    }

    function compareQuestion($question1, $question2){
        if($question1['simpoll_id']==$question2['simpoll_id'] && $question1['title']==$question2['title']
                 && $question1['question_type']==$question2['question_type'])
            return true;
        else
            return false;
    }


    function compareVoteResult($result1, $result2){
        if(count($result1['label'])!=count($result1['label']) || count($result1['data'])!=count($result1['data']) || $result1['part_num']!=$result1['part_num'])
            return false;

        for($i=0;$i<count($result1['label']);$i++){
            if($result1['label'] != $result2['label'])
                return false;
        }

        for($i=0;$i<count($result1['data']);$i++){
            if($result1['data'] != $result2['data'])
                return false;
        }

        return true;
    }

    function test($param){
        echo $param;
    }
}
?>
