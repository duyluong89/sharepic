<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ps extends MX_Controller {

    function __construct() {
        parent::__construct();
    }

    function index(){}

    function captcha() {
        $captcha_dir      = config_item('captcha_dir');
        $captcha_dir_real = get_server_path().$captcha_dir;
        if (is_dir($captcha_dir_real) == false){
            umask(0000);
            mkdir($captcha_dir_real, 0777, true);
        }

        $this->load->library('antispam');

        $configs = array(
            'img_path'   => $captcha_dir,
            'img_url'    => base_url() . $captcha_dir,
            'img_height' => '100',
            'img_width'  => '300',
            'bg_color'   => '#EEEEEE'
        );
        $captcha = $this->antispam->get_antispam_image($configs);

        # Captcha session
        $session_captcha = config_item('captcha_session');
        unset($_SESSION[$session_captcha]);
        $_SESSION[$session_captcha] = $captcha['word'];

        # Captcha path
        $flag         = true;
        $captcha_path = get_server_path().$captcha_dir.$captcha['time'].'.jpg';

        if (!file_exists($captcha_path)){
            $flag         = false;
            $captcha_path = get_server_path().'public/img/trans.gif';
        }

        # Captcha data for response
        $fp = fopen($captcha_path, 'rb');
        header("Content-Type: image/png");
        header("Content-Length: " . filesize($captcha_path));
        fpassthru($fp);

        # Remove image store
        if ($flag AND is_writeable($captcha_path)) {
            //unlink($captcha_path);
        }
    }
}
