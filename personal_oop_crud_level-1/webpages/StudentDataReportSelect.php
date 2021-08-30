<?php

//Code For User Authentication For Each Web Page
session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}



$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


switch($_POST['ReportType']){
        
    case "1":
        header('Location: StudentDataReportByGradeLevel.php');
        break;
     case "2":
        header('Location: StudentDataReportByStrand.php');
        break;
     case "3":
        header('Location: StudentDataReportByDiscount.php');
        break;
     case "4":
        header('Location: StudentDataReportByModeOfPayment.php');
        break;
     case "5":
        header('Location: StudentDataReportByEnrollmentStatus.php');
        break;
     case "6":
        header('Location: StudentDataReportByESCQVRGrantee.php');
        break;
     case "7":
       
        header('Location: StudentDataReportByQVRGrantee.php');
        break;
     case "8":
        header('Location: StudentDataReportByReferenceNumber.php');
        break;
     case "9":
        header('Location: StudentDataReportByStudentNumber.php');
        break;
}



?>