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



    /*    $index = count($label);
        for($i = count($count); $i>0; $i--){
            if((int)$count[$i-1]['cn'] != $i){
                $count[$index]['cn'] = $count[$i-1]['cn'];
                $count[$index]['count'] = $count[$i-1]['count'];
                $count[$i-1]['cn'] = $i;
                $count[$i-1]['count'] = 0;
                $index--;
            }

        }
        for($i = 1; $i <= count($label); $i++) {
            $data[$i-1] = $count[$i-1]['count'];
        }
*/

        $index = 0;
        $offset = 0;
        if((int)$count[0]['cn'] == 0){
            $index = 1;
            $offset = -1;
        }
        for($i = 1; $i <= count($label); $i++){
            $index = $i-1-$offset;
            if($index<count($count)){
                if((int)$count[$index]['cn'] == $i){
                    $data[$i-1] = (int)$count[$index]['count'];
                }else {
                    $data[$i-1] = 0;
                    $offset++;
                }
            }else{
                $data[$i-1] = 0;
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

        if(!empty($label)){
            return array('result'=>"success", 'label'=>$label,'data'=>$data);
            //return $data;
        }
        else {
            return array('result'=>"fail", 'errormsg'=>'There are no vote in this room.');
            //return $data;
        }

    }

}
?>
