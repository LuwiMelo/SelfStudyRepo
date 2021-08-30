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

//Get the latest nationality ID
try
{
    
    $statement = $dbh->prepare("SELECT MAX(SectionID)+1 AS 'Max' FROM tblsection");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        $MaxStudentID = $row['Max'];
       
        
          
    } 
    else {
    
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    

    echo $MaxStudentID;
     

?>