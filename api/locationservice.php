<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $body = file_get_contents('php://input');

        $data = json_decode($body, true);
        $locationData = $data['data'];
        $locationSize = sizeof($locationData);
        $latitude = $data['latitude'];
        $longitude = $data['longitude'];

        $resultArray = array();

        for($i = 0; $i < $locationSize; $i++){
            $userId = $locationData[$i]['userId'];
            $city = $locationData[$i]['city'];

            $distance = getDistance($latitude, $longitude, $city);
            array_push($resultArray, array("userId" => $userId, "distance" => $distance));
        }

        header('Content-Type: application/json');
        echo json_encode($resultArray);
    }

    function getDistance($latitude, $longitude, $city){
        $lat = $latitude;
        $lng =  $longitude;
        $to_location = $city;

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

        return $distance;
    }


?>
