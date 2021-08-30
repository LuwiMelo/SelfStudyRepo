<?php

/*
include 'dbconnection.php';


session_start();

$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
     $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/

include 'DataBaseConnectionFileNoLogInRequired.php';


$RetrieveUsername = $_POST['UserUsername'];
$RetrievePassword = $_POST['UserPassword'];

try
{
 
    //$database = new Connection();
    //$db = $database->openConnection();
    
    $statement = $dbh->prepare("select * from tblusers where Username = :UserUsername AND Password = :UserPassword");
    $statement->execute(array(':UserUsername' => $RetrieveUsername, ':UserPassword' => $RetrievePassword));
    $row = $statement->fetch();
    
    
    
    if (!empty($row)) {
          echo 'result';
          $UserID =  $row['UserID'];
         // header('Location: home.php');
        
         // server should keep session data for AT LEAST 1 hour
         ini_set('session.gc_maxlifetime', 7200);

         // each client should remember their session id for EXACTLY 1 hour
          session_set_cookie_params(7200);
        
          session_start();
          $_SESSION['SessionUserID'] = $row['UserID'];
          $_SESSION['SessionUserPositionLevel'] = $row['UserPositionLevel'];
        
        
          if(isset($row['AssignedDepartment'])){
                $_SESSION['SessionDepartmentID'] = $row['AssignedDepartment'];
          }
        
        
        
        
    $statement = $dbh->prepare("SELECT SchoolYear,SchoolYearID FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
        
    $row = $statement->fetch();
    
    
    
    if (!empty($row)) {
        
          $_SESSION['SessionSelectedSchoolYearID'] = $row['SchoolYearID'];
          $_SESSION['SessionSelectedSchoolYear'] = $row['SchoolYear'];
        
          //$_SESSION['SessionSelectedSchoolYearID'] = 3;
          //$_SESSION['SessionSelectedSchoolYear'] = 2020;
        
          //$_SESSION['SessionSelectedSchoolYearID'] = 2;
          //$_SESSION['SessionSelectedSchoolYear'] = 2019;
        
        
          header('Location: home.php');
    }
        
        
        
        
    } 
    else {
   
          $_SESSION['IsLoginFailed'] = true;
          header('Location: login.php');
    }

 

}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





?>