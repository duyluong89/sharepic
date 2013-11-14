<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',                            'rb');
define('FOPEN_READ_WRITE',                      'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',        'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',   'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',                    'ab');
define('FOPEN_READ_WRITE_CREATE',               'a+b');
define('FOPEN_WRITE_CREATE_STRICT',             'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',        'x+b');

define('ASSET'                                  , 'assets/');
define('ASSET_JS'                               , ASSET.'v3/js/');
define('ASSET_IMG'                              , ASSET.'v3/img/');
define('ASSET_CSS'                              , ASSET.'v3/css/');
define('ASSET_TYPE_JS'                          , 1);
define('ASSET_TYPE_CSS'                         , 2);
define('ASSET_TYPE_IMG'                         , 3);

define('REST_STATUS_SUCCESS'                    , 'ok');
define('REST_STATUS_FAIL'                       , 'fail');
define('REST_CODE_OK'                           , 200);
define('REST_CODE_PARAM_ERR'                    , 412);
define('REST_CODE_SERVER_ERR'                   , 500);

define('BOOL_YES'                               , 'yes');
define('BOOL_NO'                                , 'no');

define('SESSION_AUTH'                           , 'kloon_session_publicsolution');
define('COOKIE_AUTH'                            , 'kloon_cookie_publicsolution');
define('COOKIE_CROSS'                           , 'kloon_gcookie_publicsolution');


define('INFO_MESSAGE' 	, 1);
define('INFO_VOICE' 	, 2);
define('INFO_IMAGE' 	, 3);
define('INFO_VIDEO' 	, 4);

/* End of file constants.php */
/* Location: ./application/config/constants.php */