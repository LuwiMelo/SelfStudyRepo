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
    
    $statement = $dbh->prepare("SELECT SectionGradeLevel FROM tblsection WHERE SectionID = :SectionID");
    $statement->execute(array(':SectionID' => $Retrieve->SectionID));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
         $SelectedGradeLevel = $row['SectionGradeLevel'];
       
        
          
    } 
    else {
    
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
    

  

echo '<option value="0">Grade Level not set</option>';
try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($SelectedGradeLevel == $data['GradeLevelID']){
                $selected1 = "selected";
                
            }
            else{
                $selected1 = "";
            }
            
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected1 .'>' . $data['GradeLevel'] . '</option>';
        
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