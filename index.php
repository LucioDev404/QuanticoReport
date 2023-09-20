<?php
require('./backend/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Utenti Quantico</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./img/icon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="hero">
        <div class="box">
        <img src="./img/logo_big.svg" alt="logo quantico" width="300" height="53" class="mb-3">
            <?
            session_start();
            // When form submitted, check and create user session.
            if (isset($_POST['username'])) {
                $username = stripslashes($_REQUEST['username']);    // removes backslashes
                $username = mysqli_real_escape_string($con, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);
                // Check user is exist in the database
                $query    = "SELECT * FROM `Users` WHERE username='$username'
                             AND password='" . md5($password) . "'";

                $result = mysqli_query($con, $query) or die();

                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $_SESSION['username'] = $username;
                        $_SESSION['permesso'] = $row['permesso'];
                        $_SESSION['reparto'] = $row['reparto'];
                        $_SESSION['id'] = $row['id'];

                        if ($row['permesso'] == "r") {
                            header("Location: dashboard.php");
                        } else if ($row['permesso'] == "w") {
                            header("Location: dashboard-w.php");
                        } else if ($row['permesso'] == "a") {
                            header("Location: dashboard-administrator.php");
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Attenzione!</strong> Username o Password errati!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            }
            ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-dark">Username:</label>
                    <input type="username" class="form-control" id="username" name="username">
                    <div id="emailHelp" class="form-text">Ogni report effettuato verrà eseguito in anonimo!</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label text-dark">Password:</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>
                <input type="submit" class="btn btn-primary btn-all" value="Login">
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>