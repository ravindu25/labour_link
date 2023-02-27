<?php
function get_distance($from_location) {
    // Get the current user's location
    if (isset($_SERVER['HTTP_X_APPENGINE_CITYLATLONG'])) {
        // App Engine geolocation header
        $current_location = $_SERVER['HTTP_X_APPENGINE_CITYLATLONG'];
    } else {
        // Default to the Googleplex
        $current_location = '37.4219999,-122.0840575';
    }

    // Call the Google Maps Distance Matrix API
    $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='
        . urlencode($current_location) . '&destinations=' . urlencode($from_location) . '&key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo';
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    // Extract the distance value from the API response
    if ($data['status'] == 'OK' && count($data['rows']) > 0 && count($data['rows'][0]['elements']) > 0) {
        $distance = $data['rows'][0]['elements'][0]['distance']['value'] / 1000;
        return $distance;
    } else {
        return false;
    }
}


echo(get_distance("Moratuwa, Sri Lanka"));
?>
