var AJAX = AJAX || {};

AJAX.calls = {
    zipCityLookup: function(targetElem, inputValue, suggestType){
        var values = {csrf_token: $('input[name=csrf_token]').val(), input_value: inputValue, suggest_type: suggestType};
        $.ajax({
            url: '/ajax/zip_city_lookup',
            data: values,
            type: 'POST',
            success: function(success){
                var zipCitySuggest = targetElem.nextElementSibling,
                    zipSuggestLength = '';
                if(success.length > 0){
                    success = $.parseJSON(success);
                    while(zipCitySuggest.hasChildNodes()){
                        zipCitySuggest.removeChild(zipCitySuggest.lastChild);
                    }
                    for(var i = 0; i < success.length; i++){
                        var newSuggestItem = document.createElement('li'),
                            newSuggestItemText = document.createTextNode(success[i].Zipcode+" - "+ success[i].City+", "+success[i].State);
                        newSuggestItem.appendChild(newSuggestItemText);
                        zipCitySuggest.appendChild(newSuggestItem);
                        newSuggestItem.addEventListener('mousedown', APP.quoteGenerator.progressTracker, false);
                        zipSuggestLength = zipCitySuggest.childElementCount;
                    }
                    if(zipSuggestLength > 0){
                        $(zipCitySuggest).fadeIn('fast');
                    }
                }else if(success.length == 0){
                    while(zipCitySuggest.hasChildNodes()){
                        zipCitySuggest.removeChild(zipCitySuggest.lastChild);
                    }
                    var newSuggestItem = document.createElement('li');
                    newSuggestItem.innerText = "Sorry, I don't have anything like that.";
                    zipCitySuggest.appendChild(newSuggestItem);
                }
            }
        });
    },
    getYearMakes: function(makeOptions, modelOptions, inputValue){
        var values = {csrf_token: $('input[name=csrf_token]').val(), input_value: inputValue};
        $.ajax({
            url: '/ajax/get_year_makes',
            data: values,
            type: 'POST',
            success: function(success){
                var makeModelOptions = [makeOptions, modelOptions],
                    makeOptionsLength = '';
                if(success.length > 0){
                    success = $.parseJSON(success);
                    for(var i = 0; i < makeModelOptions.length; i++){
                        while(makeModelOptions[i].hasChildNodes()){
                            makeModelOptions[i].removeChild(makeModelOptions[i].lastChild);
                        }
                        var newOptionItem = document.createElement('option');
                        newOptionItem.innerText = (i == 0)? "Make": "Model";
                        makeModelOptions[i].appendChild(newOptionItem);
                    }

                    for(var i = 0; i < success.length; i++){
                        var newOptionItem = document.createElement('option'),
                            newOptionItemText = document.createTextNode(success[i].make);
                        newOptionItem.appendChild(newOptionItemText);
                        makeModelOptions[0].appendChild(newOptionItem);
                        //newOptionItem.addEventListener('mousedown', APP.quoteGenerator.progressTracker, false);
                        makeOptionsLength = makeModelOptions[0].childElementCount;
                    }
                    if(makeOptionsLength > 0){
                        makeModelOptions[0].style.display='block';
                    }
                }else if(success.length == 0){
                    while(makeModelOptions[0].hasChildNodes()){
                        makeModelOptions[0].removeChild(makeModelOptions[0].lastChild);
                    }
                    var newOptionItem = document.createElement('option');
                    newOptionItem.innerText = "pick one of these too...";
                    makeModelOptions[0].appendChild(newOptionItem);
                }
            }
        });
    },
    getCarModels: function(targetElem, inputValue, carYear){
        var values = {csrf_token: $('input[name=csrf_token]').val(), input_value: inputValue, year: carYear};
        $.ajax({
            url: '/ajax/get_car_models',
            data: values,
            type: 'POST',
            success: function(success){
                var carModelOptions = targetElem,
                    optionsLength = '';
                if(success.length > 0){
                    success = $.parseJSON(success);
                    while(carModelOptions.hasChildNodes()){
                        carModelOptions.removeChild(carModelOptions.lastChild);
                    }
                    var newOptionItem = document.createElement('option');
                    newOptionItem.innerText = "Model";
                    carModelOptions.appendChild(newOptionItem);
                    for(var i = 0; i < success.length; i++){
                        var newOptionItem = document.createElement('option'),
                            newOptionItemText = document.createTextNode(success[i].model),
                            newOptionAttribute = document.createAttribute('data-size');
                            newOptionAttribute.value = success[i].size;
                            newOptionItem.setAttributeNode(newOptionAttribute);
                        newOptionItem.appendChild(newOptionItemText);
                        carModelOptions.appendChild(newOptionItem);
                        //newOptionItem.addEventListener('mousedown', APP.quoteGenerator.progressTracker, false);
                        optionsLength = carModelOptions.childElementCount;
                    }
                    if(optionsLength > 0){
                        carModelOptions.style.display='block';
                    }
                }else if(success.length == 0){
                    while(carModelOptions.hasChildNodes()){
                        carModelOptions.removeChild(carModelOptions.lastChild);
                    }
                    var newOptionItem = document.createElement('option');
                    newOptionItem.innerText = "pick one of these too...";
                    carModelOptions.appendChild(newOptionItem);
                }
            }
        });
    },
    fortmatDate: function(rawDate){
        var values = {csrf_token: $('input[name=csrf_token]').val(), raw_date: rawDate};
        $.ajax({
            url: '/ajax/format_date',
            data: values,
            type: 'POST',
            success: function(success){
                if(success.length > 0){
                    APP.quoteGenerator.displayPickupDate(success);
                    MODEL.data.quoteData.pickUpFormattedDate = success;
                }
            }
        });
    },
    generateCalendar: function(month, year){
        var values = {csrf_token: $('input[name=csrf_token]').val(), month_value: month, year_value: year};
        $.ajax({
            url: 'ajax/generate_calendar',
            data: values,
            type: 'POST',
            success: function(success){
                MODEL.domElems.calendar.innerHTML=success;
            }
        });
    },
    vendorRates: function(event){
        var values = {
            csrf_token: $('input[name=csrf_token]').val(),
            origZip: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.route.items[0].address.postalCode: MODEL.data.quoteData.origZip,
            pickUpDate: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.route.items[0].timeFrame.earliestArrival: MODEL.data.quoteData.pickUpDate,
            destZip: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.route.items[1].address.postalCode: MODEL.data.quoteData.destZip,
            make: (MODEL.data.vendorRates.items)?MODEL.data.vendorRates.items[0].makeName: MODEL.data.quoteData.carMake,
            model: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.items[0].modelName: MODEL.data.quoteData.carModel,
            year: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.items[0].year: MODEL.data.quoteData.carYear,
            isRunning: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.items[0].isRunning: MODEL.data.quoteData.carCondition,
            isConvertible: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.items[0].isConvertible: MODEL.data.quoteData.convertible,
            isModified: (MODEL.data.vendorRates.items)? MODEL.data.vendorRates.items[0].isModified: MODEL.data.quoteData.modified
        };
        $.ajax({
            url: '/ajax/'+publishedOrEstimate,
            data: values,
            type: 'POST',
            async: true,
            success: function(success){
                var resultObj = JSON.parse(success);
                if(lowRates){
                    var deposit = MODEL.data.quoteRates.lowDeposit,
                        priorityFeeAmount = MODEL.data.quoteRates.lowPriority,
                        expediteFeeAmount = MODEL.data.quoteRates.lowExpedite;
                }else if(midRates){
                    var deposit = MODEL.data.quoteRates.midDeposit,
                        priorityFeeAmount = MODEL.data.quoteRates.midPriority,
                        expediteFeeAmount = MODEL.data.quoteRates.midExpedite;
                }else{
                    var deposit = MODEL.data.quoteRates.deposit,
                        priorityFeeAmount = MODEL.data.quoteRates.priorityFee,
                        expediteFeeAmount = MODEL.data.quoteRates.expediteFee;
                }
                if(publishedRates){
                    if(resultObj.totalCount > 0){
                        MODEL.data.vendorPublishedRates = resultObj.items[0];
                        MODEL.data.quoteData.pricePerDistance = parseInt(MODEL.data.vendorPublishedRates.totalPrice.value);
                        MODEL.data.quoteData.publishedTotal = parseInt(MODEL.data.vendorPublishedRates.totalPrice.value);
                        MODEL.data.quoteData.standardTotal = parseInt(MODEL.data.vendorPublishedRates.totalPrice.value) + deposit;
                        MODEL.data.quoteData.priorityTotal = parseInt(MODEL.data.vendorPublishedRates.totalPrice.value) + deposit + priorityFeeAmount;
                        MODEL.data.quoteData.expeditedTotal = parseInt(MODEL.data.vendorPublishedRates.totalPrice.value) + deposit + expediteFeeAmount;
                    }
                }else{
                    if(resultObj.price.value){
                        MODEL.data.vendorPublishedRates = resultObj;
                        MODEL.data.quoteData.pricePerDistance = parseInt(MODEL.data.vendorPublishedRates.highPrice.value);
                        MODEL.data.quoteData.publishedTotal = parseInt(MODEL.data.vendorPublishedRates.highPrice.value);
                        MODEL.data.quoteData.standardTotal = parseInt(MODEL.data.vendorPublishedRates.highPrice.value) + deposit;
                        MODEL.data.quoteData.priorityTotal = parseInt(MODEL.data.vendorPublishedRates.highPrice.value) + deposit + priorityFeeAmount;
                        MODEL.data.quoteData.expeditedTotal = parseInt(MODEL.data.vendorPublishedRates.highPrice.value) + deposit + expediteFeeAmount;
                    }
                }
                $("#stdShippPrice").text("$"+MODEL.data.quoteData.standardTotal+".00");
                $("#prioShippPrice").text("$"+MODEL.data.quoteData.priorityTotal+".00");
                $("#expShippPrice").text("$"+MODEL.data.quoteData.expeditedTotal+".00");
                MODEL.data.quoteData.quoteId = MODEL.data.quoteData.quoteId || "IQ-"+Math.random().toString(36).substr(2, 6);

                var dateObj = new Date(),
                    month = dateObj.getUTCMonth() + 1,
                    day = dateObj.getUTCDate(),
                    year = dateObj.getUTCFullYear(),
                    today = year + "-" + month + "-" + day;
                MODEL.data.quoteData.quoteDate = today;
                localStorage.setItem('instantQuote', JSON.stringify(MODEL.data.quoteData));
                AJAX.calls.storeQuoteInDb();
                if(requireContactInfo){
                    AJAX.calls.saveMyQuote();
                    console.log('call to save quote');
                    window.location = "https://carshippersofamerica.com/quote_details_v1";
                }else{
                    window.location = "https://carshippersofamerica.com/quote_details_v1";
                }
            }
        });
    },
    calculateZip: function(){
        //have to sign up for paid service at some point https://www.zipcodeapi.com/API
		var zip1 = MODEL.data.quoteData.originZip.substring(0, 5);
		var zip2 = MODEL.data.quoteData.destZip.substring(0, 5);
		if (zip1.length == 5 && /^[0-9]+$/.test(zip1) && zip2.length == 5 && /^[0-9]+$/.test(zip2)){
            var values = {csrf_token: $('input[name=csrf_token]').val(), orig: zip1, dest: zip2};
			$.ajax({
				url: "/ajax/calculate_distance",
                data: values,
                type: 'POST',
				dataType: "json",
                async: false
			}).done(function(data) {
                if (data.error_msg){
                }else if ("distance" in data){
    				MODEL.data.quoteData.distanceInMiles = data.distance;
    			}
			}).fail(function(data) {
				if (data.responseText && (json = $.parseJSON(data.responseText))){
					if (json.error_msg){
						 //json.error_msg
                    }
				}else{
					//Request failed.
                }
			});
		}
        // MODEL.data.quoteData.distanceInMiles = 1066;
    },
    storeQuoteInDb: function(){
        var values = {
            csrf_token: $('input[name=csrf_token]').val(),
            quoteId: MODEL.data.quoteData.quoteId,
            originZip: MODEL.data.quoteData.originZip,
            originCity: MODEL.data.quoteData.originCity,
            destZip: MODEL.data.quoteData.destZip,
            destCity: MODEL.data.quoteData.destCity,
            carYear: MODEL.data.quoteData.carYear,
            carMake: MODEL.data.quoteData.carMake,
            carModel: MODEL.data.quoteData.carModel,
            carSize: MODEL.data.quoteData.carSize,
            pickUpDate: MODEL.data.quoteData.pickUpDate,
            pickUpFormattedDate: MODEL.data.quoteData.pickUpFormattedDate,
            transportType: MODEL.data.quoteData.transportType,
            carCondition: MODEL.data.quoteData.carCondition,
            convertible: MODEL.data.quoteData.convertible,
            modified: MODEL.data.quoteData.modified,
            distanceInMiles: MODEL.data.quoteData.distanceInMiles,
            pricePerDistance: MODEL.data.quoteData.pricePerDistance,
            pricePerSize: MODEL.data.quoteData.pricePerSize,
            standardTotal: MODEL.data.quoteData.standardTotal,
            priorityTotal: MODEL.data.quoteData.priorityTotal,
            expeditedTotal: MODEL.data.quoteData.expeditedTotal,
            publishedTotal: MODEL.data.quoteData.publishedTotal,
            usrEmail: MODEL.data.quoteData.usrEmail,
            usrName: MODEL.data.quoteData.usrName,
            usrPhone: MODEL.data.quoteData.usrPhone,
        };
        $.ajax({
            url: '/ajax/store_generated_quote',
            data: values,
            type: 'POST',
            success: function(success){
                if(success.length > 0){
                    console.log("quote stored");
                }else if(success.length == 0){
                    //an error has occured
                }
            }
        });
    },
    saveMyQuote: function(){
        //event.preventDefault();
        var usrEmail = document.getElementById('usrEmail');
        var emailIsValid = usrEmail.checkValidity();
        if(emailIsValid){
            usrEmail.classList.remove('invalid');
            var values = {
                csrf_token: $('input[name=csrf_token]').val(),
                quoteId: MODEL.data.quoteData.quoteId,
                originZip: MODEL.data.quoteData.originZip,
                originCity: MODEL.data.quoteData.originCity,
                destZip: MODEL.data.quoteData.destZip,
                destCity: MODEL.data.quoteData.destCity,
                carYear: MODEL.data.quoteData.carYear,
                carMake: MODEL.data.quoteData.carMake,
                carModel: MODEL.data.quoteData.carModel,
                carSize: MODEL.data.quoteData.carSize,
                pickUpDate: MODEL.data.quoteData.pickUpDate,
                pickUpFormattedDate: MODEL.data.quoteData.pickUpFormattedDate,
                transportType: MODEL.data.quoteData.transportType,
                carCondition: MODEL.data.quoteData.carCondition,
                convertible: MODEL.data.quoteData.convertible,
                modified: MODEL.data.quoteData.modified,
                distanceInMiles: MODEL.data.quoteData.distanceInMiles,
                pricePerDistance: MODEL.data.quoteData.pricePerDistance,
                pricePerSize: MODEL.data.quoteData.pricePerSize,
                standardTotal: MODEL.data.quoteData.standardTotal,
                priorityTotal: MODEL.data.quoteData.priorityTotal,
                expeditedTotal: MODEL.data.quoteData.expeditedTotal,
                publishedTotal: MODEL.data.quoteData.publishedTotal,
                usrEmail: MODEL.domElems.usrEmail.value,
                usrName: MODEL.domElems.usrName.value,
                usrPhone: MODEL.domElems.usrPhone.value,
                savedByUser: 1
            };
            $.ajax({
                url: '/ajax/save_my_quote',
                data: values,
                type: 'POST',
                success: function(success){
                    if(success.length > 0){
                        $("#saveQuoteForm, #saveMyQuote").hide();
                        $("#quoteIdNumber").text(MODEL.data.quoteData.quoteId);
                        $("#saveSuccess").fadeIn();
                        localStorage.setItem('savedQuote', MODEL.data.quoteData.quoteId);
                        console.log('saved quote');
                    }
                }
            });
        }else{
            usrEmail.classList.add('invalid');
        }
    },
    generateLead: function(){
        //event.preventDefault();
        var usrEmail = document.getElementById('usrEmail');
        var emailIsValid = usrEmail.checkValidity();
        if(emailIsValid){
            var values = {
                csrf_token: $('input[name=csrf_token]').val(),
                quoteId: MODEL.data.quoteData.quoteId,
                originZip: MODEL.data.quoteData.originZip,
                originCity: MODEL.data.quoteData.originCity,
                destZip: MODEL.data.quoteData.destZip,
                destCity: MODEL.data.quoteData.destCity,
                carYear: MODEL.data.quoteData.carYear,
                carMake: MODEL.data.quoteData.carMake,
                carModel: MODEL.data.quoteData.carModel,
                carSize: MODEL.data.quoteData.carSize,
                pickUpDate: MODEL.data.quoteData.pickUpDate,
                pickUpFormattedDate: MODEL.data.quoteData.pickUpFormattedDate,
                transportType: MODEL.data.quoteData.transportType,
                carCondition: MODEL.data.quoteData.carCondition,
                convertible: MODEL.data.quoteData.convertible,
                modified: MODEL.data.quoteData.modified,
                distanceInMiles: MODEL.data.quoteData.distanceInMiles,
                pricePerDistance: MODEL.data.quoteData.pricePerDistance,
                pricePerSize: MODEL.data.quoteData.pricePerSize,
                standardTotal: MODEL.data.quoteData.standardTotal,
                priorityTotal: MODEL.data.quoteData.priorityTotal,
                expeditedTotal: MODEL.data.quoteData.expeditedTotal,
                publishedTotal: MODEL.data.quoteData.publishedTotal,
                usrEmail: MODEL.domElems.usrEmail.value,
                usrName: MODEL.domElems.usrName.value,
                usrPhone: MODEL.domElems.usrPhone.value,
                savedByUser: 1
            };
            $.ajax({
                url: '/ajax/generate_lead',
                data: values,
                type: 'POST',
                success: function(success){
                    if(success.length > 0){
                        //success
                    }
                }
            });
        }
    }

}
