<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setlang {

    public function set_lang(){
        $CI =& get_instance();
        $default_lang = "en";
        $current_lang = $CI->session->userdata('lang');
        if(!$current_lang){
            $data = array('lang' => $default_lang);
            $CI->session->set_userdata($data);
            $CI->lang->load('english', 'english');
        }elseif($current_lang == 'es'){
            $CI->lang->load('spanish', 'spanish');
        }elseif($current_lang == "en"){
            $data = array('lang' => 'en');
            $CI->session->set_userdata($data);
            $CI->lang->load('english', 'english');
        }
    }
}

/* End of file Someclass.php */
