<div class="modal fade" tabindex="-1" role="dialog" id="contactInfoModal" data-show="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">A great quote just a click away!</h2>
            </div>
            <div class="modal-body">
                <form id="saveQuoteForm" method="post" action="">
                    <p>
                        In order to generate your <strong>Instant Quote</strong>, please provide the following info.
                    </p>
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
                    <small>
                        We take your privacy extremely seriously, and we never sell lists or email addresses.<br />
                        Please take a look at our <a href="/privacy">Privacy Policy</a> for details.
                    </small>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                <button id="proceedToQuote" type="button" class="btn btn-info" data-currentstep="stepFive" data-nextstep="stepSix">Get your quote</button>
            </div>
        </div>
    </div>
</div>
