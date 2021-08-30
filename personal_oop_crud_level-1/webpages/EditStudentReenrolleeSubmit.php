<?php 

session_start();
include 'DataBaseConnectionFile.php';

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


$AdmissionID = $_SESSION['EditStudentReenrolleeAdmissionID'];
$EditStudentID = $_SESSION['VSReenrolleeStudentID'];    

    

if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);

    
    
    if($Retrieve->SHSStrand == 0){
        unset($Retrieve->SHSStrand);
    }
    

    
    
    
    
    
if ($Retrieve->SiblingDiscount == 0){
    unset($Retrieve->SiblingDiscount);
        
}
    
if ($Retrieve->AcademicScholarshipDiscount == 0){
    unset($Retrieve->AcademicScholarshipDiscount);
        
}
    
if ($Retrieve->PromotionalDiscount == 0){
    unset($Retrieve->PromotionalDiscount);
        
}

if ($Retrieve->EntranceScholarshipDiscount == 0){
    unset($Retrieve->EntranceScholarshipDiscount);
        
}
    
if ($Retrieve->VarsityDiscount == 0){
    unset($Retrieve->VarsityDiscount);
        
}
    
if ($Retrieve->STSDiscount == 0){
    unset($Retrieve->STSDiscount);
        
}
    
    
    
if ($Retrieve->EmployeeDiscount == 0){
    unset($Retrieve->EmployeeDiscount);
        
}
    
if ($Retrieve->BOTDiscount == 0){
    unset($Retrieve->BOTDiscount);
        
}
    
    
if ($Retrieve->ESCDiscount == 0){
    unset($Retrieve->ESCDiscount);
        
}
    

if ($Retrieve->QVRDiscount == 0){
    unset($Retrieve->QVRDiscount);
        
}
    
if ($Retrieve->AdmissionStatus == 0){
    unset($Retrieve->AdmissionStatus);
        
}
    
if ($Retrieve->AdmissionUpdate == 0){
    unset($Retrieve->AdmissionUpdate);
        
}
    
if (is_null($Retrieve->ESCNumber)){
    unset($Retrieve->ESCNumber);
        
}
    
if (is_null($Retrieve->QVRNumber)){
    unset($Retrieve->QVRNumber);
        
}
    
if (is_null($Retrieve->VarsityDiscountAmount)){
    unset($Retrieve->VarsityDiscountAmount);
        
}
    
    
if (is_null($Retrieve->BOTDiscountAmount)){
    unset($Retrieve->BOTDiscountAmount);
        
}
    
//Update Student data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudent SET StudentIDDisplay = :StudentIDDisplay, LRNNumber = :LRNNumber, LastName = :LastName, FirstName = :FirstName, MiddleName = :MiddleName, StudentGender = :StudentGender, StudentNationalityID = :StudentNationalityID, StudentBirthday = :StudentBirthday, PlaceOfBirth = :PlaceOfBirth, StudentReligionID = :StudentReligionID, FatherFullName = :FatherFullName, FatherOccupation = :FatherOccupation, MotherFullName = :MotherFullName, MotherOccupation = :MotherOccupation, AddressPrefix = :AddressPrefix, StudentBarangay = :StudentBarangay, StudentMunicipalityID = :StudentMunicipalityID, StudentProvinceID = :StudentProvinceID, HomeNumber = :HomeNumber, MobileNumber = :MobileNumber, ContactPerson = :ContactPerson, EmailAddress = :EmailAddress, RelationshipToContactPerson = :RelationshipToContactPerson, ContactPersonContactNumber = :ContactPersonContactNumber, StudentAge = :StudentAge, StudentStrand = :StudentStrand, ESCNumber= :ESCNumber, QVRNumber= :QVRNumber  WHERE StudentID = :StudentID     ");
   
    
    
     
    if ($statement->execute(array(':StudentIDDisplay' => $Retrieve->StudentIDDisplay , ':LRNNumber' => $Retrieve->LRNNumber, ':LastName' => $Retrieve->LastName, ':FirstName' => $Retrieve->FirstName, ':MiddleName' => $Retrieve->MiddleName, ':StudentGender' => $Retrieve->Gender, ':StudentNationalityID' => $Retrieve->StudentNationalityID, ':StudentBirthday' => $Retrieve->StudentBirthday, ':PlaceOfBirth' => $Retrieve->PlaceOfBirth, ':StudentReligionID' => $Retrieve->StudentReligionID , ':FatherFullName' => $Retrieve->FatherFullName, ':FatherOccupation' => $Retrieve->FatherOccupation, ':MotherFullName' => $Retrieve->MotherFullName, ':MotherOccupation' => $Retrieve->MotherOccupation, ':AddressPrefix' => $Retrieve->AddressPrefix, ':StudentBarangay' => $Retrieve->StudentBarangay, ':StudentMunicipalityID' => $Retrieve->StudentMunicipalityID, ':StudentProvinceID' => $Retrieve->StudentProvinceID, ':HomeNumber' => $Retrieve->HomeNumber, ':MobileNumber' => $Retrieve->MobileNumber, ':ContactPerson' => $Retrieve->ContactPerson, ':EmailAddress' => $Retrieve->EmailAddress, ':RelationshipToContactPerson' => $Retrieve->RelationshipToContactPerson, ':ContactPersonContactNumber' => $Retrieve->ContactPersonContactNumber, ':StudentAge' => $Retrieve->StudentAge, ':StudentStrand' => $Retrieve->SHSStrand, ':ESCNumber' => $Retrieve->ESCNumber, ':QVRNumber' => $Retrieve->QVRNumber, ':StudentID' => $EditStudentID  ))             )
{
  // success
    echo 'successfully updated';
    echo '<br>';
    echo $EditStudentID;

    
}
else
{
   header("HTTP/1.0 403 Forbidden");
}



//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudent", ':TableID' => $EditStudentID, ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "UPDATED OLD STUDENT PERSONAL RECORD" ))  )
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
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
//Update Interview Date
try
{
   
        
          
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET InterviewDate = :InterviewDate, AdmissionSchoolOfOrigin = :AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution = :AdmissionTypeOfInstitution, AdmissionGradeLevelID = :AdmissionGradeLevelID,  AdmissionSiblingDiscountID = :AdmissionSiblingDiscountID, 	AdmissionAcademicScholarshipDiscountID = :AdmissionAcademicScholarshipDiscountID, AdmissionPromotionalDiscountID =  :AdmissionPromotionalDiscountID, AdmissionEntranceScholarshipDiscountID = :AdmissionEntranceScholarshipDiscountID, AdmissionVarsityDiscountID = :AdmissionVarsityDiscountID, AdmissionSTSDiscountID = :AdmissionSTSDiscountID, 	ESCDiscount = :ESCDiscount, QVRDiscount = :QVRDiscount, OtherDiscount = :OtherDiscount, AdmissionEmployeeDiscountID = :AdmissionEmployeeDiscountID, AdmissionBOTDiscountID = :AdmissionBOTDiscountID, AdmissionVarsityDiscountAmount = :AdmissionVarsityDiscountAmount, AdmissionBOTDiscountAmount = :AdmissionBOTDiscountAmount, AdmissionStatus = :AdmissionStatus, AdmissionUpdate = :AdmissionUpdate WHERE AdmissionID = :AdmissionID ");
    
    
    if( $statement->execute(array(':InterviewDate' => $Retrieve->InterviewDateInsert, ':AdmissionSchoolOfOrigin' => $Retrieve->AdmissionSchoolOfOrigin,':AdmissionTypeOfInstitution' => $Retrieve->AdmissionTypeOfInstitution, ':AdmissionGradeLevelID' => $Retrieve->IncomingGradeLevel, ':AdmissionSiblingDiscountID' => $Retrieve->SiblingDiscount, ':AdmissionAcademicScholarshipDiscountID' => $Retrieve->AcademicScholarshipDiscount, ':AdmissionPromotionalDiscountID' => $Retrieve->PromotionalDiscount,  ':AdmissionEntranceScholarshipDiscountID' => $Retrieve->EntranceScholarshipDiscount,  ':AdmissionVarsityDiscountID' => $Retrieve->VarsityDiscount, ':AdmissionSTSDiscountID' => $Retrieve->STSDiscount, ':ESCDiscount' => $Retrieve->ESCDiscount, ':QVRDiscount' => $Retrieve->QVRDiscount, ':OtherDiscount' => $Retrieve->OtherDiscount, ':AdmissionEmployeeDiscountID' => $Retrieve->EmployeeDiscount, ':AdmissionBOTDiscountID' => $Retrieve->BOTDiscount, ':AdmissionVarsityDiscountAmount' => $Retrieve->VarsityDiscountAmount, ':AdmissionBOTDiscountAmount' => $Retrieve->BOTDiscountAmount,':AdmissionStatus' => $Retrieve->AdmissionStatus,':AdmissionUpdate' => $Retrieve->AdmissionUpdate, ':AdmissionID' => $AdmissionID ))  )
    {
        
        echo $Retrieve->InterviewDateInsert;
         
    }
    else{
       echo "error in admission";
       header("HTTP/1.0 403 Forbidden");
    }
    
  
    
    
    
    
    
//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudentadmission", ':TableID' => $AdmissionID, ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "UPDATED OLD STUDENT DISCOUNTS" ))  )
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
   
  

    

    
    

try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("DELETE FROM tblsibling WHERE SiblingTableAdmissionID = :SiblingTableAdmissionID");
    if ($statement->execute(array(':SiblingTableAdmissionID' => $AdmissionID))  ){
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
    
    if($statement->execute(array(':SiblingStudentID' => $SiblingIDInt, ':SiblingMainStudentID' => $EditStudentID, ':SiblingTableAdmissionID' => $AdmissionID  ))) 
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
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
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
    
   


?>