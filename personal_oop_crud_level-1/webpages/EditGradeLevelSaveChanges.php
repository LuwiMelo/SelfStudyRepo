<?php 


//Code For User Authentication For Each Web Page
session_start();

include 'DataBaseConnectionFile.php';

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

if (isset($_POST["RetrieveTransaction"]))
{

    
 $Retrieve = json_decode($_POST["RetrieveTransaction"]);


//UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblgradelevel SET GradeLevel = :GradeLevel WHERE GradeLevelID = :GradeLevelID");
   
    
    if ($statement->execute(array(':GradeLevel' => $Retrieve->GradeLevel, ':GradeLevelID' => $Retrieve->GradeLevelID ))    ){
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
    
  
    
    
//UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblschoolfees SET TuitionFee = :TuitionFee, RegistrationFee = :RegistrationFee, MiscFee = :MiscFee, OptionAAddOn = :OptionAAddOn, OptionBAddOn = :OptionBAddOn, OptionCAddOn = :OptionCAddOn, OptionDAddOn = :OptionDAddOn, DistanceLearningDiscount = :DistanceLearningDiscount WHERE SchoolFeesID = :SchoolFeesID");
   
    
    if ($statement->execute(array( ':TuitionFee' => $Retrieve->TuitionFeeEdit, ':RegistrationFee' => $Retrieve->RegistrationFeeEdit, ':MiscFee' => $Retrieve->MiscFeeEdit, ':OptionAAddOn' => $Retrieve->OptionAEdit, ':OptionBAddOn' => $Retrieve->OptionBEdit, ':OptionCAddOn' => $Retrieve->OptionCEdit, ':OptionDAddOn' => $Retrieve->OptionDEdit, ':DistanceLearningDiscount' => $Retrieve->DistanceLearningDiscountEdit, ':SchoolFeesID' => $Retrieve->SFID, ))    ){
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
    
    
    
    
    
    
    
    

    
}// if retrieve transaction
    
    
echo $Retrieve->NationalityName;
echo '<br>';
echo $Retrieve->NationalityID;



?>