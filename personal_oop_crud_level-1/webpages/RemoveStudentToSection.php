<?php 

session_start();
include 'DataBaseConnectionFile.php';

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

$QuerySuccessIndicator = true;
$DateToday = date('Y-m-d H:i:s');


if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);

$MaintainSectionID = $Retrieve->SectionID;
    
 unset($Retrieve->SectionID);
    
    
//Update Section
try
{
    
          
          
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET AdmissionSectionID = :AdmissionSectionID WHERE AdmissionID = :AdmissionID");
    
    
    if( $statement->execute(array(':AdmissionSectionID' => $Retrieve->SectionID , ':AdmissionID' => $Retrieve->AdmissionID  ))  )
    {
        
        
    }
    else{
       echo "error in admission";
       header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
    
    
    
    
    
$_SESSION['EditSectionSectionID'] = $MaintainSectionID;
    
    
        
    
$AuditDetailValue = "REMOVED FROM SECTION ".$MaintainSectionID;
    
//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudentadmission", ':TableID' => $Retrieve->AdmissionID, ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => $AuditDetailValue ))  )
    {
        
        $LastAuditID = $LastAuditID + 1;
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
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
    
   


?>