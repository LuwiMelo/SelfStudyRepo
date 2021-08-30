<?php 


//Code For User Authentication For Each Web Page
include 'DataBaseConnectionFileNoLogInRequired.php';
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


$ctr = 0;



 
$SelectIndicator = 1;
    
    
try
{
 
    $statement = $dbh->prepare("SELECT AdmissionUpdate FROM tblstudentadmission WHERE AdmissionID = :AdmissionID");
    $statement->execute(array(':AdmissionID' => $_SESSION['EditStudentAdmissionNumber']));
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
          $SelectIndicator = $row['AdmissionUpdate'];
              
              
             // if($ctr = 0){ $selected = 0;} else { $selected = '';}
           //echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
           // $ctr++;
        
    } 
    else {
   
       //echo '<option value="">Discounts not available</option>';
        echo 'No student id displayed';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

    $SelectedVariable = "";
    
    
    if($SelectIndicator == 1){
        $SelectedVariable = "selected";
    }
    else{
        $SelectedVariable = "";
    }
    
    echo '<option value="1" '.$SelectedVariable.'>Admitted</option>';
    
    
    
    if($SelectIndicator == 2){
        $SelectedVariable = "selected";
    }
    else{
        $SelectedVariable = "";
    }
    
    echo '<option value="2" '.$SelectedVariable.'>Dropped</option>';
    
    
    if($SelectIndicator == 3){
        $SelectedVariable = "selected";
    }
    else{
        $SelectedVariable = "";
    }
    
    echo '<option value="3" '.$SelectedVariable.'>Transfer</option>';
    



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