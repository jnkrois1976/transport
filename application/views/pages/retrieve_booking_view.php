<div>
    <div>
        <h1>Retrieve your booking</h1>
        <hr />
        <p>
            Do you have a booking number?<br /><br />
            Type it in the text field below and retrieve it.
        </p>
        <form action="/retrieve_booking_details" method="post" class="form-inline">
            <?php
                $csrf = array(
                    'name' => $this->security->get_csrf_token_name(),
                    'hash' => $this->security->get_csrf_hash()
                );
            ?>
            <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <div class="form-group">
                <label>Your booking number</label>
                <input type="text" class="form-control input-lg" value="" placeholder="your booking number" name="bookingId" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary font150 btn-chevron">Retrieve your booking</button>
            </div>
        </form>
    </div>
    <?php $this->load->view('/includes/generator_banner_view'); ?>
</div>
