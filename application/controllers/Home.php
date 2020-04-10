<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library('session');
    }

    // deprecated
    function session(){
        $this->load->view('debug',array('debug'=>var_dump($this->session->all_userdata())));
    }

    function index(){
        $this->load->view('home');
    }

    function search(){
        $code = $this->input->get('code');

        $message = "해당하는 Simpoll로 이동합니다.";
        $location;

        if(is_numeric($code))
            $location = "/index.php/simpoll/id/".$code;
        else
            $location = "/index.php/simpoll/url/".$code;

        $this->load->view("result", array('message'=>$message, 'location'=>$location));
    }

    function dashboard(){
        $this->load->view("dashboard");
    }
}
?>
