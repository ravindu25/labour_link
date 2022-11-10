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
<div class="register-select-modal" id="register-modal">
</div>
<div class="register-select-content" id="register-modal-content">
    <div class="register-select-heading">
        <img src="../assets/svg/user-check-solid.svg" alt="house icon" class="register-select-icon"/>
        <h1>Select registration type</h1>
    </div>
    <div class="reg-type-container">
        <div class="reg-type-card">
            <img src="../assets/home-page/job-type/labour-type.svg" alt="worker" class="reg-type-image"/>
            <button type="button" onclick="window.location.href='../worker-registration.php'" class="card-button">
                Worker
            </button>
        </div>
        <div class="reg-type-card">
            <img src="../assets/home-page/job-type/customer-type.svg" alt="customer" class="reg-type-image"/>
            <button type="button" onclick="window.location.href='../customer-registration.php'" class="card-button">
                Customer
            </button>
        </div>
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
            session_start();
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
                            <?php echo $_SESSION['username']; ?>
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
                            <input type="text" id="login-search" class="login-search"  name="search"/>
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
                $search = $_POST['search'];
                if(!isset($search)){
                    $search = "";
                }
                if($search == ""){
                    $sql = "SELECT First_Name, Last_Name, date(Timestamp), time(Timestamp), Success_Flag FROM Login_Attempt INNER JOIN User ON Login_Attempt.User_ID=User.User_ID ORDER BY Timestamp DESC LIMIT 5;";
                }else{
                    $sql = "SELECT First_Name, Last_Name, date(Timestamp), time(Timestamp), Success_Flag FROM Login_Attempt INNER JOIN User ON Login_Attempt.User_ID=User.User_ID WHERE First_Name LIKE '%$search%' OR Last_Name LIKE '%$search%' ORDER BY Timestamp DESC LIMIT 5;;";
                }
                
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo('
                        <tr class="main-tr">
                            <td class="main-td" style="text-align: left;">' . $row['First_Name'] . ' ' . $row['Last_Name'] . '
                                
                                <br/>'.
                                //if login success
                                ($row['Success_Flag'] == 1 ? '<span class="success-badge">Success</span>' : '<span class="failed-badge">Failed</span>')
                            
                            .'</td>
                            <td class="main-td">'.$row['date(Timestamp)'].'</td>
                            <td class="main-td">'.$row['time(Timestamp)'].'</td>
                            <td class="main-td">
                                <div class="more-button-container">
                                    <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                    </button>
                                    <button class="suspend-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
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
        <div class="search-users">
            <div class="search-users-title">
                <h1>Search for users of the system</h1>
                <div class="search-users-container">
                    <label for="users-search" class="users-search-text">Search(Using username, role etc)</label>
                    <br/>
                    <div class="search-input-container">
                        <input type="text" id="users-search" class="users-search"/>
                        <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Dhanaga Deepanjana
                            <br/>
                            <span class="active-badge">Active</span>
                        </td>
                        <td class="main-td">21 Oct 2022</td>
                        <td class="main-td">Admin</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="suspend-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Rushdha Rasheed
                            <br/>
                            <span class="suspend-badge">Suspend</span>
                        </td>
                        <td class="main-td">17 Oct 2022</td>
                        <td class="main-td">Admin</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="activate-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Activate
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Mohamed Izzath
                            <br/>
                            <span class="active-badge">Active</span>
                        </td>
                        <td class="main-td">8 Oct 2022</td>
                        <td class="main-td">Admin</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="suspend-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Ravindu Wegiriya
                            <br/>
                            <span class="active-badge">Active</span>
                        </td>
                        <td class="main-td">8 Oct 2022</td>
                        <td class="main-td">Admin</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="suspend-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Saman Gunawardhana
                            <br/>
                            <span class="active-badge">Active</span>
                        </td>
                        <td class="main-td">22 Oct 2022</td>
                        <td class="main-td">Worker</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="suspend-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Avinash Sudira
                            <br/>
                            <span class="suspend-badge">Suspend</span>
                        </td>
                        <td class="main-td">17 Oct 2022</td>
                        <td class="main-td">Worker</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="activate-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Activate
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Saman Gunathilaka
                            <br/>
                            <span class="active-badge">Active</span>
                        </td>
                        <td class="main-td">21 Oct 2022</td>
                        <td class="main-td">Worker</td>
                        <td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                                <button class="suspend-button"><i class="fa-solid fa-user-xmark"></i>&nbsp;&nbsp;Suspend
                                </button>
                            </div>
                        </td>
                    </tr>
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
            <button class="more-button">Create Admin</button>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/index.js" type="text/javascript"></script>
</body>

