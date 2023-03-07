<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            align-items: center;
        }
    </style>
</head>
<body>
    <h1 class="my-5">Hei, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>.</h1>
    <label>Online users</label>
    <ul id="onlineUsers">
        <li><?php echo htmlspecialchars($_SESSION['username']) ?></li>
    </ul>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset passord.</a>
        <a href="logout.php" class="btn btn-warning">Log ut av brukeren.</a>
    </p>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="assetts/dashboard.js"></script>
</body>
</html>