<?php
    require_once '../db.php';
    $bookingId = $_POST['bookingId'];
    $starRatingPunctuality = $_POST['starRatingPunctuality'];
    $starRatingEfficiency = $_POST['starRatingEfficiency'];
    $starRatingProfessionalism = $_POST['starRatingProfessionalism'];

    $choices = $_POST['choices'];
    $writtenFeedback = $_POST['writtenFeedback'];

    $sql = "INSERT INTO Feedback (Booking_ID, Star_Punctuality, Star_Efficiency, Star_Professionalism, Extra_Observations, Written_Feedback) VALUES ($bookingId, $starRatingPunctuality, $starRatingEfficiency, $starRatingProfessionalism, '$choices', '$writtenFeedback')";

    $result = $conn->query($sql);
    $conn->close();

    if ($result) {
        echo("Success");
    } else {
        echo("Error");
    }
    
    
    
?>