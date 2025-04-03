  var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

   function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        // for (var component in componentViewport) {
        //   document.getElementById(component).value = '';
        //   document.getElementById(component).disabled = false;
        // }
        // console.log(place.geometry['viewport']['f']);
        // console.log(place.address_components);
        if(place.geometry['viewport']){
          var cplace =  place.geometry['viewport'];
          document.getElementById('customer-latitude').value = cplace['f']['b'];
          document.getElementById('customer-longitude').value = cplace['b']['b'];
        }
        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
         var val = "";
        for (var i = 0; i < place.address_components.length; i++) {
           var addressType = place.address_components[i].types[0];
           if (componentForm[addressType]) {
            val = val + place.address_components[i][componentForm[addressType]] + ", ";
           }
        }
        
        val = val.slice(0, -2);
        // console.log(val);
        document.getElementById('customer-address').value = val;
    }
