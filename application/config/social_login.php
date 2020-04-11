<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * SOCIAL Setting
 **/
$config['google_login']['client_id']        = "1096548991718-mqgotblmrrmn9fjlh4nv0dk694blr4sd.apps.googleusercontent.com";
$config['google_login']['client_secret']    = "_ctkPpYKNjhXsKLI4HTK3KCc";
$config['google_login']['redirect_uri']     = "http://summeri.dothome.co.kr/index.php/login/google";
$config['google_login']['authorize_url']    = "https://accounts.google.com/o/oauth2/auth";
$config['google_login']['token_url']        = "https://www.googleapis.com/oauth2/v4/token";
$config['google_login']['info_url']         = "https://www.googleapis.com/oauth2/v1/userinfo";
$config['google_login']['token_request_post'] = TRUE;
