<?php

include_once '../config/connection.php';
include_once '../objects/tbldepartment.php';

$db = new Database();
$dbh = $db->getConnection();
$Department = new Department($dbh);

$Retrieve = json_decode($_POST["RetrieveTransaction"]);


if($Retrieve->SQLAction == "ADD"){ // Add/Insert to Database Operation

    $InsertToDBIndicator = true;

    if($Retrieve->AddDepartmentName == "" || $Retrieve->AddDepartmentName == null){
         $data['AddDepartmentNameError'] = "Please enter a department name"; 
         $InsertToDBIndicator = false;         
    }


    $Department->DepartmentName = $Retrieve->AddDepartmentName;
    

   if($InsertToDBIndicator){

    
        if($Department->InsertNewDepartment()){
            $data['AddDepartmentValidationResult'] = "FieldNoErrors";
        }
        else{
          
            header("HTTP/1.0 403 Forbidden");
        }


   }

   else{

       $data['AddDepartmentValidationResult'] = "WithFieldErrors";
   }



    echo json_encode($data);
    

}// End of Add/Insert to Database Operation







else{
    header("HTTP/1.0 403 Forbidden");
}





?>