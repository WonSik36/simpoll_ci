<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('session');
    }

    function session(){
        $this->load->view('debug',array('debug'=>var_dump($this->session->all_userdata())));
    }

    function index(){
        $this->load->view('home');
    }

    function search(){
        $code = $this->input->get('code');
        $type = $this->input->get('type');

        $message;
        $location;

        if($type=="room"){
            $message = "해당하는 방으로 이동합니다.";
            
            if(is_numeric($code))
                $location = "/index.php/room/page/".$code;
            else
                $location = "/index.php/room/url/".$code;
        }else{
            $message = "해당하는 Simpoll로 이동합니다.";

            if(is_numeric($code))
                $location = "/index.php/group/page/".$code;
            else
                $location = "/index.php/group/url/".$code;
        }

        $this->load->view("result", array('message'=>$message, 'location'=>$location));
    }

    function dashboard(){
        $this->load->view("dashboard");
    }
}
?>
