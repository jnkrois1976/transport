<?php if($rates_from_uship): ?>
    <script type="text/javascript">
        var vendorRates = true;
        var publishedRates = false;
        var publishedOrEstimate = "vendor_estimate_rates";
        var requireContactInfo = <?=($require_contact_info ? "true": "false")?>;
        var googleTrackingPixel = <?=($google_tracking_pixel ? "true": "false")?>;
    </script>
<?php endif; ?>
<div>
    <div>
        <div id="static_generator">
            <form id="static_generator_form" class="width50">
                <h1 class="font4x">Need to ship your car?</h1>
                <hr />
                <div>
                    <span class="font125">No Personal Information Needed to Get A Quote!</span><br />
                    <span class="font125">Get an instant quote on safe &amp; reliable auto transport, without an email address or credit card.</span>
                </div>
                <fieldset>
                    <?php
                        $csrf = array(
                            'name' => $this->security->get_csrf_token_name(),
                            'hash' => $this->security->get_csrf_hash()
                        );
                    ?>
                    <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                    <div>Where do we pick up your car?</div>
                    <div>
                        <div class="form-group form-group suggestBox">
                            <input id="originZip" class="form-control zipCityInput" data-index="0" data-match="originCity" data-mobileicon="trackerIconOne" data-currentstep="stepOne" data-nextstep="stepTwo" data-suggest="zipcode" data-displayone="origZipDisplay" data-displaytwo="origCityDisplay" type="number" value="" placeholder="zip code" autocomplete="off" required="true" />
                            <ul class="zipCitySuggest"></ul>
                        </div>
                        <div>&nbsp;or&nbsp;</div>
                        <div class="form-group form-group suggestBox">
                            <input id="originCity" class="form-control zipCityInput" data-index="0" data-match="originZip" data-mobileicon="trackerIconOne" data-currentstep="stepOne" data-nextstep="stepTwo" data-suggest="city" data-displayone="origZipDisplay" data-displaytwo="origCityDisplay" type="text" value="" placeholder="city" autocomplete="off" required="true" />
                            <ul class="zipCitySuggest"></ul>
                        </div>
                    </div>
                    <div>Where do we drop it off?</div>
                    <div>
                        <div class="form-group form-group suggestBox">
                            <input id="destZip" class="form-control zipCityInput" data-index="1" data-match="destCity" data-mobileicon="trackerIconTwo" data-currentstep="stepTwo" data-nextstep="stepThree" data-suggest="zipcode" data-displayone="destZipDisplay" data-displaytwo="destCityDisplay" type="number" value="" placeholder="zip code" autocomplete="off" required="true" />
                            <ul class="zipCitySuggest"></ul>
                        </div>
                        <div>&nbsp;or&nbsp;</div>
                        <div class="form-group form-group suggestBox">
                            <input id="destCity" class="form-control zipCityInput" data-index="1" data-match="destZip" data-mobileicon="trackerIconTwo" data-currentstep="stepTwo" data-nextstep="stepThree" data-suggest="city" data-displayone="destZipDisplay" data-displaytwo="destCityDisplay" type="text" value="" placeholder="city" autocomplete="off" required="true" />
                            <ul class="zipCitySuggest"></ul>
                        </div>
                    </div>
                    <div>We need the year, make and model</div>
                    <div id="carData">
                        <div class="form-group form-group">
                            <select id="carYear" class="form-control inpu carData" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay">
                                <option value="">Year</option>
                                <?php for($i = date('Y') + 1; $i > 1983; $i--): ?>
                                    <option value="<?=$i?> "><?=$i?></option>
                                <?php endfor; ?>
                                <option value="older">Older</option>
                            </select>
                            <input id="carYearOlder" type="text" class="form-control input carDataOlder" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay" placeholder="Year">
                        </div>
                        <div class="form-group form-group">
                            <select id="carMake" class="form-control input carData" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay">
                                <option value="">Make</option>
                            </select>
                            <input id="carMakeOlder" type="text" class="form-control input carDataOlder" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay" placeholder="Make">
                        </div>
                        <div class="form-group form-group">
                            <select id="carModel" class="form-control input carData" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay">
                                <option value="">Model</option>
                            </select>
                            <input id="carModelOlder" type="text" class="form-control input carDataOlder" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay" placeholder="Model" data-size="0">
                        </div>
                    </div>
                    <div>When would you like it picked up?</div>
                    <div>
                        <div class="input-group">
                            <input id="pickUpDate" class="form-control" type="date" data-currentstep="stepFour" data-nextstep="stepFive" value="" placeholder="pick up date" autocomplete="off" required="true" />
                            <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                        </div>
                        <div id="formattedDate"></div>
                    </div>
                    <div>How would you like to ship it?</div>
                    <div id="radio-control-group">
                        <div class="radio-control">
                            <input id="openTransport" class="shippingOptions" name="transportMethod" type="radio" value="OpenTransport" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="openTransport">&#9679;</label>
                            <div>Open transport</div>
                        </div>
                        <div class="radio-control">
                            <input id="enclosedTransport" class="shippingOptions" name="transportMethod" type="radio" value="Enclosed Transport" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="enclosedTransport">&#9679;</label>
                            <div>Enclosed transport</div>
                        </div>
                        <div class="radio-control">
                            <input id="convertible" class="shippingOptions" name="carOtherDetails" type="checkbox" value="true" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="convertible">&#9679;</label>
                            <div>Is it a convertible?</div>
                        </div>
                        <div class="radio-control">
                            <input id="modified" class="shippingOptions" name="carOtherDetails" type="checkbox" value="true" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="modified">&#9679;</label>
                            <div>Lifted or modified?</div>
                        </div>
                        <div class="radio-control">
                           <input id="carOk" class="shippingOptions" name="carCondition" type="radio" value="carOk" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                           <label for="carOk" >&#9679;</label>
                           <div>It runs fine</div>
                       </div>
                       <div class="radio-control">
                           <input id="carNotOk" class="shippingOptions" name="carCondition" type="radio" value="carNotOk" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                           <label for="carNotOk">&#9679;</label>
                           <div>It needs a push</div>
                       </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary font150" id="generateStaticQuote">Get a Quote Now</button>
                    </div>
                    <div id="formFailedMsg">
                        Please check the fields! I think you missed something.
                    </div>
                </fieldset>
            </form>
        </div>
        <div id="generatedQuoteWrapper">
            <h1 class="font4x">Congratulations.</h1>
            <h3>All you have to do now is choose a shipping option and book it!</h3>
            <div id="generatedQuote">
                <div class="userQuote">
                    <h3>Standard Shipping</h3>
                    <div id="stdShippPrice" class="font4x dollarAmount">$775.00*</div>
                    <a href="/book_service_v2/standard" class="btn btn-primary font150">Book Standard Shipping<sup>**</sup></a>
                    <a href="/quote_details_v2">View Details</a>
                    <small><sup>**</sup>Within 7 days of requested date</small>
                </div>
                <div class="userQuote">
                    <h3>Priority Shipping</h3>
                    <div id="prioShippPrice" class="font4x dollarAmount">$890.00*</div>
                    <a href="/book_service_v2/priority" class="btn btn-primary font150">Book Priority Shipping<sup>**</sup></a>
                    <a href="/quote_details_v2">View Details</a>
                    <small><sup>**</sup>Within 3-4 days of requested date</small>
                </div>
                <div class="userQuote">
                    <h3>Expedited Shipping</h3>
                    <div id="expShippPrice" class="font4x dollarAmount">$1150.00*</div>
                    <a href="/book_service_v2/expedited" class="btn btn-primary font150">Book Expedited Shipping<sup>**</sup></a>
                    <a href="/quote_details_v2">View Details</a>
                    <small><sup>**</sup>Within 1-2 days of requested date</small>
                </div>
            </div>
            <hr />
            <div id="quoteOptions">
                <div>
                    <h4>Need to change something?</h4>
                    <div class="form-group fullWidth">
                        <button class="btn btn-default font2x font600" id="changeQuote">Change your selections</button>
                    </div>
                    <small>
                        Think you missed something? <br />Change your selections and I'll update your quote right away.
                    </small>
                </div>
                <div>
                    <h4>Save this quote and lock your price.</h4>
                    <div class="form-group fullWidth">
                        <button class="btn btn-info font2x font600" id="saveQuote">Save this quote</button>
                    </div>
                    <small>
                        Rates are subject to change. But you can lock the price in this quote by saving it for 7 days.<br />
                        All I need is an email address to send it to you. <br />It will include a quote ID number that you can use to retrieve it and book your service.<br />
                        I promise that I'll only use your email for the purposes of this quote.
                    </small>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="saveQuoteModal" data-show="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h2 class="modal-title">Good idea to save this quote</h2>
                    </div>
                    <div class="modal-body">
                        <div id="saveSuccess">
                            <h4>Your quote was saved succesfully</h4>
                            <p>Here's your quote ID number:</p>
                            <p id="quoteIdNumber" class="font4x"></p>
                            <p>
                                This quote will be valid for 7 days from today.<br />
                                I sent you an email with the quote details and this ID number.
                            </p>
                        </div>
                        <form id="saveQuoteForm" method="post" action="">
                            <p>
                                I'll generate a quote ID number that you can use to retrieve this quote later.<br />
                                This quote will be saved for 7 days and it will lock your price for when you are ready to book your service.
                            </p>
                            <div class="form-group">
                                <label for="usrEmail">Your Email <small>(Required*)</small></label>
                                <input type="email" class="form-control" name="usrEmail" id="usrEmail" value="" placeholder="Your email..." required="required" />
                            </div>
                            <div class="form-group">
                                <label for="usrName">Your Name <small>(Optional)</small></label>
                                <input type="text" class="form-control" name="usrName" id="usrName" value="" placeholder="Your name..." />
                            </div>
                            <div class="form-group">
                                <label for="usrPhone">Your Phone <small>(Optional)</small></label>
                                <input type="tel" class="form-control" name="usrPhone" id="usrPhone" value="" placeholder="Your phone..." />
                            </div>
                            <small>
                                We take your privacy extremely seriously, and we never sell lists or email addresses.<br />
                                Please take a look at our <a href="privacy">Privacy Policy</a> for details.
                            </small>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="saveMyQuote" type="button" class="btn btn-info">Save your quote</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
