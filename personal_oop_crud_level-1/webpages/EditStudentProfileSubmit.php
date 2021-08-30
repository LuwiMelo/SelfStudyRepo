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
    
 if ($Retrieve->AdmissionGradeLevelID == 0){
    unset($Retrieve->AdmissionGradeLevelID);
   
}
    
if ($Retrieve->StudentMunicipalityID == 0){
    unset($Retrieve->StudentMunicipalityID);
   
}
    
if ($Retrieve->StudentProvinceID == 0){
    unset($Retrieve->StudentProvinceID);
   
}
    
     
    
if(!isset($Retrieve->ESCNumber) || $Retrieve->ESCNumber == ""){
    unset($Retrieve->ESCNumber);
}

      
    
//Update Student data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudent SET StudentIDDisplay = :StudentIDDisplay, LRNNumber = :LRNNumber, LastName = :LastName, FirstName = :FirstName, MiddleName = :MiddleName, StudentGender = :StudentGender, StudentNationalityID = :StudentNationalityID, StudentBirthday = :StudentBirthday, PlaceOfBirth = :PlaceOfBirth, StudentReligionID = :StudentReligionID, FatherFullName = :FatherFullName, FatherOccupation = :FatherOccupation, MotherFullName = :MotherFullName, MotherOccupation = :MotherOccupation, AddressPrefix = :AddressPrefix, StudentBarangay = :StudentBarangay, StudentMunicipalityID = :StudentMunicipalityID, StudentProvinceID = :StudentProvinceID, HomeNumber = :HomeNumber, MobileNumber = :MobileNumber, ContactPerson = :ContactPerson, EmailAddress = :EmailAddress, RelationshipToContactPerson = :RelationshipToContactPerson, ContactPersonContactNumber = :ContactPersonContactNumber, StudentStrand = :StudentStrand, ESCNumber = :ESCNumber, StudentAge = :StudentAge WHERE StudentID = :StudentID     ");
   
    
    
     
    if ($statement->execute(array(':StudentIDDisplay' => $Retrieve->StudentIDDisplay , ':LRNNumber' => $Retrieve->LRNNumber, ':LastName' => $Retrieve->LastName, ':FirstName' => $Retrieve->FirstName, ':MiddleName' => $Retrieve->MiddleName, ':StudentGender' => $Retrieve->Gender, ':StudentNationalityID' => $Retrieve->StudentNationalityID, ':StudentBirthday' => $Retrieve->StudentBirthday, ':PlaceOfBirth' => $Retrieve->PlaceOfBirth, ':StudentReligionID' => $Retrieve->StudentReligionID , ':FatherFullName' => $Retrieve->FatherFullName, ':FatherOccupation' => $Retrieve->FatherOccupation, ':MotherFullName' => $Retrieve->MotherFullName, ':MotherOccupation' => $Retrieve->MotherOccupation, ':AddressPrefix' => $Retrieve->AddressPrefix, ':StudentBarangay' => $Retrieve->StudentBarangay, ':StudentMunicipalityID' => $Retrieve->StudentMunicipalityID, ':StudentProvinceID' => $Retrieve->StudentProvinceID, ':HomeNumber' => $Retrieve->HomeNumber, ':MobileNumber' => $Retrieve->MobileNumber, ':ContactPerson' => $Retrieve->ContactPerson, ':EmailAddress' => $Retrieve->EmailAddress, ':RelationshipToContactPerson' => $Retrieve->RelationshipToContactPerson, ':ContactPersonContactNumber' => $Retrieve->ContactPersonContactNumber, ':StudentStrand' => $Retrieve->StudentStrand, ':ESCNumber' => $Retrieve->ESCNumber , ':StudentAge' => $Retrieve->StudentAge, ':StudentID' => $Retrieve->EditStudentID  ))             )
{
  // success
    echo 'successfully updated';

}
else
{
   header("HTTP/1.0 403 Forbidden");
}

    
    
    
    
        
if ($Retrieve->AdmissionSectionID == 0){
    unset($Retrieve->AdmissionSectionID);
    
    
}
    



    
        
    
//Update Admission data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET AdmissionReferenceNum = :AdmissionReferenceNum, AdmissionGradeLevelID = :AdmissionGradeLevelID, AdmissionSectionID = :AdmissionSectionID, AdmissionModeOfPaymentID = :AdmissionModeOfPaymentID, AdmissionSiblingDiscountID = :AdmissionSiblingDiscountID, AdmissionAcademicScholarshipDiscountID = :AdmissionAcademicScholarshipDiscountID, AdmissionPromotionalDiscountID = :AdmissionPromotionalDiscountID, AdmissionEntranceScholarshipDiscountID = :AdmissionEntranceScholarshipDiscountID, AdmissionVarsityDiscountID = :AdmissionVarsityDiscountID, AdmissionSTSDiscountID = :AdmissionSTSDiscountID, AdmissionStatus = :AdmissionStatus, AdmissionUpdate = :AdmissionUpdate, AdmissionSchoolOfOrigin = :AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution = :AdmissionTypeOfInstitution WHERE AdmissionID = :AdmissionID");
    
    
    if( $statement->execute(array(':AdmissionReferenceNum' => $Retrieve->AdmissionReferenceNum, ':AdmissionGradeLevelID' => $Retrieve->AdmissionGradeLevelID, ':AdmissionSectionID' => $Retrieve->AdmissionSectionID, ':AdmissionModeOfPaymentID' => $Retrieve->AdmissionModeOfPaymentID, ':AdmissionSiblingDiscountID' => $Retrieve->AdmissionSiblingDiscountID, ':AdmissionAcademicScholarshipDiscountID' => $Retrieve->AdmissionAcademicScholarshipDiscountID, ':AdmissionPromotionalDiscountID' => $Retrieve->AdmissionPromotionalDiscountID, ':AdmissionEntranceScholarshipDiscountID' => $Retrieve->AdmissionEntranceScholarshipDiscountID, ':AdmissionVarsityDiscountID' => $Retrieve->AdmissionVarsityDiscountID, ':AdmissionSTSDiscountID' => $Retrieve->AdmissionSTSDiscountID,':AdmissionStatus' => $Retrieve->AdmissionStatus,':AdmissionUpdate' => $Retrieve->AdmissionUpdate, ':AdmissionSchoolOfOrigin' => $Retrieve->AdmissionSchoolOfOrigin, ':AdmissionTypeOfInstitution' => $Retrieve->AdmissionTypeOfInstitution, ':AdmissionID' => $Retrieve->EditProfileAdmissionID      ))  )
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("DELETE FROM tblsibling WHERE SiblingMainStudentID = :SiblingMainStudentID");
    
    
    if( $statement->execute(array(':SiblingMainStudentID' => $Retrieve->EditStudentID     ))  )
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
     header("HTTP/1.0 403 Forbidden");
}
    



//Update Sibling List
  
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
    
    if($statement->execute(array(':SiblingID' => $LastSiblingIDInt, ':SiblingStudentID' => $SiblingIDInt, ':SiblingMainStudentID' => $Retrieve->EditStudentID ))) 
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
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}
 
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}








?>