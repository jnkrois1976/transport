<div class="modal fade" tabindex="-1" role="dialog" id="saveQuoteModal" data-show="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h2 class="modal-title">Good idea to save this quote</h2>
            </div>
            <div class="modal-body">
                <div id="saveSuccess">
                    <h4>Your quote was saved succesfully</h4>
                    <p>Here's your quote ID number:</p>
                    <p id="quoteIdNumber" class="font4x"></p>
                    <p>
                        This quote will be valid for 7 days from today.<br />
                        I sent you an email with the quote details and this ID number.
                    </p>
                </div>
                <form id="saveQuoteForm" method="post" action="">
                    <p>
                        I'll generate a quote ID number that you can use to retrieve this quote later.<br />
                        This quote will be saved for 7 days and it will lock your price for when you are ready to book your service.
                    </p>
                    <div class="form-group">
                        <label for="usrEmail">Your Email <small>(Required*)</small></label>
                        <input type="email" class="form-control" name="usrEmail" id="usrEmail" value="" placeholder="Your email..." required="required" />
                    </div>
                    <div class="form-group">
                        <label for="usrName">Your Name <small>(Optional)</small></label>
                        <input type="text" class="form-control" name="usrName" id="usrName" value="" placeholder="Your name..." />
                    </div>
                    <div class="form-group">
                        <label for="usrPhone">Your Phone <small>(Optional)</small></label>
                        <input type="tel" class="form-control" name="usrPhone" id="usrPhone" value="" placeholder="Your phone..." />
                    </div>
                    <small>
                        We take your privacy extremely seriously, and we never sell lists or email addresses.<br />
                        Please take a look at our <a href="/privacy">Privacy Policy</a> for details.
                    </small>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="saveMyQuote" type="button" class="btn btn-info">Save your quote</button>
            </div>
        </div>
    </div>
</div>
