<?php if($this->config->item('google_tracking_pixel')):?>
    <script type="text/javascript">
        var googleTrackingPixel = <?=($google_tracking_pixel ? "true": "false")?>;
    </script>
<?php endif; ?>
<?php if($this->config->item('redirect_to_quote_details')):?>
    <script type="text/javascript">
        var quoteDetailsPage = <?=($quote_details_page ? "true": "false")?>;
    </script>
<?php endif; ?>
<?php if($rates_from_uship): ?>
    <script type="text/javascript">
        var vendorRates = true;
        var publishedRates = <?=($use_published_rates ? 'true': 'false')?>;
        var publishedOrEstimate = "<?=($use_published_rates ? "vendor_published_rates": "vendor_estimate_rates")?>";
        var requireContactInfo = <?=($require_contact_info ? "true": "false")?>;
    </script>
<?php endif; ?>
<div id="progressTracker">
    <div>
        <div>
            <span id="trackerIconOne" class="trackerIcon trackerStep glyphicon glyphicon-circle-arrow-up" data-currentstep="stepOne" data-nextstep="stepTwo"></span>
            <div class="font125">Where's the car?</div>
            <div id="originDisplay" class="trackerStep" data-currentstep="stepOne" data-nextstep="stepTwo">
                <div id="origZipDisplay" class="trackerLgFont"></div>
                <div id="origCityDisplay" class="trackerMdFont"></div>
            </div>
            <div class="arrow_box">Click to change</div>
        </div>
        <div>
            <span id="trackerIconTwo" class="trackerIcon trackerStep glyphicon glyphicon-circle-arrow-down" data-currentstep="stepTwo" data-nextstep="stepThree"></span>
            <div class="font125">Where is it going?</div>
            <div id="destinationDisplay" class="trackerStep" data-currentstep="stepTwo" data-nextstep="stepThree">
                <div id="destZipDisplay" class="trackerLgFont"></div>
                <div id="destCityDisplay" class="trackerMdFont"></div>
            </div>
            <div class="arrow_box">Click to change</div>
        </div>
        <div>
            <span id="trackerIconThree" class="trackerIcon trackerStep symbol" data-currentstep="stepThree" data-nextstep="stepFour">&#128665;</span>
            <div class="font125">What kind of car?</div>
            <div id="carTypeDisplay" class="trackerStep" data-currentstep="stepThree" data-nextstep="stepFour">
                <div id="carMakeDisplay" class="trackerLgFont"></div>
                <div id="carModelYearDisplay" class="trackerMdFont uppercase"></div>
            </div>
            <div class="arrow_box">Click to change</div>
        </div>
        <div>
            <span id="trackerIconFour" class="trackerIcon trackerStep glyphicon glyphicon-calendar" data-currentstep="stepFour" data-nextstep="stepFive"></span>
            <div class="font125">What's the pickup date?</div>
            <div id="dateDisplay" class="trackerStep" data-currentstep="stepFour" data-nextstep="stepFive">
                <div id="dayPickupDisplay" class="trackerLgFont"></div>
                <div id="monthPickupDisplay" class="trackerMdFont"></div>
            </div>
            <div class="arrow_box">Click to change</div>
        </div>
        <div>
            <span id="trackerIconFive" class="trackerIcon trackerStep glyphicon glyphicon-tasks" data-currentstep="stepFive" data-nextstep="stepSix"></span>
            <div class="font125">Your Shipping options</div>
            <div id="OptionsDisplay" class="trackerStep" data-currentstep="stepFive" data-nextstep="stepSix">
                <div id="optionOneDisplay" class="trackerLgFont"></div>
                <div id="optionTwoDisplay" class="trackerMdFont"></div>
            </div>
            <div class="arrow_box">Click to change</div>
        </div>
        <!-- <div>
            <span id="trackerIconSix" class="trackerIcon trackerStep glyphicon glyphicon-usd" data-currentstep="stepSix"></span>
            <div class="font125">Your Quote</div>
            <div id="priceDisplay" class="trackerStep" data-currentstep="stepSix">
                <div id="priceOneDisplay" class="trackerLgFont"></div>
                <div id="priceTwoDisplay" class="trackerMdFont"></div>
            </div>
        </div> -->
    </div>
</div>
<div id="content">
    <?php if($even_odd === 0):?>
        <?php $this->load->view('/includes/static_generator_view'); ?>
    <?php elseif($even_odd !== 0):?>
        <?php $this->load->view('/includes/animated_generator_view'); ?>
    <?php endif; ?>
</div>
<?php if(!$require_contact_info): ?>
    <?php $this->load->view('/includes/save_quote_modal_view'); ?>
<?php endif; ?>
<div class="modal fade" tabindex="-1" role="dialog" id="welcomeBack" data-show="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <h2 class="modal-title">Welcome Back!</h2>
            </div>
            <div class="modal-body">
                <p>
                    We're happy to see you come back!.<br />
                    We still have the last quote that we generated for you.<br /><br />
                    Would you like to see it?
                </p>
            </div>
            <div class="modal-footer">
                <?php
                    if($even_odd === 0){
                        $v1_or_v2 = "_v1";
                    }elseif($even_odd !== 0){
                        $v1_or_v2 = "_v2";
                    }
                ?>
                <button id="deleteQuote" type="button" class="btn btn-info" data-dismiss="modal">Generate a new quote</button>
                <a id="loadQuote" data-version="<?=$v1_or_v2?>" href="/quote_details<?=$v1_or_v2?>" class="btn btn-primary">Review my quote</a>
            </div>
        </div>
    </div>
</div>
