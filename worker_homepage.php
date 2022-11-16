<!-- check session, if not logged in and if user type not customer, redirect to login page -->
<?php
    session_start();
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Worker') {
        header("Location: login.php");
    }

?>

<html>
    Labourer Homepage
</html>