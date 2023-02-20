<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Get Current Location using Google Maps API</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo&callback=initMap" async defer></script>
    <script>
      var formatted_location = "";
      function initMap() {
        console.log("Google Maps API loaded");
        getLocation();
      }

      function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
          alert("Geolocation is not supported by this browser.");
        }
      }

      function showPosition(position) {
        console.log("Latitude: " + position.coords.latitude);
        console.log("Longitude: " + position.coords.longitude);

        var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        var geocoder = new google.maps.Geocoder();
        var location = "7 PM Fernando Mawatha";
        

        geocoder.geocode({'address': location}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            console.log("Geocoder results: ", results);
            if (results[0]) {
              console.log("Formatted address: ", results[0].formatted_address);
              formatted_location = results[0].formatted_address;
              var moratuwaLatLng = results[0].geometry.location;
              calculateDistance(latLng, moratuwaLatLng);
            } else {
              console.log("No results found");
              alert("No results found");
            }
          } else {
            console.log("Geocoder failed due to: ", status);
            alert("Geocoder failed due to: " + status);
          }
        });
      }

      function calculateDistance(origin, destination) {
        var distanceService = new google.maps.DistanceMatrixService();
        distanceService.getDistanceMatrix({
          origins: [origin],
          destinations: [destination],
          travelMode: google.maps.TravelMode.DRIVING,
          unitSystem: google.maps.UnitSystem.METRIC
        }, function(response, status) {
          if (status === google.maps.DistanceMatrixStatus.OK) {
            var distance = response.rows[0].elements[0].distance.value / 1000;
            console.log("Distance to location: " + distance + " km");
            document.getElementById("location").innerHTML = "Distance to "+ formatted_location +": " + distance + " km";
          } else {
            console.log("Failed to calculate distance due to: ", status);
            alert("Failed to calculate distance due to: " + status);
          }
        });
      }

      function showError(error) {
        console.log("Geolocation error: ", error);
        alert("Geolocation error: " + error.message);
      }
    </script>
  </head>
  <body>
    <h1>Get Current Location using Google Maps API</h1>
    <p>Your current location is:</p>
    <p id="location"></p>
  </body>
</html>
