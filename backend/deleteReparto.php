<?php
require('./config.php');

if(isset($_POST['id'])){
    $sql = "DELETE FROM `Reparto` WHERE `id` = '".$_POST['id']."'";
    if ($con->query($sql) === TRUE) {
        header("location: ../gestioneReparto.php?i=i");
    } else {
        header("location: ../gestioneReparto.php?i=e");
    }
    $con->close();
}