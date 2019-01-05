<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['base_url'] = 'https://transport.local';
$config['maintenance_mode'] = FALSE;
$config['static_generator'] = FALSE;
$config['require_contact_info'] = TRUE;
$config['square_sandbox'] = TRUE;
$config['google_analytics'] = FALSE;
$config['google_tracking_pixel'] = FALSE;
$config['google_tag_manager'] = FALSE;
$config['rates_from_uship'] = TRUE;
$config['use_published_rates'] = TRUE;
$config['uship_sandbox'] = TRUE;
$config['low_rates'] = FALSE;
$config['mid_rates'] = FALSE;
$config['standard_rates'] = TRUE;
$config['use_heatmap'] = FALSE;
$config['split_home'] = FALSE; // if use_heatmap is true, split_home needs to be true`
$config['short_footer'] = FALSE;
$config['enable_dialer'] = FALSE;
$config['redirect_to_quote_details'] = TRUE;
$config['post_to_jtracker'] = TRUE;
$config['post_to_itextblast'] = TRUE;
