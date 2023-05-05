<?php
    $baseUrl = 'http://localhost/labour_link/';
?>
<div class="register-select-modal" id="register-modal">
</div>
<div class="register-select-content" id="register-modal-content">
    <div class="register-select-heading">
        <img src="<?php echo $baseUrl. "/assets/svg/user-check-solid.svg"?>" alt="house icon" class="register-select-icon" />
        <h1>Select registration type</h1>
    </div>
    <div class="reg-type-container">
        <div class="reg-type-card">
            <img src="<?php echo $baseUrl . "/assets/home-page/job-type/labour-type.svg"?>" alt="worker" class="reg-type-image" />
            <button type="button" onclick="window.location.href='<?php echo $baseUrl. 'worker-registration.php'?>'" class="card-button">Worker</button>
        </div>
        <div class="reg-type-card">
            <img src="<?php echo $baseUrl . "/assets/home-page/job-type/customer-type.svg"?>" alt="customer" class="reg-type-image" />
            <button type="button" onclick="window.location.href='<?php echo $baseUrl. 'customer-registration.php'?>'" class="card-button">Customer</button>
        </div>
    </div>
</div>

<div class="search-backdrop" id="search-backdrop"></div>
<nav class="nav-bar">
    <div class="search-component-container" id="search-component-container">
        <div class="search-main-container">
            <i class="fa-solid fa-magnifying-glass search-main-icon"></i>
            <input type="text" class="search-main-input" id="search-main-input" name="search-main-input" oninput="mainSearch()"/>
            
        </div>
        <div class="search-items">
           <span id="searchResult">
           </span>
            
        </div>
    </div>
    <div class="nav-bar-items">
        <div class="logo-container">
            <img src="<?php echo $baseUrl. "/assets/logo-croped.png"?>" alt="labourlink logo" class="labour-link-logo"/>
        </div>
        <div class="search-container">
            <div class="search-icon-container">
                <img src="<?php echo $baseUrl . "/assets/svg/search.svg"?>" alt="search" class="search-icon"/>
            </div>
            <input type="text" class="search-bar-input" id="search-bar-input" placeholder="Search for a labourer or a service"/>
        </div>
        <div class="nav-link-container">
            <div class="nav-link-items"><a href="<?php echo $baseUrl . "index.php"?>" class="nav-links">Home</a></div>
            <div class="nav-link-items"><a href="<?php echo $baseUrl . "about-us.php"?>" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="<?php echo $baseUrl . "contact-us.php"?>" class="nav-links">Contact Us</a></div>
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
                    <button type="button" class="nav-link-items-button" onclick="window.location.href='<?php echo $baseUrl . 'login.php'?>'">
                        LOGIN
                    </button>
                </div>
            <?php }else{ ?>
                <div class="nav-link-items">
                    <div class="dropdown" id="dropdown">
                        <button type="button" id="user-dropdown-button" onClick="opendropdown()"
                                class="nav-link-items-button"
                                style="background-color: #FFF; color: #102699;">
                            <i class="fa-regular fa-circle-user"></i>&nbsp;
                            <?php echo "Hi, ".$_SESSION['first_name']; ?>
                            &nbsp;
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-items" id="dropdown-items">
                            <?php
                                if($_SESSION['user_type'] == 'Admin'){
                                    $url = $baseUrl . './admin/dashboard.php';
                                    echo "<a href='$url'>";
                                }else if($_SESSION['user_type'] == 'Customer'){
                                    $url = $baseUrl . './customer/dashboard.php';
                                    echo "<a href='$url'>";
                                }else{
                                    $url = $baseUrl . './worker/dashboard.php';
                                    echo "<a href='$url'>";
                                }
                            ?>
                                <div class="dropdown-item" id="dropdown-item"><i class="fa-solid fa-gauge-high"></i>&nbsp;&nbsp;Dashboard
                                </div>
                            </a>
                            <a href="#">
                                <a href="<?php echo $baseUrl . "logout.php"?>">
                                <div class="dropdown-item" id="dropdown-item">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    &nbsp;&nbsp;Logout
                                </div>
                                </a>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>

<script>
    function mainSearch(){
        var searchInput = document.getElementById("search-main-input").value;
        if(searchInput.length == 0){
            document.getElementById("searchResult").innerHTML = "";
        }else if(searchInput.length >= 4){
            //ajax call to navbarSearch.php to get results
            
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log(this.responseText);
                    document.getElementById("searchResult").innerHTML = this.responseText;
                }
            }
            xhttp.open("POST", "/labour_link/components/navbarSearch.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("searchInput="+searchInput);

        }else{
            document.getElementById("searchResult").innerHTML = "No Results";
        }
       
           
        
    }
</script>