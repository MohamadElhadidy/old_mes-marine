<?php
session_start();
$host = "localhost"; /* Host name */
$user = "user"; /* User */
$password = "password"; /* Password */
$dbname = "old_ems"; /* Database name */

$con = mysqli_connect($host, $user, $password,$dbname);
date_default_timezone_set("Africa/Maseru");

// Check connection
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

