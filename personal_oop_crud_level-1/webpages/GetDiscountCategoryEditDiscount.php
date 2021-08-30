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
    
    $statement = $dbh->prepare("SELECT DiscountTypeDiscountCategoryID FROM tbldiscounttype WHERE DiscountTypeID = :DiscountTypeID");
    $statement->execute(array(':DiscountTypeID' => $Retrieve->DiscountTypeID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
         $SelectedGradeLevel = $row['DiscountTypeDiscountCategoryID'];
       
        
          
    } 
    else {
    
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    

  


try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tbldiscountcategory");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($SelectedGradeLevel == $data['DiscountCategoryID']){
                $selected1 = "selected";
                
            }
            else{
                $selected1 = "";
            }
            
           echo '<option value ="' . $data['DiscountCategoryID'] . '" '. $selected1 .'>' . $data['DiscountCategoryName'] . '</option>';
        
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