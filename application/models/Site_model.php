<?php

    class Site_model extends CI_Model {

        function get_car_makes(){
            $sql = "SELECT make FROM makes";
            $query = $this->db->query($sql);
            if($query->num_rows() > 0){
        		foreach($query->result() as $row){
        			$data[] = $row;
        		}
        		return $data;
    		}else {
    			return false;
    		}
        }

        function even_odd(){
            $query = $this->db->query('SELECT id FROM ci_sessions');
            return $query->num_rows() % 2;
        }

    }

?>
