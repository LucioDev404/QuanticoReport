<?php
require('./config.php');

//mail 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['reparto']) && isset($_POST['titolo']) && isset($_POST['descrizione'])) {

    //grab email from reparto
    $query    = "SELECT `email_support` FROM `Reparto` WHERE `nome_reparto` = '" . $_POST['reparto'] . "'";

    $result = mysqli_query($con, $query) or die();

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $reportEmail = $row['email_support'];
        }
    }

    //send email
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = ''; //inserite l'email dalla quale parte il messaggio
    $mail->Password = ''; //inserire la password che viene fornita
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom(''); //email dalla quale parte il messaggio

    $mail->addAddress($reportEmail);

    $mail->isHTML(true);

    $mail->Subject = $_POST['titolo'];
    $mail->Body = $_POST['descrizione'];

    $mail->send(); //invio dell'email

    //salvataggio dati nel database
    $reparto = $_POST['reparto'];
    $titolo = $_POST['titolo'];
    $descrizione = $_POST['descrizione'];

    $docs = [
        $_FILES["file1"],
        $_FILES["file2"]
    ];

    $files = [];

    foreach ($docs as $file) {
        if ($file["name"] != "" || $file["name"] != null) {
            $fileName = uniqid() . $file["name"];
            $files[] = trim($fileName);
            move_uploaded_file($file["tmp_name"], "../docs/" . basename($fileName));
        }
    }

    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $sql = "INSERT INTO `Report` (`reparto`, `titolo`, `descrizione`, `file1`, `file2`) VALUES ('" . $reparto . "','" . $titolo . "','" . $descrizione . "',' " . $files[0] . "',' " . $files[1] . "')";
    if ($connection->query($sql) === TRUE) {
        header("location: ../dashboard.php?i=i");
    } else {
        header("location: ../dashboard.php?i=e");
    }
    $connection->close();
}
