<div>
    <div>
        <?php if($quote_details): ?>
            <h1 class="font4x">Book Your Service</h1>
            <!-- Visa	4532759734545858
          MasterCard	5409889944179029
          Discover	6011033621379697
          Diners Club	36004244846408
          JCB	3566005734880650
          American Express	371263462726550 -->
            <hr />
            <form id="bookService" method="post" action="/create_booking_v2">
                <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                ?>
                <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <fieldset id="addressDetails">
                    <legend>Shippment Info</legend>
                    <div>
                        <div>
                            <p>Where's the car?</p>
                            <div id="locationField" class="form-group ">
                                <input id="autocomplete" name="autocomplete" class="form-control" placeholder="Origin address" type="text" required />
                            </div>
                            <div id="address" class="form-group">
                                <input class="form-control" id="street_number" name="street_number" disabled="true" required placeholder="Street number" />
                                <input class="form-control" id="route" name="route" disabled="true" required placeholder="Street name"/>
                                <!-- <input class="form-control" id="shippingAptNumber" name="shippingAptNumber" placeholder="Apt number"/> -->
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="locality" name="locality" disabled="true" required placeholder="City" />
                                <input class="form-control" id="administrative_area_level_1" name="administrative_area_level_1" disabled="true" required placeholder="State" />
                                <input class="form-control" id="postal_code" name="postal_code" disabled="true" required placeholder="Zip code"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control hidden" id="country" name="country" disabled="true" required placeholder="Country"/>
                            </div>
                        </div>
                        <hr />
                        <div>
                            <p>Where's the car going?</p>
                            <div id="locationField2" class="form-group ">
                                <input id="autocomplete2" name="autocomplete2" class="form-control" placeholder="Destination address" type="text" required />
                            </div>
                            <div id="address2" class="form-group">
                                <input class="form-control" id="street_number2" name="street_number2" disabled="true" required placeholder="Street number" />
                                <input class="form-control" id="route2" name="route2" disabled="true" required placeholder="Street name"/>
                                <!-- <input class="form-control" id="shippingAptNumber" name="shippingAptNumber" placeholder="Apt number"/> -->
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="locality2" name="locality2" disabled="true" required placeholder="City" />
                                <input class="form-control" id="administrative_area_level_12" name="administrative_area_level_12" disabled="true" required placeholder="State" />
                                <input class="form-control" id="postal_code2" name="postal_code2" disabled="true" required placeholder="Zip code"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control hidden" id="country2" name="country2" disabled="true" required placeholder="Country"/>
                            </div>
                        </div>
                        <hr />
                        <div>
                            <p class="font150">Pick up date and other info</p>
                            <p>Requested pick up date: <strong><em><?=$quote_details['pickUpFormattedDate']?></em></strong></p>
                            <p>The car will be shipped in an <strong><em><?=$quote_details['transportType']?></em></strong></p>
                            <p>We'd be shipping a: <strong><em><?=$quote_details['carMake']." ".$quote_details['carModel']." - ".$quote_details['carYear']?></em></strong></p>
                        </div>
                    </div>
                </fieldset>
                <div id="contactInfo">
                    <fieldset>
                        <legend>Your Contact Info</legend>
                        <div class="form-group ">
                            <input type="text" class="form-control contactLead" id="usrName" name="usrName" placeholder="What's your name?" required value="<?=$quote_details['usrName']?>">
                        </div>
                        <div class="form-group ">
                            <input type="tel" class="form-control contactLead" id="usrPhone" name="usrPhone" placeholder="What's your phone number?" required value="<?=$quote_details['usrPhone']?>">
                        </div>
                        <div class="form-group ">
                            <input type="email" class="form-control contactLead" id="usrEmail" name="usrEmail" placeholder="What's your email?" required value="<?=$quote_details['usrEmail']?>">
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Payment Info</legend>
                        <div class="form-group">
                            <input value="" class="form-control" id="cardName" name="cardName" type="text" placeholder="Cardholder name (as it appears in the card)" required="required"/>
                        </div>
                        <div class="form-group ">
                            <div class="flex column align-top justify-start form-group">
                                <input value="" class="form-control" id="sq-card-number" name="cardNumber" type="text" placeholder="Credit Card Number" required="required"/>
                                <div class="card-logos">
                                    <img src="/images/visa.png" alt="Visa"/>
                                    <img src="/images/master-card.png" alt="Master Card"/>
                                    <img src="/images/amex.png" alt="American Express"/>
                                    <img src="/images/discover.png" alt="Discover"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group expDateCvv">
                            <div>
                                <label for="sq-expiration-date">Expiration Date</label>
                                <input id="sq-expiration-date" class="form-control" name="sq-expiration-date" type="text" placeholder="MM/YY" required="required" />
                            </div>
                            <div>
                                <label for="cardCvv" class="required">CVV/CID <span class="glyphicon glyphicon-question-sign" data-html="true" data-toggle="tooltip" title="<img src='/images/cvv-graphic.png' alt='CVV Code' />"></span></label>
                                <input value="" class="form-control" id="sq-cvv" name="cardCvv" type="text" placeholder="CVV..." required="required"/>
                            </div>
                            <div>
                                <label>Zip Code</label>
                                <input type="text" id="sq-postal-code" name="sq-postal-code" class="form-control" placeholder="Zip Code" required="required" />
                                <input type="hidden" id="card-nonce" name="nonce">
                            </div>
                        </div>
                        <div id="errors"></div>
                    </fieldset>
                </div>
                <div>
                    <fieldset>
                        <legend>Overview</legend>
                        <input type="hidden" value="<?=$quote_details['quoteId']?>" name="quoteId" />
                        <input type="hidden" value="<?=$quote_details['carYear']?>" name="carYear" />
                        <input type="hidden" value="<?=$quote_details['carModel']?>" name="carModel" />
                        <input type="hidden" value="<?=$quote_details['carMake']?>" name="carMake" />
                        <input type="hidden" value="<?=$quote_details['carSize']?>" name="carSize" />
                        <input type="hidden" value="<?=$quote_details['pickUpDate']?>" name="pickUpDate" />
                        <input type="hidden" value="<?=$quote_details['transportType']?>" name="transportType" />
                        <input type="hidden" value="<?=$quote_details['pricePerSize']?>" name="pricePerSize" />
                        <input type="hidden" value="<?=$quote_details['publishedTotal']?>" name="publishedTotal" />
                        <input type="hidden" value="<?=$quote_details['carCondition']?>" name="carCondition" />
                        <input type="hidden" value="<?=$quote_details['convertible']?>" name="convertible" />
                        <input type="hidden" value="<?=$quote_details['modified']?>" name="modified" />
                        <input type="hidden" value="<?=$quote_details['distanceInMiles']?>" name="estimatedMileage" />
                        <?php
                            if($this->config->item('low_rates')){
                                $markup_amount = 50;
                                $priority_amount = 25;
                                $expedite_amount = 50;
                            }elseif($this->config->item('mid_rates')){
                                $markup_amount = 100;
                                $priority_amount = 50;
                                $expedite_amount = 100;
                            }else{
                                $markup_amount = 150;
                                $priority_amount = 75;
                                $expedite_amount = 150;
                            }
                        ?>
                        <input type="hidden" value="<?=$quote_details['pricePerDistance']+$markup_amount?>" name="baseServiceFee" />
                        <input type="hidden" value="" name="preciseMileage" id="preciseMileage" />
                        <input type="hidden" value="" name="origLat" id="origLat" />
                        <input type="hidden" value="" name="origLng" id="origLng" />
                        <input type="hidden" value="" name="destLat" id="destLat" />
                        <input type="hidden" value="" name="destLng" id="destLng" />
                        <table class="table table-striped table-bordered">
                            <colgroup>
                                <col width="50%" />
                                <col width="15%" />
                                <col width="35%" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td><div>The base shipping fee is</div></td>
                                    <td align="center"><div class="font2x">&#8674;</div></td>
                                    <td id="baseServiceFee" align="right" data-fee="<?=$quote_details['pricePerDistance']+$markup_amount?>">
                                        <?='$'.number_format($quote_details['pricePerDistance']+$markup_amount, 2, '.', '')?>
                                    </td>
                                </tr>
                                <!-- <?php if($quote_details['pricePerSize'] != 0):?>
                                    <tr>
                                        <td>Car size surcharge</td>
                                        <td align="center"><div class="font2x">&#8674;</div></td>
                                        <td align="right"><?='$'.number_format($quote_details['pricePerSize'], 2, '.', '')?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if($quote_details['carCondition'] == "false"):?>
                                    <tr>
                                        <td>Car doesn't run surcharge</td>
                                        <td align="center"><div class="font2x">&#8674;</div></td>
                                        <td align="right"><?='$'.number_format(150, 2, '.', '')?></td>
                                    </tr>
                                <?php endif; ?> -->
                                <?php if($this->uri->segment(2) == "priority"):?>
                                    <tr>
                                        <td>Priority surcharge</td>
                                        <td align="center"><div class="font2x">&#8674;</div></td>
                                        <td align="right">+ <?='$'.number_format($priority_amount, 2, '.', '')?></td>
                                    </tr>
                                <?php elseif($this->uri->segment(2) == "expedited"): ?>
                                    <tr>
                                        <td>Expedited surcharge</td>
                                        <td align="center"><div class="font2x">&#8674;</div></td>
                                        <td align="right">+ <?='$'.number_format($expedite_amount, 2, '.', '')?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr style="font-size:200%;">
                                    <td>Total</td>
                                    <td align="center"><div class="font2x">&#8674;</div></td>
                                    <?php
                                        if($this->uri->segment(2) == "priority"){
                                            $sub_total = $quote_details['priorityTotal'];
                                        }elseif ($this->uri->segment(2) == "expedited") {
                                            $sub_total = $quote_details['expeditedTotal'];
                                        }else{
                                            $sub_total = $quote_details['standardTotal'];
                                        }
                                    ?>
                                    <td id="quoteTotal" align="right" data-total="<?=$sub_total?>">
                                        <?='$'.number_format($sub_total, 2, '.', '')?>*
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr style="font-size:200%;">
                                    <td>Due TODAY</td>
                                    <td colspan="2" align="right"><?='$'.number_format(round($sub_total/100*20, 0, PHP_ROUND_HALF_UP), 2, '.', '')?>*</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <small>
                                            *Your card will NOT be charged until we have confirmed your service.<br />
                                            The amount "DUE TODAY" will be pre-authorized and later processed upon confirmation.
                                        </small>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <input id="serviceTotal" type="hidden" value="<?=$sub_total?>" name="serviceTotal" />
                        <input type="hidden" value="<?=$this->uri->segment(2)?>" name="serviceType" />
                        <input id="transactionId" type="hidden" value="" name="transactionId" />
                        <input id="transactionStatus" type="hidden" value="" name="transactionStatus" />
                    </fieldset>
                    <fieldset>
                        <legend>Transportation Agreement</legend>
                        <div id="agreementWrapper" class="form-group">
                            <input id="agreement" type="checkbox" value="" checked name="agreement" />
                            <label for="agreement">I agree to the <a href="/service_terms_and_conditions" target="blank">transportation terms and conditions</a></label>
                            <div id="agreementRequired">
                                <em>You are requierd to agree to the transportation terms and conditions.</em>
                            </div>
                        </div>
                    </fieldset>
                    <div id="bookServiceCTA">
                        <h3>Let's do this!</h3>
                        <div class="form-group-lg">
                            <script type="text/javascript">
                                var validateForm = function(response){
                                    var validFormData = APP.events.validateFormData();
                                    if(validFormData){
                                        var values = {input_value: response, <?=$this->security->get_csrf_token_name()?>: '<?=$this->security->get_csrf_hash()?>'};
                                        $.ajax({
                                            url: '/ajax/recaptcha',
                                            data: values,
                                            type: 'POST',
                                            dataType: 'json',
                                            success: function(success){
                                                if(success.success){
                                                    submitButtonClick();
                                                }else if(!success.success){
                                                    grecaptcha.reset();
                                                }
                                            }
                                        });
                                    }
                                };
                            </script>
                            <button id="card-nonce-submit" class="g-recaptcha btn btn-primary font150 btn-chevron fullWidth" data-sitekey="6LeQeBgUAAAAAJWKVMos5k9yh25F45gUl_oqXV47" data-callback="validateForm">Book Your Service Now</button>
                            <div id="formFailedMsg" class="font125">
                                Please check the fields! I think you missed something.
                            </div>
                        </div>
                        <small>Terms and conditions apply. Please visit the <a href="/terms_and_conditions">"Terms of Service"</a> page for additional information.</small>
                    </div>
                </div>
            </form>
        <?php elseif(!$quote_details): ?>
            <h1>The quote you are trying to book does not exist or it expired</h1>
            <hr />
            <h3>Would you like to generate a quote?</h3>
            <div class="form-group">
                <a href="/get_a_quote" class="btn btn-primary btn-lg btn-chevron">Get a quote now</a>
            </div>
        <?php endif; ?>
    </div>
</div>
