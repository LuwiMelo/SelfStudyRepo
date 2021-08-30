<?php


session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}

$SOAAdmissionID = $_SESSION['GenerateSOAAdmissionID'];


$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
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
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
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



//GET Tuition Fee Information
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel WHERE GradeLevelID= :GradeLevelID");
    $statement->execute(array(':GradeLevelID' => $GradeLevelID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        $TuitionFee = $row['TuitionFee'];
        $RegistrationFee = $row['RegistrationFee'];
        $MiscFee = $row['MiscFee'];
        $TuitionFee = $row['TuitionFee'];
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
$DateTodayDisplay =date("F d, yy");
$FullNameDisplay = strtoupper($LastName.', '.$FirstName.' '.$MiddleName);





$SiblingDiscountAmount = 0;
$AcademicDiscountAmount = 0;
$PromotionalDiscountAmount = 0;
$EntranceDiscountAmount = 0;
$VarsityDiscountAmount = 0;
$STSDiscountAmount = 0;
$ESCQVRDiscountAmount = 0;

$SiblingDiscountCodeDisplay = "";
$AcademicDiscountCodeDisplay = "";
$PromotionalDiscountCodeDisplay = "";
$EntranceDiscountCodeDisplay = "";
$VarsityDiscountCodeDisplay = "";
$STSDiscountCodeDisplay = "";
$ESCQVRDiscountCodeDisplay = "";


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
                $VarsityDiscountAmount = $row['FixedAmount'];
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




if($DiscountToTuition > $TuitionFee){
    $DiscountToTuition = $TuitionFee;
   
}


$TotalDiscountDisplay = $TotalDiscount + $DiscountToTuition;










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
        $pdf->Cell(21,4,"REFERENCE NO:",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(209, 15, 15);
        $pdf->Cell(17,4,$ReferenceNumber,0,0,'L');
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
        $pdf->Cell(43,5,"G12 Truth",0,0,'L');
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
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,number_format((float)$TuitionFee, 2, '.', ','),0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Registration Fee",0,0,'L');
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";
        if(strlen(number_format((float)$RegistrationFee, 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        } 
        $pdf->Cell(17,5,$SpaceAdd.number_format((float)$RegistrationFee, 2, '.', ','),0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Miscellaneous Fee",0,0,'L');
        $pdf->Cell(60,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $SpaceAdd = "";
        if(strlen(number_format((float)$MiscFee, 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        } 
        $pdf->Cell(17,5,$SpaceAdd.number_format((float)$MiscFee, 2, '.', ','),0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Addtl. Payment if not cash basis",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $pdf->Cell(50,5,"",0,0,'L');
        $pdf->Cell(10,5,"                ",0,0,'L');
        
        $SpaceAdd = "";
        if(strlen(number_format((float)$AddOnPayment , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $AddOnPaymentDisplay = number_format((float)$AddOnPayment, 2, '.', ',');

        if($AddOnPayment == "0.00"){
                $SpaceAdd = "             ";
                $AddOnPaymentDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$AddOnPaymentDisplay,0,0,'L');




        

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"TOTAL",0,0,'L');
        $pdf->Cell(65,5,"",0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(17,5,number_format((float)$TotalBillWithoutDiscount, 2, '.', ','),0,0,'L');

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"LESS: OTHERS/DISCOUNT/s",0,0,'L');
        $pdf->Cell(35,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Sibling Discount",0,0,'L');
        $pdf->Cell(35,5,$SiblingDiscountCodeDisplay ,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";
        if(strlen(number_format((float)$SiblingDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $SiblingDiscountDisplay = number_format((float)$SiblingDiscountAmount , 2, '.', ',');

        if($SiblingDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $SiblingDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$SiblingDiscountDisplay,0,0,'L');





        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Academic Discount",0,0,'L');
        $pdf->Cell(35,5,$AcademicDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";
        if(strlen(number_format((float)$AcademicDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $AcademicDiscountDisplay = number_format((float)$AcademicDiscountAmount , 2, '.', ',');

        if($AcademicDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $AcademicDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$AcademicDiscountDisplay,0,0,'L');



        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Promotional Discount",0,0,'L');
        $pdf->Cell(35,5,$PromotionalDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

        $SpaceAdd = "";
        if(strlen(number_format((float)$PromotionalDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $PromotionalDiscountDisplay = number_format((float)$PromotionalDiscountAmount , 2, '.', ',');

        if($PromotionalDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $PromotionalDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$PromotionalDiscountDisplay,0,0,'L');



        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Entrance Discount",0,0,'L');
        $pdf->Cell(35,5,$EntranceDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $SpaceAdd = "";
        if(strlen(number_format((float)$EntranceDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $EntranceDiscountDisplay = number_format((float)$EntranceDiscountAmount , 2, '.', ',');

        if($EntranceDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $EntranceDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$EntranceDiscountDisplay,0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"Athlete Discount",0,0,'L');
        $pdf->Cell(35,5,$VarsityDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $SpaceAdd = "";
        if(strlen(number_format((float)$VarsityDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $VarsityDiscountDisplay = number_format((float)$VarsityDiscountAmount , 2, '.', ',');

        if($VarsityDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $VarsityDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$VarsityDiscountDisplay,0,0,'L');




        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"STS Discount",0,0,'L');
        $pdf->Cell(35,5,$STSDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);
        $SpaceAdd = "";
        if(strlen(number_format((float)$STSDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $STSDiscountDisplay = number_format((float)$STSDiscountAmount , 2, '.', ',');

        if($STSDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $STSDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$STSDiscountDisplay,0,0,'L');
   




       
        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(40,5,"ESC-PAFE/QVR Grantees",0,0,'L');
        $pdf->Cell(35,5,$ESCQVRDiscountCodeDisplay,0,0,'L');
        $pdf->SetFont('Arial','',7);

//iF LAST DISCOUNT ROW
        $pdf->SetFont('Arial','U',7);
        $SpaceAdd = "";
        if(strlen(number_format((float)$ESCQVRDiscountAmount , 2, '.', ',')) == 8){
            $SpaceAdd = "  ";
        
        } 
    
        $ESCQVRDiscountDisplay = number_format((float)$ESCQVRDiscountAmount , 2, '.', ',');

        if($ESCQVRDiscountAmount  == "0.00"){
                $SpaceAdd = "             ";
                $ESCQVRDiscountDisplay = "-";
                
        }
      

        $pdf->Cell(17,5,$SpaceAdd.$ESCQVRDiscountDisplay,0,0,'L');


        $pdf->Cell(7,5,"                     ");
        $pdf->Cell(17,5,"(".number_format((float)$TotalDiscountDisplay, 2, '.', ',').")",0,0,'L');




        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(20,5,"Add: Receivable",0,0,'L');
        $pdf->Cell(85,5,"",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $pdf->Cell(17,5,"",0,0,'L');





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
        $pdf->Cell(20,4,"GRAND TOTAL",0,0,'L');
        $pdf->Cell(85,4," ",0,0,'L');
        $pdf->SetFont('Arial','BU',7);
        $pdf->Cell(17,4,number_format((float)$GrandTotalDisplay, 2, '.', ','),0,0,'L');



        $pdf->Ln(5); 
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
        
        $pdf->Cell(15,5,number_format((float)$GrandTotalDisplay, 2, '.', ','),0,0,'L');
       
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
        $pdf->Cell(27,5,"September 15,2019",0,0,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','',8);
//Due Date
        $pdf->Cell(74,5," at main building if Elem & extension ",0,0,'L');
        $pdf->Ln(4);    
        $pdf->Cell(10);
        $pdf->Cell(134,5,"building if HS, just present this SOA to the cashier. Incase of discrepancy against your ",0,0,'L');
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(134,5,"personal record or any other queries,present your receipt and proceed to Annex building for ",0,0,'L');
        $pdf->Ln(4);
        $pdf->Cell(10);
        $pdf->Cell(134,5,"reconciliation at Head Cashier. Please disregard notice if payment has been made.Thank you.",0,0,'L');
        $pdf->Ln(4);
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
        $pdf->Line(149.5, 31, 268.5, 31);




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
        $pdf->Cell(20,4,"SCHOOL YEAR",0,0,'L');
        $pdf->Cell(45,4,"2019-2020",0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(21,4,"REFERENCE NO:",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $pdf->SetTextColor(209, 15, 15);
        $pdf->Cell(17,4,"2020-00001",0,0,'L');
        $pdf->SetTextColor(0,0,0);


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(5);
        $pdf->Cell(20,4,"",0,0,'L');
        $pdf->Cell(70,4,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(10,4,"Date:",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"August 5,2020",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(20,4,"Student ID:",0,0,'L');
        $pdf->Cell(43,4,"2014-3143",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"",0,0,'L');



        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(15,4,"NAME:",0,0,'L');
        $pdf->Cell(43,4,"DE LEON, AZECKAH LOIS PANGILINAN",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,4,"",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(25,5,"Level/ Grade/ Yr.",0,0,'L');
        $pdf->Cell(43,5,"G12 Truth",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');
        

        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(10); 
        $pdf->Cell(10);
        $pdf->Cell(30,5,"Amount Due for S.Y.",0,0,'L');
        $pdf->Cell(43,5,"2020-2021",0,0,'L');
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(25,5,"",0,0,'L');
        $pdf->Cell(17,5,"123,000.00",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"Payments Made, Month Of:",0,0,'L');
        $pdf->Cell(43,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"November",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"December",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"January",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"February",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"March",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"April",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"May",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"June",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"July",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"August",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');


        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"September",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"October",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"November",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"December",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"January",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"February",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"March",0,0,'L');
        $pdf->Cell(15,5,"2019",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"10,000.00",0,0,'L');

        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(13,5,"Others",0,0,'L');
        $pdf->Cell(15,5,"",0,0,'L');
        $pdf->Cell(5,5,"OR#",0,0,'L');
        $pdf->Cell(10,5,"456754",0,0,'L');
        $pdf->SetFont('Arial','U',7);
        $pdf->Cell(20,5,"",0,0,'L');
        $pdf->Cell(12,5,"100,000.00",0,0,'L');
        $pdf->Cell(16,5,"                       ",0,0,'L');
        $pdf->Cell(17,5,"(100,000.00)",0,0,'L');


        $pdf->SetFont('Arial','B',7);
        $pdf->Ln(4); 
        $pdf->Cell(10);
        $pdf->Cell(40,5,"OUTSTANDING BALANCE",0,0,'L');
        $pdf->Cell(57,5,"",0,0,'L');
        $pdf->SetFont('Arial','BU',7);
        $pdf->Cell(17,5,"100,000.00",0,0,'L');


        $pdf->Ln(5); 
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


 $pdf->SetFont('Arial','',8);
        $pdf->Ln(10);
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