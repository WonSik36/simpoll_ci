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
        array('url_name'=>'url1','title'=>'title1','master'=>'1','master_nickname'=>'nickname1','user_name_type'=>'0','vote_create_auth'=>'0','sid'=>'1','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url2','title'=>'title2','master'=>'2','master_nickname'=>'nickname2','user_name_type'=>'0','vote_create_auth'=>'0','sid'=>'2','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url3','title'=>'title3','master'=>'3','master_nickname'=>'nickname3','user_name_type'=>'0','vote_create_auth'=>'0','sid'=>'3','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url4','title'=>'title4','master'=>'4','master_nickname'=>'nickname4','user_name_type'=>'0','vote_create_auth'=>'0','sid'=>'4','part_num'=>'0','status'=>'0'),
        array('url_name'=>'url5','title'=>'title5','master'=>'5','master_nickname'=>'nickname5','user_name_type'=>'0','vote_create_auth'=>'0','sid'=>'5','part_num'=>'0','status'=>'0')
    );

    private $groupList = array(
        array('room_id'=>'1','title'=>'group1','url_name'=>'url1','user_id'=>'1','user_nickname'=>'nickname1','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'1'),
        array('room_id'=>'1','title'=>'group2','url_name'=>'url2','user_id'=>'2','user_nickname'=>'nickname2','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'1','part_auth'=>'0','sid'=>'2'),
        array('room_id'=>'3','title'=>'group3','url_name'=>'url3','user_id'=>'3','user_nickname'=>'nickname3','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'1','part_auth'=>'1','sid'=>'3'),
        array('room_id'=>'4','title'=>'group4','url_name'=>'url4','user_id'=>'4','user_nickname'=>'nickname4','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'1','sid'=>'4'),
        array('room_id'=>'5','title'=>'group5','url_name'=>'url5','user_id'=>'5','user_nickname'=>'nickname5','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'5')
    );

    private $voteList = array(
        array('group_id'=>'1','title'=>'vote1','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'1'),
        array('group_id'=>'1','title'=>'vote2','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'2'),
        array('group_id'=>'1','title'=>'vote3','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'3'),
        array('group_id'=>'1','title'=>'vote4','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'4'),
        array('group_id'=>'1','title'=>'vote5','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'5'),
        array('group_id'=>'2','title'=>'vote1','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'6'),
        array('group_id'=>'2','title'=>'vote2','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'7'),
        array('group_id'=>'2','title'=>'vote3','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'8'),
        array('group_id'=>'2','title'=>'vote4','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'9'),
        array('group_id'=>'2','title'=>'vote5','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'10')
    );

    private $choiceList = array(
        array('user_id'=>'1','user_nickname'=>'nickname1','vote_id'=>'1','choice_no'=>'1|3','sid'=>'1'),
        array('user_id'=>'2','user_nickname'=>'nickname2','vote_id'=>'1','choice_no'=>'2|4','sid'=>'2'),
        array('user_id'=>'3','user_nickname'=>'nickname3','vote_id'=>'1','choice_no'=>'3','sid'=>'3'),
        array('user_id'=>'4','user_nickname'=>'nickname4','vote_id'=>'1','choice_no'=>'4','sid'=>'4'),
        array('user_id'=>'5','user_nickname'=>'nickname5','vote_id'=>'1','choice_no'=>'1','sid'=>'5'),
        array('user_id'=>'1','user_nickname'=>'nickname1','vote_id'=>'2','choice_no'=>'1','sid'=>'6'),
        array('user_id'=>'1','user_nickname'=>'nickname1','vote_id'=>'6','choice_no'=>'1','sid'=>'7')
    );


    function __construct(){
        parent::__construct();
        $this->load->model('dao/choice_model');
        $this->load->model('dao/user_model');
        $this->load->model('dao/room_model');
        $this->load->model('dao/group_model');
        $this->load->model('dao/vote_model');
        $this->load->model('service/user_service');
        $this->load->model('service/room_service');
        $this->load->model('service/group_service');
        $this->load->model('service/vote_service');
        $this->load->model('service/choice_service');
        $this->load->library('unit_test');
        $this->load->database();
    }

    function index(){
        $this->db->trans_start(TRUE);
        $this->_init();
        echo $this->unit->run($this->user_model->count(),count($this->userList),"user insert test");
        echo $this->unit->run($this->room_model->count(),count($this->roomList),"room insert test");
        echo $this->unit->run($this->group_model->count(),count($this->groupList),"group insert test");
        echo $this->unit->run($this->vote_model->count(),count($this->voteList),"vote insert test");
        echo $this->unit->run($this->choice_model->count(),count($this->choiceList),"choice insert test");
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
        $room = array('url_name'=>'update1','title'=>'update1','master'=>'1','master_nickname'=>'nickname1','user_name_type'=>'0','vote_create_auth'=>'0','sid'=>'1','part_num'=>'0','status'=>'0');
        echo $this->unit->run($this->room_model->updateOne($room),true, "updateOne Test");
        echo $this->unit->run($this->compareRoom($this->room_model->selectOneById(1), $room), true, "updateOne Test");
        $room['sid'] = '1000';
        echo $this->unit->run($this->room_model->updateOne($room), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");


        $this->db->trans_complete();
    }

    function groupmodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->compareGroup($this->group_model->selectOneById(1), $this->groupList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->group_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectOneByUrl
        echo $this->unit->run($this->compareGroup($this->group_model->selectOneByUrl("url4"), $this->groupList[3]), true, "selectOneByUrl Test");
        echo $this->unit->run($this->group_model->selectOneByUrl("wrong url"), null, "selectOneByUrl Test");   // no result

        // selectListByRoomId
        echo $this->unit->run(count($this->group_model->selectListByRoomId(5)), 1, "selectListByRoomId Test");
        echo $this->unit->run($this->compareGroup($this->group_model->selectListByRoomId(3)[0],$this->groupList[2]), true, "selectListByRoomId Test");

        // updateOne
        $group = array('room_id'=>'4','title'=>'group4','url_name'=>'url4','user_id'=>'4','user_nickname'=>'nickname4','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'4');
        echo $this->unit->run($this->group_model->updateOne($group),true, "updateOne Test");
        echo $this->unit->run($this->compareGroup($this->group_model->selectOneById(4), $group), true, "updateOne Test");
        $group['sid'] = '1000';
        echo $this->unit->run($this->group_model->updateOne($group), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");

        // deleteOne
        $this->vote_model->deleteOne('3');
        echo $this->unit->run($this->vote_model->selectOneById('3'),null,"deleteOne test");

        // selectListWithVoteByRoomId
        $groupWithVote = $this->group_model->selectListWithVoteByRoomId('1');
        echo "<h3>selectListWithVoteByRoomId Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>group_id</th><th>room_id</th><th>group_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>vote_id</th><th>vote_title</th>";
        echo "<th>choices</th><th>vote_type</th>";
        echo "</tr>";
        for($i=0;$i<count($groupWithVote);$i++){
            echo "<tr>";
            echo "<td>".$groupWithVote[$i]['group_id']."</td>";
            echo "<td>".$groupWithVote[$i]['room_id']."</td>";
            echo "<td>".$groupWithVote[$i]['group_title']."</td>";
            echo "<td>".$groupWithVote[$i]['url_name']."</td>";
            echo "<td>".$groupWithVote[$i]['user_id']."</td>";
            echo "<td>".$groupWithVote[$i]['user_nickname']."</td>";
            echo "<td>".$groupWithVote[$i]['deadline']."</td>";
            echo "<td>".$groupWithVote[$i]['is_comment_enable']."</td>";
            echo "<td>".$groupWithVote[$i]['is_anonymous']."</td>";
            echo "<td>".$groupWithVote[$i]['part_auth']."</td>";
            echo "<td>".$groupWithVote[$i]['vote_id']."</td>";
            echo "<td>".$groupWithVote[$i]['vote_title']."</td>";
            echo "<td>".$groupWithVote[$i]['choices']."</td>";
            echo "<td>".$groupWithVote[$i]['vote_type']."</td>";
            echo "</tr>";
        }
        echo "</table>";

        // selectListWithVoteAndChoiceByRoomIdAndUserId
        $groupWithVoteAndChoice = $this->group_model->selectListWithVoteAndChoiceByRoomIdAndUserId('1','1');
        echo "<h3>selectListWithVoteAndChoiceByRoomIdAndUserId Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>group_id</th><th>room_id</th><th>group_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>vote_id</th><th>vote_title</th>";
        echo "<th>choices</th><th>vote_type</th>";
        echo "</tr>";
        for($i=0;$i<count($groupWithVoteAndChoice);$i++){
            echo "<tr>";
            echo "<td>".$groupWithVoteAndChoice[$i]['group_id']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['room_id']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['group_title']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['url_name']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['user_id']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['user_nickname']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['deadline']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['is_comment_enable']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['is_anonymous']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['part_auth']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['vote_id']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['vote_title']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['choices']."</td>";
            echo "<td>".$groupWithVoteAndChoice[$i]['vote_type']."</td>";
            echo "</tr>";
        }
        echo "</table>";

        $this->db->trans_complete();
    }

    function votemodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->compareVote($this->vote_model->selectOneById(1), $this->voteList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->vote_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectListByGroupId
        echo $this->unit->run(count($this->vote_model->selectListByGroupId(1)), 5, "selectListByGroupId Test");
        echo $this->unit->run(count($this->vote_model->selectListByGroupId(3)), 0, "selectListByGroupId Test");
        echo $this->unit->run($this->compareVote($this->vote_model->selectListByGroupId(1)[1],$this->voteList[1]), true, "selectListByGroupId Test");

        // updateOne
        $vote = array('group_id'=>'1','title'=>'vote50','choices'=>'choice1|choice2|choice3','vote_type'=>'0','sid'=>'5');
        echo $this->unit->run($this->vote_model->updateOne($vote),true, "updateOne Test");
        echo $this->unit->run($this->compareVote($this->vote_model->selectOneById(5), $vote), true, "updateOne Test");
        $vote['sid'] = '1000';
        echo $this->unit->run($this->vote_model->updateOne($vote), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");

        $this->db->trans_complete();
    }

    function choicemodel(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // selectOneById
        echo $this->unit->run($this->compareChoice($this->choice_model->selectOneById(1), $this->choiceList[0]), true, "selectOneById Test");
        echo $this->unit->run($this->choice_model->selectOneById(100), null, "selectOneById Test");   // no result

        // selectOneByVoteIdAndUserId
        echo $this->unit->run(empty($this->choice_model->selectOneByVoteIdAndUserId(1,3)), false, "selectOneByVoteIdAndUserId Test");
        echo $this->unit->run(empty($this->choice_model->selectOneByVoteIdAndUserId(10,1)), true, "selectOneByVoteIdAndUserId Test");

        // selectListByVoteId
        echo $this->unit->run(count($this->choice_model->selectListByVoteId(1)), 5, "selectListByVoteId Test");
        echo $this->unit->run(count($this->choice_model->selectListByVoteId(100)), 0, "selectListByVoteId Test");
        echo $this->unit->run($this->compareChoice($this->choice_model->selectListByVoteId(1)[0],$this->choiceList[4]), true, "selectListByVoteId Test");

        // selectListByUserId
        echo $this->unit->run(count($this->choice_model->selectListByUserId(1)), 3, "selectListByUserId Test");
        echo $this->unit->run($this->compareChoice($this->choice_model->selectListByUserId(1)[0],$this->choiceList[6]), true, "selectListByUserId Test");

        // updateOne
        $choice = array('user_id'=>'2','user_nickname'=>'nickname2','vote_id'=>'1','choice_no'=>'2','sid'=>'2');
        echo $this->unit->run($this->choice_model->updateOne($choice),true, "updateOne Test");
        echo $this->unit->run($this->compareChoice($this->choice_model->selectOneById(2), $choice), true, "updateOne Test");
        $choice['sid'] = '1000';
        echo $this->unit->run($this->choice_model->updateOne($choice), true, "updateOne Test"); // no affected rows return also true
        echo $this->unit->run($this->db->affected_rows(), 0, "updateOne Test");

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
        $room = array('url_name'=>'url100','title'=>'title100','master'=>'6','master_nickname'=>'nickname6','user_name_type'=>'0','vote_create_auth'=>'0');
        $this->room_service->register($room);
        $roomList = $this->room_service->getMasterRoomList(6);
        echo $this->unit->run(count($roomList), 1, "register Test");
        echo $this->unit->run($roomList[0]['part_num'], "1", "register Test");
        $room_id = $roomList[0]['sid'];

        // addAudience2Room
        for($i=1;$i<=5;$i++){
            $this->room_service->addAudience2Room($room_id,$i);
        }

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

    function groupservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // register
        $group = array('room_id'=>'1','title'=>'group13','url_name'=>'url500','user_id'=>'5','user_nickname'=>'nickname5','deadline'=>'2020-03-20 23:00:00','is_comment_enable'=>'0','is_anonymous'=>'0','part_auth'=>'0','sid'=>'5');
        $group_id = $this->group_service->register($group);
        echo $this->unit->run($this->group_model->count(),count($this->groupList)+1,"register Test");

        // getGroupById
        echo $this->unit->run($this->compareGroup($this->group_service->getGroupById($group_id),$group),true,"getGroupById Test");
        
        // getGroupByUrl
        echo $this->unit->run($this->compareGroup($this->group_service->getGroupByUrl('url500'),$group),true,"getGroupByUrl Test");

        // deleteGroup
        $this->group_service->deleteGroup($group_id);
        echo $this->unit->run($this->group_service->getGroupById($group_id),null,"deleteGroup Test");

        // getGroupListWithVotedList
        $groupWithVotedList = $this->group_service->getGroupListWithVotedList('1','1');
        echo "<h3>getGroupListWithVotedList Test</h3>";
        echo "<table>";
        echo "<tr>";
        echo "<th>group_id</th><th>room_id</th><th>group_title</th><th>url_name</th><th>user_id</th><th>user_nickname</th>";
        echo "<th>deadline</th><th>is_comment_enable</th><th>is_anonymous</th><th>part_auth</th><th>vote_id</th><th>vote_title</th>";
        echo "<th>choices</th><th>vote_type</th><th>voted</th>";
        echo "</tr>";
        for($i=0;$i<count($groupWithVotedList);$i++){
            echo "<tr>";
            echo "<td>".$groupWithVotedList[$i]['group_id']."</td>";
            echo "<td>".$groupWithVotedList[$i]['room_id']."</td>";
            echo "<td>".$groupWithVotedList[$i]['group_title']."</td>";
            echo "<td>".$groupWithVotedList[$i]['url_name']."</td>";
            echo "<td>".$groupWithVotedList[$i]['user_id']."</td>";
            echo "<td>".$groupWithVotedList[$i]['user_nickname']."</td>";
            echo "<td>".$groupWithVotedList[$i]['deadline']."</td>";
            echo "<td>".$groupWithVotedList[$i]['is_comment_enable']."</td>";
            echo "<td>".$groupWithVotedList[$i]['is_anonymous']."</td>";
            echo "<td>".$groupWithVotedList[$i]['part_auth']."</td>";
            echo "<td>".$groupWithVotedList[$i]['vote_id']."</td>";
            echo "<td>".$groupWithVotedList[$i]['vote_title']."</td>";
            echo "<td>".$groupWithVotedList[$i]['choices']."</td>";
            echo "<td>".$groupWithVotedList[$i]['vote_type']."</td>";
            if($groupWithVotedList[$i]['voted'])
                echo "<td>true</td>";
            else
                echo "<td>false</td>";
            echo "</tr>";
        }
        echo "</table>";


        $this->db->trans_complete();
    }

    function voteservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        // register
        $vote = array('group_id'=>'1','title'=>'vote2','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0');
        $this->vote_service->register($vote);
        $list = $this->vote_service->getVoteListByGroupId(1);
        echo $this->unit->run(count($list), 6, "register Test");

        // getVoteById
        $vote_id = $list[count($list)-1]['sid'];
        echo $this->unit->run($this->compareVote($this->vote_service->getVoteById($vote_id),$vote), true, "getVoteById Test");
        
        // updateVote
        $vote['sid'] = $vote_id;
        $vote['title'] = "update title";
        $this->vote_service->updateVote($vote);
        echo $this->unit->run($this->vote_service->getVoteById($vote_id)['title'], "update title", "updateVote Test");
        
        // deleteVote
        $this->vote_service->deleteVote($vote_id);
        echo $this->unit->run($this->vote_service->getVoteById($vote_id), null, "deleteVote Test");

        $this->db->trans_complete();
    }

    function choiceservice(){
        $this->db->trans_start(TRUE);
        $this->_init();

        $user = array('email'=>'email500@email.com','name'=>'name500','nickname'=>'nickname500','password'=>'pw500');
        $this->user_model->insertOne($user);
        $user = $this->user_model->selectOneByEmailAndPW("email500@email.com","pw500");

        $vote1 = array('group_id'=>'1','title'=>'vote2','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'101');
        $vote2 = array('group_id'=>'2','title'=>'vote3','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'102');
        $vote3 = array('group_id'=>'3','title'=>'vote4','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'103');
        $vote4 = array('group_id'=>'4','title'=>'vote5','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'104');
        $this->vote_model->insertOneForTest($vote1);
        $this->vote_model->insertOneForTest($vote2);
        $this->vote_model->insertOneForTest($vote3);
        $this->vote_model->insertOneForTest($vote4);

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
        $vote = array('group_id'=>'1','title'=>'vote1','choices'=>'choice1|choice2|choice3|choice4','vote_type'=>'0','sid'=>'1');
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

        $this->db->trans_complete();
    }

    function _init(){
        $this->choice_model->deleteAll();
        $this->vote_model->deleteAll();
        $this->group_model->deleteAll();
        $this->room_model->deleteAll();
        $this->user_model->deleteAll();

        foreach($this->userList as $user)
            $this->user_model->insertOneForTest($user);
        foreach($this->roomList as $room)
            $this->room_model->insertOneForTest($room);        
        foreach($this->groupList as $group)
            $this->group_model->insertOneForTest($group);
        foreach($this->voteList as $vote)
            $this->vote_model->insertOneForTest($vote);
        foreach($this->choiceList as $choice)
            $this->choice_model->insertOneForTest($choice);
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
                && $room1['master_nickname']==$room2['master_nickname'] && $room1['vote_create_auth']==$room2['vote_create_auth'] 
                && $room1['user_name_type']==$room2['user_name_type'])
            return true;
        else
            return false;
    }

    function compareGroup($group1, $group2){
        if($group1['room_id']==$group2['room_id'] && $group1['title']==$group2['title'] && $group1['url_name']==$group2['url_name']
                && $group1['user_id']==$group2['user_id'] && $group1['user_nickname']==$group2['user_nickname'] && $group1['deadline']==$group2['deadline'] 
                && $group1['is_comment_enable']==$group2['is_comment_enable'] && $group1['is_anonymous']==$group2['is_anonymous'] && $group1['part_auth']==$group2['part_auth'] && $group1['room_id']==$group2['room_id'])
            return true;
        else
            return false;
    }

    function compareVote($vote1, $vote2){
        if($vote1['group_id']==$vote2['group_id'] && $vote1['title']==$vote2['title'] 
                && $vote1['choices']==$vote2['choices'] && $vote1['vote_type']==$vote2['vote_type'])
            return true;
        else
            return false;
    }

    function compareChoice($choice1, $choice2){
        if($choice1['user_id']==$choice2['user_id'] && $choice1['user_nickname']==$choice2['user_nickname'] 
                && $choice1['vote_id']==$choice2['vote_id'] && $choice1['choice_no']==$choice2['choice_no'])
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
}
?>
