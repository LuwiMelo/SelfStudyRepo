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
    $statement = $dbh->prepare("INSERT INTO tblschoolyear(SchoolYearID,SchoolYear) VALUES(:SchoolYearID,:SchoolYear)");
    if ($statement->execute(array(':SchoolYearID' => $Retrieve->SchoolYearID, ':SchoolYear' => $Retrieve->SchoolYear ))    ){
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


    
    
    
    
//UPDATE STUDENT STATUS
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudent SET StudentStatus = 1 WHERE LEFT(StudentIDDisplay,4) <= (SELECT MAX(SchoolYear) - 15 FROM tblschoolyear)");
    if ($statement->execute()    ){
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
      
  
    
    
    

    
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
           //echo '<option value ="' . $data['MunicipalityID'] . '" '. $selected .'>' . $data['MunicipalityName'] . '</option>';
            
            //UPDATE NATIONALITY DETAILS
try
{
    //$LatestSchoolYear;
    
    
    $statement = $dbh->prepare("INSERT INTO tblschoolfees(SFSchoolYearID,SFGradeLevelID,TuitionFee,RegistrationFee,MiscFee,OptionAAddOn,OptionBAddOn,OptionCAddOn,OptionDAddOn,DistanceLearningDiscount) VALUES(:SFSchoolYearID,:SFGradeLevelID,:TuitionFee,:RegistrationFee,:MiscFee,:OptionAAddOn,:OptionBAddOn,:OptionCAddOn,:OptionDAddOn,:DistanceLearningDiscount)");
    if ($statement->execute(array(':SFSchoolYearID' => $Retrieve->SchoolYearID, ':SFGradeLevelID' => $data['GradeLevelID'], ':TuitionFee' => 0, ':RegistrationFee' => 0, ':MiscFee' => 0, ':OptionAAddOn' => 0, ':OptionBAddOn' => 0, ':OptionCAddOn' => 0, ':OptionDAddOn' => 0, ':DistanceLearningDiscount' => 0 ))    ){
    
       
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
        
    } 
    else {
   
      echo '<option> No data </option>';
    }


    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    
    
    
    
    $_SESSION['LogOutFromAddSY'] = true;
    
    
    
    //header('Location: systemlogout.php');
    
    
    
    
    
    
    
    
    
    
}
    
    



?>