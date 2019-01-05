<div>
    <div>
        <div id="orderNumber">
            <span class="font3x">Your service has been booked.</span><span class="font3x">Order #<?="CSSN-".$booking_details['id']?> </span>
        </div>
        <hr />
        <div id="detailsBreakdown">
            <div class="breakdownBox">
                <h3>Service Details</h3>
                <table class="table table-striped table-bordered">
                    <colgroup>
                        <col width="40%" />
                        <col width="10%" />
                        <col width="50%" />
                    </colgroup>
                    <tr>
                        <td><div>We are picking up your car at:</div></td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$booking_details['full_orig_address']?></td>
                    </tr>
                    <tr>
                        <td>And it's going to</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$booking_details['full_dest_address']?></td>
                    </tr>
                    <tr>
                        <td>We'd be shipping a</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$booking_details['car_make']." ".$booking_details['car_model']." - ".$booking_details['car_year']?></td>
                    </tr>
                    <tr>
                        <td>You want it shipped on</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=date("F jS, Y", strtotime($booking_details['requested_date']))?></td>
                    </tr>
                    <tr>
                        <td>The car </td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=($booking_details['car_condition'] == 'true')? "Runs fine":"Does NOT run"?></td>
                    </tr>
                    <tr>
                        <td>And you want it shipped in an</td>
                        <td align="center"><div class="font2x">&#8674;</div></td>
                        <td><?=$booking_details['transport_type']?></td>
                    </tr>
                </table>
            </div>
            <div class="breakdownBox">
                <h3>Cost breakdown.</h3>
                <table class="table table-striped table-bordered">
                    <colgroup>
                        <col width="55%" />
                        <col width="10%" />
                        <col width="35%" />
                    </colgroup>
                    <tbody>
                        <tr>
                            <td><div>The base shipping fee is</div></td>
                            <td align="center"><div class="font2x">&#8674;</div></td>
                            <td id="baseServiceFee" align="right">
                                <?='$'.number_format($booking_details['base_fee'], 2, '.', '')?>
                            </td>
                        </tr>
                        <!-- <?php if($booking_details['price_per_size'] != 0):?>
                            <tr>
                                <td>Car size surcharge</td>
                                <td align="center"><div class="font2x">&#8674;</div></td>
                                <td align="right"><?='$'.number_format($booking_details['price_per_size'], 2, '.', '')?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if($booking_details['car_condition'] == "false"):?>
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
                        <?php if($booking_details['service_type'] == "priority"):?>
                            <tr>
                                <td>Priority surcharge</td>
                                <td align="center"><div class="font2x">&#8674;</div></td>
                                <td align="right"><?='$'.number_format($priority_amount, 2, '.', '')?></td>
                            </tr>
                        <?php elseif($booking_details['service_type'] == "expedited"): ?>
                            <tr>
                                <td>Expedited surcharge</td>
                                <td align="center"><div class="font2x">&#8674;</div></td>
                                <td align="right"><?='$'.number_format($expedite_amount, 2, '.', '')?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td colspan="3">
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font-size: 200%;">Total</span><br /> (pre-authorization)</td>
                            <td align="center" style="font-size: 200%;">&#8674;</td>
                            <td id="quoteTotal" align="right" style="font-size: 200%;">
                                <?='$'.number_format($booking_details['service_total'], 2, '.', '')?>*
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <small>*Once the service is confirmed, we will process the charges automatically and you will receive a notification.</small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div>
            <p class="font3x">
                What now?
            </p>
            <div id="whatNow">
                <span>
                    Well, we will send you a follow up email<br /> to let you know about the pick up date and time.
                </span>
                <span>
                    You can call us if you need:<br />
                    <strong class="font2x">Local: 954-734-7223<br />
                    Toll free: 800-687-6260</strong>
                </span>
                <span>
                    You can also email us:<br />
                    <strong class="font2x">
                        <a href="mailto:support@carshippersofamerica.com"><span itemprop="email">support@carshippersofamerica.com</span></a>
                    </strong>
                </span>
            </div>
        </div>
    </div>
</div>
