<?php 


//Code For User Authentication For Each Web Page
//session_start();

include 'DataBaseConnectionFileNoLogInRequired.php';

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


//Check if Exists
    
$StudentIDAvailable = false;
    
try
{
    
    $statement = $dbh->prepare("SELECT StudentIDDisplay FROM tblstudent WHERE StudentIDDisplay = :StudentIDDisplay");
    $statement->execute(array(':StudentIDDisplay' => $Retrieve->StudentIDDisplay));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        $StudentIDAvailable = 'meron';
         // $LastStudentID =  $row['Max'];
         //if($LastStudentID == 0){
           //  $LastStudentID = 1;
        
          
    } 
    else {
    
        $StudentIDAvailable = 'wala';
       //$LastStudentID = 1;
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    
    
 
    

    echo $StudentIDAvailable;
    
    
}
    
    




?>