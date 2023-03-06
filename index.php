<?php

if (isset($_SESSION['loggedin']) && $_SESSION['loggined'] === true) {
    header("location: public/dashboard.php");
    exit;
} else {
    header("location: public/login.php");
    exit;
}

?>