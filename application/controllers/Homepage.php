<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	function __construct(){
		parent::__construct();
		if($this->config->item('maintenance_mode')){
			redirect('maintenance/index');
		}else{
			$this->setlang->set_lang();
		}
    }

    public function change_lang(){
        $choosen_lang = $this->uri->segment(3);
        if($choosen_lang == "es"){
            $data = array('lang' => $choosen_lang);
            $this->session->set_userdata($data);
            $this->lang->load('spanish', 'spanish');
            redirect($this->agent->referrer());
        }elseif(!$current_lang){
            $data = array('lang' => $choosen_lang);
            $this->session->set_userdata($data);
            $this->lang->load('english', 'english');
            redirect($this->agent->referrer());
        }
    }

	public function quote_v1(){
		$this->load->model('site_model');
		$even_odd = $this->site_model->even_odd();
		$this->load->model('calendar_model');
		$generate_calendar = $this->calendar_model->generate_calendar();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'homepage',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/homepage_view',
			'generate_calendar' => $generate_calendar,
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			//'even_odd' => $even_odd,
			'even_odd' => 0,
			'rates_from_uship' => $this->config->item('rates_from_uship'),
			'use_published_rates' => $this->config->item('use_published_rates'),
			'require_contact_info' => $this->config->item('require_contact_info'),
			'google_tracking_pixel' => $this->config->item('google_tracking_pixel')
        );
        $this->load->view('templates/template_view', array('data' =>$data));
    }

	public function quote_v2(){
		$this->load->model('site_model');
		$even_odd = $this->site_model->even_odd();
		$this->load->model('calendar_model');
		$generate_calendar = $this->calendar_model->generate_calendar();
		$this->load->library('geolocation');
		$query = $this->geolocation->get_location();
        $data = array(
            'page_class' => 'homepage',
			'title_tag' => $this->lang->line('head_title_homepage'),
			'description' => $this->lang->line('head_description_homepage'),
			'keywords' => $this->lang->line('keywords_homepage'),
            'main_content' => 'pages/homepage_view',
			'generate_calendar' => $generate_calendar,
			'ip_state' => $this->session->region,
			'geolocation' => $query,
			//'even_odd' => $even_odd,
			'even_odd' => 1,
			'rates_from_uship' => $this->config->item('rates_from_uship'),
			'use_published_rates' => $this->config->item('use_published_rates'),
			'require_contact_info' => $this->config->item('require_contact_info'),
			'google_tracking_pixel' => $this->config->item('google_tracking_pixel')
        );
        $this->load->view('templates/template_view', array('data' =>$data));
    }

}
