<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('now')) {
    function now() {
        return date("Y-m-d H:i:s");
    }
}

if ( ! function_exists('empty_date')) {
    function empty_date() {
        return "1970-01-01 00:00:00";
    }
}


if ( ! function_exists('to_html')) {
    function to_html($str) {
        if($str !== null) {
            return nl2br(htmlspecialchars($str));
        }else {
            return "";
        }
    }
}

if ( ! function_exists('is_number')) {
    function is_number($str, $bAllowDecimals=true, $bAllowZero=true, $bAllowNeg=true) {
        if($bAllowDecimals)
            $regex = $bAllowZero?'[0-9]+(\.[0-9]+)?': '(^([0-9]*\.[0-9]*[1-9]+[0-9]*)$)|(^([0-9]*[1-9]+[0-9]*\.[0-9]+)$)|(^([1-9]+[0-9]*)$)';
        else
            $regex = $bAllowZero?'[0-9]+': '[1-9]+[0-9]*';

        return preg_match('#^'.($bAllowNeg?'\-?':'').$regex.'$#', $str);
    }
}


if ( ! function_exists('uuid')) {
    function uuid() {
        $hostid = hexdec(shell_exec("hostid"));
        $td = gettimeofday();
        return(md5($td['sec'].$td['usec'].getmypid().$hostid));
    }
}


if ( ! function_exists('get_url_content')) {
    function get_url_content($url, $timeout = 5) {
        $old = ini_set('default_socket_timeout', $timeout);
        $file = @fopen($url, 'r');

        $contents = "";
        if($file !== false) {
            ini_set('default_socket_timeout', $old);
            stream_set_timeout($file, $timeout);
            stream_set_blocking($file, 0);
            //the rest is standard
            while (!feof($file)) {
                $contents .= fread($file, 8192);
            }
        }

        return $contents;
    }
}


if ( ! function_exists('get_post_data')) {
    function get_post_data($field, $null_value = "") {
        $value = "";

        $CI = null;
        $CI =& get_instance();

        if($_POST){
            if($CI->input->post($field) !== ""){
                $value = $CI->input->post($field);
            }
        }else{
            $value = $null_value;
        }

        if($value !== ""){
            $value = $CI->db->escape_str($value);
        }

        return $value;

    }
}





if ( ! function_exists('debug')) {
    function debug($str = "") {
        if(is_object($str) || is_array($str)) {
            echo "<pre>";
            echo htmlspecialchars(print_r($str, true));
            echo "</pre>";
        }else {
            $str = to_html($str);
            echo $str;
        }
        echo "<hr>";
    }
}

if ( ! function_exists('debug_end')) {
    function debug_end($str = "") {
        debug($str);
        exit;
    }
}


if ( ! function_exists('debug_repeat_object')) {
    function debug_repeat_object($obj, $times) {
        $new_obj = array();
        for($i=1; $i<=$times; $i++) {
            $new_obj[] = $obj;
        }
        return $new_obj;
    }
}




if ( ! function_exists('autocomplete')) {
    function autocomplete(){
        error_reporting(E_ALL ^ E_NOTICE);

        $sys_lib = BASEPATH . '/libraries';
        $app_lib = APPPATH . '/libraries';
        $app_model = APPPATH . '/models';

        echo "&lt;?php<br><br>";
        echo "/**<br/>";
        echo '* @property CI_DB_active_record $db<br/>';
        echo '* @property CI_DB_forge $dbforge<br/>';

        if ($handle = opendir($sys_lib)) {
            /* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if($file[0] == '.') continue;
                $files = explode('.', $file);
                $file = $files[0];
                $file2 = $file;
                if($file == 'index') continue;
                if($file == 'Loader') $file2 = 'load';
                echo "* @property CI_" . $file . " $" . strtolower($file2) . "<br/>";

            }
            closedir($handle);
        }
        if ($handle = opendir($app_lib)) {
            /* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if($file[0] == '.') continue;
                $files = explode('.', $file);
                $file = $files[0];
                $file_parts = explode('_', $file);
                $first_part = $file_parts[0];
                if($first_part == 'index' || $first_part == 'MY') continue;
                if(count($file_parts) > 1){
                    $last_part = $file_parts[1];
                    echo "* @property " . ucfirst($first_part) . "_" . ucfirst($last_part) . " $" . strtolower($first_part) . "_" . strtolower($last_part) ."<br/>";
                }
                else{
                    echo "* @property " . ucfirst($first_part) . " $" . strtolower($first_part)."<br/>";
                }

            }
            closedir($handle);
        }
        if ($handle = opendir($app_model)) {
            /* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if($file[0] == '.') continue;
                $files = explode('.', $file);
                $file = $files[0];
                if($file == 'index') continue;

                $file_parts = explode("_", $file);

                $final_name = "";
                foreach($file_parts as $idx => $file_part){
                    if($idx == 0){
                        $final_name .= strtoupper(substr($file_part, 0, 2)) . strtolower(substr($file_part, 2));
                    }else{
                        $final_name .= "_" . ucfirst(strtolower($file_part));
                    }
                }

                echo "* @property " . $final_name . " $" . $final_name ."<br/>";

            }
            closedir($handle);
        }
        echo "*/<br><br>";
        echo "class Controller {}<br><br>";
        echo "class Model {}<br><br>";
        echo "?>";
    }
}



if ( ! function_exists('empty_to_null')) {
    function empty_to_null($str = ""){
        $value = null;
        return  ($str != "")?$str:$value;
    }
}



if ( ! function_exists('bool_to_int')) {
    function bool_to_int($str = false){
        return  ($str)?1:0;
    }
}



if ( ! function_exists('int_to_bool')) {
    function int_to_bool($str = 0){
        return  ($str == 0)?false:true;
    }
}


if ( ! function_exists('ceil_dec')) {
    function ceil_dec($number,$precision,$separator)
    {
        $numberpart=explode($separator,$number);
        if(count($numberpart) > 1){
            $numberpart[1]=substr_replace($numberpart[1],$separator,$precision,0);
            if($numberpart[0]>=0){
                $numberpart[1]=ceil($numberpart[1]);
            }
            else{
                $numberpart[1]=floor($numberpart[1]);
            }
        }else{
            $numberpart[1] = 0;
        }

        $ceil_number= array($numberpart[0],$numberpart[1]);
        return implode($separator,$ceil_number);
    }
}


if ( ! function_exists('count_of_not_null')) {
    function count_of_not_null($array)
    {
        $n = 0;
        foreach($array as $k => $v){
            if(!empty($v))
                $n ++;
        }
        return $n;
    }
}



if ( ! function_exists('array_filter')) {
    function array_filter($array)
    {
        foreach($array as $k => $v){
            if(empty($v))
                unset($array[$k]);
        }
        return $array;
    }
}

/*if(! function_exists('is_voted')){
}

/*
if ( ! function_exists('read_file')) {

}
*/