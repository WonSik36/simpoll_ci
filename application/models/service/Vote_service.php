<?php

class Vote_service extends CI_Model {
    function __construct()
    {
        parent::__construct();
        $this->load->model('dao/vote_model');
    }
    
}
?>
