<?php


define('DB_NAME', 'if0_34994549_streamluxe');

define('DB_USER', 'if0_34994549');

define('DB_PASSWORD', 'tSd76C1vHi');

define('DB_HOST', 'sql304.infinityfree.com');


session_start();
// Change this to your connection info.
$DATABASE_HOST = 'sql304.infinityfree.com';
$DATABASE_USER = 'if0_34994549';
$DATABASE_PASS = 'tSd76C1vHi';
$DATABASE_NAME = 'if0_34994549_streamluxe';

//connection to db
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
