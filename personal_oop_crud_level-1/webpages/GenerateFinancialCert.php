<?php
session_start();

if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}


include 'DataBaseConnectionFile.php';
/*
$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/



$DateToday = date('Y-m-d H:i:s');



$Retrieve = json_decode($_POST["RetrieveTransaction"]);


//$_SESSION['GenerateSOAAdmissionID'] = $AdmissionID;

$AdmissionID = $_SESSION['FinancialCertificateAdmissionID'];

$_SESSION['FinancialCertificateRequestor'] = $Retrieve->Requestor;
$_SESSION['FinancialCertificatePurpose'] = $Retrieve->Purpose;
$_SESSION['FinancialCertificateOtherPurpose'] = $Retrieve->OtherPurpose;
$_SESSION['FinancialCertificateTotalAmount'] = $Retrieve->TotalAmount;
$_SESSION['FinancialCertificateBooksBreakdown'] = $Retrieve->BooksBreakdown;
$_SESSION['FinancialCertificateUniformsBreakdown'] = $Retrieve->UniformsBreakdown;
$_SESSION['FinancialCertificateOthersBreakdown'] = $Retrieve->OthersBreakdown;





?>
