<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geolocation {

    public function get_location(){
        $CI =& get_instance();
        //$ip = "24.238.119.122";
        $ip = $CI->input->ip_address();
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
		$CI->session->set_userdata($query);
        $CI->session->set_userdata('region', $query['region']);
        return json_encode($query);
    }
}

/* End of file Someclass.php */
