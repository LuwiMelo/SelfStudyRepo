<?php 

include 'DataBaseConnectionFileNoLogInRequired.php';

//session_start();

/*
$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/



$QuerySuccessIndicator = true;
$DateToday = date('Y-m-d H:i:s');


if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);

    
 

$LatestSchoolYearID;
$LatestSchoolYear;

    
//Get the latest school year
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT SchoolYearID,SchoolYear FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYearID =  $row['SchoolYearID'];
          $LatestSchoolYear = $row['SchoolYear'];
    } 
    else {
   
       $LatestSchoolYearID = 3;
       $LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    
    
    
    
//To Get the number of students for assessment this school year 
$StudentsAssessmentThisSchoolYear = 0;

try
{
    $statement = $dbh->prepare("SELECT MAX(RIGHT(AdmissionAssessmentIDDisplay,6)) AS 'Total' FROM tblstudentadmission   ");
    $statement->execute(array(':LatestSchoolYear' => $LatestSchoolYear));
    $row = $statement->fetch();
    
    if (!empty($row) || $row['Total'] == 0) {
          
          $StudentsAssessmentThisSchoolYear = $row['Total'];
          
    } 
    else {
   
      $StudentsAssessmentThisSchoolYear = 0; //Initial value, just like the school year,upon the development of this system
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    
$ZeroValues;
$StudentIncrementNumber= $StudentsAssessmentThisSchoolYear + 1;
$NewAssessmentID;

if ($StudentIncrementNumber <10 ){
    $ZeroValues = '-00000';
    $NewAssessmentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
    
}
else if ($StudentIncrementNumber < 100){
    $ZeroValues = '-0000';
    $NewAssessmentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 1000){
    $ZeroValues = '-000';
    $NewAssessmentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
else if ($StudentIncrementNumber < 10000){
    $ZeroValues = '-00';
    $NewAssessmentID = $LatestSchoolYear.$ZeroValues.$StudentIncrementNumber;
}
    
    echo $NewAssessmentID;
    echo '<br>';
    echo '<br>';

if($Retrieve->Strand == "0"){
    $Retrieve->Strand = null;
}
    
//Insert New Student data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("INSERT INTO tblstudent (StudentIDDisplay, LRNNumber, LastName,FirstName,MiddleName,StudentGender, StudentNationalityID, StudentBirthday, PlaceOfBirth, StudentReligionID, FatherFullName, FatherOccupation, MotherFullName, MotherOccupation, AddressPrefix, StudentBarangay, StudentMunicipalityID, StudentProvinceID, HomeNumber, MobileNumber, ContactPerson, EmailAddress, RelationshipToContactPerson, ContactPersonContactNumber, DateCreated, StudentStatus, StudentAge, StudentStrand) VALUES (:StudentIDDisplay, :LRNNumber, :LastName, :FirstName, :MiddleName, :StudentGender, :StudentNationalityID, :StudentBirthday, :PlaceOfBirth, :StudentReligionID, :FatherFullName, :FatherOccupation, :MotherFullName, :MotherOccupation, :AddressPrefix, :StudentBarangay, :StudentMunicipalityID, :StudentProvinceID, :HomeNumber, :MobileNumber, :ContactPerson, :EmailAddress, :RelationshipToContactPerson, :ContactPersonContactNumber, :DateCreated, :StudentStatus, :StudentAge, :StudentStrand)");
   
    
    
    if ($statement->execute(array(':StudentIDDisplay' => $Retrieve->StudentIDDisplay , ':LRNNumber' => $Retrieve->LRNNumber, ':LastName' => $Retrieve->LastName, ':FirstName' => $Retrieve->FirstName, ':MiddleName' => $Retrieve->MiddleName, ':StudentGender' => $Retrieve->Gender, ':StudentNationalityID' => $Retrieve->StudentNationalityID, ':StudentBirthday' => $Retrieve->StudentBirthday, ':PlaceOfBirth' => $Retrieve->PlaceOfBirth, ':StudentReligionID' => $Retrieve->StudentReligionID , ':FatherFullName' => $Retrieve->FatherFullName, ':FatherOccupation' => $Retrieve->FatherOccupation, ':MotherFullName' => $Retrieve->MotherFullName, ':MotherOccupation' => $Retrieve->MotherOccupation, ':AddressPrefix' => $Retrieve->AddressPrefix, ':StudentBarangay' => $Retrieve->StudentBarangay, ':StudentMunicipalityID' => $Retrieve->StudentMunicipalityID, ':StudentProvinceID' => $Retrieve->StudentProvinceID, ':HomeNumber' => $Retrieve->HomeNumber, ':MobileNumber' => $Retrieve->MobileNumber, ':ContactPerson' => $Retrieve->ContactPerson, ':EmailAddress' => $Retrieve->EmailAddress, ':RelationshipToContactPerson' => $Retrieve->RelationshipToContactPerson, ':ContactPersonContactNumber' => $Retrieve->ContactPersonContactNumber, ':DateCreated' => $DateToday, ':StudentStatus' => '0', ':StudentAge' => $Retrieve->StudentAge, ':StudentStrand' => $Retrieve->Strand ))             )
{
  // success
}
else
{
   header("HTTP/1.0 403 Forbidden");
}
    
     
$LastStudentID = $dbh->lastInsertId();

    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
    header("HTTP/1.0 403 Forbidden");
}
    
    
//Insert New Admission data into database
try
{
    //$LatestSchoolYear;
    //$statement = $dbh->prepare("INSERT INTO tblstudentadmission (AdmissionID,AdmissionStatus,AdmissionUpdate,AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution,AdmissionSchoolYearID,AdmissionAssessmentIDDisplay) VALUES (:AdmissionID, :AdmissionStatus , :AdmissionUpdate, :AdmissionSchoolOfOrigin, :AdmissionTypeOfInstitution, :AdmissionSchoolYearID, :AdmissionAssessmentIDDisplay )");
    
    
      //if( $statement->execute(array(':AdmissionID' => $LastAdmissionID , ':AdmissionStatus' => 0 , ':AdmissionUpdate' => 1 , ':AdmissionSchoolOfOrigin' => $Retrieve->AdmissionSchoolOfOrigin, ':AdmissionTypeOfInstitution' => $Retrieve->AdmissionTypeOfInstitution, ':AdmissionSchoolYearID' => $LatestSchoolYearID, ':AdmissionAsssessmentIDDisplay' => $NewAssessmentID  ))  )
          
          
    $statement = $dbh->prepare("INSERT INTO tblstudentadmission (AdmissionStudentID,AdmissionStatus,AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution, AdmissionSchoolYearID,AdmissionAssessmentIDDisplay,isAssessmentPhase,AdmissionGradeLevelID) VALUES (:AdmissionStudentID, :AdmissionStatus ,  :AdmissionSchoolOfOrigin, :AdmissionTypeOfInstitution, :AdmissionSchoolYearID, :AdmissionAssessmentIDDisplay, :isAssessmentPhase, :AdmissionGradeLevelID )");
    
    
    if( $statement->execute(array(':AdmissionStudentID' => $LastStudentID,  ':AdmissionStatus' => 1 , ':AdmissionSchoolOfOrigin' => $Retrieve->AdmissionSchoolOfOrigin, ':AdmissionTypeOfInstitution' => $Retrieve->AdmissionTypeOfInstitution, ':AdmissionSchoolYearID' => $LatestSchoolYearID, ':AdmissionAssessmentIDDisplay' => $NewAssessmentID, ':isAssessmentPhase' => 0, ':AdmissionGradeLevelID' => $Retrieve->IncomingGradeLevel  ))  )
    {
        
        
    }
    else{
       echo "error in admission";
       header("HTTP/1.0 403 Forbidden");
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
    
  
    
$LastAdmissionID = $dbh->lastInsertId();
    
    
if(isset($_SESSION['SessionUserID'])){
     $UserIDInsert = $_SESSION['SessionUserID'];
}
else{
     unset($_SESSION['SessionUserID']);
}

    
  

//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudent", ':TableID' => $LastStudentID, ':TableAction' => "INSERT", ':DateTime' => $DateToday,':TableUserID' => $UserIDInsert, ':AuditDetails' => "CREATED NEW TRANSFEREE RECORD" ))  )
    {
        
        $LastAuditID = $LastAuditID + 1;
    }
    else{
     
       echo "error pa din sa audit trail nagsabay sabay na naman yan";
       header("HTTP/1.0 403 Forbidden");
        
    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
     
     header("HTTP/1.0 403 Forbidden");
    
    
     
} 

    


//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudentadmission", ':TableID' => $LastAdmissionID, ':TableAction' => "INSERT", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "CREATED NEW TRANSFEREE RECORD" ))  )
    {
        $LastAuditID = $LastAuditID + 1;
        
    }
    else{

       echo "error pa din sa audit trail nagsabay sabay na naman yan";
       header("HTTP/1.0 403 Forbidden");
    

    }
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
     
     header("HTTP/1.0 403 Forbidden");
} 
    
    
    
    
    
    

//Insert Siblings Inside IUCS
if(isset($Retrieve->StudentSiblings)){
   

$TotalSiblings = count($Retrieve->StudentSiblings);

//$LastSiblingIDInt = (int)$LastSiblingID;

    
    
for ($x = 0; $x < $TotalSiblings; $x++){
    
  $SiblingIDInt = (int)$Retrieve->StudentSiblings[$x];
  echo $SiblingIDInt;
    
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblsibling (SiblingStudentID, SiblingMainStudentID, SiblingTableAdmissionID) VALUES (:SiblingStudentID, :SiblingMainStudentID, :SiblingTableAdmissionID )");
    
    
    //ech (string)$Retrieve->StudentSiblings[$x];
  
   // echo $SiblingIDInt;
    
    if($statement->execute(array(':SiblingStudentID' => $SiblingIDInt, ':SiblingMainStudentID' => $LastStudentID, ':SiblingTableAdmissionID' => $LastAdmissionID  ))) 
    {
        
        
    }
    
    else{
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
    
    
    
    
    
    
    
    
}  
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
    
   


?>