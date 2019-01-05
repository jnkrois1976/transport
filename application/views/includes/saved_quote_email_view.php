<div>
    <div>
        <h1 class="font4x">Your quote id number: <?=$saved_quote_details['quoteId']?></h1>
        <hr />
        <div id="detailsBreakdown">
            <div class="breakdownBox">
                <table class="table table-striped table-bordered">
                    <colgroup>
                        <col width="40%" />
                        <col width="10%" />
                        <col width="50%" />
                    </colgroup>
                    <tr>
                        <td><div>Your car is in </div></td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$saved_quote_details['originCity']." - ".$saved_quote_details['originZip']?></td>
                    </tr>
                    <tr>
                        <td>And it's going to</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$saved_quote_details['destCity']." - ".$saved_quote_details['destZip']?></td>
                    </tr>
                    <tr>
                        <td>We'd be shipping a</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$saved_quote_details['carMake']." ".$saved_quote_details['carModel']." - ".$saved_quote_details['carYear']?></td>
                    </tr>
                    <tr>
                        <td>You want it shipped on</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=date("F jS, Y", strtotime($saved_quote_details['pickUpDate']))?></td>
                    </tr>
                    <tr>
                        <td>The car </td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=($saved_quote_details['carCondition'] == 'true')? "Runs fine":"Does NOT run"?></td>
                    </tr>
                    <tr>
                        <td>And you want it shipped in an</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$saved_quote_details['transportType']?></td>
                    </tr>
                    <!-- <tr>
                        <td><div>The base shipping fee is</div></td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td align="right"><?='$'.number_format($saved_quote_details['standardTotal'], 2, '.', '')?></td>
                    </tr> -->
                    <!-- <tr>
                        <td>Car size surcharge</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td align="right"><?='$'.number_format($saved_quote_details['pricePerSize'], 2, '.', '')?></td>
                    </tr>
                    <?php if($saved_quote_details['carCondition'] == "false"):?>
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
                    <!-- <tr>
                        <td>Priority surcharge (if selected)</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td align="right"><?='$'.number_format($priority_amount, 2, '.', '')?></td>
                    </tr>
                    <tr>
                        <td>Expedited surcharge (if selected)</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td align="right"><?='$'.number_format($expedite_amount, 2, '.', '')?></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td align="right"><?='$'.number_format($saved_quote_details['standardTotal'], 2, '.', '')?></td>
                    </tr> -->
                </table>
            </div>
        </div>
        <hr />
        <!-- <div id="generatedQuote">
            <div class="userQuote">
                <h3>Standard Shipping</h3>
                <div id="stdShippPrice" class="font4x dollarAmount"><?=//'$'.number_format($saved_quote_details['standardTotal'], 2, '.', '')?>*</div>
                <div class="form-group">
                    <a href="<?=base_url()?>book_service_v1/standard/<?=//$saved_quote_details['quoteId']?>" class="btn btn-primary" type="submit" value="stdQuote">Book Standard Shipping<sup>**</sup></a>
                </div>
                <small><sup>**</sup>Within 7 days of requested date</small>
            </div>
            <div class="userQuote">
                <h3>Priority Shipping</h3>
                <div id="prioShippPrice" class="font4x dollarAmount"><?=//'$'.number_format($saved_quote_details['priorityTotal'], 2, '.', '')?>*</div>
                <div class="form-group">
                    <a href="<?=base_url()?>book_service_v1/priority/<?=//$saved_quote_details['quoteId']?>" class="btn btn-primary" type="submit" value="stdQuote">Book Priority Shipping<sup>**</sup></a>
                </div>
                <small><sup>**</sup>Within 3-4 days of requested date</small>
            </div>
            <div class="userQuote">
                <h3>Expedited Shipping</h3>
                <div id="expShippPrice" class="font4x dollarAmount"><?=//'$'.number_format($saved_quote_details['expeditedTotal'], 2, '.', '')?>*</div>
                <div class="form-group">
                    <a href="<?=base_url()?>book_service_v1/expedited/<?=//$saved_quote_details['quoteId']?>" class="btn btn-primary" type="submit" value="stdQuote">Book Expedited Shipping<sup>**</sup></a>
                </div>
                <small><sup>**</sup>Within 1-2 days of requested date</small>
            </div>
        </div> -->
    </div>
</div>
