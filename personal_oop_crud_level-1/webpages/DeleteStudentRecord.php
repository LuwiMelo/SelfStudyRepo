<?php

//Code For User Authentication For Each Web Page
session_start();
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




//Get the latest school year
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT SchoolYear FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYear =  $row['SchoolYear'];
          
    } 
    else {
   
       $LatestSchoolYear = "2019";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





//Remove Siblings of selected student to be deleted
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("DELETE FROM tblsibling WHERE SiblingMainStudentID = :SiblingMainStudentID");
    
    
    if( $statement->execute(array(':SiblingMainStudentID' => $_POST['id']     ))  )
    {
        
        echo 'remove sibling success';
    }
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     //header("HTTP/1.0 403 Forbidden");
    header('Location: StudentRecordsList.php');
}
    




//Get the latest admission record
try
{
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID HAVING LEFT(AdmissionReferenceNum,4) = :LatestSchoolYear  ");
    $statement->execute(array(':AdmissionStudentID' => $_POST['id'], ':LatestSchoolYear' => $LatestSchoolYear     ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){

              $DeleteStudentAdmissionID = $data['AdmissionID'];
        }
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





//Remove Admission Record
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("DELETE FROM tblstudentadmission WHERE AdmissionStudentID = :AdmissionStudentID");
    
    
    if( $statement->execute(array(':AdmissionStudentID' => $_POST['id']     ))  )
    {
        
        echo '<br>remove admission success';
    }
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     //header("HTTP/1.0 403 Forbidden");
    header('Location: StudentRecordsList.php');
}
 


//Remove Student Record
try
{
    //$LatestSchoolYear
    $statement = $dbh->prepare("DELETE FROM tblstudent WHERE StudentID = :StudentID");

    if( $statement->execute(array(':StudentID' => $_POST['id']     ))  )
    {
        
        echo '<br>remove student success';
    }
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     //header("HTTP/1.0 403 Forbidden");
    header('Location: StudentRecordsList.php');
}
 


header('Location: StudentRecordsList.php');






?>