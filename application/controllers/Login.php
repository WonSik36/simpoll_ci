<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
    public function google()
    {
        $this->load->library("google_login");
        $result = $this->google_login->get_profile();

        print_r($result);
    }
}
?>
