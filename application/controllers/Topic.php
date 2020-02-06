<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topic extends CI_Controller {
    function __construct()
    {       
        parent::__construct();
        $this->load->database();
		$this->load->model('topic_model');
		
		$this->load->view('head');
        $topics = $this->topic_model->gets();
        $this->load->view('topic_list', array('topics'=>$topics));
    }
    function index(){        
        $this->load->view('main');
        $this->load->view('footer');
    }
    function get($id){        
        $topic = $this->topic_model->get($id);
        $this->load->view('get', array('topic'=>$topic));
        $this->load->view('footer');
    }
}
?>