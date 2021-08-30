<?php

include_once '../config/connection.php';
include_once '../objects/tbldepartment.php';

$db = new Database();
$dbh = $db->getConnection();
$Department = new Department($dbh);


$num_rows = $Department->CountExistingDepartments();


if($stmt = $Department->ReadAllActiveDepartments()){

    $OutputPrefix = '{ "sEcho": 1 , "iTotalRecords": '.$num_rows.', "iTotalDisplayRecords": '.$num_rows.', "aaData": ['; 
    $OutputData = "";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
        extract($row);

        //$OutputData .= '["'.$dataa['DepartmentID'].'","'.$dataa['DepartmentName'].'","'.$dataa['Details'].'","<button disabled class=\"btn btn-success btnEditUser\" data-id=\"'.$dataa['DepartmentID'].'\" data-firstname=\"'.$dataa['DepartmentName'].'\"    >Edit</button>","<button disabled class=\"btn btn-danger btnDeleteUser\" data-id=\"'.$dataa['DepartmentID'].'\" data-name=\"'.$dataa['DepartmentName'].'\"    >Delete</button>"],';
        $OutputData .=  "[\"{$DepartmentID}\",\"{$DepartmentName}\",\"<button class='btn btn-md btn-success'    id='{$DepartmentID}'>Edit</button>\", \"<button class='btn btn-danger' id='{$DepartmentID}'>Delete</button>\"],";

    }

    $OutputData = rtrim($OutputData,',');

    $OutputEcho = $OutputPrefix.$OutputData;
    $OutputEcho .= ']}';

    
    echo $OutputEcho;


}
else{
    header("HTTP/1.0 403 Forbidden");
}




?>