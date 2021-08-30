<?php 


//Code For User Authentication For Each Web Page
session_start();

include 'DataBaseConnectionFile.php';

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}


$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/





if (isset($_POST["RetrieveTransaction"]))
{

    
$Retrieve = json_decode($_POST["RetrieveTransaction"]);


if($Retrieve->UserPositionLevel == 0){
    unset($Retrieve->UserPositionLevel);
}

if($Retrieve->EditDepartment == 0){
    unset($Retrieve->EditDepartment);
}
    
    
if($Retrieve->EditUserMiddleName == ""){
    unset($Retrieve->EditUserMiddleName);
}

    
//UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblusers SET Username = :Username, Password = :Password, UserPositionLevel = :UserPositionLevel, AssignedDepartment = :AssignedDepartment, FirstName = :FirstName, MiddleName = :MiddleName, LastName = :LastName WHERE UserID = :UserID");
   
    
    if ($statement->execute(array(':Username' => $Retrieve->Username,':Password' => $Retrieve->Password,':UserPositionLevel' => $Retrieve->UserPositionLevel, ':AssignedDepartment' => $Retrieve->EditDepartment, ':FirstName' => $Retrieve->EditUserFirstName, ':MiddleName' => $Retrieve->EditUserMiddleName, ':LastName' => $Retrieve->EditUserLastName, ':UserID' => $Retrieve->UserID  ))    ){
        // success
    }
    else
{
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