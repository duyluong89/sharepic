<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    #----------- LINK HELPER -----------#
    /**
     * Get server base path
     * @return Ambiguous
     * @author Chien Tran <tran.duc.chien@kloon.vn>
     * @created 4 Nov 2013
     */
    function get_server_path(){
        return dirname($_SERVER["DOCUMENT_ROOT"] . $_SERVER['SCRIPT_NAME']).'/';
    }

    /**
     * Get link resources
     * @param  string  $resource  resource
     * @param  boolean $real_path get system real path
     * @param  int     $type      [description]
     * @return string             link to resource
     */
    function assets($resource = '', $type = NULL, $real_path = FALSE){
        $return = '';
        if ($real_path) {
            $root_path = dirname($_SERVER["DOCUMENT_ROOT"] . $_SERVER['SCRIPT_NAME']).'/';
        }
        else {
            switch ($type){
                case ASSET_TYPE_JS:
                    $return = base_url(ASSET_JS.$resource);
                    break;

                case ASSET_TYPE_CSS:
                    $return = base_url(ASSET_CSS.$resource);
                    break;

                default:
                    $return = base_url(ASSET.$resource);
                    break;
            }
        }

        return $return;
    }

    /**
     * Create reserved url
     * @param  string $key key for match url
     * @return string url
     * @author Chien Tran <tran.duc.chien@kloon.vn>
     * @created 4 Nov 2013
     */
    function create_url($key) {
        $CI =& get_instance();
        $CI->load->config('url_reserved');
        $url_reserved = $CI->config->item('url_reserved');
        return isset($url_reserved[$key]) ? base_url($url_reserved[$key]) : base_url($key);
    }

    /**
     * Get current url with params
     * @param  array  $add_param param add to current url
     * @return string Full url with params
     * @author Chien Tran <tran.duc.chien@kloon.vn>
     * @created 4 Nov 2013
     */
    function current_url_with_params($add_param = array()) {
        $CI =& get_instance();
        $CI->load->helper('url');
        $param = $_GET;
        $param = array_merge($param, $add_param);
        return current_url() . '?' . http_build_query($param);
    }
    #-----------// LINK HELPER -----------#

    /**
     * Get session login
     * @param string $return_boolean
     * @return boolean|Ambigous <NULL, unknown>
     * @created 4 Nov 2013
     */
    function session_login($return_boolean = true){
        if ($return_boolean){
            return isset($_SESSION[SESSION_AUTH]->id) ? true : false;
        } else {
            return isset($_SESSION[SESSION_AUTH]) ? $_SESSION[SESSION_AUTH] : NULL;
        }
    }

    /**
     * Create / Destroy session login
     * @param NULL|string $user_object
     * @return boolean
     * @author Chien Tran <tran.duc.chien@kloon.vn>
     * @created 4 Nov 2013
     */
    function session_holder($user_object = NULL){
        # CI instance
        $CI = get_instance();

        # Global server name
        $server_name = explode('.', $_SERVER["SERVER_NAME"]);
        if (is_array($server_name) && (count($server_name) >= 2)){
            $server_name = '.'.$server_name[count($server_name) - 2].'.'.$server_name[count($server_name) - 1];
        } else {
            $server_name = '/';
        }

        if (!is_null($user_object)){
            # Global cookie
            #$CI->input->set_cookie(array('name' => COOKIE_CROSS, 'value' => $user_object->first_name . '|' .$user_object->last_name . '|' . $user_object->display_name, 'expire' => '2629743', 'domain' => $server_name));

            $_SESSION[SESSION_AUTH] = $user_object;
            return true;
        } else {
            /* Remove cookie */
            #$CI->input->set_cookie(array('name' => COOKIE_AUTH, 'value' => NULL, 'expire' => ''));

             /* Remove global cookie */
            #$CI->input->set_cookie(array('name' => COOKIE_CROSS, 'value' => NULL, 'domain' => $server_name, 'expire' => ''));

            /* Destroy session */
            $_SESSION[SESSION_AUTH] = NULL;
            unset($_SESSION[SESSION_AUTH]);
            return false;
        }
    }

    function current_language($return_name = true) {
        $CI =& get_instance();
        $language = $CI->config->item('language');
        if ($return_name) {
            $all_language = $CI->config->item('language_array');
            if (isset($all_language[$language])) {
                return $all_language[$language];
            }
            return false;
        } else {
            return $language;
        }
    }
