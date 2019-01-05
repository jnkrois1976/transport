<div>
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
</div>
