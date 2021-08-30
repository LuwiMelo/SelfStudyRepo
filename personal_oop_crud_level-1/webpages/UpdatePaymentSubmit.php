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

$PaymentID = $_SESSION['UpdatePaymentPaymentID'];
$AdmissionID = $_SESSION['UpdatePaymentAdmissionID'];

$DateToday = date('Y-m-d H:i:s');


$Retrieve = json_decode($_POST["RetrieveTransaction"]);





//Update Mode of Payment
try
{
    
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET AdmissionModeOfPaymentID = :AdmissionModeOfPaymentID WHERE AdmissionID = :AdmissionID");
    
    
    if( $statement->execute(array(':AdmissionModeOfPaymentID' => $Retrieve->ModeOfPayment, ':AdmissionID' => $AdmissionID ))  )
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


//Update Payment Data
try
{
    
    $statement = $dbh->prepare("UPDATE tblpaymenttransactions SET DateOfPayment = :DateOfPayment, ORNumber = :ORNumber, AmountPaid = :AmountPaid,ORPaymentRemarks = :ORPaymentRemarks WHERE PaymentID = :PaymentID");
    
    
    if( $statement->execute(array(':DateOfPayment' => $Retrieve->DateOfPaymentInsert, ':ORNumber' => $Retrieve->ORNumber, ':AmountPaid' => $Retrieve->AmountPaid,':ORPaymentRemarks' => $Retrieve->ORPaymentRemarks, ':PaymentID' => $PaymentID ))  )
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


$LastPaymentID = $dbh->lastInsertId();






//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblpaymenttransactions", ':TableID' => $PaymentID, ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "UPDATED PAYMENT DETAILS" ))  )
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
   




$_SESSION['GenerateSOAAdmissionID'] = $_SESSION['UpdatePaymentAdmissionID'];





?>
