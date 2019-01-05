var APP = APP || {};

APP.elems = MODEL.domElems;

APP.quoteGenerator = {
    geolocation: function(){
        if(MODEL.data.geolocation != null){
            $("#originZip").val(MODEL.data.geolocation.zip);
            $("#origZipDisplay").text(MODEL.data.geolocation.zip);
            $("#origCityDisplay").text(MODEL.data.geolocation.city+" "+MODEL.data.geolocation.region);
            MODEL.data.quoteData.originZip = MODEL.data.geolocation.zip;
            MODEL.data.quoteData.originCity = MODEL.data.geolocation.city+", "+MODEL.data.geolocation.region;
            if(vendorRates){
                MODEL.data.vendorRates.route.items[0].address.postalCode = MODEL.data.geolocation.zip;
            }
            MODEL.data.progressTracker.stepOne = true;
            $("#stepOne").find("button").show();
        }
    },
    animateGenerator: function(event, currentStep, nextStep){
        event.preventDefault();
        if(event.target.nodeName == "BUTTON" && event.target.id == "startGenerator"){
            APP.quoteGenerator.geolocation();
            currentStep = event.target.dataset.currentstep;
            nextStep = event.target.dataset.nextstep;
            $(APP.elems.progressTracker).animate({
                height: 100,
                opacity: 1
            }, 400);
            $('.wizardSteps').each(function(e){
                var elemHeight = $(this).height();
                $(this).css('margin-top', elemHeight);
            });
        }
        if(event.target.parentNode.classList.contains('trackerStep') || event.target.classList.contains('trackerIcon')){
            $(".checkData").hide();
            var wizardSteps = MODEL.domElems.wizardSteps;
            for(var i = 0; i < wizardSteps.length; i++){
                if(MODEL.data.progressTracker[currentStep] == false){
                    return false;
                }
            }
            var elemHeight = $('.active').height();
            $('.active').animate({
                marginTop: elemHeight,
                opacity: 0
            }).hide();
            $('.active').removeClass('active');
            $(APP.elems[currentStep]).show().animate({
                marginTop: 20,
                opacity: 1
            });
            $(APP.elems[currentStep]).addClass('active');
        }else{
            if(requireContactInfo){
                $(APP.elems[currentStep]).animate({
                    marginTop: APP.elems[currentStep].clientHeight,
                    opacity: 0
                }, 500).hide();
                $(APP.elems[currentStep]).removeClass('active');
                $(APP.elems[nextStep]).addClass('active');
                $(APP.elems[nextStep]).show().animate({
                    marginTop: 20,
                    opacity: 1
                }, 500);
            }else{
                if(nextStep == "stepSix"){
                    $(APP.elems.progressTracker).animate({
                        height: 0,
                        opacity: 0
                    }, 500);
                }
                $(APP.elems[currentStep]).animate({
                    marginTop: APP.elems[currentStep].clientHeight,
                    opacity: 0
                }, 500).hide();
                $(APP.elems[currentStep]).removeClass('active');
                $(APP.elems[nextStep]).addClass('active');
                $(APP.elems[nextStep]).show().animate({
                    marginTop: 20,
                    opacity: 1
                }, 500);
            }
        }
    },
    recalculateQuote: function(currentStep, nextStep){
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
        if(nextStep == "stepSix" || MODEL.data.progressTracker.allSteps){
            $(APP.elems.progressTracker).animate({
                height: 0,
                opacity: 0
            }, 500);
        }
        var elemHeight = $('.active').height();
        $('.active').animate({
            marginTop: elemHeight,
            opacity: 0
        }, 500).hide();
        $('.active').removeClass('active');
        if(!quoteDetailsPage){
            setTimeout(function(){
                $(APP.elems.stepSix).show().animate({
                    marginTop: 20,
                    opacity: 1
                }, 500);
                $("#loading").css("display", "none");
            }, 7000);
            $(APP.elems.stepSix).addClass('active');
        }
    },
    startGenerator: function(){
        if(APP.elems.startGenerator){
            APP.elems.startGenerator.addEventListener('click', APP.quoteGenerator.animateGenerator , true);
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
    validateCarData: function(event){
        var selectElem = event.target;
        if(selectElem.id == "carYear"){
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
        var carDataElems = APP.elems.carData, selectElem;
        for(var i = 0; i < carDataElems.length; i++){
            selectElem = carDataElems[i];
            if(selectElem.value == ""){
                return false;
            }
            if(i == 2){
                $("#carMakeDisplay").text(carDataElems[0].value);
                $("#carModelYearDisplay").text(carDataElems[1].value+' '+carDataElems[2].value);
                $("#trackerIconThree").addClass('completeIcon');
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
                    if(requireContactInfo){
                        if(MODEL.data.quoteData.usrName == null || MODEL.data.quoteData.usrPhone == null || MODEL.data.quoteData.usrEmail == null){
                            $("#contactInfoModal").modal({
                                backdrop: 'static',
                                show: true
                            });
                        }else{
                            APP.quoteGenerator.recalculateQuote(selectElem.dataset.currentStep, selectElem.dataset.nextstep);
                        }
                    }else{
                        $("#loading").css("display", "flex");
                        APP.quoteGenerator.recalculateQuote(selectElem.dataset.currentStep, selectElem.dataset.nextstep);
                    }
                }else{
                    APP.quoteGenerator.animateGenerator(event, selectElem.dataset.currentstep, selectElem.dataset.nextstep);
                }
            }
        }
    },
    carData: function(){
        var carDataElems = APP.elems.carData, selectElem;
        for(var i = 0; i < carDataElems.length; i++){
            selectElem = carDataElems[i];
            selectElem.addEventListener('change', this.validateCarData, false);
        }
    },
    displayPickupDate: function(formattedDate){
        var breakFormatedDate = formattedDate.split('-');
        $("#dayPickupDisplay").text(breakFormatedDate[0]);
        $("#monthPickupDisplay").text(breakFormatedDate[1]);
    },
    definePickupDate: function(event){
        var pickupDateElems = APP.elems.pickupDate,
        dayElem = '',
        selectedElem = event.target,
        selectedElemDate = selectedElem.dataset.fulldate,
        nextStep = selectedElem.dataset.nextstep,
        currentStep = selectedElem.dataset.currentstep,
        completeIcon = selectedElem.dataset.mobileicon,
        getformattedDate = AJAX.calls.fortmatDate(selectedElemDate);
        MODEL.data.quoteData.pickUpDate = selectedElemDate;
        if(vendorRates){
            MODEL.data.vendorRates.route.items[0].timeFrame.earliestArrival = selectedElemDate;
        }
        for(var i = 0; i < pickupDateElems.length; i++){
            dayElem = pickupDateElems[i];
            dayElem.classList.remove('selected');
        }
        selectedElem.classList.add('selected');
        $("#"+completeIcon).addClass('completeIcon');
        MODEL.data.progressTracker[currentStep] = true;
        if(MODEL.data.progressTracker.allSteps){
            if(requireContactInfo){
                if(MODEL.data.quoteData.usrName == null || MODEL.data.quoteData.usrPhone == null || MODEL.data.quoteData.usrEmail == null){
                    $("#contactInfoModal").modal({
                        backdrop: 'static',
                        show: true
                    });
                }else{
                    APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
                }
            }else{
                $("#loading").css("display", "flex");
                APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
            }
        }else{
            APP.quoteGenerator.animateGenerator(event, currentStep, nextStep);
        }
    },
    pickupDate: function(){
        if(document.querySelector('#pickUpDate')){
            document.querySelector('#pickUpDate').addEventListener('click', function(event){
                if(event.target.classList.contains('pickUpDay')){
                    APP.quoteGenerator.definePickupDate(event);
                }
            }, true);
        }
    },
    generateAjaxCalendar: function(event){
        event.preventDefault();
        var extractDate = event.target.pathname,
            breakDate = extractDate.split('/');
        AJAX.calls.generateCalendar(breakDate[4], breakDate[3]);
    },
    monthNavEvents: function(){
        if(document.querySelector('#pickUpDate')){
            document.querySelector('#pickUpDate').addEventListener('click', function(event) {
                if ( event.target.classList.contains('monthNav') ) {
                    APP.quoteGenerator.generateAjaxCalendar(event);
                }
            }, true);
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
        $("#"+siblingInput.dataset.displayone).text(breakData[0]);
        $("#"+siblingInput.dataset.displaytwo).text(breakData[1]);
        $("#"+completeIcon).addClass('completeIcon');
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
            if(requireContactInfo){
                if(MODEL.data.quoteData.usrName == null || MODEL.data.quoteData.usrPhone == null || MODEL.data.quoteData.usrEmail == null){
                    $("#contactInfoModal").modal({
                        backdrop: 'static',
                        show: true
                    });
                }else{
                    APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
                }
            }else{
                $("#loading").css("display", "flex");
                APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
            }
        }else{
            APP.quoteGenerator.animateGenerator(event, currentStep, nextStep);
        }
        while(parentElem.hasChildNodes()){
            parentElem.removeChild(parentElem.lastChild);
        }
        parentElem.style.display='none';
    },
    validateShippingOptions: function(event){
        var elem = event.target,
        currentStep = elem.dataset.currentstep,
        nextStep = elem.dataset.nextstep,
        completeIcon = elem.dataset.mobileicon,
        elem14 = elem.form[14].checked,
        elem15 = elem.form[15].checked,
        elem17 = elem.form[17].checked,
        elem18 = elem.form[18].checked,
        elem20 = elem.form[20].checked,
        elem21 = elem.form[21].checked,
        shippingData,
        breakData;
        if(elem17 == true){
            MODEL.data.quoteData.convertible=true;
            MODEL.data.vendorRates.items[0].isConvertible=true;
        }
        if(elem18 == true){
            MODEL.data.quoteData.modified=true;
            MODEL.data.vendorRates.items[0].isModified=true;
        }
        if((elem14 == true || elem15 == true) && (elem20 == true || elem21 == true)){
            $("#"+completeIcon).addClass('completeIcon');
            MODEL.data.progressTracker[currentStep] = true;
            //MODEL.data.progressTracker.allSteps = true;
            if(elem14 == true){
                shippingData = elem.form[14].value;
                MODEL.data.quoteData.transportType = elem.form[14].value;
            }else if(elem15 == true){
                shippingData = elem.form[15].value;
                MODEL.data.quoteData.transportType = elem.form[15].value;
            }
            if(elem20 == true){
                MODEL.data.quoteData.carCondition = true;
                MODEL.data.vendorRates.items[0].isRunning = true;
            }else if(elem21 == true){
                MODEL.data.quoteData.carCondition = false;
                MODEL.data.vendorRates.items[0].isRunning = false;
            }
            if(MODEL.data.progressTracker.allSteps){
                // if(requireContactInfo){
                //     if(MODEL.data.quoteData.usrName == null || MODEL.data.quoteData.usrPhone == null || MODEL.data.quoteData.usrEmail == null){
                //         $("#contactInfoModal").modal({
                //             backdrop: 'static',
                //             show: true
                //         });
                //     }else{
                //         MODEL.domElems.contactLead[0].value = MODEL.data.quoteData.usrEmail;
                //         MODEL.domElems.contactLead[1].value = MODEL.data.quoteData.usrName;
                //         MODEL.domElems.contactLead[2].value = MODEL.data.quoteData.usrPhone;
                //         APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
                //     }
                // }else{
                //     $("#loading").css("display", "flex");
                //     APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
                // }
            }else{
                APP.quoteGenerator.animateGenerator(event, currentStep, nextStep);
            }
            breakData = shippingData.split(" ");
            $("#optionOneDisplay").text(breakData[0]);
            $("#optionTwoDisplay").text(breakData[1]);
        }
    },
    shippingOptionsEvent: function(){
        var shippingOptionElems = APP.elems.shippingOptions, checkedElem;
        for(var i = 0; i < shippingOptionElems.length; i++){
            checkedElem = shippingOptionElems[i];
            checkedElem.addEventListener('change', this.validateShippingOptions, false);
        }
    },
    trackerStepModify: function(event){
        if(event.target.classList.contains('trackerIcon')){
            var trackerStepElem = event.target;
        }else{
            var trackerStepElem = event.target.parentNode;
        }
        var currentStep = trackerStepElem.dataset.currentstep,
            nextStep = trackerStepElem.dataset.nextstep;
        APP.quoteGenerator.animateGenerator(event, currentStep, nextStep);
    },
    trackerStep: function(){
        var trackerStepElems = APP.elems.trackerStep, trackerStep;
        for(var i = 0; i < trackerStepElems.length; i++){
            trackerStep = trackerStepElems[i];
            trackerStep.addEventListener('click', this.trackerStepModify, false);
        }
    },
    manualStepEvent: function(event){
        event.preventDefault();
        event.target.nextElementSibling.style.display = "inline";
        var currentStep = event.target.dataset.currentstep,
            nextStep = event.target.dataset.nextstep;
        if(MODEL.data.progressTracker[currentStep] == false){
            event.target.nextElementSibling.style.display = "inline";
            return false;
        }
        event.target.nextElementSibling.style.display = "none";
        APP.quoteGenerator.animateGenerator(event,currentStep, nextStep);
    },
    manualSteps: function(){
        var manualStepElems = APP.elems.manualSteps, manualStep;
        for(var i = 0; i < manualStepElems.length; i++){
            manualStep = manualStepElems[i];
            manualStep.addEventListener('click', this.manualStepEvent, false);
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
        if(saveQuoteBtn != null){
            saveQuoteBtn.addEventListener('click', this.saveQuoteModal, false);
        }
    },
    changeQuoteEvent: function(event){
        event.preventDefault();
        $(APP.elems.progressTracker).animate({
            height: 100,
            opacity: 1
        }, 500);
        APP.quoteGenerator.animateGenerator(event, "stepSix", "stepOne");
        $(".trackerStep").each(function(){
            $(this).addClass('change');
        });
    },
    changeQuote: function(){
        var changeQuoteBtn = APP.elems.changeQuote;
        if(changeQuoteBtn !== null){
            changeQuoteBtn.addEventListener('click', this.changeQuoteEvent, false);
        }
    },
    saveMyQuote: function(){
        var saveMyQuoteBtn = APP.elems.saveMyQuote;
        if(saveMyQuoteBtn != null){
            saveMyQuoteBtn.addEventListener('click', AJAX.calls.saveMyQuote, false);
        }
    },
    validateContactInfo: function(event){
        var elem = event.target,
            currentStep = elem.dataset.currentstep,
            nextStep = elem.dataset.nextstep,
            completeIcon = elem.dataset.mobileicon,
            leadContactInfoElems = APP.elems.contactLead,
            validInputElem,
            allContactFields = false,
            inputElem;
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
            APP.quoteGenerator.recalculateQuote(currentStep, nextStep);
        }
    },
    validateContactInfoEvent: function(){
        var contactLeadElems = APP.elems.contactLead, contactLeadElem;
        for(var i = 0; i < contactLeadElems.length; i++){
            contactLeadElem = contactLeadElems[i];
            contactLeadElem.addEventListener('change', this.validateContactInfo, false);
        }
    },
    proceedToQuote: function(){
        var proceedToQuoteBtn = APP.elems.proceedToQuote;
        if(proceedToQuoteBtn != undefined){
            proceedToQuoteBtn.addEventListener('click', this.validateContactInfo, false);
        }
    }
}

APP.quoteGenerator.startGenerator();
APP.quoteGenerator.zipCitySuggest();
APP.quoteGenerator.carData();
APP.quoteGenerator.pickupDate();
APP.quoteGenerator.monthNavEvents();
APP.quoteGenerator.shippingOptionsEvent();
APP.quoteGenerator.trackerStep();
APP.quoteGenerator.manualSteps();
APP.quoteGenerator.saveQuote();
APP.quoteGenerator.changeQuote();
APP.quoteGenerator.saveMyQuote();
APP.quoteGenerator.proceedToQuote();
APP.quoteGenerator.validateContactInfoEvent();
