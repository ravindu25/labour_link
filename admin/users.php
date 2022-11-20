<?php
session_start();
//if not logged in redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
    // header("Location: admin-login.php");
}
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
    <link href="../styles/admin/users.css" rel="stylesheet"/>
    <title>Users | Admin Dashboard</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="backdrop-modal" id="admin-backdrop-modal">
</div>
<div class="reset-login-content" id="reset-login-content">
    <div class="reset-login-title">
        <h1>Do you want to reset selected login?</h1>
    </div>
    <div class="reset-login-buttons">
        <button type="button" onclick="closeResetModal()" class="reset-cancel-button">Cancel</button>
        <button type="button" onclick="resetLogin()" class="reset-confirm-button">Confirm</button>
    </div>
</div>
<div class="create-admin-form" id="create-admin-form">
    <div class="create-admin-wrapper">
        <div class="create-admin-title">
            <h1>Create new <u>Admin</u></h1>
        </div>
        <form id="admin-create-form" action="" method="POST">
            <div class="admin-form-container">
                <div class="admin-form-row">
                    <div class="admin-form-column">
                        <label for="first-name">First name</label>
                        <br/>
                        <input type="text" id="first-name" name="first-name"/>
                        <span class="input-error-text" id="input-first-name-error"></span>
                    </div>
                    <div class="admin-form-column">
                        <label for="last-name">Last name</label>
                        <br/>
                        <input type="text" id="last-name" name="last-name"/>
                        <span class="input-error-text" id="input-last-name-error"></span>
                    </div>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-column">
                        <label for="email">Email</label>
                        <br/>
                        <input type="text" id="email" name="email"/>
                        <span class="input-error-text" id="input-email-error"></span>
                    </div>
                    <div class="admin-form-column">
                        <label for="phone-number">Phone number</label>
                        <br/>
                        <input type="text" id="phone-number" name="phone-number"/>
                        <span class="input-error-text" id="input-phone-number-error"></span>
                    </div>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-column">
                        <label for="address">Address</label>
                        <br/>
                        <input type="text" id="address" name="address"/>
                        <span class="input-error-text" id="input-address-error"></span>
                    </div>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-column">
                        <label for="nic-number">NIC Number</label>
                        <br/>
                        <input type="text" id="nic-number" name="nic-number"/>
                        <span class="input-error-text" id="input-nic-number-error"></span>
                    </div>
                    <div class="admin-form-column">
                        <label for="phone-number">Date of birth(MM/DD/YYYY)</label>
                        <br/>
                        <input type="date" id="dob" name="dob"/>
                        <span class="input-error-text" id="input-dob-error"></span>
                    </div>
                </div>
                <div class="admin-form-row">
                    <div class="admin-form-column">
                        <label for="initial-password">Initial password</label>
                        <br/>
                        <input type="password" id="initial-password" name="initial-password"/>
                        <span class="input-error-text" id="input-initial-password-error"></span>
                    </div>
                    <div class="admin-form-column">
                        <label for="confirm-password">Confirm password</label>
                        <br/>
                        <input type="password" id="confirm-password" name="confirm-password"/>
                        <span class="input-error-text" id="input-confirm-password-error"></span>
                    </div>
                </div>
                <div class="form-message">
                    <h5>Note that: We will prompt to change password in initial login</h5>
                </div>
                <div class="button-container">
                    <button type="button" class="cancel-button" id="admin-create-cancel-button">Cancel</button>
                    <input type="submit" class="submit-button" id="admin-create-submit-button" name="admin-create-submit-button" value="Create Admin"/>
                </div>
            </div>

        </form>
    </div>
</div>
<nav class="nav-bar">
    <div class="nav-bar-items">
        <div class="logo-container">
            <img src="../assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
        </div>
        <div class="search-container">
            <div class="search-icon-container">
                <img src="../assets/svg/search.svg" alt="search" class="search-icon"/>
            </div>
            <input type="text" class="search-bar-input" placeholder="Search for a labourer or a service"/>
        </div>
        <div class="nav-link-container">
            <div class="nav-link-items"><a href="#" class="nav-links">Home</a></div>
            <div class="nav-link-items">
                <select name="jobs" class="nav-select">
                    <option value="jobs" selected>Jobs</option>
                    <option value="plumbing">Plumbing</option>
                    <option value="carpentry">Carpentry</option>
                    <option value="electrical">Electrical</option>
                    <option value="painting">Painting</option>
                    <option value="masonry">Masonry</option>
                    <option value="janitorial">Janitorial</option>
                    <option value="mechanical">Mechanical</option>
                    <option value="gardening">Gardening</option>
                </select>
            </div>
            <div class="nav-link-items"><a href="#" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="#" class="nav-links">Contact Us</a></div>
            <?php
            if (!isset($_SESSION['username'])) {

                ?>
                <div class="nav-link-items">
                    <button type="button" id="register-button" class="nav-link-items-button"
                            style="background-color: #FFF; color: #102699;">
                        REGISTER
                    </button>
                </div>
                <div class="nav-link-items">
                    <button type="button" class="nav-link-items-button" onclick="window.location.href='login.php'">
                        LOGIN
                    </button>
                </div>
            <?php } else { ?>
                <div class="nav-link-items">
                    <div class="dropdown" id="dropdown">
                        <button type="button" id="user-dropdown-button" onClick="opendropdown()"
                                class="nav-link-items-button"
                                style="background-color: #FFF; color: #102699;">
                            <i class="fa-regular fa-circle-user"></i>&nbsp;
                            Hi,&nbsp;<?php echo $_SESSION['first_name']; ?>
                            &nbsp;
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-items" id="dropdown-items">
                            <a href="#">
                                <div class="dropdown-item" id="dropdown-item"><i class="fa-solid fa-gauge-high"></i>&nbsp;&nbsp;Dashboard
                                </div>
                            </a>
                            <a href="#">
                                <div class="dropdown-item" id="dropdown-item">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    &nbsp;&nbsp;Logout
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
<span style="display:none" id="reset-user-id"></span>
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
                    <h4 class="sidebar-icon-heading">Booking</h4>
                </div>
            </a>
            <a href="./feedbacks.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-message sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Feedbacks</h4>
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
            <a href="./users.php">
                <div class="sidebar-item  sidebar-item-selected">
                    <i class="fa-solid fa-user-check sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Users</h4>
                </div>
            </a>
            <a href="./reports.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-newspaper sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Reports</h4>
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
            <h1>Control panel for managing <u>Users</u></h1>
            <h5>Logged as Ravindu Wegiriya</h5>
        </div>
        <div class="recent-logins">
            <div class="recent-logins-title">
                <h1>Recent login attemps</h1>
                <div class="login-search-container">
                    <label for="login-search" class="login-search-text">Search(Using username, date etc)</label>
                    <br/>
                    <form action="" method="POST">
                        <div class="search-input-container">
                            <input type="text" id="login-search" class="login-search" name="search"/>
                            <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="recent-logins-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                    <th class="main-th">
                        <div class="table-heading-date">Username/Status&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-date">Date&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-date">Time&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once '../db.php';
                if (!isset($_POST['search'])) {
                    $search = "";
                } else {
                    $search = $_POST['search'];
                }
                if ($search == "") {
                    $sql = "SELECT User.User_ID, First_Name, Last_Name, date(Timestamp), time(Timestamp), Success_Flag, Activation_Flag FROM Login_Attempt INNER JOIN User ON Login_Attempt.User_ID=User.User_ID ORDER BY Timestamp DESC LIMIT 5;";
                } else {
                    $sql = "SELECT User.User_ID, First_Name, Last_Name, date(Timestamp), time(Timestamp), Success_Flag, Activation_Flag FROM Login_Attempt INNER JOIN User ON Login_Attempt.User_ID=User.User_ID WHERE First_Name LIKE '%$search%' OR Last_Name LIKE '%$search%' ORDER BY Timestamp DESC LIMIT 5;;";
                }

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $user_id = $row['User_ID'];
                        echo('
                        <tr class="main-tr">
                            <td class="main-td" style="text-align: left;">' . $row['First_Name'] . ' ' . $row['Last_Name'] . '
                                
                                <br/>' .
                            //if login success
                            ($row['Success_Flag'] == 1 ? '<span class="success-badge">Success</span>' : '<span class="failed-badge">Failed</span>')

                            . '</td>
                            <td class="main-td">' . date("d M Y", strtotime($row['date(Timestamp)'])) . '</td>
                            <td class="main-td">' . $row['time(Timestamp)'] . '</td>
                            <td class="main-td">
                                <div class="more-button-container">
                                    <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                    </button>&nbsp;' .

                            ($row['Activation_Flag'] == 1 ? '<button class="suspend-button" onclick="suspend_user(' . $user_id . ')"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
                                    </button>' : '<button class="activate-button" onclick="activate_user(' . $user_id . ')"><i class="fa-solid fa-user-check"></i>&nbsp;&nbsp;Activate
                                    </button>') .
                            '</div>
                            </td>
                        </tr>');
                    }
                }
                ?>

                </tbody>
            </table>
            <div class="pagination-container">
                <button class="pagination-button"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button-current"><i class="fa-solid fa-2"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-3"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        </div>
        <div class="search-users">
            <div class="search-users-title">
                <h1>Search for users of the system</h1>
                <div class="search-users-container">
                    <label for="users-search" class="users-search-text">Search(Using username, role etc)</label>
                    <br/>
                    <form action="" method="POST">
                        <div class="search-input-container">
                            <input type="text" id="users-search" class="users-search" name="users-search"/>
                            <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="recent-payments-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                    <th class="main-th">
                        <div class="table-heading-date">Username/Status&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-date">Recent login&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-date">Role&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                require_once '../db.php';
                if (!isset($_POST['users-search'])) {
                    $search = "";
                } else {
                    $search = $_POST['users-search'];
                }
                if ($search == "") {
                    $sql = "SELECT * FROM User";
                } else {
                    $sql = "SELECT * FROM User WHERE First_Name LIKE '%$search%'";
                }

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $sql2 = "SELECT date(Timestamp) FROM Login_Attempt WHERE User_ID=" . $row['User_ID'] . " ORDER BY Timestamp DESC LIMIT 1;";
                        $result2 = $conn->query($sql2);
                        $row2 = $result2->fetch_assoc();
                        $last_login = $row2['date(Timestamp)'];
                        if ($last_login == "") {
                            $last_login = "Never";
                        } else {
                            //format date with month in words
                            $last_login = date("d M Y", strtotime($last_login));
                        }
                        $user_id = $row['User_ID'];
                        echo('<tr class="main-tr">
                                <td class="main-td" style="text-align: left;">
                                    ' . $row['First_Name'] . ' ' . $row['Last_Name'] . '
                                    <br/>'
                            . ($row['Activation_Flag'] == 1 ? '<span class="success-badge">Active</span>' : '<span class="suspend-badge">Suspended</span>') .
                            '</td>
                                <td class="main-td">' . $last_login . '</td>
                                <td class="main-td">' . $row['Type'] . '</td>
                                <td class="main-td">
                                    <div class="more-button-container">
                                        <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                        </button>
                                        <button class="reset-login-button" onclick="openResetModal(' . $user_id . ')"><i class="fa-solid fa-gear"></i>&nbsp;&nbsp;Reset login
                                        </button>
                                    </div>
                                </td>
                            </tr>');
                    }
                }

                ?>


                </tbody>
            </table>
            <div class="pagination-container">
                <button class="pagination-button"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button-current"><i class="fa-solid fa-2"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-3"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        </div>
        <div class="create-admin">
            <h1>Do you want to add new <u>Admin</u></h1>
            <button class="more-button" id="create-admin-button">Create Admin</button>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>

<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/admin/users.js" type="text/javascript"></script>
<script src="../scripts/admin/admin-create-validation.js" type="text/javascript"></script>
<!--<script src="../scripts/index.js" type="text/javascript"></script>-->

<script>
    function suspend_user(user_id) {

        // fetch('http://localhost/labour_link/admin/suspend-user.php', {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'www-form-urlencoded'
        //     },
        //     body: "user_id=" + user_id
        // }).then(response => response.text())
        //     .then(data => {
        //         console.log(data);
        //         if(data.status === 'Success'){
        //             alert('User suspended successfully');
        //             location.reload();
        //         }else{
        //             alert('Error occurred');
        //         }
        //     })
        //     .catch((error) => {
        //         console.error('Error:', error);
        //     });
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText === 'Success') {
                    // alert('User suspended successfully');
                    location.reload();
                } else {
                    // alert('Error occurred');
                    location.reload();
                }
            }
        }
        xmlhttp.open("POST", "http://localhost/labour_link/admin/suspend-user.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("user_id=" + user_id);

    }

    function activate_user(user_id) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;

                if (response == "Success") {
                    // alert('User activated successfully');
                    //print data type of response
                    location.reload();
                } else {
                    // alert('Error occurred');
                    location.reload();
                }
            }
        }
        xmlhttp.open("POST", "http://localhost/labour_link/admin/activate-user.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("user_id=" + user_id);

    }

    function resetLogin() {
        user_id = document.getElementById("reset-user-id").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var response = this.responseText;

                if (response == "Success") {
                    // alert('User activated successfully');
                    //print data type of response
                    location.reload();
                } else {
                    // alert('Error occurred');
                    location.reload();
                }
            }
        }
        xmlhttp.open("POST", "http://localhost/labour_link/admin/reset-login.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("user_id=" + user_id);

    }


</script>
</body>


</html>


<?php

    include_once '../db.php';
    if(isset($_POST['first-name'])){
        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $email = $_POST['email'];
        $password = $_POST['initial-password'];
        $phone_number= $_POST['phone-number'];
        $address = $_POST['address'];
        $nic= $_POST['nic-number'];
        $dob= $_POST['dob'];
       

        $sql1 = "INSERT INTO User (First_Name, Last_Name, Email, User_Address, Contact_No, NIC, Pswd, DOB, Type) VALUES ('$first_name', '$last_name', '$email', '$address', '$phone_number', '$nic', '$password', '$dob', 'Admin')";
        $result1 = mysqli_query($conn, $sql1);
    
        $sql2="SELECT User_ID FROM User WHERE Email='$email'";
        $result2 = mysqli_query($conn, $sql2);
        $row = mysqli_fetch_assoc($result2);
        $user_id = $row['User_ID'];
        
        $sql3 = "INSERT INTO System_Admin (Admin_ID) VALUES ('$user_id')";
        $result3 = mysqli_query($conn, $sql3);
    
        if($result1 && $result3){
            echo "Successfully Inserted";
        }else{
            echo "Error in Insertion";
            echo("Error description: " . mysqli_error($conn));
            echo("<script>console.log('PHP: " . mysqli_error($conn) . "');</script>");
            
        }
    }

?>