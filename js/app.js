var APP = APP || {};

APP.events = {
    welcomeBack: function(){
        var retrieveQuote = localStorage.getItem('instantQuote'),
            dateObj = new Date(),
            month = dateObj.getUTCMonth() + 1,
            day = dateObj.getUTCDate(),
            year = dateObj.getUTCFullYear(),
            today = year + "-" + month + "-" + day,
            storageObj = JSON.parse(retrieveQuote),
            defaultHref = '/quote_details',
            quoteDate = (storageObj != null)? storageObj.quoteDate: today;
            MODEL.data.quoteData.quoteDate = today;
        if(retrieveQuote && today != quoteDate){
            $("#welcomeBack").modal({
                backdrop: 'static',
                show: true
            });
            var version = $("#loadQuote").attr("data-version")+"/";
            $("#loadQuote").attr('href', defaultHref+ version + storageObj.quoteId);
        }
    },
    deleteQuote: function(){
        localStorage.removeItem('instantQuote');
    },
    deleteQuoteEvent: function(){
        var deleteQuoteBtn = document.getElementById('deleteQuote');
        if(deleteQuoteBtn !== null){
            deleteQuoteBtn.addEventListener('click', this.deleteQuote, false);
        }
    },
    openMenu: function(elem){
        $(elem.target).toggleClass('glyphicon-align-justify');
        $('#siteNav').fadeToggle('fast');
    },
    openMenuListener: function(){
        var menuIcon = document.getElementById('menuIcon');
        menuIcon.addEventListener('click', this.openMenu, false);
    },
    retrieveQuoteData: function(){
        if(localStorage.getItem('instantQuote') != null){
            MODEL.data.quoteData = JSON.parse(localStorage.getItem('instantQuote'));
        }
    },
    updateBaseFee: function(distance){
        var getBaseShippingFee = $("#baseServiceFee").attr("data-fee");
        var getQuoteTotal = $("#quoteTotal").attr("data-total");
        var getNumber = distance.replace(" mi", "");
        getNumber = getNumber.replace(",", "");
        var newBaseFee = (MODEL.data.quoteData.transportType == "OpenTransport")? (getNumber * 0.5) + 150: (getNumber * 1) + 150;
        $("#baseServiceFee").text("$"+parseInt(newBaseFee)+".00");
        $("#serviceTotal").val(newBaseFee);
        var newTotal = (parseInt(getQuoteTotal) - parseInt(getBaseShippingFee)) + newBaseFee;
        $("#quoteTotal").text("$"+parseInt(newTotal)+".00");
    },
    validateFormData: function(event){
        var validateFields = $('input[required]').get(), allFieldsComplete = true;
        for(var i = 0; i < validateFields.length; i++){
            var fieldState = validateFields[i].validity.valueMissing;
            var fieldIsValid = validateFields[i].validity.valid;
            if(fieldState && !fieldIsValid){
                allFieldsComplete = false;
                validateFields[i].classList.add('invalid');
                $("#formFailedMsg").fadeIn();
                grecaptcha.reset();
                return allFieldsComplete;
            }
        }
        if(allFieldsComplete){
            $("#formFailedMsg").hide();
            return allFieldsComplete;
        }
    },
    generateLead: function(){
        AJAX.calls.generateLead();
    },
    validateContactInfo: function(event){
        var leadContactInfoElems = MODEL.domElems.contactLead, validInputElem, allContactFields = false;
        for(var i = 0; i < leadContactInfoElems.length; i++){
            validInputElem = leadContactInfoElems[i].value;
            if(validInputElem.length > 0){
                MODEL.data.quoteData[leadContactInfoElems[i].name] = leadContactInfoElems[i].value;
                allContactFields = true;
            }else{
                allContactFields = false;
                return false;
            }
        }
        if(allContactFields){
            APP.events.generateLead();
        }
    },
    contactInfoEvent: function(){
        var contactInfoElems = MODEL.domElems.contactLead, inputElem;
        for(var i = 0; i < contactInfoElems.length; i++){
            inputElem = contactInfoElems[i];
            inputElem.addEventListener('change', this.validateContactInfo, false);
        }
    },
    contactUs: function(event){
        event.preventDefault();
        var values = {
            csrf_token: $('input[name=csrf_token]').val(),
            Name: $('input[name=Name]').val(),
            Email: $('input[name=Email]').val(),
            Subject: $('input[name=Subject]').val(),
            Message: $('textarea[name=Message]').val()
        };
        $.ajax({
            url: '/ajax/user_message',
            data: values,
            type: 'POST',
            dataType: 'text',
            success: function(success){
                if(success){
                    $('#user_message').hide();
                    $('#messageConfirmation').fadeIn('fast');
                }else{
                    // there was an error
                }
            }
        });
    },
    contactUsEvent: function(){
        var userMessage = document.getElementById('userMessage');
        if(userMessage != null){
            userMessage.addEventListener('click', this.contactUs, false);
        }
    },
    saveQuoteModal: function(event){
        event.preventDefault();
        $("#saveSuccess").hide();
        $("#saveQuoteForm, #saveMyQuote").show();
        $("#quoteIdNumber").text("");
        $("#saveQuoteModal").modal({
            backdrop: 'static',
            show: true
        });
    },
    saveQuote: function(){
        var saveQuoteBtn = document.getElementById('saveQuote');
            if(saveQuoteBtn !== null){
                saveQuoteBtn.addEventListener('click', this.saveQuoteModal, false);
            }
    },
    saveMyQuote: function(){
        var saveMyQuoteBtn = document.getElementById('saveMyQuote');
        if(saveMyQuoteBtn !== null){
            saveMyQuoteBtn.addEventListener('click', AJAX.calls.saveMyQuote, false);
        }
    },
    agreeToTerms: function(event){
        //event.preventDefault();
        var elem = event.target, state = event.target.checked;
        if(!state){
            MODEL.domElems.bookService.disabled = true;
            MODEL.domElems.agreementRequired.style.display = 'block';
        }else{
            MODEL.domElems.bookService.disabled = false;
            MODEL.domElems.agreementRequired.style.display = 'none';
        }
    },
    agreementEvent: function(){
        var agreementBtn = MODEL.domElems.agreement;
        if(agreementBtn != null){
            agreementBtn.addEventListener('click', this.agreeToTerms, true);
        }
    }
}

APP.events.welcomeBack();
APP.events.openMenuListener();
APP.events.contactUsEvent();
APP.events.retrieveQuoteData();
APP.events.deleteQuoteEvent();
//APP.events.contactInfoEvent();
APP.events.saveQuote();
APP.events.saveMyQuote();
APP.events.agreementEvent();
