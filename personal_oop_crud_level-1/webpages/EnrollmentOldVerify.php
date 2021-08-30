<?php
include 'DataBaseConnectionFileNoLogInRequired.php';

//Code For User Authentication For Each Web Page
//session_start();



//$RetrieveStudentID = $_POST['ModalStudentNum'];


//echo $RetrieveStudentID;

/*
$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
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
    
    
try
{
 
 
    $statement = $dbh->prepare("SELECT * FROM tblstudent WHERE StudentIDDisplay = :StudentIDDisplay  ");
    $statement->execute(array(':StudentIDDisplay' => $Retrieve->StudentIDDisplay));
    $row = $statement->fetch();
    
    
    
    if (!empty($row)) {
        
          $_SESSION['SessionEnrollOldStudentIDPK'] =  $row['StudentID'];
          
        
         // server should keep session data for AT LEAST 1 hour
         ini_set('session.gc_maxlifetime', 3600);

         // each client should remember their session id for EXACTLY 1 hour
          session_set_cookie_params(3600);
        
          session_start();
          $_SESSION['SessionEnrollOldStudentIDDisplay'] = $row['StudentID'];
 
           //echo $_SESSION['SessionEnrollOldStudentIDPK'];
        
          //header('Location: EnrollmentPhase1Old.php');
        
        
    } 
    else {
        //Ajax force to throw error meaning student id entered is not in the database
        echo $Retrieve->StudentIDDisplay;
        header("HTTP/1.0 403 Forbidden");
    }

 

}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



}
else{
    
    echo ' wala';
}



?>