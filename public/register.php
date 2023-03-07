<?php

require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty(trim($_POST['username']))) {
        $username_err = "Skriv inn et brukernavn.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST['username']))) {
        $username_err = "Brukernavnet kan bare inneholde bokstaver, tall og understrek.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST['username']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Dette brukernavnet er opptatt.";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Oops! Noe gikk galt. Prøv igjen senere.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if (empty(trim($_POST['password']))) {
        $password_err = "Skriv inn ett passord.";
    } elseif (strlen(trim($_POST['password'])) < 6) {
        $password_err = "Passordet krever 6 eller flere tegn.";
    } else {
        $password = trim($_POST['password']);
    }
    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = "Skriv inn passordet igjen.";
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Passordene er ikke like.";
        }
    }
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($stmt)) {
                header("location: login.php");
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
    <title>Login</title>
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
        <h2>Register</h2>
        <p>Fyll inn dine detaljer nedenfor.</p>

        <?php
            if(!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="username">Brukernavn</label>
                <input
                    type="text"
                    name="username"
                    class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $username; ?>"
                >
                <span class="invalid-feedback"><?php echo $username_err ?></span>
            </div>
            <div class="form-group">
                <label for="password">Passord</label>
                <input
                    type="password"
                    name="password"
                    class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $password; ?>"
                >
                <span class="invalid-feedback"><?php echo $password_err ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmer passord</label>
                <input
                    type="password"
                    name="confirm_password"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $confirm_password; ?>"
                >
                <span class="invalid-feedback"><?php echo $confirm_password_err ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Register" class="btn btn-primary">
                <input type="reset" value="Reset" class="btn btn-secondary">
            </div>
            <p>Har du allerede en bruker? <a href="login.php">Login her</a>.</p>
        </form>
    </div>
</body>
</html>