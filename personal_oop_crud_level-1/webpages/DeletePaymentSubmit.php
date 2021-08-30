<?php
session_start();

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



$DateToday = date('Y-m-d H:i:s');


$Retrieve = json_decode($_POST["RetrieveTransaction"]);





//Get the latest school year
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT SchoolYearID,SchoolYear FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYearID =  $row['SchoolYearID'];
          $LatestSchoolYear = $row['SchoolYear'];
    } 
    else {
   
       $LatestSchoolYearID = 3;
       $LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//Get the admission ID
$RetrievePaymentAdmissionID = "";

try
{
    $statement = $dbh->prepare("SELECT PaymentAdmissionID FROM tblpaymenttransactions WHERE PaymentID = $Retrieve->PaymentID ");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row) ) {
          
          $RetrievePaymentAdmissionID = $row['PaymentAdmissionID'];
          
    } 
    else {
   
     
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//Delete Payment
try
{
    
    $statement = $dbh->prepare("DELETE FROM tblpaymenttransactions WHERE PaymentID = :PaymentID");
    
    
    if( $statement->execute(array( ':PaymentID' => $Retrieve->PaymentID ))  )
    {
        
        
    }
    else{
       echo "error in payment";
       header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
     
     header("HTTP/1.0 403 Forbidden");
} 


//$LastPaymentID = $dbh->lastInsertId();






//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblpaymenttransactions", ':TableID' => $Retrieve->PaymentID, ':TableAction' => "DELETE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "DELETED PAYMENT" ))  )
    {
        
        //$LastAuditID = $LastAuditID + 1;
    }
    else{
     
       echo "error pa din sa audit trail nagsabay sabay na naman yan";
       header("HTTP/1.0 403 Forbidden");
        
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
     
     header("HTTP/1.0 403 Forbidden");
    
    
     
} 
   


$hasNoOtherPayment = false;

try
{
    $statement = $dbh->prepare("SELECT * FROM tblpaymenttransactions WHERE PaymentAdmissionID = $RetrievePaymentAdmissionID    ");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row) ) {
          
          //$StudentsAssessmentThisSchoolYear = $row['Total'];
          
    } 
    else {
   
        $hasNoOtherPayment = true;
        
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




if($hasNoOtherPayment){
    
    
//Update reference number  of new enrollee 
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET AdmissionReferenceNum = :AdmissionReferenceNum, AdmissionStatus = :AdmissionStatus, AdmissionUpdate = :AdmissionUpdate WHERE AdmissionID = :AdmissionID");
    
    
    if( $statement->execute(array(':AdmissionReferenceNum' => null,':AdmissionStatus' => 1, ':AdmissionUpdate' => null, ':AdmissionID' => $RetrievePaymentAdmissionID ))  )
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
    
    
}




//$_SESSION['GenerateSOAAdmissionID'] = $_SESSION['UpdatePaymentAdmissionID'];





?>
