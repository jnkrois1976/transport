<div>
    <div>
        <h1 class="font4x">Your quote details</h1>
        <hr />
        <?php if($quote_details): ?>
            <div id="detailsBreakdown">
                <div class="breakdownBox">
                    <h3>Let's see what we got here</h3>
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col width="40%" />
                            <col width="10%" />
                            <col width="50%" />
                        </colgroup>
                        <tr>
                            <td><div>Your car is in </div></td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td><?=$quote_details['originCity']." - ".$quote_details['originZip']?></td>
                        </tr>
                        <tr>
                            <td>And it's going to</td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td><?=$quote_details['destCity']." - ".$quote_details['destZip']?></td>
                        </tr>
                        <tr>
                            <td>We'd be shipping a</td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td><?=$quote_details['carMake']." ".$quote_details['carModel']." - ".$quote_details['carYear']?></td>
                        </tr>
                        <tr>
                            <td>You want it shipped on</td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td><?=date("F jS, Y", strtotime($quote_details['pickUpDate']))?></td>
                        </tr>
                        <tr>
                            <td>The car </td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td><?=($quote_details['carCondition'] == 'true')? "Runs fine":"Does NOT run"?></td>
                        </tr>
                        <tr>
                            <td>And you want it shipped in an</td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td><?=$quote_details['transportType']?></td>
                        </tr>
                    </table>
                </div>
                <div class="breakdownBox">
                    <h3>What is it going to cost?</h3>
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
                    <table class="table table-striped table-bordered">
                        <colgroup>
                            <col width="40%" />
                            <col width="10%" />
                            <col width="50%" />
                        </colgroup>
                        <tr>
                            <td><div>The base shipping fee is</div></td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td align="right"><?='$'.number_format($quote_details['pricePerDistance']+$markup_amount, 2, '.', '')?></td>
                        </tr>
                        <!-- <tr>
                            <td>Car size surcharge</td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td align="right"><?='$'.number_format($quote_details['pricePerSize'], 2, '.', '')?></td>
                        </tr> -->
                        <!-- <?php if($quote_details['carCondition'] == "false"):?>
                            <tr>
                                <td>Car doesn't run surcharge</td>
                                <td align="center"><div class="font2x">&#8674;</div></td>
                                <td align="right"><?='$'.number_format(150, 2, '.', '')?></td>
                            </tr>
                        <?php endif; ?> -->
                        <?php
                            if($this->config->item('low_rates')){
                                $priority_amount = 25;
                                $expedite_amount = 50;
                            }elseif($this->config->item('mid_rates')){
                                $priority_amount = 50;
                                $expedite_amount = 100;
                            }else{
                                $priority_amount = 75;
                                $expedite_amount = 150;
                            }
                        ?>
                        <tr>
                            <td>Priority surcharge <strong>(if selected)</strong></td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td align="right">+ <?='$'.number_format($priority_amount, 2, '.', '')?></td>
                        </tr>
                        <tr>
                            <td>Expedited surcharge <strong>(if selected)</strong></td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td align="right">+ <?='$'.number_format($expedite_amount, 2, '.', '')?></td>
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
                                <?='$'.number_format($sub_total, 2, '.', '')?>
                            </td>
                        </tr>
                        <?php if(!$require_contact_info): ?>
                            <tr>
                                <td colspan="3" style="vertical-align: top;">
                                    <div id="saveQuoteDetails">
                                        <div class="font150">Save this quote and lock your price.</div>
                                        <div class="form-group">
                                            <button class="btn btn-info font600" id="saveQuote">Save this quote</button>
                                        </div>
                                    </div>
                                    <div style="display:block;">
                                        <small>
                                            Rates are subject to change. Save this quote and lock the rate for 7 days.<br />
                                            We'll send you an email that with the quote ID number that you can use to retrieve it and book your service.<br />
                                            I promise that I'll only use your email for the purposes of this quote.
                                        </small>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <hr />
            <div id="generatedQuote">
                <div class="userQuote">
                    <h3>Standard Shipping</h3>
                    <div id="stdShippPrice" class="font4x dollarAmount"><?='$'.number_format($quote_details['standardTotal'], 2, '.', '')?></div>
                    <div class="form-group">
                        <a href="/book_service_v2/standard" class="btn btn-primary font150" type="submit" value="stdQuote">Book Standard Shipping<sup>*</sup></a>
                    </div>
                    <small><sup>*</sup>Within 7 days of requested date</small>
                </div>
                <div class="userQuote">
                    <h3>Priority Shipping</h3>
                    <div id="prioShippPrice" class="font4x dollarAmount"><?='$'.number_format($quote_details['priorityTotal'], 2, '.', '')?></div>
                    <div class="form-group">
                        <a href="/book_service_v2/priority" class="btn btn-primary font150" type="submit" value="stdQuote">Book Priority Shipping<sup>*</sup></a>
                    </div>
                    <small><sup>*</sup>Within 3-4 days of requested date</small>
                </div>
                <div class="userQuote">
                    <h3>Expedited Shipping</h3>
                    <div id="expShippPrice" class="font4x dollarAmount"><?='$'.number_format($quote_details['expeditedTotal'], 2, '.', '')?></div>
                    <div class="form-group">
                        <a href="/book_service_v2/expedited" class="btn btn-primary font150" type="submit" value="stdQuote">Book Expedited Shipping<sup>*</sup></a>
                    </div>
                    <small><sup>*</sup>Within 1-2 days of requested date</small>
                </div>
            </div>
        <?php elseif(!$quote_details): ?>
            That quote does not exist or has expired
        <?php endif; ?>
    </div>
    <?php
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
    ?>
    <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
    <?php $this->load->view('/includes/save_quote_modal_view'); ?>
</div>
