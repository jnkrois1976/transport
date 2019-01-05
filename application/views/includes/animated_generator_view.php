<form action="/ajax/generate_quote" method="post" id="quoteGenerator">
    <?php
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    ?>
    <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <div id="stepZero">
    <!-- <div id="stepZero" style="display:none;"> -->
        <h1 class="font4x">Need to ship your car?</h1>
        <h4>Let us help you with that.</h4>
        <div>
            <div class="form-group">
                <button class="btn btn-primary font150 btn-lg" id="startGenerator" data-currentstep="stepZero" data-nextstep="stepOne">Get a Quote Now</button>
            </div>
            <em>Get an instant quote on safe &amp; reliable auto transport, no hassle or commitment.</em>
        </div>
        <ul class="font2x">
            <li>Awesome Rates</li>
            <li>Instant Quotes</li>
            <li>No Commitment</li>
        </ul>
    </div>
    <div class="wizardSteps" id="stepOne">
        <h1 class="font4x">Where do we pick up your car?</h1>
        <p>
            What's your zip code or City?
        </p>
        <div id="origin">
            <div class="form-group form-group-lg">
                <input id="originZip" class="form-control zipCityInput" data-index="0" data-match="originCity" data-mobileicon="trackerIconOne" data-currentstep="stepOne" data-nextstep="stepTwo" data-suggest="zipcode" data-displayone="origZipDisplay" data-displaytwo="origCityDisplay" type="number" value="" placeholder="zip code" autocomplete="off" required="true" />
                <ul class="zipCitySuggest"></ul>
            </div>
            <div>&nbsp;or&nbsp;</div>
            <div class="form-group form-group-lg">
                <input id="originCity" class="form-control zipCityInput" data-index="0" data-match="originZip" data-mobileicon="trackerIconOne" data-currentstep="stepOne" data-nextstep="stepTwo" data-suggest="city" data-displayone="origZipDisplay" data-displaytwo="origCityDisplay" type="text" value="" placeholder="city" autocomplete="off" required="true" />
                <ul class="zipCitySuggest"></ul>
            </div>
        </div>
        <div class="form-group fullWidth">
            <button class="form-control btn btn-primary manualStep" data-currentstep="stepOne" data-nextstep="stepTwo">Next </button>
            <span class="checkData">Please provide a zip code or city name.</span>
        </div>
    </div>
    <div class="wizardSteps" id="stepTwo">
        <h1 class="font4x">Where do we drop it off?</h1>
        <p>
            What's the zip code or City?
        </p>
        <div id="destination">
            <div class="form-group form-group-lg">
                <input id="destZip" class="form-control zipCityInput" data-index="1" data-match="destCity" data-mobileicon="trackerIconTwo" data-currentstep="stepTwo" data-nextstep="stepThree" data-suggest="zipcode" data-displayone="destZipDisplay" data-displaytwo="destCityDisplay" type="number" value="" placeholder="zip code" autocomplete="off" required="true" />
                <ul class="zipCitySuggest"></ul>
            </div>
            <div>&nbsp;or&nbsp;</div>
            <div class="form-group form-group-lg">
                <input id="destCity" class="form-control zipCityInput" data-index="1" data-match="destZip" data-mobileicon="trackerIconTwo" data-currentstep="stepTwo" data-nextstep="stepThree" data-suggest="city" data-displayone="destZipDisplay" data-displaytwo="destCityDisplay" type="text" value="" placeholder="city" autocomplete="off" required="true" />
                <ul class="zipCitySuggest"></ul>
            </div>
        </div>
        <div class="form-group fullWidth">
            <button class="form-control btn btn-primary manualStep" data-currentstep="stepTwo" data-nextstep="stepThree">Next </button>
            <span class="checkData">Please provide a zip code or city name.</span>
        </div>
    </div>
    <div class="wizardSteps" id="stepThree">
        <h1 class="font4x">What kind of car is it?</h1>
        <p>
            We need the year, make and model please.
        </p>
        <div id="carInfo">
            <div class="form-group form-group-lg">
                <select id="carYear" class="form-control inpu-lg carData" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay">
                    <option value="">Year</option>
                    <?php for($i = date('Y') + 1; $i > 1983; $i--): ?>
                        <option value="<?=$i?> "><?=$i?></option>
                    <?php endfor; ?>
                    <!-- <option value="older">Older</option> -->
                </select>
            </div>
            <div class="form-group form-group-lg">
                <select id="carMake" class="form-control input-lg carData" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay">
                    <option value="">Make</option>
                </select>
            </div>
            <div class="form-group form-group-lg">
                <select id="carModel" class="form-control input-lg carData" data-mobileicon="trackerIconThree" data-currentstep="stepThree" data-nextstep="stepFour" data-displayone="carMakeDisplay" data-displaytwo="carModelYearDisplay">
                    <option value="">Model</option>
                </select>
            </div>
        </div>
        <div class="form-group fullWidth">
            <button class="form-control btn btn-primary manualStep" data-currentstep="stepThree" data-nextstep="stepFour">Next </button>
            <span class="checkData">Please choose from the options above.</span>
        </div>
    </div>
    <div class="wizardSteps" id="stepFour" style="display:bloc;">
        <h1 class="font4x">When would you like it picked up?</h1>
        <div id="pickUpDate">
            <?=$generate_calendar?>
        </div>
        <div class="form-group fullWidth">
            <button class="form-control btn btn-primary manualStep" data-currentstep="stepFour" data-nextstep="stepFive">Next </button>
            <span class="checkData">Please choose a date from the calendar.</span>
        </div>
    </div>
    <div class="wizardSteps" id="stepFive">
        <?php
            $options_title = ($require_contact_info ? "Shipping options": "Last Questions.");
        ?>
        <h1 class="font4x"><?=$options_title?></h1>
        <div id="shippingOptions">
            <div>
                <fieldset>
                    <legend>How would you like to ship it?</legend>
                    <div>
                        <div>
                            <div>Open transport</div>
                            <input id="openTransport" class="shippingOptions" name="transportMethod" type="radio" value="OpenTransport" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="openTransport">&#9679;</label>
                        </div>
                        <div>
                            <div>Enclosed transport</div>
                            <input id="enclosedTransport" class="shippingOptions" name="transportMethod" type="radio" value="EnclosedTransport" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="enclosedTransport">&#9679;</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset>
                    <legend>Other car details?</legend>
                    <div>
                        <div>
                            <div>Is it a convertible?</div>
                            <input id="convertible" class="shippingOptions" name="carOtherDetails" type="checkbox" value="true" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="convertible" >&#9679;</label>
                        </div>
                        <div>
                            <div>Lifted or modified?</div>
                            <input id="modified" class="shippingOptions" name="carOtherDetails" type="checkbox" value="true" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="modified">&#9679;</label>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div>
                <fieldset>
                    <legend>What is the condition of the car?</legend>
                    <div>
                        <div>
                            <div>It runs fine</div>
                            <input id="carOk" class="shippingOptions" name="carCondition" type="radio" value="carOk" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="carOk" >&#9679;</label>
                        </div>
                        <div>
                            <div>It needs a push</div>
                            <input id="carNotOk" class="shippingOptions" name="carCondition" type="radio" value="carNotOk" data-mobileicon="trackerIconFive" data-currentstep="stepFive" data-nextstep="stepSix">
                            <label for="carNotOk">&#9679;</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="form-group fullWidth">
            <?php
                $next_step = ($require_contact_info ? "Next step": "All done");
            ?>
            <button class="form-control btn btn-primary manualStep" data-currentstep="stepFive" data-nextstep="stepSix"><?=$next_step?> </button>
            <span class="checkData">Please choose your shipping options.</span>
        </div>
    </div>
    <?php if($require_contact_info): ?>
        <div class="wizardSteps" id="stepSix">
            <h1>Your contact Info</h1>
            <div id="contactInfo">
                <div class="form-group">
                    <label for="usrEmail">Your Email <small>(Required*)</small></label>
                    <input type="email" class="form-control contactLead" name="usrEmail" id="usrEmail" value="" placeholder="Your email..." required="required" />
                </div>
                <div class="form-group">
                    <label for="usrName">Your Name <small>(Required*)</small></label>
                    <input type="text" class="form-control contactLead" name="usrName" id="usrName" value="" placeholder="Your name..." />
                </div>
                <div class="form-group">
                    <label for="usrPhone">Your Phone <small>(Required*)</small></label>
                    <input type="tel" class="form-control contactLead" name="usrPhone" id="usrPhone" value="" placeholder="Your phone..." />
                </div>
            </div>
            <div class="form-group fullWidth">
                <button id="proceedToQuote" class="form-control btn btn-primary manualStep" data-currentstep="stepSix" data-nextstep="stepSeven">All done </button>
                <span class="checkData">Please fill out your contact info.</span>
            </div>
            <small>
                We take your privacy extremely seriously, and we never sell lists or email addresses.<br />
                Please take a look at our <a href="/privacy" target="_blank">Privacy Policy</a> for details.
            </small>
        </div>
    <?php endif; ?>
    <?php if(!$quote_details_page): ?>
        <div class="wizardSteps" id="stepSix">
        <!-- <div class="wizardSteps" id="stepSix" style="display:block; opacity:1; margin-top:20px;"> -->
            <h1 class="font4x">Congratulations.</h1>
            <?php if($require_contact_info): ?>
                <h4>All you have to do now is choose a shipping option and book it!</h4>
                <hr />
                <div class="autoSavedQuote">
                    <p>
                        Also, here's your quote ID. This quote is valid for seven days.<br />
                        You can use the ID to retrieve this quote when you need it.<br /><br />
                        For your convenience, you also sent you an email with your quote details and ID.
                    </p>
                    <div id="saveSuccess">
                        <h4>Here's your quote ID number:</h4>
                        <p id="quoteIdNumber" class="font4x"></p>
                    </div>
                </div>
                <hr />
            <?php elseif(!$require_contact_info): ?>
                <h4>All you have to do now is choose a shipping option and book it!<br /><br />Or</h4>
                <div>
                    <h4>Save this quote and lock your price.</h4>
                    <div class="form-group fullWidth">
                        <button class="btn btn-info btn-lg font2x font600" id="saveQuote">Save this quote</button>
                    </div>
                    <small>
                        Rates are subject to change. But you can lock the price in this quote by saving it for 7 days.<br />
                        <!-- All I need is an email address to send it to you. <br />It will include a quote ID number that you can use to retrieve it and book your service.<br />
                        I promise that I'll only use your email for the purposes of this quote. -->
                    </small>
                </div>
                <hr />
            <?php endif; ?>
            <div id="generatedQuote">
                <div class="userQuote">
                    <h3>Standard Shipping</h3>
                    <div id="stdShippPrice" class="font4x dollarAmount">$775.00</div>
                    <a href="/book_service_v1/standard" class="btn btn-primary font150">Book Standard Shipping<sup>*</sup></a>
                    <a href="/quote_details_v1">View Details</a>
                    <small><sup>*</sup>Within 7 days of requested date</small>
                </div>
                <div class="userQuote">
                    <h3>Priority Shipping</h3>
                    <div id="prioShippPrice" class="font4x dollarAmount">$890.00</div>
                    <a href="/book_service_v1/priority" class="btn btn-primary font150">Book Priority Shipping<sup>*</sup></a>
                    <a href="/quote_details_v1">View Details</a>
                    <small><sup>*</sup>Within 3-4 days of requested date</small>
                </div>
                <div class="userQuote">
                    <h3>Expedited Shipping</h3>
                    <div id="expShippPrice" class="font4x dollarAmount">$1150.00</div>
                    <a href="/book_service_v1/expedited" class="btn btn-primary font150">Book Expedited Shipping<sup>*</sup></a>
                    <a href="/quote_details_v1">View Details</a>
                    <small><sup>*</sup>Within 1-2 days of requested date</small>
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
            </div>
        </div>
    <?php endif; ?>
</form>
