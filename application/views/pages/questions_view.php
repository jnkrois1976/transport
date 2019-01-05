<div>
    <div>
        <h1 class="font4x">Let us know how we can help.</h1>
        <hr />
        <div id="contactUs">
            <?php if(!$this->config->item('short_footer')): ?>
                <div class="margin-top30">
                    <h3>24 hours a day 7 days a week.</h3>
                    <p class="margin-top30">
                        <h4>By Phone</h4>
                        Toll Free: 800-687-6260<br />
                        Local: 954-734-7223
                    </p>

                    <p class="margin-top30">
                    <h4>By Mail</h4>
                        1001 NW 62ND STREET SUITE 203<br />
                        Ft Lauderdale, FL 33309
                    </p>
                    <p class="margin-top30">
                        <h4>By Email</h4>
                        <a href="mailto:support@carshippersofamerica.com"><span itemprop="email">support@carshippersofamerica.com</span></a>
                    </p>
                </div>
            <?php endif; ?>
            <div>
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
                        <input type="text" name="Subject" value="" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="userMessage">Your message:</label>
                        <textarea name="Message" cols="40" rows="10" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <input id="userMessage" type="submit" value="Send your message" class="btn btn-primary font150"/>
                    </div>
                </form>
            </div>
            <div id="messageConfirmation" class="display-none center-text margin-top30 margin-bottom30">
                <h2>Your message has been sent!<br />Thanks</h2>
                <span class="glyphicon glyphicon-ok" style="font-size: 80px; color:#95cc28;"></span>
            </div>
        </div>
    </div>
    <?php $this->load->view('/includes/generator_banner_view'); ?>
</div>
