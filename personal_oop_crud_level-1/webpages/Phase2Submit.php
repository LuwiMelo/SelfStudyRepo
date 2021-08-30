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


if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);

    
 $Phase2AdmissionID = $_SESSION['Phase2AdmissionID'];
 $Phase2StudentID = $_SESSION['InterviewFormStudentID'];
    
    
    
    
if ($Retrieve->FinalStrand == 0){
    unset($Retrieve->FinalStrand);
        
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
    
if ($Retrieve->ESCDiscount == 0){
    unset($Retrieve->ESCDiscount);
        
}
    

if ($Retrieve->QVRDiscount == 0){
    unset($Retrieve->QVRDiscount);
        
}
    
    
if ($Retrieve->EmployeeDiscount == 0){
    unset($Retrieve->EmployeeDiscount);
        
}
    
if ($Retrieve->BOTDiscount == 0){
    unset($Retrieve->BOTDiscount);
        
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
    
    
//Insert New Admission Phase 2 Data into database
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("INSERT INTO tbladmissionphase2 (AdmissionStudentAdmissionID,AdmissionPhase2StudentNickname,PersonalInfoRemarks,FacebookMessenger,FamilyBackgroundRemarks,ExtendedFamilyBackgroundRemarks, AcademicStrengths, AcademicWeaknesses, RecognitionReceived, OtherInterests, SpecialNeeds, SeriousDisciplinaryCase, ConcernsForTransfer, ReasonsForTransfer, WhoDecidesTheTransfer, EducationalBackgroundRemarks, ChurchName, ChurchLocation, ChurchEngagement, SchoolRelatedClubs, OtherOrgInvolvement, OrganizationsRemarks, RateOfGeneralHealth, 	HearingCondition, EyesightCondition, Allergies, OtherHealthConcerns, HealthCategoryRemarks, ServicesOfInterests, AncillaryRemarks) VALUES (:AdmissionStudentAdmissionID, :AdmissionPhase2StudentNickname, :PersonalInfoRemarks, :FacebookMessenger, :FamilyBackgroundRemarks, :ExtendedFamilyBackgroundRemarks, :AcademicStrengths, :AcademicWeaknesses, :RecognitionReceived, :OtherInterests, :SpecialNeeds, :SeriousDisciplinaryCase, :ConcernsForTransfer, :ReasonsForTransfer, :WhoDecidesTheTransfer, :EducationalBackgroundRemarks, :ChurchName, :ChurchLocation, :ChurchEngagement, :SchoolRelatedClubs, :OtherOrgInvolvement, :OrganizationsRemarks, :RateOfGeneralHealth, 	:HearingCondition, :EyesightCondition, :Allergies, :OtherHealthConcerns, :HealthCategoryRemarks, :ServicesOfInterests, :AncillaryRemarks   )");
   
    
    if ($statement->execute(array(':AdmissionStudentAdmissionID' => $Phase2AdmissionID , ':AdmissionPhase2StudentNickname' => $Retrieve->Phase2Nickname, ':PersonalInfoRemarks' => $Retrieve->Phase2PersonalInfoRemarks, ':FacebookMessenger' => $Retrieve->Phase2FacebookMessenger, ':FamilyBackgroundRemarks' => $Retrieve->FamilyBackgroundRemarks, ':ExtendedFamilyBackgroundRemarks' => $Retrieve->ExtendedFamilyBackgroundRemarks, ':AcademicStrengths' => $Retrieve->AcademicStrengths, ':AcademicWeaknesses' => $Retrieve->AcademicWeaknesses, ':RecognitionReceived' => $Retrieve->RecognitionsReceived, ':OtherInterests' => $Retrieve->OtherInterests, ':SpecialNeeds' => $Retrieve->SpecialNeeds, ':SeriousDisciplinaryCase' => $Retrieve->DisciplinaryCase, ':ConcernsForTransfer' => $Retrieve->ConcernsForTransfer, ':ReasonsForTransfer' => $Retrieve->ReasonsForChoosing, ':WhoDecidesTheTransfer' => $Retrieve->WhoDecides, ':EducationalBackgroundRemarks' => $Retrieve->EducBackgroundRemarks, ':ChurchName' => $Retrieve->ChurchName, ':ChurchLocation' => $Retrieve->ChurchLocation, ':ChurchEngagement' => $Retrieve->ChurchEngagement, ':SchoolRelatedClubs' => $Retrieve->SchoolClubs,  ':OtherOrgInvolvement' => $Retrieve->OtherOrg, ':OrganizationsRemarks' => $Retrieve->OrgBackgroundRemarks,  ':RateOfGeneralHealth' => $Retrieve->RateOfGeneralHealth,  ':HearingCondition' => $Retrieve->HearingCondition, ':EyesightCondition' => $Retrieve->EyesightCondition,  ':Allergies' => $Retrieve->Allergies, ':OtherHealthConcerns' => $Retrieve->OtherHealthConcerns, ':HealthCategoryRemarks' => $Retrieve->HealthBackgroundRemarks, ':ServicesOfInterests' => $Retrieve->ServicesOfInterest,  ':AncillaryRemarks' => $Retrieve->AncillaryRemarks  ))             )
{
  // success
}
else
{
    
   //header("HTTP/1.0 403 Forbidden");
}
    
    
  
}
catch (PDOException $e)
{
   // echo "There is some problem in connection: " . $e->getMessage();
    //$QuerySuccessIndicator = false;
    //header("HTTP/1.0 403 Forbidden");
}
    

    
    
$LastAdmissionPhase2ID = $dbh->lastInsertId();
    
    

//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tbladmissionphase2", ':TableID' => $LastAdmissionPhase2ID, ':TableAction' => "INSERT", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'], ':AuditDetails' => "CREATED INTERVIEW  RESULT" ))  )
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
  
    
    
    
    
    
    
    
//Update tblstudent data
    
    
//$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudent SET HomeNumber = :HomeNumber, MobileNumber = :MobileNumber, FatherFullName = :FatherFullName, FatherAge = :FatherAge, FatherReligionID = :FatherReligion, FatherOccupation = :FatherOccupation, FatherCompanyName = :FatherCompany, FatherCompanyLocation = :FatherCompanyLocation, FatherEducAttainment = :FatherEducAttainment, FatherSupportEduc = :FatherSupport, MotherFullName = :MotherFullName, MotherAge = :MotherAge, MotherReligionID = :MotherReligion, MotherOccupation = :MotherOccupation, MotherCompanyName = :MotherCompany, MotherCompanyLocation = :MotherCompanyLocation, MotherEducAttainment = :MotherEducAttainment, MotherSupportEduc = :MotherSupport,ParentAddress = :ParentAddress, ParentStatus = :ParentStatus, ParentHomeNumber = :ParentHomeNumber, ParentMobileNumber = :ParentMobileNumber, FatherMessenger = :FatherMessenger, MotherMessenger = :MotherMessenger, GuardianFullName = :GuardianFullName, GuardianMessenger = :GuardianMessenger, GuardianHomeNumber = :GuardianHomeNumber, GuardianMobileNumber = :GuardianMobileNumber, GuardianRelationship = :GuardianRelationship, GuardianCommitment = :GuardianCommitment, GuardianAddress = :GuardianAddress, StudentOrderOfBirth = :StudentOrderOfBirth, StudentStrand = :StudentStrand, ESCNumber = :ESCNumber, QVRNumber = :QVRNumber  WHERE StudentID = :StudentID     ");
   
    
    
     
    if ($statement->execute(array(':HomeNumber' => $Retrieve->Phase2HomeNumber , ':MobileNumber' => $Retrieve->Phase2MobileNumber, ':FatherFullName' => $Retrieve->FatherFullName, ':FatherAge' => $Retrieve->FatherAge,':FatherReligion' => $Retrieve->FatherReligion,':FatherOccupation' => $Retrieve->FatherOccupation,':FatherCompany' => $Retrieve->FatherCompany,':FatherCompanyLocation' => $Retrieve->FatherCompanyLocation,':FatherEducAttainment' => $Retrieve->FatherEducAttainment,':FatherSupport' => $Retrieve->FatherSupport, ':MotherFullName' => $Retrieve->MotherFullName, ':MotherAge' => $Retrieve->MotherAge,':MotherReligion' => $Retrieve->MotherReligion,':MotherOccupation' => $Retrieve->MotherOccupation,':MotherCompany' => $Retrieve->MotherCompany,':MotherCompanyLocation' => $Retrieve->MotherCompanyLocation,':MotherEducAttainment' => $Retrieve->MotherEducAttainment,':MotherSupport' => $Retrieve->MotherSupport, ':ParentAddress' => $Retrieve->ParentAddress, ':ParentStatus' => $Retrieve->ParentStatus, ':ParentHomeNumber' => $Retrieve->ParentHomeNum, ':ParentMobileNumber' => $Retrieve->ParentMobileNum, ':FatherMessenger' => $Retrieve->FatherFB, ':MotherMessenger' => $Retrieve->MotherFB, ':GuardianFullName' => $Retrieve->GuardianName, ':GuardianMessenger' => $Retrieve->GuardianMessenger, ':GuardianHomeNumber' => $Retrieve->GuardianHomeNumber,':GuardianMobileNumber' => $Retrieve->GuardianMobileNumber, ':GuardianRelationship' => $Retrieve->GuardianRelationship, ':GuardianCommitment' => $Retrieve->GuardianCommitment, ':GuardianAddress' => $Retrieve->GuardianAddress,':StudentOrderOfBirth' => $Retrieve->OrderOfBirth, ':StudentStrand' => $Retrieve->FinalStrand,':ESCNumber' => $Retrieve->ESCNumber, ':QVRNumber' => $Retrieve->QVRNumber, ':StudentID' => $Phase2StudentID  ))             )
{
  // success
    echo 'successfully updated';
    echo '<br>';
    //echo $EditStudentID;

    
}
else
{
   header("HTTP/1.0 403 Forbidden");
}
    
    
    
    
    
    
//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudent", ':TableID' => $Phase2StudentID, ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "UPDATED TRANSFEREE PERSONAL RECORD" ))  )
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
   
    
    
    
    
    
 $statement3 = $dbh->prepare("UPDATE tblstudentadmission SET AdmissionSiblingDiscountID = :AdmissionSiblingDiscountID, AdmissionAcademicScholarshipDiscountID = :AdmissionAcademicScholarshipDiscountID, AdmissionPromotionalDiscountID = :AdmissionPromotionalDiscountID, AdmissionEntranceScholarshipDiscountID = :AdmissionEntranceScholarshipDiscountID, AdmissionVarsityDiscountID = :AdmissionVarsityDiscountID, AdmissionSTSDiscountID = :AdmissionSTSDiscountID, ESCDiscount = :ESCDiscount, QVRDiscount = :QVRDiscount, OtherDiscount = :OtherDiscount, AdmissionEmployeeDiscountID = :AdmissionEmployeeDiscountID, AdmissionBOTDiscountID = :AdmissionBOTDiscountID, AdmissionVarsityDiscountAmount = :AdmissionVarsityDiscountAmount, AdmissionBOTDiscountAmount = :AdmissionBOTDiscountAmount WHERE AdmissionID = :AdmissionID     ");
   
    
    
     
if ($statement3->execute(array(':AdmissionSiblingDiscountID' => $Retrieve->SiblingDiscount , ':AdmissionAcademicScholarshipDiscountID' => $Retrieve->AcademicScholarshipDiscount , ':AdmissionPromotionalDiscountID' => $Retrieve->PromotionalDiscount , ':AdmissionEntranceScholarshipDiscountID' => $Retrieve->EntranceScholarshipDiscount , ':AdmissionVarsityDiscountID' => $Retrieve->VarsityDiscount , ':AdmissionSTSDiscountID' => $Retrieve->STSDiscount, ':ESCDiscount' => $Retrieve->ESCDiscount, ':QVRDiscount' => $Retrieve->QVRDiscount, ':OtherDiscount' => $Retrieve->OtherDiscount , ':AdmissionEmployeeDiscountID' => $Retrieve->EmployeeDiscount, ':AdmissionBOTDiscountID' => $Retrieve->BOTDiscount, ':AdmissionVarsityDiscountAmount' => $Retrieve->VarsityDiscountAmount, ':AdmissionBOTDiscountAmount' => $Retrieve->BOTDiscountAmount, ':AdmissionID' => $Phase2AdmissionID  ))             )
{
  // success
    echo 'successfully updated';
    echo '<br>';
    //echo $EditStudentID;

    
}
else
{
   header("HTTP/1.0 403 Forbidden");
}
    
    
    

        
//Insert Audit Trail
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblaudittrail(TableName,TableID,TableAction,DateTime,TableUserID,AuditDetails) VALUES (:TableName,:TableID,:TableAction,:DateTime,:TableUserID,:AuditDetails)");
    
    
    if( $statement->execute(array(':TableName' => "tblstudentadmission", ':TableID' => $Phase2AdmissionID, ':TableAction' => "UPDATE", ':DateTime' => $DateToday,':TableUserID' => $_SESSION['SessionUserID'],':AuditDetails' => "CREATED STUDENT ADMISSION DISCOUNTS" ))  )
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
    if ($statement->execute(array(':SiblingTableAdmissionID' => $Phase2AdmissionID))  ){
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
    
    if($statement->execute(array(':SiblingStudentID' => $SiblingIDInt, ':SiblingMainStudentID' => $Phase2StudentID, ':SiblingTableAdmissionID' => $Phase2AdmissionID  ))) 
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
    
    

    
    
//Insert Siblings Outside IUCS
if(isset($Retrieve->ExternalSiblingsDetails)){




    
 $TotalExternalSiblings = count($Retrieve->ExternalSiblingsDetails);

    
 //$LastSiblingIDInt = (int)$LastSiblingID2;
    

for ($x = 0; $x < $TotalExternalSiblings; $x++){
    
  //$SiblingIDInt = (int)$Retrieve->StudentSiblings[$x];
  //echo $SiblingIDInt;
    
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblsibling (SiblingMainStudentID,ExternalSiblingName,ExternalSiblingSchool,ExternalSiblingStatus,ExternalSiblingEducationalLevel,SiblingTableAdmissionID) VALUES (:SiblingMainStudentID, :ExternalSiblingName, :ExternalSiblingSchool, :ExternalSiblingStatus, :ExternalSiblingEducationalLevel, :SiblingTableAdmissionID )");
    
    
    //ech (string)$Retrieve->StudentSiblings[$x];
  
   // echo $SiblingIDInt;
    
    if($statement->execute(array( ':SiblingMainStudentID' => $Phase2StudentID, ':ExternalSiblingName' => $Retrieve->ExternalSiblingsDetails[$x]->ExternalSiblingName, ':ExternalSiblingSchool' => $Retrieve->ExternalSiblingsDetails[$x]->ExternalSiblingSchool, ':ExternalSiblingStatus' => $Retrieve->ExternalSiblingsDetails[$x]->ExternalSiblingStatus, ':ExternalSiblingEducationalLevel' => $Retrieve->ExternalSiblingsDetails[$x]->ExternalSiblingEduc, ':SiblingTableAdmissionID' => $Phase2AdmissionID  ))) 
    {
        
        
    }
    
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
   // $LastSiblingIDInt++;

  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
   
    
    
    
}
    
    
    
    
    
    
    

 
    
    
    
    

}//End of insert external siblings
    
    
    
    
    
    
    
//Insert Other Schools Attended
if(isset($Retrieve->OtherSchoolsAttended)){


 $TotalOSA = count($Retrieve->OtherSchoolsAttended);

    
 //$LastOSAIDInt = (int)$LastOSAID;
    

for ($x = 0; $x < $TotalOSA; $x++){
    
  //$SiblingIDInt = (int)$Retrieve->StudentSiblings[$x];
  //echo $SiblingIDInt;
    
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblotherschoolsattended (NameOfSchool,	SchoolLocation,YearAttended,SchoolTypeOfInstitution,HighestEducLevel,OSAAdmissionPhase2ID) VALUES (:NameOfSchool, :SchoolLocation, :YearAttended, :SchoolTypeOfInstitution, :HighestEducLevel, :OSAAdmissionPhase2ID )");
    
    
    //ech (string)$Retrieve->StudentSiblings[$x];
  
   // echo $SiblingIDInt;
    
    if($statement->execute(array(':NameOfSchool' => $Retrieve->OtherSchoolsAttended[$x]->SchoolName, ':SchoolLocation' => $Retrieve->OtherSchoolsAttended[$x]->SchoolLocation, ':YearAttended' => $Retrieve->OtherSchoolsAttended[$x]->YearAttended, ':SchoolTypeOfInstitution' => $Retrieve->OtherSchoolsAttended[$x]->SchoolTypeOfInstitution, ':HighestEducLevel' => $Retrieve->OtherSchoolsAttended[$x]->HighestEduc, ':OSAAdmissionPhase2ID' => $LastAdmissionPhase2ID  ))) 
    {
        
        
    }
    
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
    //$LastOSAIDInt++;

  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
   
    
    
    
}
    
    
    
    
    
}//End of insert other schools attended
    
    
    
    
    
    
    
    
    
    
    
    
    
//Insert Referrals
if(isset($Retrieve->Referrals)){


 $TotalReferrals = count($Retrieve->Referrals);

    
 //$LastReferralIDInt = (int)$LastReferralID;
    

for ($x = 0; $x < $TotalReferrals; $x++){
    
  //$SiblingIDInt = (int)$Retrieve->StudentSiblings[$x];
  //echo $SiblingIDInt;
    
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblenrollmentreferrals (NameWhoRefer,Relationship, ReferralAdmissionPhase2ID) VALUES (:NameWhoRefer, :Relationship, :ReferralAdmissionPhase2ID)");
    
    
    //ech (string)$Retrieve->StudentSiblings[$x];
  
   // echo $SiblingIDInt;
    
    if($statement->execute(array(':NameWhoRefer' => $Retrieve->Referrals[$x]->ReferredBy, ':Relationship' => $Retrieve->Referrals[$x]->Relationship, ':ReferralAdmissionPhase2ID' => $LastAdmissionPhase2ID  ))) 
    {
        
        
    }
    
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
    //$LastReferralIDInt++;

  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
   
    
    
    
}
    
    
    
    
    
}//End of insert other schools attended
    
    
    

    
    
    
    
    
    
    
//Insert Exclusive Relationship
if(isset($Retrieve->ExclusiveRelationship)){


 $TotalExclusiveRelationship = count($Retrieve->ExclusiveRelationship);

    
 //$LastERIDInt = (int)$LastERID;
    

for ($x = 0; $x < $TotalExclusiveRelationship; $x++){
    
  //$SiblingIDInt = (int)$Retrieve->StudentSiblings[$x];
  //echo $SiblingIDInt;
    
try
{
    
    $statement = $dbh->prepare("INSERT INTO tblexclusiverelationship (RelationshipToWhom,Relationship,ERAdmissionPhase2ID) VALUES (:RelationshipToWhom, :Relationship, :ERAdmissionPhase2ID)");
    
    
    //ech (string)$Retrieve->StudentSiblings[$x];
  
   // echo $SiblingIDInt;
    
    if($statement->execute(array(':RelationshipToWhom' => $Retrieve->ExclusiveRelationship[$x]->RelationshipToWhom, ':Relationship' => $Retrieve->ExclusiveRelationship[$x]->Relationship, ':ERAdmissionPhase2ID' => $LastAdmissionPhase2ID ))) 
    {
        
        
    }
    
    else{
        header("HTTP/1.0 403 Forbidden");
    }
    
    $LastERIDInt++;

  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
}  
   
    
    
    
}
    
    
    
    
    
}//End of insert exclusive relationship
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
    
   


?>