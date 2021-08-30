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

if(isset($_SESSION['SessionSelectedSchoolYearID'])){
    
    $LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    $LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
}





$_SESSION['FinancialCertificateStudentID'] = $_POST['id'];
$_SESSION['FinancialCertificateAdmissionID'] = $_POST['admissionid'];

//Get the latest admission record
try
{
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID AND AdmissionID = :AdmissionID  ");
    $statement->execute(array(':AdmissionStudentID' => $_SESSION['FinancialCertificateStudentID'], ':AdmissionID' => $_SESSION['FinancialCertificateAdmissionID']    ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              //$RetrieveAdmissionID = $data['AdmissionID'];
              //$_SESSION['FinancialCertificateAdmissionID'] =  $data['AdmissionID'];
     
              
        }
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//echo $_SESSION['EditProfileStudentID'];
header('Location: FinancialCertificateBeforePrint.php');




?>