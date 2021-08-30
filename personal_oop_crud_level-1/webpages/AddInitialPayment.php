<?php 


session_start();

include 'DataBaseConnectionFile.php';
include 'adminheader.php';

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



if(isset($_SESSION['SessionSelectedSchoolYearID'])){
    
    $LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    $LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
}




$StudentID = $_SESSION['AddPaymentTransfereeStudentID'];
$AdmissionIDRetrieve = $_SESSION['AddPaymentTransfereeAdmissionID'];

$_SESSION['InitialPaymentStudentID'] = $StudentID;

//Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblstudent WHERE StudentID = :StudentID");
    $statement->execute(array(':StudentID' => $StudentID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
              $RetrieveStudentIDDisplay = $row['StudentIDDisplay'];
              $_SESSION['EditStudentSelectedStudentIDDisplay'] = $RetrieveStudentIDDisplay;
              $RetrieveESCNumber = $row['ESCNumber'];
              $RetrieveLRNNumber = $row['LRNNumber'];
              $RetrieveFirstName = $row['FirstName'];
              $RetrieveMiddleName = $row['MiddleName'];
              $RetrieveLastName = $row['LastName'];
              $StudentFullName = $RetrieveFirstName.' '.$RetrieveMiddleName.' '.$RetrieveLastName;
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
            //  $RetrieveESCNumber = $row['ESCNumber'];
              $RetrieveStrand = $row['StudentStrand'];
              $RetrieveAge = $row['StudentAge'];
        
              $StudentNameDisplay = $RetrieveFirstName." ".$RetrieveMiddleName." ".$RetrieveLastName;
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
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID AND AdmissionID = :AdmissionID  ");
    $statement->execute(array(':AdmissionStudentID' => $StudentID, ':AdmissionID' => $AdmissionIDRetrieve ));
    
    $row = $statement->fetchAll(); 
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              //$RetrieveStudentIDDisplay = $data['StudentIDDisplay'];
              $RetrieveAdmissionID = $data['AdmissionID'];
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
              $RetrieveGradeLevelID = $data['AdmissionGradeLevelID'];
              //$RetrieveAdmissionStatus = $data['AdmissionStatus'];
              $_SESSION['EditStudentForInterviewAdmissionID'] = $data['AdmissionID'];
              $RetrieveSchoolOfOrigin = $data['AdmissionSchoolOfOrigin'];
              $RetrieveTypeOfInstitution = $data['AdmissionTypeOfInstitution'];
              $RetrieveInterviewDate = $data['InterviewDate'];
              $RetrieveESCDiscount = $data['ESCDiscount'];
              $RetrieveQVRDiscount = $data['QVRDiscount'];
              $RetrieveOtherDiscount = $data['OtherDiscount'];
              $RetrieveDueDate = $data['DueDate'];
              $RetrieveEmployeeDiscount = $data['AdmissionEmployeeDiscountID'];
              $RetrieveBOTDiscount = $data['AdmissionBOTDiscountID'];
              $RetrieveAdmissionBOTDiscountAmount = $data['AdmissionBOTDiscountAmount'];
              $RetrieveAdmissionVarsityDiscountAmount = $data['AdmissionVarsityDiscountAmount'];
              
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

$_SESSION['InitialPaymentAdmissionID'] = $RetrieveAdmissionID;



//Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT tblschoolfees.* FROM tblgradelevel,tblschoolfees WHERE GradeLevelID = :GradeLevelID AND SFGradeLevelID = GradeLevelID AND SFSchoolYearID = :SFSchoolYearID");
    $statement->execute(array(':GradeLevelID' => $RetrieveGradeLevelID, ':SFSchoolYearID' => $LatestSchoolYearID ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           $TuitionFee = $row['TuitionFee'];
           $RegistrationFee = $row['RegistrationFee'];
           $MiscFee = $row['MiscFee'];
           $OptionAAddOn = $row['OptionAAddOn'];
           $OptionBAddOn = $row['OptionBAddOn'];
           $OptionCAddOn = $row['OptionCAddOn'];
           $OptionDAddOn = $row['OptionDAddOn'];
        
           $RunningTotal;
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





if($RetrieveSiblingDiscountID == 44){
           $OptionAAddOn = 0;
           $OptionBAddOn = 0;
           $OptionCAddOn = 0;
           $OptionDAddOn = 0;
}


$SiblingDiscountAmount = 0;
$AcademicDiscountAmount = 0;
$PromotionalDiscountAmount = 0;
$EntranceDiscountAmount = 0;
$VarsityDiscountAmount = 0;
$STSDiscountAmount = 0;

$EmployeeDiscountAmount = 0;
$BOTDiscountAmount = 0;

$TotalDiscount = 0;
$DiscountToTuition = 0;


//Get discount for sibling discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveSiblingDiscountID ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
        if($row['DiscountTypeID'] == 44){
            $SiblingDiscountAmount = 0;
            $TotalDiscount += $SiblingDiscountAmount;
        }
        
        else{
            
        
            if(is_null($row['Percent'])){
                $SiblingDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $SiblingDiscountAmount;
                        
                
            }
            else{
                
                $SiblingDiscountPercent = $row['Percent'];
                $SiblingDiscountAmount = $TuitionFee * ($SiblingDiscountPercent/100);
                
                $DiscountToTuition += $SiblingDiscountAmount;
                
            }
        
        
        }

        
          
    } 
    else {
   
       $SiblingDiscountAmount = 0;
       $TotalDiscount += $SiblingDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}










//Get discount for academic scholarship discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveAcademicScholarshipDiscountID   ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $AcademicDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $AcademicDiscountAmount;
                        
                
            }
            else{
                $AcademicDiscountAmountPercent = $row['Percent'];
                $AcademicDiscountAmount = $TuitionFee * ($AcademicDiscountAmountPercent/100);
                
                $DiscountToTuition += $AcademicDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $AcademicDiscountAmount = 0;
       $TotalDiscount += $AcademicDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





//Get discount for promotional scholarship discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrievePromotionalDiscountID    ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $PromotionalDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $PromotionalDiscountAmount;
                        
                
            }
            else{
                $PromotionalDiscountAmountPercent = $row['Percent'];
                $PromotionalDiscountAmount  = $TuitionFee * ($PromotionalDiscountAmountPercent/100);
                
                $DiscountToTuition += $PromotionalDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $PromotionalDiscountAmount = 0;
       $TotalDiscount += $PromotionalDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





//Get discount for entrance scholarship discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveEntranceScholarshipDiscountID     ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $EntranceDiscountAmountAmount = $row['FixedAmount'];
                $TotalDiscount += $EntranceDiscountAmountAmount;
                        
                
            }
            else{
                $EntranceDiscountAmountPercent = $row['Percent'];
                $EntranceDiscountAmount  = $TuitionFee * ($EntranceDiscountAmountPercent/100);
                
                $DiscountToTuition += $EntranceDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $EntranceDiscountAmount = 0;
       $TotalDiscount += $EntranceDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//Get discount for varsity discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveVarsityDiscountID      ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
               
                
                $VarsityDiscountAmount = $RetrieveAdmissionVarsityDiscountAmount;
                
                
                if($RetrieveAdmissionVarsityDiscountAmount == null || $RetrieveAdmissionVarsityDiscountAmount == 0 ){
                    
                     $VarsityDiscountAmount = $row['FixedAmount'];
                }
                
                
                $TotalDiscount += $VarsityDiscountAmount;
                        
                
            }
            else{
                $VarsityDiscountAmountPercent = $row['Percent'];
                $VarsityDiscountAmount  = $TuitionFee * ($VarsityDiscountAmountPercent/100);
                
                $DiscountToTuition += $VarsityDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $VarsityDiscountAmount = 0;
       $TotalDiscount += $VarsityDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//Get discount for sts discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveSTSDiscountID       ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $STSDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $STSDiscountAmount;
                        
                
            }
            else{
                $STSDiscountAmountPercent = $row['Percent'];
                $STSDiscountAmount  = $TuitionFee * ($STSDiscountAmountPercent/100);
                
                $DiscountToTuition += $STSDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $STSDiscountAmount = 0;
       $TotalDiscount += $STSDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}











//Get discount for esc discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveESCDiscount        ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $ESCDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $ESCDiscountAmount;
                        
                
            }
            else{
                $ESCDiscountAmountPercent = $row['Percent'];
                $ESCDiscountAmount  = $TuitionFee * ($ESCDiscountAmountPercent/100);
                
                $DiscountToTuition += $ESCDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $ESCDiscountAmount = 0;
       $TotalDiscount += $ESCDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//Get discount for qvr discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveQVRDiscount         ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $QVRDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $QVRDiscountAmount;
                        
                
            }
            else{
                $QVRDiscountAmountPercent = $row['Percent'];
                $QVRDiscountAmount  = $TuitionFee * ($QVRDiscountAmountPercent/100);
                
                $DiscountToTuition += $QVRDiscountAmount;
                
            }
        
    
          
    } 
    else {
   
       $QVRDiscountAmount = 0;
       $TotalDiscount += $QVRDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


//Get discount for Employee discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveEmployeeDiscount  ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
        if($row['DiscountTypeID'] == 44){
            $EmployeeDiscountAmount = 0;
            $TotalDiscount += $EmployeeDiscountAmount;
        }
        
        else{
            
        
            if(is_null($row['Percent'])){
                $EmployeeDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $EmployeeDiscountAmount;
                        
                
            }
            else{
                
                $EmployeeDiscountPercent = $row['Percent'];
                $EmployeeDiscountAmount = $TuitionFee * ($EmployeeDiscountPercent/100);
                
                $DiscountToTuition += $EmployeeDiscountAmount;
                
            }
        
        
        }

        
          
    } 
    else {
   
       $EmployeeDiscountAmount = 0;
       $TotalDiscount += $EmployeeDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//Get discount for BOT discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveBOTDiscount  ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
        if($row['DiscountTypeID'] == 44){
            $BOTDiscountAmount = 0;
            $TotalDiscount += $BOTDiscountAmount;
        }
        
        else{
            
            /*
            if(is_null($row['Percent'])){
                $BOTDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $BOTDiscountAmount;
                        
                
            }
            else{
                
                $BOTDiscountPercent = $row['Percent'];
                $BOTDiscountAmount = $TuitionFee * ($BOTDiscountPercent/100);
                
                $DiscountToTuition += $BOTDiscountAmount;
                
            }
             */
            
              
                   $BOTDiscountAmount = $RetrieveAdmissionBOTDiscountAmount;
                   $TotalDiscount += $BOTDiscountAmount;
        
        }

        
          
    } 
    else {
   
       $BOTDiscountAmount = 0;
       $TotalDiscount += $BOTDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}







//Other Discount
if(isset($RetrieveOtherDiscount)){
    
   $TotalDiscount += $RetrieveOtherDiscount;   
    
}



$VisibilityToggle = ' style = " visibility: hidden; " ';

if($DiscountToTuition > $TuitionFee){
    $DiscountToTuition = $TuitionFee;
    $VisibilityToggle = ' style = " visibility: visible; " ';
}


$TotalDiscountDisplay = $TotalDiscount + $DiscountToTuition;





$DateTodayDisplay =date("F d, yy");

$DateTodayTextboxValue = date("m/d/Y");

$NextSchoolYear = $LatestSchoolYear + 1;
$DefaultDueDate = $NextSchoolYear.'/03/30';

$dateTime = new DateTime($DefaultDueDate);
$DueDateTextboxValue = $dateTime->format("m/d/Y");


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
 <center><h1> Add Initial Transaction  </h1></center>
      <br>
      <br>
    
     
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Transaction Details</h5>
        </div>
        <div class="widget-content nopadding">
              <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5">
              
                   <label class="control-label">Student Name:</label>
              <div class="controls">
                <input type="text" name="StudentName" id="StudentName" class="span10 m-wrap" value="<?php echo $StudentFullName; ?>" disabled/>
              </div>
                      
                
                 </div>
            
                
                   <div class="span5">
              
                   <label class="control-label">Incoming Grade Level:</label>
              <div class="controls">
                <select name="IncomingGradeLevel" id="IncomingGradeLevel" disabled>
                    <?php 
                                                        
                             $GradeLevelDisplay;                             
        try
{
 
    
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($RetrieveGradeLevelID == $data['GradeLevelID']){
                $selected = "selected";
                
                $GradeLevelDisplay = $data['GradeLevel'];
                $GradeLevelDisplay = $str = substr($GradeLevelDisplay, 4);
                
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
  
            
           
                
                
            
            </div>
              <br>
            
            
            <div class="row-fluid">
                <div class="span1"></div>
            <div class="span5">
              
                   <label class="control-label">Mode of Payment:</label>
              <div class="controls">
                <select name="ModeOfPayment" id="ModeOfPayment">
                    <?php 
                                                        
                                                      
        try
{
 
    
    $statement = $dbh->prepare("SELECT * FROM tblpaymentoption");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            
           echo '<option value ="' . $data['PaymentOptionID'] . '" '. $selected .'>' . $data['PaymentOptionName'] .'</option>';
            
            
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
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
            <h5 >Billing Information</h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
              <div class="span6">
                <table class="">
                  <tbody>
                    <tr>
                      <td><h4>Imus Unida Christian School</h4></td>
                    </tr>
                    <tr>
                      <td>Imus,Cavite</td>
                    </tr>
                    <tr>
                      <td>Region IV-A, CALABARZON</td>
                    </tr>
                    <tr>
                      <td></td>
                    </tr>
                    <tr>
                      <td ></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="span6">
                <table class="table table-bordered table-invoice">
                  <tbody>
                    <tr>
                    <tr>
                      <td class="width30">Enrollee Number:</td>
                      <td class="width70"><strong>To be generated by the system upon saving</strong></td>
                    </tr>
                      
                      <tr>
                      <td class="width30">Mode of Payment:</td>
                      <td class="width70" id="ModeOfPaymentDisplay"><strong>Cash Basis</strong></td>
                    </tr>
                    <tr>
                      <td>Date:</td>
                      <td><strong><?php echo $DateTodayDisplay; ?></strong></td>
                    </tr>
                    
                  <td class="width30">Student's Details:</td>
                    <td class="width70"><strong><?php echo $StudentNameDisplay; ?></strong> <br>
                      Incoming <?php echo $GradeLevelDisplay; ?> <br>
                      
                  </tr>
                    </tbody>
                  
                </table>
              </div>
            </div>
           
            <div class="row-fluid">
              <div class="span12">
                <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Category</th>
                      <th class="head1">Description</th>
                      <th class="head0 right">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tuition Fee</td>
                      <td>
                        <?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>
                        

                     </td>
                     
                      <td class="right"><strong><?php echo number_format((float)$TuitionFee, 2, '.', ''); $RunningTotal = $TuitionFee; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Registration Fee</td>
                      <td>
                        
                      <?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 2");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  
                      </td>
                  
                      <td class="right"><strong><?php echo number_format((float)$RegistrationFee, 2, '.', ''); $RunningTotal += $RegistrationFee; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Miscellaneous Fee</td>
                      <td>
                      <?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 3");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  
                      </td>
                   
                      <td class="right"><strong><?php echo number_format((float)$MiscFee, 2, '.', ''); $RunningTotal += $MiscFee; ?></strong></td>
                    </tr>
                    <tr>
                      <td>Option A: Additional Fee</td>
                      <td>
                       <?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 4");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?> 
                       </td>
                  
                      <td class="right" id="OptionAFee"><strong>0.00</strong></td>
                    </tr>
                    <tr>
                      <td>Option B: Additional Fee</td>
                      <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 4");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?></td>

                      <td class="right" id="OptionBFee"><strong>0.00</strong></td>
                    </tr>
                    <tr>
                      <td>Option C: Additional Fee</td>
                      <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 4");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?></td>

                      <td class="right" id="OptionCFee"><strong>0.00</strong></td>
                    </tr>
                        <tr>
                      <td>Option D: Additional Fee</td>
                      <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblpaymentdescriptions WHERE PaymentDescriptionID = 4");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DescriptionDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?></td>

                      <td class="right" id="OptionDFee"><strong>0.00</strong></td>
                    </tr>
                      
                  
                  </tbody>
                </table>
                <table class="table table-bordered table-invoice-full">
                  <tbody>
                    <tr>
                      <td class="msg-invoice" width="85%"><h4></h4>
                       </td>
                      
                    </tr>
                  </tbody>
                </table>
                <div class="pull-right">
                  <h4 id="AmountDueDisplay"><span>Sub-total:</span> <?php echo number_format((float)$RunningTotal, 2, '.', ''); ?></h4>
                  <br>
                    
                    
                    
                    
                    
                    

               <!--   <a class="btn btn-primary btn-large pull-right" href="">Pay Invoice</a> </div> -->
              </div>
            </div>
          </div>
           
            <h4>Discounts: </h4>
            
    <div class="row-fluid">
      <div class="span12">
           <table class="table table-bordered table-invoice-full">
                  <thead>
                    <tr>
                      <th class="head0">Category</th>
                      <th class="head1">Description</th>
                      <th class="head0 right">Amount</th>
                    </tr>
                  </thead>
               
                   <tbody>
                        <tr>
                        <td>Sibling Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$SiblingDiscountAmount, 2, '.', ''); ?> (Tuition Fee) </strong></td>
                        </tr>
                       
                       
                       
                         <tr>
                        <td>Academic Scholarship Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 2");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$AcademicDiscountAmount, 2, '.', ''); ?> (Tuition Fee) </strong></td>
                        </tr>
                       
                       
                       
                       
                       
                        <tr>
                        <td>Promotional Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 3");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$PromotionalDiscountAmount, 2, '.', ''); ?> </strong></td>
                        </tr>
                       
                       
                       
                           
                        <tr>
                        <td>Entrance Scholarship Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 4");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$EntranceDiscountAmount, 2, '.', ''); ?> (Tuition Fee) </strong></td>
                        </tr>
                       
                       
                           
                        <tr>
                        <td>Varsity Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 5");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$VarsityDiscountAmount, 2, '.', ''); ?> </strong></td>
                        </tr>
                       
                       
                           
                        <tr>
                        <td>STS Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 6");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$STSDiscountAmount, 2, '.', ''); ?> </strong></td>
                        </tr>
                       
                       
                       
                       
                          <tr>
                        <td>ESC Discount(Grade 7 to 10)</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 7");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?> </td>
                        <td><strong><?php  echo number_format((float)$ESCDiscountAmount, 2, '.', ''); ?> </strong></td>
                        </tr>
                       
                         <tr>
                        <td>QVR Discount(SHS)</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 8");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$QVRDiscountAmount, 2, '.', ''); ?> </strong></td>
                        </tr>
                       
                        <tr>
                        <td>Employee Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 9");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$EmployeeDiscountAmount, 2, '.', ''); ?> (Tuition Fee) </strong></td>
                        </tr>
                       
                       
                       
                        <tr>
                        <td>BOT Discount</td>
                        <td><?php 
                          
                          //Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory WHERE DiscountCategoryID = 10");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
           echo $row['DiscountCategoryDetails'];
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
 
                          
                        ?>  </td>
                        <td><strong><?php  echo number_format((float)$BOTDiscountAmount, 2, '.', ''); ?> </strong></td>
                        </tr>
                       
                       
                       
                           <tr>
                        <td>Other Discounts</td>
                        <td>Discounts set/added by school</td>
                        <td><strong><?php  echo number_format((float)$RetrieveOtherDiscount, 2, '.', ''); ?> </strong></td>
                      
                      </tr>
                       
                       
                       
                       
                       
                   </tbody>
               
          </table>
        
             <div class="pull-right">
                  <h4 id="TotalDiscountDisplay"><span>Total Discount:</span> <?php echo number_format((float)$TotalDiscountDisplay, 2, '.', ''); ?></h4>
                  <br>
                    
                    
                    
                    
                    
                    

               <!--   <a class="btn btn-primary btn-large pull-right" href="">Pay Invoice</a> </div> -->
              </div>
          <br>
          <br>
          <br>
          
            <div class="alert alert-error alert-block" <?php echo $VisibilityToggle; ?> > <a class="close" data-dismiss="alert" href="#">×</a>
              <h4 class="alert-heading">Notification about Discounts!</h4>
              Some discounts have been omitted to total amount due because of exceeding % of reductions to total tuition fee. Cannot exceed beyond 100% off for tuition fee as some of discounts are calculated from tuition fee. For more information, please communicate to Finance team. </div>
          
              <div class="pull-right">
                  <h2 id="FinalAmountDueDisplay"><span>Amount Due:</span> <?php $FinalAmountDue = $RunningTotal - $TotalDiscountDisplay;  echo number_format((float)$FinalAmountDue, 2, '.', ''); ; ?></h2>
                  <br>
                    
                    
                    
                    
                    
                    

               <!--   <a class="btn btn-primary btn-large pull-right" href="">Pay Invoice</a> </div> -->
              </div>
          
      </div>    
    </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
            <h5 >Transaction Details</h5>
          </div>
          <div class="widget-content">
            <div class="row-fluid">
                
                      <div class="span1"></div>
                 <div class="span5 control-group" id="AmountPaidControlGroup">
              
                   <label class="control-label">*Amount Paid/Refunded (indicate negative if refund)</label>
              <div class="controls">
                <input type="text" name="AmountPaid" id="AmountPaid" class="span10 m-wrap" placeholder="e.g. 10000.50"/>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="AmountPaidError"  name="AmountPaidError">Please enter a valid amount</span> 
              </div>
                      
           
                
                 </div>
            
                
                   <div class="span5 control-group" id="ORNumberControlGroup">
              
                   <label class="control-label">*OR/CV Number: (indicate CV# or OR# at the beginning)</label>
              <div class="controls">
                <input type="text" name="ORNumber" id="ORNumber" class="span10 m-wrap" placeholder="e.g. OR#71997"/>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="ORNumberError"  name="ORNumberError">Please enter a valid OR Number</span> 
              </div>
                      
           
                
                 </div>
                
            </div>
              
              
              <div class="row-fluid">
                
                      <div class="span1"></div>
                  
                  
                 <div class="span5">
              
                    <div class="control-group" id="DateOfPaymentControlGroup">
              <label class="control-label">*Date Of Payment</label>
              <div class="controls">
                <div  data-date="12-02-2012" class="input-append date datepicker">
                  <input type="text" name="DateOfPayment" id="DateOfPayment"  data-date-format="mm-dd-yyyy" class="span11" value="<?php echo $DateTodayTextboxValue; ?>">
                  <span class="add-on"><i class="icon-th"></i></span> </div>
                  
                    <span class="help-inline" style="color: #b94a48; display: none;" id="DateOfPaymentError"  name="DateOfPaymentError">Please enter a valid date</span> 
              </div
            </div>
                      
           
                
                 </div>
                     </div>
                     
                     
                
                   <div class="span5">
              
                       <div class="control-group" id="ORPaymentRemarksControlGroup">
              <label class="control-label">OR/Payment Remarks</label>
              <div class="controls">
                <textarea name="ORPaymentRemarks" id="ORPaymentRemarks" class="span11" ></textarea>
                  
              </div>
            </div>
                      
           
                
                 </div>

                  
            </div>
              
                
            <div class="row-fluid">
                
                <div class="span1"></div>
                  
                  
                 <div class="span5">
              
                    <div class="control-group" id="DueDateControlGroup">
              <label class="control-label">*Due Date (Default is March)</label>
              <div class="controls">
                <div  data-date="12-02-2012" class="input-append date datepicker">
                  <input type="text" name="DueDate" id="DueDate"  data-date-format="mm-dd-yyyy" class="span11" value="<?php echo $DueDateTextboxValue; ?>">
                  <span class="add-on"><i class="icon-th"></i></span> </div>
                  
                    <span class="help-inline" style="color: #b94a48; display: none;" id="DueDateError"  name="DueDateError">Please enter a valid date</span> 
              </div
            </div>
                      
           
                
                 </div>
                     </div>
            </div>
                  
                  
                  
                  
                  
                  
                  
              
            
              <div class="row-fluid">
                       <a class="btn btn-info btn-large pull-right" href="NewInitialPaymentList.php">Cancel</a>
                  
                  <button id="btnSavePayment" class="btn btn-primary btn-large pull-right" type="button" style = " margin-right: 30px;">Save Transaction</button>
             
             </div>
              
              
              
              
              
              
              
              
              
              
              
              
              
            </div>
          </div>
                </div>
            </div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
         
        </div> <!-- widget content -->
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
    
    
    

      </div>
    
    

<?php

include 'adminfooter.php';

?>
    
    
    
    
    
<script type="text/javascript">
    
    /*
  $( document ).ready(function() {
      console.log("TEST");
      alert("");
      
});
    
    */
    
    
      $("#ModeOfPayment").change(function(){
    
      
        var ModeOfPaymentVal = $(this).val();
        
        
        var ModeOfPaymentText = $("#ModeOfPayment option:selected").text();
       
        $("#ModeOfPaymentDisplay").html("<strong> "+ModeOfPaymentText.substring(4)+ " </strong>");   
    
          
        if(ModeOfPaymentVal == 1){
             //Cash basis
             $("#OptionAFee").html("<strong>0.00</strong>");
             $("#OptionBFee").html("<strong>0.00</strong>");
             $("#OptionCFee").html("<strong>0.00</strong>");
             $("#OptionDFee").html("<strong>0.00</strong>");
            
             var RunningTotal = <?php echo json_encode($RunningTotal, JSON_HEX_TAG); ?>;
             var RunningTotalDisplay = (Math.round(RunningTotal * 100) / 100).toFixed(2);
            
        
             $("#AmountDueDisplay").html("<span>Sub-total:</span> "+RunningTotalDisplay);
            
            
             var TotalDiscount = <?php echo json_encode($TotalDiscountDisplay, JSON_HEX_TAG); ?>;  
             var AmountDue = RunningTotal - TotalDiscount;
             var AmountDueDisplay = (Math.round(AmountDue * 100) / 100).toFixed(2);
            
             $("#FinalAmountDueDisplay").html("<span>Amount due:</span> "+AmountDueDisplay);
            
        }
        else if (ModeOfPaymentVal == 2){
            
            
            //Option A
            var OptionAValue = <?php echo json_encode($OptionAAddOn, JSON_HEX_TAG); ?>;
            var RunningTotal = <?php echo json_encode($RunningTotal, JSON_HEX_TAG); ?>;
            var NewRunningTotalIfOptionA = parseFloat(OptionAValue)+parseFloat(RunningTotal); 
            
            OptionAValue = (Math.round(OptionAValue * 100) / 100).toFixed(2);
            NewRunningTotalIfOptionA = (Math.round(NewRunningTotalIfOptionA * 100) / 100).toFixed(2);
        
            $("#OptionAFee").html("<strong> "+OptionAValue+" </strong> ");
            $("#OptionBFee").html("<strong>0.00</strong>");
            $("#OptionCFee").html("<strong>0.00</strong>");
            $("#OptionDFee").html("<strong>0.00</strong>");
            
            $("#AmountDueDisplay").html("<span>Sub-total:</span> "+NewRunningTotalIfOptionA);
            
             var TotalDiscount = <?php echo json_encode($TotalDiscountDisplay, JSON_HEX_TAG); ?>;  
             var AmountDue = parseFloat(NewRunningTotalIfOptionA) - parseFloat(TotalDiscount);
             var AmountDueDisplay = (Math.round(AmountDue * 100) / 100).toFixed(2);
            
             $("#FinalAmountDueDisplay").html("<span>Amount due:</span> "+AmountDueDisplay);
            
            
        }
        else if (ModeOfPaymentVal == 3){
            
            
            //Option B
            var OptionBValue = <?php echo json_encode($OptionBAddOn, JSON_HEX_TAG); ?>;
            var RunningTotal = <?php echo json_encode($RunningTotal, JSON_HEX_TAG); ?>;
            var NewRunningTotalIfOptionB = parseFloat(OptionBValue)+parseFloat(RunningTotal); 
            
            OptionBValue = (Math.round(OptionBValue * 100) / 100).toFixed(2);
            NewRunningTotalIfOptionB = (Math.round(NewRunningTotalIfOptionB * 100) / 100).toFixed(2);
        
            $("#OptionAFee").html("<strong>0.00</strong>");
            $("#OptionBFee").html("<strong> "+OptionBValue+" </strong> ");
            $("#OptionCFee").html("<strong>0.00</strong>");
            $("#OptionDFee").html("<strong>0.00</strong>");
            
            $("#AmountDueDisplay").html("<span>Sub-total:</span> "+NewRunningTotalIfOptionB);
            
            
             var TotalDiscount = <?php echo json_encode($TotalDiscountDisplay, JSON_HEX_TAG); ?>;  
            var AmountDue = parseFloat(NewRunningTotalIfOptionB) - parseFloat(TotalDiscount);
             var AmountDueDisplay = (Math.round(AmountDue * 100) / 100).toFixed(2);
            
             $("#FinalAmountDueDisplay").html("<span>Amount due:</span> "+AmountDueDisplay);
            
            
            
        }
          
        else if (ModeOfPaymentVal == 4){
            
            
            //Option C
            var OptionCValue = <?php echo json_encode($OptionCAddOn, JSON_HEX_TAG); ?>;
            var RunningTotal = <?php echo json_encode($RunningTotal, JSON_HEX_TAG); ?>;
            var NewRunningTotalIfOptionC = parseFloat(OptionCValue)+parseFloat(RunningTotal); 
            
            OptionCValue = (Math.round(OptionCValue * 100) / 100).toFixed(2);
            NewRunningTotalIfOptionC = (Math.round(NewRunningTotalIfOptionC * 100) / 100).toFixed(2);
        
            $("#OptionAFee").html("<strong>0.00</strong>");
            $("#OptionBFee").html("<strong>0.00</strong>");
            $("#OptionCFee").html("<strong> "+OptionCValue+" </strong> ");
            $("#OptionDFee").html("<strong>0.00</strong>");
            
            $("#AmountDueDisplay").html("<span>Sub-total:</span> "+NewRunningTotalIfOptionC);
            
             var TotalDiscount = <?php echo json_encode($TotalDiscountDisplay, JSON_HEX_TAG); ?>;  
            var AmountDue = parseFloat(NewRunningTotalIfOptionC) - parseFloat(TotalDiscount);
             var AmountDueDisplay = (Math.round(AmountDue * 100) / 100).toFixed(2);
            
             $("#FinalAmountDueDisplay").html("<span>Amount due:</span> "+AmountDueDisplay);
            
            
            
            
        }
          
        else if (ModeOfPaymentVal == 5){
            
            
            //Option D
            var OptionDValue = <?php echo json_encode($OptionDAddOn, JSON_HEX_TAG); ?>;
            var RunningTotal = <?php echo json_encode($RunningTotal, JSON_HEX_TAG); ?>;
            var NewRunningTotalIfOptionD = parseFloat(OptionDValue)+parseFloat(RunningTotal); 
            
            OptionDValue = (Math.round(OptionDValue * 100) / 100).toFixed(2);
            NewRunningTotalIfOptionD = (Math.round(NewRunningTotalIfOptionD * 100) / 100).toFixed(2);
        
            $("#OptionAFee").html("<strong>0.00</strong>");
            $("#OptionBFee").html("<strong>0.00</strong>");
            $("#OptionCFee").html("<strong>0.00</strong>");
            $("#OptionDFee").html("<strong> "+OptionDValue+" </strong> ");
            
            $("#AmountDueDisplay").html("<span>Sub-total:</span> "+NewRunningTotalIfOptionD);
            
             var TotalDiscount = <?php echo json_encode($TotalDiscountDisplay, JSON_HEX_TAG); ?>;  
            var AmountDue = parseFloat(NewRunningTotalIfOptionD) - parseFloat(TotalDiscount);
             var AmountDueDisplay = (Math.round(AmountDue * 100) / 100).toFixed(2);
            
             $("#FinalAmountDueDisplay").html("<span>Amount due:</span> "+AmountDueDisplay);
            
            
            
            
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
    

    
      $("#btnSavePayment").click(function(e){
        if (confirm('Are you sure you want to save this payment?')) {
            
              var FormValidator = true;
            

            //Amount Paid Validation
            var AmountPaid = $("#AmountPaid").val();
            if(isNaN(AmountPaid) || AmountPaid == null || AmountPaid == ""){
                FormValidator = false;
                $("#AmountPaidControlGroup").addClass("error");
                $("#AmountPaidError").show();
            }
            else{
               $("#AmountPaidControlGroup").removeClass("error");
               $("#AmountPaidError").hide();
            }
            
            
            //OR Number Validation
            var ORNumber  = $("#ORNumber").val();
            if(ORNumber == null || ORNumber == ""){
                FormValidator = false;
                $("#ORNumberControlGroup").addClass("error");
                $("#ORNumberError").show();
            }
            else{
               $("#ORNumberControlGroup").removeClass("error");
               $("#ORNumberError").hide();
            }
            
            
    
            
            //Date of Payment Validation
            var DateOfPayment = $("#DateOfPayment").val();
            if (Date.parse(DateOfPayment) ) {
                
               if(DateOfPayment != null || DateOfPayment != ""){
                   $("#DateOfPaymentControlGroup").removeClass("error");
                   $("#DateOfPaymentError").hide();
               }
               else{
                   FormValidator = false;
                   $("#DateOfPaymentControlGroup").addClass("error");
                   $("#DateOfPaymentError").show();
               }
            } 
            else
            {
                FormValidator = false;
                $("#DateOfPaymentControlGroup").addClass("error");
                $("#DateOfPaymentError ").show();
            }
            
            
            
            
            
            //Due Date Validation
            var DueDate = $("#DueDate").val();
            if (Date.parse(DueDate) ) {
                
               if(DueDate != null || DueDate != ""){
                   $("#DueDateControlGroup").removeClass("error");
                   $("#DueDateError").hide();
               }
               else{
                   FormValidator = false;
                   $("#DueDateControlGroup").addClass("error");
                   $("#DueDateError").show();
               }
            } 
            else
            {
                FormValidator = false;
                $("#DueDateControlGroup").addClass("error");
                $("#DueDateError ").show();
            }
            
            
            
            
            
            var ORPaymentRemarks = $("#ORPaymentRemarks").val();
            var DateOfPaymentInsert = formatDate(DateOfPayment);
            var DueDateInsert = formatDate(DueDate);
            var ModeOfPayment = $("#ModeOfPayment").val();
            
   
        
            var PaymentDetails = { AmountPaid: AmountPaid, ORNumber: ORNumber, DateOfPaymentInsert: DateOfPaymentInsert, ORPaymentRemarks: ORPaymentRemarks, ModeOfPayment: ModeOfPayment, DueDateInsert: DueDateInsert };

            
        
            if(FormValidator){
                   $.ajax({
                            type:'POST',
                            url:'InitialPaymentSubmit.php',
                            data:{"RetrieveTransaction" : JSON.stringify(PaymentDetails)},
                            success:function(html){
                                 
                                   //alert("Success");
                               window.location.href="/iucsenrollmentsystem/webpages/InitialPaymentSuccessMessage.php";
                                   
                    
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
                // document.documentElement.scrollTop = 0;
                 
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
    
    

    