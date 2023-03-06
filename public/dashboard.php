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
    <h1 class="my-5">Whasgood <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to da hood</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset yo password cuz yo stoopid ass forgot it</a>
        <a href="logout.php" class="btn btn-warning">Sign out of yo fookin account</a>
    </p>
</body>
</html>