
var placeSearch, autocomplete, autocomplete2;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name'
};
var componentForm2 = {
    street_number2: 'short_name2',
    route2: 'long_name2',
    locality2: 'long_name2',
    administrative_area_level_12: 'short_name2',
    country2: 'long_name2',
    postal_code2: 'short_name2'
};

function initAutocomplete() {
    autocomplete = new google.maps.places.Autocomplete(
    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
    {types: ['geocode']});
    autocomplete2 = new google.maps.places.Autocomplete(
    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete2')),
    {types: ['geocode']});

    autocomplete.addListener('place_changed', fillInAddress);
    autocomplete2.addListener('place_changed', fillInAddress2);
}

function calculateDistance(){
    if(MODEL.data.quoteData.originAddress && MODEL.data.quoteData.destAddress){
        var origLat = MODEL.data.quoteData.originLatitude,
            origLng = MODEL.data.quoteData.originLongitude,
            destLat = MODEL.data.quoteData.destLatitude,
            destLng = MODEL.data.quoteData.destLongitude;
        var origin1 = new google.maps.LatLng(origLat, origLng);
        //var origin2 = '';
        //var destinationA = '';
        var destinationB = new google.maps.LatLng(destLat, destLng);

        var service = new google.maps.DistanceMatrixService();
        service.getDistanceMatrix({
            origins: [origin1],
            destinations: [destinationB],
            travelMode: 'DRIVING',
            //transitOptions: TransitOptions,
            //drivingOptions: DrivingOptions,
            unitSystem: google.maps.UnitSystem.IMPERIAL,
            avoidHighways: false,
            avoidTolls: false,
            },
        callback);
    }
}

function callback(response, status) {
    if (status == 'OK') {
        var origins = response.originAddresses;
        var destinations = response.destinationAddresses;
        for (var i = 0; i < origins.length; i++) {
            var results = response.rows[i].elements;
            for (var j = 0; j < results.length; j++) {
                var element = results[j];
                var distance = element.distance.text;
                var duration = element.duration.text;
                var from = origins[i];
                var to = destinations[j];
            }
        }
        MODEL.data.quoteData.disanceInMilesPrecise = distance;
        document.getElementById('preciseMileage').value = distance;
        //APP.events.updateBaseFee(distance);
    }
}

function fillInAddress() {
    var place = autocomplete.getPlace();
    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }
    MODEL.data.quoteData.originLatitude = place.geometry.location.lat();
    MODEL.domElems.origLat.value = place.geometry.location.lat();
    MODEL.data.quoteData.originLongitude = place.geometry.location.lng();
    MODEL.domElems.origLng.value = place.geometry.location.lng();
    MODEL.data.quoteData.originAddress = true;
    calculateDistance();
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}

function fillInAddress2() {
    var place2 = autocomplete2.getPlace();
    for (var component in componentForm2) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }
    MODEL.data.quoteData.destLatitude = place2.geometry.location.lat();
    MODEL.domElems.destLat.value = place2.geometry.location.lat();
    MODEL.data.quoteData.destLongitude = place2.geometry.location.lng();
    MODEL.domElems.destLng.value = place2.geometry.location.lng();
    MODEL.data.quoteData.destAddress = true;
    calculateDistance();
    for (var i = 0; i < place2.address_components.length; i++) {
        var addressType = place2.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place2.address_components[i][componentForm[addressType]];
            document.getElementById(addressType+"2").value = val;
        }
    }
}
