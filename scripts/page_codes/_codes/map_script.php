<script>
  var map;
  var infoWindow;
  function initMap() {
	map = new google.maps.Map(document.getElementById('map_<?php print($this_option_id);?>'), {
	  center: {lat: -15.4168189, lng: 28.2737132},
	  zoom: 13
	});
	
	google.maps.event.addListener(map, 'click', function(event) {
	  placeMarker(event.latLng);
	});
	
	 infoWindow = new google.maps.InfoWindow;
	  if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
           // infoWindow.open(map);
            map.setCenter(pos);
			$('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val(pos.lat+','+pos.lng);
			placeMarker(pos);
			
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
	
  }
  
	function handleLocationError(browserHasGeolocation, infoWindow, pos) {
		infoWindow.setPosition(pos);
		infoWindow.setContent(browserHasGeolocation ?
							  'Error: The Geolocation service failed.' :
							  'Error: Your browser doesn\'t support geolocation.');
		infoWindow.open(map);
	}
  
	var marker;
	function placeMarker(location) {
	  if ( marker ) {
		marker.setPosition(location);
	  } else {
		marker = new google.maps.Marker({
		  position: location,
		  map:map
		});
	  }

	  $('#category_option_<?php print($this_category_id.'_'.$this_option_id);?>_value').val(location);
	}
	
	
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5S8fOeptaW9522eqNwtUTw9WbnomcVUg&callback=initMap"
async defer></script>