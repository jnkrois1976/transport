<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($this->config->item('maintenance_mode')){
    $route['default_controller'] = 'Maintenance';
}else{
    $route['default_controller'] = 'Site';
}
$route['404_override'] = 'custom_404';
$route['translate_uri_dashes'] = FALSE;

// MAPPING FOR SEO FRIENDLY URL's
$route['get_my_quote'] = 'homepage/quote_v1';
$route['get_your_quote'] = 'homepage/quote_v2';
$route['how_it_works'] = 'pages/how_it_works';
$route['our_services'] = 'pages/our_services';
$route['our_guarantee'] = 'pages/our_guarantee';
$route['questions'] = 'pages/questions';
$route['get_a_quote'] = "pages/get_a_quote";
$route['retrieve_quote'] = 'pages/retrieve_quote';
$route['review_booking'] = 'pages/review_booking';
$route['service_status'] = 'pages/service_status';
$route['check_service_status'] = 'pages/check_service_status';
$route['check_service_status/(:any)'] = 'pages/check_service_status';
$route['terms_and_conditions'] = 'pages/terms_and_conditions';
$route['service_terms_and_conditions'] = 'pages/service_terms_and_conditions';
$route['privacy'] = 'pages/privacy';
$route['retrieve_quote_details'] = 'pages/retrieve_quote_details';
$route['retrieve_quote_details/(:any)'] = 'pages/retrieve_quote_details';
$route['retrieve_booking_details'] = 'pages/retrieve_booking_details';
$route['retrieve_booking_details/(:any)'] = 'pages/retrieve_booking_details';
$route['quote_details_v1'] = 'pages/quote_details_v1';
$route['quote_details_v1/(:any)'] = 'pages/quote_details_v1';
$route['quote_details_v2'] = 'pages/quote_details_v2';
$route['quote_details_v2/(:any)'] = 'pages/quote_details_v2';
$route['book_service_v1/expedited'] = 'pages/service_v1/expedited';
$route['book_service_v1/expedited/(:any)'] = 'pages/service_v1/expedited';
$route['book_service_v1/priority'] = 'pages/service_v1/priority';
$route['book_service_v1/priority/(:any)'] = 'pages/service_v1/priority';
$route['book_service_v1/standard'] = 'pages/service_v1/standard';
$route['book_service_v1/standard/(:any)'] = 'pages/service_v1/standard';
$route['book_service_v2/expedited'] = 'pages/service_v2/expedited';
$route['book_service_v2/expedited/(:any)'] = 'pages/service_v2/expedited';
$route['book_service_v2/priority'] = 'pages/service_v2/priority';
$route['book_service_v2/priority/(:any)'] = 'pages/service_v2/priority';
$route['book_service_v2/standard'] = 'pages/service_v2/standard';
$route['book_service_v2/standard/(:any)'] = 'pages/service_v2/standard';
$route['thank_you_v1'] = 'pages/thank_you_v1';
$route['thank_you_v2'] = 'pages/thank_you_v2';
$route['create_booking_v1'] = 'pages/create_booking_v1';
$route['create_booking_v2'] = 'pages/create_booking_v2';
