<?php 


//Code For User Authentication For Each Web Page
/*
session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
*/

session_start();
include 'DataBaseConnectionFile.php';

/*
$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/


$ctr = 0;


if(!empty($_POST["country_id"])){
 
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tbldepartment");
    $statement->execute();
    $row = $statement->fetchAll();
    
    if (!empty($row)) {
        
          foreach($row as $data){
              
              
           echo '<option value ="' . $data['DepartmentID'] . '" '. $selected .'>' . $data['DepartmentName'] . '</option>';
           
        }
    } 
    else {
   
       echo '<option value="">Departments not available</option>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    
    
    
    
}


/*

elseif(!empty($_POST["state_id"])){
    
    
    
    //Fetch all city data
    $query = $conn->query("SELECT UOMID,UOMName FROM tblproductxuom,tblunitofmeasurement WHERE ProductXUOMProductID = ".$_POST['state_id']." AND tblproductxuom.ProductXUOMUOMID = UOMID ORDER BY UOMName ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //City option list
    if($rowCount > 0){
        echo '<option value="">--Units Updated--</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['UOMID'].'">'.$row['UOMName'].'</option>';
        }
    }else{
        echo '<option value="">Unit of Measurements not available</option>';
    }
}

*/































?>