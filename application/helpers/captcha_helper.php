<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('captcha_destroy')){
        /**
         * Destroy captcha session
         * @return boolean
         * @author Chien Tran <tran.duc.chien@kloon.vn>
         * @created 5 Nov 2013
         */
        function captcha_destroy() {
            $session_captcha = config_item('captcha_session');
            if (isset($_SESSION[$session_captcha])) {
                unset($_SESSION[$session_captcha]);
            }
        }
    }

    if (!function_exists('captcha_check')){
        /**
         * Check captcha string
         * @param  string  $str character for check
         * @return boolean
         * @author Chien Tran <tran.duc.chien@kloon.vn>
         * @created 5 Nov 2013
         */
        function captcha_check($str, $incasitive = true) {
            $session_captcha = config_item('captcha_session');
            $session_captcha = isset($_SESSION[$session_captcha]) ? $_SESSION[$session_captcha] : NULL;

            if ($incasitive) {
                $session_captcha = strtolower($session_captcha);
                $str             = strtolower($str);
            }

            if ($session_captcha === $str) {
                return true;
            }
            return false;
        }
    }

    if (!function_exists('captcha_make')){
        /**
         * Make captcha image
         * @return Image
         * @author Chien Tran <tran.duc.chien@kloon.vn>
         * @created 5 Nov 2013
         */
        function captcha_make(){
            $CI =& get_instance();
            $captcha_dir      = config_item('captcha_dir');
            $captcha_dir_real = get_server_path().$captcha_dir;
            if (is_dir($captcha_dir_real) == false){
                umask(0000);
                mkdir($captcha_dir_real, 0777, true);
            }

            $CI->load->library('antispam');
            $configs = array(
                'img_path'   => $captcha_dir,
                'img_url'    => base_url() . $captcha_dir,
                'img_height' => '100',
                'img_width'  => '300',
                'bg_color'   => '#EEEEEE'
            );
            $captcha = $CI->antispam->get_antispam_image($configs);

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
            $CI->output->set_header("Content-Type: image/png");
            $CI->output->set_header("Content-Length: " . filesize($captcha_path));
            fpassthru($fp);

            # Remove image store
            if ($flag AND is_writeable($captcha_path)) {
                //unlink($captcha_path);
            }
        }
    }