<?php
    session_start();
    // Check whether labourer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Worker') {
        header("Location: ../login.php");
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
    <link href="../styles/worker-dashboard.css" rel="stylesheet"/>
    <link href="../styles/worker/worker-housing.css" rel="stylesheet"/>
    <title>Labourer Dashboard | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
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
        <h1>Welcome Back
                <u>
                    <?php
                        echo $_SESSION['first_name'] . " " . $_SESSION['last_name']
                    ?>
                </u>
            </h1>
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
        <div class="new-housing-job-title">
            <h1>Need to find new housing job?</h1>
            <button class="more-button">Find More</button>
        </div>
        <div class="recent-housing">
            <div class="recent-housing-title">
                <h1>Recent Housing Jobs</h1>
            </div>
            <div class="recent-housing-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Adress / Start Date</th>
                        <th class="main-th">Customer name</th>
                        <th class="main-th">Service</th>
                        <th class="main-th">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohomad</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohomad</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohomad</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohomad</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="search-housing">
            <div class="search-housing-title">
                <h1>Search for housing jobs</h1>
                <form action="" method="POST">
                    <div class="housing-search-input-container">
                        <label for="housing-search">Search (Using customer name etc)</label>
                        <div class="housing-search-input-field">
                            <input type="text" id="housing-search" class="housing-search-input" name="users-search"/>
                            <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="search-housing-container">
                <table class="main-table">
                    <thead>
                        <tr class="main-tr">
                        <div class="recent-payments-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                    <th class="main-th">
                        <div class="table-heading-container">Adress / Status&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Customer&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Service&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Bambalapitiya Colombo
                        <br/>
                        <span class="completed-badge">completed</span>
                    </td>
                    <td class="main-td">Mohomad Izzath</td>
                    <td class="main-td">Electrical</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Bambalapitiya Colombo
                        <br/>
                        <span class="rejected-badge">Rejected</span>
                    </td>
                    <td class="main-td">Mohomad Izzath</td>
                    <td class="main-td">Electrical</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Bambalapitiya Colombo
                        <br/>
                        <span class="pending-badge">Pending</span>
                    </td>
                    <td class="main-td">Mohomad Izzath</td>
                    <td class="main-td">Electrical</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Bambalapitiya Colombo
                        <br/>
                        <span class="pending-badge">Pending</span>
                    </td>
                    <td class="main-td">Mohomad Izzath</td>
                    <td class="main-td">Electrical</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
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
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
</body>