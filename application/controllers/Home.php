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
      $this->load->view('home',array('nickname'=>$this->session->userdata('nickname')));
    }
}
?>
