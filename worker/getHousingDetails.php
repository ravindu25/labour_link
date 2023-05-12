<?php
    $houseID = $_POST['houseID'];
    $type = $_POST['type'];

    require_once('../db.php');
    $sql = "SELECT * FROM House INNER JOIN User ON House.Customer_ID = User.User_ID WHERE House_ID = $houseID";
    $result = $conn -> query($sql);

    $row = $result->fetch_assoc();

    echo('<div class="housing-job-details-title">
    <h1>More Information about the Housing Job</h1>
</div>
<div class="details-container">
    <div class="details-row">
        <h4>Job type</h4>
        <h4 class="details-value">'.$type.'</h4>
    </div>
    <div class="details-row">
        <h4>Customer</h4>
        <h4 class="details-value">'.$row['First_Name'].' '.$row['Last_Name'].'</h4>
    </div>
    <div class="details-row">
        <h4>House Address</h4>
        <h4 class="details-value">'.$row['Address'].'</h4>
    </div>
    <div class="details-row">
        <h4>Contact Number</h4>
        <h4 class="details-value">'.$row['Contact_No'].'</h4>
    </div>
    <div class="details-row">
        <h4>User Address</h4>
        <h4 class="details-value">'.$row['User_Address'].'</h4>
    </div> 
    <div class="back-button-container">
        <button type="button" class="more-button" id="back-button">Back</button>
    </div>
</div>');
?>