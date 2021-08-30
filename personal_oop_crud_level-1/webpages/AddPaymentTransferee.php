<?php 


session_start();

include 'adminheader.php';


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



$StudentID = $_SESSION['AddPaymentTransfereeStudentID'];



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
 
    $statement = $dbh->prepare("SELECT * FROM `tblstudentadmission` WHERE AdmissionStudentID = :AdmissionStudentID ORDER BY AdmissionID DESC LIMIT 1  ");
    $statement->execute(array(':AdmissionStudentID' => $StudentID));
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
              //$RetrieveSiblingDiscountID = $data['AdmissionSiblingDiscountID'];
              //$RetrieveAcademicScholarshipDiscountID = $data['AdmissionAcademicScholarshipDiscountID'];
              //$RetrievePromotionalDiscountID = $data['AdmissionPromotionalDiscountID'];
              //$RetrieveEntranceScholarshipDiscountID = $data['AdmissionEntranceScholarshipDiscountID'];
              //$RetrieveVarsityDiscountID = $data['AdmissionVarsityDiscountID'];
			  //$RetrieveSTSDiscountID = $data['AdmissionSTSDiscountID'];
              $RetrieveGradeLevelID = $data['AdmissionGradeLevelID'];
              //$RetrieveAdmissionStatus = $data['AdmissionStatus'];
              $_SESSION['EditStudentForInterviewAdmissionID'] = $data['AdmissionID'];
              $RetrieveSchoolOfOrigin = $data['AdmissionSchoolOfOrigin'];
              $RetrieveTypeOfInstitution = $data['AdmissionTypeOfInstitution'];
              $RetrieveInterviewDate = $data['InterviewDate'];
              
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




//Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel WHERE GradeLevelID = :GradeLevelID");
    $statement->execute(array(':GradeLevelID' => $RetrieveGradeLevelID));
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












$DateTodayDisplay =date("F d, yy");

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
 <center><h1> Add Initial Payment - Transferee </h1></center>
      <br>
      <br>
    
     
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Payment Transaction</h5>
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
                  <a class="btn btn-primary btn-large pull-right" href="">Pay Invoice</a> </div>
              </div>
            </div>
          </div>
        </div>
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
            
            
            
            
        }
        
     
    });
    
    


</script>
    
    
    
    
    </body>
</html>
    
    

    