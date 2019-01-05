        </main>
        <?php if($data['page_class'] == 'homepage' || $data['page_class'] == 'getAquote' || $data['page_class'] == 'service'): ?>
            <div id="testimonials">
                <ul>
                    <li>
                        <div>
                            <span>Kathleen of Ocala, FL</span><span class="ratings">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                        </div>
                        <p>
                            I had an extremely excellent experience with Car Shippers of America. The person that I talked with on the phone was courteous and polite.
                        </p>
                    </li>
                    <li>
                        <div>
                            <span>Jeff of Atlanta, GA</span><span class="ratings">&#9733;&#9733;&#9733;&#9733;</span>
                        </div>
                        <p>
                            I bought a vehicle so I had to have it shipped and Car Shippers of America provided good service. Their reps were knowledgeable and answered all my questions.
                        </p>
                    </li>
                    <li>
                        <div>
                            <span>Brooke of Miami Beach, FL</span><span class="ratings">&#9733;&#9733;&#9733;&#9733;&#9733;</span>
                        </div>
                        <p>
                            I had a very last minute need to ship my car from New York to Miami Beach.
                            My car arrived on time, and everything went accoring to plan.
                        </p>
                    </li>
                    <li>
                        <div>
                            <span>George of Cape Coral, FL</span><span class="ratings">&#9733;&#9733;&#9733;&#9733;</span>
                        </div>
                        <p>
                            The customer service was better than what I expected. I like the online quote but I prefer to speak with someone just to be sure, and everything was great.
                        </p>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
        <div id="badgesAndSeals">
            <div>
                <img src="/images/c_a_badge.png" alt="Consumer Affairs Acredited" style="height:80px; width: auto;" />
            </div>
            <div>
                <img src="/images/guarantee_seal.png" alt="100% Guarantee" style="height:80px; width: auto;" />
            </div>
            <div>
                <img src="/images/pay-with-square.png" alt="Powered by Square" style="height:80px; width: auto;" />
            </div>
            <div>
                <!-- (c) 2005, 2017. Authorize.Net is a registered trademark of CyberSource Corporation -->
                <div class="AuthorizeNetSeal">
                    <script type="text/javascript" language="javascript">
                        var ANS_customer_id="243ec43b-077d-4a11-b79e-3869bc442a71";
                    </script>
                    <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
                    <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Merchant Services</a>
                </div>
            </div>
            <div>
                <span id="siteseal">
                    <script async type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=wYKAmsgNAhe63MqSx5X9tpy9ROS9hRThfpLTtnyfgQR42Tu0d66YEZsPyXfI"></script>
                </span>
            </div>

        </div>
        <footer>
            <div>
                <?php if($this->config->item('short_footer')): ?>
                    <div id="otherResources">
                        <h3>Other things you can do</h3>
                        <div>
                            <div>
                                <h4>Need a quote?</h4>
                                <a href="/get_a_quote" title="Home">Get a Quote here</a>
                            </div>
                            <div>
                                <h4>Already have a quote?</h4>
                                <a href="/retrieve_quote" title="Home">Retrieve your Quote here</a>
                            </div>
                            <div>
                                <h4>Have an active booking?</h4>
                                <a href="/review_booking" title="How It Works">Review your Booking here</a>
                            </div>
                            <div>
                                <h4>Status of your booking</h4>
                                <a href="/service_status" title="Service Status">Check the status here</a>
                            </div>
                            <div>
                                <h4>The legal stuff</h4>
                                <a href="/terms_and_conditions" title="Our Services">Service Terms</a> and
                                <a href="/privacy" title="Our Guarantee">Privacy</a>
                            </div>
                        </div>
                    </div>
                <?php elseif(!$this->config->item('short_footer')): ?>
                    <ul>
                        <li>
                            <a href="/" title="Home">Home<!--&#127968;--></a>
                        </li>
                        <li>
                            <a href="/how_it_works" title="How It Works">How It Works</a>
                        </li>
                        <li>
                            <a href="/our_services" title="Our Services">Our Services</a>
                        </li>
                        <li>
                            <a href="/our_guarantee" title="Our Guarantee">Our Guarantee</a>
                        </li>
                        <li>
                            <a href="/questions" title="Have Questions?">Have Questions?</a>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <a href="/get_a_quote" title="Home">Get a Quote</a>
                        </li>
                        <li>
                            <a href="/retrieve_quote" title="Home">Retrieve a Quote</a>
                        </li>
                        <li>
                            <a href="/review_booking" title="How It Works">Review Booking</a>
                        </li>
                        <li>
                            <a href="/service_status" title="Service Status">Service Status</a>
                        </li>
                        <li>
                            <a href="/terms_and_conditions" title="Our Services">Terms of Service</a>
                        </li>
                        <li>
                            <a href="/privacy" title="Our Guarantee">Privacy Policy</a>
                        </li>
                    </ul>
                    <ul>
                        <li class="phone-hide">
                            1001 NW 62ND STREET.<br />
                            SUITE 203<br />
                            Ft Lauderdale. FL, 33309.
                        </li>
                        <li>Toll Free: 800-687-6260</li>
                        <li>Local: 954-734-7223</li>
                        <li><a href="mailto:support@carshippersofamerica.com"><span itemprop="email">support@carshippersofamerica.com</span></a></li>
                        <li class="phone-hide"><a itemprop="url" href="http://carshippersofamerica.com/">www.CarShippersOfAmerica.com</a></li>
                    </ul>
                    <div id="topLinks">
                        <a target="blank" href="https://www.facebook.com/carshippersofamerica1/">
                            <img class="socialIcons" src="/svg/facebook.svg" title="Facebook"  />
                        </a>
                        <a target="blank" href="http://carshippersofamerica.business.site/">
                            <img class="socialIcons" src="/svg/google.svg" title="Google+"  />
                        </a>
                        <a target="blank" href="https://twitter.com/CarShippers1">
                            <img class="socialIcons" src="/svg/twitter.svg" title="Twitter"  />
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <div id="copyright"><?=$this->lang->line('footer_copyright')?></div>
            </div>
        </footer>


        <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/model.js"></script>
        <?php if($this->config->item('require_contact_info')):?>
            <script type="text/javascript">
                MODEL.data.progressTracker.stepSix = false;
            </script>
        <?php endif; ?>
        <?php if($data['page_class'] == 'homepage'): ?>
            <script type="text/javascript" src="/js/ajax.js"></script>
            <script>
                <?php echo "MODEL.data.geolocation =".$geolocation; ?>
            </script>
            <?php if($even_odd === 0):?>
                <script type="text/javascript" src="/js/quote_generator_static.js"></script>
            <?php elseif($even_odd !== 0):?>
                <script type="text/javascript" src="/js/quote_generator.js"></script>
            <?php endif; ?>
        <?php endif; ?>
        <?php if($data['page_class'] == 'getAquote'): ?>
            <script type="text/javascript" src="/js/ajax.js"></script>
            <script type="text/javascript" src="/js/quote_generator_static.js"></script>
        <?php endif; ?>
        <?php if($data['page_class'] == "service" && $quote_details != null): ?>
            <script type="text/javascript" src="/js/google_address.js"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8LTf5_09dK6M3Gw-AKTbLoc9ympafAFQ&libraries=places&callback=initAutocomplete" async defer></script>
            <script type="text/javascript" src="https://js.squareup.com/v2/paymentform"></script>
            <script type="text/javascript">
                var sqPaymentForm = new SqPaymentForm({
                    <?php if($this->config->item('square_sandbox') == TRUE): ?>
                        applicationId: 'sandbox-sq0idp-zjYozUTgoIPun6X1GlFChQ',
                    <?php elseif($this->config->item('square_sandbox') == FALSE): ?>
                        applicationId: 'sq0idp-zjYozUTgoIPun6X1GlFChQ',
                    <?php endif; ?>
                    inputClass: 'sq-input',
                    cardNumber: {
                        elementId: 'sq-card-number',
                        placeholder: "0000 0000 0000 0000"
                    },
                    cvv: {
                        elementId: 'sq-cvv',
                        placeholder: 'CVV'
                    },
                    expirationDate: {
                        elementId: 'sq-expiration-date',
                        placeholder: 'MM/YY'
                    },
                    postalCode: {
                        elementId: 'sq-postal-code',
                        placeholder: 'Postal Code'
                    },
                    inputStyles: [
                        {
                            fontSize: '14px',
                            padding: '3px'
                        },
                        {
                            mediaMaxWidth: '400px',
                            fontSize: '18px',
                        }
                    ],
                    callbacks: {
                        cardNonceResponseReceived: function(errors, nonce, cardData) {
                            if (errors) {
                                var errorDiv = document.getElementById('errors');
                                errorDiv.innerHTML = "";
                                errorDiv.style.display = "block";
                                errors.forEach(function(error) {
                                    var p = document.createElement('p');
                                    p.innerHTML = error.message;
                                    errorDiv.appendChild(p);
                                });
                                grecaptcha.reset();
                            } else {
                                var nonceField = document.getElementById('card-nonce');
                                nonceField.value = nonce;
                                var values = {
                                    nonce_value: nonce,
                                    dollar_amount: Math.round(parseInt($("#serviceTotal").val())/100*20),
                                    <?=$this->security->get_csrf_token_name()?>: '<?=$this->security->get_csrf_hash()?>'
                                };
                                $("#loading").css("display", "flex");
                                $.ajax({
                                    url: '/ajax/authorize_card',
                                    data: values,
                                    type: 'POST',
                                    dataType: 'json',
                                    success: function(success){
                                        if(success.transaction_id != null){
                                            $("#transactionId").val(success.transaction_id);
                                            $("#transactionStatus").val(success.transaction_status);
                                            document.getElementById('bookService').submit();
                                        }else if(success.error_message != null){
                                            $("#errors").text(success.error_message).fadeIn();
                                            grecaptcha.reset();
                                            $("#loading").css("display", "none");
                                            return false;
                                        }
                                    }
                                });
                            }
                        },
                        unsupportedBrowserDetected: function() {
                            // Alert the buyer that their browser is not supported
                        }
                    }
                });
                function submitButtonClick() {
                    sqPaymentForm.requestCardNonce();
                }
            </script>
            <script type="text/javascript">
                MODEL.data.quoteData = JSON.parse(JSON.stringify(<?=json_encode($quote_details)?>));
            </script>
        <?php endif; ?>
        <?php if($data['page_class'] == 'service' || $data['page_class'] == 'quoteDetails' ): ?>
            <script type="text/javascript" src="/js/ajax.js"></script>
        <?php endif; ?>
        <script type="text/javascript" src="/js/app.js"></script>
        <?php if($this->config->item('google_analytics')): ?>
            <script>
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-93838204-1', 'auto');
                ga('send', 'pageview');
            </script>
        <?php endif; ?>
        <?php if($this->config->item('use_heatmap')): ?>
            <script>
                (function(h,e,a,t,m,p) {
                m=e.createElement(a);m.async=!0;m.src=t;
                p=e.getElementsByTagName(a)[0];p.parentNode.insertBefore(m,p);
                })(window,document,'script','https://u.heatmap.it/log.js');
            </script>
        <?php endif; ?>
        <!--<script type="text/javascript" src="https://cdn.ywxi.net/js/1.js" async></script>-->
        <!--<script src="https://scripts.ninjacat.io/js.php?nt_id=7681880"></script>-->
    </body>
</html>
