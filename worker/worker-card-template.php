<?php
    echo "
<div class='worker-card'>
    <h1 class='worker-card-title'>"
        . ucfirst($fullName) .
        "</h1>
    <div class='worker-card-star-container'>
        $ratingHtml
        &nbsp;&nbsp;<b>$currentRating </b>
    </div>
    <div class='worker-image'>
        <img src='$imageUrl' alt='worker-profile'>
    </div>
    <div class='worker-card-location-row'>
        <h3><i class='fa-solid fa-location-dot' style='color: var(--primary-color)'></i>&nbsp;&nbsp;"
            . ucfirst($city) .
            "</h3>
    </div>
    <div class='worker-card-types-row'>
        <div class='worker-type-badge'>
            <h5>Electrician</h5>
        </div>
        <div class='worker-type-badge'>
            <h5>Plumber</h5>
        </div>
    </div>
    <div class='worker-card-button-container'>
        <a href='view-worker-profile.php?workerId=$userId'>
            <button type='button' class='view-profile-button'>View Profile</button>
        </a>
        <button type='button' class='booking-button' id='booking-create-button'>Book now!</button>
    </div>
</div>
"

        echo '<div class="button-container">
            <button type="button" class="more-button" id="top-workers-button">Load more&nbsp;
                <i class="fa-solid fa-spinner"></i></button>
        </div>';
        ?>