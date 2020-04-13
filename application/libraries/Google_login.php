<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "libraries/Social_login.php";

class Google_login extends Social_login {

    protected function _get_authorize_param() {
        
        $param = parent::_get_authorize_param();
        $param['access_type'] = "offline";
        $param['scope'] = "https://www.googleapis.com/auth/userinfo.profile";

        return $param;
    }

}
