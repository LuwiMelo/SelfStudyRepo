<?php

//Code For User Authentication For Each Web Page
session_start();
include 'DataBaseConnectionFile.php';


/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}


$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/


$_SESSION['VSReenrolleeStudentID'] = $_POST['id'];
$_SESSION['VSReenrolleeAdmissionID'] = $_POST['admissionid'];


//echo $_SESSION['EditProfileStudentID'];
header('Location: PrintStudentReEnrollees.php');




?>