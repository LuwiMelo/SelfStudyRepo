<?php


session_start();

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}

*/

include 'DataBaseConnectionFile.php';
$SOAAdmissionID = $_SESSION['GenerateSOAAdmissionID'];


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


$NewAmountDueDisplay = $_SESSION['GenerateSOAAmountDueDisplay'];

if(isset($_SESSION['SessionSelectedSchoolYearID'])){
    
    $LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    $LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
}



//GET Admission Details
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblstudentadmission WHERE AdmissionID= :AdmissionID");
    $statement->execute(array(':AdmissionID' => $SOAAdmissionID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        $ReferenceNumber = $row['AdmissionReferenceNum'];
        $StudentID = $row['AdmissionStudentID'];
        $GradeLevelID = $row['AdmissionGradeLevelID'];
        $ModeOfPaymentID = $row['AdmissionModeOfPaymentID'];
        $AdmissionSiblingDiscountID = $row['AdmissionSiblingDiscountID'];
        $AdmissionAcademicScholarshipDiscountID = $row['AdmissionAcademicScholarshipDiscountID'];
        $AdmissionPromotionalDiscountID = $row['AdmissionPromotionalDiscountID'];
        $AdmissionEntranceScholarshipDiscountID = $row['AdmissionEntranceScholarshipDiscountID'];
        $AdmissionVarsityDiscountID = $row['AdmissionVarsityDiscountID'];
        $AdmissionSTSDiscountID = $row['AdmissionSTSDiscountID'];
        $ESCDiscount = $row['ESCDiscount'];
        $QVRDiscount = $row['QVRDiscount'];
        $AdmissionSectionID = $row['AdmissionSectionID'];
        $DueDate = $row['DueDate'];
        $RetrieveOtherDiscount = $row['OtherDiscount'];
        $RetrieveAssessmentID = $row['AdmissionAssessmentIDDisplay'];
        $RetrieveReenrollmentID = $row['AdmissionReenrollmentID'];
        $RetrieveEmployeeDiscountID = $row['AdmissionEmployeeDiscountID'];
        $RetrieveBOTDiscountID = $row['AdmissionBOTDiscountID'];
        $RetrieveBOTDiscountAmount = $row['AdmissionBOTDiscountAmount'];
        $RetrieveVarsityDiscountAmount = $row['AdmissionVarsityDiscountAmount'];
        
        
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



if(isset($RetrieveAssessmentID)){
    
    $ReferenceNumberDisplay = "T-".$RetrieveAssessmentID;
}
else{
    $ReferenceNumberDisplay = "R-".$RetrieveReenrollmentID;
}




//GET student details
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblstudent WHERE StudentID= :StudentID");
    $statement->execute(array(':StudentID' => $StudentID ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        $StudentIDDisplay = $row['StudentIDDisplay'];
        $LastName = $row['LastName'];
        $FirstName = $row['FirstName'];
        $MiddleName = $row['MiddleName'];
          
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


//GET sectiondetails
$SectionName = "";
if(isset($AdmissionSectionID)){
    
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblsection WHERE SectionID= :SectionID");
    $statement->execute(array(':SectionID' => $AdmissionSectionID ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
         $SectionName = $row['SectionName'];
         $SectionName = substr($SectionName,4);
          
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    
    
    
}
else{
    $SectionName = "";
}





//GET Tuition Fee Information
try
{
    
    //$statement = $dbh->prepare("SELECT * FROM tblgradelevel WHERE GradeLevelID= :GradeLevelID");
    //$statement->execute(array(':GradeLevelID' => $GradeLevelID));
    
    $statement = $dbh->prepare("SELECT tblschoolfees.*,GradeLevel FROM tblgradelevel,tblschoolfees WHERE GradeLevelID = :GradeLevelID AND GradeLevelID = SFGradeLevelID AND SFSchoolYearID = :SFSchoolYearID");
    
    $statement->execute(array(':GradeLevelID' => $GradeLevelID, ':SFSchoolYearID' => $LatestSchoolYearID ));
    
    
    $row = $statement->fetch();
    
    if (!empty($row)) {
        $GradeLevel = $row['GradeLevel'];
        
        if(isset($row['GradeLevel'])){
            $GradeLevel = substr($GradeLevel, 4);
        }
        
        
        $TuitionFee = $row['TuitionFee'];
        $RegistrationFee = $row['RegistrationFee'];
        $MiscFee = $row['MiscFee'];
        $TuitionFee = $row['TuitionFee'];
        $DistanceLearningDiscount = $row['DistanceLearningDiscount'];
        $AddOnPayment = 0.00;
        
        if($ModeOfPaymentID == 1){
            $AddOnPayment = 0.00;
        }
        
        if($ModeOfPaymentID == 2){
            $AddOnPayment = $row['OptionAAddOn'];
        }
        
        if($ModeOfPaymentID == 3){
            $AddOnPayment = $row['OptionBAddOn'];
        }
        
        if($ModeOfPaymentID == 4){
            $AddOnPayment = $row['OptionCAddOn'];
        }
        
        if($ModeOfPaymentID == 5){
            $AddOnPayment = $row['OptionDAddOn'];
        }
        
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



$TotalBillWithoutDiscount = $TuitionFee + $RegistrationFee + $MiscFee + $AddOnPayment;


$LatestSchoolYear = substr($ReferenceNumber, 0, 4);
$DateTodayDisplay =date("F d, Y");
$FullNameDisplay = strtoupper($LastName.', '.$FirstName.' '.$MiddleName);





$SiblingDiscountAmount = 0;
$AcademicDiscountAmount = 0;
$PromotionalDiscountAmount = 0;
$EntranceDiscountAmount = 0;
$VarsityDiscountAmount = 0;
$STSDiscountAmount = 0;
$ESCQVRDiscountAmount = 0;
$OtherDiscountAmount = 0;

$NewVarsityDiscountAmount = 0;
$EmployeeDiscountAmount = 0;
$BOTDiscountAmount = 0;

$SiblingDiscountCodeDisplay = "";
$AcademicDiscountCodeDisplay = "";
$PromotionalDiscountCodeDisplay = "";
$EntranceDiscountCodeDisplay = "";
$VarsityDiscountCodeDisplay = "";
$STSDiscountCodeDisplay = "";
$ESCQVRDiscountCodeDisplay = "";

$EmployeeDiscountCodeDisplay = "";
$BOTDiscountCodeDisplay = "";


$TotalDiscount = 0;
$DiscountToTuition = 0;




//Get discount for sibling discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $AdmissionSiblingDiscountID  ));
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
        
        
             $SiblingDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($SiblingDiscountCode, $TrimIndicator);
             $SiblingDiscountCodeDisplay = substr($SiblingDiscountCode, 0, $pos);
            
            
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
    $statement->execute(array(':DiscountTypeID' => $AdmissionAcademicScholarshipDiscountID    ));
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
        
    
             $AcademicDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($AcademicDiscountCode, $TrimIndicator);
             $AcademicDiscountCodeDisplay = substr($AcademicDiscountCode, 0, $pos);
        
        
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
    $statement->execute(array(':DiscountTypeID' => $AdmissionPromotionalDiscountID     ));
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
        
             $PromotionalDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($PromotionalDiscountCode, $TrimIndicator);
             $PromotionalDiscountCodeDisplay = substr($PromotionalDiscountCode, 0, $pos);
        
          
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
    $statement->execute(array(':DiscountTypeID' => $AdmissionEntranceScholarshipDiscountID      ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $EntranceDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $EntranceDiscountAmount;
                        
                
            }
            else{
                $EntranceDiscountAmountPercent = $row['Percent'];
                $EntranceDiscountAmount  = $TuitionFee * ($EntranceDiscountAmountPercent/100);
                
                $DiscountToTuition += $EntranceDiscountAmount;
                
            }
        
             $EntranceDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($EntranceDiscountCode, $TrimIndicator);
             $EntranceDiscountCodeDisplay = substr($EntranceDiscountCode, 0, $pos);
          
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
    $statement->execute(array(':DiscountTypeID' => $AdmissionVarsityDiscountID       ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                
                $VarsityDiscountAmount = $RetrieveVarsityDiscountAmount;
                
                
                if($RetrieveVarsityDiscountAmount == null || $RetrieveVarsityDiscountAmount == 0 ){
                    
                     $VarsityDiscountAmount = $row['FixedAmount'];
                }
                
                
                $TotalDiscount += $VarsityDiscountAmount;
                        
                
            }
            else{
                $VarsityDiscountAmountPercent = $row['Percent'];
                $VarsityDiscountAmount  = $TuitionFee * ($VarsityDiscountAmountPercent/100);
                
                $DiscountToTuition += $VarsityDiscountAmount;
                
            }
        
             $VarsityDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($VarsityDiscountCode, $TrimIndicator);
             $VarsityDiscountCodeDisplay = substr($VarsityDiscountCode, 0, $pos);
        
          
    } 
    else {
   
        
      if($RetrieveVarsityDiscountAmount == null || $RetrieveVarsityDiscountAmount == 0 ){
                        
          $VarsityDiscountAmount = 0;
          $TotalDiscount += $VarsityDiscountAmount;     
                            
       }
       else{
           $VarsityDiscountAmount = $RetrieveVarsityDiscountAmount;
           $TotalDiscount += $VarsityDiscountAmount;
           
       }
      
        
        
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
    $statement->execute(array(':DiscountTypeID' => $AdmissionSTSDiscountID        ));
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
        
        
             $STSDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($STSDiscountCode, $TrimIndicator);
             $STSDiscountCodeDisplay = substr($STSDiscountCode, 0, $pos);
          
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
    $statement->execute(array(':DiscountTypeID' => $ESCDiscount         ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $ESCQVRDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $ESCQVRDiscountAmount;
                        
                
            }
            else{
                $ESCQVRDiscountAmountPercent = $row['Percent'];
                $ESCQVRDiscountAmount  = $TuitionFee * ($ESCQVRDiscountAmountPercent/100);
                
                $DiscountToTuition += $ESCQVRDiscountAmount;
                
            }
        
             $ESCQVRDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($ESCQVRDiscountCode, $TrimIndicator);
             $ESCQVRDiscountCodeDisplay = substr($ESCQVRDiscountCode, 0, $pos);
          
    } 
    else {
   
       $ESCQVRDiscountAmount = 0;
       $TotalDiscount += $ESCQVRDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





//Get discount for employee discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $RetrieveEmployeeDiscountID  ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                
                
            
                $EmployeeDiscountAmount  = $row['FixedAmount'];
                $TotalDiscount += $EmployeeDiscountAmount;
                        
                
            }
            else{
                $EmployeeDiscountAmountPercent = $row['Percent'];
                $EmployeeDiscountAmount  = $TuitionFee * ($EmployeeDiscountAmountPercent/100);
                
                $DiscountToTuition += $EmployeeDiscountAmount;
                
            }
        
             $EmployeeDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($EmployeeDiscountCode, $TrimIndicator);
             $EmployeeDiscountCodeDisplay = substr($EmployeeDiscountCode, 0, $pos);
          
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
    $statement->execute(array(':DiscountTypeID' => $RetrieveBOTDiscountID  ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                
                $BOTDiscountAmount = $RetrieveBOTDiscountAmount;
                
                if($RetrieveBOTDiscountAmount == null || $RetrieveBOTDiscountAmount == 0){
                       $BOTDiscountAmount  = $row['FixedAmount'];
                }
             
                $TotalDiscount += $BOTDiscountAmount;
                        
                
            }
            else{
                
                $BOTDiscountAmount = $RetrieveBOTDiscountAmount;
                
                
                if($RetrieveBOTDiscountAmount == null || $RetrieveBOTDiscountAmount == 0){
                        $BOTDiscountAmountPercent = $row['Percent'];
                        $BOTDiscountAmount  = $TuitionFee * ($BOTDiscountAmountPercent/100);
                }
                
                

                
                $DiscountToTuition += $BOTDiscountAmount;
                
            }
        
             $BOTDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($BOTDiscountCode, $TrimIndicator);
             $BOTDiscountCodeDisplay = substr($BOTDiscountCode, 0, $pos);
          
    } 
    else {
   
        
       if($RetrieveBOTDiscountAmount == null || $RetrieveBOTDiscountAmount == 0){
                           
           $BOTDiscountAmount = 0;
           $TotalDiscount += $BOTDiscountAmount;        
       }
       else{
           
          $BOTDiscountAmount = $RetrieveBOTDiscountAmount;
          $TotalDiscount += $BOTDiscountAmount;   
       }

    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}























if($GradeLevelID <= 13){
    
    
    
}
else{
    
    
//Get discount for qvr discount
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID ");
    $statement->execute(array(':DiscountTypeID' => $QVRDiscount          ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
      

        
            if(is_null($row['Percent'])){
                $ESCQVRDiscountAmount = $row['FixedAmount'];
                $TotalDiscount += $ESCQVRDiscountAmount;
                        
                
            }
            else{
                $ESCQVRDiscountAmountPercent = $row['Percent'];
                $ESCQVRDiscountAmount  = $TuitionFee * ($ESCQVRDiscountAmountPercent/100);
                
                $DiscountToTuition += $ESCQVRDiscountAmount;
                
            }
        
    
             $ESCQVRDiscountCode = $row['DiscountType'];
             $TrimIndicator = '-';
             $pos = strpos($ESCQVRDiscountCode, $TrimIndicator);
             $ESCQVRDiscountCodeDisplay = substr($ESCQVRDiscountCode, 0, $pos);
        
          
    } 
    else {
   
       $ESCQVRDiscountAmount = 0;
       $TotalDiscount += $ESCQVRDiscountAmount;
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

}


if(isset($RetrieveOtherDiscount)){
    
    $TotalDiscount += $RetrieveOtherDiscount;
    
}

if(isset($DistanceLearningDiscount)){
    
    $TotalDiscount += $DistanceLearningDiscount;
    
}




if($DiscountToTuition > $TuitionFee){
    $DiscountToTuition = $TuitionFee;
   
}



$TotalDiscountDisplay = $TotalDiscount + $DiscountToTuition;

$TotalBillCashBasis = $TuitionFee + $MiscFee + $RegistrationFee;




$AmountPaidIncrements = 0;
//Generate each payment made
try
{
 
    $statement = $dbh->prepare("SELECT *,MONTH(DateOfPayment) AS 'Month' FROM tblpaymenttransactions,tblstudentadmission WHERE PaymentAdmissionID = AdmissionID AND AdmissionID = :AdmissionID ORDER BY DateOfPayment ");
    $statement->execute(array(':AdmissionID' => $SOAAdmissionID     ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
    foreach($row as $data){
                $AmountPaidIncrements += $data['AmountPaid'];
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



if(isset($DueDate)){
    $dateTime = new DateTime($DueDate);
    //$DueDateDisplay = $dateTime->format("m/d/Y");
    $DueDateDisplay = date('F j, Y', strtotime($DueDate));
    
}
else{
    
    $DueDateDisplay = "March 30, ".$LatestSchoolYear;
    
}





    require("mysql_table.php");


        //footer - page number
        class PDF extends PDF_MySQL_Table {
         
            function Footer() {
                  
                    $date = date_default_timezone_set('Asia/Manila');
                    $dt = date("F j, Y  g:i A");
                    $this->SetY(-19);
                    //$this->Ln(4);
                    $this->SetFont('Arial','I',6);
                    $this->Cell(10);
                    $this->Cell(40,10,"Generated on {$dt}",0,0,'L');
                    $this->Cell(65);
                    $this->Cell(30,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
            }
            
            
            
             function Header(){
                   
                    $pageWidth = 279;
                    $pageHeight = 216;
                    $margin = 10;
                  
                    $this->SetLineWidth(0.5);
                    $this->Rect($margin, $margin , 119.5 , 195);
                    
                    //$this->Rect(144.5, 210 , 129 , -205);
                   // $this->Rect(149.5, 205 , 119 , -195);
                   //(kakaliwa pag dinagdagan, bababa pag dinagdagan, mababawasan kanan border pag dinagdagan  ,  width, height  )
             }

            
            
        }
        
     
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('L','Letter');
        $pdf->SetMargins(0,0);
        $pdf->SetLineWidth(0.5);
      
        $pdf->Line(139.5, 0, 139.5, 216); // division
       
    //header

    $SchoolLogo = "fpdf/images/iucslogo.jpg";
    $IUCSHeader = "IUCSheader.png";

 


    $pdf->SetFont('Arial','B',12);

//NOTE: +139.5 mula sa kaliwa para makuha ang katapat sa page 2

    //border
    //$pdf->Rect($margin,$margin, $pageWidth - $margin * 2, $pageHeight - $margin * 2);

//School logo page 1
    $pdf->Ln(7);
    $pdf->SetXY(20,11); 
    $pdf->Cell(0,10, $pdf->Image($SchoolLogo, $pdf->GetX(),$pdf->GetY(), 15),0,0,'L',false);

//Iucs header logo page 1
    $pdf->SetXY(38,12);
    $pdf->Cell(0,20, $pdf->Image($IUCSHeader, $pdf->GetX(),$pdf->GetY(),75),0,0,'L',false);

    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(40);
    $pdf->Cell(57,10,'Sol. P. Bella St., Poblacion I-B, City of Imus, Cavite 4103',0,0,'L');



    $pdf->Ln(3);
    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(50);
    $pdf->Cell(0,10,'Tel nos. 471-0525 / 472-2747',0,0,'L');

    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(48);
    $pdf->Cell(0,10,'STATEMENT OF ACCOUNT',0,0,'L');


//HEADER HORIZONTAL LINE
  //  $pdf->Line(20, 45, 210-20, 45); 

//HEADER HORIZONTAL LINE
     // 50mm from each edge
$pdf->Ln(10); 

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(20);
        $pdf->Cell(20,4,"SCHOOL YEAR ",0,0,'L');
        $LatestSchoolYearPlus1 = intval($LatestSchoolYear) + 1;
        $pdf->Cell(45,4,$LatestSchoolYear.'-'.$LatestSchoolYearPlus1,0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(21,4,"ENROLLEE ID:",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(209, 15, 15);
        $pdf->Cell(17,4,$ReferenceNumberDisplay,0,0,'L');
        $pdf->SetTextColor(0,0,0);


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(5);
        $pdf->Cell(20,4,"",0,0,'L');
        $pdf->Cell(65,4,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(8,4,"Date:",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,$DateTodayDisplay,0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(20,4,"Student ID:",0,0,'L');
        $pdf->Cell(43,4,$StudentIDDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"",0,0,'L');



        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(15,4,"NAME:",0,0,'L');
        $pdf->Cell(80,4,$FullNameDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(25,5,"Level/ Grade/ Yr.",0,0,'L');
        $strsize = $pdf->GetStringWidth($GradeLevel);
        $pdf->Cell($strsize,5,$GradeLevel,0,0,'L');

        $pdf->Cell(43,5,'-- '.$SectionName,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"Particulars:",0,0,'L');
        $pdf->Cell(43,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Tuition Fee",0,0,'L');
        $pdf->Cell(55,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,number_format((float)$TuitionFee, 2, '.', ','),0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Registration Fee",0,0,'L');
        $pdf->Cell(55,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";
        if(strlen(number_format((float)$RegistrationFee, 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        } 
        $pdf->Cell(17,5,$SpaceAdd.number_format((float)$RegistrationFee, 2, '.', ','),0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Miscellaneous + Other Fees",0,0,'L');
        $pdf->Cell(55,5,"",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $SpaceAdd = "";
        if(strlen(number_format((float)$MiscFee, 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        } 
        $pdf->Cell(17,5,$SpaceAdd.number_format((float)$MiscFee, 2, '.', ','),0,0,'L');




        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Total If Cash Basis",0,0,'L');
        $pdf->Cell(55,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,number_format((float)$TotalBillCashBasis, 2, '.', ','),0,0,'L');



        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Addtl. Payment if not cash basis",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $pdf->Cell(45,5,"",0,0,'L');
        $pdf->Cell(10,5,"",0,0,'L');
        
        $SpaceAdd = "";
        if(strlen(number_format((float)$AddOnPayment , 2, '.', ',')) == 4){
            $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$AddOnPayment , 2, '.', ',')) == 5){
            $SpaceAdd = "        ";
        
        } 

        if(strlen(number_format((float)$AddOnPayment , 2, '.', ',')) == 6){
            $SpaceAdd = "       ";
        
        } 
    
        if(strlen(number_format((float)$AddOnPayment , 2, '.', ',')) == 7){
            $SpaceAdd = "     ";
        
        }

        if(strlen(number_format((float)$AddOnPayment , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        $AddOnPaymentDisplay = number_format((float)$AddOnPayment, 2, '.', ',');

      
      

        $pdf->Cell(17,5,$SpaceAdd.$AddOnPaymentDisplay,0,0,'L');




        

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"TOTAL",0,0,'L');
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(17,5,number_format((float)$TotalBillWithoutDiscount, 2, '.', ','),0,0,'L');

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"Less Discount & Other Deduction (see page 2 for breakdown)",0,0,'L');
        $pdf->Cell(59,5,"",0,0,'L');
        $pdf->SetFont('Arial','BU',7);


        $SpaceAdd = "";

        //$TotalDiscountDisplay = 15000;
       
        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 
        
        $TotalDiscountDisplay2 = number_format((float)$TotalDiscountDisplay , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd."(".$TotalDiscountDisplay2.")",0,0,'L');



        $GrandTotalDisplay = $TotalBillWithoutDiscount - $TotalDiscountDisplay;





        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"NET for SY ".$LatestSchoolYear."-".$LatestSchoolYearPlus1,0,0,'L');
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','B',7);



        $SpaceAdd = "";

        //$GrandTotalDisplay = 1000;

        if(strlen(number_format((float)$GrandTotalDisplay , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$GrandTotalDisplay , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$GrandTotalDisplay , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$GrandTotalDisplay , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$GrandTotalDisplay , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$GrandTotalDisplay , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $GrandTotalDisplay2 = number_format((float)$GrandTotalDisplay , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$GrandTotalDisplay2,0,0,'L');

       


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"Less Payment (See page 2 for breakdown)",0,0,'L');
        $pdf->Cell(59,5,"",0,0,'L');
        $pdf->SetFont('Arial','BU',7);


        
        $SpaceAdd = "";

        //$AmountPaidIncrements = 10000;

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $AmountPaidIncrements2 = number_format((float)$AmountPaidIncrements , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd."(".$AmountPaidIncrements2.")",0,0,'L');



        $OutstandingBalance = $GrandTotalDisplay-$AmountPaidIncrements;
        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"Outstanding Balance",0,0,'L');
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','BU',7);


        $SpaceAdd = "";

        //$OutstandingBalance = 10000;

        if(strlen(number_format((float)$OutstandingBalance , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$OutstandingBalance , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$OutstandingBalance , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$OutstandingBalance , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$OutstandingBalance , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$OutstandingBalance , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $OutstandingBalance2 = number_format((float)$OutstandingBalance , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$OutstandingBalance2,0,0,'L');







        //$pdf->Cell(17,5,number_format((float)$OutstandingBalance, 2, '.', ','),0,0,'L');


       

       

        $pdf->Ln(15); 
        $pdf->Cell(10);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(27,5,"NOTES: ",0,0,'L');
        $pdf->Cell(79,5," ",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        //$pdf->Cell(30,5,"8,000.00",0,0,'L');

        $pdf->Ln(5); 
        $pdf->Cell(20);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(79,3,"___________________________________________________________________________",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        //$pdf->Cell(30,5,"8,000.00",0,0,'L');


        $pdf->Ln(3); 
        $pdf->Cell(20);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(79,3,"___________________________________________________________________________",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        //$pdf->Cell(30,5,"8,000.00",0,0,'L');



        $pdf->Ln(3); 
        $pdf->Cell(20);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(79,3,"___________________________________________________________________________",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        //$pdf->Cell(30,5,"8,000.00",0,0,'L');



        $pdf->Ln(10); 
        $pdf->SetFillColor(115, 207, 2);
        $pdf->Cell(10);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(53,5,"              AMOUNT DUE for this SY PHP ",0,0,'L');
        
        //$pdf->Cell(20,5,"   7,500.00   ",0,0,'L',true);
//Amount Due for this School Year
        $pdf->SetTextColor(237, 9, 9);
        $pdf->SetFont('Arial','B',8);
        
        $pdf->Cell(15,5,number_format((float)$NewAmountDueDisplay, 2, '.', ','),0,0,'L');
       
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
//Amount Due for this School Year
        $pdf->Cell(59,5," plus surcharges if any. Please  settle  ",0,0,'L');
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"your account due on or before ",0,0,'L');
//Due Date
        $pdf->SetTextColor(237, 9, 9);
        $pdf->SetFont('Arial','B',8);
        $strsize = $pdf->GetStringWidth($DueDateDisplay);
        $pdf->Cell($strsize,5,$DueDateDisplay,0,0,'L');
        //$pdf->Cell(27,5,$DueDateDisplay,0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
//Due Date
        $pdf->Cell(74,5," at main building if Elem & extension ",0,0,'L');
        $pdf->Ln(4);    
        $pdf->Cell(10);
        $pdf->Cell(134,5,"building if HS, just present this SOA to the cashier. Incase of discrepancy against your ",0,0,'L');
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(134,5,"personal record or any other queries,please present your receipt and proceed to Extension  ",0,0,'L');
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(134,5,"building for reconciliation at Head Cashier. Please disregard notice if payment has been made.",0,0,'L');
     
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(134,5,"Thank you.",0,0,'L');

        $pdf->Ln(7);
        $pdf->Cell(13);
       

        $pdf->SetFont('Arial','',8);
        $pdf->Ln(5);
        $pdf->Cell(7);
        $pdf->Cell(50,0,"____________________________",0,2,'C');
        $pdf->Ln(3);
        $pdf->Cell(7);
        $pdf->Cell(50,0,"Maria Teresa B. Pasiona",0,2,'C');
        $pdf->Ln(3);
        $pdf->Cell(7);
        $pdf->Cell(50,0,"Cashier",0,2,'C');
        $pdf->Ln(7);
        $pdf->SetFont('Arial','I',7);
        $pdf->Cell(10);
        $pdf->Cell(119.5,5,'"Train up a child in the way he should go,and when he is old, he will not depart from it." Proverbs.22:6 "',1,2,'C');
        //$pdf->Cell(210,0,"Secretary",0,2,'C');
        //$pdf->Cell(198,0,"HRD Officer",0,2,'R');



   //Line Function Syntax(x axis start, y axis start, x axis end, y axis end)
        $pdf->SetLineWidth(0.5);
//Underline Under Statement of Account Page 1
        $pdf->Line(10, 31, 129.5, 31);
//Underline Under Statement of Account Page 2
        //$pdf->Line(149.5, 31, 268.5, 31);




//****************STATEMENT OF ACCOUNT PAGE 2 STATEMENT OF ACCOUNT PAGE 2 STATEMENT OF ACCOUNT PAGE 2 *******************
    $pdf->AddPage('L','Letter');


//School logo page 1
    $pdf->Ln(7);
    $pdf->SetXY(20,11); 
    $pdf->Cell(0,10, $pdf->Image($SchoolLogo, $pdf->GetX(),$pdf->GetY(), 15),0,0,'L',false);

//Iucs header logo page 1
    $pdf->SetXY(38,12);
    $pdf->Cell(0,20, $pdf->Image($IUCSHeader, $pdf->GetX(),$pdf->GetY(),75),0,0,'L',false);

    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(40);
    $pdf->Cell(57,10,'Sol. P. Bella St., Poblacion I-B, City of Imus, Cavite 4103',0,0,'L');



    $pdf->Ln(3);
    $pdf->SetFont('Arial','B',6);
    $pdf->Cell(50);
    $pdf->Cell(0,10,'Tel nos. 471-0525 / 472-2747',0,0,'L');

    $pdf->Ln(4);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(48);
    $pdf->Cell(0,10,'STATEMENT OF ACCOUNT',0,0,'L');


//HEADER HORIZONTAL LINE
  //  $pdf->Line(20, 45, 210-20, 45); 

//HEADER HORIZONTAL LINE
     // 50mm from each edge
$pdf->Ln(10); 

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(20);
        $pdf->Cell(20,4,"SCHOOL YEAR ",0,0,'L');
        $LatestSchoolYearPlus1 = intval($LatestSchoolYear) + 1;
        $pdf->Cell(45,4,$LatestSchoolYear.'-'.$LatestSchoolYearPlus1,0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(21,4,"ENROLLEE ID:",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(209, 15, 15);
        $pdf->Cell(17,4,$ReferenceNumberDisplay,0,0,'L');
        $pdf->SetTextColor(0,0,0);


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(5);
        $pdf->Cell(20,4,"",0,0,'L');
        $pdf->Cell(65,4,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(8,4,"Date:",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,$DateTodayDisplay,0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(20,4,"Student ID:",0,0,'L');
        $pdf->Cell(43,4,$StudentIDDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"",0,0,'L');



        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(15,4,"NAME:",0,0,'L');
        $pdf->Cell(80,4,$FullNameDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(25,5,"Level/ Grade/ Yr.",0,0,'L');
        $strsize = $pdf->GetStringWidth($GradeLevel);
        $pdf->Cell($strsize,5,$GradeLevel,0,0,'L');
        $pdf->Cell(43,5,'-- '.$SectionName,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');



        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(7); 
        $pdf->Cell(10);
        $pdf->Cell(25,5,"A. Breakdown of Discount & Deduction ",0,0,'L');
        $pdf->Cell(43,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');





        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Sibling Discount",0,0,'L');
        $pdf->Cell(35,5,$SiblingDiscountCodeDisplay ,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$SiblingDiscountAmount = 10;

        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $SiblingDiscountDisplay = number_format((float)$SiblingDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$SiblingDiscountDisplay,0,0,'L');





        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Employee Discount",0,0,'L');
        $pdf->Cell(35,5,$EmployeeDiscountCodeDisplay ,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$SiblingDiscountAmount = 10;

        if(strlen(number_format((float)$EmployeeDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$EmployeeDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$EmployeeDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$EmployeeDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$EmployeeDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$EmployeeDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $EmployeeDiscountDisplay = number_format((float)$EmployeeDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$EmployeeDiscountDisplay,0,0,'L');





        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Board of Trustees Discount",0,0,'L');
        $pdf->Cell(35,5,$BOTDiscountCodeDisplay ,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$SiblingDiscountAmount = 10;

        if(strlen(number_format((float)$BOTDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$BOTDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$BOTDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$BOTDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$BOTDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$BOTDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $BOTDiscountDisplay = number_format((float)$BOTDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$BOTDiscountDisplay,0,0,'L');







        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Academic Discount",0,0,'L');
        $pdf->Cell(35,5,$AcademicDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$AcademicDiscountAmount = 10;

        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $AcademicDiscountDisplay = number_format((float)$AcademicDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$AcademicDiscountDisplay,0,0,'L');



        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Promotional Discount",0,0,'L');
        $pdf->Cell(35,5,$PromotionalDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$PromotionalDiscountAmount = 10000;

        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $PromotionalDiscountDisplay = number_format((float)$PromotionalDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$PromotionalDiscountDisplay,0,0,'L');



        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Entrance Discount",0,0,'L');
        $pdf->Cell(35,5,$EntranceDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$EntranceDiscountAmount = 10000;

        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $EntranceDiscountDisplay = number_format((float)$EntranceDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$EntranceDiscountDisplay,0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Athlete Discount",0,0,'L');
        $pdf->Cell(35,5,$VarsityDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$VarsityDiscountAmount = 1000;

        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $VarsityDiscountDisplay = number_format((float)$VarsityDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$VarsityDiscountDisplay,0,0,'L');




        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"STS Discount",0,0,'L');
        $pdf->Cell(35,5,$STSDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        
        $SpaceAdd = "";

        //$STSDiscountAmount = 10000;

        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $STSDiscountDisplay = number_format((float)$STSDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$STSDiscountDisplay,0,0,'L');




       
        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"ESC-PAFE/QVR Grantees",0,0,'L');
        $pdf->Cell(35,5,$ESCQVRDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        //$pdf->SetFont('Arial','U',7);
       
        $SpaceAdd = "";

        //$ESCQVRDiscountAmount = 1000;

        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $ESCQVRDiscountDisplay = number_format((float)$ESCQVRDiscountAmount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$ESCQVRDiscountDisplay,0,0,'L');




//Distance Learning Discount


       
        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Distance Learning Discount",0,0,'L');
        $pdf->Cell(35,5,'',0,0,'L');
        $pdf->SetFont('Arial','',7);

        //$pdf->SetFont('Arial','U',7);
       
        $SpaceAdd = "";

        //$ESCQVRDiscountAmount = 1000;

        if(strlen(number_format((float)$DistanceLearningDiscount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$DistanceLearningDiscount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$DistanceLearningDiscount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$DistanceLearningDiscount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$DistanceLearningDiscount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$DistanceLearningDiscount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $DistanceLearningDiscountDisplay = number_format((float)$DistanceLearningDiscount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$DistanceLearningDiscountDisplay,0,0,'L');









//End of Distance Learning Discount

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"OtherDiscount",0,0,'L');
        $pdf->Cell(35,5,'',0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";

        //$PromotionalDiscountAmount = 10000;
         $pdf->SetFont('Arial','U',7);


        if(strlen(number_format((float)$RetrieveOtherDiscount , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$RetrieveOtherDiscount , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$RetrieveOtherDiscount , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$RetrieveOtherDiscount , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$RetrieveOtherDiscount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$RetrieveOtherDiscount , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $OtherDiscountDisplay = number_format((float)$RetrieveOtherDiscount , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$OtherDiscountDisplay,0,0,'L');




        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(20,5,"TOTAL",0,0,'L');
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','B',7);



        $SpaceAdd = "";

        //$TotalDiscountDisplay = 10000;

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$TotalDiscountDisplay , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $TotalDiscountDisplay = number_format((float)$TotalDiscountDisplay , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$TotalDiscountDisplay,0,0,'L');


        //$pdf->Cell(17,5,number_format((float)$TotalDiscountDisplay, 2, '.', ','),0,0,'L');





        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(5);
        $pdf->Cell(7,5,"",0,0,'L');
       // $pdf->Cell(27,5,"2018 ",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $pdf->Cell(17,5,"",0,0,'L');


        $GrandTotalDisplay = $TotalBillWithoutDiscount - $TotalDiscountDisplay;

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(20,4,"B. Payment Breakdown",0,0,'L');
        $pdf->Cell(85,4," ",0,0,'L');
        $pdf->SetFont('Arial','BU',7);
        $pdf->Cell(17,4,'',0,0,'L');



 /*
        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(10); 
        $pdf->Cell(10);
        $pdf->Cell(30,5,"Amount Due for S.Y.",0,0,'L');
        $pdf->Cell(43,5,"2020-2021",0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(25,5,"",0,0,'L');
        $pdf->Cell(17,5,number_format((float)$GrandTotalDisplay, 2, '.', ','),0,0,'L');
*/

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Payments Made, Month Of:",0,0,'L');
        $pdf->Cell(43,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');




$AmountPaidIncrements = 0;

//Generate each payment made
try
{
 
    $statement = $dbh->prepare("SELECT *,MONTH(DateOfPayment) AS 'Month',YEAR(DateOfPayment) AS 'Year', DAY(DateOfPayment) AS 'Day' FROM tblpaymenttransactions,tblstudentadmission WHERE PaymentAdmissionID = AdmissionID AND AdmissionID = :AdmissionID ORDER BY DateOfPayment ");
    $statement->execute(array(':AdmissionID' => $SOAAdmissionID     ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
           
                $pdf->SetFont('Arial','',7);
                $pdf->Ln(4); 
                $pdf->Cell(20);
              
                $dateObj   = DateTime::createFromFormat('!m', $data['Month']);
                $monthName = $dateObj->format('F'); 
              //$date = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
                //$strsize = $pdf->GetStringWidth($monthName);
                //$pdf->Cell($strsize,5,$monthName,0,0,'L');
                //$pdf->Cell(13,5,$monthName,0,0,'L');
                //$pdf->Cell(4,5,' '.$data['Day'],0,0,'L');
                //$pdf->Cell(10,5,''.$data['Year'],0,0,'L');
                $pdf->Cell(38,5,$monthName.' '.$data['Day'].' '.$data['Year'],0,0,'L');
                //$pdf->Cell(30,5,''.'',0,0,'L');
                $pdf->Cell(5,5,"   ",0,0,'L');
                $pdf->Cell(10,5,$data['ORNumber'],0,0,'L');
                $pdf->Cell(20,5,"",0,0,'L');
                $pdf->SetFont('Arial','',7);
              
              
                    $SpaceAdd = "";

        //$TotalDiscountDisplay = 10000;

        if(strlen(number_format((float)$data['AmountPaid'] , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$data['AmountPaid'] , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$data['AmountPaid'] , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$data['AmountPaid'] , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$data['AmountPaid'] , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$data['AmountPaid'] , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $MonthlyAmountPaymentDisplay = number_format((float)$data['AmountPaid'] , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$MonthlyAmountPaymentDisplay,0,0,'L');
              
              
               

                $AmountPaidIncrements += $data['AmountPaid'];
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









        $OutstandingBalance = $GrandTotalDisplay-$AmountPaidIncrements;
        //$pdf->Cell(17,5,"(".number_format((float)$AmountPaidIncrements, 2, '.', ',').")",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"TOTAL PAYMENT",0,0,'L');
        $pdf->Cell(38,5,"",0,0,'L');
        $pdf->SetFont('Arial','BU',7);






        $SpaceAdd = "";

        //$TotalDiscountDisplay = 10000;

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 4){
           $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 5){
            $SpaceAdd = "       ";
        
        } 

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 6){
            $SpaceAdd = "     ";
        
        } 
    
        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 7){
            $SpaceAdd = "    ";
        
        }

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 

        if(strlen(number_format((float)$AmountPaidIncrements , 2, '.', ',')) == 9){
            $SpaceAdd = "";
        
        } 

        $AmountPaidIncrements = number_format((float)$AmountPaidIncrements , 2, '.', ',');
     
        $pdf->Cell(17,5,$SpaceAdd.$AmountPaidIncrements,0,0,'L');

        //$pdf->Cell(17,5,number_format((float)$AmountPaidIncrements, 2, '.', ','),0,0,'L');




 $pdf->SetFont('Arial','',8);
        $pdf->Ln(15);
        $pdf->Cell(7);
        $pdf->Cell(50,0,"____________________________",0,2,'C');
        $pdf->Ln(3);
        $pdf->Cell(7);
        $pdf->Cell(50,0,"Maria Teresa B. Pasiona",0,2,'C');
        $pdf->Ln(3);
        $pdf->Cell(7);
        $pdf->Cell(50,0,"Cashier",0,2,'C');
        $pdf->Ln(7);
        $pdf->SetFont('Arial','I',7);
        $pdf->Cell(10);
        $pdf->Cell(119.5,5,'"Train up a child in the way he should go,and when he is old, he will not depart from it." Proverbs.22:6 "',1,2,'C');
        //$pdf->Cell(210,0,"Secretary",0,2,'C');
        //$pdf->Cell(198,0,"HRD Officer",0,2,'R');



        $pdf->Line(139.5, 0, 139.5, 216); // division

   //Line Function Syntax(x axis start, y axis start, x axis end, y axis end)
        $pdf->SetLineWidth(0.5);
//Underline Under Statement of Account Page 1
        $pdf->Line(10, 31, 129.5, 31);
//Underline Under Statement of Account Page 2
        //$pdf->Line(149.5, 31, 268.5, 31);
 

        $pdf->Output('I','sample.pdf');
    
?>