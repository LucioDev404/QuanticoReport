<?php
require('./backend/config.php');
require('./backend/auth.php');
if ($_SESSION['permesso'] != "w" && $_SESSION['permesso'] != "a") {
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
            <?php
            if ($_SESSION['permesso'] == "w") {
                echo '
                    <a class="navbar-brand" href="./dashboard-w.php">
                        <img src="./img/logo_big.svg" alt="logo quantico" width="146" height="26">
                    </a>
                    ';
            } else if ($_SESSION['permesso'] == "a") {
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
                        <?php
                        if ($_SESSION['permesso'] == "a") {
                            echo '
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
                                ';
                        } else if ($_SESSION['permesso'] == "w") {
                            echo '
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="./dashboard-w.php">
                                        <img src="./img/report.png" alt="" width="35">
                                        Visualizza Report
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
    <div class="container mt-5">
        <div class="box mb-5">
            <h1 class="text-center text-dark">Crea Nuovo Utente:</h1>
            <?
            // When form submitted, check and create user session.
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirmPwd']) && isset($_POST['permesso']) && isset($_POST['reparto'])) {
                $username = stripslashes($_REQUEST['username']);    // removes backslashes
                $username = mysqli_real_escape_string($con, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);
                $confirmPwd = stripslashes($_REQUEST['confirmPwd']);
                $confirmPwd = mysqli_real_escape_string($con, $confirmPwd);
                $permesso = stripslashes($_REQUEST['permesso']);
                $permesso = mysqli_real_escape_string($con, $permesso);
                $reparto = stripslashes($_REQUEST['reparto']);
                $reparto = mysqli_real_escape_string($con, $reparto);

                if ($password === $confirmPwd) {
                    // Check user is exist in the database
                    $sql = "INSERT INTO `Users`(`username`, `password`, `permesso`, `reparto`) 
                            VALUES ('" . $username . "','" . md5($password) . "','" . $permesso . "','" . $reparto . "')";

                    if ($con->query($sql) === TRUE) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            Nuovo Utente creato correttamente!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Attenzione!</strong> Errore durante la creazione del nuovo utente, riprovare!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Attenzione!</strong> Le Password non corrispondono!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            }
            ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-dark">Username:</label>
                    <input type="username" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label text-dark">Password:</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="confirmPwd" class="form-label text-dark">Password:</label>
                    <input type="password" class="form-control" id="confirmPwd" name="confirmPwd" required>
                </div>
                <div class="mb-3">
                    <label for="inputGroupSelect01" class="form-label text-dark">Permesso:</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect01" name="permesso" required>
                            <option>r</option>
                            <?
                            if ($_SESSION['permesso'] == "a") {
                                echo '<option>w</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputGroupSelect01" class="form-label text-dark">Reparto:</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect01" name="reparto" required>
                            <?php
                            if ($_SESSION['permesso'] == "w") {
                                echo "<option>$_SESSION[reparto]</option>";
                            } else if ($_SESSION['permesso'] == "a") {
                                $query    = "SELECT `nome_reparto` FROM `Reparto` WHERE 1";

                                $result = mysqli_query($con, $query) or die();

                                if ($result->num_rows > 0) {
                                    // output data of each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "
                                            <option>$row[nome_reparto]</option>
                                        ";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-all" value="Crea Nuovo Utente">
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>