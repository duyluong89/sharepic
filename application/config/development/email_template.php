<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['email_template_forgot_request'] = array(
    'subject' => 'Forgot password - Public Solution',
    'message' => 'Dear [USER] ! This is your link forgot password : [LINK]',
);

$config['email_template_forgot_success'] = array(
    'subject' => 'New password - Public Solution',
    'message' => 'Dear [USER] ! This is your new password : [NEW_PASSWORD]',
);