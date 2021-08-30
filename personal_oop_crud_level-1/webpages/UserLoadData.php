<?php 


//Code For User Authentication For Each Web Page
session_start();

include 'DataBaseConnectionFile.php';

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}

$dsn = 'mysql:host=localhost;dbname=iucs_ecra_db;';
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
    $statement = $dbh->prepare("SELECT COUNT(UserID) AS 'Total' FROM tblusers");
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
    $statement = $dbh->prepare("SELECT tblusers.*,tblposition.PositionName,tbldepartment.DepartmentName FROM tblposition,tblusers LEFT JOIN tbldepartment ON tbldepartment.DepartmentID = tblusers.AssignedDepartment WHERE UserPositionLevel <> 1 AND UserPositionLevel = PositionID");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
            foreach($row as $dataa){
                
               $MaskedPassword = str_repeat("*", strlen($dataa['Password'])); 
               
               $OutputData .= '["'.$dataa['UserID'].'","'.$dataa['Username'].'","'.$MaskedPassword.'","'.$dataa['LastName'].'","'.$dataa['FirstName'].'","'.$dataa['MiddleName'].'","'.$dataa['PositionName'].'","'.$dataa['DepartmentName'].'","<button class=\"btn btn-success btnEditUser\" data-id=\"'.$dataa['UserID'].'\" data-firstname=\"'.$dataa['FirstName'].'\" data-middlename=\"'.$dataa['MiddleName'].'\"  data-lastname=\"'.$dataa['LastName'].'\" data-name=\"'.$dataa['Username'].'\"  data-password=\"'.$dataa['Password'].'\"  >Edit</button>","<button disabled class=\"btn btn-danger btnDeleteUser\" data-id=\"'.$dataa['UserID'].'\" data-name=\"'.$dataa['Username'].'\"    >Delete</button>"],';
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