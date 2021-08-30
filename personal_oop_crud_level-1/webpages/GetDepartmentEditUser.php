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

//$_SESSION['SelectedSectionGradeLevelEdit'] = "";

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/


$Retrieve = json_decode($_POST["RetrieveTransaction"]);

//
try
{
    
    $statement = $dbh->prepare("SELECT AssignedDepartment,UserPositionLevel FROM tblusers WHERE UserID = :UserID");
    $statement->execute(array(':UserID' => $Retrieve->UserID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
         $SelectedDepartment = $row['AssignedDepartment'];
         $UserPositionLevel = $row['UserPositionLevel'];
        
          
    } 
    else {
    
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    

  



if($UserPositionLevel == 4 || $UserPositionLevel == 7 ){
    
    try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tbldepartment ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($SelectedDepartment == $data['DepartmentID']){
                $selected1 = "selected";
                
            }
            else{
                $selected1 = "";
            }
            
           echo '<option value ="' . $data['DepartmentID'] . '" '. $selected1 .'>' . $data['DepartmentName'] . '</option>';
        
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

    
}
else{
    
    echo '<option value="0">For Teachers and Supervisor Only</option>';
}











     

?>