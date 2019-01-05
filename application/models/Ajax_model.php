<?php

    class Ajax_model extends CI_Model {

        function zip_city_lookup(){
        	$input_value = $this->input->post('input_value');
            $suggest_type = $this->input->post('suggest_type');
            if($suggest_type == 'zipcode'){
                $sql = "SELECT DISTINCT Zipcode, City, State
                        FROM zipcodes_small
                        WHERE Zipcode
                        LIKE '$input_value%'
                        AND LocationType !='NOT ACCEPTABLE'
                        AND State != 'HI'
                        AND State != 'VI'
                        AND State != 'PR'
                        AND State != 'GU'
                        AND State != 'AK'
                        ORDER BY Zipcode ASC";
            }elseif ($suggest_type == 'city') {
                $sql = "SELECT DISTINCT Zipcode, City, State
                        FROM zipcodes_small
                        WHERE City
                        LIKE '$input_value%'
                        AND LocationType !='NOT ACCEPTABLE'
                        AND State != 'HI'
                        AND State != 'VI'
                        AND State != 'PR'
                        AND State != 'GU'
                        AND State != 'AK'
                        ORDER BY City ASC";
            }
        	$suggestions = $this->db->query($sql);
        	if ($suggestions->num_rows() > 0){
        		foreach($suggestions->result() as $row){
        			$suggestions_result[] = $row;
        		}
        		return $suggestions_result;
        	}
        }

        function get_year_makes(){
            $input_value = $this->input->post('input_value');
            $sql = "SELECT DISTINCT make FROM carmakemodelyear WHERE year='$input_value' ORDER BY make ASC";
        	$options = $this->db->query($sql);
        	if ($options->num_rows() > 0){
        		foreach($options->result() as $row){
        			$options_result[] = $row;
        		}
        		return $options_result;
        	}
        }

        function get_car_models(){
            $input_value = $this->input->post('input_value');
            $year = $this->input->post('year');
            $sql = "SELECT DISTINCT model, size FROM carmakemodelyear WHERE make='$input_value' AND year='$year' ORDER BY model ASC";
        	$options = $this->db->query($sql);
        	if ($options->num_rows() > 0){
        		foreach($options->result() as $row){
        			$options_result[] = $row;
        		}
        		return $options_result;
        	}
        }

        function generate_calendar(){
            $month_value = $this->input->post('month_value');
            $year_value  = $this->input->post('year_value');
            $current_month = ($month_value === date('m'))? "&nbsp;": '<a href="{previous_url}" class="monthNav">&#10094;</span></a>';
            if($month_value == "12"){
                $year = date('Y') + 1 ."-";
    			$month = "01-";
            }else{
                $year = date('Y')."-";
    			$month = "0".date('m') + 1 ."-";
            }
            $prefs = array (
				'start_day'    => 'sunday',
				'show_next_prev'  => TRUE,
				'next_prev_url'   => '/ajax/calendar'
			);

            $prefs['template'] = array(
                'table_open'           => '<table class="calendar" width="50%">',
                'heading_previous_cell' => '<th>'.$current_month.'</th>',
                'heading_next_cell' => '<th><a href="{next_url}" class="monthNav">&#10095;</a></th>',
                'cal_cell_start_today' => '<td class="today">',
                'cal_cell_no_content_future' => '<span class="pickUpDay" data-mobileicon="trackerIconFour" data-fulldate="'.$year.$month.'{day}" data-currentstep="stepFour" data-nextstep="stepFive">{day}</span>'

            );
			$this->load->library('calendar', $prefs);
			echo $this->calendar->generate($year_value, $month_value);

		} // generate_calendar ends

        function store_generated_quote(){
            $quote_data = array(
                'quoteId' => $this->input->post('quoteId'),
                'originZip' => $this->input->post('originZip'),
                'originCity' => $this->input->post('originCity'),
                'destZip' => $this->input->post('destZip'),
                'destCity' => $this->input->post('destCity'),
                'carYear' => $this->input->post('carYear'),
                'carMake' => $this->input->post('carMake'),
                'carModel' => $this->input->post('carModel'),
                'carSize' => $this->input->post('carSize'),
                'pickUpDate' => $this->input->post('pickUpDate'),
                'pickUpFormattedDate' => $this->input->post('pickUpFormattedDate'),
                'transportType' => $this->input->post('transportType'),
                'carCondition' => $this->input->post('carCondition'),
                'convertible' => $this->input->post('convertible'),
                'modified' => $this->input->post('modified'),
                'distanceInMiles' => $this->input->post('distanceInMiles'),
                'pricePerDistance' => $this->input->post('pricePerDistance'),
                'pricePerSize' => $this->input->post('pricePerSize'),
                'standardTotal' => $this->input->post('standardTotal'),
                'priorityTotal' => $this->input->post('priorityTotal'),
                'expeditedTotal' => $this->input->post('expeditedTotal'),
                'publishedTotal' => $this->input->post('publishedTotal'),
                'usrEmail' => $this->input->post('usrEmail'),
                'usrName' => $this->input->post('usrName'),
                'usrPhone' => $this->input->post('usrPhone'),
                'ipAddress' => $this->session->query,
                'date_stamp' => date("Y-m-d")
            );
            if($this->session->userdata('quoteId') == $quote_data['quoteId']){
                $this->db->where('quoteId', $this->session->quoteId);
                $store_quote = $this->db->update('generated_quotes', $quote_data);
            }else{
                $store_quote = $this->db->insert('generated_quotes', $quote_data);
                $this->session->set_userdata('quoteId', $quote_data['quoteId']);
            }
            if($store_quote){
                if($this->config->item('enable_dialer')){
                    $split_name = explode(' ', $quote_data['usrName']);
                    $orig_city_state = explode(', ', $quote_data['originCity']);
                    $dest_city_state = explode(', ', $quote_data['destCity']);
                    $form_data = array(
                        "security_key" => "e7463fd2d410939f585a3e6b8a416274",
                        "campaign_id" => "127357",
                        "phone" => preg_replace('/\D+/', '', $quote_data['usrPhone']),
                        "extern_id" => "facebook/google",
                        "de_dupe" => "false",
                        "first_name" => $split_name[0],
                        "last_name" => $split_name[1],
                        "city" => $orig_city_state[0],
                        "state" => $orig_city_state[1],
                        "zip" => $quote_data['originZip'],
                        "aux_data1" => $dest_city_state[0],
                        "aux_data2" => $dest_city_state[1],
                        "aux_data3" => $quote_data['carYear'],
                        "aux_data4" => $quote_data['carMake'],
                        "aux_data5" => $quote_data['carModel'],
                        "aux_data6" => $quote_data['usrEmail']
                    );
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "http://api.phonefusion.com/VACD//ListLoader.php",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => http_build_query($form_data),
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded"
                        ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                }
                if($this->config->item('post_to_jtracker')){
                    $break_name = explode(' ', $this->input->post('usrName'));
                    $orig_city_state = explode(', ', $quote_data['originCity']);
                    $dest_city_state = explode(', ', $quote_data['destCity']);
                    if($this->input->post('transportType') == "OpenTransport"){
                        $ship_via_id = "1";
                    }else{
                        $ship_via_id = "2";
                    }
                    $jtracker_data = array(
                        "first_name" => $break_name[0],
                        "last_name" => $break_name[1],
                        "phone" => preg_replace('/\D+/', '', $quote_data['usrPhone']),
                        "email" => $this->input->post('usrEmail'),
                        "pickup_city" => $orig_city_state[0],
                        "pickup_state_code" => $orig_city_state[1],
                        "pickup_country_id" => "1",
                        "dropoff_city" => $dest_city_state[0],
                        "dropoff_state_code" => $dest_city_state[1],
                        "dropoff_country_id" => "1",
                        "estimated_ship_date" => $this->input->post('pickUpDate'),
                        "vehicle_runs" => ($this->input->post('carCondition')? "1": "0"),
                        "ship_via_id" => $ship_via_id,
                        "year1" => $this->input->post('carYear'),
                        "make1" => $this->input->post('carMake'),
                        "model1" => $this->input->post('carModel'),
                        "vehicle_type_id1" => "11",
                        "vehicle_type_other1" => "other",
                        "referrer" => "CarShippersOfAmerica.com",
                        "CSRFToken" => "122ea33342725fcb104690a35e5f572264f1b36c231b92a9598707c14ad7fe7c",
                        "broker_id" => "fd72d4a9153d9af676aa5d486fd3da77"
                    );
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://www.jtracker.com/lead_post.php",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 30,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => http_build_query($jtracker_data),
                        CURLOPT_HTTPHEADER => array(
                            "cache-control: no-cache",
                            "content-type: application/x-www-form-urlencoded"
                        ),
                    ));
                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);
                }
                if($this->config->item('post_to_itextblast')){
                    $email_template = json_encode($quote_data);
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['smtp_host'] = 'relay-hosting.secureserver.net';;
                    $config['smtp_port'] = 25;
                    $config['mailtype'] = 'text';
                    $this->email->initialize($config);
                    $this->email->from('support@carshippersofamerica.com', 'CarShippersOfAmerica.com');
                    $this->email->to('csoasupp@itextblast.com');
                    $this->email->reply_to('noreply@carshippersofamerica.com');
                    $this->email->subject('New Lead generated at carshippersofamerica.com');
                    $this->email->message($email_template);
                    $send_message = $this->email->send();
                }
                return $store_quote;
            }else{
                return FALSE;
            }
        }

        function save_my_quote(){
            $quote_data = array(
                'quoteId' => $this->input->post('quoteId'),
                'originZip' => $this->input->post('originZip'),
                'originCity' => $this->input->post('originCity'),
                'destZip' => $this->input->post('destZip'),
                'destCity' => $this->input->post('destCity'),
                'carYear' => $this->input->post('carYear'),
                'carMake' => $this->input->post('carMake'),
                'carModel' => $this->input->post('carModel'),
                'carSize' => $this->input->post('carSize'),
                'pickUpDate' => $this->input->post('pickUpDate'),
                'pickUpFormattedDate' => $this->input->post('pickUpFormattedDate'),
                'transportType' => $this->input->post('transportType'),
                'carCondition' => $this->input->post('carCondition'),
                'convertible' => $this->input->post('convertible'),
                'modified' => $this->input->post('modified'),
                'distanceInMiles' => $this->input->post('distanceInMiles'),
                'pricePerDistance' => $this->input->post('pricePerDistance'),
                'pricePerSize' => $this->input->post('pricePerSize'),
                'standardTotal' => $this->input->post('standardTotal'),
                'priorityTotal' => $this->input->post('priorityTotal'),
                'expeditedTotal' => $this->input->post('expeditedTotal'),
                'publishedTotal' => $this->input->post('publishedTotal'),
                'usrEmail' => $this->input->post('usrEmail'),
                'usrName' => $this->input->post('usrName'),
                'usrPhone' => $this->input->post('usrPhone'),
                'savedByUser' => 1,
                'ipAddress' => $this->session->query,
                'date_stamp' => date("Y-m-d")
            );
            $quote_id = $quote_data['quoteId'];
            $sql = "SELECT * FROM saved_quotes WHERE quoteId='$quote_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $this->db->where('quoteId', $quote_id);
                $save_quote = $this->db->update('saved_quotes', $quote_data);
            }else{
                $save_quote = $this->db->insert('saved_quotes', $quote_data);
            }
            if($save_quote){
                return $save_quote;
            }else{
                return FALSE;
            }
        }

        function get_saved_quote_details(){
            $quote_id = $this->session->quoteId;
            $sql = "SELECT * FROM saved_quotes WHERE quoteId='$quote_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
               $row = $query->row_array();
               return $row;
            }else {
    			return false;
    		}
        }

        function generate_lead(){
            $quote_data = array(
                'quoteId' => $this->input->post('quoteId'),
                'originZip' => $this->input->post('originZip'),
                'originCity' => $this->input->post('originCity'),
                'destZip' => $this->input->post('destZip'),
                'destCity' => $this->input->post('destCity'),
                'carYear' => $this->input->post('carYear'),
                'carMake' => $this->input->post('carMake'),
                'carModel' => $this->input->post('carModel'),
                'carSize' => $this->input->post('carSize'),
                'pickUpDate' => $this->input->post('pickUpDate'),
                'pickUpFormattedDate' => $this->input->post('pickUpFormattedDate'),
                'transportType' => $this->input->post('transportType'),
                'carCondition' => $this->input->post('carCondition'),
                'convertible' => $this->input->post('convertible'),
                'modified' => $this->input->post('modified'),
                'distanceInMiles' => $this->input->post('distanceInMiles'),
                'pricePerDistance' => $this->input->post('pricePerDistance'),
                'pricePerSize' => $this->input->post('pricePerSize'),
                'standardTotal' => $this->input->post('standardTotal'),
                'priorityTotal' => $this->input->post('priorityTotal'),
                'expeditedTotal' => $this->input->post('expeditedTotal'),
                'publishedTotal' => $this->input->post('publishedTotal'),
                'usrEmail' => $this->input->post('usrEmail'),
                'usrName' => $this->input->post('usrName'),
                'usrPhone' => $this->input->post('usrPhone'),
                'savedByUser' => 1,
                'ipAddress' => $this->session->query,
                'date_stamp' => date("Y-m-d")
            );
            $quote_id = $quote_data['quoteId'];
            $sql = "SELECT * FROM generated_leads WHERE quoteId='$quote_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $this->db->where('quoteId', $quote_id);
                $save_lead = $this->db->update('generated_leads', $quote_data);
            }else{
                $save_lead = $this->db->insert('generated_leads', $quote_data);
            }
            if($save_lead){
                return $save_lead;
            }else{
                return FALSE;
            }
        }

        function get_lead_details(){
            $quote_id = $this->session->quoteId;
            $sql = "SELECT * FROM generated_leads WHERE quoteId='$quote_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
               $row = $query->row_array();
               return $row;
            }else {
			       return false;
    		  }
        }

    }

?>
