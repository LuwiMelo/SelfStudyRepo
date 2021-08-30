<?php
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

include 'DataBaseConnectionFile.php';

//$StudentID = $_SESSION['InitialPaymentStudentID'];
$AdmissionID = $_SESSION['GenerateSOAAdmissionID'];

$DateToday = date('Y-m-d H:i:s');


$Retrieve = json_decode($_POST["RetrieveTransaction"]);


//Get the latest school year
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT * FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYear =  $row['SchoolYear'];
          $LatestSchoolYearID = $row['SchoolYearID'];
    } 
    else {
   
       $LatestSchoolYear = "2020";
       $LatestSchoolYearID = 3;
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



if(isset($_SESSION['SessionSelectedSchoolYearID'])){
    
    $LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    $LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
}




//Update due date
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET  DueDate = :DueDate, AdmissionModeOfPaymentID = :AdmissionModeOfPaymentID WHERE AdmissionID = :AdmissionID");
    
    
    if( $statement->execute(array( ':DueDate' => $Retrieve->DueDateInsert, ':AdmissionModeOfPaymentID' => $Retrieve->ModeOfPayment, ':AdmissionID' => $AdmissionID ))  )
    {
        
        
    }
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
   // $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
    


$_SESSION['GenerateSOAAmountDueDisplay'] = $Retrieve->AmountDue;
$_SESSION['GenerateSOAAdmissionID'] = $AdmissionID;





?>
