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

 $SelectedSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    
//UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("INSERT INTO tblgradelevel(GradeLevelID,GradeLevel) VALUES(:GradeLevelID,:GradeLevel)");
    if ($statement->execute(array(':GradeLevelID' => $Retrieve->GradeLevelID,':GradeLevel' => $Retrieve->GradeLevel ))    ){
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
   
    
    
$LastGradeLevelID = $dbh->lastInsertId();
    
    
/*
if ($Retrieve->TuitionFeeAdd  == 0){
    unset($Retrieve->TuitionFeeAdd);
        
}
if ($Retrieve->RegistrationFeeAdd == 0){
    unset($Retrieve->RegistrationFeeAdd);
        
}
if ($Retrieve->MiscFeeAdd == 0){
    unset($Retrieve->MiscFeeAdd);
        
}
if ($Retrieve->OptionAAdd == 0){
    unset($Retrieve->OptionAAdd);
        
}
if ($Retrieve->OptionBAdd == 0){
    unset($Retrieve->OptionBAdd);
        
}
if ($Retrieve->OptionCAdd == 0){
    unset($Retrieve->OptionCAdd);
        
}
if ($Retrieve->OptionDAdd == 0){
    unset($Retrieve->OptionDAdd);
        
}
if ($Retrieve->DistanceLearningDiscount == 0){
    unset($Retrieve->DistanceLearningDiscount);
        
}

*/
    
    
    
//UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    
    
    $statement = $dbh->prepare("INSERT INTO tblschoolfees(SFSchoolYearID,SFGradeLevelID,TuitionFee,RegistrationFee,MiscFee,OptionAAddOn,OptionBAddOn,OptionCAddOn,OptionDAddOn,DistanceLearningDiscount) VALUES(:SFSchoolYearID,:SFGradeLevelID,:TuitionFee,:RegistrationFee,:MiscFee,:OptionAAddOn,:OptionBAddOn,:OptionCAddOn,:OptionDAddOn,:DistanceLearningDiscount)");
    if ($statement->execute(array(':SFSchoolYearID' => $SelectedSchoolYearID, ':SFGradeLevelID' => $Retrieve->GradeLevelID, ':TuitionFee' => $Retrieve->TuitionFeeAdd, ':RegistrationFee' => $Retrieve->RegistrationFeeAdd, ':MiscFee' => $Retrieve->MiscFeeAdd, ':OptionAAddOn' => $Retrieve->OptionAAdd, ':OptionBAddOn' => $Retrieve->OptionBAdd, ':OptionCAddOn' => $Retrieve->OptionCAdd, ':OptionDAddOn' => $Retrieve->OptionDAdd, ':DistanceLearningDiscount' => $Retrieve->DistanceLearningDiscount ))    ){
    
       
        //$statement = $dbh->prepare("INSERT INTO tblschoolfees(SFSchoolYearID,SFGradeLevelID) VALUES(:SFSchoolYearID,:SFGradeLevelID)");
   // if ($statement->execute(array(':SFSchoolYearID' => $SelectedSchoolYearID,':SFGradeLevelID' => $LastGradeLevelID  ))    ){
        
        
        
        // success
    }
    else
{
        echo $LastGradeLevelID.' this is the lastgradelevelid';
        
   //header("HTTP/1.0 403 Forbidden");
}
    
    
    
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
    $QuerySuccessIndicator = false;
     header("HTTP/1.0 403 Forbidden");
} 
   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
    
    
echo $Retrieve->NationalityName;
echo '<br>';
echo $Retrieve->NationalityID;



?>