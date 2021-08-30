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
    
    $StudentIDToBeVerified = $_SESSION['SessionEnrollOldStudentIDDisplay'];
try
{
 
 
    $statement = $dbh->prepare("SELECT AdmissionID,tblstudent.StudentID AS 'StudentID' FROM tblstudent,tblstudentadmission WHERE StudentID = AdmissionStudentID AND StudentID = $StudentIDToBeVerified AND tblstudentadmission.AdmissionSchoolYearID = (SELECT MAX(SchoolYearID) from tblschoolyear) ");
    $statement->execute();
    $row = $statement->fetch();
    
    
    
    if (!empty($row)) {
        
        //Ajax force to throw error meaning student id entered is already enrolled in this school year
          header("HTTP/1.0 403 Forbidden");
        
        
 
    } 
    else {
        
       
         // server should keep session data for AT LEAST 1 hour
         //ini_set('session.gc_maxlifetime', 3600);

         // each client should remember their session id for EXACTLY 1 hour
          //session_set_cookie_params(3600);
        
          //session_start();
         // $_SESSION['SessionEnrollOldStudentIDDisplay'] = $row['StudentID'];
 
          //$_SESSION['SessionEnrollOldStudentIDPK'] =  $row['StudentID'];
           //echo $_SESSION['SessionEnrollOldStudentIDPK'];
        
          //header('Location: EnrollmentPhase1Old.php');
        
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