<?php
require('./backend/config.php');
include('./backend/auth.php');
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
                        <li class="nav-item">
                            <?php
                            if ($_SESSION['permesso'] == "w") {
                                echo '
                                <a class="nav-link active" aria-current="page" href="./dashboard-w.php">
                                    <img src="./img/report.png" alt="" width="35">
                                    Viusualizza Report
                                </a>
                    ';
                            } else if ($_SESSION['permesso'] == "a") {
                                echo '
                                <a class="nav-link active" aria-current="page" href="./viewAllReport.php">
                                    <img src="./img/report.png" alt="" width="35">
                                    Visualizza Report
                                </a>
                    ';
                            }
                            ?>

                        </li>
                        <?php
                            if($_SESSION['permesso'] == "a"){
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
            <h1 class="text-center text-dark">Visualizza Report</h1>
            <?php
            if (isset($_GET['i'])) {
                $codice = $_GET['i'];
                if ($codice == "i") {
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Eliminazione avvenuta con successo!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                } else if ($codice == "e") {
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errore: </strong> Utente non eliminato correttamente!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                }
            }
            ?>
            <div class="container-report">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Username</th>
                            <th scope="col">Reparto</th>
                            <th scope="col">Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if ($_SESSION['permesso'] == "w") {
                            $query    = "SELECT * FROM `Users` WHERE `reparto` = '" . $_SESSION['reparto'] . "' and permesso != 'w' ORDER BY `id` DESC";

                            $result = mysqli_query($con, $query) or die();

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                            <tr>
                                <th scope='row'>$row[id]</th>
                                <td>$row[username]</td>
                                <td>$row[reparto]</td>
                                <td>
                                    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#elimina$row[id]'>
                                        Elimina
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal -->
                            <div class='modal fade' id='elimina$row[id]' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='eliminaModal$row[id]' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h1 class='modal-title fs-5' id='eliminaModal$row[id]'><strong>Attenzione!!</strong></h1>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            Sei sicuro di voler eliminare '$row[username]'?
                                        </div>
                                        <div class='modal-footer'>
                                            <form action='./backend/deleteUsr.php' method='post'>
                                                <input type='text' name='id' hidden value='$row[id]'>
                                                <input type='submit' value='ELIMINA' class='btn btn-danger'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                                }
                            }
                        }
                        else if ($_SESSION['permesso'] == "a") {
                            $query    = "SELECT * FROM `Users` WHERE permesso != 'a' ORDER BY `id` DESC";

                            $result = mysqli_query($con, $query) or die();

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "
                            <tr>
                                <th scope='row'>$row[id]</th>
                                <td>$row[username]</td>
                                <td>$row[reparto]</td>
                                <td>
                                    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#elimina$row[id]'>
                                        Elimina
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Modal -->
                            <div class='modal fade' id='elimina$row[id]' data-bs-backdrop='static' data-bs-keyboard='false' tabindex='-1' aria-labelledby='eliminaModal$row[id]' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h1 class='modal-title fs-5' id='eliminaModal$row[id]'><strong>Attenzione!!</strong></h1>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            Sei sicuro di voler eliminare '$row[username]'?
                                        </div>
                                        <div class='modal-footer'>
                                            <form action='./backend/deleteUsr.php' method='post'>
                                                <input type='text' name='id' hidden value='$row[id]'>
                                                <input type='submit' value='ELIMINA' class='btn btn-danger'>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- fine form -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

</body>

</html>