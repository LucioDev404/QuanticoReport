<?php
require('./backend/config.php');
include('./backend/auth.php');

$username = $_SESSION["username"];
$permesso = $_SESSION["permesso"];
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
    <!-- inizio navbar -->
    <nav class="navbar bg-light border-bottom border-body" data-bs-theme="light">
        <div class="container">
            <?php
            if ($permesso == "r") {
                echo '
                    <a class="navbar-brand" href="./dashboard.php">
                        <img src="./img/logo_big.svg" alt="logo quantico" width="146" height="26">
                    </a>
                    ';
            } else if ($permesso == "w") {
                echo '
                    <a class="navbar-brand" href="./dashboard-w.php">
                        <img src="./img/logo_big.svg" alt="logo quantico" width="146" height="26">
                    </a>
                    ';
            } else if ($permesso == "a") {
                echo '
                    <a class="navbar-brand" href="./dashboard-administrator.php">
                        <img src="./img/logo_big.svg" alt="logo quantico" width="146" height="26">
                    </a>
                    ';
            }
            ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <img src="./img/logo_big.svg" alt="logo quantico" width="146" height="26">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <?php
                            if ($permesso == "r") {
                                echo '
                                <a class="nav-link active" aria-current="page" href="./dashboard.php">
                                    <img src="./img/report.png" alt="" width="35">
                                    Invia Segnalazione
                                </a>
                            ';
                            } else if ($permesso == "w") {
                                echo '
                                <a class="nav-link active" aria-current="page" href="./dashboard-w.php">
                                    <img src="./img/report.png" alt="" width="35">
                                    Visualizza Report
                                </a>
                            ';
                            } else if ($permesso == "a") {
                                echo '
                                <a class="nav-link active" aria-current="page" href="./dashboard-administrator.php">
                                    <img src="./img/report.png" alt="" width="35">
                                    Invia Segnalazione
                                </a>
                    ';
                            }
                            ?>

                        </li>
                        <?php
                        if ($_SESSION['permesso'] == "a") {
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./createReparto.php">
                                        <img src="./img/report.png" alt="" width="35">
                                        Crea Reparto
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./gestioneReparto.php">
                                        <img src="./img/report.png" alt="" width="35">
                                        Gestione Reparto
                                    </a>
                                </li>
                                ';
                        }
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="./img/user.png" alt="" width="35">
                                Area Utente
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="./changepwd.php">
                                        <img src="./img/key.png" alt="" width="25">
                                        Cambia Password
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./logout.php">
                                        <img src="./img/logout.png" alt="" width="25">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- fine navbar -->
    <!-- inizio form -->
    <div class="container mt-5">
        <div class="box mb-5">
            <?php
            session_start();
            $id = $_SESSION["id"];/* userid of the user */
            if (count($_POST) > 0) {
                $result = mysqli_query($con, "SELECT * from Users WHERE id='" . $id . "'");
                $row = mysqli_fetch_array($result);
                if (md5($_POST["currentPassword"]) == $row["password"] && $_POST["newPassword"] == $_POST["confirmPassword"]) {
                    mysqli_query($con, "UPDATE Users set password='" . md5($_POST["newPassword"]) . "' WHERE id='" . $id . "'");
                    $message = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>La Password è stata cambiata!</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                } else {
                    $message = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Errore nel cambio della password, riprova.</strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>';
                }
                echo $message;
            }

            ?>
            <h1 class="text-center text-dark">Modifica Password</h1>
            <form action="./changepwd.php" method="post">
                <div class="mb-3">
                    <label for="currentPassword" class="form-label text-dark">Old Password:</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label text-dark">New Password:</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label text-dark">Repeate Password:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                </div>
                <input type="submit" class="btn btn-primary btn-all" value="Modifica">
            </form>
        </div>
    </div>
    <!-- fine form -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

</body>

</html>