<?php 
include 'DataBaseConnectionFileNoLogInRequired.php';

/*
session_start();
*/
if(!isset($_SESSION['SessionUserID'])){
    
    include 'phase1header.php';
}
else{
    include 'adminheader.php';
}




$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
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


$ReferenceNumThisYear;

try
{
    //$LatestSchoolYear;
   $statement = $dbh->prepare("SELECT COUNT(AdmissionID) AS 'Total' FROM tblstudentadmission WHERE LEFT(AdmissionReferenceNum,4) = :LatestSchoolYear     ");
    $statement->execute(array(':LatestSchoolYear' => $LatestSchoolYear));
    $row = $statement->fetch();
    
    if (!empty($row) && $row['Total'] != 0) {
          
          $ReferenceNumThisYear =  $row['Total'];
          
    } 
    else {
   
       $ReferenceNumThisYear = "0";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




$StudentsEnrolledThisSchoolYear;

try
{
    $statement = $dbh->prepare("SELECT MAX(RIGHT(StudentIDDisplay,6)) AS 'Total' FROM tblstudent   ");
    $statement->execute(array(':LatestSchoolYear' => $LatestSchoolYear));
    $row = $statement->fetch();
    
    if (!empty($row) || $row['Total'] == 0) {
          
          $StudentsEnrolledThisSchoolYear = $row['Total'];
          
    } 
    else {
   
      $StudentsEnrolledThisSchoolYear = 2411; //Initial value, just like the school year,upon the development of this system
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//for intial only
if($StudentsEnrolledThisSchoolYear == 2172){
$StudentsEnrolledThisSchoolYear = 2411;
}




$ZeroValues;
$StudentIncrementNumber= $StudentsEnrolledThisSchoolYear + 1;
$NewStudentID;

if ($StudentIncrementNumber <10 ){
    $ZeroValues = '-00000';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
    
}
else if ($StudentIncrementNumber < 100){
    $ZeroValues = '-0000';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 1000){
    $ZeroValues = '-000';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 10000){
    $ZeroValues = '-00';
    $NewStudentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}



$ReferenceNumZeroValues;
$ReferenceIncrementNumber = $ReferenceNumThisYear + 1; 
$NewReferenceNum;



if ($ReferenceIncrementNumber <10 ){
    $ReferenceNumZeroValues = '-00000';
    $NewReferenceNum = $LatestSchoolYear.$ReferenceNumZeroValues.$ReferenceIncrementNumber;
}
else if ($ReferenceIncrementNumber < 100){
    $ReferenceNumZeroValues = '-0000';
    $NewReferenceNum = $LatestSchoolYear.$ReferenceNumZeroValues.$ReferenceIncrementNumber;
}
else if ($ReferenceIncrementNumber < 1000){
    $ReferenceNumZeroValues = '-000';
    $NewReferenceNum = $LatestSchoolYear.$ReferenceNumZeroValues.$ReferenceIncrementNumber;
}
else if ($ReferenceIncrementNumber < 10000){
    $ReferenceNumZeroValues = '-00';
    $NewReferenceNum = $LatestSchoolYear.$ReferenceNumZeroValues.$ReferenceIncrementNumber;
}





$FirstGradeLevelID;

try
{
    $statement = $dbh->prepare("SELECT GradeLevelID FROM tblgradelevel ORDER BY GradeLevelID LIMIT 1    ");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $FirstGradeLevelID = $row['GradeLevelID'];
          
    } 
    else {
   
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//$ExistingStudentIDDisplay;
$ExistingStudentIDDisplay = array();

try
{
    $statement = $dbh->prepare("SELECT StudentIDDisplay FROM tblstudent WHERE StudentStatus = 0    ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
          
         foreach($row as $data){
            //$ExistingStudentIDDisplay = $data['StudentIDDisplay'];
             array_push($ExistingStudentIDDisplay,$data['StudentIDDisplay']);
         }
    } 
    else {
   
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

/*

$ExistingStudentID;

try
{
    $statement = $dbh->prepare("SELECT StudentIDDisplay FROM tblstudent WHERE StudentStatus = 0    ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
          
         foreach($row as $data){
            $ExistingStudentID = $data['StudentIDDisplay'];
         }
    } 
    else {
   
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
*/


?>

<!--main-container-part-->
<div id="content"> <!-- this div will have no end tag, end tag will be found in the admin footer page -->

  <div id="content-header">
    
  </div>



     <div class="container-fluid">
         <hr>
    <center>    <img  style="width: 800px; height: 150px;" src="phase1logo.png"> </center>
      <br>
          <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Notifications</h5>
          </div>
          <div class="widget-content">
            
            <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
              <center><h1 class="alert-heading">Enrollment Phase 1 Success!</h1></center>
                
            <h3>
              You have completed the phase 1 of enrollment in Imus Unida Christian School. For Phase 2, please go to Guidance Office for the schedule of the student's interview! 
                
                </h3>
              
            </div>
       
           
              
              
                 <div class="row-fluid">
                     <div class="span5"></div>
             
				     <div class="span5" style="margin-top: 25px; margin-left: 150px; margin-bottom: 100px;">
       <a href="EnrollmentPrePhase1.php"><button type="button" id="SubmitButton" class="btn btn-large btn-success">Enroll New Student</button></a>
              
            
    
    </div>
                <br>
                <br>
                <br>
                     <br>
                     <br>
                     <br>
                     
            </div>
                   
          
           
         

          </div>
        </div>
         
         
         
         
         
         
    </div> <!-- end of container fluid -->
    
    

<?php

include 'adminfooter.php';

?>
    
    

    
    </body>
</html>
    
    
    
    
    
    
    
    
    