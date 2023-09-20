<?php
require('./backend/config.php');
include('./backend/auth.php');
if ($_SESSION['permesso'] != "r") {
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
            <a class="navbar-brand" href="./dashboard.php">
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
                            <a class="nav-link active" aria-current="page" href="./dashboard.php">
                                <img src="./img/report.png" alt="" width="35">
                                Invia Segnalazione
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
            <h1 class="text-center text-dark">Invia una Segnalazione</h1>
            <?php
            if (isset($_GET['i'])) {
                $codice = $_GET['i'];
                if ($codice == "i") {
                    echo '
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Report inviato con successo!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                } else if ($codice == "e") {
                    echo '
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errore, il report non è stato inviato correttamente, riprovare!</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        ';
                }
            }
            ?>
            <form action="./backend/report.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="inputGroupSelect01" class="form-label">Reparto da segnalare:</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="inputGroupSelect01" name="reparto" required>
                            <?php
                            $query    = "SELECT `nome_reparto` FROM `Reparto` WHERE 1";

                            $result = mysqli_query($con, $query) or die();

                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option>$row[nome_reparto]</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="titolo" class="form-label">Titolo della segnalazione:</label>
                    <input type="text" class="form-control" id="titolo" name="titolo" required>
                </div>
                <label for="descrizione" class="form-label">Descrizione della segnalazione:</label>
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="descrizione" required name="descrizione" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Descrizione</label>
                </div>
                <div class="mb-3">
                    <div class="mb-3">
                        <label for="formFile1" class="form-label">Foto e/o Documenti</label>
                        <div class="row">
                            <div class="col-md mb-3">
                                <input class="form-control" type="file" id="formFile1" name="file1">
                            </div>
                            <div class="col-md">
                                <input class="form-control" type="file" id="formFile2" name="file2">
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-all" value="INVIA">
            </form>
        </div>
    </div>
    <!-- fine form -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

</body>

</html>