<?php
require('./config.php');

if(isset($_POST['id'])){
    $sql = "DELETE FROM `Users` WHERE `id` = '".$_POST['id']."'";
    if ($con->query($sql) === TRUE) {
        header("location: ../deleteUser.php?i=i");
    } else {
        header("location: ../deleteUser.php?i=e");
    }
    $con->close();
}