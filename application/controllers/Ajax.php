<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Ajax extends CI_Controller {

        public function zip_city_lookup(){
            $this->load->model('ajax_model');
            $suggest_query = $this->ajax_model->zip_city_lookup();
            if($suggest_query){
                $suggestions = array();
                foreach($suggest_query as $suggest_query_row){
                    array_push($suggestions, $suggest_query_row);
                }
                echo json_encode($suggestions);
            }else{
                return FALSE;
            }
        }

        public function get_year_makes(){
            $this->load->model('ajax_model');
            $makes_query = $this->ajax_model->get_year_makes();
            if($makes_query){
                $options = array();
                foreach($makes_query as $makes_query_row){
                    array_push($options, $makes_query_row);
                }
                echo json_encode($makes_query);
            }else{
                return FALSE;
            }
        }

        public function get_car_models(){
            $this->load->model('ajax_model');
            $models_query = $this->ajax_model->get_car_models();
            if($models_query){
                $options = array();
                foreach($models_query as $models_query_row){
                    array_push($options, $models_query_row);
                }
                echo json_encode($models_query);
            }else{
                return FALSE;
            }
        }

        public function format_date(){
            $raw_date = $this->input->post('raw_date');
            echo date("l-F, d", strtotime($raw_date));
        }

        public function generate_calendar(){
            $this->load->model('ajax_model');
            $generate_calendar = $this->ajax_model->generate_calendar();
            echo $generate_calendar;
        }

        public function calculate_distance(){
            $orig = $this->input->post('orig');
            $dest = $this->input->post('dest');
            $url = "http://www.zipcodeapi.com/rest/uLSc09bXvQwq9RS7nJQ7MmTdwt3mfXWKIOXIX9GtZcT83Mgrv7yhurv1UynawjVf/distance.json/".$orig."/".$dest."/mile";
            $get_distance = file_get_contents($url);
            echo $get_distance;
        }

        public function store_generated_quote(){
            $this->load->model('ajax_model');
            $store_generated_quote = $this->ajax_model->store_generated_quote();
            if($store_generated_quote){
                $generate_lead = $this->ajax_model->generate_lead();
                if($generate_lead){
                    $created_lead = $this->ajax_model->get_lead_details();
                    $email_template = '
            			<html>
            				<head>
            					<title>New Lead Generated</title>
            				</head>
            				<body>
            					<table cellpadding="1" cellspacing="2" border="0" width="600">
            						<tr>
            							<td>Customer name</td>
                                        <td>'.$created_lead['usrName'].'</td>
            						</tr>
            						<tr>
            							<td>Customer email</td>
                                        <td>'.$created_lead['usrEmail'].'</td>
            						</tr>
                                    <tr>
            							<td>Customer phone number</td>
                                        <td>'.$created_lead['usrPhone'].'</td>
            						</tr>
                                    <tr>
            							<td>Quote Id</td>
                                        <td>'.$created_lead['quoteId'].'</td>
            						</tr>
            					</table>
            				</body>
            			</html>
            		';
                    $config['protocol'] = 'sendmail';
                    $config['mailpath'] = '/usr/sbin/sendmail';
                    $config['smtp_host'] = 'relay-hosting.secureserver.net';;
                    $config['smtp_port'] = 25;
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $this->email->from('support@carshippersofamerica.com', 'CarShippersOfAmerica.com');
                    $this->email->to('support@carshippersofamerica.com');
                    $this->email->reply_to('noreply@carshippersofamerica.com');
                    $this->email->subject('New Lead generated at carshippersofamerica.com');
                    $this->email->message($email_template);
                    $send_message = $this->email->send();
                    $this->email->clear(TRUE);
                }
                echo "success";
            }else{
                return FALSE;
            }
        }

        public function save_my_quote(){
            $this->load->model('ajax_model');
            $save_my_quote = $this->ajax_model->save_my_quote();
            if($save_my_quote){
                $saved_quote_details = $this->ajax_model->get_saved_quote_details();
                $email_template = $this->load->view('includes/saved_quote_email_view', array('saved_quote_details' => $saved_quote_details), TRUE);
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['smtp_host'] = 'relay-hosting.secureserver.net';;
                $config['smtp_port'] = 25;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from('support@carshippersofamerica.com', 'CarShippersOfAmerica.com');
                $this->email->to($saved_quote_details['usrEmail']);
                $this->email->bcc('support@carshippersofamerica.com');
                $this->email->reply_to('noreply@carshippersofamerica.com');
                $this->email->subject('Car shipping quote from Car Shippers Of America');
                $this->email->message($email_template);
                $send_message = $this->email->send();
                echo "success";
            }else{
                return FALSE;
            }
        }

        public function generate_lead(){
            $this->load->model('ajax_model');
            $generate_lead = $this->ajax_model->generate_lead();
            if($generate_lead){
                $created_lead = $this->ajax_model->get_lead_details();
                // $email_template = $this->load->view('includes/saved_quote_email_view', array('saved_quote_details' => $saved_quote_details), TRUE);
                $email_template = '
        			<html>
        				<head>
        					<title>New Lead Generated</title>
        				</head>
        				<body>
        					<table cellpadding="1" cellspacing="2" border="0" width="600">
        						<tr>
        							<td>Customer name</td>
                                    <td>'.$created_lead['usrName'].'</td>
        						</tr>
        						<tr>
        							<td>Customer email</td>
                                    <td>'.$created_lead['usrEmail'].'</td>
        						</tr>
                                <tr>
        							<td>Customer phone number</td>
                                    <td>'.$created_lead['usrPhone'].'</td>
        						</tr>
                                <tr>
        							<td>Quote Id</td>
                                    <td>'.$created_lead['quoteId'].'</td>
        						</tr>
        					</table>
        				</body>
        			</html>
        		';
                $config['protocol'] = 'sendmail';
                $config['mailpath'] = '/usr/sbin/sendmail';
                $config['smtp_host'] = 'relay-hosting.secureserver.net';;
                $config['smtp_port'] = 25;
                $config['mailtype'] = 'html';
                $this->email->initialize($config);
                $this->email->from('support@carshippersofamerica.com', 'CarShippersOfAmerica.com');
                $this->email->to('support@carshippersofamerica.com');
                $this->email->reply_to('noreply@carshippersofamerica.com');
                $this->email->subject('New Lead generated at carshippersofamerica.com');
                $this->email->message($email_template);
                $send_message = $this->email->send();
                echo "lead generated";
            }else{
                return FALSE;
            }
        }

        public function recaptcha(){
            $captchaResponse = $this->input->post('input_value');
            $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeQeBgUAAAAAAYycKdAZk8fiffmkoFPkh3SNgZM&response=".$captchaResponse."&remoteip=".$_SERVER['REMOTE_ADDR']);
            echo $verifyResponse;
        }

        public function user_message(){
            $customer_name = $this->input->post('Name');
            $customer_email = $this->input->post('Email');
            $message_subject = $this->input->post('Subject');
            $message_body = $this->input->post('Message');
            $email_template = '
    			<html>
    				<head>
    					<title>Message from customer</title>
    				</head>
    				<body>
    					<table cellpadding="1" cellspacing="2" border="0" width="600">
    						<tr>
    							<td>Customer name</td>
                                <td>'.$customer_name.'</td>
    						</tr>
    						<tr>
    							<td>Customer email</td>
                                <td>'.$customer_email.'</td>
    						</tr>
                            <tr>
    							<td>Message subject</td>
                                <td>'.$message_subject.'</td>
    						</tr>
                            <tr>
    							<td>Customer message</td>
                                <td>'.$message_body.'</td>
    						</tr>
    					</table>
    				</body>
    			</html>
    		';
            $config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['smtp_host'] = 'relay-hosting.secureserver.net';;
            $config['smtp_port'] = 25;
            $config['mailtype'] = 'html';
            $this->email->initialize($config);
            $this->email->from($customer_email);
            $this->email->to('support@carshippersofamerica.com');
            $this->email->reply_to('noreply@carshippersofamerica.com');
            $this->email->subject('New customer message');
            $this->email->message($email_template);
            $send_message = $this->email->send();
            // $this->email->clear();
            if($send_message){
                echo TRUE;
            }else{
                echo FALSE;
            }
        }

        public function authorize_card(){
            require 'vendor/autoload.php';
            //$location_id = '74DDBJRXK7THS'; // this id is linked to Juan's bank account
            if($this->config->item('square_sandbox') == TRUE){
                $location_id = 'CBASEFZhwPx_vw4aqb0WVF_pYeAgAQ'; // this is the sandbox id
        		$access_token = 'Bearer sandbox-sq0atb-vXpBqh1jTO5Mrb0aQ2v4_A';
            }elseif($this->config->item('square_sandbox') == FALSE){
                $location_id = '1HSWSG287X2CH'; // this id is linked to the company's bank account
        		$access_token = 'Bearer sq0atp-qyvPhtYrV9ShJgIOFRNQsw';
            }
    		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    			error_log("Received a non-POST request");
    			echo "Request not allowed";
    			//show_404();
    			http_response_code(404);
    			return;
    		}
    		$nonce = $_POST['nonce_value'];
    		if (is_null($nonce)) {
    			echo "Invalid card data";
    			http_response_code(422);
    			return;
    		}
    		$transaction_api = new \SquareConnect\Api\TransactionApi();
    		$request_body = array (
    			"card_nonce" => $nonce,
    			"amount_money" => array (
    				"amount" => $_POST['dollar_amount'] * 100,
                    //"amount" => 100,
    				"currency" => "USD"
    			),
                "delay_capture" => true, // change to false or remove to charge cards inmediately
    			"idempotency_key" => uniqid()
    		);
    		try {
                $response = array('transaction_status' => "", 'transaction_id' => "");
    			$result = $transaction_api->charge($access_token, $location_id, $request_body);
                $transaction_result = (array) $result['transaction'];
                $this->session->set_userdata("transaction_result", serialize($transaction_result)); // turn into plain text
                $transaction_status = (array) $result['transaction']['tenders'][0]['card_details']['status'];
                $response['transaction_status'] = $transaction_status[0];
    			$resultArray = (array) $result['transaction']['id'];
    			if($resultArray != null){
                    $response['transaction_id'] = $resultArray[0];
                    $this->session->set_userdata("transaction_id", $resultArray[0]);
                    $this->session->unset_userdata('quoteId');
    				echo json_encode($response);
    			}
    		} catch (\SquareConnect\ApiException $e) {
    			$result = (array) $e->getResponseBody();
    		    $resultCode = (array) $result['errors'][0];
                //echo json_encode($resultCode);
    			switch ($resultCode['code']) {
    				case 'VERIFY_CVV_FAILURE':
    					$error_message = "The CVV code you provided is not valid";
    					break;
    				case 'VERIFY_AVS_FAILURE':
    					$error_message = "The zip code you provided is not valid";
    					break;
    				case 'INVALID_EXPIRATION':
    					$error_message = "The expiration date you provided is not valid";
    					break;
                    case 'CARD_DECLINED':
                        $error_message = "Card declined. Please contact your bank";
                        break;
    				default:
    					$error_message = "There was an error processing the card";
    					break;
    			}
                $error_response = array("error_message" => $error_message, 'error_code' => $resultCode['code']);
    			echo json_encode($error_response);
    		}
        }

        public function vendor_estimate_rates(){
            $token_data = array(
                "grant_type" => "client_credentials",
                "client_id" => "rwjb7yuaf5pxaygx2hg97h2q",
                "client_secret" => "sKm2cNZPaY"
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.uship.com/oauth/token");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($token_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $json_token = curl_exec($ch);
            curl_close ($ch);
            $token_obj = json_decode($json_token);

            $access_token = $token_obj->access_token;

            $call_body = array(
                "route" => array(
                    "items" => [
                        array(
                            "address" => array(
                                "postalCode" => $this->input->post('origZip'),
                                "country" => "US"
                            )
                        ),
                        array(
                            "address" => array(
                                "postalCode" => $this->input->post('destZip'),
                                "country" => "US"
                            )
                        )
                    ]
                ),
                "items" => [
                    array(
                        "commodity" => "CarsLightTrucks",
                        "year" => $this->input->post('year'),
                        "makeName" => $this->input->post('make'),
                        "modelName" => $this->input->post('model')
                    )
                ]
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.uship.com/v2/estimate/");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($call_body));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ));
            $json_data = curl_exec($ch);
            curl_close ($ch);
            $data_obj = json_decode($json_data);
            echo $json_data;

        }

        public function vendor_published_rates(){
            $token_data = array(
                "grant_type" => "client_credentials",
                "client_id" => "rwjb7yuaf5pxaygx2hg97h2q", // for rate estimates production endpoint
                "client_secret" => "sKm2cNZPaY" // for rate estimates production endpoint
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.uship.com/oauth/token");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($token_data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $json_token = curl_exec($ch);
            curl_close ($ch);
            $token_obj = json_decode($json_token);
            $access_token = $token_obj->access_token;

            $format_pickup_date = str_replace("-","/", $this->input->post('pickUpDate'));
            $date = date_create($this->input->post('pickUpDate'));
            date_add($date, date_interval_create_from_date_string('7 days'));
            $seven_days_later = date_format($date, 'Y/m/d');

            $call_body = array(
                "route" => array(
                    "items" => [
                        array(
                            "address" => array(
                                "postalCode" => $this->input->post('origZip'),
                                "country" => "US"
                            ),
                            "timeFrame" => array(
                                "earliestArrival" => $format_pickup_date,
                                "latestArrival" => $format_pickup_date,
                                "timeFrameType" => "on"
                            )
                        ),
                        array(
                            "address" => array(
                                "postalCode" => $this->input->post('destZip'),
                                "country" => "US"
                            ),
                            "timeFrame" => array(
                                "earliestArrival" => $seven_days_later,
                                "latestArrival" => $seven_days_later,
                                "timeFrameType" => "between"
                            )
                        )
                    ]
                ),
                "items" => [
                    array(
                        "commodity" => "CarsLightTrucks",
                        "makeName" => $this->input->post('make'),
                        "modelName" => $this->input->post('model'),
                        "year" => $this->input->post('year'),
                        "isRunning" =>  $this->input->post('isRunning'),
                        "isConvertible" =>  $this->input->post('isConvertible'),
                        "isModified" =>  $this->input->post('isModified')
                    )
                ]
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.uship.com/v2/raterequests");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($call_body));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Authorization: Bearer '.$access_token.'',
                'Content-Type: application/json'
            ));
            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($http_code === 201){
                function get_headers_from_curl_response($response){
                    $headers = array();
                    $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));
                    foreach (explode("\r\n", $header_text) as $i => $line)
                    if ($i === 0){
                        $headers['http_code'] = $line;
                    }else{
                        list ($key, $value) = explode(': ', $line);
                        $headers[$key] = $value;
                    }
                    return $headers;
                }
                $headers = get_headers_from_curl_response($response);
                $location_header = $headers['Location'];
                curl_close ($ch);
                sleep(5);
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $location_header,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        'Accept: application/json',
                        'Authorization: Bearer '.$access_token.'',
                        'Content-Type: application/json'
                    )
                ));
                $json_data = curl_exec($curl);
                curl_close ($curl);
                $data_obj = json_decode($json_data);
                echo $json_data;
            }else{
                echo $response;
                // handle error
            }
        }

    }
?>
