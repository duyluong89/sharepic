<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Auth Controller
 * @author chientran <tran.duc.chien@kloon.vn>
 * @created 1 Nov 2013
 */
class Auth extends MY_Controller {
    public function __construct() {
        parent::__construct();

        # Language
        $this->load->language('auth');

        # Config
        $this->load->config('email_template');

        # Init API server
        $this->rest->initialize(array('server' => config_item('api_web')));
    }

    function login() {
        if (session_login()) {
            redirect(create_url('home'));
        }

        # Data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            # API
            $this->rest->initialize(array('server' => config_item('api_web')));
            $api_param = array(
                'username' => $username,
                'password' => $password
            );
            $api_result = $this->rest->post('web/auth/login', $api_param, 'json');
            $api_status = $this->rest->status();
            if ( ($api_status == REST_CODE_OK) AND (isset($api_result->status)) AND ($api_result->status == REST_STATUS_SUCCESS) ) {
                session_holder($api_result->info);
                redirect(create_url('home'));
            } else {
                $this->data['status'] = FALSE;
                $this->data['msg']    = $this->lang->line('auth_err_login_fail');
            }
        }

        # View
        $this->view   = 'auth/login';
        $this->layout = 'layouts/auth';
    }

    function forgot() {
        # Library
        $this->load->library('form_validation');

        # Helpers
        $this->load->library('encrypt');
        $this->load->helper('string');
        $this->load->helper('captcha');

        # POST process
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            # Post data
            $email   = $this->input->post('email');
            $captcha = $this->input->post('captcha');

            # Form validation
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required');
            if ($this->form_validation->run() === TRUE) {
                # Check captcha
                $this->load->helper('captcha');
                if (captcha_check($captcha)) {
                    $api_param = array(
                        'email'    => $email,
                    );
                    $api_result = $this->rest->post('web/auth/forgot_request', $api_param, 'json');
                    $api_status = $this->rest->status();
                    if ( (isset($api_result->status)) AND ($api_result->status == REST_STATUS_SUCCESS) ) {
                        # Generate link forgot
                        $link_forgot_param = array(
                            'email' => $email,
                            'hash'  => $this->encrypt->encode($email.'|'.time())
                        );
                        $link_forgot = create_url('forgot').'?'.http_build_query($link_forgot_param);

                        # Send email confirm forgot password
                        $api_param = array(
                            'to_email'         => $email,
                            'template'         => 'email_template_forgot_request',
                            'template_pattern' => json_encode(array('[USER]', '[LINK]')),
                            'template_replace' => json_encode(array($email, $link_forgot)),
                        );
                        $api_result = $this->rest->post('web/email/send', $api_param, 'json');
                        $api_status = $this->rest->status();

                        # Message for view
                        $this->data['status']   = TRUE;
                        $this->data['validate'] = TRUE;
                        if (isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS)) {
                            $this->data['msg']    = $this->lang->line('auth_msg_forgot_request');
                        } else {
                            write_log('Send mail error_Data: '.json_encode($api_param));
                        }

                        # Destroy captcha
                        captcha_destroy();
                    } else {
                        $this->data['status'] = false;
                        $this->data['msg']    = $this->lang->line('auth_err_forgot_validate');
                    }
                } else {
                    $this->data['status'] = false;
                    $this->data['msg']    = $this->lang->line('err_captcha_invalid');
                }
            } else {
                $this->data['status'] = false;
                $this->data['msg']    = validation_errors();
            }
        } else {
            $email = $this->input->get('email');
            $hash  = $this->input->get('hash');
            if ($email AND $hash) {
                $email = strtolower($email);
                $hash  = explode('|', $this->encrypt->decode($hash));
                if ( !empty($hash[0]) AND ($email === strtolower($hash[0])) ) {
                    # Get new password
                    $api_result = $this->rest->get('web/auth/generate_password', NULL, 'json');
                    $api_status = $this->rest->status();
                    if ( isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS) ) {
                        $flag = true;

                        # New password
                        $salt          = isset($api_result->salt) ? $api_result->salt : '';
                        $password      = isset($api_result->password) ? $api_result->password : '';
                        $hash_password = isset($api_result->hash_password) ? $api_result->hash_password : '';

                        # Update user's password
                        /*$api_param = array(
                            'email'    => $email,
                            'password' => $hash_password,
                            'salt'     => $salt
                        );
                        $api_result = $this->rest->put('web/user', $api_param, 'json');
                        $api_status = $this->rest->status();
                        if (isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS)) {}
                        else {
                            $flag = FALSE;
                        }*/

                        # Send email new password
                        if ($flag) {
                            $api_param = array(
                                'to_email'         => $email,
                                'template'         => 'email_template_forgot_success',
                                'template_pattern' => json_encode(array('[USER]', '[NEW_PASSWORD]')),
                                'template_replace' => json_encode(array($email, $new_password)),
                            );
                            $api_result = $this->rest->post('web/email/send_mail', $api_param, 'json');
                            $api_status = $this->rest->status();
                            if (isset($api_result->status) AND ($api_result->status == REST_STATUS_SUCCESS)) {
                                $this->data['status'] = TRUE;
                                $this->data['msg']    = $this->lang->line('auth_msg_forgot_request');
                            } else {
                                write_log('Send mail error_Data: '.json_encode($api_param));
                            }

                            $this->data['status'] = TRUE;
                            $this->data['msg']    = $this->lang->line('auth_msg_forgot_validate');
                        } else {
                            $this->data['status'] = FALSE;
                            $this->data['msg']    = $this->lang->line('auth_err_forgot_validate');
                        }
                    } else {
                        $this->data['status'] = TRUE;
                        $this->data['msg']    = $this->lang->line('auth_msg_forgot_validate');
                    }
                } else {
                    $this->data['status'] = FALSE;
                    $this->data['msg']    = $this->lang->line('auth_err_forgot_validate');
                }
            }
        }

        # View
        $this->view   = 'auth/forgot';
        $this->layout = 'layouts/auth';
    }

    function logout() {
        session_holder(NULL);
        redirect(create_url('login'));
    }

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

    function _captcha(){
        $this->load->helper('captcha');
        captcha_make();
    }
}