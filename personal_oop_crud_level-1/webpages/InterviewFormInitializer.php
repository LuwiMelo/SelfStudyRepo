<?php


 // server should keep session data for AT LEAST 1 hour
 ini_set('session.gc_maxlifetime', 7200);

 // each client should remember their session id for EXACTLY 1 hour
 session_set_cookie_params(7200);


session_start();

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


$_SESSION['InterviewFormStudentID'] = $_POST['id'];
$_SESSION['InterviewFormAdmissionID'] = $_POST['admissionid'];


//echo $_SESSION['EditProfileStudentID'];
header('Location: EnrollmentPhase2InterviewForm.php');




?>