<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('_debug')){
        /**
         * Debug output HTML for array
         * @param  array        $array_data (array debug)
         * @return output HTML  Output to client
         * @author chientran <tran.duc.chien@kloon.vn>
         */
        function _debug($array_data = array()){
            echo '<pre>';
            print_r($array_data);
            echo '</pre>';
        }
    }

    if (!function_exists('write_log')){
        /**
         * Write log to file
         *
         * @param string $error_message : Log Message
         * @author chientran@vietnambiz.com
         */
        function write_log($error_message = '', $type = 'api'){
            /* Log path */
            $root_path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_FILENAME'];
            $root_path = dirname($root_path);
            $log_path  = APPPATH . 'logs/';
            $log_name  = 'log-'.date('Y-m-d', time()) . '_'.$type.'.php';
            $log_file  = $log_path . $log_name;

            $data = '';

            /* Create file if haven't exist */
            if (!file_exists($log_file)){
                $data .= "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>".PHP_EOL;
                $file_handler = @fopen($log_file, 'w');
                @fclose($file_handler);
            }

            /* Data for write to file */
            $current_time = gmdate('Y/m/d H:i:s', time());
            $data .= $current_time . ' : ';
            $data .= $error_message;
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $data .= ' _ Remote IP '.$_SERVER['REMOTE_ADDR'];
            }

            # Router log
            $CI = get_instance();
            #$data .= ' _ '.$CI->router->fetch_module().'/'.$CI->router->class.'/'.$CI->router->method;
            $data .= ' _ '.$CI->router->class.'/'.$CI->router->method;

            $data .= PHP_EOL;

            /* Write data to file */
            @file_put_contents($log_file, $data, FILE_APPEND);
        }
    }