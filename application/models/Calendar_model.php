<?php

    class Calendar_model extends CI_Model {

		function generate_calendar(){
            $year = date('Y')."-";
			$month = date('m')."-";
            $prefs = array (
				'start_day'    => 'sunday',
				'show_next_prev'  => TRUE,
				'next_prev_url'   => '/ajax/calendar'
			);

            $prefs['template'] = array(
                'table_open'           => '<table class="calendar">',
                'heading_previous_cell' => '<th>&nbsp;</th>',
                'heading_next_cell' => '<th><a href="{next_url}" class="monthNav">&#10095;</a></th>',
                'cal_cell_start_today' => '<td class="today">',
                'cal_cell_no_content_future' => '<span class="pickUpDay" data-mobileicon="trackerIconFour" data-fulldate="'.$year.$month.'{day}" data-currentstep="stepFour" data-nextstep="stepFive">{day}</span>'
            );
			$this->load->library('calendar', $prefs);
			return $this->calendar->generate();

		} // generate_calendar ends


    } /* Calendar_model ends */

?>
