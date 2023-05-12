<?php
    session_start();
    // Check whether worker is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Worker') {
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
    <link href="../styles/worker-dashboard.css" rel="stylesheet"/>
    <link href="../styles/worker/worker-profile.css" rel="stylesheet"/>
    <title>Worker Profile | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<?php
    require_once('../db.php');

    $sql_statement = "SELECT Worker.Worker_ID, P.Plumber_ID, P.Active AS Plumber_Active, C.Carpenter_ID, C.Active AS Carpenter_Active, E.Electrician_ID, E.Active AS Electrician_Active, P2.Painter_ID, P2.Active AS Painter_Active,
        M.Mason_ID, M.Active AS Mason_Active, J.Janitor_ID, J.Active AS Janitor_Active, M2.Mechanic_ID, M2.Active AS Mechanic_Active, G.Gardener_ID, G.Active AS Gardener_Active
                    FROM Worker LEFT JOIN Plumber P on Worker.Worker_ID = P.Plumber_ID
                    LEFT JOIN Carpenter C on Worker.Worker_ID = C.Carpenter_ID
                    LEFT JOIN Electrician E on Worker.Worker_ID = E.Electrician_ID
                    LEFT JOIN Painter P2 on Worker.Worker_ID = P2.Painter_ID
                    LEFT JOIN Mason M on Worker.Worker_ID = M.Mason_ID
                    LEFT JOIN Janitor J on Worker.Worker_ID = J.Janitor_ID
                    LEFT JOIN Mechanic M2 on Worker.Worker_ID = M2.Mechanic_ID
                    LEFT JOIN Gardener G on Worker.Worker_ID = G.Gardener_ID WHERE Worker_ID = $userId";

    $result = $conn->query($sql_statement);

    $workerCategories = array();
    $addCategories = array();
    $activeCategories = array();
    $deactiveCategories = array();

    if($result->num_rows){
        while($row = $result->fetch_assoc()){
            if($row['Plumber_ID'] != null){
                array_push($workerCategories, "Plumber");

                if($row['Plumber_Active'] == 1){
                    array_push($activeCategories, "Plumber");
                } else {
                    array_push($deactiveCategories, "Plumber");
                }
            } else {
                array_push($addCategories, "Plumber");
            }

            if($row['Carpenter_ID'] != null){
                array_push($workerCategories, "Carpenter");

                if($row['Carpenter_Active'] == 1){
                    array_push($activeCategories, "Carpenter");
                } else {
                    array_push($deactiveCategories, "Carpenter");
                }
            } else {
                array_push($addCategories, "Carpenter");
            }

            if($row['Electrician_ID'] != null){
                array_push($workerCategories, "Electrician");

                if($row['Electrician_Active'] == 1){
                    array_push($activeCategories, "Electrician");
                } else {
                    array_push($deactiveCategories, "Electrician");
                }
            } else {
                array_push($addCategories, "Electrician");
            }

            if($row['Painter_ID'] != null){
                array_push($workerCategories, "Painter");

                if($row['Painter_Active'] == 1){
                    array_push($activeCategories, "Painter");
                } else {
                    array_push($deactiveCategories, "Painter");
                }
            } else {
                array_push($addCategories, "Painter");
            }

            if($row['Mason_ID'] != null){
                array_push($workerCategories, "Mason");

                if($row['Mason_Active'] == 1){
                    array_push($activeCategories, "Mason");
                } else {
                    array_push($deactiveCategories, "Mason");
                }
            } else {
                array_push($addCategories, "Mason");
            }

            if($row['Janitor_ID'] != null){
                array_push($workerCategories, "Janitor");

                if($row['Janitor_Active'] == 1){
                    array_push($activeCategories, "Janitor");
                } else {
                    array_push($deactiveCategories, "Janitor");
                }
            } else {
                array_push($addCategories, "Janitor");
            }

            if($row['Mechanic_ID'] != null){
                array_push($workerCategories, "Mechanic");

                if($row['Mechanic_Active'] == 1){
                    array_push($activeCategories, "Mechanic");
                } else {
                    array_push($deactiveCategories, "Mechanic");
                }
            } else {
                array_push($addCategories, "Mechanic");
            }

            if($row['Gardener_ID'] != null){
                array_push($workerCategories, "Gardener");

                if($row['Gardener_Active'] == 1){
                    array_push($activeCategories, "Gardener");
                } else {
                    array_push($deactiveCategories, "Gardener");
                }
            } else {
                array_push($addCategories, "Gardener");
            }
        }
    }

    function getImageUrl($workerType){
        switch($workerType){
            case "Plumber":
                return "../assets/job-card-image/plumbing-image.jpg";
            case "Carpenter":
                return "../assets/job-card-image/carpentry-image.jpg";
            case "Electrician":
                return "../assets/job-card-image/electrical-image.jpg";
            case "Painter":
                return "../assets/job-card-image/painting-image.jpg";
            case "Mason":
                return "../assets/job-card-image/masonry-image.jpg";
            case "Janitor":
                return "../assets/job-card-image/janitor-image.jpg";
            case "Mechanic":
                return "../assets/job-card-image/mechanical-image.jpg";
            case "Gardener":
                return "../assets/job-card-image/gardening-image.jpg";
        }
    }
?>
<div class="worker-type-modal" id="add-worker-type-modal">
    <div class="worker-type-modal-header">
        <h1>Add for new worker category!</h1>
    </div>
    <div class="worker-type-modal-cards-container">
        <?php
            for($i = 0; $i < sizeof($addCategories); $i++){
                $categoryName = ucfirst($addCategories[$i]);
                $imageUrl = getImageUrl($addCategories[$i]);

                echo "
                    <div class='worker-type-modal-card'>
                    <label>
                        <input type='checkbox' name='add-job-type-select' value='$addCategories[$i]' class='job-type-select' id='job-type-add-$addCategories[$i]' />
                        <div class='job-type-card-container'>
                            <div class='job-type-image-container'>
                                <img src='$imageUrl' alt='$addCategories[$i]' class='job-type-image' />
                            </div>
                            <h3>$categoryName</h3>
                    </div>
                    </label>
                    </div>
                ";
            }
        ?>
    </div>
    <div class="worker-type-modal-button-container">
        <button type="button" class="primary-outline-button" onclick="hideAddCategoryContainer()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
        <?php
        echo('<button type="button" id="worker-type-add-button" class="disable-button" onclick="addCategory('.$userId.')"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add category</button>');
        ?>
    </div>
</div>
<div class="success-message-container" id="add-jobType-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Job type added sucessfully!</h1>
</div>
<div class="failed-message-container" id="add-jobType-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Job type adding failed!</h1>
        <h5 id="add-job-type-fail-text">Your login session outdated. Please login again.</h5>
    </div>
</div>
<div class="success-message-container" id="update-jobType-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Job Type Activation/Deactivation Successful!</h1>
</div>
<div class="failed-message-container" id="update-jobType-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Job Type Activation/Deactivation Failed!</h1>
        <h5 id="update-job-type-fail-text">Your login session outdated. Please login again.</h5>
    </div>
</div>
<div class="worker-type-modal" id="update-worker-type-modal">
    <div class="worker-type-modal-header">
        <h1>Activate/Deactivate worker category!</h1>
    </div>
    <div class="worker-type-modal-cards-container">
        <?php
            for($i = 0; $i < sizeof($workerCategories); $i++){
                $categoryName = ucfirst($workerCategories[$i]);
                $imageUrl = getImageUrl($workerCategories[$i]);
                $isActive = true;

                if(in_array($workerCategories[$i], $deactiveCategories)){
                    $isActive = false;
                }

                $checkedText = '';
                if(!$isActive){
                    $checkedText = 'checked';
                }

                echo "
                    <div class='worker-type-modal-card'>
                    <label>
                        <input type='checkbox' name='update-job-type-select' value='$workerCategories[$i]' class='job-type-update-select' id='job-type-add-$workerCategories[$i]' $checkedText/>
                        <div class='job-type-card-container'>
                            <div class='job-type-image-container'>
                                <img src='$imageUrl' alt='$workerCategories[$i]' class='job-type-image' />
                            </div>
                            <h3>$categoryName</h3>
                    </div>
                    </label>
                    </div>
                ";
            }
        ?>
    </div>
    <div class="worker-type-modal-button-container">
        <button type="button" class="primary-outline-button" onclick="hideActiveDeactivateContainer()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
        <?php
        echo('<button type="button" id="worker-type-add-button" class="disable-button" onclick="updateWorkerType('.$userId.')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>');
        ?>
    </div>
</div>
<div class="profile-change-modal-container" id="profile-change-modal-container">
    <div class="change-profile-page">
        <div class="change-profile-banner">
            <h1>Change your  profile picture now!</h1>
        </div>
        <div class="current-picture-container" id="current-picture-container">
            <?php
            echo "<img src='../assets/profile-image/$userId.jpg' alt='profile-image' />";
            ?>
        </div>
        <form method="post" enctype="multipart/form-data" action="">
            <div class="select-image-container" id="select-image-container">
                <input type="file" class="upload-box" id="picture-upload-input" name="picture-upload-input" accept="image/png, image/jpeg"/>

            </div>
            <div class="profile-change-button-container">
                <button type="button" class="primary-button" id="set-default-button" onclick="setDefaultProfile()">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i>&nbsp;&nbsp;Set default
                </button>
                <button type="button" class="primary-outline-button" onclick="closeChangeProfileModal()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
                <button type="button" class="primary-button" id="remove-picture-button" onclick="goNextProfileChangePage()">
                    <i class="fa-solid fa-trash-can"></i>&nbsp;&nbsp;Remove picture
                </button>

                <input type="submit" class="disable-button" id="save-button" name="save-button" value="Save Picture" disabled>
                <!-- <button type="button" class="disable-button" id="save-button" onclick="updateProfilePicture()" disabled>
                    <i class="fa-solid fa-arrow-up"></i>&nbsp;&nbsp;Save picture
                </button> -->
            </div>
        </form>
    </div>
</div>
<div class="success-message-container" id="profile-update-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Profile picture updated!</h1>
</div>
<div class="failed-message-container" id="profile-update-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Profile picture update failed!</h1>
        <h5 id="housing-create-fail-text">Your login session outdated. Please login again.</h5>
    </div>
</div>
<?php
require_once('../db.php');

$sql_get_details = "SELECT * FROM User WHERE User_ID = $userId";
$result = $conn->query($sql_get_details);

$row = $result->fetch_assoc();
$username = $row['First_Name'] . ' ' . $row['Last_Name'];
$email = $row['Email'];
$contactNum = $row['Contact_No'];
$nic = $row['NIC'];
$dob = $row['DOB'];
$address = $row['User_Address'];
$activationFlag = $row['Activation_Flag'] == 1 ? 'Activated': 'Not activated';
?>
<div class="details-edit-modal" id="edit-modal-username">
    <div class="edit-modal-header">
        <h1>Edit your account details</h1>
    </div>
    <div class="edit-modal-inputs">
        <label for="firstname-input">First name:</label>
        <?php
        echo ('<input type="text" id="firstname-input" value="'.$row['First_Name'].'"/>');
        ?>
    </div>
    <div class="edit-modal-inputs">
        <label for="lastname-input">Last name:</label>
        <?php
        echo ('<input type="text" id="lastname-input" value="'.$row['Last_Name'].'"/>');
        ?>
    </div>
    <div class="edit-modal-button-container">
        <button type="button" class="primary-outline-button" onclick="closeEditModal('edit-modal-username')"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
        <?php
        echo('<button type="button" class="disable-button" id="update-button-name" onclick="updateName('.$userId.')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>');
        ?>
    </div>
</div>
<div class="details-edit-modal" id="edit-modal-email">
    <div class="edit-modal-header">
        <h1>Edit your account details</h1>
    </div>
    <div class="edit-modal-inputs">
        <label for="email-input">Email address:</label>
        <input type="email" id="email-input"/>
    </div>
    <div class="edit-modal-button-container">
        <button type="button" class="primary-outline-button" onclick="closeEditModal('edit-modal-email')"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
        <button type="button" class="disable-button" id="update-button-email"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>
    </div>
</div>
<div class="details-edit-modal" id="edit-modal-contactnum">
        <div class="edit-modal-header">
            <h1>Edit your account details</h1>
        </div>
        <div class="edit-modal-inputs">
            <label for="contactnum-input">Contact number:</label>
            <?php
            echo ('<input type="text" id="contactnum-input" value="'.$row['Contact_No'].'"/>');
            ?>
        </div>
        <div class="edit-modal-button-container">
            <button type="button" class="primary-outline-button" onclick="closeEditModal('edit-modal-contactnum')"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
            <?php
        echo('<button type="button" class="disable-button" id="update-button-contactnum" onclick="updateContactNum('.$userId.')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>');
        ?>
        </div>
    </div>
<div class="details-edit-modal" id="edit-modal-nic">
        <div class="edit-modal-header">
            <h1>Edit your account details</h1>
        </div>
        <div class="edit-modal-inputs">
            <label for="nic-input">NIC number:</label>
            <?php
            echo ('<input type="text" id="nic-input" value="'.$row['NIC'].'"/>');
            ?>
        </div>
        <div class="edit-modal-button-container">
            <button type="button" class="primary-outline-button" onclick="closeEditModal('edit-modal-nic')"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
            <?php
        echo('<button type="button" class="disable-button" id="update-button-nic" onclick="updateNIC('.$userId.')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>');
        ?>
        </div>
    </div>
<div class="details-edit-modal" id="edit-modal-dob">
        <div class="edit-modal-header">
            <h1>Edit your account details</h1>
        </div>
        <div class="edit-modal-inputs">
            <label for="dob-input">Date of Birth:</label>
            <?php
            echo ('<input type="date" id="dob-input" value="'.$row['DOB'].'"/>');
            ?>
        </div>
        <div class="edit-modal-button-container">
            <button type="button" class="primary-outline-button" onclick="closeEditModal('edit-modal-dob')"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
            <?php
        echo('<button type="button" class="disable-button" id="update-button-dob" onclick="updateDOB('.$userId.')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>');
        ?>
        </div>
    </div>
<div class="details-edit-modal" id="edit-modal-address">
        <div class="edit-modal-header">
            <h1>Edit your account details</h1>
        </div>
        <div class="edit-modal-inputs">
            <label for="address-input">Address:</label>
            <?php
            echo ('<input type="text" id="address-input" value="'.$row['User_Address'].'"/>');
            ?>
        </div>
        <div class="edit-modal-button-container">
            <button type="button" class="primary-outline-button" onclick="closeEditModal('edit-modal-address')"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
            <?php
        echo('<button type="button" class="disable-button" id="update-button-address" onclick="updateAddress('.$userId.')"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Update details</button>');
        ?>
        </div>
    </div>
<div class="success-message-container" id="account-details-update-success">
        <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Account details updated!</h1>
    </div>
<div class="failed-message-container" id="account-details-update-fail">
        <div class="message-text">
            <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Account details update failed!</h1>
            <h5 id="housing-create-fail-text">Your login session outdated. Please login again.</h5>
        </div>
    </div>
<div class="change-password-container" id="change-password-container">
        <div class="change-password-header">
            <h1>Change your current password</h1>
        </div>
        <div class="change-password-row">
            <label for="change-password-label">Current password</label>
            <input type="password" id="current-password-input" />
        </div>
        <div class="change-password-row">
            <label for="new-password-input">New password</label>
            <input type="password" id="new-password-input" />
        </div>
        <div class="change-password-row">
            <label for="reenter-new-password-input">Re-enter new password</label>
            <input type="password" id="reenter-new-password-input" />
        </div>
        <div class="change-password-button-container">
            <button type="button" class="primary-outline-button" onclick="closeChangePasswordModal()">
                <i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel
            </button>
            <?php
            echo('<button type="button" class="disable-button" id="change-password-button" onclick="updatePassword('.$userId.')" disabled>
            <i class="fa-solid fa-unlock-keyhole"></i>&nbsp;&nbsp;Change 
        </button>');
            ?>
        </div>
    </div>
<div class="success-message-container" id="password-change-success">
        <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Password changed!</h1>
    </div>
<div class="failed-message-container" id="password-change-fail">
        <div class="message-text">
            <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Password change failed!</h1>
            <h5 id="password-update-failed-text">Your login session outdated. Please login again.</h5>
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
            <a href="./housing.php">
                <div class="sidebar-item">
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
                <div class="sidebar-item sidebar-item-selected">
                    <i class="fa-regular fa-circle-user sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Profile</h4>
                </div>
            </a>
        </div>
    </section>
    <section class="main-content">
        <div class="main-heading">
            <h1>The Settings Of Your <u>Profile!</u></h1>
            <?php
                require_once('../db.php');
                // Getting the most recent logging attempt of the current user
                $sql = "SELECT * FROM User WHERE Email = '{$_SESSION['username']}'";
                $result = $conn -> query($sql);

                // Getting the current user id
                $row = $result->fetch_assoc();
                $userId = $row['User_ID'];


                $sql = "SELECT * FROM Login_Attempt WHERE User_ID = {$userId} ORDER BY Timestamp DESC LIMIT 1";
                $result = $conn -> query($sql);

                $row = $result->fetch_assoc();
                $latestTime = date_create($row['Timestamp']);

                $dateInText = date_format($latestTime, 'dS F Y');

                echo "<h5>Last accessed $dateInText</h5>";
            ?>
        </div>
        <div class="profile-details-container">
            <div class="profile-image-container">
                <div class="profile-image">
                    <?php
                    echo "
                            <img src='../assets/profile-image/$userId.jpg' alt='profile-image' />
                        ";
                    ?>
                    <div class="profile-change-container">
                        <button type="button" id="profile-change-button" class="primary-button" onclick="openChangeProfileModal()">
                            <i class="fa-solid fa-camera"></i> Change
                        </button>
                    </div>
                </div>
            </div>
            <div class="profile-details-panel">
                <div class="edit-item-container" id="edit-item-username">
                    <h1><?php echo $username ?></h1>
                    <button type="button" class="update-button" id="button-edit-item-username" onclick="openEditModal('edit-modal-username')"><i class="fa-solid fa-pen-clip"></i></button>
                </div>
                <div class="edit-item-container" id="edit-item-contactnum">
                    <div class="edit-item-header">
                        Phone -
                    </div>
                    <div class="edit-item-value">
                        <?php echo $contactNum ?>
                    </div>
                    <button type="button" class="update-button" id="button-edit-item-contactnum" onclick="openEditModal('edit-modal-contactnum')"><i class="fa-solid fa-pen-clip"></i></button>
                </div>
                <div class="edit-item-container" id="edit-item-email">
                    <div class="edit-item-header">
                        Email -
                    </div>
                    <div class="edit-item-value">
                        <?php echo $email ?>
                    </div>
                    <button type="button" class="update-button" id="button-edit-item-email" onclick="openEditModal('edit-modal-email')"><i class="fa-solid fa-pen-clip"></i></button>
                </div>
                <div class="edit-item-container" id="edit-item-address">
                    <div class="edit-item-header">
                        Residence -
                    </div>
                    <div class="edit-item-value">
                        <?php echo $address ?>
                    </div>
                    <button type="button" class="update-button" id="button-edit-item-address" onclick="openEditModal('edit-modal-address')"><i class="fa-solid fa-pen-clip"></i></button>
                </div>
                <div class="edit-item-container" id="edit-item-dob">
                    <div class="edit-item-header">
                        Date of Birth -
                    </div>
                    <div class="edit-item-value">
                        <?php echo $dob ?>
                    </div>
                    <button type="button" class="update-button" id="button-edit-item-dob" onclick="openEditModal('edit-modal-dob')"><i class="fa-solid fa-pen-clip"></i></button>
                </div>
                <div class="edit-item-container" id="edit-item-nic">
                    <div class="edit-item-header">
                        NIC number -
                    </div>
                    <div class="edit-item-value">
                        <?php echo $nic ?>
                    </div>
                    <button type="button" class="update-button" id="button-edit-item-nic" onclick="openEditModal('edit-modal-nic')"><i class="fa-solid fa-pen-clip"></i></button>
                </div>
            </div>
        </div>
        <div class="quick-action-container">
            <div class="quick-action-banner">
                <h1>Quick actions</h1>
            </div>
            <div class="quick-action-list">
                <div class="quick-action-item">
                    <h3>Secure your account with a new password!</h3>
                    <div class="quick-action-item-button-container">
                        <button type="button" class="primary-button" onclick="showChangePasswordModal()"><i class="fa-solid fa-unlock-keyhole"></i>&nbsp;&nbsp;Change password</button>
                    </div>
                </div>
                <div class="quick-action-item">
                    <h3>Add for new worker category!</h3>
                    <div class="quick-action-item-button-container">
                        <button type="button" class="primary-button" onclick="showAddCategoryContainer()"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Add category</button>
                    </div>
                </div>
                <div class="quick-action-item">
                    <h3>Activate/Deactivate from worker category</h3>
                    <div class="quick-action-item-button-container">
                        <button type="button" class="primary-button" onclick="showActiveDeactivateContainer()"><i class="fa-solid fa-shuffle"></i>&nbsp;&nbsp;Activate/Deactivate</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<?php
    echo "<script>
        let userId = $userId;
    </script>"
?>
<?php
    if(isset($_POST['save-button'])) {
        // Define the directory where the uploaded images will be stored
        $target_dir = "../assets/profile-image/";
        $userid=$_SESSION['user_id'];
        // Get the filename of the uploaded image
        //change file name to what we want
        $target_file = $target_dir . $userid. ".jpg";

        // Check if the uploaded file is an image
        $check = getimagesize($_FILES["picture-upload-input"]["tmp_name"]);
        if($check !== false) {
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "<script>failedProfileUpdate('Sorry, only JPG, JPEG, PNG & GIF files are allowed')</script>";
                // exit();
            } else {

                // Move the uploaded image to the target directory
                if (move_uploaded_file($_FILES["picture-upload-input"]["tmp_name"], $target_file)) {
                    echo "<script>successProfileUpdate()</script>";
                    header("refresh:1");
                } else {
                    echo "<script>failedProfileUpdate('Sorry, there was an error uploading your file')";
                }
            }
        } else {
            echo "<script>failedProfileUpdate('Sorry, only image files are allowed')</script>";
        }
    }
?>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/worker/profile.js" type="text/javascript"></script>
</body>