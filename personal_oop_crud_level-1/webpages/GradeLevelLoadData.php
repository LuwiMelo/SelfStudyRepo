<?php 


//Code For User Authentication For Each Web Page
session_start();

include 'DataBaseConnectionFile.php';

$SessionSelectedSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}

$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

*/

//Count the Total Number of Nationality
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("SELECT COUNT(GradeLevelID) AS 'Total' FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row) && $row['Total'] != 0) {
          
          $TotalRecords =  $row['Total'];
          
    } 
    else {
   
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//Initialize the String/Output
$OutputPrefix = '{ "sEcho": 1 , "iTotalRecords": '.$TotalRecords.', "iTotalDisplayRecords": '.$TotalRecords.', "aaData": [  '; 


$OutputData = "";

try
{
    //$index = 0;
    $data = array();
    //$statement = $dbh->prepare("SELECT (@row_number:=@row_number + 1) AS Num, NationalityID,NationalityName FROM tblnationality,(SELECT @row_number:=0) AS t ORDER BY NationalityName ASC");
    $statement = $dbh->prepare("SELECT GradeLevelID,GradeLevel,SFTable.CashBasis,SFTable.SchoolFeesID, SFTable.TuitionFee, SFTable.RegistrationFee, SFTable.MiscFee, SFTable.OptionAAddOn, SFTable.OptionBAddOn, SFTable.OptionCAddOn, SFTable.OptionDAddOn, SFTable.DistanceLearningDiscount   FROM tblgradelevel LEFT JOIN (SELECT (`TuitionFee`+`RegistrationFee`+`MiscFee`) AS CashBasis,SFGradeLevelID,SchoolFeesID, TuitionFee, RegistrationFee, MiscFee, OptionAAddOn, OptionBAddOn, OptionCAddOn, OptionDAddOn, DistanceLearningDiscount  FROM tblschoolfees WHERE SFSchoolYearID = $SessionSelectedSchoolYearID ) AS SFTable ON tblgradelevel.GradeLevelID = SFTable.SFGradeLevelID");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
            foreach($row as $dataa){
                
               //$TuitionFee = $dataa['TuitionFee'];
               //$RegistrationFee = $dataa['RegistrationFee'];
               //$MiscFee = $dataa['MiscFee'];
                
               $TotalCashBasis = $dataa['CashBasis'];
                
               $TotalCashBasisDisplay = number_format($TotalCashBasis, 2, '.', ',');
                
               $OutputData .= '["'.$dataa['GradeLevelID'].'","'.$dataa['GradeLevel'].'", "'.$TotalCashBasisDisplay.'","<button class=\"btn btn-success btnEditNationality\" data-sfid=\"'.$dataa['SchoolFeesID'].'\"  data-id=\"'.$dataa['GradeLevelID'].'\" data-name=\"'.$dataa['GradeLevel'].'\" data-tuition=\"'.$dataa['TuitionFee'].'\" data-registration=\"'.$dataa['RegistrationFee'].'\" data-misc=\"'.$dataa['MiscFee'].'\" data-optiona=\"'.$dataa['OptionAAddOn'].'\"  data-optionb=\"'.$dataa['OptionBAddOn'].'\" data-optionc=\"'.$dataa['OptionCAddOn'].'\" data-optiond=\"'.$dataa['OptionDAddOn'].'\" data-distance=\"'.$dataa['DistanceLearningDiscount'].'\" >Update Fees</button>","<button disabled class=\"btn btn-danger btnDeleteNationality\" data-id=\"'.$dataa['GradeLevelID'].'\" data-name=\"'.$dataa['GradeLevel'].'\"    >Delete</button>"],';
                //echo $OutputData;
            }
          
    } 
    else {
        
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



$OutputData = rtrim($OutputData,',');

$OutputEcho = $OutputPrefix.$OutputData;
$OutputEcho .= ']}';

    
echo $OutputEcho;



?>