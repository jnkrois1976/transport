<!doctype html>
<html class="no-js" lang="">
    <head>
        <?php if($this->config->item('google_tag_manager')): ?>
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-NLVZL2R');</script>
            <!-- End Google Tag Manager -->
        <?php endif; ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title itemprop='name'><?=$title_tag?></title>
        <link rel="canonical" href="<?php echo base_url();?>" itemprop="url">
        <meta name="description" content="<?=$description?>">
        <meta name="keywords" content="<?=$keywords?>">
        <meta name="author" content="Juan C. Rois">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="format-detection" content="telephone=no" />
        <meta name="google-site-verification" content="IVNCmz-gSbCIbpbfPtmU58-PhbGid4qo2v6ybhKmBAM" />
        <link rel="alternate" hreflang="en-us" href="alternateURL">
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800" rel="stylesheet">
        <link rel="stylesheet" href="/css/normalize.css">
        <link rel="stylesheet" href="/css/bootstrap.css"/>
        <link rel="stylesheet" href="/css/static_layout.css" />
        <link rel="stylesheet" href="/css/common_layout.css" />
        <!-- <link rel="stylesheet" href="/css/layout.css"> -->
        <link rel="stylesheet" href="/css/helpers.css">
        <link rel="stylesheet" href="/css/format.css">
        <link rel="stylesheet" href="/css/skin.css">
        <link rel="stylesheet" href="/css/breakpoints.css">
        <?php if($page_class == "service"): ?>
            <script src='https://www.google.com/recaptcha/api.js'></script>
        <?php endif; ?>
        <script type="text/javascript">
            <?php if($this->config->item('low_rates')): ?>
                var lowRates = true, midRates = false, standardRates = false;
            <?php elseif($this->config->item('mid_rates')): ?>
                var lowRates = false, midRates = true, standardRates = false;
            <?php elseif($this->config->item('standard_rates')): ?>
                var lowRates = false, midRates = false, standardRates = true;
            <?php endif; ?>
        </script>
        <!-- Hotjar Tracking Code for https://carshippersofamerica.com -->
        <!--<script>
            (function(h,o,t,j,a,r){
                h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                h._hjSettings={hjid:557589,hjsv:5};
                a=o.getElementsByTagName('head')[0];
                r=o.createElement('script');r.async=1;
                r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                a.appendChild(r);
            })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
        </script>-->
    </head>
    <!--Start of Zendesk Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){
z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='https://v2.zopim.com/?54iC3uuPjsNxHOvuvpAanzytPCmK4R9O';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');</script>
<!--End of Zendesk Chat Script-->
    <body class="<?=$page_class?>">
        <div id="phoneBanner">
            Call us now&nbsp; <a href="tel:800-687-6260">800-687-6260</a>
        </div>
        <?php if($this->config->item('google_tag_manager')): ?>
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NLVZL2R"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        <?php endif; ?>
        <div id="loading">
            <div>
                <img src="/images/rolling.gif" alt="Loading" />
            </div>
        </div>
        <header>
            <div id="logo">
                <a href="/" title="Home">
                    <img src="/svg/Car-shippers-of-america-logo.svg" title="Best car shipping company and auto transport rates" alt="How much does it cost to ship a car?" />
                </a>
            </div>
            <nav>
                <span id="menuIcon" class="glyphicon glyphicon-remove glyphicon-align-justify font2x" aria-hidden="true"></span>
                <ul id="siteNav">
                    <!-- <li class="font150">
                        <a href="/" title="Home">Home</a>
                    </li> -->
                    <li class="font150">
                        <a href="/how_it_works" title="How It Works">How It Works</a>
                    </li>
                    <li class="font150">
                        <a href="/our_services" title="Our Services">Our Services</a>
                    </li>
                    <li class="font150">
                        <a href="/our_guarantee" title="Our Guarantee">Our Guarantee</a>
                    </li>
                    <li class="font150">
                        <a href="/questions" title="Have Questions?">Have Questions?</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main class="<?=$ip_state?>">
