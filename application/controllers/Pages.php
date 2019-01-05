<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->config->item('maintenance_mode')){
			redirect('maintenance/index');
		}else{
			$this->setlang->set_lang();
		}
    }

	public function how_it_works(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'howItWorks',
			'title_tag' => $this->lang->line('head_title_about'),
			'description' => $this->lang->line('head_description_about'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/how_it_works_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

    public function our_services(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'ourServices',
			'title_tag' => $this->lang->line('head_title_services'),
			'description' => $this->lang->line('head_description_services'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/our_services_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

    public function our_guarantee(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'ourGuarantee',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/our_guarantee_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

    public function questions(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'questions',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/questions_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function get_a_quote(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'getAquote',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/get_a_quote_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'rates_from_uship' => $this->config->item('rates_from_uship'),
			'use_published_rates' => $this->config->item('use_published_rates'),
			'require_contact_info' => $this->config->item('require_contact_info'),
			'google_tracking_pixel' => $this->config->item('google_tracking_pixel')
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function get_custom_quote(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'getAquote',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/get_custom_quote_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'rates_from_uship' => $this->config->item('rates_from_uship'),
			'require_contact_info' => $this->config->item('require_contact_info'),
			'google_tracking_pixel' => $this->config->item('google_tracking_pixel')
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function retrieve_quote(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'retrieveQuote',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/retrieve_quote_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function retrieve_quote_details(){
		$this->load->model('pages_model');
		$quote_details = $this->pages_model->retrieve_quote_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
		if($this->session->userdata('quoteId') == null){
			$this->session->set_userdata('quoteId', $quote_details['quoteId']);
		}
        $data = array(
            'page_class' => 'quoteDetails',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/quote_details_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'quote_details' => $quote_details
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function review_booking(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'reviewBooking',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/retrieve_booking_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function retrieve_booking_details(){
		$this->load->model('pages_model');
		$booking_details = $this->pages_model->retrieve_booking_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'quoteDetails',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/booking_details_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'booking_details' => $booking_details
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function service_status(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'reviewBooking',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/service_status_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function check_service_status(){
		$this->load->model('pages_model');
		$status = $this->pages_model->status();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'serviceStatus',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/check_service_status_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'status' => $status
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function terms_and_conditions(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'terms',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/toc_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function service_terms_and_conditions(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'terms',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/service_terms_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function privacy(){
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'privacy',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/privacy_view',
			'ip_state' => $this->session->region,
			'geolocation' => $query
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function quote_details_v1(){
		$this->load->model('pages_model');
		$quote_details = $this->pages_model->get_quote_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
		if($this->session->userdata('quoteId') == null){
			$this->session->set_userdata('quoteId', $quote_details['quoteId']);
		}
        $data = array(
            'page_class' => 'quoteDetails',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/quote_details_view_v1',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'quote_details' => $quote_details,
			'require_contact_info' => $this->config->item('require_contact_info'),
			'quote_details_page' => $this->config->item('redirect_to_quote_details')
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function quote_details_v2(){
		$this->load->model('pages_model');
		$quote_details = $this->pages_model->get_quote_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
		if($this->session->userdata('quoteId') == null){
			$this->session->set_userdata('quoteId', $quote_details['quoteId']);
		}
        $data = array(
            'page_class' => 'quoteDetails',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/quote_details_view_v2',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'quote_details' => $quote_details,
			'require_contact_info' => $this->config->item('require_contact_info')
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function service_v1(){
		$this->load->model('pages_model');
		$quote_details = $this->pages_model->get_quote_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'service',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/service_view_v1',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'quote_details' => $quote_details
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function service_v2(){
		$this->load->model('pages_model');
		$quote_details = $this->pages_model->get_quote_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'service',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/service_view_v2',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'quote_details' => $quote_details
        );
        $this->load->view('templates/template_view', array('data' =>$data));
	}

	public function create_booking_v1(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->load->model('pages_model');
			$book_service = $this->pages_model->book_service();
			if($book_service){
				$booking_details = $this->pages_model->get_booking_details();
		        $email_template = $this->load->view('includes/booking_confirmation_email_view', array('booking_details' => $booking_details), TRUE);
		        $config['protocol'] = 'sendmail';
		        $config['mailpath'] = '/usr/sbin/sendmail';
		        $config['smtp_host'] = 'relay-hosting.secureserver.net';;
		        $config['smtp_port'] = 25;
		        $config['mailtype'] = 'html';
		        $this->email->initialize($config);
		        $this->email->from('support@carshippersofamerica.com', 'CarShippersOfAmerica.com');
		        $this->email->to($booking_details['contact_email']);
		        // $this->email->bcc(
		        //     array('support@carshippersofamerica.com', 'juanca.response1@gmail.com')
		        // );
		        $this->email->reply_to('noreply@carshippersofamerica.com');
		        $this->email->subject('New Booking with Car Shippers Of America');
		        $this->email->message($email_template);
		        $send_message = $this->email->send();
				redirect('/thank_you_v1');
			}else{
				echo "booking not created";
			}
		}else{
			show_404();
		}
	}

	public function create_booking_v2(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->load->model('pages_model');
			$book_service = $this->pages_model->book_service();
			if($book_service){
				$booking_details = $this->pages_model->get_booking_details();
		        $email_template = $this->load->view('includes/booking_confirmation_email_view', array('booking_details' => $booking_details), TRUE);
		        $config['protocol'] = 'sendmail';
		        $config['mailpath'] = '/usr/sbin/sendmail';
		        $config['smtp_host'] = 'relay-hosting.secureserver.net';;
		        $config['smtp_port'] = 25;
		        $config['mailtype'] = 'html';
		        $this->email->initialize($config);
		        $this->email->from('support@carshippersofamerica.com', 'CarShippersOfAmerica.com');
		        $this->email->to($booking_details['contact_email']);
		        // $this->email->bcc(
		        //     array('support@carshippersofamerica.com', 'juanca.response1@gmail.com')
		        // );
		        $this->email->reply_to('noreply@carshippersofamerica.com');
		        $this->email->subject('New Booking with Car Shippers Of America');
		        $this->email->message($email_template);
		        $send_message = $this->email->send();
				redirect('/thank_you_v2');
			}else{
				echo "booking not created";
			}
		}else{
			show_404();
		}
	}

	public function thank_you_v1(){
		session_destroy();
		$this->load->model('pages_model');
		$booking_details = $this->pages_model->get_booking_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
		$data = array(
			'page_class' => 'confirmation_v1',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
			'main_content' => 'pages/confirmation_view_v1',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'booking_details' => $booking_details
		);
		$this->load->view('templates/template_view', array('data' =>$data));
	}

	public function thank_you_v2(){
		session_destroy();
		$this->load->model('pages_model');
		$booking_details = $this->pages_model->get_booking_details();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
		$data = array(
			'page_class' => 'confirmation_v2',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
			'main_content' => 'pages/confirmation_view_v2',
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			'booking_details' => $booking_details
		);
		$this->load->view('templates/template_view', array('data' =>$data));
	}



	// public function conf_test(){
	// 	$this->load->model('pages_model');
	// 	$booking_details = $this->pages_model->get_booking_details('e6d785b9-856e-53ae-5199-3fb8da039c9a');
	// 	$this->load->library('geolocation');
	// 	$query = $this->geolocation->get_location();
	// 	$data = array(
	// 		'page_class' => 'confirmation_v1',
	// 		'title_tag' => $this->lang->line('head_title_homepage'),
	// 		'description' => $this->lang->line('head_description_homepage'),
	// 		'keywords' => $this->lang->line('keywords_homepage'),
	// 		'main_content' => 'pages/confirmation_view',
	// 		'ip_state' => $this->session->region,
	// 		'geolocation' => $query,
	// 		'booking_details' => $booking_details
	// 	);
	// 	$this->load->view('templates/template_view', array('data' =>$data));
	// }

}
