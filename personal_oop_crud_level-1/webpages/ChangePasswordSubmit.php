<?php 

session_start();

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}

*/

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


$QuerySuccessIndicator = true;
$DateToday = date('Y-m-d H:i:s');

   

    

if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);

    
    
 
//Update Password
try
{
  
    $statement = $dbh->prepare("UPDATE tblusers SET Password = :Password  WHERE UserID = :UserID     ");
   
    
    if ($statement->execute(array(':Password' => $Retrieve->Password, ':UserID' => $_SESSION['UserIDChangePassword']  ))     )
{
  // success
    echo 'successfully updated';
    echo '<br>';
  

    
}
else
{
   header("HTTP/1.0 403 Forbidden");
}


    
    
//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblusers", ':TableID' => $_SESSION['UserIDChangePassword'], ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['UserIDChangePassword'],':AuditDetails' => "CHANGE PASSWORD" ))  )
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
    
    
     
    
    
    

  

    
    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}    

    
    
}
    
   


?>