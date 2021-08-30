<?php

session_start();

/*
$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/

include 'DataBaseConnectionFile.php';

    
//Get the latest admission phase ID
$StudentID = $_POST['id'];
$AdmissionID = $_POST['admissionid'];

/*
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblstudentadmission WHERE AdmissionStudentID = $StudentID AND AdmissionSchoolYearID = (SELECT MAX(SchoolYearID) FROM tblschoolyear) ");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
         $AdmissionID = $row['AdmissionID'];
          
    } 
    else {
   
       //$LastAdmissionPhase2ID = 1;
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
*/


$_SESSION['GenerateSOAStudentIDPass'] = $StudentID;
$_SESSION['GenerateSOAAdmissionID'] = $AdmissionID;

//echo $_SESSION['GenerateSOAAdmissionID'];





header('location: BeforePrintStatementOfAccount.php');


?>