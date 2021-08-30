<?php 


//Code For User Authentication For Each Web Page


session_start();

include 'DataBaseConnectionFile.php';

include 'adminheader.php';

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
*/


$StudentID = $_SESSION['ViewInterviewFormStudentID'];
$AdmissionID;

$AdmissionIDRetrieve = $_SESSION['VIFAdmissionID'];


//$_SESSION['InterviewFormStudentID'] = $StudentID;


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
   
       $LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


$LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
$LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];



//Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblstudent WHERE StudentID = :StudentID");
    $statement->execute(array(':StudentID' => $StudentID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
              $_SESSION['UpdateInterviewResultStudentID'] = $StudentID;
              $RetrieveStudentIDDisplay = $row['StudentIDDisplay'];
              $_SESSION['EditStudentSelectedStudentIDDisplay'] = $RetrieveStudentIDDisplay;
              $RetrieveESCNumber = $row['ESCNumber'];
              $RetrieveQVRNumber = $row['QVRNumber'];
              $RetrieveLRNNumber = $row['LRNNumber'];
              $RetrieveFirstName = $row['FirstName'];
              $RetrieveMiddleName = $row['MiddleName'];
              $RetrieveLastName = $row['LastName'];
              $RetrieveGender = $row['StudentGender'];
              $RetrieveNationality = $row['StudentNationalityID'];
              $RetrieveBirthday = $row['StudentBirthday'];
              $RetrievePlaceOfBirth = $row['PlaceOfBirth'];
              $RetrieveReligion = $row['StudentReligionID'];
              $RetrieveMotherFullName = $row['MotherFullName'];
              $RetrieveFatherFullName = $row['FatherFullName'];
              $RetrieveMotherOccupation = $row['MotherOccupation'];
              $RetrieveFatherOccupation = $row['FatherOccupation'];
              $RetrieveAddressPrefix = $row['AddressPrefix'];
              $RetrieveBarangay = $row['StudentBarangay'];
              $RetrieveMunicipality = $row['StudentMunicipalityID'];
              $RetrieveProvince = $row['StudentProvinceID'];
              $RetrieveHomeNumber = $row['HomeNumber'];
              $RetrieveMobileNumber = $row['MobileNumber'];
              $RetrieveContactPerson = $row['ContactPerson'];
              $RetrieveRelationshipToContactPerson = $row['RelationshipToContactPerson'];
              $RetrieveContactPersonContactNumber = $row['ContactPersonContactNumber'];
              $RetrieveEmailAddress= $row['EmailAddress'];
              $RetrieveESCNumber = $row['ESCNumber'];
              $RetrieveStrand = $row['StudentStrand'];
              $RetrieveAge = $row['StudentAge'];
              $AddressPrefix = $row['AddressPrefix'];
              $MunicipalityID = $row['StudentMunicipalityID'];
              $ProvinceID = $row['StudentProvinceID'];
        
              //Phase 2 Results
              $FatherAge = $row['FatherAge'];
              $FatherReligionID = $row['FatherReligionID'];
              $FatherCompanyName = $row['FatherCompanyName'];
              $FatherCompanyLocation = $row['FatherCompanyLocation'];
              $FatherEducAttainment = $row['FatherEducAttainment'];
              $FatherSupportEduc = $row['FatherSupportEduc'];
         
              $MotherAge = $row['MotherAge'];
              $MotherReligionID = $row['MotherReligionID'];
              $MotherCompanyName = $row['MotherCompanyName'];
              $MotherCompanyLocation = $row['MotherCompanyLocation'];
              $MotherEducAttainment = $row['MotherEducAttainment'];
              $MotherSupportEduc = $row['MotherSupportEduc'];
              
              $ParentAddress = $row['ParentAddress'];
              $ParentStatus = $row['ParentStatus'];
              $ParentHomeNumber = $row['ParentHomeNumber'];
              $ParentMobileNumber = $row['ParentMobileNumber'];
              $FatherMessenger = $row['FatherMessenger'];
              $MotherMessenger = $row['MotherMessenger'];
              
              $GuardianFullName = $row['GuardianFullName'];
              $GuardianMessenger = $row['GuardianMessenger'];
              $GuardianHomeNumber = $row['GuardianHomeNumber'];
              $GuardianMobileNumber = $row['GuardianMobileNumber'];
              $GuardianRelationship = $row['GuardianRelationship'];
              $GuardianCommitment = $row['GuardianCommitment'];
              $GuardianAddress = $row['GuardianAddress'];
        
              $StudentOrderOfBirth = $row['StudentOrderOfBirth'];
              
        
        
        
        
            
              
        
    } 
    else {
   
       echo '<h1>Error in selecting from databaseselect from studenttable </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
  



//Get the municipality name
try
{
   // $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT MunicipalityName FROM tblmunicipality WHERE MunicipalityID = $MunicipalityID");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $MunicipalityName =  $row['MunicipalityName'];
          
    } 
    else {
   
       //$LatestSchoolYear = "";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//Get the province name
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("SELECT ProvinceName FROM tblprovince WHERE ProvinceID = $ProvinceID");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $ProvinceName =  $row['ProvinceName'];
          
    } 
    else {
   
       //$LatestSchoolYear = "";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


$AddressOfResidence = $AddressPrefix.' '.$MunicipalityName.' '.$ProvinceName;



//Get the latest admission record
try
{
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID AND AdmissionID = :AdmissionID ");
    $statement->execute(array(':AdmissionStudentID' => $StudentID, ':AdmissionID' => $AdmissionIDRetrieve      ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              //$RetrieveStudentIDDisplay = $data['StudentIDDisplay'];
              //$RetrieveAdmissionID = $data['AdmissionID'];
              //$_SESSION['EditStudentAdmissionNumber'] = $data['AdmissionID'];
            //  $RetrieveReferenceNumber = $data['AdmissionReferenceNum'];
             // $_SESSION['EditStudentSelectedReferenceNum'] = $RetrieveReferenceNumber;
              //$RetrieveSectionID = $data['AdmissionSectionID'];
              //$RetrieveModeOfPaymentID = $data['AdmissionModeOfPaymentID'];
              $RetrieveSiblingDiscountID = $data['AdmissionSiblingDiscountID'];
              $RetrieveAcademicScholarshipDiscountID = $data['AdmissionAcademicScholarshipDiscountID'];
              $RetrievePromotionalDiscountID = $data['AdmissionPromotionalDiscountID'];
              $RetrieveEntranceScholarshipDiscountID = $data['AdmissionEntranceScholarshipDiscountID'];
              $RetrieveVarsityDiscountID = $data['AdmissionVarsityDiscountID'];
			  $RetrieveSTSDiscountID = $data['AdmissionSTSDiscountID'];
              //$RetrieveGradeLevelID = $data['AdmissionGradeLevelID'];
              //$RetrieveAdmissionStatus = $data['AdmissionStatus'];
              $_SESSION['Phase2AdmissionIDEdit'] = $data['AdmissionID'];
              $_SESSION['UpdateInterviewResultAdmissionID'] = $data['AdmissionID'];
              $RetrieveGradeLevel = $data['AdmissionGradeLevelID'];
              $RetrieveSchoolOfOrigin = $data['AdmissionSchoolOfOrigin'];
              $RetrieveTypeOfInstitution = $data['AdmissionTypeOfInstitution'];
              $RetrieveInterviewDate = $data['InterviewDate'];
              $RetrieveESCDiscount = $data['ESCDiscount'];
              $RetrieveQVRDiscount = $data['QVRDiscount'];
              $RetrieveOtherDiscount = $data['OtherDiscount'];
              $RetrieveEmployeeDiscount = $data['AdmissionEmployeeDiscountID'];
              $RetrieveBOTDiscount = $data['AdmissionBOTDiscountID'];
              $RetrieveVarsityDiscountAmount = $data['AdmissionVarsityDiscountAmount'];
              $RetrieveBOTDiscountAmount = $data['AdmissionBOTDiscountAmount'];
        }
    } 
    else {
   
       echo '<h1>Error in selecting from database select from admission table </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//Get student admission phase 2 record
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbladmissionphase2 WHERE AdmissionStudentAdmissionID = :AdmissionStudentAdmissionID");
    $statement->execute(array(':AdmissionStudentAdmissionID' => $_SESSION['Phase2AdmissionIDEdit']));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
              $RetrievePhase2ID = $row['AdmissionPhase2ID'];
              $_SESSION['UpdateInterviewResultAdmissionPhase2ID'] = $RetrievePhase2ID;
              $RetrieveStudentNickname = $row['AdmissionPhase2StudentNickname'];
              $RetrieveStudentMessenger = $row['FacebookMessenger'];
              $RetrievePersonalInfoRemarks = $row['PersonalInfoRemarks'];
              $RetrieveFamilyBackgroundRemarks = $row['FamilyBackgroundRemarks'];
              $ExtendedFamilyBackgroundRemarks = $row['ExtendedFamilyBackgroundRemarks'];
              $AcademicStrengths = $row['AcademicStrengths'];
              $AcademicWeaknesses = $row['AcademicWeaknesses'];
              $RecognitionReceived = $row['RecognitionReceived'];
              $OtherInterests = $row['OtherInterests'];
              $SpecialNeeds	= $row['SpecialNeeds'];
              $SeriousDisciplinaryCase = $row['SeriousDisciplinaryCase'];
              $ConcernsForTransfer = $row['ConcernsForTransfer'];
              $ReasonsForTransfer = $row['ReasonsForTransfer'];
              $WhoDecidesTheTransfer = $row['WhoDecidesTheTransfer'];
              $EducationalBackgroundRemarks = $row['EducationalBackgroundRemarks'];  
              $ChurchName = $row['ChurchName'];
              $ChurchLocation = $row['ChurchLocation'];
              $ChurchEngagement = $row['ChurchEngagement'];
              $SchoolRelatedClubs = $row['SchoolRelatedClubs'];
              $OtherOrgInvolvement = $row['OtherOrgInvolvement'];
              $OrganizationsRemarks = $row['OrganizationsRemarks'];
              $RateOfGeneralHealth = $row['RateOfGeneralHealth'];
              $HearingCondition = $row['HearingCondition'];
              $EyesightCondition = $row['EyesightCondition'];
              $Allergies = $row['Allergies'];
              $OtherHealthConcerns = $row['OtherHealthConcerns'];
              $HealthCategoryRemarks = $row['HealthCategoryRemarks'];
              $ServicesOfInterests = $row['ServicesOfInterests'];
              $AncillaryRemarks = $row['AncillaryRemarks'];
              
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}







$InternalSiblingList = [];

//Get the internal siblings
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblsibling WHERE SiblingMainStudentID = :SiblingMainStudentID AND SiblingTableAdmissionID = :SiblingTableAdmissionID ");
    $statement->execute(array(':SiblingMainStudentID' => $StudentID, ':SiblingTableAdmissionID' => $_SESSION['Phase2AdmissionIDEdit'] ));
    $row = $statement->fetchAll();
    
    
    $x = 0; 
    
    if (!empty($row)) {
        
        
        foreach($row as $data){
            
              $InternalSiblingList[$x] = $data['SiblingStudentID'];
              $x++;
        }
    } 
    else {
   
       //echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}






$InternalSiblingsCount = count($InternalSiblingList);

$InternalSiblingsCountInt = $InternalSiblingsCount;








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




//Check if there is exclusive relationship
$ERTableVisibility = ' style = " display: none; " ';
$CheckIndicator = false;

try
{
    $statement = $dbh->prepare("SELECT * FROM tblexclusiverelationship WHERE ERAdmissionPhase2ID = :ERAdmissionPhase2ID    ");
    $statement->execute(array(':ERAdmissionPhase2ID' => $RetrievePhase2ID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $ERTableVisibility = "";
          $CheckIndicator = true;
          //$ERTableVisibility = ' style = " display: none; " ';
          
    } 
    else {
   
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
      <hr>
    <center>    <img  style="width: 800px; height: 150px;" src="phase1logo.png"> </center>
      <br>
 <center><h1>View Interview Result </h1></center>
      <br>
      <br>
    
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Student Personal Information</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
              
        
         
              <!--
                <div class="control-group">
              <label class="control-label">*Student ID :</label>
              <div class="controls">
                <input type="text" disabled name="StudentID" id="StudentID" class="span11" placeholder="e.g. 2014-000001" value=" />
                  
                <input type="hidden" name="StudentIDMainField" id="StudentIDMainField" >
              </div>
            </div>
              


              
            -->
        <div class="row-fluid">
		
		<!--
            <div class="span12">
                
                  <div class="span7" style="margin-left: -60px;">
                    <label class="control-label">*Type of Student:</label>
                    <div class="controls">
                            <select name="StudentType" id="StudentType" style="margin-left: -30px;">
                                <option value="0">New</option>
                                <option value="1">Old</option>
                
                            </select>
                    </div>
                      
                  </div>
            
            
                  <div class="span9" style="margin-left: -100px;" id="StudentIDControlGroup">
                    <label class="control-label">*Student #:</label>
                    <div class="controls">
                     <input type="text" style="width: 90px !important;" disabled name="StudentID" id="StudentID" style="margin-left: -20px;" placeholder="e.g. 2014-000001"  value=""/>
                     <button class="btn btn-info" type="button" id="LoadPreviousData"><i class="icon-repeat"></i></button>
                        
                    <span class="help-inline" style="color: #b94a48; display: none;" id="StudentIDError"  name="StudentIDError">Student ID already exists!</span> 
                        
                    <input type="hidden" name="StudentIDMainField" id="StudentIDMainField" >
                    </div>
            
                   </div>
                
          </div>
		  
		  -->
     </div>
              
                  
            <div class="control-group" id="Phase2NicknameControlGroup">
              <label class="control-label">Nickname:</label>
              <div class="controls">
                <input type="text" class="span11" name="Phase2Nickname" id="Phase2Nickname" placeholder="e.g. Junjun" value="<?php echo $RetrieveStudentNickname; ?>"  />
                <span class="help-inline" style="color: #b94a48; display: none;" id="Phase2NicknameError"  name="Phase2NicknameError">Invalid Nickname </span> 
              </div>
            </div>
            <div class="control-group" id="LastNameControlGroup">
              <label class="control-label">*Last Name :</label>
              <div class="controls">
                <input type="text" name="LastName" id="LastName" class="span11" placeholder="Last name" value="<?php echo $RetrieveLastName; ?>" disabled />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="LastNameError"  name="LastNameError">Invalid Last Name</span>
              </div>
            </div>
              
              <div class="control-group" id="FirstNameControlGroup">
              <label class="control-label">*First Name :</label>
              <div class="controls">
                <input type="text" name="FirstName" id="FirstName" class="span11" placeholder="First name"  value="<?php echo $RetrieveFirstName; ?>" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="FirstNameError"  name="FirstNameError">Invalid First Name</span>
              </div>
            </div>
              
              
              <div class="control-group" id="MiddleNameControlGroup">
              <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="MiddleName" id="MiddleName" class="span11" placeholder="Middle name" value="<?php echo $RetrieveMiddleName; ?>" disabled/>
                    <span class="help-inline" style="color: #b94a48; display: none;" id="MiddleNameError"  name="MiddleNameError">Invalid Middle Name</span>
              </div>
            </div>
              
                 <div class="control-group">
              <label class="control-label">*Grade Level</label>
              <div class="controls">
                <select name="Phase2GradeLevel" id="Phase2GradeLevel" disabled>
                     
                    <?php 
                                                        
                                                    
try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveGradeLevel == $data['GradeLevelID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected .'>' . $data['GradeLevel'] .'</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                
                </select>
              </div>
            </div>
              
              
              
              
              
              
              
              
              
              
              
                <div class="control-group">
              <label class="control-label">Strand for SHS Students</label>
              <div class="controls">
                <select name="Phase2Strand" id="Phase2Strand" disabled>
                     
<?php 
                                                        
                                                    
try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblstrand");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveGradeLevel == "14" || $RetrieveGradeLevel == "15" ){
                 
                if($RetrieveStrand == $data['StrandID']){
                    $selected = "selected";
                }
                else{
                    $selected = "";
                }
                
                  echo '<option value ="' . $data['StrandID'] . '" '. $selected .'>' . $data['StrandName'] .'</option>';
            }
            else{
                $selected = "";
                echo '<option value="0">Strands for SHS Only </option> ';
            }
         
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                
                </select>
              </div>
            </div>
              
              

        
                 <div class="control-group">
              <label class="control-label">*Nationality</label>
              <div class="controls">
                <select name="Nationality" id="Nationality" disabled>
                    <option value="0">Not set</option>
                     <?php 
                                                        
                                                        
try
{
 
       
    $statement = $dbh->prepare("SELECT * FROM tblnationality");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($data['NationalityID'] == $RetrieveNationality){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
              
           echo '<option value ="' . $data['NationalityID'] . '" '. $selected .'>' . $data['NationalityName'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }


}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                                                                                
                     ?> 
                </select>
              </div>
            </div>
              
                 <div class="control-group" id="BirthdayControlGroup">
              <label class="control-label">*Birthday</label>
              <div class="controls">
                <div  data-date="12-02-2012" class="input-append date datepicker">
                  <input type="text" name="Birthday" id="Birthday"  data-date-format="mm-dd-yyyy" class="span11"  value="<?php echo $RetrieveBirthday; ?>" disabled>
                   </div>
                    <span class="help-inline" style="color: #b94a48; display: none;" id="BirthdayError"  name="BirthdayError">Please enter a valid date</span>
              </div>
            </div>
              
              
              <div class="control-group" id="AgeControlGroup">
              <label class="control-label">Age :</label>
              <div class="controls">
                <input type="text" name="Age" id="Age" class="span11" placeholder="Age"  value="" disabled />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="AgeError"  name="AgeError">Invalid Age</span>
              </div>
            </div>
              
              
                 <div class="control-group" id="PlaceOfBirthControlGroup">
              <label class="control-label">Place of Birth</label>
              <div class="controls">
                <textarea disabled name="PlaceOfBirth" id="PlaceOfBirth" class="span11" ><?php echo $RetrievePlaceOfBirth; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="PlaceOfBirthError"  name="PlaceOfBirthError">Please enter place of birth </span>
              </div>
            </div>
              
              
                 <div class="control-group">
              <label class="control-label">*Religion</label>
              <div class="controls">
                <select name="Religion" id="Religion" disabled>
                     <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblreligion");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveReligion == $data['ReligionID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['ReligionID'] . '" '. $selected .'>' . $data['ReligionName'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                
                </select>
              </div>
            </div>
              
              
    
              <div class="control-group" id="AddressOfResidenceControlGroup">
              <label class="control-label">Address of Residence</label>
              <div class="controls">
                <textarea disabled name="AddressOfResidence" id="AddressOfResidence" class="span11" ><?php echo $AddressOfResidence; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="AddressOfResidenceError"  name="AddressOfResidenceError"> </span>
              </div>
            </div>
              
              
               <div class="control-group" id="Phase2HomeNumberControlGroup">
              <label class="control-label">Home Number:</label>
              <div class="controls">
                <input type="text" class="span11" name="Phase2HomeNumber" id="Phase2HomeNumber" placeholder="" value="<?php echo $RetrieveHomeNumber; ?>" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="Phase2HomeNumberError"  name="Phase2HomeNumberError">Invalid Home Number </span> 
              </div>
            </div>
            
              
              <div class="control-group" id="Phase2MobileNumberControlGroup">
              <label class="control-label">Mobile Number:</label>
              <div class="controls">
                <input type="text" class="span11" name="Phase2MobileNumber" id="Phase2MobileNumber" placeholder="" value="<?php echo $RetrieveMobileNumber; ?>" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="Phase2MobileNumberError"  name="Phase2MobileNumberError">Invalid Mobile Number </span> 
              </div>
            </div>
              
                  <div class="control-group" id="FacebookMessengerControlGroup">
              <label class="control-label">Facebook Messenger:</label>
              <div class="controls">
                <input type="text" class="span11" name="FacebookMessenger" id="FacebookMessenger"  value="<?php echo $RetrieveStudentMessenger; ?>" placeholder="" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="FacebookMessengerError"  name="FacebookMessengerError">Invalid Facebook Messenger </span> 
              </div>
            </div>
              
              
            <div class="control-group" id="PersonalInfoRemarksControlGroup">
              <label class="control-label">Personal Information Remarks</label>
              <div class="controls">
                <textarea  name="PersonalInfoRemarks" id="PersonalInfoRemarks" rows="5" class="span11" ><?php echo $RetrievePersonalInfoRemarks; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="PersonalInfoRemarksError"  name="PersonalInfoRemarksError"> </span>
              </div>
            </div>
              
              
              
              
              
          </form>
        </div>
      </div>
            
            
            
            
        </div>
        
        <!-- span 6 -->
        
        
        <!-- second span 6 -->
        
        
    <div class="span6">
        
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Family Background</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
          <h3><center>Father</center></h3>
              
                <div class="control-group">
              <label class="control-label">Father's Name :</label>
              <div class="controls">
                <input type="text" name="FatherFullName" id="FatherFullName" class="span11" placeholder="Father's Full Name" value="<?php echo $RetrieveFatherFullName; ?>" />
              </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">Father's Age :</label>
              <div class="controls">
                <input type="text" name="FatherAge" id="FatherAge" class="span11" placeholder="e.g. 45" value="<?php echo $FatherAge; ?>" />
              </div>
            </div>
              
              
              
<div class="control-group">
              <label class="control-label">Father's Religion</label>
              <div class="controls">
                <select name="FatherReligion" id="FatherReligion" >
            <?php 
                                                        
                                                        
try
{   
    $statement = $dbh->prepare("SELECT * FROM tblreligion");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($FatherReligionID == $data['ReligionID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['ReligionID'] . '" '. $selected .'>' . $data['ReligionName'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
                                   
                     ?> 
                
                </select>
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label">Occupation :</label>
              <div class="controls">
                <input type="text"  name="FatherOccupation" id="FatherOccupation" class="span11" placeholder="e.g. Doctor" value="<?php echo $RetrieveFatherOccupation; ?>" />
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label">Company Name :</label>
              <div class="controls">
                <input type="text"  name="FatherCompany" id="FatherCompany" class="span11" placeholder="e.g. Government" value="<?php echo $FatherCompanyName; ?>" />
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label">Company Location :</label>
              <div class="controls">
                <input type="text"  name="FatherCompanyLocation" id="FatherCompanyLocation" class="span11" placeholder="e.g. Imus Cavite" value="<?php echo $FatherCompanyLocation; ?>" />
              </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">Father's Educational Attainment</label>
              <div class="controls">
                <select name="FatherEducAttainment" id="FatherEducAttainment" >
                    <option value="1" <?php if($FatherEducAttainment == 1){ echo ' selected ';} else{ echo ''; } ?> >Under Graduate</option>
                    <option value="2" <?php if($FatherEducAttainment == 2){ echo ' selected ';} else{ echo ''; } ?>>High School Graduate</option>
                    <option value="3" <?php if($FatherEducAttainment == 3){ echo ' selected ';} else{ echo ''; } ?>>College Graduate</option>
                    <option value="4" <?php if($FatherEducAttainment == 4){ echo ' selected ';} else{ echo ''; } ?>>Masteral,Doctorate etc</option>
                </select>
              </div>
            </div>
              
              
            <div class="control-group">
              <label class="control-label">Support For Education:</label>
              <div class="controls">
                <input type="text"  name="FatherSupport" id="FatherSupport" class="span11" placeholder="" value="<?php echo  $FatherSupportEduc; ?>" />
              </div>
            </div>
          
              
              
              
               <h3><center>Mother</center></h3>
              
              
                  <div class="control-group">
              <label class="control-label">Mothers's Maiden Name :</label>
              <div class="controls">
                <input type="text" name="MotherFullName" id="MotherFullName" class="span11" placeholder="Mother's Maiden Name" value="<?php echo $RetrieveMotherFullName; ?>" />
              </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">Mother's Age :</label>
              <div class="controls">
                <input type="text" name="MotherAge" id="MotherAge" class="span11" placeholder="e.g. 45" value="<?php echo $MotherAge; ?>" />
              </div>
            </div>
              
              
              
<div class="control-group">
              <label class="control-label">Mother's Religion</label>
              <div class="controls">
                <select name="MotherReligion" id="MotherReligion" >
                    
                                                        
                                                        
         <?php 
                                                        
                                                        
try
{   
    $statement = $dbh->prepare("SELECT * FROM tblreligion");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($MotherReligionID == $data['ReligionID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['ReligionID'] . '" '. $selected .'>' . $data['ReligionName'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
   


                                                        


                                                        
                     ?> 
                
                </select>
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label">Occupation :</label>
              <div class="controls">
                <input type="text"  name="MotherOccupation" id="MotherOccupation" class="span11" placeholder="e.g. Doctor" value="<?php echo $RetrieveMotherOccupation; ?>" />
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label">Company Name :</label>
              <div class="controls">
                <input type="text"  name="MotherCompany" id="MotherCompany" class="span11" placeholder="e.g. Government" value="<?php echo $MotherCompanyName; ?>" />
              </div>
            </div>
              
            <div class="control-group">
              <label class="control-label">Company Location :</label>
              <div class="controls">
                <input type="text"  name="MotherCompanyLocation" id="MotherCompanyLocation" class="span11" placeholder="e.g. Imus Cavite" value="<?php echo $MotherCompanyLocation; ?>" />
              </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">Mother's Educational Attainment</label>
              <div class="controls">
                <select name="MotherEducAttainment" id="MotherEducAttainment" >
                    <option value="1" <?php if($MotherEducAttainment == 1){ echo ' selected ';} else{ echo ''; } ?> >Under Graduate</option>
                    <option value="2" <?php if($MotherEducAttainment == 2){ echo ' selected ';} else{ echo ''; } ?> >High School Graduate</option>
                    <option value="3" <?php if($MotherEducAttainment == 3){ echo ' selected ';} else{ echo ''; } ?> >College Graduate</option>
                    <option value="4" <?php if($MotherEducAttainment == 4){ echo ' selected ';} else{ echo ''; } ?> >Masteral,Doctorate etc</option>
                </select>
              </div>
            </div>
              
              
            <div class="control-group">
              <label class="control-label">Support For Education:</label>
              <div class="controls">
                <input type="text"  name="MotherSupport" id="MotherSupport" class="span11" placeholder="" value="<?php echo $MotherSupportEduc; ?>" />
              </div>
            </div>
          

              
          </form>
        </div>
      </div>
            
      
        
        
    </div>
        
    
    </div>
      
      <!-- row end -->
  
<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Admission Information</h5>
        </div>
        <div class="widget-content nopadding">
        
          <h3><center>Parents' Additional Information</center></h3>
              
            
            
    <div class="row-fluid">
            
            <div class="span1"></div>
            
            <div class="span5" id="ParentAddressControlGroup">
            
                
            
              <label class="control-label">*Parent Address</label>
              <div class="controls">
                <textarea  name="ParentAddress" id="ParentAddress" rows="2" class="span10" ><?php echo $ParentAddress;?> </textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="ParentAddressError"  name="ParentAddressError"> </span>
              </div>
      
                
                
            </div>
        
        
               <div class="span5">
            
                
            
            <label class="control-label">*Parents' Status</label>
              <div class="controls">
                <select name="ParentStatus" id="ParentStatus" class="span10" >
                    <option value="1" <?php if($ParentStatus == 1){ echo ' selected ';} else{ echo ''; } ?> >Married</option>
                    <option value="2" <?php if($ParentStatus == 2){ echo ' selected ';} else{ echo ''; } ?>>Separated</option>
                    <option value="3" <?php if($ParentStatus == 3){ echo ' selected ';} else{ echo ''; } ?> >Widowed</option>
                    <option value="4" <?php if($ParentStatus == 4){ echo ' selected ';} else{ echo ''; } ?> >Solo</option>
                </select>
              </div>
                
                
            </div>
            
     </div>
            
            
    
            
       <div class="row-fluid">
            
            <div class="span1"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Parent Home Number</label>
              <div class="controls">
                <input type="text" name="ParentHomeNum" id="ParentHomeNum" class="span10 m-wrap" placeholder="e.g. 434-0505" value="<?php echo $ParentHomeNumber; ?>"/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
              <label class="control-label">Parent Mobile Number</label>
              <div class="controls">
                <input type="text" name="ParentMobileNum" id="ParentMobileNum" class="span10 m-wrap" placeholder="e.g. 09123456789"value="<?php echo $ParentMobileNumber; ?>"/>
              </div>
          
                
                
            </div>
            
     </div>
    
            
        <div class="row-fluid">
            
            <div class="span1"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Father Facebook Messenger</label>
              <div class="controls">
                <input type="text" name="FatherFB" id="FatherFB" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz" value="<?php echo $FatherMessenger; ?>"/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
              <label class="control-label">Mother Facebook Messenger</label>
              <div class="controls">
                <input type="text" name="MotherFB" id="MotherFB" class="span10 m-wrap" placeholder="e.g. Maria Clara" value="<?php echo $MotherMessenger; ?>"/>
              </div>
          
                
                
            </div>
            
     </div>
            
            
            
      <div class="row-fluid">
            
            <div class="span4" style="margin-left: -30px;"></div>
            
            <div class="span5">
            
                
            
           <label class="control-label">Family Background Remarks</label>
              <div class="controls">
                <textarea  name="FamilyBackgroundRemarks" id="FamilyBackgroundRemarks" rows="4" class="span11" ><?php echo $RetrieveFamilyBackgroundRemarks; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="FamilyBackgroundError"  name="FamilyBackgroundError"> </span>
              </div>
                      
      
                
                
            </div>
        
        
     
            
     </div>
          <!-- row end -->
       
    <div class="row-fluid">
            <br>
            <h3><center>Extended Family Background Information</center></h3>
        <br>
            <h4 style="margin-left: 30px;">I. Guardian Information (Skip this phase if not applicable for the enrollee)</h4>
        <br>
            <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Guardian(if any)</label>
              <div class="controls">
                <input type="text" name="GuardianName" id="GuardianName" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz" value="<?php echo $GuardianFullName; ?>"/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
              <label class="control-label">Guardian Facebook Messenger</label>
              <div class="controls">
                <input type="text" name="GuardianMessenger" id="GuardianMessenger" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz" value="<?php echo $GuardianMessenger; ?>"/>
              </div>
          
                
                
            </div>
            
     </div>
            
            
            
        <div class="row-fluid">
           
         
            <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Guardian Home Number</label>
              <div class="controls">
                <input type="text" name="GuardianHomeNumber" id="GuardianHomeNumber" class="span10 m-wrap" placeholder="e.g. 4343-1234" value="<?php echo $GuardianHomeNumber; ?>"/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
              <label class="control-label">Guardian Mobile Number</label>
              <div class="controls">
                <input type="text" name="GuardianMobileNumber" id="GuardianMobileNumber" class="span10 m-wrap" placeholder="e.g. 09124567890" value="<?php echo $GuardianMobileNumber; ?>"/>
              </div>
          
                
                
            </div>
            
     </div>

  
     <div class="row-fluid">
           
         
            <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Relationship to Student</label>
              <div class="controls">
                <input type="text" name="GuardianRelationship" id="GuardianRelationship" class="span10 m-wrap" placeholder="e.g. Aunt" value="<?php echo $GuardianRelationship; ?>"/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
              <label class="control-label">Commitment to Support</label>
              <div class="controls">
                <input type="text" name="GuardianCommitment" id="GuardianCommitment" class="span10 m-wrap" placeholder="" value="<?php echo $GuardianCommitment; ?>"/>
              </div>
          
                
                
            </div>
            
     </div>
            
            
            
     <div class="row-fluid">
           
         
            <div class="span1" style="margin-left: -5px;"></div>
            
                <div class="span5" >
            
                
            
              <label class="control-label">Guardian Address</label>
              <div class="controls">
                <textarea  name="GuardianAddress" id="GuardianAddress" rows="2" class="span10" ><?php echo $GuardianAddress; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="GuardianAddressError"  name="GuardianAddressError"> </span>
              </div>
      
                
                
            </div>
        
        
          
            
     </div>
            
            

   <div class="row-fluid">
           
        <br>
            <h4 style="margin-left: 30px;">II. Sibling Information(Skip this phase if not applicable for the enrollee)</h4>
        <br>
            <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
              <label class="control-label">Student Order of Birth:</label>
              <div class="controls">
                <select name="OrderOfBirth" id="OrderOfBirth" class="span10" >
                    <option value="1" <?php if($StudentOrderOfBirth == 1){ echo ' selected ';} else{ echo ''; } ?>>Solo</option>
					<option value="2" <?php if($StudentOrderOfBirth == 2){ echo ' selected ';} else{ echo ''; } ?>>1st</option>
                    <option value="3" <?php if($StudentOrderOfBirth == 3){ echo ' selected ';} else{ echo ''; } ?>>2nd</option>
                    <option value="4" <?php if($StudentOrderOfBirth == 4){ echo ' selected ';} else{ echo ''; } ?>>3rd</option>
                    <option value="5" <?php if($StudentOrderOfBirth == 5){ echo ' selected ';} else{ echo ''; } ?>>4th</option>
                    <option value="6" <?php if($StudentOrderOfBirth == 6){ echo ' selected ';} else{ echo ''; } ?>>5th</option>
                    <option value="7" <?php if($StudentOrderOfBirth == 7){ echo ' selected ';} else{ echo ''; } ?>>6th</option>
                    <option value="8" <?php if($StudentOrderOfBirth == 8){ echo ' selected ';} else{ echo ''; } ?>>7th</option>
                    <option value="9" <?php if($StudentOrderOfBirth == 9){ echo ' selected ';} else{ echo ''; } ?>>8th</option>
                    <option value="10" <?php if($StudentOrderOfBirth == 10){ echo ' selected ';} else{ echo ''; } ?>>9th</option>
                    <option value="11" <?php if($StudentOrderOfBirth == 11){ echo ' selected ';} else{ echo ''; } ?>>10th</option>
                    <option value="12" <?php if($StudentOrderOfBirth == 12){ echo ' selected ';} else{ echo ''; } ?>>11th</option>
                    <option value="13" <?php if($StudentOrderOfBirth == 13){ echo ' selected ';} else{ echo ''; } ?>>12th</option>
                </select>
              </div>
            
            
                
                
            </div>
        
        
            <div class="span5">
            
               
                
                   <label class="control-label">Siblings Enrolled in IUCS</label>
              <div class="controls wrapper">
                <select multiple="multiple" name="Siblings[]" id="Siblings" class="span10 selection">
                  
                    
                    
<?php 
                                                        
                                                        
try
{
 
    $LatestSchoolYearMinus15 = $LatestSchoolYear - 15;

    $statement = $dbh->prepare("SELECT DISTINCT tblstudent.* FROM tblstudent,tblstudentadmission  WHERE StudentID = AdmissionStudentID  AND LEFT(StudentIDDisplay,4) >= $LatestSchoolYearMinus15  ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            
              for($y = 0; $y < $InternalSiblingsCountInt; $y++){
                  
                  if($data['StudentID'] == $InternalSiblingList[$y]){
                       $selected1 = " selected ";
                       break;
                  }
                  else{
                      $selected1 = "";
                  }
              }
            
            
            
          echo '<option value ="' . $data['StudentID'] . '" '. $selected1 .'>' .$data['StudentIDDisplay'].'- '.$data['FirstName'].      ' '.$data['MiddleName']. ' '.$data['LastName']. '</option>';
            
            
            $selected1 = "";
            
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                                                        
                     ?> 
                    
                                
                    
                </select>
              </div>
            
                
                
            </div>
            
     </div>
                
            
            
            
            
  
            <div class="row-fluid">
           
        <br>
        
        <br>
            <div class="span1" style="margin-left: -5px;"></div>
                
            <div class="span5">
                
                     
           <label class="control-label">Extended Family Background Remarks</label>
              <div class="controls">
                <textarea  name="ExtendedFamilyBackgroundRemarks" id="ExtendedFamilyBackgroundRemarks" rows="4" class="span11" ><?php echo $ExtendedFamilyBackgroundRemarks; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="ExtendedFamilyBackgroundError"  name="ExtendedFamilyBackgroundError"> </span>
              </div>
                      
            
                
            </div>
            
       
        
        
            <div class="span5">
            
               
            
                
                
            </div>
            
     </div>
            
     
            
<div class="row-fluid">
  
            <br>
   
             <button class="btn btn-md btn-info" href="#modalAddExternalSiblings" data-toggle="modal" style="margin-left: 780px;margin-top: -80px;" >Click to Add Siblings Outside IUCS</button>
            <h3><center>Siblings Outside IUCS</center></h3>
      <table class="table table-bordered data-table" id="ExternalSiblingsList">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Status</th>
                  <th>School(if student) </th>
                  <th>Educational Level</th>
                  <th>StatusHidden</th>
                  <th>EducationalLevelHidden</th>
                  <th>Action</th>
                </tr>
              </thead>
             <tbody>
                 
                 <?php
                  
                  
try
{
   // $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT * FROM tblsibling WHERE SiblingMainStudentID = :SiblingMainStudentID  AND ExternalSiblingName IS NOT NULL");
    $statement->execute(array(':SiblingMainStudentID' => $StudentID ));
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
    
        
    foreach($row as $data){

        echo '<tr>';
       
        echo '<td>'.$data['ExternalSiblingName'].'</td>';
        
        if($data['ExternalSiblingStatus'] == 1){
            echo '<td>Student</td>';
        }
        if($data['ExternalSiblingStatus'] == 2){
            echo '<td>Employed</td>';
        }
        if($data['ExternalSiblingStatus'] == 3){
            echo '<td>Infant</td>';
        }
        if($data['ExternalSiblingStatus'] == 4){
            echo '<td>Deceased</td>';
        }
        
        echo '<td>'.$data['ExternalSiblingSchool'].'</td>';
        
        
        
        if($data['ExternalSiblingEducationalLevel'] == 0){
            echo '<td>None</td>';
        }
        if($data['ExternalSiblingEducationalLevel'] == 1){
            echo '<td>ECEd</td>';
        }
        if($data['ExternalSiblingEducationalLevel'] == 2){
            echo '<td>Grade School</td>';
        }
        if($data['ExternalSiblingEducationalLevel'] == 3){
            echo '<td>Junior High School</td>';
        }
        if($data['ExternalSiblingEducationalLevel'] == 4){
            echo '<td>Senior High School</td>';
        }
        if($data['ExternalSiblingEducationalLevel'] == 5){
            echo '<td>College</td>';
        }
        if($data['ExternalSiblingEducationalLevel'] == 6){
            echo '<td>College Graduate</td>';
        }
        
        echo '<td>'.$data['ExternalSiblingStatus'].'</td>';
        
        echo '<td>'.$data['ExternalSiblingEducationalLevel'].'</td>';
        
        
        echo '<td><button class="btn btn-danger" id="RemoveRow">Remove </button></td>';
        
   
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                  
                  
                                    
?>
                  
                 
                
             </tbody>
            
    </table>
            
</div>
            

                            <!-- Educational Background Information -->
            
            
<div class="row-fluid">
        <br>
        <br>
            <h3><center>Educational Background Information</center></h3>
        <br>
    
         <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">School Of Origin</label>
              <div class="controls">
                <input type="text" name="SchoolOfOrigin" id="SchoolOfOrigin" class="span10 m-wrap" placeholder="e.g. Del Pilar Academy" value="<?php echo $RetrieveSchoolOfOrigin; ?>" disabled/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
                  <label class="control-label">Type Of Institution:</label>
              <div class="controls">
                <select name="TypeOfInstitution" id="TypeOfInstitution" class="span10" disabled>
                    <option value="0" <?php if($RetrieveTypeOfInstitution == '0') {echo " selected"; } ?>>Private</option>
                    <option value="1" <?php if($RetrieveTypeOfInstitution == '1') {echo " selected"; }?>>Public</option>
                    <option value="2" <?php if($RetrieveTypeOfInstitution == '2') {echo " selected"; }?>>IS</option>
                    
                </select>
              </div>
            
          
                
                
            </div>

    
</div>
            
            
            
<div class="row-fluid">
 
       
    
         <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Academic Strengths</label>
              <div class="controls">
                <input type="text" name="AcademicStrengths" id="AcademicStrengths" class="span10 m-wrap" placeholder="e.g. History Quizbee Contestant" value="<?php echo $AcademicStrengths; ?>" />
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
                <label class="control-label">Academic Weaknesses</label>
              <div class="controls">
                <input type="text" name="AcademicWeaknesses" id="AcademicWeaknesses" class="span10 m-wrap" placeholder="e.g. Poor Math Skills" value="<?php echo $AcademicWeaknesses; ?>" />
              </div>
          
                
                
            </div>

    
</div> 
            


            
<div class="row-fluid">
 
       
    
         <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Recognitions Received</label>
              <div class="controls">
                <input type="text" name="RecognitionsReceived" id="RecognitionsReceived" class="span10 m-wrap" placeholder="e.g. Athlete of the Year" value = "<?php echo $RecognitionReceived; ?>" />
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
                <label class="control-label">Other Interests</label>
              <div class="controls">
                <input type="text" name="OtherInterests" id="OtherInterests" class="span10 m-wrap" placeholder="e.g. Choir" value="<?php echo $OtherInterests; ?>" />
              </div>
          
                
                
            </div>

    
</div> 
            
            
<div class="row-fluid">
  
       
    
         <div class="span1" style="margin-left: -5px;"></div>
            
            <div class="span5">
            
                
            
              <label class="control-label">Special Needs(if any)</label>
              <div class="controls">
                <input type="text" name="SpecialNeeds" id="SpecialNeeds" class="span10 m-wrap" placeholder="e.g." value="<?php echo $SpecialNeeds; ?>"/>
              </div>
                      
      
                
                
            </div>
        
        
            <div class="span5">
            
                <label class="control-label">Serious Disciplinary Case</label>
              <div class="controls">
                <input type="text" name="DisciplinaryCase" id="DisciplinaryCase" class="span10 m-wrap" placeholder="e.g. " value="<?php echo $SeriousDisciplinaryCase; ?>" />
              </div>
          
                
                
            </div>

    
</div> 
        
    
                        
<div class="row-fluid">
                  <br>
   
             <button class="btn btn-md btn-info" href="#modalAddOtherSchoolsAttended" data-toggle="modal" style="margin-left: 780px;margin-bottom: -40px;" > Add Other Schools Attended</button>
            <h3><center>Other Schools Attended</center></h3>
      <table class="table table-bordered data-table" id="OtherSchoolsAttendedList">
              <thead>
                <tr>
                  <th>School Name</th>
                  <th>Type Of Institution</th>
                  <th>Location</th>
                  <th>Year Attended </th>
                  <th>Highest Educational Level</th>
                  <th>TypeOfInstitutionHidden</th>
                  <th>EducationalLevelHidden</th>
                  <th>Action</th>
                </tr>
              </thead>
             <tbody>
                
                 
                 <?php
                  
                  
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("SELECT * FROM tblotherschoolsattended WHERE OSAAdmissionPhase2ID = :OSAAdmissionPhase2ID");
    $statement->execute(array(':OSAAdmissionPhase2ID' => $RetrievePhase2ID ));
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
    
        
    foreach($row as $data){

        echo '<tr>';
       
        echo '<td>'.$data['NameOfSchool'].'</td>';
        
        
        if($data['SchoolTypeOfInstitution'] == 0){
            echo '<td>Private</td>';
        }
        if($data['SchoolTypeOfInstitution'] == 1){
            echo '<td>Public</td>';
        }
        if($data['SchoolTypeOfInstitution'] == 2){
            echo '<td>IS</td>';
        }
        
        
        echo '<td>'.$data['SchoolLocation'].'</td>';
        echo '<td>'.$data['YearAttended'].'</td>';
        
        
    
        if($data['HighestEducLevel'] == 1){
            echo '<td>ECEd</td>';
        }
        if($data['HighestEducLevel'] == 2){
            echo '<td>Grade School</td>';
        }
        if($data['HighestEducLevel'] == 3){
            echo '<td>Junior High School</td>';
        }
        if($data['HighestEducLevel'] == 4){
            echo '<td>Senior High School</td>';
        }
        
        
        echo '<td>'.$data['SchoolTypeOfInstitution'].'</td>';
        
        echo '<td>'.$data['HighestEducLevel'].'</td>';
        
        
        echo '<td><button class="btn btn-danger" id="RemoveRow">Remove </button></td>';
        
   
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                  
                  
                                    
?>
   
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
             </tbody>
            
    </table>
    
    
    
    
    

</div>

            
            
<div class="row-fluid">
    
      <br>
  

  <div class="span1"></div>
            
            <div class="span5" >
            
                
            
              <label class="control-label">Concerns For Transfer</label>
              <div class="controls">
                <textarea  name="ConcernsForTransfer" id="ConcernsForTransfer" rows="2" class="span10" ><?php echo $ConcernsForTransfer; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="ConcernsForTransferError"  name="ConcernsForTransferError"> </span>
              </div>
      
                
                
            </div>
    
    
       <div class="span5" >
            
                
            
              <label class="control-label">Reasons for Choosing IUCS</label>
              <div class="controls">
                <textarea  name="ReasonsForChoosing" id="ReasonsForChoosing" rows="2" class="span10" ><?php echo $ReasonsForTransfer; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="ReasonsForChoosingError"  name="ReasonsForChoosingError"> </span>
              </div>
      
                
                
            </div>
    
    
    
    
</div>
            
            
            
      <div class="row-fluid">
    
      <br>
      

  <div class="span1"></div>
            
            <div class="span5" >
            
                
            
              <label class="control-label">Who Decides the Transfer</label>
              <div class="controls">
                <textarea  name="WhoDecides" id="WhoDecides" rows="2" class="span10" ><?php echo $WhoDecidesTheTransfer; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="WhoDecidesError"  name="WhoDecidesError"> </span>
              </div>
      
                
                
            </div>
    
    
       <div class="span5" >
            
                
            
              <label class="control-label">Educational Background Remarks</label>
              <div class="controls">
                <textarea  name="EducBackgroundRemarks" id="EducBackgroundRemarks" rows="2" class="span10" ><?php echo $EducationalBackgroundRemarks; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="EducBackgroundRemarksError"  name="EducBackgroundRemarksError"> </span>
              </div>
      
                
                
            </div>
    
    
    
    
</div>      
            
            
            

<div class="row-fluid">
               
   
             <button class="btn btn-md btn-info" href="#modalAddReferrals" data-toggle="modal" style="margin-left: 780px;margin-bottom: -40px;" > Add Referrals</button>
            <h3><center>Who Referred You to IUCS</center></h3>
      <table class="table table-bordered data-table" id="ReferralsList">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Relationship</th>
                  <th>Action</th>
                </tr>
              </thead>
             <tbody>
                
                 
                 <?php
                  
                  
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("SELECT * FROM tblenrollmentreferrals WHERE ReferralAdmissionPhase2ID = :ReferralAdmissionPhase2ID");
    $statement->execute(array(':ReferralAdmissionPhase2ID' => $RetrievePhase2ID ));
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
    
        
    foreach($row as $data){

        echo '<tr>';
       
        echo '<td>'.$data['NameWhoRefer'].'</td>';        
        echo '<td>'.$data['Relationship'].'</td>';
    
        
        echo '<td><button class="btn btn-danger" id="RemoveRow">Remove </button></td>';
        
   
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                  
                  
                                    
?>
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
             </tbody>
            
    </table>
    
    
    
    
    

</div>
            
            
            
            
<div class="row-fluid" style="margin-left: -24px;">
    
 

 
          <br>
    
            <h3><center>Organizational Membership</center></h3>
    <br>
            
    <div class="span1"></div>
            <div class="span5" >
            
                
                <label class="control-label">Church Name</label>
              <div class="controls">
                <input type="text" name="ChurchName" id="ChurchName" class="span10 m-wrap" placeholder="e.g. United Pentecostal Church Imus" value="<?php echo $ChurchName; ?>" />
              </div>
                      
            
                
                
            </div>
    
    
       <div class="span5" >
            
                
              <label class="control-label">Church Location</label>
              <div class="controls">
                <input type="text" name="ChurchLocation" id="ChurchLocation" class="span10 m-wrap" placeholder="e.g. Imus, Cavite" value="<?php echo $ChurchLocation; ?>" />
              </div>
          
      
                
                
         </div>
    
    
    
    
</div>      
            
            
            
<div class="row-fluid">
    
  

        
    <div class="span1"></div>
            <div class="span5" >
            <br>
                
                <label class="control-label">Church Engagement</label>
              <div class="controls">
                <input type="text" name="ChurchEngagement" id="ChurchEngagement" class="span10 m-wrap" placeholder="e.g." value="<?php echo $ChurchEngagement; ?>" />
              </div>
                      
            
                
                
            </div>
    
    
       <div class="span5" style="margin-top: 30px;">
            
                
             <div class="controls">
                <label style="font-size: 20px;">
                  <input type="checkbox" name="radios" name="ExclusiveRelationshipCheckbox" id="ExclusiveRelationshipCheckbox" <?php if($CheckIndicator){ echo " checked "; } ?> />
                  Exclusive Relationship</label>
               
              </div>
          
      
                
                
         </div>
    
    
    
    
</div> 
            
            
<div class="row-fluid" id="DivExclusiveRelationship"  <?php echo $ERTableVisibility; ?> >
    
    <div class="row-fluid">
                  <br>
   
             <button class="btn btn-md btn-info" href="#modalAddExclusiveRelationship" data-toggle="modal" style="margin-left: 780px;margin-bottom: -40px;" > Add Exclusive Relationship</button>
            <h3><center>Exclusive Relationship</center></h3>
      <table class="table table-bordered data-table" id="ExclusiveRelationshipList">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Relationship</th>
                  <th>Action</th>
                </tr>
              </thead>
             <tbody>
                
                 
                 
                 
        <?php
                  
                  
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("SELECT * FROM tblexclusiverelationship WHERE ERAdmissionPhase2ID = :ERAdmissionPhase2ID");
    $statement->execute(array(':ERAdmissionPhase2ID' => $RetrievePhase2ID  ));
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
    
        
    foreach($row as $data){

        echo '<tr>';
       
        echo '<td>'.$data['RelationshipToWhom'].'</td>';        
        echo '<td>'.$data['Relationship'].'</td>';
    
        
        echo '<td><button class="btn btn-danger" id="RemoveRow">Remove </button></td>';
        
   
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                  
                  
                                    
?>
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
                 
             </tbody>
            
    </table>
    
    
    
    
    

</div>
    
    
    
    
</div>
            
            
            
            
            
    <div class="row-fluid">
    
  


  <div class="span1"></div>
            <br>
     
 
            <div class="span5" >
            
                
                <label class="control-label">School-Related Clubs</label>
              <div class="controls">
                <input type="text" name="SchoolClubs" id="SchoolClubs" class="span10 m-wrap" placeholder="e.g. Math Club, Choir, Dance Troope" value="<?php echo $SchoolRelatedClubs; ?>" />
              </div>
                      
            
                
                
            </div>
    
    
       <div class="span5" >
            
                
              
              <label class="control-label">Other Organization Involvement</label>
              <div class="controls">
                <textarea  name="OtherOrg" id="OtherOrg" rows="2" class="span10" placeholder="Include organization name, position and location"><?php echo $OtherOrgInvolvement; ?></textarea>
                   
              </div>
          
      
                
                
         </div>
    
    
    
    
</div>      
        
            
            
            
            
    <div class="row-fluid">
    
  
  

  <div class="span1"></div>
            <br>
     
    
       <div class="span5" >
            
                
              
              <label class="control-label">Organizational Background Remarks</label>
              <div class="controls">
                <textarea  name="OrgBackgroundRemarks" id="OrgBackgroundRemarks" rows="2" class="span10" placeholder=""><?php echo $OrganizationsRemarks; ?></textarea>
                   
              </div>
          
      
                
                
         </div>
    
    
    
    
</div>
       

            
            
<div class="row-fluid" style="margin-left: -24px;">
    
 

 
          <br>
    
            <h3><center>Health History</center></h3>
    <br>
            
    <div class="span1"></div>
            <div class="span5" >
            
                
                 <label class="control-label">Rate of General Health</label>
              <div class="controls">
                <select name="RateOfGeneralHealth" id="RateOfGeneralHealth" class="span10" >
                    <option value="0" 
<?php if($RateOfGeneralHealth == 0){ echo ' selected ';} else{ echo ''; } ?>>Healthy</option>
                    
                    <option value="1" 
<?php if($RateOfGeneralHealth == 1){ echo ' selected ';} else{ echo ''; } ?>>Good</option>
        
                    <option value="2" 
<?php if($RateOfGeneralHealth == 2){ echo ' selected ';} else{ echo ''; } ?>>Fair</option>
                    
                    <option value="3" 
<?php if($RateOfGeneralHealth == 3){ echo ' selected ';} else{ echo ''; } ?>>Poor</option>
                </select>
              </div>
            
            
                
                
            </div>
    
    
       <div class="span5" >
            
                
              <label class="control-label">Hearing Condition</label>
              <div class="controls">
                <input type="text" name="HearingCondition" id="HearingCondition" class="span10 m-wrap" placeholder="e.g." value="<?php echo $HearingCondition; ?>" />
              </div>
          
      
                
                
         </div>
    
    
    
    
</div>     
            

            
            
<div class="row-fluid" >
    
 

 
    
            
    <div class="span1"></div>
    <br>
            <div class="span5" >
            
                
                   <label class="control-label">Eyesight Condition</label>
              <div class="controls">
                <input type="text" name="EyesightCondition" id="EyesightCondition" class="span10 m-wrap" placeholder="e.g." value="<?php echo $EyesightCondition; ?>" />
              </div>
            
                
                
            </div>
    
    
       <div class="span5" >
            
                
              <label class="control-label">Allergies</label>
              <div class="controls">
                <input type="text" name="Allergies" id="Allergies" class="span10 m-wrap" placeholder="e.g." value="<?php echo $Allergies; ?>" />
              </div>
          
      
                
                
         </div>
    
    
    
    
</div>      
      
            
            
<div class="row-fluid" >
    
 

 
    
            
    <div class="span1"></div>
    <br>
            <div class="span5" >
            
                
                   <label class="control-label">Other Health Concerns</label>
              <div class="controls">
                <input type="text" name="OtherHealthConcerns" id="OtherHealthConcerns" class="span10 m-wrap" placeholder="e.g." value="<?php echo $OtherHealthConcerns; ?>" />
              </div>
            
                
                
            </div>
    
    
       <div class="span5" >
            
                
              <label class="control-label">Health History Remarks</label>
              <div class="controls">
                <textarea  name="HealthBackgroundRemarks" id="HealthBackgroundRemarks" rows="2" class="span10" placeholder=""><?php echo $HealthCategoryRemarks; ?></textarea>
                   
              </div>
      
                
                
         </div>
    
    
    
    
</div> 
      
                    
       
            
            
            
            
    <div class="row-fluid" style="margin-left: -24px;">
    
 

 
          <br>
    
            <h3><center>Ancillary Information</center></h3>
    <br>
            
    <div class="span1"></div>
            <div class="span5" >
            
                
                 <label class="control-label">Final Desired Strand (For SHS Only) </label>
              <div class="controls">
                <select name="FinalStrand" id="FinalStrand" <?php if($RetrieveGradeLevel == "14" || $RetrieveGradeLevel == "15" ){  } else { echo ' disabled '; } ?> >
                     
<?php 
                                                        
                                                    
try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblstrand");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveGradeLevel == "14" || $RetrieveGradeLevel == "15" ){
                 
                if($RetrieveStrand == $data['StrandID']){
                    $selected = "selected";
                }
                else{
                    $selected = "";
                }
                
                  echo '<option value ="' . $data['StrandID'] . '" '. $selected .'>' . $data['StrandName'] .'</option>';
            }
            else{
                $selected = "";
                echo '<option value="0">Strands for SHS Only </option> ';
            }
         
             $selected = "";
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                
                </select>
              </div>
            
                
                
            </div>
    
    
       <div class="span5" >
            
                
              <label class="control-label">IUCS Services of Interest</label>
              <div class="controls">
                <input type="text" name="ServicesOfInterest" id="ServicesOfInterest" class="span10 m-wrap" placeholder="e.g." value="<?php echo $ServicesOfInterests; ?>" />
              </div>
          
      
                
                
         </div>
    
    
    
    
</div>         
            
            
            
            
            
            
            
            
            
        <div class="row-fluid">
                  
         
            <div class="span1"></div>
               <br>
  <div class="span5">
       <label class="control-label">Sibling Discount </label>
              
                
                 <div class="controls">
                <select name="SiblingDiscount" id="SiblingDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 1");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
      if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveSiblingDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }


    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
    
    
    
    
        
        
        
        <div class="span5">
       <label class="control-label">Academic Scholarship Discount </label>
              
                
                 <div class="controls">
                <select name="AcademicScholarshipDiscount" id="AcademicScholarshipDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 2");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveAcademicScholarshipDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
        
        
        
        
        
        
        
        
        
        
        
        
        
  
                
    
    
                  
</div>
                  
<!-- sibling discount ending -->
                      
            
            
            
            
            
      <div class="row-fluid">
            <div class="span1"></div>
          
          <br>
  <div class="span5">
       <label class="control-label">Promotional Discount </label>
              
                
                 <div class="controls">
                <select name="PromotionalDiscount" id="PromotionalDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 3");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrievePromotionalDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
    
    
    
    
        
        
        
        <div class="span5">
       <label class="control-label">Entrance Scholarship Discount </label>
              
                
                 <div class="controls">
                <select name="EntranceScholarshipDiscount" id="EntranceScholarshipDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 4");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveEntranceScholarshipDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }
    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
        
                      
    
    
                  
</div>
               
            
            
            
            
            
            
            
            
            
            
            
            
    <div class="row-fluid">
            <div class="span1"></div>
        <br>
  <div class="span5" >
       <label class="control-label">Varsity Discount </label>
              
                
                 <div class="controls">
                <select name="VarsityDiscount" id="VarsityDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 5");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveVarsityDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
    
    
    
    
	
            <div class="span5" id="VarsityDiscountAmountControlGroup">
              
                   <label class="control-label">Varsity Discounts(Input Amount)</label>
              <div class="controls">
                <input type="text" name="VarsityDiscountAmount" id="VarsityDiscountAmount" class="span10 m-wrap" placeholder="e.g. 10000"  value="<?php echo $RetrieveVarsityDiscountAmount; ?>"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="VarsityDiscountAmountError"  name="VarsityDiscountAmountError">Invalid Amount </span>
            </div>
        
        
        </div>  
        
        
        
  
                
    
    
                  
</div>        
            
            
             <div class="row-fluid">
            <div class="span1"></div>
        <br>
  <div class="span5" >
       <label class="control-label">ESC Discount (Grade 7 to Grade 10 Only) </label>
              
                
                 <div class="controls">
                <select name="ESCDiscount" id="ESCDiscount" <?php $ESCDisabled = " disabled "; if($RetrieveGradeLevel == 10 || $RetrieveGradeLevel == 11 || $RetrieveGradeLevel == 12 || $RetrieveGradeLevel == 13 ){ $ESCDisabled = ""; } echo $ESCDisabled; ?>>
                 <option value="0"  <?php if(is_null($RetrieveESCDiscount)){ echo " selected ";} ?>>None</option>
                 <?php 
                                                        
                                                        
        try
{
 

   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 7");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
        if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveESCDiscount   == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }


    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
    
    
    
    
	
	<div class="span5" >
       <label class="control-label">QVR Discount (For SHS Only)</label>
              
                
                 <div class="controls">
                <select name="QVRDiscount" id="QVRDiscount" <?php $QVRDisabled = " disabled "; if($RetrieveGradeLevel == 14 || $RetrieveGradeLevel == 15  ){ $QVRDisabled = ""; } echo $QVRDisabled; ?>>
                    <option value="0" <?php if(is_null($RetrieveQVRDiscount)){ echo " selected ";} ?>>None</option>
                  
                    
                     <?php 
                                                        
                                                        
        try
{
 

   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 8");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
        if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveQVRDiscount   == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }


    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                </select>
              </div>
                  
    
    
    </div>
	
	
	
	
	
	
                
</div>             
          
            
                <div class="row-fluid">
                     
       <div class="span1"></div>
               <br>
  <div class="span5">
       <label class="control-label">Employee's Discount </label>
              
                
                 <div class="controls">
                <select name="EmployeeDiscount" id="EmployeeDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 9");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
              
            if($RetrieveEmployeeDiscount   == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
            
            
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
    
    
    
    
        
        
<div class="span5">

      <label class="control-label">STS Discount for SHS</label>
              
                
                 <div class="controls">
                <select name="STSDiscount" id="STSDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 

   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 6");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
        if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveSTSDiscountID  == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }


    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
</div>
    
        
        
        
        
        
        
        
        
        
        
        
    </div>
            

            
                <div class="row-fluid">
                     
       <div class="span1"></div>
               <br>
 
    
    
    
    
    
        
        
        
        <div class="span5">
       <label class="control-label">Board of Trustees Discount </label>
              
                
                 <div class="controls">
                <select name="BOTDiscount" id="BOTDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 10");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveBOTDiscount   == $data['DiscountTypeID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
            
            
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

    
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                    
                    
                    
                    
                    
                    
                    
                    
                    
                </select>
              </div>
                  
    
    
    </div>
    
        
        
            <div class="span5" id="BOTDiscountAmountControlGroup">
              
                   <label class="control-label">BOT Discounts(Input Amount)</label>
              <div class="controls">
                <input type="text" name="BOTDiscountAmount" id="BOTDiscountAmount" class="span10 m-wrap" placeholder="e.g. 10000"  value="<?php echo $RetrieveBOTDiscountAmount; ?>"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="BOTDiscountAmountError"  name="BOTDiscountAmountError">Invalid Amount </span>
              </div>
                      
           
            
                     
                       
                       
                 
            </div>
        
        
        
        
        
        
        
        
        
    </div>
           
            
            
          <div class="row-fluid" >
    
 

 
    
            
    <div class="span1" ></div>
    <br>
     <br>
     <div class="span5" style="margin-left: 90px;" >
            
                
                   <label class="control-label">ESC Number</label>
              <div class="controls">
                <input type="text" name="ESCNumber" id="ESCNumber" class="span10 m-wrap" placeholder="e.g." value="<?php echo $RetrieveESCNumber; ?>" />
              </div>
            
                
                
            </div>
    
       <div class="span5" >
            
                
              <label class="control-label">Ancillary Information Remarks</label>
              <div class="controls">
                <textarea  name="AncillaryRemarks" id="AncillaryRemarks" rows="2" class="span10" placeholder=""><?php echo $AncillaryRemarks; ?></textarea>
                   
              </div>
      
                
                
         </div>
    
    
    
    
</div> 
        
            
            
            
            
                    <div class="row-fluid">
            
                <br>
                
                
              <div class="span1"  style="margin-left: -1px;"></div>
              
                 <div class="span5" >
            
                
              <label class="control-label">QVR Number (if any)</label>
              <div class="controls">
                <input type="text" name="QVRNumber" id="QVRNumber" class="span10 m-wrap" placeholder="e.g." value="<?php echo $RetrieveQVRNumber; ?>" />
              </div>
          
      
              </div>
                
                                     
                 <div class="span5" id="OtherDiscountControlGroup">
              
                   <label class="control-label">Other Discounts(if any)</label>
              <div class="controls">
                <input type="text" name="OtherDiscount" id="OtherDiscount" class="span10 m-wrap" placeholder="e.g. 10000"  value="<?php echo $RetrieveOtherDiscount; ?>"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="OtherDiscountError"  name="OtherDiscountError">Invalid Amount </span>
              </div>
                      
           
            
                     
                       
                       
                 
                 </div>
                           
     </div>    
            
            
            
            
            
            
            
            
            
            
<div class="row-fluid">
            
            
    
            
                     
            <div class="row-fluid">
                     <div class="span5"></div>
             
            
				     <div class="span5" style="margin-top: 25px; margin-left: 150px; margin-bottom: 100px;">
                    <button type="button" id="SubmitButton" class="btn btn-large btn-success">Save Changes</button> 
                 <div class="span4"></div>
                    <a href="ForInterviewList.php"><button type="button"  id="CancelButton" class="btn btn-large btn-info">Back</button></a>

                
             
    
    
                 </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                     
            </div>
                     
                     
                     
</div>
            
    <!-- last row >
            
              
             
        
        
        
        
        
            
        
        
        </div>
        
<!-- widget content padding -->
        
        
        
        
    </div>
<!-- widget box -->
        
        
     

    
  
  </div>
      
      <!-- end 2nd row fluid -->


    
    <!-- end-container -->
    
</div>

<!--end-main-container-part-->
    
    

      <!-- Modal Add Other Schools Attended -->
      
       <div id="modalAddOtherSchoolsAttended" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Other Schools Attended</h3>
              </div>
              <div class="modal-body">
                  
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">School Name</label>
                            <div class="controls">
                            <input type="text" name="Modal2SchoolName" id="Modal2SchoolName" class="span10 m-wrap" placeholder="e.g. Imus Institude" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
                     <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
                                <label class="control-label">*Type Of Institution</label>
                                <div class="controls">
                                    <select name="Modal2TypeOfInstitution" id="Modal2TypeOfInstitution" class="span10" >
                                    <option value="0">Private</option>
                                    <option value="1">Public</option>
                                    <option value="2">IS</option>
                                    </select>
                                </div>
                            </div>
                      
                    </div>
                  <br>
                    <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">School Location</label>
                            <div class="controls">
                            <input type="text" name="Modal2SchoolLocation" id="Modal2SchoolLocation" class="span10 m-wrap" placeholder="e.g. Imus,Cavite" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
                  
                     <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">Year Attended</label>
                            <div class="controls">
                            <input type="text" name="Modal2YearAttended" id="Modal2YearAttended" class="span10 m-wrap" placeholder="e.g. 2015-2016" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  
                  <br>
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
                                <label class="control-label">*Highest Educational Level</label>
                                <div class="controls">
                                    <select name="Modal2HighestEduc" id="Modal2HighestEduc" class="span10" >
                                    <option value="1">ECEd</option>
                                    <option value="2">Grade School</option>
                                    <option value="3">Junior High School</option>
                                    <option value="4">Senior High School</option>
                                    </select>
                                </div>
                            </div>
                      
                    </div>
                    <br>
                    <br>
                  <br>
                  
                  
              </div> <!-- modal body -->
              <div class="modal-footer"> <a data-dismiss="modal" id="btnAddOtherSchoolsAttended" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
            </div>    
            
      
      
      
      <!-- Modal Add External Siblings -->

            <div id="modalAddExternalSiblings" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add Sibling Outside IUCS</h3>
              </div>
              <div class="modal-body">
                  
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">Sibling Name</label>
                            <div class="controls">
                            <input type="text" name="ModalSiblingName" id="ModalSiblingName" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
                     <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
                                <label class="control-label">*Sibling Status</label>
                                <div class="controls">
                                    <select name="ModalSiblingStatus" id="ModalSiblingStatus" class="span10" >
                                    <option value="1">Student</option>
                                    <option value="2">Employed</option>
                                    <option value="3">Infant</option>
                                    <option value="4">Deceased</option>
                                    </select>
                                </div>
                            </div>
                      
                    </div>
                  <br>
                    <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">School(If Student)</label>
                            <div class="controls">
                            <input type="text" name="ModalSchoolName" id="ModalSchoolName" class="span10 m-wrap" placeholder="e.g. Del Pilar Academy" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
                                <label class="control-label">*Sibling Educational Level</label>
                                <div class="controls">
                                    <select name="ModalSiblingEduc" id="ModalSiblingEduc" class="span10" >
									<option value="0">None </option>
                                    <option value="1">ECEd</option>
                                    <option value="2">Grade School</option>
                                    <option value="3">Junior High School</option>
                                    <option value="4">Senior High School</option>
                                    <option value="5">College</option>
                                    <option value="6">College Graduate</option>
                                    </select>
                                </div>
                            </div>
                      
                    </div>
                    <br>
                    <br>
                  
                  
                  
              </div> <!-- modal body -->
              <div class="modal-footer"> <a data-dismiss="modal" id="btnAddExternalSibling" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
            </div>    
            
    
      
      
      
      
      
      
       <!-- Modal Add Referrals -->

            <div id="modalAddReferrals" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add Referrals</h3>
              </div>
              <div class="modal-body">
                  
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">Referred by</label>
                            <div class="controls">
                            <input type="text" name="ModalReferredBy" id="ModalReferredBy" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
                     <div class="row-fluid">
                     <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">Relationship</label>
                            <div class="controls">
                            <input type="text" name="ModalReferralRelationship" id="ModalReferralRelationship" class="span10 m-wrap" placeholder="e.g. Friend" value=""/>
                            </div>
                    
                            </div>
                    </div>
               
                   
               
                
                    <br>
                    <br>
                  
                  
                  
              </div> <!-- modal body -->
              <div class="modal-footer"> <a data-dismiss="modal" id="btnAddRefferal" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
            </div> 
      

      
      
      
      
      
      
       <!-- Modal Add Exclusive Relationship -->

            <div id="modalAddExclusiveRelationship" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add Exclusive Relationship</h3>
              </div>
              <div class="modal-body">
                  
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">Exclusive Relationship To Whom</label>
                            <div class="controls">
                            <input type="text" name="Modal4RelationshipToWhom" id="Modal4RelationshipToWhom" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
                     <div class="row-fluid">
                     <div class="span2"></div>
                            <div class="span10">
            
                            <label class="control-label">Relationship</label>
                            <div class="controls">
                            <input type="text" name="Modal4Relationship" id="Modal4Relationship" class="span10 m-wrap" placeholder="e.g. Friend" value=""/>
                            </div>
                    
                            </div>
                    </div>
               
                   
               
                
                    <br>
                    <br>
                  
                  
                  
              </div> <!-- modal body -->
              <div class="modal-footer"> <a data-dismiss="modal" id="btnAddExclusiveRelationship" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
            </div> 
      
      
      
      
    

<?php


include 'EnrollmentPhase2Footer.php';
?>
    
    
    
    
    
<script type="text/javascript">
    
    
   
    $( document ).ready(function() {
        
               $('head').append('<link rel="stylesheet" href="scrollablesiblings.css" type="text/css" />');
        
        
        
        UpdateAge();
        
        function UpdateAge(){
            
           
    var BirthdayVal = $("#Birthday").val();
           //alert(BirthdayVal);
    
    BirthdayVal = formatDate(BirthdayVal);
    dob = new Date(BirthdayVal);
    var today = new Date();
    var age = Math.floor((today-dob) / (365.25 * 24 * 60 * 60 * 1000));
    //$('#Age').html(age+' years old');
    
    if(isNaN(age)){
        age = "Please enter valid birthday";
    }
    $("#Age").val(age);
        }
        
        
            function formatDate(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
}
    
        
        
        var SiblingsTable = $('#ExternalSiblingsList').DataTable({
       
            "bRetrieve": true,
    
        });
    
        
        SiblingsTable.column( 4 ).visible( false );
        SiblingsTable.column( 5 ).visible( false );
    
    
        
        SiblingsTable.on('click', '#RemoveRow', function () {
        
            SiblingsTable.row($(this).parents('tr')).remove().draw(false);
        
        });
        
        
        
        var OtherSchoolsTable = $('#OtherSchoolsAttendedList').DataTable({
       
            "bRetrieve": true,
    
        });
    
        
        OtherSchoolsTable.column( 5 ).visible( false );
        OtherSchoolsTable.column( 6 ).visible( false );
    
    
        
        OtherSchoolsTable.on('click', '#RemoveRow', function () {
        
            OtherSchoolsTable.row($(this).parents('tr')).remove().draw(false);
        
        });
        
        
        
        var ReferralsTable = $('#ReferralsList').DataTable({
       
            "bRetrieve": true,
    
        });
        
        ReferralsTable.on('click', '#RemoveRow', function () {
        
            ReferralsTable.row($(this).parents('tr')).remove().draw(false);
        
        });
        
        
        var ERTable = $('#ExclusiveRelationshipList').DataTable({
       
            "bRetrieve": true,
    
        });
        
        ERTable.on('click', '#RemoveRow', function () {
        
            ERTable.row($(this).parents('tr')).remove().draw(false);
        
        });
    
        
         //For Positioning of Search Filter of Data Table
        $('#ExternalSiblingsList_filter').css('margin-top',"1230px");
        $('#OtherSchoolsAttendedList_filter').css('margin-top',"1850px");
        $('#OtherSchoolsAttendedList_filter').hide();
        $('#ReferralsList_filter').hide();
        $('#ExclusiveRelationshipList_filter').hide();
        
        
        
       // $('#DivExclusiveRelationship').hide();
        
        
        
    });

  


    $("#ExclusiveRelationshipCheckbox").change(function() {
        if(this.checked) {
            $('#DivExclusiveRelationship').show();
        }
        else{
            $('#DivExclusiveRelationship').hide();
            //var ERLTable = $('#ExclusiveRelationshipList').DataTable();
            //ERLTable.clear().draw();
            
            
        }
    });
    
    
      //Button Add Other Schools Attended
      $("#btnAddOtherSchoolsAttended").click(function () {
          
          
          var Modal2SchoolName = $('#Modal2SchoolName').val();
          var Modal2TypeOfInstitution = $('#Modal2TypeOfInstitution').val();
          var Modal2TypeOfInstitutionDisplay = $("#Modal2TypeOfInstitution option:selected").text();
          var Modal2SchoolLocation = $('#Modal2SchoolLocation').val();
          var Modal2YearAttended = $('#Modal2YearAttended').val();
          var Modal2HighestEduc = $('#Modal2HighestEduc').val();
          var Modal2HighestEducDisplay = $("#Modal2HighestEduc option:selected").text();
          
          var dataTable = $('#OtherSchoolsAttendedList').DataTable();
        dataTable.row.add([Modal2SchoolName,Modal2TypeOfInstitutionDisplay,Modal2SchoolLocation,Modal2YearAttended,Modal2HighestEducDisplay,Modal2TypeOfInstitution,Modal2HighestEduc, '<button class="btn btn-danger" id="RemoveRow">Remove </button>']).draw();
        
          
          
        //Note: The code below is not working due to syntax is updated. The above code is working due to outdated datatables code
          
          
        //dataTable.row.add([Quantity,UOMName,ProductName , PricePerUnit ,AccumulatedPrice, UOMID, ProductID, SupplierID, '<button class="btn btn-success btn-md" id="EditRow"> Edit Order </button>','<button class="btn btn-danger btn-md" id="RemoveRow"> Remove Order </button>']).draw();
          
          
          
          $('#Modal2SchoolName').val("");
          $('#Modal2SchoolLocation').val("");
          $('#Modal2YearAttended').val("");
        
          
          $('#s2id_Modal2TypeOfInstitution span').text('Private');
          $("select#Modal2TypeOfInstitution")[0].selectedIndex = 0;
          
          $('#s2id_Modal2HighestEduc span').text('ECEd');
          $("select#Modal2HighestEduc")[0].selectedIndex = 0;
          
          
      });
    
    
    
    
       $("#btnAddRefferal").click(function () {
          
          
          var Modal3ReferredBy = $('#ModalReferredBy').val();
          var Modal3Relationship = $('#ModalReferralRelationship').val();
   
          
          var dataTable = $('#ReferralsList').DataTable();
        dataTable.row.add([Modal3ReferredBy, Modal3Relationship,'<button class="btn btn-danger" id="RemoveRow">Remove </button>']).draw();
    
          
          $('#ModalReferredBy').val("");
          $('#ModalReferralRelationship').val("");
       

          
      });
    
    
    
    
    
    
       $("#btnAddExclusiveRelationship").click(function () {
          
          
          var Modal4RelationshipToWhom = $('#Modal4RelationshipToWhom').val();
          var Modal4Relationship = $('#Modal4Relationship').val();
   
          
          var dataTable = $('#ExclusiveRelationshipList').DataTable();
        dataTable.row.add([Modal4RelationshipToWhom, Modal4Relationship,'<button class="btn btn-danger" id="RemoveRow">Remove </button>']).draw();
    
          
          $('#Modal4RelationshipToWhom').val("");
          $('#Modal4Relationship').val("");
       

          
      });
    
    
    
    
    
    
    
    //Button Add External Sibling
      $("#btnAddExternalSibling").click(function () {
          
          
          var ModalSiblingName = $('#ModalSiblingName').val();
          var ModalSiblingStatus = $('#ModalSiblingStatus').val();
          var ModalSiblingStatusDisplay = $("#ModalSiblingStatus option:selected").text();
          var ModalSchoolName = $('#ModalSchoolName').val();
          var ModalSiblingEduc = $('#ModalSiblingEduc').val();
          var ModalSiblingEducDisplay = $("#ModalSiblingEduc option:selected").text();
          
          var dataTable = $('#ExternalSiblingsList').DataTable();
        dataTable.row.add([ModalSiblingName,ModalSiblingStatusDisplay,ModalSchoolName,ModalSiblingEducDisplay,ModalSiblingStatus,ModalSiblingEduc, '<button class="btn btn-danger" id="RemoveRow">Remove </button>']).draw();
        
          
          
        //Note: The code below is not working due to syntax is updated. The above code is working due to outdated datatables code
          
          
        //dataTable.row.add([Quantity,UOMName,ProductName , PricePerUnit ,AccumulatedPrice, UOMID, ProductID, SupplierID, '<button class="btn btn-success btn-md" id="EditRow"> Edit Order </button>','<button class="btn btn-danger btn-md" id="RemoveRow"> Remove Order </button>']).draw();
          
          
          
          $('#ModalSiblingName').val("");
          $('#ModalSchoolName').val("");
         
        
          
          $('#s2id_ModalSiblingStatus span').text('Student');
          $("select#ModalSiblingStatus")[0].selectedIndex = 0;
          
          $('#s2id_ModalSiblingEduc span').text('ECEd');
          $("select#ModalSiblingEduc")[0].selectedIndex = 0;
          
          
      });
    
    
    
    
    
    
    
    function formatDate(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
}
    
 

    
    $("#SubmitButton").click(function(e){
        if (confirm('Update student data?')) {
            
              var FormValidator = true;
        
            
            
            var Phase2Nickname = $("#Phase2Nickname").val();
            var Phase2FacebookMessenger = $("#FacebookMessenger").val();
            var Phase2PersonalInfoRemarks = $("#PersonalInfoRemarks").val();
            var Phase2HomeNumber = $("#Phase2HomeNumber").val();
            var Phase2MobileNumber = $("#Phase2MobileNumber").val();
             //End Of Personal Info Category
            
            
            var FatherFullName = $("#FatherFullName").val();
            var FatherAge = $("#FatherAge").val();
            var FatherReligion = $("#FatherReligion").val();
            var FatherOccupation = $("#FatherOccupation").val();
            var FatherCompany = $("#FatherCompany").val();
            var FatherCompanyLocation = $("#FatherCompanyLocation").val();
            var FatherEducAttainment = $("#FatherEducAttainment").val();
            var FatherSupport = $("#FatherSupport").val();
            
            var MotherFullName = $("#MotherFullName").val();
            var MotherAge = $("#MotherAge").val();
            var MotherReligion = $("#MotherReligion").val();
            var MotherOccupation = $("#MotherOccupation").val();
            var MotherCompany = $("#MotherCompany").val();
            var MotherCompanyLocation = $("#MotherCompanyLocation").val();
            var MotherEducAttainment = $("#MotherEducAttainment").val();
            var MotherSupport = $("#MotherSupport").val();
            
                
          //Address Validation
          var ParentAddress = $("#ParentAddress").val();
            
            if(ParentAddress == null || ParentAddress == ""){
                FormValidator = false;
                $("#ParentAddressControlGroup").addClass("error");
                $('#ParentAddressControlGroup').css('color', "#b94a48");
                $("#ParentAddress").css("border-color","#b94a48");
                $("#ParentAddress").css("color","#b94a48");
                $("#ParentAddressError").show();
            }
            else{
                $("#ParentAddressControlGroup").removeClass("error");
                $('#ParentAddressControlGroup').css('color', "#333");
                $("#ParentAddress").css("border-color","#ccc");
                $("#ParentAddress").css("color","#333");
                $("#ParentAddressError").hide();
            }
            
            var ParentStatus = $("#ParentStatus").val();
            var ParentHomeNum = $("#ParentHomeNum").val();
            var ParentMobileNum = $("#ParentMobileNum").val();
            var FatherFB = $("#FatherFB").val();
            var MotherFB = $("#MotherFB").val();
            var FamilyBackgroundRemarks = $("#FamilyBackgroundRemarks").val();
            
            
            
            //End Of Family Background Category
            
            var GuardianName = $("#GuardianName").val();
            var GuardianMessenger = $("#GuardianMessenger").val();
            var GuardianHomeNumber = $("#GuardianHomeNumber").val();
            var GuardianMobileNumber = $("#GuardianMobileNumber").val();
            var GuardianRelationship = $("#GuardianRelationship").val();
            var GuardianCommitment = $("#GuardianCommitment").val();
            var GuardianAddress = $("#GuardianAddress").val();
            var OrderOfBirth = $("#OrderOfBirth").val();
            
            var ExtendedFamilyBackgroundRemarks = $("#ExtendedFamilyBackgroundRemarks").val();
            var Siblings = $("#Siblings").val();
            
            
            
            var StudentSiblings = { StudentSiblingsID: ""};
            
            var ExternalSiblingsDetails = { ExternalSiblingName: "", ExternalSiblingSchool: "", ExternalSiblingStatus: "", ExternalSiblingEduc: "",  };
            
            
        
            
            //Educational Background    
            var AcademicStrengths = $("#AcademicStrengths").val();
            var AcademicWeaknesses = $("#AcademicWeaknesses").val();
            var RecognitionsReceived = $("#RecognitionsReceived").val();
            var OtherInterests = $("#OtherInterests").val();
            var SpecialNeeds = $("#SpecialNeeds").val();
            var DisciplinaryCase = $("#DisciplinaryCase").val();
            
            var OtherSchoolsAttended = { SchoolName: "", SchoolTypeOfInstitution: "", SchoolLocation: "", YearAttended: "", HighestEduc: "",  };
            
            
            var ConcernsForTransfer = $("#ConcernsForTransfer").val();
            var ReasonsForChoosing = $("#ReasonsForChoosing").val();
            var WhoDecides = $("#WhoDecides").val();
            var EducBackgroundRemarks = $("#EducBackgroundRemarks").val();
            
            var Referrals = { ReferredBy: "", Relationship: "" };
            
            
            //Organization Background
            var ChurchName = $("#ChurchName").val();
            var ChurchLocation = $("#ChurchLocation").val();
            var ChurchEngagement = $("#ChurchEngagement").val();
            var SchoolClubs = $("#SchoolClubs").val();
            var OtherOrg = $("#OtherOrg").val();
            var OrgBackgroundRemarks = $("#OrgBackgroundRemarks").val();
            
            var ExclusiveRelationship = { RelationshipToWhom: "", Relationship: ""  };
            
            
            //Health Background
            var RateOfGeneralHealth = $("#RateOfGeneralHealth").val();
            var HearingCondition = $("#HearingCondition").val();
            var EyesightCondition = $("#EyesightCondition").val();
            var Allergies = $("#Allergies").val();
            var OtherHealthConcerns = $("#OtherHealthConcerns").val();
            var HealthBackgroundRemarks = $("#HealthBackgroundRemarks").val();
            
            
            //Ancillary Information
            var FinalStrand = $("#FinalStrand").val();
            var ServicesOfInterest = $("#ServicesOfInterest").val();
            var SiblingDiscount = $("#SiblingDiscount").val();
            var AcademicScholarshipDiscount = $("#AcademicScholarshipDiscount").val();
            var PromotionalDiscount = $("#PromotionalDiscount").val();
            var EntranceScholarshipDiscount = $("#EntranceScholarshipDiscount").val();
            var VarsityDiscount = $("#VarsityDiscount").val();
            var STSDiscount = $("#STSDiscount").val();
            var QVRDiscount = $("#QVRDiscount").val();
            var ESCDiscount = $("#ESCDiscount").val();
            
            var EmployeeDiscount = $("#EmployeeDiscount").val();
            var BOTDiscount = $("#BOTDiscount").val();
            
            var AncillaryRemarks = $("#AncillaryRemarks").val();
            
            var ESCNumber = $("#ESCNumber").val();
            var QVRNumber = $("#QVRNumber").val();
            
            //Other Discount Validation
            var OtherDiscount = $("#OtherDiscount").val();
            if(isNaN(OtherDiscount) || OtherDiscount == null ){
                  FormValidator = false;
                $("#OtherDiscountControlGroup").addClass("error");
                $('#OtherDiscountControlGroup').css('color', "#b94a48");
                $("#OtherDiscount").css("border-color","#b94a48");
                $("#OtherDiscount").css("color","#b94a48");
                $("#OtherDiscountError").show();
                
                                
                
            }
            else{
                  $("#OtherDiscountControlGroup").removeClass("error");
                $('#OtherDiscountControlGroup').css('color', "#333");
                $("#OtherDiscount").css("border-color","#ccc");
                $("#OtherDiscount").css("color","#333");
                $("#OtherDiscountError").hide();
            }
            
                        //Varsity Discount Amount Validation
            var VarsityDiscountAmount = $("#VarsityDiscountAmount").val();
            if(isNaN(VarsityDiscountAmount) || VarsityDiscountAmount == null ){
                FormValidator = false;
                $("#VarsityDiscountAmountControlGroup").addClass("error");
                $('#VarsityDiscountAmountControlGroup').css('color', "#b94a48");
                $("#VarsityDiscountAmount").css("border-color","#b94a48");
                $("#VarsityDiscountAmount").css("color","#b94a48");
                $("#VarsityDiscountAmountError").show();
                

            }
            else{
                $("#VarsityDiscountAmountControlGroup").removeClass("error");
                $('#VarsityDiscountAmountControlGroup').css('color', "#333");
                $("#VarsityDiscountAmount").css("border-color","#ccc");
                $("#VarsityDiscountAmount").css("color","#333");
                $("#VarsityDiscountAmountError").hide();
            }
            
            //BOT Discount Amount Validation
            var BOTDiscountAmount = $("#BOTDiscountAmount").val();
            if(isNaN(BOTDiscountAmount) || BOTDiscountAmount == null ){
                FormValidator = false;
                $("#BOTDiscountAmountControlGroup").addClass("error");
                $('#BOTDiscountAmountControlGroup').css('color', "#b94a48");
                $("#BOTDiscountAmount").css("border-color","#b94a48");
                $("#BOTDiscountAmount").css("color","#b94a48");
                $("#BOTDiscountAmountError").show();
                

            }
            else{
                $("#BOTDiscountAmountControlGroup").removeClass("error");
                $('#BOTDiscountAmountControlGroup').css('color', "#333");
                $("#BOTDiscountAmount").css("border-color","#ccc");
                $("#BOTDiscountAmount").css("color","#333");
                $("#BOTDiscountAmountError").hide();
            }
            
            
            
            
            var StudentDetails = { Phase2HomeNumber: Phase2HomeNumber, Phase2MobileNumber: Phase2MobileNumber, Phase2Nickname: Phase2Nickname, Phase2FacebookMessenger: Phase2FacebookMessenger, Phase2PersonalInfoRemarks: Phase2PersonalInfoRemarks, FatherFullName: FatherFullName, FatherAge: FatherAge, FatherReligion: FatherReligion, FatherOccupation: FatherOccupation, FatherCompany: FatherCompany, FatherCompanyLocation: FatherCompanyLocation, FatherEducAttainment: FatherEducAttainment, FatherSupport: FatherSupport, MotherFullName: MotherFullName, MotherAge: MotherAge, MotherReligion: MotherReligion, MotherOccupation: MotherOccupation, MotherCompany: MotherCompany, MotherCompanyLocation: MotherCompanyLocation, MotherEducAttainment: MotherEducAttainment, MotherSupport: MotherSupport, ParentAddress: ParentAddress, ParentStatus: ParentStatus, ParentHomeNum: ParentHomeNum, ParentMobileNum: ParentMobileNum, FatherFB: FatherFB, MotherFB: MotherFB, FamilyBackgroundRemarks: FamilyBackgroundRemarks, GuardianName: GuardianName, GuardianMessenger: GuardianMessenger, GuardianHomeNumber: GuardianHomeNumber, GuardianMobileNumber: GuardianMobileNumber, GuardianRelationship: GuardianRelationship, GuardianCommitment: GuardianCommitment, GuardianAddress: GuardianAddress, OrderOfBirth: OrderOfBirth, ExtendedFamilyBackgroundRemarks: ExtendedFamilyBackgroundRemarks, StudentSiblings: [], ExternalSiblingsDetails: [], AcademicStrengths: AcademicStrengths, AcademicWeaknesses: AcademicWeaknesses, RecognitionsReceived: RecognitionsReceived, OtherInterests: OtherInterests, SpecialNeeds: SpecialNeeds, DisciplinaryCase: DisciplinaryCase, OtherSchoolsAttended: [], ConcernsForTransfer: ConcernsForTransfer, ReasonsForChoosing: ReasonsForChoosing, WhoDecides: WhoDecides, EducBackgroundRemarks: EducBackgroundRemarks, Referrals: [], ChurchName: ChurchName, ChurchLocation: ChurchLocation, ChurchEngagement: ChurchEngagement, SchoolClubs: SchoolClubs, OtherOrg: OtherOrg, OrgBackgroundRemarks: OrgBackgroundRemarks, ExclusiveRelationship: [], RateOfGeneralHealth: RateOfGeneralHealth, HearingCondition: HearingCondition,  EyesightCondition: EyesightCondition, Allergies: Allergies, OtherHealthConcerns: OtherHealthConcerns, HealthBackgroundRemarks: HealthBackgroundRemarks, FinalStrand: FinalStrand, ServicesOfInterest: ServicesOfInterest, SiblingDiscount: SiblingDiscount,  AcademicScholarshipDiscount: AcademicScholarshipDiscount, PromotionalDiscount: PromotionalDiscount,  EntranceScholarshipDiscount: EntranceScholarshipDiscount, VarsityDiscount: VarsityDiscount, STSDiscount: STSDiscount, QVRDiscount: QVRDiscount, ESCDiscount: ESCDiscount, AncillaryRemarks: AncillaryRemarks, OtherDiscount: OtherDiscount, QVRNumber: QVRNumber, ESCNumber: ESCNumber, BOTDiscount: BOTDiscount, EmployeeDiscount: EmployeeDiscount, VarsityDiscountAmount: VarsityDiscountAmount, BOTDiscountAmount: BOTDiscountAmount    };

            
          
            
            if(Siblings != null){
                
                    for(var x = 0; x<Siblings.length; x++){
                            StudentDetails.StudentSiblings.push(Siblings[x]);
                    }
                
                
            }
            
            
            
            
            //External Siblings List
            var oTable = $('#ExternalSiblingsList').dataTable().fnGetData();

                if (oTable != "") {

                    for (var i = 0; i < oTable.length; i++) {

                      
                        ExternalSiblingsDetails.ExternalSiblingName = oTable[i][0];
                        ExternalSiblingsDetails.ExternalSiblingSchool = oTable[i][2];
                        ExternalSiblingsDetails.ExternalSiblingStatus = oTable[i][4];
                        ExternalSiblingsDetails.ExternalSiblingEduc = oTable[i][5];
                        
                        StudentDetails.ExternalSiblingsDetails.push(ExternalSiblingsDetails);

                        var ExternalSiblingsDetails = { ExternalSiblingName: "", ExternalSiblingSchool: "", ExternalSiblingStatus: "", ExternalSiblingEduc: "",  };


                    }
                }

                else {

                    
                }
                    
                
            
            
            //Other Schools Attended
            var oTable2 = $('#OtherSchoolsAttendedList').dataTable().fnGetData();

                if (oTable2 != "") {

                    for (var i = 0; i < oTable2.length; i++) {

                      
                        OtherSchoolsAttended.SchoolName = oTable2[i][0];
                        OtherSchoolsAttended.SchoolLocation = oTable2[i][2];
                        OtherSchoolsAttended.YearAttended = oTable2[i][3];
                        OtherSchoolsAttended.SchoolTypeOfInstitution = oTable2[i][5];
                        OtherSchoolsAttended.HighestEduc = oTable2[i][6];
                        
                        StudentDetails.OtherSchoolsAttended.push(OtherSchoolsAttended);

                      var OtherSchoolsAttended = { SchoolName: "", SchoolTypeOfInstitution: "", SchoolLocation: "", YearAttended: "", HighestEduc: "",  };


                    }
                }

                else {

                    
                }

                        
            //Referrals
            var oTable3 = $('#ReferralsList').dataTable().fnGetData();

                if (oTable3 != "") {

                    for (var i = 0; i < oTable3.length; i++) {

                      
                        Referrals.ReferredBy = oTable3[i][0];
                        Referrals.Relationship = oTable3[i][1];
                      
                        
                        StudentDetails.Referrals.push(Referrals);

                         var Referrals = { ReferredBy: "", Relationship: "" };


                    }
                }

                else {

                    
                }
        
            
            
            
            //Exclusive Relationship
            var oTable4 = $('#ExclusiveRelationshipList').dataTable().fnGetData();

                if (oTable4 != "") {

                    for (var i = 0; i < oTable4.length; i++) {

                      
                        ExclusiveRelationship.RelationshipToWhom = oTable4[i][0];
                        ExclusiveRelationship.Relationship = oTable4[i][1];
                      
                        
                        StudentDetails.ExclusiveRelationship.push(ExclusiveRelationship);

                         var ExclusiveRelationship = { RelationshipToWhom: "", Relationship: ""  };


                    }
                }

                else {

                    
                }
                    
            if(FormValidator){
                   $.ajax({
                            type:'POST',
                            url:'UpdatePhase2Submit.php',
                            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                            success:function(html){
                                 
                                    window.location.href="/iucsenrollmentsystem/webpages/ForInterviewList.php";
                                   
                    
                            }, // After Ajax Submit
                       
                       error: function(request, error) {
                            
                                 $.gritter.add({
			                         title: 'Operation Failed!',
			                         text: 'System Error! Please contact the IT Team of Imus Unida Christian School',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 $(".gritter-item").css("background","#ff0000");
        
                        }
                }); 
            }
            else{
                 document.documentElement.scrollTop = 0;
                 
              $.gritter.add({
			       title: 'Operation Failed!',
			       text: 'Some fields might not be inputted properly! Check for errors!',
                   time: 6000,
			       image: 'img/demo/checkmark.png',
			       sticky: false,
                   position: 'center'
		      });	
                    
                $(".gritter-item").css("background","#ff0000");
    
                
                
            }
            
            
        }
      
               
    });
    

    
    
        
    
</script>
    
    





    
    
    </body>
</html>
    
    
    
    
    
    
    
    
    