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

//Count the Total Number of Religion
try
{
    //$LatestSchoolYear;
    $statement = $dbh->prepare("SELECT COUNT(PaymentOptionID) AS 'Total' FROM tblpaymentoption");
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
    $statement = $dbh->prepare("SELECT * FROM tblpaymentoption");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
            foreach($row as $dataa){
                
               $OutputData .= '["'.$dataa['PaymentOptionID'].'","'.$dataa['PaymentOptionName'].'","<button class=\"btn btn-success btnEditReligion\" data-id=\"'.$dataa['PaymentOptionID'].'\" data-name=\"'.$dataa['PaymentOptionName'].'\"  >Edit</button>","<button disabled class=\"btn btn-danger btnDeleteReligion\" data-id=\"'.$dataa['PaymentOptionID'].'\" data-name=\"'.$dataa['PaymentOptionName'].'\"    >Delete</button>"],';
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