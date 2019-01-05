<?php

    class Pages_model extends CI_Model {

        function get_quote_details(){
            if($this->session->quoteId != null){
                $quote_id = $this->session->quoteId;
            }elseif($this->uri->segment(2) != null){ // might need to create another method for segment 3
                $quote_id = $this->uri->segment(2);
            }else{
                $quote_id = $this->uri->segment(3);
            }
            $sql = "SELECT * FROM generated_quotes WHERE quoteId='$quote_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
               $row = $query->row_array();
               return $row;
            }else {
    			return false;
    		}
        }

        function retrieve_quote_details(){
            if($this->input->post('quoteId')){
                $quote_id = $this->input->post('quoteId');
            }elseif($this->uri->segment(2)){
                $quote_id = $this->uri->segment(2);
            }else{
                $quote_id = null;
            }
            $sql = "SELECT * FROM saved_quotes WHERE quoteId='$quote_id'"; // might have to create another method for saved_quotes table
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
               $row = $query->row_array();
               return $row;
            }else {
    			return false;
    		}
        }

        function retrieve_booking_details(){
            if($this->input->post('bookingId')){
                $booking_id = $this->input->post('bookingId');
            }elseif($this->uri->segment(2)){
                $booking_id = $this->uri->segment(2);
            }
            if($booking_id){
                $row_id = explode("-", $booking_id);
                $sql = "SELECT * FROM bookings WHERE id='$row_id[1]'";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0){
                   $row = $query->row_array();
                   return $row;
                }else {
        			return false;
        		}
            }else{
                return FALSE;
            }

        }

        function book_service(){

            if($this->config->item('uship_sandbox')){
                $token_endpoint = "https://apistaging.uship.com/oauth/token_authenticated";
                $client_id = "egbeyn74pqqem3btfwa7gh6h";
                $client_secret = "K8QQQsTBFB";
            }else{
                $token_endpoint = "https://api.uship.com/oauth/token_authenticated";
                $client_id = "bfy9uskmbgb77ev22qfdj7br"; // for listinga production endpoint
                $client_secret = "8PtjP9EWWM"; // for listinga production endpoint
            }
            $curl_token = curl_init();
            curl_setopt_array($curl_token, array(
                CURLOPT_URL => $token_endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "username=carshippersofamerica%40gmail.com&password=C%40R%241pp3r%24&client_id=".$client_id."&client_secret=".$client_secret."&grant_type=password",
                CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded")
            ));
            $response = curl_exec($curl_token);
            $err = curl_error($curl_token);
            curl_close($curl_token);
            if ($err) {
                echo "cURL Error #:" . $err;
                // handle error
            } else {
                $token_obj = json_decode($response);
                $access_token = $token_obj->access_token;
            }

            if($access_token){
                $format_pickup_date = str_replace("-","/", $this->input->post('pickUpDate'));
                $date = date_create($this->input->post('pickUpDate'));
                date_add($date, date_interval_create_from_date_string('7 days'));
                $seven_days_later = date_format($date, 'Y/m/d');
                $listing_body = array (
                    'title' => $this->input->post('carMake').' '.$this->input->post('carModel').' '.$this->input->post('carYear'),
                    'description' => 'Provide optional details about the vehicle listing.',
                    'status' => 'Saved',
                    'route' => array (
                        'items' => [
                            array (
                                'address' => array (
                                    'streetAddress' => $this->input->post('street_number').' '.$this->input->post('route'),
                                    'majorMunicipality' => $this->input->post('locality'),
                                    'postalCode' => $this->input->post('postal_code'),
                                    'stateProvince' => $this->input->post('administrative_area_level_1'),
                                    'country' => 'US',
                                    'latitude' => $this->input->post('origLat'),
                                    'longitude' => $this->input->post('origLng'),
                                    'type' => 'Residence'
                                ),
                                'timeFrame' => array (
                                    'earliestArrival' => $this->input->post('pickUpDate'),
                                    'latestArrival' => $this->input->post('pickUpDate'),
                                    'timeFrameType' => 'after'
                                )
                            ),
                            array (
                                'address' => array (
                                    'streetAddress' => $this->input->post('street_number2').' '.$this->input->post('route2'),
                                    'majorMunicipality' => $this->input->post('locality2'),
                                    'postalCode' => $this->input->post('postal_code2'),
                                    'stateProvince' => $this->input->post('administrative_area_level_12'),
                                    'country' => 'US',
                                    'latitude' => $this->input->post('destLat'),
                                    'longitude' => $this->input->post('destLng'),
                                    'type' => 'Residence'
                                ),
                                'timeFrame' => array (
                                    'earliestArrival' => $seven_days_later,
                                    'latestArrival' => $seven_days_later,
                                    'timeFrameType' => 'on'
                                )
                            )
                        ]
                    ),
                    'pricing' => array (
                        'namedPrice' => array (
                            'amount' => $this->input->post('publishedTotal'),
                            'currencyType' => 'USD'
                        )
                    ),
                    'items' => [
                        array (
                            'Title' => $this->input->post('carMake').' '.$this->input->post('carModel').' '.$this->input->post('carYear'),
                            'Description' => $this->input->post('carMake').' '.$this->input->post('carModel').' '.$this->input->post('carYear'),
                            'Commodity' => 'CarsLightTrucks',
                            'Year' => $this->input->post('carYear'),
                            'MakeName' => $this->input->post('carMake'),
                            'ModelName' => $this->input->post('carModel'),
                            'IsRunning' => $this->input->post('carCondition'),
                            'IsConvertible' => $this->input->post('convertible'),
                            'IsModified' => $this->input->post('modified')
                        )
                    ],
                    'serviceTypes' => array (
                        $this->input->post('transportType')
                    )
                );

                $listing_endpoint = $this->config->item('uship_sandbox')? "https://apistaging.uship.com/v2/listings": "https://api.uship.com/v2/listings";
                $curl_listing = curl_init();
                curl_setopt_array($curl_listing, array(
                    CURLOPT_URL => $listing_endpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($listing_body),
                    CURLOPT_HEADER => true,
                    CURLOPT_HTTPHEADER => array(
                        "accept: application/json",
                        "authorization: Bearer ".$access_token."",
                        "content-type: application/json",
                        "password: C@R$1pp3r$",
                        "username: carshippersofamerica@gmail.com"
                    ),
                ));
                $response = curl_exec($curl_listing);
                $http_code = curl_getinfo($curl_listing, CURLINFO_HTTP_CODE);
                if($http_code === 201){
                    function get_headers_from_curl_response($response){
                        $headers = array();
                        $arrRequests = explode("\r\n\r\n", $response);
                        for ($index = 0; $index < count($arrRequests) -1; $index++) {
                            foreach (explode("\r\n", $arrRequests[$index]) as $i => $line){
                                if ($i === 0){
                                    $headers[$index]['http_code'] = $line;
                                }else{
                                    list ($key, $value) = explode(': ', $line);
                                    $headers[$index][$key] = $value;
                                }
                            }
                        }
                        return $headers;
                    }
                    $headers = get_headers_from_curl_response($response);
                    $location_header = $headers[1]['Location'];

                    if($location_header){
                        $booking_data = array(
                            'listing_id' => $location_header,
                            'quote_id' => $this->input->post('quoteId'),
                            'full_orig_address' => $this->input->post('autocomplete'),
                            'orig_street_address' => $this->input->post('street_number'),
                            'orig_route' => $this->input->post('route'),
                            'orig_locality' => $this->input->post('locality'),
                            'orig_state' => $this->input->post('administrative_area_level_1'),
                            'orig_zip_code' => $this->input->post('postal_code'),
                            'orig_country' => $this->input->post('country'),
                            'full_dest_address' => $this->input->post('autocomplete2'),
                            'dest_street_address' => $this->input->post('street_number2'),
                            'dest_route' => $this->input->post('route2'),
                            'dest_locality' => $this->input->post('locality2'),
                            'dest_state' => $this->input->post('administrative_area_level_12'),
                            'dest_zip_code' => $this->input->post('postal_code2'),
                            'dest_country' => $this->input->post('country2'),
                            'estimated_mileage' => $this->input->post('estimatedMileage'),
                            'precise_mileage' => $this->input->post('preciseMileage'),
                            'car_year' => $this->input->post('carYear'),
                            'car_make' => $this->input->post('carMake'),
                            'car_model' => $this->input->post('carModel'),
                            'car_size' => $this->input->post('carSize'),
                            'requested_date' => $this->input->post('pickUpDate'),
                            'transport_type' => $this->input->post('transportType'),
                            'contact_name' => $this->input->post('usrName'),
                            'contact_phone' => $this->input->post('usrPhone'),
                            'contact_email' => $this->input->post('usrEmail'),
                            'card_holder_name' => $this->input->post('cardName'),
                            'card_nonce' => $this->input->post('nonce'),
                            'transaction_result' => $this->session->userdata('transaction_result'),
                            'transaction_id' => $this->input->post('transactionId'),
                            'transaction_status' => $this->input->post('transactionStatus'),
                            'base_fee' => $this->input->post('baseServiceFee'),
                            'price_per_size' => $this->input->post('pricePerSize'),
                            'car_condition' => $this->input->post('carCondition'),
                            'convertible' => $this->input->post('convertible'),
                            'modified' => $this->input->post('modified'),
                            'publishedTotal' => $this->input->post('publishedTotal'),
                            'service_total' => $this->input->post('serviceTotal'),
                            'service_type' => $this->input->post('serviceType'),
                            'date_stamp' => date("Y-m-d")
                        );

                        $create_booking = $this->db->insert('bookings', $booking_data);
                        if($create_booking){
                            return $create_booking;
                        }else{
                            return FALSE;
                        }
                    }
                }
                curl_close ($curl_listing);
            }
            unset($_POST);
        }

        function get_booking_details(){
            $transaction_id = $this->session->userdata('transaction_id');
            $sql = "SELECT * FROM bookings WHERE transaction_id='$transaction_id'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
               $row = $query->row_array();
               return $row;
            }else {
    			return false;
    		}
        }

        function status(){
            $service_id = "0-0";
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $service_id = $this->input->post('bookingId');
            }elseif($this->uri->segment(2, 0)){
                $service_id = $this->uri->segment(2, 0);
            }
            $break_id = explode("-", $service_id);
            $sql = "SELECT listing_id FROM bookings WHERE id='$break_id[1]' LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
               $row = $query->row_array();
               $listing_url = $row['listing_id'];
               if($this->config->item('uship_sandbox')){
                   $token_endpoint = "https://apistaging.uship.com/oauth/token_authenticated";
                   $client_id = "egbeyn74pqqem3btfwa7gh6h";
                   $client_secret = "K8QQQsTBFB";
               }else{
                   $token_endpoint = "https://api.uship.com/oauth/token_authenticated";
                   $client_id = "bfy9uskmbgb77ev22qfdj7br"; // for listinga production endpoint
                   $client_secret = "8PtjP9EWWM"; // for listinga production endpoint
               }
               $curl_token = curl_init();
               curl_setopt_array($curl_token, array(
                   CURLOPT_URL => $token_endpoint,
                   CURLOPT_RETURNTRANSFER => true,
                   CURLOPT_ENCODING => "",
                   CURLOPT_MAXREDIRS => 10,
                   CURLOPT_TIMEOUT => 30,
                   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                   CURLOPT_CUSTOMREQUEST => "POST",
                   CURLOPT_POSTFIELDS => "username=carshippersofamerica%40gmail.com&password=C%40R%241pp3r%24&client_id=".$client_id."&client_secret=".$client_secret."&grant_type=password",
                   CURLOPT_HTTPHEADER => array("content-type: application/x-www-form-urlencoded")
               ));
               $response_token = curl_exec($curl_token);
               $err = curl_error($curl_token);
               curl_close($curl_token);
               if($err){
                   return "cURL Error #:" . $err;
               }else{
                   $token_obj = json_decode($response_token);
                   $access_token = $token_obj->access_token;
                   $curl_listing = curl_init();
                   curl_setopt_array($curl_listing, array(
                       CURLOPT_URL => $listing_url,
                       CURLOPT_RETURNTRANSFER => true,
                       CURLOPT_ENCODING => "",
                       CURLOPT_MAXREDIRS => 10,
                       CURLOPT_TIMEOUT => 30,
                       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                       CURLOPT_CUSTOMREQUEST => "GET",
                       CURLOPT_HTTPHEADER => array(
                           "accept: application/json",
                           "authorization: Bearer ".$access_token."",
                           "content-type: application/json",
                       ),
                   ));
                   $response_listing = curl_exec($curl_listing);
                   $err = curl_error($curl_listing);
                   curl_close($curl_listing);
                   if ($err) {
                       return "cURL Error #:" . $err;
                   } else {
                       return json_decode($response_listing);
                   }
               }
            }else {
    			return false;
    		}
        }

    }

?>
