var APP = APP || {};

APP.elems = MODEL.domElems;

APP.quoteGenerator = {
    geolocation: function(){
        if(MODEL.data.geolocation != null){
            $("#originZip").val(MODEL.data.geolocation.zip);
            MODEL.data.quoteData.originZip = MODEL.data.geolocation.zip;
            MODEL.data.quoteData.originCity = MODEL.data.geolocation.city+", "+MODEL.data.geolocation.region;
            if(vendorRates){
                MODEL.data.vendorRates.route.items[0].address.postalCode = MODEL.data.geolocation.zip;
            }
        }
    },
    zipCityEvent: function(event){
        var keyupEvent,
            targetElem = event.target,
            inputValueLength = targetElem.value.length
            suggestElem = targetElem.nextElementSibling;
        if(keyupEvent){
            clearTimeout(keyupEvent);
        }
        keyupEvent = setTimeout(function(){
            if(inputValueLength >= 3){
                var inputValue = targetElem.value,
                    suggestType = targetElem.dataset.suggest;
                AJAX.calls.zipCityLookup(targetElem, inputValue, suggestType);
            }else if(inputValueLength < 3){
                while(suggestElem.hasChildNodes()){
                    suggestElem.removeChild(suggestElem.lastChild);
                }
                if(inputValueLength == 0){
                    suggestElem.style.display='none';
                }
            }
        }, 500);
    },
    hideSuggestBox: function(event){
        var targetElem = event.target.nextElementSibling;
        targetElem.style.display='none';
    },
    zipCitySuggest: function(){
        var zipCityInput = APP.elems.zipCityInput, inputElem;
        for(var i = 0; i < zipCityInput.length; i++){
            inputElem = zipCityInput[i];
            inputElem.addEventListener('keyup', this.zipCityEvent, false);
            inputElem.addEventListener('blur', this.hideSuggestBox, false);
        }
    },
    progressTracker: function(event){
        var parentElem = event.target.parentNode,
        siblingInput = event.target.parentNode.previousElementSibling,
        index = siblingInput.dataset.index,
        nextStep = siblingInput.dataset.nextstep,
        currentStep = siblingInput.dataset.currentstep,
        completeIcon = siblingInput.dataset.mobileicon,
        completeStep = siblingInput.dataset.displayone.parentNode,
        suggestData = event.target.innerText,
        breakData = suggestData.split(" - ");
        MODEL.data.progressTracker[currentStep] = true;
        if(siblingInput.dataset.suggest == 'zipcode'){
            siblingInput.value=breakData[0];
            MODEL.data.quoteData[siblingInput.id] = breakData[0];
            MODEL.data.quoteData[siblingInput.dataset.match] = breakData[1];
            if(siblingInput.dataset.index == '0'){
                APP.elems.zipCityInput[1].value = breakData[1];
            }else{
                APP.elems.zipCityInput[3].value = breakData[1];
            }
            if(vendorRates){
                MODEL.data.vendorRates.route.items[index].address.postalCode = breakData[0];
            }
        }else{
            siblingInput.value=breakData[1];
            MODEL.data.quoteData[siblingInput.id] = breakData[1];
            MODEL.data.quoteData[siblingInput.dataset.match] = breakData[0];
            if(siblingInput.dataset.index == '0'){
                APP.elems.zipCityInput[0].value = breakData[0];
            }else{
                APP.elems.zipCityInput[2].value = breakData[0];
            }
            if(vendorRates){
                MODEL.data.vendorRates.route.items[index].address.postalCode = breakData[0];
            }
        }
        if(MODEL.data.progressTracker.allSteps){
            APP.quoteGenerator.recalculateQuote(event);
        }
        while(parentElem.hasChildNodes()){
            parentElem.removeChild(parentElem.lastChild);
        }
        parentElem.style.display='none';
    },
    validateCarData: function(event){
        var selectElem = event.target;
        if(selectElem.id == "carYear" && selectElem.value == "older"){
            $(".carData").hide();
            $(".carDataOlder").show();
        }
        if(selectElem.id == "carYear" && selectElem.value != "older"){
            AJAX.calls.getYearMakes(APP.elems.carData[1], APP.elems.carData[2], selectElem.value);
            MODEL.data.quoteData.carYear = selectElem.value;
            MODEL.data.quoteData.carMake = null;
            MODEL.data.quoteData.carModel = null;
            return false;
        }
        if(selectElem.id == "carMake"){
            AJAX.calls.getCarModels(APP.elems.carData[2], selectElem.value, MODEL.data.quoteData.carYear);
            MODEL.data.quoteData.carMake = null;
            MODEL.data.quoteData.carModel = null;
            return false;
        }
        if(selectElem.id == "carModel"){
            var carDataElems = APP.elems.carData, selectElem;
            for(var i = 0; i < carDataElems.length; i++){
                selectElem = carDataElems[i];
                if(selectElem.value == ""){
                    return false;
                }
                if(i == 2){
                    MODEL.data.quoteData.carYear = carDataElems[0].value;
                    MODEL.data.quoteData.carModel = carDataElems[2].value;
                    MODEL.data.quoteData.carMake = carDataElems[1].value;
                    if(vendorRates){
                        MODEL.data.vendorRates.items[0].year = carDataElems[0].value;
                        MODEL.data.vendorRates.items[0].makeName = carDataElems[1].value;
                        MODEL.data.vendorRates.items[0].modelName = carDataElems[2].value;
                    }
                    MODEL.data.quoteData.carSize = selectElem[selectElem.selectedIndex].dataset.size;
                    MODEL.data.progressTracker.stepThree = true;
                    if(MODEL.data.progressTracker.allSteps){
                        APP.quoteGenerator.recalculateQuote(event);
                    }
                }
            }
        }
        if(selectElem.id == "carYearOlder"){
            $(".carData").hide();
            $(".carDataOlder").show();
            MODEL.data.quoteData.carYear = selectElem.value;
            MODEL.data.quoteData.carMake = null;
            MODEL.data.quoteData.carModel = null;
            return false;
        }
        if(selectElem.id == "carMakeOlder"){
            MODEL.data.quoteData.carMake = selectElem.value;
            MODEL.data.quoteData.carModel = null;
            return false;
        }
        if(selectElem.id == "carModelOlder"){
            var carDataOlderElems = APP.elems.carDataOlder, textOlderElem;
            for(var i = 0; i < carDataOlderElems.length; i++){
                textOlderElem = carDataOlderElems[i];
                if(textOlderElem.value == ""){
                    return false;
                }
                if(i == 2){
                    MODEL.data.quoteData.carYear = carDataOlderElems[0].value;
                    MODEL.data.quoteData.carModel = carDataOlderElems[2].value;
                    MODEL.data.quoteData.carMake = carDataOlderElems[1].value;
                    if(vendorRates){
                        MODEL.data.vendorRates.items[0].year = carDataOlderElems[0].value;
                        MODEL.data.vendorRates.items[0].makeName = carDataOlderElems[1].value;
                        MODEL.data.vendorRates.items[0].modelName = carDataOlderElems[2].value;
                    }
                    MODEL.data.quoteData.carSize = textOlderElem.dataset.size;
                    MODEL.data.progressTracker.stepThree = true;
                    if(MODEL.data.progressTracker.allSteps){
                        APP.quoteGenerator.recalculateQuote(event);
                    }
                }
            }
        }
    },
    carData: function(){
        var carDataElems = APP.elems.carData, carDataOlderElems = APP.elems.carDataOlder, selectElem, textOlderElem;
        for(var i = 0; i < carDataElems.length; i++){
            selectElem = carDataElems[i];
            textOlderElem = carDataOlderElems[i];
            selectElem.addEventListener('change', this.validateCarData, false);
            if(textOlderElem != null){
                textOlderElem.addEventListener('change', this.validateCarData, false);
            }
        }

    },
    displayPickupDate: function(formattedDate){
        $("#formattedDate").text(formattedDate);
    },
    definePickupDate: function(event){
        var selectedElem = event.target,
        selectedElemDate = selectedElem.value,
        nextStep = selectedElem.dataset.nextstep,
        currentStep = selectedElem.dataset.currentstep,
        getformattedDate = AJAX.calls.fortmatDate(selectedElemDate);
        MODEL.data.quoteData.pickUpDate = selectedElemDate;
        if(vendorRates){
            MODEL.data.vendorRates.route.items[0].timeFrame.earliestArrival = selectedElemDate;
        }
        MODEL.data.progressTracker[currentStep] = true;
        if(MODEL.data.progressTracker.allSteps){
            APP.quoteGenerator.recalculateQuote(event);
        }
    },
    pickupDate: function(){
        var pickUpDate = APP.elems.pickUpDateStatic;
        pickUpDate.addEventListener('change', this.definePickupDate, false);
    },
    validateShippingOptions: function(event){
        var elem = event.target,
        currentStep = elem.dataset.currentstep,
        nextStep = elem.dataset.nextstep,
        completeIcon = elem.dataset.mobileicon,
        elem13 = elem.form[13].checked,
        elem14 = elem.form[14].checked,
        elem15 = elem.form[15].checked,
        elem16 = elem.form[16].checked,
        elem17 = elem.form[17].checked,
        elem18 = elem.form[18].checked,
        shippingData,
        breakData;
        if(elem15 == true){
            MODEL.data.quoteData.convertible=true;
            MODEL.data.vendorRates.items[0].isConvertible=true;
        }
        if(elem16 == true){
            MODEL.data.quoteData.modified=true;
            MODEL.data.vendorRates.items[0].isModified=true;
        }
        if((elem13 == true || elem14 == true) && (elem17 == true || elem18 == true)){
            MODEL.data.progressTracker[currentStep] = true;
            MODEL.data.progressTracker.allSteps = true;
            if(elem13 == true){
                shippingData = elem.form[13].value;
                MODEL.data.quoteData.transportType = elem.form[13].value;
            }else if(elem14 == true){
                shippingData = elem.form[14].value;
                MODEL.data.quoteData.transportType = elem.form[14].value;
            }
            if(elem17 == true){
                MODEL.data.quoteData.carCondition = true;
                MODEL.data.vendorRates.items[0].isRunning = true;
            }else if(elem18 == true){
                MODEL.data.quoteData.carCondition = false;
                MODEL.data.vendorRates.items[0].isRunning = false;
            }
        }
    },
    shippingOptionsEvent: function(){
        var shippingOptionElems = APP.elems.shippingOptions, checkedElem;
        for(var i = 0; i < shippingOptionElems.length; i++){
            checkedElem = shippingOptionElems[i];
            checkedElem.addEventListener('change', this.validateShippingOptions, false);
        }
    },
    recalculateQuote: function(event){
        event.preventDefault();
        if(MODEL.data.progressTracker.allSteps && MODEL.data.progressTracker.stepFour){
            $("#loading").css("display", "flex");
            if(vendorRates){
                AJAX.calls.vendorRates();
            }else{
                AJAX.calls.calculateZip();
                var quoteData = MODEL.data.quoteData,
                    quoteRates = MODEL.data.quoteRates,
                    ratePerMile = (quoteData.transportType == "OpenTransport")? quoteRates.rateMileOpen: quoteRates.rateMileClosed,
                    pricePerDistance = quoteData.distanceInMiles * ratePerMile,
                    priceRateAdjustment = pricePerDistance * 0.10,
                    adjustedRate = pricePerDistance + priceRateAdjustment,
                    priceLoadAssist = (quoteData.carCondition == "carOk")? quoteRates.carOk: quoteRates.carNotOk,
                    pricePerSize = MODEL.data.carSizes[parseInt(quoteData.carSize)],
                    deposit = quoteRates.deposit;
                MODEL.data.quoteData.pricePerDistance = parseInt(adjustedRate);
                MODEL.data.quoteData.pricePerSize = pricePerSize;
                MODEL.data.quoteData.standardTotal = parseInt(adjustedRate) + deposit + priceLoadAssist + pricePerSize;
                MODEL.data.quoteData.priorityTotal = parseInt(adjustedRate) + deposit + priceLoadAssist + pricePerSize + quoteRates.priorityFee;
                MODEL.data.quoteData.expeditedTotal = parseInt(adjustedRate) + deposit + priceLoadAssist + pricePerSize + quoteRates.expediteFee;
            }
            if(MODEL.data.quoteData.quoteId == null){
                MODEL.data.quoteData.quoteId = "IQ-"+Math.random().toString(36).substr(2, 6);
            }
            $("#formFailedMsg").hide();
            setTimeout(function(){
                $("#static_generator").hide();
                $("#loading").css("display", "none");
                $("#generatedQuoteWrapper").fadeIn('fast');
            }, 7000);
        }else{
            $("#formFailedMsg").fadeIn();
        }
    },
    contactInfoModal: function(event){
        event.preventDefault();
        if(MODEL.data.progressTracker.allSteps && MODEL.data.progressTracker.stepFour){
            if(MODEL.data.quoteData.usrName == null || MODEL.data.quoteData.usrPhone == null || MODEL.data.quoteData.usrEmail == null){
                $("#contactInfoModal").modal({
                    backdrop: 'static',
                    show: true
                });
            }else{
                MODEL.domElems.contactLead[0].value = MODEL.data.quoteData.usrEmail;
                MODEL.domElems.contactLead[1].value = MODEL.data.quoteData.usrName;
                MODEL.domElems.contactLead[2].value = MODEL.data.quoteData.usrPhone;
                APP.quoteGenerator.recalculateQuote(event);
            }
        }else{
            $("#formFailedMsg").fadeIn();
        }
    },
    getStaticQuote: function(){
        var staticQuoteBtn = document.getElementById('generateStaticQuote');
        if(requireContactInfo){
            staticQuoteBtn.addEventListener('click', this.contactInfoModal, false);
        }else{
            staticQuoteBtn.addEventListener('click', this.recalculateQuote, false);
        }
    },
    saveQuoteModal: function(){
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
            if(saveQuoteBtn != undefined){
                saveQuoteBtn.addEventListener('click', this.saveQuoteModal, false);
            }
    },
    changeQuoteEvent: function(){
        event.preventDefault();
        $("#generatedQuoteWrapper").hide();
        $("#static_generator").fadeIn();
    },
    changeQuote: function(){
        var changeQuoteBtn = APP.elems.changeQuote;
        changeQuoteBtn.addEventListener('click', this.changeQuoteEvent, false);
    },
    saveMyQuote: function(){
        var saveMyQuoteBtn = APP.elems.saveMyQuote;
        if(saveMyQuoteBtn != undefined){
            saveMyQuoteBtn.addEventListener('click', AJAX.calls.saveMyQuote, false);
        }
    },
    validateContactInfo: function(event){
        var leadContactInfoElems = APP.elems.contactLead, validInputElem, allContactFields = false, inputElem;
        for(var i = 0; i < leadContactInfoElems.length; i++){
            validInputElem = leadContactInfoElems[i].value;
            inputElem = leadContactInfoElems[i];
            if(validInputElem.length > 0){
                MODEL.data.quoteData[leadContactInfoElems[i].name] = leadContactInfoElems[i].value;
                inputElem.classList.remove('has-error');
                allContactFields = true;
            }else{
                allContactFields = false;
                inputElem.classList.add('has-error');
                return false;
            }
        }
        if(allContactFields){
            $("#contactInfoModal").modal('hide');
            APP.quoteGenerator.recalculateQuote(event);
        }
    },
    proceedToQuote: function(){
        var proceedToQuoteBtn = APP.elems.proceedToQuote;
        if(proceedToQuoteBtn != undefined){
            proceedToQuoteBtn.addEventListener('click', this.validateContactInfo, false);
        }
    }
};

APP.quoteGenerator.geolocation();
APP.quoteGenerator.zipCitySuggest();
APP.quoteGenerator.carData();
APP.quoteGenerator.pickupDate();
APP.quoteGenerator.shippingOptionsEvent();
APP.quoteGenerator.saveQuote();
APP.quoteGenerator.changeQuote();
APP.quoteGenerator.saveMyQuote();
APP.quoteGenerator.getStaticQuote();
APP.quoteGenerator.proceedToQuote();
