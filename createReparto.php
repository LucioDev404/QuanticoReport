<?php
require('./backend/config.php');
include('./backend/auth.php');
if ($_SESSION['permesso'] != "a") {
    header("Location: ./logout.php");
}
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
            <a class="navbar-brand" href="./dashboard-administrator.php">
                <img src="./img/logo_big.svg" alt="logo quantico" width="146" height="26">
            </a>
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
                            <a class="nav-link active" aria-current="page" href="./viewAllReport.php">
                                <img src="./img/report.png" alt="" width="35">
                                Visualizza Report
                            </a>
                        </li>
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
                                    <a class="dropdown-item" href="./createNewUser.php">
                                        <img src="./img/user.png" alt="" width="25">
                                        Crea Nuovo Utente
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="./deleteUser.php">
                                        <img src="./img/user.png" alt="" width="25">
                                        Elimina Utente
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
            <h1 class="text-center text-dark">Crea Nuovo Reparto</h1>

            <?php
                session_start();
                if(isset($_POST['reparto']) && isset($_POST['email'])){
                    $reparto = $_POST['reparto'];
                    $email = $_POST['email'];

                    $sql = "INSERT INTO `Reparto`(`nome_reparto`, `email_support`) VALUES ('".$reparto."','".$email."')";

                    if ($con->query($sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Nuovo Reparto creato correttamente!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Attenzione!</strong> Errore durante la creazione del nuovo reparto, riprovare!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    $_POST = "";
                    $con->close();
                }
            ?>

            <form action="./createReparto.php" method="post">
                <div class="mb-3">
                    <label for="nome_repartro" class="form-label text-dark">Nome Reparto:</label>
                    <input type="nome_repartro" class="form-control" id="nome_repartro" name="reparto" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label text-dark">Email Responsabile:</label>
                    <input type="emial" class="form-control" id="email" name="email" required>
                </div>
                <input type="submit" class="btn btn-primary btn-all" value="Crea Nuovo Reparto">
            </form>
        </div>
    </div>
    <!-- fine form -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

</body>

</html>