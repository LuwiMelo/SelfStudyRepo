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


//UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("INSERT INTO tblsection(SectionID,SectionName,SectionGradeLevel) VALUES(:SectionID,:SectionName, :SectionGradeLevel)");
    if ($statement->execute(array(':SectionID' => $Retrieve->SectionID, ':SectionName' => $Retrieve->SectionName, ':SectionGradeLevel' => $Retrieve->SectionGradeLevel ))    ){
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
    
      
    
    echo $Retrieve->SectionGradeLevel;
    
}
    
    



?>