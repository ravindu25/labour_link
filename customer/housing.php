<?php
    session_start();
    require_once('../db.php');
    // Check whether customer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Customer') {
        header("Location: ../login.php");
    }
    $userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@400;500;600&display=swap"
          rel="stylesheet">

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

    <!-- CSS files -->
    <link href="../styles/index-page.css" rel="stylesheet"/>
    <link href="../styles/dashboard.css" rel="stylesheet"/>
    <link href="../styles/customer/customer-housing.css" rel="stylesheet" />
    <title>Housing | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="housing-create-container" id="housing-create-container">
    <div class="housing-create-page" id="housing-create-first-page">
        <div class="housing-create-banner-container">
            <h1>Start you're own housing project</h1>
            <img src="../assets/customer/housing/housing-project-create.png" alt="housing-banner" />
        </div>
        <div class="housing-create-page-container">
            <div class="housing-create-page-row">
                <h5>House address(Supported by google locations)&nbsp;&nbsp;<i class="fa-solid fa-location-dot"></i></h5>
                <input type="text" id="place-autocomplete" class="housing-create-page-text-input" />
            </div>
            <div class="button-container">
                <button class="secondary-button" onclick="closeHousingCreateModal()">Cancel</button>
                <button class="primary-button" id="first-page-next-button" onclick="goToSecondHousingPage()">Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="housing-create-page" id="housing-create-second-page">
        <h1>Select jobs that you need to complete</h1>
        <div class="housing-create-tasks-container">
            <?php
                $sql_statement = 'SELECT * FROM Job_Type';

                $result = $conn->query($sql_statement);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $jobId = $row['Job_Type_ID'];
                        $description = $row['Description'];
                        $numberIcon = '';

                        if($jobId > 9){
                            $secondDigit = $jobId % 10;
                            $firstDigit = ($jobId - $secondDigit) / 10;
                            $numberIcon = "<i class='fa-solid fa-$firstDigit'></i><i class='fa-solid fa-$secondDigit'></i>";
                        } else {
                            $numberIcon = "<i class='fa-solid fa-$jobId'></i>";
                        }

                        echo "
                        <label>
                            <input type='checkbox' name='job-selection' value='$jobId' class='job-selection-input' />
                            <div class='job-selection-container'>
                                $numberIcon
                                <h3>$description</h3>
                            </div>
                        </label>
                        ";
                    }
                }
            ?>
        </div>
        <div class="button-container">
            <button class="primary-button" onclick="goToFirstHousingPage()"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</button>
            <button class="secondary-button" onclick="closeHousingCreateModal()">Cancel</button>
            <button class="primary-button" onclick="submitHousing()"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Create</button>
        </div>
    </div>
</div>
<div class="success-message-container" id="housing-create-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Housing project placed successfully and we will verify it soon!</h1>
</div>
<div class="failed-message-container" id="housing-create-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Housing project creation failed!</h1>
        <h5 id="housing-create-fail-text">Your login session outdated. Please login again.</h5>
    </div>
</div>
<?php include_once '../components/navbar.php' ?>
<main class="main-section">
    <section class="sidebar">
        <h1 class="sidebar-heading">Dashboard</h1>
        <div class="sidebar-items">
            <a href="./dashboard.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-server sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Overview</h4>
                </div>
            </a>
            <a href="./bookings.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-b sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Bookings</h4>
                </div>
            </a>
            <a href="./feedbacks.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-message sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Feedbacks</h4>
                </div>
            </a>
            <a href="./housing.php">
                <div class="sidebar-item sidebar-item-selected">
                    <i class="fa-solid fa-house sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Housing</h4>
                </div>
            </a>
            <a href="./payments.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-credit-card sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Payments</h4>
                </div>
            </a>
            <a href="./profile.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-circle-user sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Profile</h4>
                </div>
            </a>
        </div>
    </section>
    <section class="main-content">
        <div class="main-heading">
            <h1>All About Your <u>Housing Projects</u> Here!</h1>
            <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
        </div>
        <div class="new-housing">
            <h1>Do you want to start a new housing project?</h1>
            <button class="more-button" id="project-create-button" onclick="openHousingCreateModal()">Start Project</button>
        </div>
        <div class="current-projects">
            <h1>Ongoing housing projects</h1>
            <div class="projects-container" >

            </div>
            <?php
                $sql_get_customer_housings = "SELECT * FROM House WHERE Customer_ID = $userId";

                $result = $conn->query($sql_get_customer_housings);

                if($result->num_rows > 0){
                    echo "<div class='projects-container'>";
                    $numberCount = 0;

                    while($row = $result->fetch_assoc()) {
                        $address = $row['Address'];
                        $verified = $row['Verified'];
                        $houseId = $row['House_ID'];
                        $jobsContainerId = "project-items-jobs-container-$houseId";
                        $numberCount += 1;

                        $sql_get_housing_jobs = "SELECT Job_Type.*, Job.* FROM Job_Type INNER JOIN Job On Job_Type.Job_Type_ID = Job.Job_Type_ID WHERE Job.House_ID = $houseId";

                        $numberIcon = '';

                        if($numberCount > 9){
                            $secondDigit = $numberCount % 10;
                            $firstDigit = ($numberCount - $secondDigit) / 10;
                            $numberIcon = "<i class='fa-solid fa-$firstDigit'></i><i class='fa-solid fa-$secondDigit'></i>";
                        } else {
                            $numberIcon = "<i class='fa-solid fa-$numberCount'></i>";
                        }

                        if($verified == 1){
                            $verifiedDisplay = "
                                <i class='fa-solid fa-circle-check' style='color: var(--success-color)'></i>
                                &nbsp;&nbsp;
                                <h5>Verified</h5>
                            ";
                        } else {
                            $verifiedDisplay = "
                                <i class='fa-solid fa-circle-xmark' style='color: var(--danger-color)'></i>
                                &nbsp;&nbsp;
                                <h5>Not verified</h5>
                            ";
                        }
                        echo "
                        <div class='project-item-container'>
                            <div class='project-item-header'>
                                <div class='project-item-header-title'>
                                <h5>Housing package details</h5>
                                <h1>
                                    $address
                                </h1>
                                </div>
                                <div class='project-item-verified-container'>
                                    $verifiedDisplay
                                </div>
                            </div>
                            <div class='project-item-jobs-container' id='$jobsContainerId'>";

                              $jobsResult = $conn->query($sql_get_housing_jobs);
                              if($jobsResult->num_rows > 0){
                                  while($jobsRow = $jobsResult->fetch_assoc()){
                                    $description = $jobsRow['Description'];
                                    $completionFlag = $jobsRow['Completion_Flag'];
                                    $advertisementStatus = $jobsRow['Advertisement_Status'];

                                    $jobStatusBadge = '';

                                    if($completionFlag == 1){
                                        $jobStatusBadge = "<button class='completed-badge'>
                                            <i class='fa-solid fa-check'></i>&nbsp;&nbsp;Completed
                                            </button>";
                                    } else if($advertisementStatus == 1){
                                        $jobStatusBadge = "<button class='advertised-badge'>
                                                <i class='fa-solid fa-chart-simple'></i>&nbsp;&nbsp;Advertised
                                                </button>";
                                    } else {
                                        $jobStatusBadge = "<button class='pending-badge'><i class='fa-solid fa-hourglass-start'></i>&nbsp;&nbsp;Pending</button>";
                                    }

                                    echo "
                                        <div class='project-job-item'>
                                            <h5>$description</h5>
                                            $jobStatusBadge
                                        </div>
                                        ";
                                  }
                              }

                            echo "</div>
                            <div class='project-item-buttons'>
                                <button type='button' class='secondary-button' id='jobs-load-more-button-$houseId' onclick='showJobs($houseId)'>
                                    <i class='fa-solid fa-arrow-down'></i>&nbsp;&nbsp;Load jobs
                                </button>
                                <a href='housing-project.php?houseId=$houseId'>
                                    <button type='button' class='primary-button'>
                                        <i class='fa-solid fa-arrow-right'></i>&nbsp;&nbsp;Show details
                                    </button>
                                </a>
                            </div>
                        </div>
                        ";
                    }

                    echo "</div>";
                } else {
                    echo "
                     <div class='empty-projects-container'>
                        <img src='../assets/customer/housing/undraw_house_searching_re_stk8.svg' alt='housing-projects' />
                        <h5>You don't have any housing projects started</h5>
                    </div>
                    ";
                }
            ?>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<?php
    echo "
        <script>
            let userId = $userId;
        </script>
    ";
?>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/housing.js" type="text/javascript"></script>
<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo&libraries=places&callback=initAutocomplete">
</script>
</body>
