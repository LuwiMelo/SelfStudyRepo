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


$QuerySuccessIndicator = true;
$DateToday = date('Y-m-d');


if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);

    
//Get the latest student ID
$LastStudentID;
    
try
{
    
    $statement = $dbh->prepare("SELECT MAX(StudentID) + 1 AS 'Max' FROM tblstudent ORDER BY StudentID DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LastStudentID =  $row['Max'];
         if($LastStudentID == 0){
             $LastStudentID = 1;
        }
          
    } 
    else {
   
       //$LastStudentID = 1;
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    
    
    
//Get the latest admission ID
$LastAdmissionID;
    
try
{
    
    $statement = $dbh->prepare("SELECT MAX(AdmissionID) + 1 AS 'Max' FROM tblstudentadmission ORDER BY AdmissionID DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LastAdmissionID =  $row['Max'];
        
         if($LastAdmissionID == 0){
             $LastAdmissionID = 1;
        }
          
    } 
    else {
   
       $LastAdmissionID = 1;
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


    
    
    
//Get the latest sibling ID
$LastSiblingID;
    
try
{
    
    $statement = $dbh->prepare("SELECT MAX(SiblingID) + 1 AS 'Max' FROM tblsibling ORDER BY SiblingID DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LastSiblingID =  $row['Max'];
        
        if($LastSiblingID == 0){
             $LastSiblingID = 1;
        }
          
    } 
    else {
        
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    

    
if ($Retrieve->StudentStrand == 0){
    unset($Retrieve->StudentStrand);
    
    
}
    
if ($Retrieve->AdmissionSiblingDiscountID == 0){
    unset($Retrieve->AdmissionSiblingDiscountID);
    
    
}
    
if ($Retrieve->AdmissionAcademicScholarshipDiscountID== 0){
    unset($Retrieve->AdmissionAcademicScholarshipDiscountID);
    
    
}
    
if ($Retrieve->AdmissionPromotionalDiscountID == 0){
    unset($Retrieve->AdmissionPromotionalDiscountID);
    
    
}
    
if ($Retrieve->AdmissionEntranceScholarshipDiscountID == 0){
    unset($Retrieve->AdmissionEntranceScholarshipDiscountID);
    
    
}
    
if ($Retrieve->AdmissionVarsityDiscountID == 0){
    unset($Retrieve->AdmissionVarsityDiscountID);
    
    
}

if ($Retrieve->AdmissionSTSDiscountID == 0){
    unset($Retrieve->AdmissionSTSDiscountID);
    
    
}
    
if ($Retrieve->StudentStrand == 0){
    unset($Retrieve->StudentStrand);
        
}
    
       
if(!isset($Retrieve->ESCNumber) || $Retrieve->ESCNumber == ""){
    unset($Retrieve->ESCNumber);
}

   
    
    
//Insert New Student data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("INSERT INTO tblstudent (StudentID,StudentIDDisplay, LRNNumber, LastName,FirstName,MiddleName,StudentGender, StudentNationalityID, StudentBirthday, PlaceOfBirth, StudentReligionID, FatherFullName, FatherOccupation, MotherFullName, MotherOccupation, AddressPrefix, StudentBarangay, StudentMunicipalityID, StudentProvinceID, HomeNumber, MobileNumber, ContactPerson, EmailAddress, RelationshipToContactPerson, ContactPersonContactNumber, StudentStrand, ESCNumber, DateCreated, StudentStatus, StudentAge) VALUES ( :StudentID, :StudentIDDisplay, :LRNNumber, :LastName, :FirstName, :MiddleName, :StudentGender, :StudentNationalityID, :StudentBirthday, :PlaceOfBirth, :StudentReligionID, :FatherFullName, :FatherOccupation, :MotherFullName, :MotherOccupation, :AddressPrefix, :StudentBarangay, :StudentMunicipalityID, :StudentProvinceID, :HomeNumber, :MobileNumber, :ContactPerson, :EmailAddress, :RelationshipToContactPerson, :ContactPersonContactNumber, :StudentStrand , :ESCNumber, :DateCreated, :StudentStatus, :StudentAge)");
   
    
    
    
    if ($statement->execute(array(':StudentID' => $LastStudentID , ':StudentIDDisplay' => $Retrieve->StudentIDDisplay , ':LRNNumber' => $Retrieve->LRNNumber, ':LastName' => $Retrieve->LastName, ':FirstName' => $Retrieve->FirstName, ':MiddleName' => $Retrieve->MiddleName, ':StudentGender' => $Retrieve->Gender, ':StudentNationalityID' => $Retrieve->StudentNationalityID, ':StudentBirthday' => $Retrieve->StudentBirthday, ':PlaceOfBirth' => $Retrieve->PlaceOfBirth, ':StudentReligionID' => $Retrieve->StudentReligionID , ':FatherFullName' => $Retrieve->FatherFullName, ':FatherOccupation' => $Retrieve->FatherOccupation, ':MotherFullName' => $Retrieve->MotherFullName, ':MotherOccupation' => $Retrieve->MotherOccupation, ':AddressPrefix' => $Retrieve->AddressPrefix, ':StudentBarangay' => $Retrieve->StudentBarangay, ':StudentMunicipalityID' => $Retrieve->StudentMunicipalityID, ':StudentProvinceID' => $Retrieve->StudentProvinceID, ':HomeNumber' => $Retrieve->HomeNumber, ':MobileNumber' => $Retrieve->MobileNumber, ':ContactPerson' => $Retrieve->ContactPerson, ':EmailAddress' => $Retrieve->EmailAddress, ':RelationshipToContactPerson' => $Retrieve->RelationshipToContactPerson, ':ContactPersonContactNumber' => $Retrieve->ContactPersonContactNumber, ':StudentStrand' => $Retrieve->StudentStrand, ':ESCNumber' => $Retrieve->ESCNumber , ':DateCreated' => $DateToday, ':StudentStatus' => '0', ':StudentAge' => $Retrieve->StudentAge ))             )
{
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
    
    

    
if ($Retrieve->AdmissionSectionID == 0){
    unset($Retrieve->AdmissionSectionID);
    
    
}
    


    
//Insert New Admission data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("INSERT INTO tblstudentadmission (AdmissionID,AdmissionStudentID, AdmissionReferenceNum, AdmissionGradeLevelID,AdmissionSectionID, AdmissionModeOfPaymentID, AdmissionSiblingDiscountID, AdmissionAcademicScholarshipDiscountID, AdmissionPromotionalDiscountID, AdmissionEntranceScholarshipDiscountID, AdmissionVarsityDiscountID, AdmissionSTSDiscountID,AdmissionStatus,AdmissionUpdate,AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution) VALUES (:AdmissionID, :AdmissionStudentID, :AdmissionReferenceNum, :AdmissionGradeLevelID, :AdmissionSectionID, :AdmissionModeOfPaymentID, :AdmissionSiblingDiscountID, :AdmissionAcademicScholarshipDiscountID, :AdmissionPromotionalDiscountID, :AdmissionEntranceScholarshipDiscountID, :AdmissionVarsityDiscountID, :AdmissionSTSDiscountID, :AdmissionStatus , :AdmissionUpdate, :AdmissionSchoolOfOrigin, :AdmissionTypeOfInstitution )");
    
    
    if( $statement->execute(array(':AdmissionID' => $LastAdmissionID , ':AdmissionStudentID' => $LastStudentID , ':AdmissionReferenceNum' => $Retrieve->AdmissionReferenceNum, ':AdmissionGradeLevelID' => $Retrieve->AdmissionGradeLevelID, ':AdmissionSectionID' => $Retrieve->AdmissionSectionID, ':AdmissionModeOfPaymentID' => $Retrieve->AdmissionModeOfPaymentID, ':AdmissionSiblingDiscountID' => $Retrieve->AdmissionSiblingDiscountID, ':AdmissionAcademicScholarshipDiscountID' => $Retrieve->AdmissionAcademicScholarshipDiscountID, ':AdmissionPromotionalDiscountID' => $Retrieve->AdmissionPromotionalDiscountID, ':AdmissionEntranceScholarshipDiscountID' => $Retrieve->AdmissionEntranceScholarshipDiscountID, ':AdmissionVarsityDiscountID' => $Retrieve->AdmissionVarsityDiscountID,  ':AdmissionSTSDiscountID' => $Retrieve->AdmissionSTSDiscountID, ':AdmissionStatus' => 0 , ':AdmissionUpdate' => 1 , ':AdmissionSchoolOfOrigin' => $Retrieve->AdmissionSchoolOfOrigin, ':AdmissionTypeOfInstitution' => $Retrieve->AdmissionTypeOfInstitution ))  )
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
    
    
    /*
    var_dump($Retrieve);
    //var_dump($wg_village);
    echo $Retrieve->StudentSiblings[0];
    echo $Retrieve->StudentSiblings[1];
    //echo $Retrieve->StudentSiblings[1];
    
    */

if(isset($Retrieve->StudentSiblings)){
   

$TotalSiblings = count($Retrieve->StudentSiblings);

$LastSiblingIDInt = (int)$LastSiblingID;

    
    
for ($x = 0; $x < $TotalSiblings; $x++){
    
  $SiblingIDInt = (int)$Retrieve->StudentSiblings[$x];
  echo $SiblingIDInt;
    
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblsibling (SiblingID,SiblingStudentID, SiblingMainStudentID) VALUES (:SiblingID , :SiblingStudentID, :SiblingMainStudentID )");
    
    
    //ech (string)$Retrieve->StudentSiblings[$x];
  
   // echo $SiblingIDInt;
    
    if($statement->execute(array(':SiblingID' => $LastSiblingIDInt, ':SiblingStudentID' => $SiblingIDInt, ':SiblingMainStudentID' => $LastStudentID ))) 
    {
        
        
    }
    
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
    $LastSiblingIDInt++;

  
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