<?php 


//Code For User Authentication For Each Web Page
session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}


include 'adminheader.php';

$EditProfileID = 247;
$_SESSION['EditStudentSelectedStudentIDDisplay'] = "";
$_SESSION['EditStudentSelectedReferenceNum'] = "";
$_SESSION['EditStudentAdmissionNumber'] = "";

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




//Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblstudent WHERE StudentID = :StudentID");
    $statement->execute(array(':StudentID' => $EditProfileID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
              $RetrieveStudentIDDisplay = $row['StudentIDDisplay'];
              $_SESSION['EditStudentSelectedStudentIDDisplay'] = $RetrieveStudentIDDisplay;
              $RetrieveESCNumber = $row['ESCNumber'];
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
        
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
   





//Get the latest admission record
try
{
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID HAVING LEFT(AdmissionReferenceNum,4) = :LatestSchoolYear  ");
    $statement->execute(array(':AdmissionStudentID' => $EditProfileID, ':LatestSchoolYear' => $LatestSchoolYear     ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              //$RetrieveStudentIDDisplay = $data['StudentIDDisplay'];
              $RetrieveAdmissionID = $data['AdmissionID'];
              $_SESSION['EditStudentAdmissionNumber'] = $data['AdmissionID'];
              $RetrieveReferenceNumber = $data['AdmissionReferenceNum'];
              $_SESSION['EditStudentSelectedReferenceNum'] = $RetrieveReferenceNumber;
              $RetrieveSectionID = $data['AdmissionSectionID'];
              $RetrieveModeOfPaymentID = $data['AdmissionModeOfPaymentID'];
              $RetrieveSiblingDiscountID = $data['AdmissionSiblingDiscountID'];
              $RetrieveAcademicScholarshipDiscountID = $data['AdmissionAcademicScholarshipDiscountID'];
              $RetrievePromotionalDiscountID = $data['AdmissionPromotionalDiscountID'];
              $RetrieveEntranceScholarshipDiscountID = $data['AdmissionEntranceScholarshipDiscountID'];
              $RetrieveVarsityDiscountID = $data['AdmissionVarsityDiscountID'];
			  $RetrieveSTSDiscountID = $data['AdmissionSTSDiscountID'];
              $RetrieveGradeLevelID = $data['AdmissionGradeLevelID'];
              $RetrieveAdmissionStatus = $data['AdmissionStatus'];
              $RetrieveSchoolOfOrigin = $data['AdmissionSchoolOfOrigin'];
              $RetrieveTypeOfInstitution = $data['AdmissionTypeOfInstitution'];
              
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






//Get siblings
try
{
 
    $SiblingIndex = 0;
    $SiblingList;
    
$statement = $dbh->prepare("SELECT StudentID,FirstName,LastName FROM tblsibling, tblstudent WHERE SiblingMainStudentID = :MainStudentID AND StudentID = SiblingStudentID AND StudentStatus = 0 ");
    $statement->execute(array(':MainStudentID' => $EditProfileID   ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              $SiblingList[$SiblingIndex] = $data['StudentID'];
              $SiblingIndex++;
             
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






//Get strands

/*
try
{
 
    $StrandIndex = 0;
    $StrandID;
    $StrandName;
    
    $Strands;
   //'tn' => 'Tunisia',
   //'us' => 'United States',
   

    
    $statement = $dbh->prepare("SELECT * FROM tblstrand  ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              $Strands->$StrandID[$StrandIndex] = $data['StrandID'];
              $Strands->$StrandName[$StrandIndex] = $data['StrandName'];
              $StrandIndex++;
             
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


*/















/*
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
   
       $ReferenceNumThisYear = "1";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


*/




/*
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
   
      $StudentsEnrolledThisSchoolYear = 2411;
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

*/









/*

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

*/




/*

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


*/


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
 <center><h1>Edit Student Profile</h1></center>
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Student Personal Information</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
              
        
           <div class="control-group" id="ReferenceNumControlGroup">
              <label class="control-label">*Reference Number: </label>
              <div class="controls">
                <input type="text" name="ReferenceNum" id="ReferenceNum" class="span11" placeholder="e.g. 2014-000001" value="<?php echo $RetrieveReferenceNumber; ?>"/>
                  
                <span class="help-inline" style="color: #b94a48; display: none;" id="ReferenceNumError"  name="ReferenceNumError">Reference Num already exists!</span> 
              </div>
            </div>
              <!--
                <div class="control-group">
              <label class="control-label">*Student ID :</label>
              <div class="controls">
                <input type="text" disabled name="StudentID" id="StudentID" class="span11" placeholder="e.g. 2014-000001" value=" />
                  
                <input type="hidden" name="StudentIDMainField" id="StudentIDMainField" >
              </div>
            </div>
              


              
            -->
     
         
                
                
            
            
                  <div class="control-group" id="StudentIDControlGroup">
                    <label class="control-label">*Student #:</label>
                    <div class="controls">
                     <input type="text" placeholder="e.g. 2014-000001"  class="span11" value="<?php echo $RetrieveStudentIDDisplay; ?>"  id="StudentIDMainField" name="StudentIDMainField"   />'
                   <!-- <input type="hidden" name="StudentIDMainField" id="StudentIDMainField" value= ""> -->
                        
                          <span class="help-inline" style="color: #b94a48; display: none;" id="StudentIDError"  name="StudentIDError">Student ID already exists!</span> 
                        
                    </div>
            
                   </div>
                
        
    
              
                  
           
                
               
              
              
              
            <div class="control-group" id="LRNNumControlGroup">
              <label class="control-label">*LRN #:</label>
              <div class="controls">
                <input type="text" class="span11" name="LRNNum" id="LRNNum" placeholder="457848457744" value="<?php echo $RetrieveLRNNumber; ?>" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="LRNNumError"  name="LRNNumError">Invalid LRN Number</span> 
              </div>
            </div>
            <div class="control-group" id="LastNameControlGroup">
              <label class="control-label">*Last Name :</label>
              <div class="controls">
                <input type="text" name="LastName" id="LastName" class="span11" placeholder="Last name" value="<?php echo $RetrieveLastName; ?>" />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="LastNameError"  name="LastNameError">Invalid Last Name</span>
              </div>
            </div>
              
              <div class="control-group" id="FirstNameControlGroup">
              <label class="control-label">*First Name :</label>
              <div class="controls">
                <input type="text" name="FirstName" id="FirstName" class="span11" placeholder="First name" value="<?php echo $RetrieveFirstName; ?>" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="FirstNameError"  name="FirstNameError">Invalid First Name</span>
              </div>
            </div>
              
              
              <div class="control-group" id="MiddleNameControlGroup">
              <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="MiddleName" id="MiddleName" class="span11" placeholder="Middle name" value="<?php echo $RetrieveMiddleName; ?>" />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="MiddleNameError"  name="MiddleNameError">Invalid Middle Name</span>
              </div>
            </div>
              
                 <div class="control-group">
              <label class="control-label">*Gender</label>
              <div class="controls">
                <select name="Gender" id="Gender" >
                  <option value="0" <?php  if($RetrieveGender == 0) { echo 'selected' ;}  ?>>Male</option>
                  <option value="1" <?php  if($RetrieveGender == 1) { echo 'selected' ;}  ?>>Female</option>
                
                </select>
              </div>
            </div>
              
              
                 <div class="control-group">
              <label class="control-label">*Nationality</label>
              <div class="controls">
                <select name="Nationality" id="Nationality">
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
                  <input type="text" name="Birthday" id="Birthday"  data-date-format="mm-dd-yyyy" class="span11" value="<?php echo $RetrieveBirthday; ?>" >
                  <span class="add-on"><i class="icon-th"></i></span> </div>
                    <span class="help-inline" style="color: #b94a48; display: none;" id="BirthdayError"  name="BirthdayError">Please enter a valid date</span>
              </div>
            </div>
              
              <div class="control-group" id="AgeControlGroup">
              <label class="control-label">Age :</label>
              <div class="controls">
                <input type="text" name="Age" id="Age" class="span11" placeholder="Age" value="<?php echo $RetrieveAge; ?>" />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="AgeError"  name="AgeError">Invalid Age</span>
              </div>
            </div>
              
              
                 <div class="control-group" id="PlaceOfBirthControlGroup">
              <label class="control-label">Place of Birth</label>
              <div class="controls">
                <textarea name="PlaceOfBirth" id="PlaceOfBirth" class="span11" ><?php echo $RetrievePlaceOfBirth; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="PlaceOfBirthError"  name="PlaceOfBirthError">Please enter place of birth </span>
              </div>
            </div>
              
              
                 <div class="control-group">
              <label class="control-label">*Religion</label>
              <div class="controls">
                <select name="Religion" id="Religion">
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
              
              
    
          
            
          </form>
        </div>
      </div>
            
            
            
            
        </div>
        
        <!-- span 6 -->
        
        
        <!-- second span 6 -->
        
        
    <div class="span6">
        
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Parent Information</h5>
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
              
              
              <!--
              
              
                <div class="control-group">
              <label class="control-label">Last Name :</label>
              <div class="controls">
                <input type="text" name="FatherLastName" id="FatherLastName" class="span11" placeholder="Last Name" />
              </div>
            </div>
              
              
                <div class="control-group">
              <label class="control-label">First Name :</label>
              <div class="controls">
                <input type="text" name="FatherFirstName" id="FatherFirstName" class="span11" placeholder="First Name" />
              </div>
            </div>
              
              
              
              
              
                  <div class="control-group">
              <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="FatherMiddleName" id="FatherMiddleName" class="span11" placeholder="Middle Name" />
              </div>
            </div>
              -->
              
                  <div class="control-group">
              <label class="control-label">Occupation :</label>
              <div class="controls">
                <input type="text"  name="FatherOccupation" id="FatherOccupation" class="span11" placeholder="e.g. Doctor" value="<?php echo $RetrieveFatherOccupation; ?>" />
              </div>
            </div>
              
               <h3><center>Mother</center></h3>
              
              
               <div class="control-group">
              <label class="control-label">Mother's Maiden Name :</label>
              <div class="controls">
                <input type="text" name="MotherFullName" id="MotherFullName" class="span11" placeholder="Mother's Full Name" value="<?php echo $RetrieveMotherFullName; ?>" />
              </div>
            </div>
              
              
              
              <!--
                <div class="control-group">
              <label class="control-label">Last Name :</label>
              <div class="controls">
                <input type="text" name="MotherLastName" id="MotherLastName" class="span11" placeholder="Last Name" />
              </div>
            </div>
              
              
                <div class="control-group">
              <label class="control-label">First Name :</label>
              <div class="controls">
                <input type="text" name="MotherFirstName" id="MotherFirstName" class="span11" placeholder="First Name" />
              </div>
            </div>
              
              
              
              
              
                  <div class="control-group">
              <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="MotherMiddleName" id="MotherMiddleName" class="span11" placeholder="Middle Name" />
              </div>
            </div>
               -->
              
                  <div class="control-group">
              <label class="control-label">Occupation :</label>
              <div class="controls">
                <input type="text"  name="MotherOccupation" id="MotherOccupation" class="span11" placeholder="e.g. Doctor"  value="<?php echo $RetrieveMotherOccupation; ?>"/>
              </div>
            </div>
              

              <br>
              <br>
            
            
          </form>
        </div>
      </div>
        
        
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5>Previous Enrollment Information</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
          <h3><center>School of Origin</center></h3>
              
                <div class="control-group">
              <label class="control-label">School :</label>
              <div class="controls">
                <input type="text" name="SchoolOfOrigin" id="SchoolOfOrigin" class="span11" placeholder="e.g. Imus Unida Christian School" value="<?php echo $RetrieveSchoolOfOrigin; ?>" />
              </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">*Type of Institution</label>
              <div class="controls">
                <select name="TypeOfInstitution" id="TypeOfInstitution">
                    <option value="0" 
                            <?php if($RetrieveTypeOfInstitution == 0){echo "selected"; } else {echo ""; }?>
                            >Private</option>
                    <option value="1" <?php if($RetrieveTypeOfInstitution == 1){echo "selected"; } else {echo ""; }?>>Public</option>
                
                </select>
              </div>
            </div>
              
             <hr style="height:15px; visibility:hidden;" />
              
          </form>
        </div>
      </div>
            
    
        
        
    </div>
        
        
        
        
   
    </div>
      
      <!-- row end -->
      
<div class="row-fluid">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Address and Contact Information</h5>
        </div>
        <div class="widget-content nopadding">
        
          <h3><center>Address</center></h3>
              
           
        <div class="row-fluid">
            
            <div class="span1"></div>
            
            <!--
            <div class="span3" id="HouseNumControlGroup">
                   <label class="control-label">*House #</label>
              <div class="controls">
                <input type="text"  name="HouseNum" id="HouseNum" class="span10 m-wrap" placeholder="e.g. Blk. 3 Lot 2"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="HouseNumError"  name="HouseNumError">Invalid House # </span>
              
                  
                      
            </div>
                </div>
-->
            <!--
            <div class="span3" id="StreetControlGroup">
            
        
                   
                   <label class="control-label">Street</label>
              <div class="controls">
                <input type="text" name="Street" id="Street" class="span10 m-wrap" placeholder="e.g.Emerald Street"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="StreetError"  name="StreetError">Invalid Street </span>
              </div>
                      
          
            
            
            </div>
            -->
            <!--
              <div class="span3">
                   <label class="control-label">Village</label>
              <div class="controls">
                <input type="text" name="Village" id="Village" class="span10 m-wrap" placeholder="e.g. Velarde Village"/>
              </div>
                      
            </div>

-->
            
               <div class="span4" id="AddressPrefixControlGroup">
                   <label class="control-label">House #, Street, Village if any</label>
              <div class="controls">
                <!--<input type="text" name="Village" id="Village" class="span10 m-wrap" placeholder="e.g. Velarde Village"/> -->
                  
                   <textarea name="AddressPrefix" id="AddressPrefix" class="span11" > <?php echo $RetrieveAddressPrefix; ?></textarea>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="AddressPrefixError"  name="AddressPrefixError">Please enter address </span>
              </div>
                      
            </div>
            
                <div class="span3" id="BarangayControlGroup">
                   <label class="control-label">*Barangay</label>
              <div class="controls">
                <input type="text" name="Barangay" id="Barangay" class="span10 m-wrap" placeholder="e.g. Poblacion I-C" value="<?php echo $RetrieveBarangay; ?>"  />
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="BarangayError"  name="BarangayError">Invalid Barangay </span>
              </div>
                      
            </div>
            
                <div class="span3">
            
        
                   
                   <label class="control-label">*Municipality/City</label>
                <div class="controls">
                <select name="Municipality" id="Municipality">
                  <?php 
                                                        
                                                    
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblmunicipality");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveMunicipality == $data['MunicipalityID']){
                $selected = "selected";
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['MunicipalityID'] . '" '. $selected .'>' . $data['MunicipalityName'] . '</option>';
        
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
            
            <!-- first row end -->
<div class="row-fluid">
    <div class="span8"></div>
    <div class="span3">
            <label class="control-label">*Province/Region</label>
                <div class="controls">
                <select name="Province" id="Province">
                    <option value="0">Province/Region not set</option>
                  <?php 
                                                        
                                                        
try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblprovince");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveProvince == $data['ProvinceID']){
                $selectedprovince = "selected";
            }
            else{
                $selectedprovince = "";
            }
           echo '<option value ="' . $data['ProvinceID'] . '" '. $selectedprovince .'>' . $data['ProvinceName'] . '</option>';
        
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
            
           
            
        
            <!--
            
              <div class="span3">
                   <label class="control-label">*Province</label>
            
                 <div class="controls">
                <select disabled>
                  <option>Cavite</option>
                  <option>Laguna</option>
                
                </select>
              </div>
             
                      
            </div>
-->
            
     </div>
           
          <!-- 2nd row end -->
           <h3><center>Contact Details</center></h3>
  
            <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5">
              
                   <label class="control-label">Home Number</label>
              <div class="controls">
                <input type="text" name="HomeNum" id="HomeNum" class="span10 m-wrap" placeholder="e.g. 434-0505"   value="<?php echo $RetrieveHomeNumber; ?>"/>
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5">
              
                   <label class="control-label">Mobile Number</label>
              <div class="controls">
                <input type="text" name="MobileNum" id="MobileNum" class="span10 m-wrap" placeholder="e.g. 09051234567"   value="<?php echo $RetrieveMobileNumber; ?>"/>
              </div>
                      
           
                
                 </div>
  
            
           
                
                
            
            </div>
              
            
                 <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5" id="ContactPersonControlGroup">
              
                   <label class="control-label">*Contact Person</label>
              <div class="controls">
                <input type="text" name="ContactPerson" id="ContactPerson" class="span10 m-wrap" placeholder="e.g. Juan dela Cruz"  value="<?php echo $RetrieveContactPerson; ?>"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="ContactPersonError"  name="ContactPersonError">Contact Person is required </span>
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5">
              
                   <label class="control-label">E-mail address</label>
              <div class="controls">
                <input type="text" name="EmailAddress" id="EmailAddress"  value="<?php echo $RetrieveEmailAddress; ?>" class="span10 m-wrap" placeholder="e.g. juandelacruz@gmail.com"/>
              </div>
                      
           
                
                 </div>
  
            
           
                
                
            
            </div>
              
              
            
                 <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5" id="RelationshipControlGroup">
              
                   <label class="control-label">*Relationship to Contact Person</label>
              <div class="controls">
                <input type="text"   value="<?php echo $RetrieveRelationshipToContactPerson; ?>" name="Relationship" id="Relationship" class="span10 m-wrap" placeholder="e.g. Mother"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="RelationshipError"  name="RelationshipError">This field is required </span>
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5" id="ContactPersonContactNumberControlGroup">
              
                   <label class="control-label">*Contact Person Contact Number</label>
              <div class="controls">
                <input type="text"   value="<?php echo $RetrieveContactPersonContactNumber; ?>" name="ContactPersonContactNumber" id="ContactPersonContactNumber" class="span10 m-wrap" placeholder="e.g. 09051234567"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="ContactPersonContactNumberError"  name="ContactPersonContactNumberError">Contact # of Contact Person is required </span>
              </div>
                      
           
                <br>
                       <br>
                 </div>
  
            
           
                
                
            
            </div>
            
              
             
        
        
        
        
        
        
        
        </div>
        
<!-- widget content padding -->
        
        
        
        
    </div>
<!-- widget box -->
        
        
     

    
  
  </div>
      
      <!-- end 2nd row fluid -->

    
      
    <div class="row-fluid">
          <div class="widget-box">
               <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Current Admission Information</h5>
                </div>
              
              <div class="widget-content nopadding">
                  
                  
                  
                  
                  
                     <div class="row-fluid">
            
            <div class="span1"></div>
            
            <div class="span3">
                   <label class="control-label">*Grade Level</label>
              
                
                 <div class="controls">
                <select name="GradeLevel" id="GradeLevel">
                    <option value="0">No Grade Level selected</option>
    <?php 
             try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel ORDER BY GradeLevel ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveGradeLevelID == $data['GradeLevelID']){
                $selected = "selected";
                
            }else{
                $selected = "";
            }
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected .'>' . $data['GradeLevel'] . '</option>';
        
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
            
                         
               <div class="span3" id="SectionControlGroup">
                   <label class="control-label">Section</label>
              
                
                 <div class="controls">
                <select name="Section" id="Section">
                  
                    
                    
                    <?php 
             try
{
 
    echo '<option value ="0" > No section yet </option>   ';
   
    $statement = $dbh->prepare("SELECT * FROM tblsection WHERE SectionGradeLevel = :FirstSection ");
    $statement->execute(array(':FirstSection' => $RetrieveGradeLevelID));
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveSectionID == $data['SectionID']){
                $selected = "selected";
            }else{
                $selected = "";
            }
           echo '<option value ="' . $data['SectionID'] . '" '. $selected .'>' . $data['SectionName'] . '</option>';
        
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
                     
                     <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="SectionError"  name="SectionError">Please select section </span>
              </div>
                  
                  
            
                      
            </div>
          
                         
                         
            <div class="span4" name="DivStrand" id="StrandControlGroup">
                   <label class="control-label">Strand (FOR SHS)  </label>
              
                
                 <div class="controls">
                <select name="SHSStrand" id="SHSStrand" >
                    
                    
                    <?php 
                    
                    $GradeLevelID = (int)$RetrieveGradeLevelID;
                    
                   
                    
                    if($RetrieveGradeLevelID == 14 || $RetrieveGradeLevelID == 15){
                        
                        
                        
                          $statement = $dbh->prepare("SELECT * FROM tblstrand  ");
                          $statement->execute();
                          $row = $statement->fetchAll();
    
                          if (!empty($row)) {
        
                              
                             echo '<option value="0">No strand selected </option>';
                              
                              
                                foreach($row as $data){
                                        
                                    
                                    if($RetrieveStrand == $data['StrandID']){
                                        $selected = "selected";
                                    }
                                    else{
                                        $selected = "";
                                    }
                                    
                                     echo '<option value ="' . $data['StrandID'] . '" '. $selected .'>' . $data['StrandName'] . '</option>';
             
                                }
                          } 
                            else {
   
                                    //echo '<h1>Error in selecting from database </h1>';
    
                            }
                     
                        
                        
                        
                        
                        
                    }
                    else{
                       
                        echo "<option value='0'>Strands not available</option>";
                    
                    }
                    
                      
                    ?>
                    
                 
                
                </select>
                     
                     <span class="help-inline" style="color: #b94a48; display: none; " id="StrandError"  name="StrandError">Strand is required for SHS Students </span>
              </div>
                  
                  
            
                      
            </div>
            
            
          
            
     </div>
                  
              
                  
                  
                  
                  <br>
                  <br>
                  
                  
    <div class="row-fluid">
                  <div class="span3"></div>
        
        
        <div class="span3">
        
        
              <div class="controls">
                <label style="font-size: 20px;">
                  <input type="checkbox" name="radios" name="ESCCheckbox" id="ESCCheckbox"  <?php if($RetrieveESCNumber != null){ echo 'checked'; } ?>   />
                  ESC/QVR Grantee</label>
               
              </div>
        
        </div>
        
        
        
        
        
        <div class="span4" id="ESCNumberControlGroup">
        
        
             <label class="control-label">ESC Number</label>
              <div class="controls">
                <input type="text" name="ESCNumber" id="ESCNumber" class="span10 m-wrap" placeholder="e.g. 2015784578441254" value="<?php echo $RetrieveESCNumber; ?>"/>
                  
                   <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="ESCNumberError"  name="ESCNumberError">ESC Number is required </span>
              </div>
                      
        
        </div>
        
        
        
        
        
        
        
        
                  
                  
                
    </div>    
                  
                  
                  <br>
                  <br>
                  
                  
<div class="row-fluid">
  
    
    
    <div class="span5" style="margin-left: 40px;">
      <label class="control-label">Sibling </label>
              <div class="controls">
                <select multiple="multiple" name="Siblings[]" id="Siblings" >
                  
                    
                    
<?php 
                                                        
                                                        
        try
{
 
    $LatestSchoolYearMinus15 = $LatestSchoolYear - 15;
   
    $statement = $dbh->prepare("SELECT * FROM tblstudent  WHERE StudentStatus = 0   ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            
         if(!empty($SiblingList)){
                
         foreach($SiblingList as $TotalSiblings){
                if($TotalSiblings == $data['StudentID']){
                    $selected = "selected";
                    break;
                }
                else{
                    $selected = "";
                   
                }
                
         
                
         }
         }
		 else{
		 $selected = "";
		 }
            
            echo '<option value ="' . $data['StudentID'] . '" '. $selected .'>' .$data['StudentIDDisplay'].'- '.$data['FirstName'].      ' '.$data['MiddleName']. ' '.$data['LastName']. '</option>';
        
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
       <label class="control-label">*Mode of Payment </label>
              
                
                 <div class="controls">
                <select name="ModeOfPayment" id="ModeOfPayment" >
                    <option value="0">Mode of Payment not set</option>
               <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblpaymentoption");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveModeOfPaymentID == $data['PaymentOptionID']){
                $selected = "selected";
            }else{
                $selected = "";
            }
           echo '<option value ="' . $data['PaymentOptionID'] . '" '. $selected .'>' . $data['PaymentOptionName'] . '</option>';
        
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
              
                  <br>
                  <br>

                  
<div class="row-fluid">
                  
  <div class="span5" style="margin-left: 40px;">
       <label class="control-label">Sibling Discount </label>
              
                
                 <div class="controls">
                <select name="SiblingDiscount" id="SiblingDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 1");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveSiblingDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }else{
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
            }else{
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
                  
                  
                     
                  
                  
                      <br>
                  <br>

                  
<div class="row-fluid">
                  
  <div class="span5" style="margin-left: 40px;">
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
            }else{
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
 
    +
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 4");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
              if($RetrieveEntranceScholarshipDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }else{
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
                 
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                                    <br>
                  <br>

                  
<div class="row-fluid">
                  
  <div class="span5" style="margin-left: 40px;">
       <label class="control-label">Varsity Discount </label>
              
                
                 <div class="controls">
                <select name="VarsityDiscount" id="VarsityDiscount">
                 <option value="0">None</option>
                    <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 5");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
              if($RetrieveVarsityDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }else{
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
       <label class="control-label">STS Discount for SHS </label>
              
                
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
            
              if($RetrieveSTSDiscountID == $data['DiscountTypeID']){
                $selected = "selected";
            }else{
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
    
	
	
	
	
	
	
	
    
        <input type="hidden" id="EditProfileStudentID" name="EditProfileStudentID" value="<?php echo $EditProfileID; ?>">
        <input type="hidden" id="EditProfileAdmissionID" name="EditProfileAdmissionID" value="<?php echo $RetrieveAdmissionID ?>">
        
        
       
    
        
        
        
        
        
        
        
        
        
        
        
        
        
  

    
    
                  
</div>
                      <hr> 
                      <hr> 
                  <br>
				  <br>
                  
				  <div class="span3">
                  
                         <label class="control-label">Enrollment Status </label>
                      <div class="controls">
                        <select name="EnrollmentStatus" id="EnrollmentStatus">
                          
                            <option value="0" <?php 
                                    if($RetrieveAdmissionStatus == 0){
                                        echo 'selected';
                                    }
                                    ?>>Enrolled</option>
                            <option value="1"  <?php 
                                    if($RetrieveAdmissionStatus == 1){
                                        echo 'selected';
                                    }
                                    ?>>Pulled-out</option>
                         
                           
                          </select>
                      </div>
                      
                  
                  </div>
                  
                    <div class="span3" >
                  
                         <label class="control-label">Enrollment Update </label>
                      <div class="controls">
                        <select name="EnrollmentUpdate" id="EnrollmentUpdate">
                        </select>
                      </div>
                      
                  
                  </div>
                  
                  
                  
    <div id="_divDatePullOut" class="span3" style="margin-top:-10px; <?php if($RetrieveAdmissionStatus == 0){ echo "visibility: hidden;";} ?>">
            <label class="control-label">Date of Pull Out: </label>
              <div class="controls">
                <div  data-date="12-02-2012" class="input-append date datepicker">
                  <input type="text" name="DateOfPullOut" id="DateOfPullOut"  data-date-format="mm-dd-yyyy" class="span11"  >
                  <span class="add-on"><i class="icon-th"></i></span> </div>
                    
              </div>
          
    </div>
                  
                   
<div class="row">
        <div class="span6"></div>
    
        <div class="span3" style="margin-top: 25px; margin-left: 100px;" >
            <button type="button" id="SubmitButton" class="btn btn-large btn-success">Save</button>
              
            <a href="StudentRecordsList.php">  <button type="button"  id="CancelButton" class="btn btn-large btn-danger">Cancel</button></a>
    
        </div>
                  
</div>            
   
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                
                  
                  
                      <br>
        <br>
        <br>
        <div class="span6"></div>
             
              
                  
                  
                  
                  <br>
                  <br>
                  <br>
                  
                  
                  
                  
                  
                  
                  
                  
                  
              
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
                  
              </div>
              
              
              
              
              
        </div>
      
      
    
      
    </div>
      
      
      
      
      
      
      
      
      
      
      
      
      
      
    
    <!-- end-container -->
    
</div>

<!--end-main-container-part-->
    
    
    

<div class="row-fluid">
  <div id="footer" class="span12"> 2019 &copy; Imus Unida Christian School </div>
</div>

<!--end-Footer-part-->

<script src="js/excanvas.min.js"></script> 
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/bootstrap-colorpicker.js"></script> 
<script src="js/bootstrap-datepicker.js"></script> 

<script src="js/masked.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/matrix.js"></script> 

    
<script type="text/javascript">
    
    
$(document).ready(function(){
 
     $("select#EnrollmentStatus").change();
     $("select#Province").change();
    
    
});
    
</script>
<script src="js/matrix.form_common.js"></script>
<script src="js/wysihtml5-0.3.0.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/bootstrap-wysihtml5.js"></script> 
<script src="js/jquery.flot.min.js"></script> 
<script src="js/jquery.flot.resize.min.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/fullcalendar.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.dashboard.js"></script> 
<script src="js/jquery.gritter.min.js"></script> 
<script src="js/matrix.interface.js"></script> 
<script src="js/matrix.chat.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.form_validation.js"></script> 
<script src="js/jquery.wizard.js"></script> 
<script src="js/matrix.popover.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 

<script src="js/matrix.tables.js"></script> 
    
    

<?php


    
//include 'adminfooter.php';

?>
    
    
    
    
    
<script type="text/javascript">
 
    
    $("#StudentType").change(function(){
    
      
      var StudentType = $(this).val();
      var StudentTypeIndex = $("#StudentType").prop('selectedIndex');
            
            
            if(StudentTypeIndex != 0){
                $("#StudentID").removeAttr("disabled"); 
            }
            else{
                  $("#StudentID").attr("disabled", "disabled"); 
            }
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
    
    $("#SubmitButton").click(function(){
        if (confirm('Save changes to this student data?')) {
            
            var FormValidator = true;
            
                 //Reference Num validation
              var ReferenceNum = $("#ReferenceNum").val();
              var ReferenceNumCheck = { ReferenceNum: ReferenceNum};
              var ReferenceNumValidator;
            
             
              //AJAX to check if student ID entered already exists!	
              $.ajax({	
                   type:'POST',	
                   url:'CheckIfReferenceNumExistsEdit.php',	
                   async: false,	
                   data:{"RetrieveTransaction" : JSON.stringify(ReferenceNumCheck)},	
                   success:function(data){	
                          ReferenceNumValidator = data;	
                       	
                   },	
                     	
               error: function(request, error) {	
                           	
                           alert("Error in AJAX checking of reference num");	
               }	
              });	
           	
            
           if(ReferenceNumValidator == 'meron'){	
        	
               FormValidator = false;
               $("#ReferenceNumControlGroup").addClass("error");	
               $("#ReferenceNumError").show();	
               	
           }	
           	
            else{
	
              $("#ReferenceNumControlGroup").removeClass("error");	
              $("#ReferenceNumError").hide();	
           }
            
            
          
               //Student ID Validation
              var StudentIDDisplay = $("#StudentIDMainField").val();
              var StudentIDCheck = { StudentIDDisplay: StudentIDDisplay};	
              var StudentIDValidator;
	
             //AJAX to check if student ID entered already exists!	
              $.ajax({	
                   type:'POST',	
                   url:'CheckIfStudentIDExistsEdit.php',	
                   async: false,	
                   data:{"RetrieveTransaction" : JSON.stringify(StudentIDCheck)},	
                   success:function(data){	
                          StudentIDValidator = data;	
                       	
                   },	
                     	
               error: function(request, error) {	
                           	
                           alert("Error in AJAX checking of student id");	
               }	
              });	
           	
            
           if(StudentIDValidator == 'meron'){	
               //alert("Student ID already exists!");	
               FormValidator = false;
	
               $("#StudentIDControlGroup").addClass("error");	
               $("#StudentIDError").show();	
               	
           }	
           	
            else{
	
              $("#StudentIDControlGroup").removeClass("error");	
              $("#StudentIDError").hide();	
           }	
             
            
            
            var EditProfileStudentID = $("#EditProfileStudentID").val();
            var EditProfileAdmissionID = $("#EditProfileAdmissionID").val();
            
            
            //LRN Num Validation
            var LRNNumber = $("#LRNNum").val();
            if(isNaN(LRNNumber) || LRNNumber.length > 12 || LRNNumber == null || LRNNumber == ""){
                FormValidator = false;
                $("#LRNNumControlGroup").addClass("error");
                $("#LRNNumError").show();
            }
            else{
               $("#LRNNumControlGroup").removeClass("error");
               $("#LRNNumError").hide();
            }
            
            //Student Last Name Validation
            var StudentLastName = $("#LastName").val();
            if(StudentLastName.length > 40 || StudentLastName == null || StudentLastName == ""){
                FormValidator = false;
                $("#LastNameControlGroup").addClass("error");
                $("#LastNameError").show();
            }
            else{
               $("#LastNameControlGroup").removeClass("error");
               $("#LastNameError").hide();
            }
            
            
            //Student First Name Validation
            var StudentFirstName = $("#FirstName").val();
            if(StudentFirstName.length > 40 || StudentFirstName == null || StudentFirstName == ""){
                FormValidator = false;
                $("#FirstNameControlGroup").addClass("error");
                $("#FirstNameError").show();
            }
            else{
               $("#FirstNameControlGroup").removeClass("error");
               $("#FirstNameError").hide();
            }
            
            
            //Student Middle Name Validation
            var StudentMiddleName = $("#MiddleName").val();
            if(StudentMiddleName.length > 40 ){
                FormValidator = false;
                $("#MiddleNameControlGroup").addClass("error");
                $("#MiddleNameError").show();
            }
            else{
               $("#MiddleNameControlGroup").removeClass("error");
               $("#MiddleNameError").hide();
            }
            
            //Gender
            var StudentGender = $("#Gender").val();
            var StudentNationality = $("#Nationality").val();
            var StudentReligion = $("#Religion").val();
            var FatherFullName = $("#FatherFullName").val();
         
            var FatherOccupation = $("#FatherOccupation").val();
            var MotherFullName = $("#MotherFullName").val();
  
            var MotherOccupation = $("#MotherOccupation").val();

            
            var Municipality = $("#Municipality").val();
            var Province = $("#Province").val();
            var HomeNum = $("#HomeNum").val();
            var MobileNum = $("#MobileNum").val();
            var EmailAddress = $("#EmailAddress").val();
            var GradeLevel = $("#GradeLevel").val();
            var Section = $("#Section").val();
            
            //Student Birthday Validation
            var StudentBirthday = $("#Birthday").val();
            if (Date.parse(StudentBirthday) ) {
                
               if(StudentBirthday != null || StudentBirthday != ""){
                   $("#BirthdayControlGroup").removeClass("error");
                   $("#BirthdayError").hide();
               }
               else{
                   FormValidator = false;
                   $("#BirthdayControlGroup").addClass("error");
                   $("#BirthdayError").show();
               }
            } 
            else
            {
                FormValidator = false;
                $("#BirthdayControlGroup").addClass("error");
                $("#BirthdayError").show();
            }
            
            
            //Age Validation
            var StudentAge = $("#Age").val();
            if(isNaN(StudentAge)){
                   FormValidator = false;
                   $("#AgeControlGroup").addClass("error");
                   $("#AgeError").show();
            }
            else{
                   FormValidator = true;
                   $("#AgeControlGroup").removeClass("error");
                   $("#AgeError").hide();
            }
            
            
            
            //Place Of Birth Validation
            var PlaceOfBirth = $("#PlaceOfBirth").val();
            if(PlaceOfBirth.length > 150 ){
                FormValidator = false;
                $("#PlaceOfBirthControlGroup").addClass("error");
                $("#PlaceOfBirthError").show();
            }
            else{
                $("#PlaceOfBirthControlGroup").removeClass("error");
                $("#PlaceOfBirthError").hide();
            }
            
            //Barangay validation
            var Barangay = $("#Barangay").val();
            
            if(Barangay == null || Barangay == ""){
                FormValidator = false;
                $("#BarangayControlGroup").addClass("error");
                $('#BarangayControlGroup').css('color', "#b94a48");
                $("#Barangay").css("border-color","#b94a48");
                $("#Barangay").css("color","#b94a48");
                $("#BarangayError").show();
            }
            else{
                $("#BarangayControlGroup").removeClass("error");
                $('#BarangayControlGroup').css('color', "#333");
                $("#Barangay").css("border-color","#ccc");
                $("#Barangay").css("color","#333");
                $("#BarangayError").hide();
            }
            
            
            //Address Prefix Validation
            var AddressPrefix = $("#AddressPrefix").val();
            
            if(AddressPrefix == null || AddressPrefix == ""){
                FormValidator = false;
                $("#AddressPrefixControlGroup").addClass("error");
                $('#AddressPrefixControlGroup').css('color', "#b94a48");
                $("#AddressPrefix").css("border-color","#b94a48");
                $("#AddressPrefix").css("color","#b94a48");
                $("#AddressPrefixError").show();
            }
            else{
                $("#AddressPrefixControlGroup").removeClass("error");
                $('#AddressPrefixControlGroup').css('color', "#333");
                $("#AddressPrefix").css("border-color","#ccc");
                $("#AddressPrefix").css("color","#333");
                $("#AddressPrefixError").hide();
            }
            
        
            
            //Contact Person Validation
            var ContactPerson = $("#ContactPerson").val();
            
            if(ContactPerson == null || ContactPerson == ""){
                FormValidator = false;
                $("#ContactPersonControlGroup").addClass("error");
                $('#ContactPersonControlGroup').css('color', "#b94a48");
                $("#ContactPerson").css("border-color","#b94a48");
                $("#ContactPerson").css("color","#b94a48");
                $("#ContactPersonError").show();
            }
            else{
            
                $("#ContactPersonControlGroup").removeClass("error");
                $('#ContactPersonControlGroup').css('color', "#333");
                $("#ContactPerson").css("border-color","#ccc");
                $("#ContactPerson").css("color","#333");
                $("#ContactPersonError").hide();
                
            }
            
            
            
            //Relationship
            var Relationship = $("#Relationship").val();
            
            if(Relationship == null || Relationship == ""){
                FormValidator = false;
                $("#RelationshipControlGroup").addClass("error");
                $('#RelationshipControlGroup').css('color', "#b94a48");
                $("#Relationship").css("border-color","#b94a48");
                $("#Relationship").css("color","#b94a48");
                $("#RelationshipError").show();
            }
            else{
            
                $("#RelationshipControlGroup").removeClass("error");
                $('#RelationshipControlGroup').css('color', "#333");
                $("#Relationship").css("border-color","#ccc");
                $("#Relationship").css("color","#333");
                $("#RelationshipError").hide();
                
            }
            
            //Contact Person Contact Number Validation
            var ContactPersonContactNumber = $("#ContactPersonContactNumber").val();
            if(ContactPersonContactNumber == null || ContactPersonContactNumber == ""){
                FormValidator = false;
                $("#ContactPersonContactNumberControlGroup").addClass("error");
                $('#ContactPersonContactNumberControlGroup').css('color', "#b94a48");
                $("#ContactPersonContactNumber").css("border-color","#b94a48");
                $("#ContactPersonContactNumber").css("color","#b94a48");
                $("#ContactPersonContactNumberError").show();
            }
            else{
            
                $("#ContactPersonContactNumberControlGroup").removeClass("error");
                $('#ContactPersonContactNumberControlGroup').css('color', "#333");
                $("#ContactPersonContactNumber").css("border-color","#ccc");
                $("#ContactPersonContactNumber").css("color","#333");
                $("#ContactPersonContactNumberError").hide();
                
            }
            
            //Section Validation
            /*
            var Section = $("#Section").val();
            var SectionIndex = $("#DiscountCategory").prop('selectedIndex');
            if(SectionIndex == 0){
                 FormValidator = false;
                $("#SectionControlGroup").addClass("error");
                $('#SectionControlGroup').css('color', "#b94a48");
                $("#Section").css("border-color","#b94a48");
                $("#Section").css("color","#b94a48");
                $("#SectionError").show();
            }
            else{
                $("#SectionControlGroup").removeClass("error");
                $('#SectionControlGroup').css('color', "#333");
                $("#Section").css("border-color","#ccc");
                $("#Section").css("color","#333");
                $("#SectionError").hide();
            }
            */
            
            //Strand Validation
            
            var Strand = $("#SHSStrand").val();
            var GradeLevelIndex = $("#GradeLevel").prop('selectedIndex');
            var StrandIndex = $("#SHSStrand").prop('selectedIndex');
            if(GradeLevelIndex > 13){
                
				/*
                if(StrandIndex == 0){
                FormValidator = false;
                $("#StrandControlGroup").addClass("error");
                $('#StrandControlGroup').css('color', "#b94a48");
                $("#SHSStrand").css("border-color","#b94a48");
                $("#SHSStrand").css("color","#b94a48");
                $("#StrandError").show();
                }
                else{ */
				
                $("#StrandControlGroup").removeClass("error");
                $('#StrandControlGroup').css('color', "#333");
                $("#SHSStrand").css("border-color","#ccc");
                $("#SHSStrand").css("color","#333");
                $("#StrandError").hide();
                //}
                
                
            }
            else{
                $("#StrandControlGroup").removeClass("error");
                $('#StrandControlGroup').css('color', "#333");
                $("#SHSStrand").css("border-color","#ccc");
                $("#SHSStrand").css("color","#333");
                $("#StrandError").hide();
            }
            
            
            
            
            
            
            //ESC Number Validation
            var ESCGrantee = false;
            var ESCNumber = $("#ESCNumber").val();
            
            if ($('#ESCCheckbox').is(":checked"))
            {
                ESCGrantee = true;
                
            }
            else{
                ESCGrantee = false;
            }
            
            
            
            
            
            if(ESCGrantee){
                if(ESCNumber == null || ESCNumber == ""){
                     FormValidator = false;
                    
                     $("#ESCNumberControlGroup").addClass("error");
                     $('#ESCNumberControlGroup').css('color', "#b94a48");
                     $("#ESCNumber").css("border-color","#b94a48");
                     $("#ESCNumber").css("color","#b94a48");
                     $("#ESCNumberError").show();
                      
                    
                    
                }
                
                else{
                    
                $("#ESCNumberControlGroup").removeClass("error");
                $('#ESCNumberControlGroup').css('color', "#333");
                $("#ESCNumber").css("border-color","#ccc");
                $("#ESCNumber").css("color","#333");
                $("#ESCNumberError").hide();
                    
                    
                }
                
            }
            else{
                
                
                $("#ESCNumberControlGroup").removeClass("error");
                $('#ESCNumberControlGroup').css('color', "#333");
                $("#ESCNumber").css("border-color","#ccc");
                $("#ESCNumber").css("color","#333");
                $("#ESCNumberError").hide();
            }
            
            
            var ModeOfPayment = $("#ModeOfPayment").val();
            var AdmissionSiblingDiscountID = $("#SiblingDiscount").val();
            var AdmissionAcademicScholarshipDiscountID = $("#AcademicScholarshipDiscount").val();
            var AdmissionPromotionalDiscountID = $("#PromotionalDiscount").val();
            var AdmissionEntranceScholarshipDiscountID = $("#EntranceScholarshipDiscount").val();
            var AdmissionVarsityDiscountID = $("#VarsityDiscount").val();
			var AdmissionSTSDiscountID = $("#STSDiscount").val();
            var AdmissionSchoolOfOrigin = $("#SchoolOfOrigin").val();
            var AdmissionTypeOfInstitution = $("#TypeOfInstitution").val();
            var AdmissionStatus = $("#EnrollmentStatus").val();
            var AdmissionUpdate = $("#EnrollmentUpdate").val();
            
            
            var EditStudentID = $("#EditProfileStudentID").val();
            var Siblings = $("#Siblings").val();
            
           
            var StudentBirthdayInsert = formatDate(StudentBirthday);
            
            var StudentSiblings = { StudentSiblingsID: ""};
           // var StudentIDDisplay = $("#StudentIDMainField").val();
            
            
            
            var StudentDetails = { EditStudentID: EditStudentID, EditProfileAdmissionID : EditProfileAdmissionID,StudentIDDisplay : StudentIDDisplay, LRNNumber: LRNNumber, LastName: StudentLastName, FirstName: StudentFirstName, MiddleName: StudentMiddleName, Gender: StudentGender, StudentNationalityID: StudentNationality, StudentBirthday: StudentBirthdayInsert, PlaceOfBirth: PlaceOfBirth, StudentReligionID: StudentReligion, FatherFullName: FatherFullName, FatherOccupation: FatherOccupation, MotherFullName: MotherFullName, MotherOccupation: MotherOccupation, AddressPrefix: AddressPrefix, StudentBarangay: Barangay, StudentMunicipalityID: Municipality, StudentProvinceID : Province, HomeNumber: HomeNum, MobileNumber: MobileNum, ContactPerson: ContactPerson, EmailAddress: EmailAddress, RelationshipToContactPerson: Relationship, ContactPersonContactNumber: ContactPersonContactNumber, AdmissionGradeLevelID: GradeLevel , AdmissionReferenceNum: ReferenceNum, AdmissionSectionID: Section, StudentStrand: Strand, ESCNumber: ESCNumber, AdmissionModeOfPaymentID: ModeOfPayment, StudentSiblings: [], AdmissionSiblingDiscountID: AdmissionSiblingDiscountID, AdmissionAcademicScholarshipDiscountID: AdmissionAcademicScholarshipDiscountID, AdmissionPromotionalDiscountID: AdmissionPromotionalDiscountID, AdmissionEntranceScholarshipDiscountID: AdmissionEntranceScholarshipDiscountID, AdmissionVarsityDiscountID: AdmissionVarsityDiscountID, AdmissionSTSDiscountID: AdmissionSTSDiscountID, AdmissionStatus: AdmissionStatus, AdmissionUpdate: AdmissionUpdate, StudentAge: StudentAge, AdmissionSchoolOfOrigin: AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution: AdmissionTypeOfInstitution };

            
            
            if(Siblings != null){
            
            for(var x = 0; x<Siblings.length; x++){

                StudentDetails.StudentSiblings.push(Siblings[x]);
        
            }
        
                
                
            }
            if(FormValidator){
                   $.ajax({
                            type:'POST',
                            url:'EditStudentProfileSubmit.php',
                            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                            success:function(html){
                                 
                                   alert("Succcess");
                                   window.location.href="/iucsenrollmentsystem/webpages/StudentRecordsList.php";
                            },
                       
                       error: function(request, error) {
                            
                              alert("Error");
                        }
                }); 
            }
            else{
                 document.documentElement.scrollTop = 0;
                 
            }
            
            
        }
      
               
    });
    
    
    
$('#EnrollmentStatus').change(function() {
    
    
        var EnrollmentStatus = $(this).val();
        var EnrollmentStatusIndex = $(this).prop('selectedIndex');
    
         
        
         if(EnrollmentStatusIndex != 0){
                
               $("_divDatePullOut").css("visibility", "visible");
               $("#DateOfPullOut").val("");
             
             
                $('#EnrollmentUpdate').empty();
                $('#s2id_EnrollmentUpdate span').text('');
                $('#EnrollmentUpdate').append('<option value="0" selected="selected">Enrollment update not available</option>');
                $("select#EnrollmentUpdate")[0].selectedIndex = 0;
                var NewSelected = $("#EnrollmentUpdate option:selected").text();
                $('#s2id_EnrollmentUpdate span').text(NewSelected);
            
        }
        
        else if(EnrollmentStatusIndex == 0){
           
            
            $("_divDatePullOut").css("visibility", "hidden");
            $("#DateOfPullOut").val("");
            
            $.ajax({
                type:'POST',
                url:'GetEnrollmentUpdate.php',
                //data:'country_id='+EnrollmentStatus,
                success:function(html){
                     
                    $('#EnrollmentUpdate').empty();
                    $('#s2id_EnrollmentUpdate span').text('');
                    $('#EnrollmentUpdate').html(html);
                   
                    //$("select#EnrollmentUpdate")[0].selectedIndex = 0;
                    var NewSelected = $("#EnrollmentUpdate option:selected").text();
                    $('#s2id_EnrollmentUpdate span').text(NewSelected);
                    
                }
            }); 
            
        }
        
    
});
    
   
$('#Province').change(function() {
    
    
        var ProvinceID = $(this).val();
        var ProvinceIndex = $(this).prop('selectedIndex');
        var MunicipalityID = "<?php echo $RetrieveMunicipality; ?>";
    
        var ProvinceXMunicipality= { ProvinceID: ProvinceID, MunicipalityID: MunicipalityID };
        
        
         if(ProvinceIndex == 0){
                
                $('#Municipality').empty();
                $('#s2id_Municipality span').text('');
                $('#Municipality').append('<option value="0" selected="selected">Municipality not available</option>');
                $("select#Municipality")[0].selectedIndex = 0;
                var NewSelected = $("#Municipality option:selected").text();
                $('#s2id_Municipality span').text(NewSelected);
            
        }
        
        else{
            $.ajax({
                type:'POST',
                url:'GetMunicipalityEdit.php',
                data: {"ProvinceXMunicipality" : JSON.stringify(ProvinceXMunicipality)},	
                success:function(html){
                    $('#Municipality').empty();
                    $('#s2id_Municipality span').text('');
                    $('#Municipality').html(html);
                    //$("select#EnrollmentUpdate")[0].selectedIndex = 0;
                    var NewSelected = $("#Municipality option:selected").text();
                    $('#s2id_Municipality span').text(NewSelected);
                    
                }
            }); 
        }
        
    
});
    
    $('#SiblingDiscountCategory').change(function() {
        
        var DiscountCategoryID = $(this).val();
        var DiscountCategoryIndex = $("#SiblingDiscountCategory").prop('selectedIndex');
        
        
         if(DiscountCategoryID == 0 ){
          
             
             
                $('#SiblingDiscountType').empty();
                $('#s2id_SiblingDiscountType span').text('');
                $('#SiblingDiscountType').append('<option value="0" selected="selected">Discounts not available</option>');
                $("select#SiblingDiscountType")[0].selectedIndex = 0;
                var NewSelected = $("#SiblingDiscountType option:selected").text();
                $('#s2id_SiblingDiscountType span').text(NewSelected);
            
        }
        
        
        
        
        else{
            $.ajax({
                type:'POST',
                url:'GetDiscountTypeList.php',
                data:'country_id='+DiscountCategoryID,
                success:function(html){
                    $('#SiblingDiscountType').empty();
                    $('#s2id_SiblingDiscountType span').text('');
                    $('#SiblingDiscountType').html(html);
                    $("select#SiblingDiscountType")[0].selectedIndex = 0;
                     var NewSelected = $("#SiblingDiscountType option:selected").text();
                    $('#s2id_SiblingDiscountType span').text(NewSelected);
                    
                }
            }); 
        }
        
       
    
    
    });
    
    
    
    
     $('#ESCCheckbox').change(function() {
        if(this.checked) {
            //var returnVal = confirm("Are you sure?");
            //$(this).prop("checked", returnVal);
             $("#ESCNumber").removeAttr("disabled"); 
        }
        
        else{
            $("#ESCNumber").val('');
            $("#ESCNumber").attr("disabled", "disabled");
        }
        //$('#textbox1').val(this.checked);        
    });
    
    
    $("#GradeLevel").change(function(){ 
   
  
        
        //s2id_SHSStrand
      var GradeLevelID = $(this).val();
      var GradeLevelIndex = $("#GradeLevel").prop('selectedIndex');
            
            
            if(GradeLevelIndex != 0){
             
                
            }
    
            else{
                
                
             
            }
        
        
            if(GradeLevelIndex == 14 || GradeLevelIndex == 15){
               
                
                  $.ajax({
                    type:'GET',
                    url:'GetStrandList.php',
                    //data:'country_id='+GradeLevelID,
                    success:function(html){
                        $('#SHSStrand').empty();
                        $('#s2id_SHSStrand span').text('');
                        //$('#SHSStrand').append('<option value="0" selected="selected">No strand selected</option>');
                        $('#SHSStrand').html(html);
                        $("select#SHSStrand")[0].selectedIndex = 0;
                        var NewSelected = $("#SHSStrand option:selected").text();
                        $('#s2id_SHSStrand span').text(NewSelected);
                    
                }
            }); 
                
                
                
                
            }
            else{
                
                $('#SHSStrand').empty();
                $('#s2id_SHSStrand span').text('');
                $('#SHSStrand').append('<option value="0" selected="selected">Strands Not available</option>');
                $("select#SHSStrand")[0].selectedIndex = 0;
                var NewSelected = $("#SHSStrand option:selected").text();
                $('#s2id_SHSStrand span').text(NewSelected);
                
                
                /*
                 $("#s2id_SHSStrand").removeClass("select2-container select2-container-active select2-dropdown-open");
                 $("#s2id_SHSStrand").addClass("select2-container select2-container-disabled");
                $("#SHSStrand").prop('disabled', true);
                */
                /*
                 $("select#SHSStrand")[0].selectedIndex = 0;
                  $('#s2id_SHSStrand span').text('');
                var NewSelected = $("#SHSStrand option:selected").text();
                    $('#s2id_SHSStrand span').text(NewSelected);
                    */
                
            }
        
        
        if(GradeLevelID){
            $.ajax({
                type:'POST',
                url:'GetSectionList.php',
                data:'country_id='+GradeLevelID,
                success:function(html){
                    $('#Section').empty();
                    $('#s2id_Section span').text('');
                    $('#Section').html(html);
                    $("select#Section")[0].selectedIndex = 0;
                     var NewSelected = $("#Section option:selected").text();
                    $('#s2id_Section span').text(NewSelected);
                    
                }
            }); 
        }else{
            $('#Section').html('<option value="">--Select Grade Level first--</option>');
            
        } 

});
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</script>
    
    
    
    
    </body>
</html>
    
    
    
    
    
    
    
    
    