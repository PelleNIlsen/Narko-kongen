<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

require_once "config.php";

$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['new_password']))) {
        $new_password_err = "Skriv inn ett nytt passord.";
    } elseif (strlen(trim($_POST['new_password'])) < 6) {
        $new_password_err = "Passordet må ha 6 eller mer tegn.";
    } else {
        $new_password = trim($_POST['new_password']);
    }

    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = "Konfirmer passord.";
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Passordene er ikke like.";
        }
    }

    if (empty($new_password_err) && empty($confirm_password_err)) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION['id'];
            if (mysqli_stmt_execute($stmt)) {
                session_destroy();
                header("location: login.php");
                exit();
            } else {
                echo "Oops! Noe gikk galt. Prøv igjen senere.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
        }
        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Passord</h2>
        <p>Fyll inn dine detaljer nedenfor.</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="new_password">Nytt passord</label>
                <input
                    type="password"
                    name="new_password"
                    class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $new_password; ?>"
                >
                <span class="invalid-feedback"><?php echo $new_password_err ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmer passord</label>
                <input
                    type="password"
                    name="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                >
                <span class="invalid-feedback"><?php echo $confirm_password_err ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Endre passord" class="btn btn-primary">
            </div>
            <a class="btn btn-link ml-2" href="dashboard.php">Avbryt</a>
        </form>
    </div>
</body>
</html>