<?php 

include 'DataBaseConnectionFileNoLogInRequired.php';
//session_start();

if(!isset($_SESSION['SessionUserID'])){
    
    include 'phase1header.php';
}
else{
    include 'adminheader.php';
}



$OldStudentIDDisplay = $_SESSION['SessionEnrollOldStudentIDDisplay'];
$OldStudentIDPK = $_SESSION['SessionEnrollOldStudentIDPK'];


$_SESSION['SessionEnrollOldStudentIDPK'] = $OldStudentIDPK;


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
    $statement->execute(array(':StudentID' => $OldStudentIDPK));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
              $RetrieveStudentIDDisplay = $row['StudentIDDisplay'];
              $_SESSION['SessionEnrollOldStudentIDDisplay'] = $RetrieveStudentIDDisplay;
              $RetrieveESCNumber = $row['ESCNumber'];
              $RetrieveLRNNumber = $row['LRNNumber'];
              $RetrieveFirstName = $row['FirstName'];
              $RetrieveMiddleName = $row['MiddleName'];
              $RetrieveLastName = $row['LastName'];
              $RetrieveGender = $row['StudentGender'];
              $RetrieveNationality = $row['StudentNationalityID'];
              $RetrieveBirthday = $row['StudentBirthday'];
              $RetrieveAge = $row['StudentAge'];
              $RetrievePlaceOfBirth = $row['PlaceOfBirth'];
              $RetrieveReligion = $row['StudentReligionID'];
              $RetrieveFatherFullName = $row['FatherFullName'];
              $RetrieveFatherOccupation = $row['FatherOccupation'];
              $RetrieveMotherFullName = $row['MotherFullName'];
              $RetrieveMotherOccupation = $row['MotherOccupation'];
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
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID ORDER BY AdmissionID DESC LIMIT 1 ");
    $statement->execute(array(':AdmissionStudentID' => $OldStudentIDPK));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              $RetrieveAdmissionID = $data['AdmissionID'];
              $RetrieveGradeLevelID = $data['AdmissionGradeLevelID'];
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


if($RetrieveGradeLevelID != 15){
    
    $RetrieveGradeLevelIDNew = (int)$RetrieveGradeLevelID + 1;
    //$RetrieveGradeLevelIDNew = 14;
   
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





$InternalSiblingList = [];

//Get the internal siblings
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblsibling WHERE SiblingMainStudentID = :SiblingMainStudentID AND SiblingTableAdmissionID = :SiblingTableAdmissionID ");
    $statement->execute(array(':SiblingMainStudentID' => $OldStudentIDPK, ':SiblingTableAdmissionID' => $RetrieveAdmissionID ));
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
 <center><h1>Enrollment - Phase 1 (For Re-enrollees/Old Student) </h1></center>
      <br>
      <br>
      <center><h3>Note: You may update the information from your previous admission</h3></center>
     
    <div class="row-fluid">
        <div class="span6">
            <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Student Personal Information</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
              
        <div class="row-fluid">
		
	
     </div>
              
                
            <div class="control-group" id="LRNNumControlGroup">
              <label class="control-label">*Learner Reference Number:</label>
              <div class="controls">
                <input type="text" class="span11" name="LRNNum" id="LRNNum" placeholder="457848457744" value = "<?php echo $RetrieveLRNNumber; ?> "/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="LRNNumError"  name="LRNNumError" >Invalid LRN </span> 
              </div>
            </div>
            <div class="control-group" id="LastNameControlGroup">
              <label class="control-label">*Last Name :</label>
              <div class="controls">
                <input type="text" name="LastName" id="LastName" class="span11" placeholder="Last name" value = "<?php echo $RetrieveLastName; ?>" />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="LastNameError"  name="LastNameError">Invalid Last Name</span>
              </div>
            </div>
              
              <div class="control-group" id="FirstNameControlGroup">
              <label class="control-label">*First Name :</label>
              <div class="controls">
                <input type="text" name="FirstName" id="FirstName" class="span11" placeholder="First name" value = "<?php echo $RetrieveFirstName; ?>"/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="FirstNameError"  name="FirstNameError">Invalid First Name</span>
              </div>
            </div>
              
              
              <div class="control-group" id="MiddleNameControlGroup">
              <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="MiddleName" id="MiddleName" class="span11" placeholder="Middle name" value = "<?php echo $RetrieveMiddleName; ?>" />
                    <span class="help-inline" style="color: #b94a48; display: none;" id="MiddleNameError"  name="MiddleNameError">Invalid Middle Name</span>
              </div>
            </div>
              
                 <div class="control-group">
              <label class="control-label">*Gender</label>
              <div class="controls">
                <select name="Gender" id="Gender" >
                  <option value="0" <?php if($RetrieveGender == 0){ echo ' selected '; } ?>>Male</option>
                  <option value="1" <?php if($RetrieveGender == 1){ echo ' selected '; } ?>>Female</option>
                
                </select>
              </div>
            </div>
              
              
                 <div class="control-group">
              <label class="control-label">*Nationality</label>
              <div class="controls">
                <select name="Nationality" id="Nationality">
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
                  <input type="text" name="Birthday" id="Birthday"  data-date-format="mm-dd-yyyy" class="span11" value = "<?php echo $RetrieveBirthday; ?>">
                  <span class="add-on"><i class="icon-th"></i></span> </div>
                    <span class="help-inline" style="color: #b94a48; display: none;" id="BirthdayError"  name="BirthdayError">Please enter a valid date</span>
                    &nbsp;
                  <button id="ComputeAge" class="btn btn-warning" type="button">Compute Age</button>
              </div>
            </div>
              
              
            <div class="control-group" id="AgeControlGroup">
              <label class="control-label">Age :</label>
              <div class="controls">
                <input type="text" name="Age" id="Age" class="span11" placeholder="Input student's birthday" disabled />
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
              
              <br>
              <br>
              <br>
              <br>
              <br>
              <br>
    
          
            
          </form>
        </div>
      </div>
            
            
            
            
        </div>
        
        <!-- span 6 -->
        
        
        <!-- second span 6 -->
        
        
    <div class="span6">
        
        <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Family Information</h5>
        </div>
        <div class="widget-content nopadding">
          <form action="#" method="get" class="form-horizontal">
          <h3><center>Father</center></h3>
              
                <div class="control-group">
              <label class="control-label">Father's Name :</label>
              <div class="controls">
                <input type="text" name="FatherFullName" id="FatherFullName" class="span11" placeholder="Father's Full Name" value = "<?php echo $RetrieveFatherFullName; ?>"   />
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
                <input type="text"  name="FatherOccupation" id="FatherOccupation" class="span11" placeholder="e.g. Doctor" value = "<?php echo $RetrieveFatherOccupation; ?>"  />
              </div>
            </div>
              
               <h3><center>Mother</center></h3>
              
              
               <div class="control-group">
              <label class="control-label">Mother's Maiden Name :</label>
              <div class="controls">
                <input type="text" name="MotherFullName" id="MotherFullName" class="span11" placeholder="Mother's Full Name" value = "<?php echo $RetrieveMotherFullName; ?>"  />
              </div>
            </div>
              
              
        
              
                  <div class="control-group">
              <label class="control-label">Occupation :</label>
              <div class="controls">
                <input type="text"  name="MotherOccupation" id="MotherOccupation" class="span11" placeholder="e.g. Doctor"  value = "<?php echo $RetrieveMotherOccupation; ?>" />
              </div>
            </div>
              
              
              
                                          <div class="control-group">
            
               
              <!--
                    <button style="margin-top: 25px; margin-left: -55px; margin-bottom: 100px;" type="button" id="AddInternalSibling" class="btn btn-success">Click to Add Sibling Enrolled in IUCS</button>
              
                     <button style="margin-top: -152px; margin-left: 220px; margin-bottom: 100px;" type="button" id="AddExternalSibling" class="btn btn-info">Click to Add Sibling Outside IUCS</button>
                  -->
                
                   <label class="control-label">Siblings Enrolled in IUCS</label>
              <div class="controls">
                <select multiple="multiple" name="Siblings[]" id="Siblings" class="span10" >
                  
                    
<?php 
                                                        
                                                        
try
{
 
    $LatestSchoolYearMinus15 = $LatestSchoolYear - 15;
   
    $statement = $dbh->prepare("SELECT DISTINCT tblstudent.* FROM tblstudent,tblstudentadmission  WHERE StudentID = AdmissionStudentID  AND LEFT(StudentIDDisplay,4) >= $LatestSchoolYearMinus15 AND AdmissionStatus = 2");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    $selected2 = "";
    
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
                <input disabled type="text" name="SchoolOfOrigin" id="SchoolOfOrigin" class="span11" placeholder="e.g. Imus Unida Christian School" value="Imus Unida Christian School"/>
              </div>
            </div>
              
              <div class="control-group">
              <label class="control-label">*Type of Institution</label>
              <div class="controls">
                <select name="TypeOfInstitution" id="TypeOfInstitution" disabled>
                    <option value="0">Private</option>
                    <option value="1">Public</option>
                    <option value="2">IS</option>
                
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
                <input type="text" name="Barangay" id="Barangay" class="span10 m-wrap" placeholder="e.g. Poblacion I-C"  value = "<?php echo $RetrieveBarangay; ?>"/>
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
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblmunicipality WHERE MunicipalityProvinceID = 1");
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
                <input type="text" name="HomeNum" id="HomeNum" class="span10 m-wrap" placeholder="e.g. 434-0505" value = "<?php echo $RetrieveHomeNumber; ?>"/>
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5">
              
                   <label class="control-label">Mobile Number</label>
              <div class="controls">
                <input type="text" name="MobileNum" id="MobileNum" class="span10 m-wrap" placeholder="e.g. 09051234567" value = "<?php echo $RetrieveMobileNumber; ?>"/>
              </div>
                      
           
                
                 </div>
  
            
           
                
                
            
            </div>
              
            
                 <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5" id="ContactPersonControlGroup">
              
                   <label class="control-label">*Contact Person</label>
              <div class="controls">
                <input type="text" name="ContactPerson" id="ContactPerson" class="span10 m-wrap"  value = "<?php echo $RetrieveContactPerson; ?>" placeholder="e.g. Juan dela Cruz"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="ContactPersonError"  name="ContactPersonError">Contact Person is required </span>
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5">
              
                   <label class="control-label">E-mail address(Parent)</label>
              <div class="controls">
                <input type="text" name="EmailAddress" id="EmailAddress" class="span10 m-wrap" placeholder="e.g. juandelacruz@gmail.com" value = "<?php echo $RetrieveEmailAddress; ?>"/>
              </div>
                      
           
                
                 </div>
  
            
           
                
                
            
            </div>
              
              
            
                 <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5" id="RelationshipControlGroup">
              
                   <label class="control-label">*Relationship to Contact Person</label>
              <div class="controls">
                <input type="text" name="Relationship" id="Relationship" class="span10 m-wrap" placeholder="e.g. Mother" value = "<?php echo $RetrieveRelationshipToContactPerson ; ?>"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="RelationshipError"  name="RelationshipError">This field is required </span>
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5" id="ContactPersonContactNumberControlGroup">
              
                   <label class="control-label">*Contact Person Contact Number</label>
              <div class="controls">
                <input type="text" name="ContactPersonContactNumber" id="ContactPersonContactNumber" class="span10 m-wrap" placeholder="e.g. 09051234567" value = "<?php echo $RetrieveContactPersonContactNumber ; ?>"/>
                  <span class="help-inline" style="color: #b94a48; display: none; margin-top: -20px;" id="ContactPersonContactNumberError"  name="ContactPersonContactNumberError">Contact # of Contact Person is required </span>
              </div>
                      
           
                <br>
                       <br>
                       
                       
                 
                 </div>
                     
                     
            <div class="row-fluid">
                     
             <h3><center>Admission Information</center></h3>
            
            <div class="span1"></div>
            <div class="span4">
                
                <div class="control-group">
              <label class="control-label">*Incoming Grade Level:</label>
              <div class="controls">
                <select name="IncomingGradeLevel" id="IncomingGradeLevel">
                    <?php 
                                                        
                                                          
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            if($RetrieveGradeLevelIDNew == $data['GradeLevelID']){
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
            </div>
                
                <div class="span1"></div>
                   <div class="span4" name="DivStrand" id="StrandControlGroup">
                   <label class="control-label">Desired Strand for Incoming Senior High School </label>
              
                
                 <div class="controls">
                <select name="SHSStrand" id="SHSStrand"  <?php if($RetrieveGradeLevelIDNew == 15) { echo ' disabled '; } ?> >
                    
                    <?php 
                    
                    
                    if ($RetrieveGradeLevelIDNew == 14 || $RetrieveGradeLevelIDNew == 15){
                        
                        
                        echo '<option value="0"> No strand selected </option>';
                    
                                                        
                                                          
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblstrand");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            if($RetrieveStrand == $data['StrandID']){
                $selected = "selected";
                
            }else{
                $selected = "";
            }
           echo '<option value ="' . $data['StrandID'] . '" '. $selected .'>' . $data['StrandName'] . '</option>';
        
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
                        
                        
                        
                        
                        
                        
                        
                        
                    }
                    else {
                        echo '<option value="0">Strands not available</option>';
                    }
                    
                    ?>
                   
                 
                
                </select>
                     
                     <span class="help-inline" style="color: #b94a48; display: none; " id="StrandError"  name="StrandError">Strand is required for SHS Students </span>
              </div>
                  
                  
            
                      
            </div>
                
                
                
                
            </div>
  
            <div class="row-fluid">
                     <div class="span5"></div>
             
				     <div class="span5" style="margin-top: 25px; margin-left: 150px; margin-bottom: 100px;">
       <button type="button" id="SubmitButton" class="btn btn-large btn-success">Enroll Student</button>
              
             <a href="DestroySession.php"><button type="button"  id="CancelButton" class="btn btn-large btn-danger">Cancel</button></a>
    
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
        
<!-- widget content padding -->
        
        
        
        
    </div>
<!-- widget box -->
        
        
     

    
  
  </div>
      
      <!-- end 2nd row fluid -->


    
    <!-- end-container -->
    
</div>

<!--end-main-container-part-->
    
    
    

    
    
    

<?php

include 'adminfooter.php';

?>
    
    
    
    
    
<script type="text/javascript">
    
    
    $("#ComputeAge").click(function(e){
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
 });
    
    
    
    $("#StudentType").change(function(){
    
      
      var StudentType = $(this).val();
      var StudentTypeIndex = $("#StudentType").prop('selectedIndex');
            
            
            if(StudentTypeIndex != 0){
                $("#StudentID").removeAttr("disabled"); 
                $("#SchoolOfOrigin").val("Imus Unida Christian School");
                $("select#TypeOfInstitution")[0].selectedIndex = 0;
            }
            else{
                  $("#StudentID").attr("disabled", "disabled"); 
                  $("#SchoolOfOrigin").val("");
                  $("select#TypeOfInstitution")[0].selectedIndex = 1;
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
    
    $("#SubmitButton").click(function(e){
        if (confirm('Enroll this student data?')) {
            
              var FormValidator = true;
            
        	
            
           
            
            
           // e.preventDefault();
            //LRN Num Validation
            var LRNNumber = $("#LRNNum").val().trim();
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
           // var FatherLastName = $("#FatherLastName").val();
            //var FatherFirstName = $("#FatherFirstName").val();
            //var FatherMiddleName = $("#FatherMiddleName").val();
            var FatherOccupation = $("#FatherOccupation").val();
            var MotherFullName = $("#MotherFullName").val();
            //var MotherLastName = $("#MotherLastName").val();
            //var MotherFirstName = $("#MotherFirstName").val();
            //var MotherMiddleName = $("#MotherMiddleName").val();
            var MotherOccupation = $("#MotherOccupation").val();
            //var Street = $("#Street").val();
            //var Village = $("#Village").val();
            //var Barangay = $("#Barangay").val();
            
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
            
    
            //Strand Validation
            var Strand = $("#SHSStrand").val();
            var GradeLevelIndex = $("#IncomingGradeLevel").prop('selectedIndex');
            var StrandIndex = $("#SHSStrand").prop('selectedIndex');
            if(GradeLevelIndex > 12){
                
                
            if(StrandIndex == 0){
                FormValidator = false;
                $("#StrandControlGroup").addClass("error");
                $('#StrandControlGroup').css('color', "#b94a48");
                $("#SHSStrand").css("border-color","#b94a48");
                $("#SHSStrand").css("color","#b94a48");
                $("#StrandError").show();
             
            }
            else{
                
                $("#StrandControlGroup").removeClass("error");
                $('#StrandControlGroup').css('color', "#333");
                $("#SHSStrand").css("border-color","#ccc");
                $("#SHSStrand").css("color","#333");
                $("#StrandError").hide();
              
            }
               
                
            }
            else{
             
                $("#StrandControlGroup").removeClass("error");
                $('#StrandControlGroup').css('color', "#333");
                $("#SHSStrand").css("border-color","#ccc");
                $("#SHSStrand").css("color","#333");
                $("#StrandError").hide();
                //alert("No error");
            }
            
            
            
  
            
            var StudentBirthdayInsert = formatDate(StudentBirthday);
            var AdmissionSchoolOfOrigin = $("#SchoolOfOrigin").val();
            var AdmissionTypeOfInstitution = $("#TypeOfInstitution").val();
            var IncomingGradeLevel = $("#IncomingGradeLevel").val();
            
            var Siblings = $("#Siblings").val();
            var StudentSiblings = { StudentSiblingsID: ""};
            
            
        
            var StudentDetails = {  LRNNumber: LRNNumber, LastName: StudentLastName, FirstName: StudentFirstName, MiddleName: StudentMiddleName, Gender: StudentGender, StudentNationalityID: StudentNationality, StudentBirthday: StudentBirthdayInsert, PlaceOfBirth: PlaceOfBirth, StudentReligionID: StudentReligion, FatherFullName: FatherFullName, FatherOccupation: FatherOccupation, MotherFullName: MotherFullName, MotherOccupation: MotherOccupation, AddressPrefix: AddressPrefix, StudentBarangay: Barangay, StudentMunicipalityID: Municipality, StudentProvinceID : Province, HomeNumber: HomeNum, MobileNumber: MobileNum, ContactPerson: ContactPerson, EmailAddress: EmailAddress, RelationshipToContactPerson: Relationship, ContactPersonContactNumber: ContactPersonContactNumber, AdmissionSchoolOfOrigin: AdmissionSchoolOfOrigin, AdmissionTypeOfInstitution: AdmissionTypeOfInstitution, IncomingGradeLevel: IncomingGradeLevel, Strand: Strand, StudentSiblings: [] };

            if(Siblings != null){
                
                    for(var x = 0; x<Siblings.length; x++){
                            StudentDetails.StudentSiblings.push(Siblings[x]);
                    }
                
                
            }
        
            if(FormValidator){
                   $.ajax({
                            type:'POST',
                            url:'Phase1SubmitOldStudent.php',
                            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                            success:function(html){
                                 
                                   window.location.href="/iucsenrollmentsystem/webpages/Phase1SuccessMessageOldStudent.php";
                                   
                    
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
    

    
    $('#Province').change(function() {
        
        var ProvinceID = $(this).val();
        var ProvinceIndex = $("#Province").prop('selectedIndex');
        
    
            $.ajax({
                type:'POST',
                url:'GetMunicipalityList.php',
                data:'country_id='+ProvinceID,
                success:function(html){
                    $('#Municipality').empty();
                    $('#s2id_Municipality span').text('');
                    $('#Municipality').html(html);
                    $("select#Municipality")[0].selectedIndex = 0;
                     var NewSelected = $("#Municipality option:selected").text();
                    $('#s2id_Municipality span').text(NewSelected);
                    
                }
            }); 
        
    
    
    
    });
    
    
    
    
    
    
    
     $("#IncomingGradeLevel").change(function(){ 
   
  
        
        //s2id_SHSStrand
      var GradeLevelID = $(this).val();
      var GradeLevelIndex = $("#IncomingGradeLevel").prop('selectedIndex');
            
            
            if(GradeLevelIndex != 0){
             
                
            }
    
            else{
                
                
             
            }
        
        
            if(GradeLevelIndex == 13 || GradeLevelIndex == 14){
               
                
                  $.ajax({
                    type:'GET',
                    url:'GetStrandList.php',
                    //data:'country_id='+GradeLevelID,
                    success:function(html){
                        $('#SHSStrand').empty();
                        $('#s2id_SHSStrand span').text('');
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
                
                
             
                
            }
        
        
   

});
    
    
    
    
    
        
    
</script>
    
    
    
    
    </body>
</html>
    
    
    
    
    
    
    
    
    