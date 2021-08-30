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
    
    $statement = $dbh->prepare("SELECT UserPositionLevel FROM tblusers WHERE UserID = :UserID");
    $statement->execute(array(':UserID' => $Retrieve->UserID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
         $SelectedUserPosition = $row['UserPositionLevel'];
       
        
          
    } 
    else {
    
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    

  

echo '<option value="0">User Type Not Set</option>';
try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblposition WHERE PositionID <> 1");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($SelectedUserPosition == $data['PositionID']){
                $selected1 = "selected";
                
            }
            else{
                $selected1 = "";
            }
            
           echo '<option value ="' . $data['PositionID'] . '" '. $selected1 .'>' . $data['PositionName'] . '</option>';
        
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











     

?>