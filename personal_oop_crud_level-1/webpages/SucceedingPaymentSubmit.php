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

$StudentID = $_SESSION['InitialPaymentStudentID'];
$AdmissionID = $_SESSION['InitialPaymentAdmissionID'];

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






$isRefund = 0;

if($Retrieve->AmountPaid >= 0){
    
    unset($isRefund);
}
else{
    
}





//Insert New Payment data into database
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblpaymenttransactions (DateOfPayment,PaymentAdmissionID,ORNumber,AmountPaid,ORPaymentRemarks,PaymentSchoolYearID, isRefund) VALUES (:DateOfPayment,:PaymentAdmissionID,:ORNumber,:AmountPaid,:ORPaymentRemarks,:PaymentSchoolYearID, :isRefund)");
    
    
    if( $statement->execute(array(':DateOfPayment' => $Retrieve->DateOfPaymentInsert, ':PaymentAdmissionID' => $AdmissionID, ':ORNumber' => $Retrieve->ORNumber, ':AmountPaid' => $Retrieve->AmountPaid,':ORPaymentRemarks' => $Retrieve->ORPaymentRemarks, ':PaymentSchoolYearID' => $LatestSchoolYearID, ':isRefund' => $isRefund ))  )
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
    
    
    if( $statement->execute(array(':TableName' => "tblpaymenttransactions", ':TableID' => $LastPaymentID, ':TableAction' => "INSERT", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "CREATE SUCCEEDING PAYMENT" ))  )
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
 
















//Check if student has old ID

$StudentIsNew = true;

try
{
    
    $statement = $dbh->prepare("SELECT StudentIDDisplay FROM tblstudent WHERE StudentID= :StudentID");
    $statement->execute(array(':StudentID' => $StudentID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        if(is_null($row['StudentIDDisplay'])){
          
        }
        else{
            
            $StudentIsNew = false;
        }
         
          
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
  


//Generate New Student ID Display if New Student

if($StudentIsNew){
    
    
//To Get the number of students with student id display this school year 
$StudentsIDDisplayThisSchoolYear = 0;

try
{
    $statement = $dbh->prepare("SELECT MAX(RIGHT(StudentIDDisplay,6)) AS 'Total' FROM tblstudent   ");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row) || $row['Total'] == 0) {
          
          $StudentsIDDisplayThisSchoolYear = $row['Total'];
          
    } 
    else {
   
      $StudentsIDDisplayThisSchoolYear = 0; //Initial value, just like the school year,upon the development of this system
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    
    
$ZeroValues;
$StudentIncrementNumber= $StudentsIDDisplayThisSchoolYear + 1;
$NewStudentID;

if ($StudentIncrementNumber <10 ){
    $ZeroValues = '-00000';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
    
}
else if ($StudentIncrementNumber < 100){
    $ZeroValues = '-0000';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 1000){
    $ZeroValues = '-000';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 10000){
    $ZeroValues = '-00';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
    
    echo $NewStudentID;
    echo '<br>';
    echo '<br>';

    

    

//Update studentiddisplay of new enrollee 
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudent SET StudentIDDisplay = :StudentIDDisplay WHERE StudentID = :StudentID");
    
    
    if( $statement->execute(array(':StudentIDDisplay' => $NewStudentID,':StudentID' => $StudentID    ))  )
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
    

    
    
    
}//End of Generating New Student ID Display if New Student








   
//To Get the latest reference number  this school year 
$ReferenceNumThisSchoolYear = 0;

try
{
    $statement = $dbh->prepare("SELECT MAX(RIGHT(AdmissionReferenceNum,6)) AS 'Total' FROM tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearID  ");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row) || $row['Total'] == 0) {
          
          $ReferenceNumThisSchoolYear = $row['Total'];
          
    } 
    else {
   
      $ReferenceNumThisSchoolYear = 0; //Initial value, just like the school year,upon the development of this system
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    


$ZeroValues;
$StudentIncrementNumber= $ReferenceNumThisSchoolYear + 1;
$NewReferenceNum;

if ($StudentIncrementNumber <10 ){
    $ZeroValues = '-00000';
    $NewReferenceNum = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
    
}
else if ($StudentIncrementNumber < 100){
    $ZeroValues = '-0000';
    $NewReferenceNum = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 1000){
    $ZeroValues = '-000';
    $NewReferenceNum = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 10000){
    $ZeroValues = '-00';
    $NewReferenceNum = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
    
    echo $NewReferenceNum;
    echo '<br>';
    echo '<br>';







//Update reference number  of new enrollee 
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET AdmissionReferenceNum = :AdmissionReferenceNum,AdmissionModeOfPaymentID = :AdmissionModeOfPaymentID WHERE AdmissionID = :AdmissionID");
    
    
    if( $statement->execute(array(':AdmissionReferenceNum' => $NewReferenceNum,':AdmissionModeOfPaymentID' => $Retrieve->ModeOfPayment,  ':AdmissionID' => $AdmissionID ))  )
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
    


$_SESSION['GenerateSOAAdmissionID'] = $AdmissionID;





?>
