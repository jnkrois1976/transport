<div>
    <?php if($status): ?>
        <div>
            <h1>Your Service Status</h1>
            <?php
                $current_status = "Processing";
                $created = "";
                $processing = "";
                $confirmed = "";
                $dispatched = "";
                $pickedup = "";
                $delivered = "";
                switch ($status->status->value) {
                    case 'Saved':
                        $current_status = "Processing";
                        $created = "is-active";
                        break;
                    case 'OnHold':
                        $current_status = "Processing";
                        $created = "is-active";
                        $processing = "is-active";
                        break;
                    case 'Active':
                        $current_status = "Processing";
                        $created = "is-active";
                        $processing = "is-active";
                        break;
                    case 'Booked':
                        $current_status = "Confirmed";
                        $created = "is-active";
                        $processing = "is-active";
                        $confirmed = "is-active";
                        break;
                    case 'Deleted':
                        $current_status = "Deleted";
                        break;
                    case 'Closed':
                        $current_status = "Deleted";
                        break;
                    case 'Archived':
                        $current_status = "Deleted";
                        break;
                    default:
                        $current_status = "Processing";
                        break;
                }
                if(isset($status->transitStatus)){
                    switch ($status->transitStatus->value) {
                        case 'ReadyForDispatch':
                            $current_status = "Confirmed";
                            $created = "is-active";
                            $processing = "is-active";
                            $confirmed = "is-active";
                            $dispatched = "";
                            $pickedup = "";
                            $delivered = "";
                            break;
                        case 'Dispatched':
                            $current_status = "Dispatched";
                            $created = "is-active";
                            $processing = "is-active";
                            $confirmed = "is-active";
                            $dispatched = "is-active";
                            $pickedup = "";
                            $delivered = "";
                            break;
                        case 'PickedUp':
                            $current_status = "Picked Up";
                            $created = "is-active";
                            $processing = "is-active";
                            $confirmed = "is-active";
                            $dispatched = "is-active";
                            $pickedup = "is-active";
                            $delivered = "";
                            break;
                        case 'Delivered':
                            $current_status = "Delivered";
                            $created = "is-active";
                            $processing = "is-active";
                            $confirmed = "is-active";
                            $dispatched = "is-active";
                            $pickedup = "is-active";
                            $delivered = "is-active";
                            break;
                        default:
                            $current_status = "Processing";
                            break;
                    }
                }

            ?>
            <p class="font150">The current status of your service is: <strong><em><?=$current_status?></em></strong></p>
            <div class="progress-bar six-states">
                <div class="progress-bar-state <?=$created?>">Created&nbsp;<span class="glyphicon glyphicon-ok"></span></div>
                <div class="progress-bar-state <?=$processing?>">Processing&nbsp;<span class="glyphicon glyphicon-ok"></span></div>
                <div class="progress-bar-state <?=$confirmed?>">Confirmed&nbsp;<span class="glyphicon glyphicon-ok"></span></div>
                <div class="progress-bar-state <?=$dispatched?>">Dispatched&nbsp;<span class="glyphicon glyphicon-ok"></span></div>
                <div class="progress-bar-state <?=$pickedup?>">Picked Up&nbsp;<span class="glyphicon glyphicon-ok"></span></div>
                <div class="progress-bar-state <?=$delivered?>">Delivered&nbsp;<span class="glyphicon glyphicon-ok"></span></div>
            </div>
            <hr />
            <div id="serviceStatusWrapper">
                <div>
                    <p class="font2x">Service number: <?=$this->input->post('bookingId')?> - Details</p>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Vehicle</td>
                                <td><?=$status->title?></td>
                            </tr>
                            <tr>
                                <td>Travel Distance</td>
                                <td><?=$status->route->distance->label?></td>
                            </tr>
                            <tr>
                                <td>Pick up location</td>
                                <td>
                                    <?=$status->route->items[0]->address->streetAddress.", ".$status->route->items[0]->address->label.", ".$status->route->items[0]->address->postalCode?>
                                </td>
                            </tr>
                            <tr>
                                <td>Pick up timeframe</td>
                                <td>
                                    <?php
                                        $break_date_one = explode("T", $status->route->items[0]->timeFrame->earliestArrival);
                                        $break_date_two = explode("T", $status->route->items[0]->timeFrame->latestArrival);
                                        $break_date_three = explode("T", $status->route->items[1]->timeFrame->earliestArrival);
                                        $earliest = date("F jS, Y", strtotime($break_date_one[0]));
                                        $latest = date("F jS, Y", strtotime($break_date_two[0]));
                                        $drop_off = date("F jS, Y", strtotime($break_date_three[0]));
                                    ?>
                                    <?=$earliest." - ".$latest?>
                                </td>
                            </tr>
                            <tr>
                                <td>Drop off location</td>
                                <td>
                                    <?=$status->route->items[1]->address->streetAddress.", ".$status->route->items[1]->address->label.", ".$status->route->items[1]->address->postalCode?>
                                </td>
                            </tr>
                            <tr>
                                <td>Estimated drop off date</td>
                                <td>
                                    <?=$drop_off?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <p class="font2x">
                        Have a question?
                    </p>
                    <form id="user_message" action="/ajax/user_message" method="post">
                        <fieldset>
                            <?php
                                $csrf = array(
                                    'name' => $this->security->get_csrf_token_name(),
                                    'hash' => $this->security->get_csrf_hash()
                                );
                            ?>
                            <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                            <div class="form-group">
                                <label for="userName">Your name:</label>
                                <input type="text" name="Name" value="" placeholder="Full name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="userEmail">Your email:</label>
                                <input type="email" name="Email" value="" placeholder="Your email" size="40" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="subject">Subject:</label>
                                <input type="text" name="Subject" value="<?=$this->input->post('bookingId')?>" readonly class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="userMessage">Your message:</label>
                                <textarea name="Message" cols="40" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <input id="userMessage" type="submit" value="Send your message" class="btn btn-primary font150"/>
                            </div>
                        </fieldset>
                    </form>
                    <div id="messageConfirmation" class="display-none center-text margin-top30 margin-bottom30">
                        <h2>Your message has been sent!<br />Thanks</h2>
                        <span class="glyphicon glyphicon-ok" style="font-size: 80px; color:#95cc28;"></span>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif(!$status): ?>
        <div>
            <h1>Check the status of your service</h1>
            <hr />
            <p>
                Do you have a service number?<br /><br />
                Type it in the text field below and retrieve it.
            </p>
            <form action="/check_service_status" method="post" class="form-inline">
                <?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );
                ?>
                <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
                <div class="form-group">
                    <label>Your service number</label>
                    <input type="text" class="form-control input-lg" value="" placeholder="your booking number" name="bookingId" />
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary font150 btn-chevron">Check Status</button>
                </div>
            </form>
        </div>
        <?php $this->load->view('/includes/generator_banner_view'); ?>
    <?php endif; ?>
</div>

<?php
    // echo "<pre>";
    // print_r($status->status->value);
    // echo "</pre>";
    //
    // echo "<pre>";
    // print_r($status);
    // echo "</pre>";
?>
