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
 $QueryColumn = "";
    
    
switch ($Retrieve->DiscountTypeDiscountCategoryID) {
    case 1:
        $QueryColumn = "AdmissionSiblingDiscountID";
        break;
    case 2:
        $QueryColumn = "AdmissionAcademicScholarshipDiscountID";
        break;
    case 3:
        $QueryColumn = "AdmissionPromotionalDiscountID";
        break;
    case 4:
        $QueryColumn = "AdmissionEntranceScholarshipDiscountID";
        break;
    case 5:
        $QueryColumn = "AdmissionVarsityDiscountID";
        break;
    case 6:
        $QueryColumn = "AdmissionSTSDiscountID";
        break;
    default:
        echo "not defined";
}
    
    
    

//UPDATE NATIONALITY OF STUDENTS WITH NATIONALITYID TO BE DELETED
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("UPDATE tblstudentadmission SET $QueryColumn = NULL WHERE $QueryColumn = :AdmissionDiscountIDRemove");
    if ($statement->execute(array(':AdmissionDiscountIDRemove' => $Retrieve->DiscountTypeID))){
        // success
        echo 'Success in updating!';
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
    
    
    
    
    
//DELETE NATIONALITY
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("DELETE FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID");
    if ($statement->execute(array(':DiscountTypeID' => $Retrieve->DiscountTypeID))    ){
        // success
        echo "Success in deleting";
        echo "<br>";
        echo $Retrieve->ReligionID;
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
   
    
    
    
    
    
    
}
    
    



?>