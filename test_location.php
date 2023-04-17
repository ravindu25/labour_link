
<?php
//   $lat = $_POST['lat'];
//   $lng = $_POST['lng'];
//   $to_location = $_POST['to_location'];

//   // Use Google Maps API Geocoding to get the latitude and longitude of the "To Location"
//   $geocode_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($to_location)."&key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo";
  
//   $curl = curl_init();
//   curl_setopt_array($curl, array(
//     CURLOPT_RETURNTRANSFER => 1,
//     CURLOPT_URL => $geocode_url,
//   ));
//   $response = curl_exec($curl);
//   curl_close($curl);

//   $geocode_obj = json_decode($response);
//   $to_lat = $geocode_obj->results[0]->geometry->location->lat;
//   $to_lng = $geocode_obj->results[0]->geometry->location->lng;

//   // Calculate distance between two locations using Haversine formula
//   $R = 6371; // Earth's mean radius in km
//   $lat1 = deg2rad($lat);
//   $lng1 = deg2rad($lng);
//   $lat2 = deg2rad($to_lat);
//   $lng2 = deg2rad($to_lng);
//   $dlat = $lat2 - $lat1;
//   $dlng = $lng2 - $lng1;
//   $a = sin($dlat/2) * sin($dlat/2) + cos($lat1) * cos($lat2) * sin($dlng/2) * sin($dlng/2);
//   $c = 2 * atan2(sqrt($a), sqrt(1-$a));
//   $distance = $R * $c;

//   // Return distance in kilometers to JavaScript
//   echo $distance;



// PHP code in your_php_script.php

  $lat = $_POST['lat'];
  $lng = $_POST['lng'];
  $to_location = $_POST['to_location'];

  // Use Google Maps API Geocoding to get the latitude and longitude of the "To Location"
  $geocode_url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($to_location)."&key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo";
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $geocode_url,
  ));
  $response = curl_exec($curl);
  curl_close($curl);

  $geocode_obj = json_decode($response);
  $to_lat = $geocode_obj->results[0]->geometry->location->lat;
  $to_lng = $geocode_obj->results[0]->geometry->location->lng;

  // Use Google Maps Directions API to get the driving distance between two locations
  $directions_url = "https://maps.googleapis.com/maps/api/directions/json?origin=".$lat.",".$lng."&destination=".$to_lat.",".$to_lng."&mode=driving&key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo";

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $directions_url,
  ));
  $response = curl_exec($curl);
  curl_close($curl);

  $directions_obj = json_decode($response);
  $distance = $directions_obj->routes[0]->legs[0]->distance->value / 1000; // Convert distance to kilometers

  // Return distance in kilometers to JavaScript
  header('Content-Type: application/json');
  echo json_encode(array('distance' => $distance));


?>
