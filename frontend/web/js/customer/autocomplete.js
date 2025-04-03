// In the following example, markers appear when the user clicks on the map.
// Each marker is labeled with a single alphabetical character.
var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
var labelIndex = 0;

function initialize() {

  var input = document.getElementById('searchTextField');        
  var autocomplete = new google.maps.places.Autocomplete(input);
  var lat;
  var lng;
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
            var formatted_address = place.formatted_address;
            document.getElementById("customer-address").value =  formatted_address;
            document.getElementById("customer-latitude").value = lat;
            document.getElementById("customer-longitude").value = lng;

            loadMap(lat, lng, formatted_address);
         }
      );


  //add default map on the UI
  var latLng = { lat: 14.6091, lng:  121.0223};
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: latLng,
      });
  addMarker(latLng, map);
  

  // This event listener calls addMarker() when the map is clicked.
  // google.maps.event.addListener(map, 'click', function(event) {
  //   addMarker(event.latLng, map);
  // });

}

//---------------------LOAD MAP IN MAP_CANVAS CONTAINER---------------------------//
    
    function loadMap(lat,lng,formatted_address) {  
      var latLng = { lat: lat, lng: lng };
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 18,
        center: latLng,
      });

      // Add a marker at the center of the map.
      addMarker(latLng, map);
   }

// Adds a marker to the map.
function addMarker(location, map) {
  // Add the marker at the clicked location, and add the next-available label
  // from the array of alphabetical characters.
  

  var marker = new google.maps.Marker({
    position: location,
    // label: labels[labelIndex++ % labels.length],
    map: map,
    draggable: true
  });
  google.maps.event.addListener(marker, 'dragend', function (event) {
    // console.log(this.getPosition());
      $("#customer-latitude").val(this.getPosition().lat().toFixed(6));
      $("#customer-longitude").val(this.getPosition().lng().toFixed(6));
    });

  toggleBounce(marker);
}

function toggleBounce(marker) {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}

google.maps.event.addDomListener(window, 'load', initialize);