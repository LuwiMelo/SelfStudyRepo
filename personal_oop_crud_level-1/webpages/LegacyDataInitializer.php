<?php 

session_start();


include 'DataBaseConnectionFile.php';


  
 $RetrieveGoToSYID = $_POST['LegacyDataSYID'];


$_SESSION['SessionSelectedSchoolYearID'] = $RetrieveGoToSYID;




//GET Tuition Fee Information
try
{
    
    
    $statement = $dbh->prepare("SELECT * FROM tblschoolyear WHERE SchoolYearID = $RetrieveGoToSYID ");
    
    $statement->execute();
    
    
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
        $SchoolYearDisplay = $row['SchoolYear'];
        
        $_SESSION['SessionSelectedSchoolYear'] =  $row['SchoolYear'];
  
    }
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}
   

    
    

    header('Location: SwitchSchoolYearNotification.php');
   


?>