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







$LatestSchoolYearID;
$LatestSchoolYear;

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


$LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
$LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];










if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);


$MaintainSectionID = $_SESSION['EditSectionSectionID'];
    
    

    
if($Retrieve->Adviser == 0){
    unset($Retrieve->Adviser);
}
//Delete previous adviser record
try
{
    
          
          
    $statement = $dbh->prepare("DELETE FROM tbladvisory WHERE AdvisorySectionID = :AdvisorySectionID AND AdvisorySchoolYearID = :AdvisorySchoolYearID ");
    
    
    if( $statement->execute(array(':AdvisorySectionID' => $MaintainSectionID , ':AdvisorySchoolYearID' => $LatestSchoolYearID  ))  )
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
    

//Insert New Adviser Record
try
{
    
    $statement = $dbh->prepare("INSERT INTO tbladvisory(AdvisoryUserID,AdvisorySectionID,AdvisorySchoolYearID) VALUES (:AdvisoryUserID,:AdvisorySectionID,:AdvisorySchoolYearID)");
    
    
    if( $statement->execute(array(':AdvisoryUserID' => $Retrieve->Adviser, ':AdvisorySectionID' => $MaintainSectionID, ':AdvisorySchoolYearID' => $LatestSchoolYearID  ))  )
    {
        
        //$LastAuditID = $LastAuditID + 1;
    }
    else{
     
       //echo "error pa din sa audit trail nagsabay sabay na naman yan";
       header("HTTP/1.0 403 Forbidden");
        
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
     
     header("HTTP/1.0 403 Forbidden");
    
    
     
} 
   

$LastAdvisoryID = $dbh->lastInsertId();
    
    
    
    

    
    
$_SESSION['EditSectionSectionID'] = $MaintainSectionID;
    
    
        
    
$AuditDetailValue = "ASSIGNED NEW ADVISER ".$Retrieve->Adviser;
    
//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tbladvisory", ':TableID' => $LastAdvisoryID, ':TableAction' => "INSERT", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => $AuditDetailValue ))  )
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