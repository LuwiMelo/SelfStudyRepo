<?php


session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}


include 'DataBaseConnectionFile.php';

$AdmissionID = $_SESSION['FinancialCertificateAdmissionID'];
$RequestorName = $_SESSION['FinancialCertificateRequestor'];

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
    $statement = $dbh->prepare("SELECT * FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYear =  $row['SchoolYear'];
          $LatestSchoolYearID = $row['SchoolYearID'];
    } 
    else {
   
       $LatestSchoolYear = "2020";
       $LatestSchoolYearID = 3;
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




//GET Admission Details
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblstudentadmission WHERE AdmissionID= :AdmissionID");
    $statement->execute(array(':AdmissionID' => $AdmissionID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        //$ReferenceNumber = $row['AdmissionReferenceNum'];
        $StudentID = $row['AdmissionStudentID'];
        $GradeLevelID = $row['AdmissionGradeLevelID'];
        //$ModeOfPaymentID = $row['AdmissionModeOfPaymentID'];
        //$AdmissionSiblingDiscountID = $row['AdmissionSiblingDiscountID'];
        //$AdmissionAcademicScholarshipDiscountID = $row['AdmissionAcademicScholarshipDiscountID'];
        //$AdmissionPromotionalDiscountID = $row['AdmissionPromotionalDiscountID'];
        //$AdmissionEntranceScholarshipDiscountID = $row['AdmissionEntranceScholarshipDiscountID'];
        //$AdmissionVarsityDiscountID = $row['AdmissionVarsityDiscountID'];
        //$AdmissionSTSDiscountID = $row['AdmissionSTSDiscountID'];
        //$ESCDiscount = $row['ESCDiscount'];
        //$QVRDiscount = $row['QVRDiscount'];
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//Check if enrolled already
$CurrentlyEnrolledString = "";
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblpaymenttransactions WHERE PaymentAdmissionID= :PaymentAdmissionID AND PaymentSchoolYearID = $LatestSchoolYearID");
    $statement->execute(array(':PaymentAdmissionID' => $AdmissionID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
       $CurrentlyEnrolledString = " is currently enrolled";
    } 
    else {
   
       $CurrentlyEnrolledString = " is incoming";
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
          
       // $StudentIDDisplay = $row['StudentIDDisplay'];
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

$firstCharacter = "";

if($MiddleName != null){
  $firstCharacter = substr($MiddleName, 0, 1);
  $firstCharacter = $firstCharacter.".";
}

$FullName = $LastName.", ".$FirstName.' '.$firstCharacter;


//GET Tuition Fee Information
try
{
    
    $statement = $dbh->prepare("SELECT tblschoolfees.* FROM tblgradelevel,tblschoolfees WHERE GradeLevelID= :GradeLevelID AND GradeLevelID = SFGradeLevelID AND SFSchoolYearID = :SFSchoolYearID");
    $statement->execute(array(':GradeLevelID' => $GradeLevelID, ':SFSchoolYearID' => $LatestSchoolYearID ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
        $TuitionFee = $row['TuitionFee'];
        $RegistrationFee = $row['RegistrationFee'];
        $MiscFee = $row['MiscFee'];
   
        
    } 
    else {
   
       
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



//GET Purpose Information
$PurposeDisplay = "";
try
{
    
    $statement = $dbh->prepare("SELECT * FROM tblcertpurpose WHERE CertPurposeID = :CertPurposeID");
    $statement->execute(array(':CertPurposeID' => $_SESSION['FinancialCertificatePurpose']));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
       
           $PurposeDisplay = $row['CertPurpose'];
        
    } 
    else {
   
       $PurposeDisplay = $_SESSION['FinancialCertificateOtherPurpose'];
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




$TotalBill = $TuitionFee + $RegistrationFee + $MiscFee;



    require("mysql_table.php");


        //footer - page number
        class PDF extends PDF_MySQL_Table {
         
            function Footer() {
                  
                    $date = date_default_timezone_set('Asia/Manila');
                    $dt = date("F j, Y  g:i A");
                    $this->SetY(-19);
                    //$this->Ln(4);
                    $this->SetFont('Arial','I',10);
                    $this->Cell(10);
                    $this->Cell(40,10,"Generated on {$dt}",0,0,'L');
                    $this->Cell(120);
                    $this->Cell(30,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
            }
            
            
            
             function Header(){
                   
                    $pageWidth = 216;
                    $pageHeight = 279;
                    $margin = 10;
                  
                    $this->SetLineWidth(0.5);
                    //$this->Rect( $margin, $margin , 206 , 269);
                 $this->Rect( $margin, $margin , 196 , 259);
                   // $this->Rect($margin, $margin , 119.5 , 195);
                    
                    //$this->Rect(144.5, 210 , 129 , -205);
                   // $this->Rect(149.5, 205 , 119 , -195);
                   //(kakaliwa pag dinagdagan, bababa pag dinagdagan, mababawasan kanan border pag dinagdagan  ,  width, height  )
             }

            
            
        }
        
     


function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
        'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
    );
    $list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'Hundred');
    $list3 = array('', 'Thousand', 'Million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? '' . $list1[$hundreds] . ' Hundred' . '' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? '' . $list1[$tens] . '' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . '';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}



        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage('P','Letter');
       // $pdf->SetMargins(0,0);
        $pdf->SetLineWidth(0.5);
      
      //  $pdf->Line(139.5, 0, 139.5, 216); // division
       
    //header

    $SchoolLogo = "fpdf/images/iucslogo.jpg";
    $IUCSHeader = "IUCSheader.png";

 


    $pdf->SetFont('Arial','B',12);

//NOTE: +139.5 mula sa kaliwa para makuha ang katapat sa page 2

    //border
    //$pdf->Rect($margin,$margin, $pageWidth - $margin * 2, $pageHeight - $margin * 2);

//School logo page 1
    $pdf->Ln(7);
    $pdf->SetXY(30,11); 
    $pdf->Cell(0,10, $pdf->Image($SchoolLogo, $pdf->GetX(),$pdf->GetY(), 25),0,0,'L',false);

//Iucs header logo page 1
    $pdf->SetXY(60,12);
    $pdf->Cell(0,20, $pdf->Image($IUCSHeader, $pdf->GetX(),$pdf->GetY(),120),0,0,'L',false);

    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(49);
    $pdf->Cell(57,10,'Sol. P. Bella St., Poblacion I-B, City of Imus, Cavite 4103',0,0,'L');



    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',11);
    $pdf->Cell(50);
    $pdf->Cell(0,10,'Tel nos. 471-0525 / 472-2747',0,0,'L');


    $pdf->Ln(30);
    $pdf->SetFont('Arial','BU',14);
    $pdf->Cell(80);
    $pdf->Cell(0,10,'CERTIFICATION',0,0,'L');


    $pdf->SetFont('Arial','',12);
 
    $pdf->Ln(30);
    $pdf->Cell(20);
    $pdf->Cell(43,10,'This is to certify that ',0,0,'L');
    $pdf->SetFont('Arial','BU',12);
    //$FullName = "Matro, Mark Daniel S.";
    //$FullName = "Matro, John Timothy John John  S.";
    $strsize = $pdf->GetStringWidth($FullName);
    $pdf->Cell($strsize,10,$FullName,0,0,'L');
    $pdf->SetFont('Arial','',12);

    $pdf->Cell(15,10,'______',0,0,'L');
    $pdf->Cell(20,10,$CurrentlyEnrolledString.' as a ',0,0,'L');
     
/*
    $SpaceFiller = "";
    //$pdf->Cell(1,10,'                                                ',0,0,'L');
    for($x = 0; $x < $NumberOfCharacters; $x++){
        $SpaceFiller = $SpaceFiller."  ";
    }
    $SpaceFiller = substr($SpaceFiller, 0, -5);
    //$SpaceFiller = $SpaceFiller."    ";
    */
    //
    //$pdf->Cell(10,10,'',0,0,'L');

    $GradeLevelDisplay = "";
    $DepartmentDisplay = "";
   // $GradeLevelID = 2;
    switch ($GradeLevelID) {
        case "1":
            $GradeLevelDisplay = " Pre-Kinder 1";
            $DepartmentDisplay = "ECED";
            break;
        case "2":
            $GradeLevelDisplay = " Pre-Kinder 2";
            $DepartmentDisplay = "ECED";
            break;
        case "3":
            $GradeLevelDisplay = " Kinder 1";
            $DepartmentDisplay = "ECED";
            break;
        case "4":
            $GradeLevelDisplay = " Grade 1";
            $DepartmentDisplay = "Primary";
            break;
        case "5":
            $GradeLevelDisplay = " Grade 2";
            $DepartmentDisplay = "Primary";
            break;
        case "6":
            $GradeLevelDisplay = " Grade 3";
            $DepartmentDisplay = "Primary";
            break;
        case "7":
            $GradeLevelDisplay = " Grade 4";
            $DepartmentDisplay = "Intermediate";
            break;
        case "8":
            $GradeLevelDisplay = " Grade 5";
            $DepartmentDisplay = "Intermediate";
            break;
        case "9":
            $GradeLevelDisplay = " Grade 6";
            $DepartmentDisplay = "Intermediate";
            break;
        case "10":
            $GradeLevelDisplay = " Grade 7";
            $DepartmentDisplay = "Junior High School";
            break;
        case "11":
            $GradeLevelDisplay = " Grade 8";
             $DepartmentDisplay = "Junior High School";
            break;
        case "12":
            $GradeLevelDisplay = " Grade 9";
             $DepartmentDisplay = "Junior High School";
            break;
        case "13":
            $GradeLevelDisplay = " Grade 10";
            $DepartmentDisplay = "Junior High School";
            break;
        case "14":
            $GradeLevelDisplay = " Grade 11";
            $DepartmentDisplay = "Senior High School";
            break;
        case "15":
            $GradeLevelDisplay = " Grade 12";
            $DepartmentDisplay = "Senior High School";
            break;            
    
        default:
            $GradeLevelDisplay = "1";
   }
    //$pdf->Cell(0,10,,0,0,'L');

$Size = 0;

if($GradeLevelID == 1 || $GradeLevelID == 2){
    $Size = 25;
}
else{
    $Size = 18;
}
//$pdf->Cell(40,10,$GradeLevelDisplay,0,0,'L');

$pdf->Ln(5);
$pdf->Cell(20);
//$pdf->Cell(8,10,'as a ',0,0,'L');
//$GradeLevelDisplay = "Pre-Kinder 1";
//$pdf->Cell(100,10,$GradeLevelDisplay.' student this school year '.'2018-2019'.'.',0,0,'L');

$strsize = $pdf->GetStringWidth($GradeLevelDisplay);
$pdf->Cell($strsize,10,$GradeLevelDisplay,0,0,'L');
$pdf->Cell(48,10,' student this school year ',0,0,'L');
$pdf->Cell(12,10,$LatestSchoolYear.'-',0,0,'L');
$pdf->Cell(20,10,$LatestSchoolYear+1,0,0,'L');


//$pdf->Cell(48,10,'student this school year',0,0,'L');
//$pdf->Cell(20,10,'2018-2019.',0,0,'L');

$pdf->Ln(10);

$pdf->Cell(20);
$pdf->Cell(50,10,'This further certifies that the current school fees and other fee requirements for',0,0,'L');

$pdf->Ln(5);

$pdf->Cell(20);

//$TotalBill = 4314;
//$TotalBill = 35000;

$NewTotalBill = $_SESSION['FinancialCertificateTotalAmount'];
$AmountInWords =  convertNumberToWord($NewTotalBill);

 $strsize = $pdf->GetStringWidth($DepartmentDisplay);
$pdf->Cell($strsize,10,$DepartmentDisplay,0,0,'L');

$GradeLevelDisplay2 = ' Department '.$GradeLevelDisplay;

 $strsize = $pdf->GetStringWidth($GradeLevelDisplay2);
$pdf->Cell($strsize,10,$GradeLevelDisplay2,0,0,'L');



//$pdf->Cell(50,10,' Department '.$GradeLevelDisplay,0,0,'L');

$pdf->Cell(45,10,' in particular amounts to: ',0,0,'L');

$pdf->Ln(5);

$pdf->Cell(20);

$pdf->SetFont('Arial','BIU',12);

$pdf->Cell(40,10,$AmountInWords.' pesos (PHP '.number_format((float)$NewTotalBill, 2, '.', ',').') only.',0,0,'L');
//$pdf->SetFont('Arial','',12);
$pdf->Ln(5);

$pdf->Cell(20);
$pdf->SetFont('Arial','',12);
$pdf->Cell(45,10,'Breakdown is listed as follows ',0,0,'L');


$pdf->Ln(5);
$pdf->Ln(10);

$pdf->Cell(60);
$pdf->Cell(30,10,'Registration Fee ',0,0,'L');
$pdf->Cell(10);
$pdf->Cell(50,10,'Php  '.number_format((float)$RegistrationFee, 2, '.', ','),0,0,'L');

$pdf->Ln(5);

$pdf->Cell(60);
$pdf->Cell(30,10,'Tuition Fee ',0,0,'L');
$pdf->Cell(10);
$pdf->Cell(50,10,'       '.number_format((float)$TuitionFee, 2, '.', ','),0,0,'L');


$pdf->Ln(5);

$pdf->Cell(60);
$pdf->Cell(30,10,'Books ',0,0,'L');
$pdf->Cell(10);
$pdf->SetFont('Arial','',12);

        if(strlen(number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'] , 2, '.', ',')) == 4){
            
             $SpaceAdd = "            ";
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'] , 2, '.', ',')) == 5){
            
             $SpaceAdd = "              ";
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'] , 2, '.', ',')) == 6){
             
            $SpaceAdd = "            ";
        } 
    
        if(strlen(number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'] , 2, '.', ',')) == 7){
             
            $SpaceAdd = "          ";
        }

        if(strlen(number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'] , 2, '.', ',')) == 8){
            $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'] , 2, '.', ',')) == 9){
            $SpaceAdd = "       ";
        
        }

$pdf->Cell(50,10,$SpaceAdd.number_format((float)$_SESSION['FinancialCertificateBooksBreakdown'], 2, '.', ','),0,0,'L');
$pdf->SetFont('Arial','',12);

$pdf->Ln(5);

$pdf->Cell(60);
$pdf->Cell(30,10,'Uniforms ',0,0,'L');
$pdf->Cell(10);
$pdf->SetFont('Arial','',12);



        if(strlen(number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'] , 2, '.', ',')) == 4){
            
            $SpaceAdd = "             ";
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'] , 2, '.', ',')) == 5){
            
            $SpaceAdd = "              ";
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'] , 2, '.', ',')) == 6){
             
             $SpaceAdd = "            ";
        } 
    
        if(strlen(number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'] , 2, '.', ',')) == 7){
             
             $SpaceAdd = "          ";
        }

        if(strlen(number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'] , 2, '.', ',')) == 8){
            $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'] , 2, '.', ',')) == 9){
             $SpaceAdd = "       ";
        
        }


$pdf->Cell(50,10,$SpaceAdd.number_format((float)$_SESSION['FinancialCertificateUniformsBreakdown'], 2, '.', ','),0,0,'L');
$pdf->SetFont('Arial','',12);


$pdf->Ln(5);

$pdf->Cell(60);
$pdf->Cell(30,10,'Others ',0,0,'L');
$pdf->Cell(10);
$pdf->SetFont('Arial','U',12);


        if(strlen(number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'] , 2, '.', ',')) == 4){
            
             $SpaceAdd = "            ";
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'] , 2, '.', ',')) == 5){
            
             $SpaceAdd = "              ";
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'] , 2, '.', ',')) == 6){
             
            $SpaceAdd = "            ";
        } 
    
        if(strlen(number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'] , 2, '.', ',')) == 7){
             
            $SpaceAdd = "          ";
        }

        if(strlen(number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'] , 2, '.', ',')) == 8){
            $SpaceAdd = "         ";
        
        } 

        if(strlen(number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'] , 2, '.', ',')) == 9){
            $SpaceAdd = "       ";
        
        }
$pdf->Cell(50,10,$SpaceAdd.number_format((float)$_SESSION['FinancialCertificateOthersBreakdown'], 2, '.', ','),0,0,'L');
$pdf->SetFont('Arial','',12);




$pdf->Ln(5);

$pdf->Cell(60);




$pdf->Cell(30,10,'Total:',0,0,'L');
$pdf->Cell(10);
$pdf->Cell(50,10,'Php '.number_format((float)$NewTotalBill, 2, '.', ','),0,0,'L');


$pdf->Ln(10);
$pdf->Cell(20);

$pdf->SetFont('Arial','',12);
$date = date_default_timezone_set('Asia/Manila');
$dateToday = date("d");

if($dateToday == 1 || $dateToday == 21 || $dateToday == 31){
    $dateToday = $dateToday."st";
}

if($dateToday == 2 || $dateToday == 22 ){
    $dateToday = $dateToday."nd";
}

if($dateToday == 3 || $dateToday == 23 ){
    $dateToday = $dateToday."rd";
}


if($dateToday != 1 && $dateToday != 21 && $dateToday != 31 && $dateToday != 2 && $dateToday != 22 && $dateToday != 3 && $dateToday != 23 ){
    $dateToday = $dateToday."th";
}



$monthToday = date("F");
$yearToday = date("Y");

$pdf->Cell(80,10,'This certification is issued on '.$dateToday.' day of '.$monthToday.','.$yearToday.' upon the request of ',0,0,'L');

$pdf->Ln(5);
$pdf->Cell(20);


$pdf->SetFont('Arial','BU',12);
$strsize = $pdf->GetStringWidth($RequestorName);
$pdf->Cell($strsize,10,$RequestorName,0,0,'L');

$pdf->SetFont('Arial','',12);
$pdf->Cell(10,10,'  for ',0,0,'L');


    
$strsize = $pdf->GetStringWidth($PurposeDisplay);
$pdf->Cell($strsize,10,$PurposeDisplay,0,0,'L');

$pdf->Ln(20);
$pdf->Cell(20);

$pdf->Cell(40,10,'_____________________________',0,0,'L');
$pdf->Ln(5);
$pdf->Cell(23);
$pdf->Cell(40,10,'Mrs. Sharon M. Lasquete, MAEd',0,0,'L');

$pdf->Ln(5);
$pdf->Cell(38);
$pdf->Cell(40,10,'School Principal',0,0,'L');


//Mrs. Sharon M. Lasquete, MAEd School Principal

/*

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
        $pdf->Cell(40,5,"Miscellaneous Fee",0,0,'L');
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
        
        $pdf->Cell(15,5,number_format((float)$OutstandingBalance, 2, '.', ','),0,0,'L');
       
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
        $pdf->Ln(7); 
        $pdf->Cell(10);
        $pdf->Cell(25,5,"A. Breakdown of Discount & Deduction ",0,0,'L');
        $pdf->Cell(43,5,"",0,0,'L');
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(17,5,"",0,0,'L');





        $pdf->SetFont('Arial','',7);
        $pdf->Ln(4); 
        $pdf->Cell(15);
        $pdf->Cell(45,5,"Sibling/BOT/Employee's Discount",0,0,'L');
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

        $pdf->SetFont('Arial','U',7);
       
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
 
    $statement = $dbh->prepare("SELECT *,MONTH(DateOfPayment) AS 'Month' FROM tblpaymenttransactions,tblstudentadmission WHERE PaymentAdmissionID = AdmissionID AND AdmissionID = :AdmissionID ORDER BY DateOfPayment ");
    $statement->execute(array(':AdmissionID' => $SOAAdmissionID     ));
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
           
                $pdf->SetFont('Arial','',7);
                $pdf->Ln(4); 
                $pdf->Cell(20);
              
                $dateObj   = DateTime::createFromFormat('!m', $data['Month']);
                $monthName = $dateObj->format('F'); 
                $pdf->Cell(13,5,$monthName,0,0,'L');
                $pdf->Cell(15,5,$LatestSchoolYear-1,0,0,'L');
                $pdf->Cell(5,5,"OR#",0,0,'L');
                $pdf->Cell(10,5,$data['ORNumber'],0,0,'L');
                $pdf->Cell(30,5,"",0,0,'L');
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



       // $pdf->Line(139.5, 0, 139.5, 216); // division
*/
  // Line Function Syntax(x axis start, y axis start, x axis end, y axis end)
        $pdf->SetLineWidth(0.5);
//Underline Under Statement of Account Page 1
        //$pdf->Line(10, 31, 129.5, 31);
//Underline Under Statement of Account Page 2
        //$pdf->Line(149.5, 31, 268.5, 31);
 

        $pdf->Output('I','sample.pdf');
    
?>