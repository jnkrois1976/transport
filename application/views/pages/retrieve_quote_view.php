<div>
    <div>
        <h1>Retrieve your quote</h1>
        <hr />
        <p>
            Do you have a quote id?<br /><br />
            Type it in the text field below and retreive it.
        </p>
        <form action="/retrieve_quote_details" method="post" class="form-inline">
            <?php
                $csrf = array(
                    'name' => $this->security->get_csrf_token_name(),
                    'hash' => $this->security->get_csrf_hash()
                );
            ?>
            <input id="csrf_token" type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>" />
            <div class="form-group">
                <label>Your quote Id</label>
                <input type="text" class="form-control input-lg" value="" placeholder="your quote id" name="quoteId" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary  font150 btn-chevron">Retrieve your quote</button>
            </div>
        </form>
    </div>
    <?php $this->load->view('/includes/generator_banner_view'); ?>
</div>
