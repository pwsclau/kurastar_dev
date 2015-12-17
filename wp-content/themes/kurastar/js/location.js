(function($, document, window) {
    'use strict';

    var D = $(document),
        W = $(window),
        autocomplete = null,
        componentForm = {
            street_number: 'short_name',
            route: 'long_name',
            locality: 'long_name',
            administrative_area_level_1: 'short_name',
            country: 'long_name',
            postal_code: 'short_name',
            region: 'long_name'
        },
        Global  = {
            init: function () {
                this.autocompleteAddress();
            },
            autocompleteAddress:function () {

                var input  = document.getElementById('custom-location');
                if(input) {
                    //Reset the below input box on click
                    input.addEventListener('click', function(){
                        $(this).addClass('test-class');
                        input.value = "";
                    });
                }

                if (!document.getElementById('custom-location')) return;
                // Create the autocomplete object, restricting the search
                // to geographical location types.
                autocomplete = new google.maps.places.Autocomplete(
                    /** @type {HTMLInputElement} */(document.getElementById('custom-location')),
                    { types: ['(cities)'] });
                //componentRestrictions: {country: 'US'}
                // When the user selects an address from the dropdown,
                // populate the address fields in the form.
                google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    var place = autocomplete.getPlace();
                    Global.fillAddress();
                });

            },
            fillAddress:function () {
                // Get the place details from the autocomplete object.
                var place = autocomplete.getPlace();

                for (var component in componentForm) {

                    if (document.getElementById(component)) {
                        document.getElementById(component).value = '';
                        document.getElementById(component).disabled = false;
                    }
                }

                // Get each component of the address from the place details
                // and fill the corresponding field on the form.
                for (var i = 0; i < place.address_components.length; i++) {
                    var addressType = place.address_components[i].types[0];

                    if (componentForm[addressType] && document.getElementById(addressType)) {



                        var val = place.address_components[i][componentForm[addressType]];
                        document.getElementById(addressType).value = val;
                    }

                }

            }

        };
    D.ready(function() {

        Global.init();
    });
}(jQuery, document, window));