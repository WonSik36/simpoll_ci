<?php

class Vote_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/vote_model');
    }

    function vote_result($sid) {
        $label = $this->vote_model->get_contents($sid);
        $label = explode ("|" , $label);
        $count = $this->vote_model->get_contents_number($sid);
        $contents = [];
        $data = [];

        if(empty($count)) {
            for($i=0;$i<count($label);$i++){
                $data[$i] = 0;
            }
        }else {
            $index = 0;
            $offset = 0;
            if((int)$count[0]['cn'] == 0){
                $index = 1;
                $offset = -1;
            }
            for($i = 1; $i <= count($label); $i++) {
                $index = $i-1-$offset;
                if($index<count($count)) {
                    if((int)$count[$index]['cn'] == $i) {
                        $data[$i-1] = (int)$count[$index]['count'];
                    }else {
                        $data[$i-1] = 0;
                        $offset++;
                    }
                }else {
                    $data[$i-1] = 0;
                }
            }
        }



/*
        $offset = 0;
        if((int)$count[0]['cn'] == 0)
        $offset = 1;
        for($i = 1; $i <= count($label); $i++) {
            if($i-1+$offset<count($count)){
                if((int)$count[$i-1+$offset]['cn'] == $i){
                    $data[$i-1] = (int)$count[$i+$offset-1]['count'];
                }else{
                    $data[$i-1] = 0;
                    $offset--;
                }
            }else{
                $data[$i-1] = 0;
                $offset--;
            }

        }
*/

        if(!empty($label)) {
            return array('result'=>"success", 'label'=>$label,'data'=>$data);
            //return $data;
        }
        else {
            return array('result'=>"fail", 'errormsg'=>'There are no vote in this room.');
            //return $data;
        }

    }

    function vote_register($vote) {
        $result = $this->vote_model->insert_vote($vote);
        return $result;
    }

    function searchVoteByUrl($url){
        return $this->vote_model->selectVoteByUrl($url);
    }
    function get_part_num($sid) {
        $part_num = $this->vote_model->get_part_num($sid);
        return $part_num;
    }

    function get_title($sid) {
        $title = $this->vote_model->get_title_deadline($sid);
        return $title['title'];
    }

    function get_contents($sid) {
        $contents = $this->vote_model->get_contents($sid);
        return $contents;
    }

    function get_deadline($sid) {
        $deadline = $this->vote_model->get_title_deadline($sid);
        return $deadline['deadline'];
    }

}
?>
