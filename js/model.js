var MODEL = MODEL || {};

MODEL.domElems = {
    startGenerator: document.getElementById('startGenerator'),
    progressTracker: document.getElementById('progressTracker'),
    stepZero: document.getElementById('stepZero'),
    stepOne: document.getElementById('stepOne'),
    stepTwo: document.getElementById('stepTwo'),
    stepThree: document.getElementById('stepThree'),
    stepFour: document.getElementById('stepFour'),
    stepFive: document.getElementById('stepFive'),
    stepSix: document.getElementById('stepSix'),
    manualSteps: document.getElementsByClassName('manualStep'),
    wizardSteps: document.getElementsByClassName('wizardSteps'),
    zipCityInput: document.getElementsByClassName('zipCityInput'),
    zipCitySuggest: document.getElementsByClassName('zipCitySuggest'),
    carData: document.getElementsByClassName('carData'),
    carDataOlder: document.getElementsByClassName('carDataOlder'),
    pickupDate: document.getElementsByClassName('pickUpDay'),
    monthNav: document.getElementsByClassName('monthNav'),
    calendar: document.getElementById('pickUpDate'),
    shippingOptions: document.getElementsByClassName('shippingOptions'),
    trackerStep: document.getElementsByClassName('trackerStep'),
    trackerIcon: document.getElementsByClassName('trackerIcon'),
    changeQuote: document.getElementById('changeQuote'),
    saveMyQuote: document.getElementById('saveMyQuote'),
    proceedToQuote: document.getElementById('proceedToQuote'),
    usrEmail: document.getElementById('usrEmail'),
    usrName: document.getElementById('usrName'),
    usrPhone: document.getElementById('usrPhone'),
    saveQuoteForm: document.getElementById('saveQuoteForm'),
    pickUpDateStatic: document.getElementById('pickUpDate'),
    contactLead: document.getElementsByClassName('contactLead'),
    origLat: document.getElementById('origLat'),
    origLng: document.getElementById('origLng'),
    destLat: document.getElementById('destLat'),
    destLng: document.getElementById('destLng'),
    agreement: document.getElementById('agreement'),
    bookService: document.getElementById('card-nonce-submit'),
    agreementRequired: document.getElementById('agreementRequired')
};

MODEL.data = {
    progressTracker: {
        stepOne: false,
        stepTwo: false,
        stepThree: false,
        stepFour: false,
        stepFive: false,
        allSteps: false
    },
    quoteData: {
        quoteId: null,
        quoteDate: null,
        originZip: null,
        originCity: null,
        originLatitude: null,
        originLongitude: null,
        originAddress: null,
        destZip: null,
        destCity: null,
        destLatitude: null,
        destLongitude: null,
        destAddress: null,
        carYear: null,
        carMake: null,
        carModel: null,
        carSize: null,
        pickUpDate: null,
        pickUpFormattedDate: null,
        transportType: null,
        convertible: false,
        modified: false,
        carCondition: true,
        distanceInMiles: null,
        disanceInMilesPrecise: null,
        pricePerDistance: null,
        pricePerSize: null,
        standardTotal: null,
        priorityTotal: null,
        expeditedTotal: null,
        publishedTotal: null,
        usrEmail: null,
        usrName: null,
        usrPhone: null
    },
    quoteRates: {
        rateMileOpen: 0.50,
        rateMileClosed: 1,
        carOk: 0,
        carNotOk: 150,
        standardFee: 0,
        lowPriority: 25,
        midPriority: 50,
        priorityFee: 75,
        lowExpedite: 50,
        midExpedite: 100,
        expediteFee: 150,
        lowDeposit: 50,
        midDeposit: 100,
        deposit: 150
    },
    carSizes: {
        "0": 0,
        "1": 25,
        "2": 50,
        "3": 75,
        "4": 100
    },
    vendorRates: {
        "route":{
            "items":[
                {
                    "address":{
                        "postalCode": null,
                        "country": 'US'
                    },
                    "timeFrame": {
                        "earliestArrival": null,
                        "latestArrival": null,
                        "timeFrameType": "on"
                    }
                },
                {
                    "address":{
                        "postalCode": null,
                        "country": 'US'
                    },
                    "timeFrame": {
                        "earliestArrival": null,
                        "latestArrival": null,
                        "timeFrameType": "between"
                    }
                }
            ]
        },
        "items":[
            {
                "commodity": "CarsLightTrucks",
                "makeName": null,
                "modelName": null,
                "year": null,
                "isRunning": true,
                "isConvertible": false,
                "isModified": false
            }
        ]
    },
    vendorPublishedRates: {}
};
