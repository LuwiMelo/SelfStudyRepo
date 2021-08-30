<?php 


include 'DataBaseConnectionFileNoLogInRequired.php';

//session_start();


if(!isset($_SESSION['SessionUserID'])){
    
    include 'phase1header.php';
}
else{
    include 'adminheader.php';
}


    $LatestSchoolYearID;


    $statement = $dbh->prepare("SELECT MAX(SchoolYearID) AS 'Max' FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
        
    $row = $statement->fetch();
    
    
    
    if (!empty($row)) {
        
          $LatestSchoolYearID = $row['Max'];
    }
        
 
    else {
   

    }


    if($LatestSchoolYearID == $_SESSION['SessionSelectedSchoolYearID'] ){
      
         //header('Location: EnrollmentPrePhase1.php');
         echo "<script>location.href='EnrollmentPrePhase1.php';</script>";
    }
    else{
   
        echo "<script>location.href='EnrollmentPrePhase1Failed.php';</script>";
       // header('Location: EnrollmentPrePhase1Failed.php');
       
    }






?>


    
    
    
    
    
    
    
    
    