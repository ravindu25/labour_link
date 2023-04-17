<?php
    session_start();
    // Check whether customer is logged in
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
    <link href="../styles/worker/worker-feedbacks.css" rel="stylesheet"/>
    <title>Feedbacks | LabourLink</title>
</head>
<body>
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
                <div class="sidebar-item sidebar-item-selected">
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
            <h1>All About Your <u>Feedbacks</u> In One Place!</h1>
            <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
        </div>
        <!-- Recent feedbacks section -->
        <div class="recent-feedback">
            <h1>Recent Feedbacks</h1>
        </div>
        <div class="recent-feedback-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                <th class="main-th">
                        <div class="table-heading-container">Comment&nbsp;
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Customer name&nbsp;
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Commented Date&nbsp;
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Service&nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Extremely satisfied with the work done.
                        <br/>
                        <span class="blue-badge">Updated 15 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunawardhana</td>
                    <td class="main-td">21 Oct 2022</td>
                    <td class="main-td">Plumbing</td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Process was neatly done on time
                        <br/>
                        <span class="blue-badge">Updated 20 days ago</span>
                    </td>
                    <td class="main-td">Kapila Gunawardhana</td>
                    <td class="main-td">16 Oct 2022</td>
                    <td class="main-td">Gardening</td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Work not completed on time.Slightly dissappointing.
                        <br/>
                        <span class="blue-badge">Updated 27 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunathilaka</td>
                    <td class="main-td">09 Oct 2022</td>
                    <td class="main-td">Electrical</td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Payment not going through
                        <br/>
                        <span class="blue-badge">Updated a month ago</span>
                    </td>
                    <td class="main-td">Kapila Dharmadasa</td>
                    <td class="main-td">05 Oct 2022</td>
                    <td class="main-td">Mason</td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>

        <!--Feedbacks search container-->
        <div class="feedback-search">
            <div class="feedback-search-title">
                <h1>Search for Feedbacks</h1>
                <form action="" method="POST">
                    <div class="feedback-search-input-container">
                        <label for="feedback-search">Search (Customer name etc)</label>
                        <div class="feedback-search-input-field">
                            <input type="text" id="feedback-search" class="feedback-search-input" name="users-search"/>
                            <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="recent-payments-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                    <th class="main-th">
                        <div class="table-heading-container">Comment&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Customer Name&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Commented Date&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Extremely satisfied with the work done.
                        <br/>
                        <span class="blue-badge">Updated 15 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunawardhana</td>
                    <td class="main-td">21 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="delete-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Process was neatly done on time.
                        <br/>
                        <span class="blue-badge">Updated 20 days ago</span>
                    </td>
                    <td class="main-td">Kapila Gunawardana</td>
                    <td class="main-td">16 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="delete-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Work not completed on time.Slighlty dissappointing.
                        <br/>
                        <span class="blue-badge">Updated 27 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunathilaka</td>
                    <td class="main-td">09 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="disable-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="disable-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Payment not going through.
                        <br/>
                        <span class="blue-badge">Updated 1 month ago</span>
                    </td>
                    <td class="main-td">Kapila Dharmadhasa</td>
                    <td class="main-td">05 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="disable-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="disable-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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