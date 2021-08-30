<?php


//Code For User Authentication For Each Web Page
session_start();

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
*/


include 'DataBaseConnectionFile.php';
include 'adminheader.php';


/*
$dsn = 'mysql:host=localhost;dbname=iucs_ecra_db;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/

//Get the latest school year
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT SchoolYear,SchoolYearID FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYear =  $row['SchoolYear'];
          $LatestSchoolYearID =  $row['SchoolYearID'];
          
    } 
    else {
   
       $LatestSchoolYear = "2019"; //I set school year 2019 as the default because this system is developed year 2019.
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

if(isset($_SESSION['SessionSelectedSchoolYearID'])){
    
    $LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    $LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
}



$GradeLevelQuery = "";

if($_POST['GradeLevelFrom'] == $_POST['GradeLevelTo']){
    
    $GradeLevelQuery = "AND AdmissionGradeLevelID = ".$_POST['GradeLevelFrom']." AND (";
}
else{
    $GradeLevelQuery = "AND AdmissionGradeLevelID BETWEEN ".$_POST['GradeLevelFrom']." AND ".$_POST['GradeLevelTo']." AND (";
}

$SiblingQuery = "";

if($_POST['SiblingFrom'] == 0 || $_POST['SiblingTo'] == 0){
    
    $SiblingQuery = "";
}
else{
    $SiblingQuery = " AdmissionSiblingDiscountID BETWEEN ".$_POST['SiblingFrom']." AND ".$_POST['SiblingTo'];
}


$ASQuery = "";
$PreASQuery = "OR";

if($SiblingQuery == ""){
    $PreASQuery = "";
}

if($_POST['ASFrom'] == 0 || $_POST['ASTo'] == 0){
    
    $ASQuery = "";
}

else{
    $ASQuery = " $PreASQuery AdmissionAcademicScholarshipDiscountID BETWEEN ".$_POST['ASFrom']." AND ".$_POST['ASTo'];
}


$PromotionalQuery = "";
$PrePromotionalQuery = "OR";

if($SiblingQuery == "" && $ASQuery == ""){
    $PrePromotionalQuery = "";
}

if($_POST['PromotionalFrom'] == 0 || $_POST['PromotionalTo'] == 0){
    
    $PromotionalQuery = "";
}

else{
    $PromotionalQuery = " $PrePromotionalQuery AdmissionPromotionalDiscountID BETWEEN ".$_POST['PromotionalFrom']." AND ".$_POST['PromotionalTo'];
}


$ESQuery = "";
$PreESQuery = "OR";
if($SiblingQuery == "" && $ASQuery == "" && $PromotionalQuery == ""){
    $PreESQuery = "";
}

if($_POST['ESFrom'] == 0 || $_POST['ESTo'] == 0){
    
    $ESQuery = "";
}
else{
    
    $ESQuery = " $PreESQuery AdmissionEntranceScholarshipDiscountID BETWEEN ".$_POST['ESFrom']." AND ".$_POST['ESTo'];
}

$VarsityQuery = "";
$PreVarsityQuery = "OR";

if($SiblingQuery == "" && $ASQuery == "" && $PromotionalQuery == "" && $ESQuery == "" ){
    $PreVarsityQuery = "";
}


if($_POST['VarsityFrom'] == 0 || $_POST['VarsityTo'] == 0){
    
    $VarsityQuery = "";
}
else{
    $VarsityQuery = " $PreVarsityQuery AdmissionVarsityDiscountID BETWEEN ".$_POST['VarsityFrom']." AND ".$_POST['VarsityTo'];
}


$EmployeeQuery = "";
$PreEmployeeQuery = "OR";

if($SiblingQuery == "" && $ASQuery == "" && $PromotionalQuery == "" && $ESQuery == "" && $VarsityQuery == "" ){
    $PreEmployeeQuery = "";
}


if($_POST['EmployeeFrom'] == 0 || $_POST['EmployeeTo'] == 0){
    
    $EmployeeQuery = "";
}
else{
    $EmployeeQuery = " $PreEmployeeQuery AdmissionEmployeeDiscountID BETWEEN ".$_POST['EmployeeFrom']." AND ".$_POST['EmployeeTo'];
}


$BOTQuery = "";
$PreBOTQuery = "OR";

if($SiblingQuery == "" && $ASQuery == "" && $PromotionalQuery == "" && $ESQuery == "" && $VarsityQuery == "" && $EmployeeQuery == "" ){
    $PreBOTQuery = "";
}


if($_POST['BOTFrom'] == 0 || $_POST['BOTTo'] == 0){
    
    $BOTQuery = "";
}
else{
    $BOTQuery = " $PreBOTQuery AdmissionBOTDiscountID BETWEEN ".$_POST['BOTFrom']." AND ".$_POST['BOTTo'];
}






$STSQuery = "";
$PreSTSQuery = "OR";

if($SiblingQuery == "" && $ASQuery == "" && $PromotionalQuery == "" && $ESQuery == "" && $VarsityQuery == "" && $EmployeeQuery == "" && $BOTQuery == "" ){
    $PreSTSQuery = "";
}



if($_POST['STSFrom'] == 0 || $_POST['STSTo'] == 0){
    
    $STSQuery = "";
}
else{
    $STSQuery = " $PreSTSQuery AdmissionSTSDiscountID BETWEEN ".$_POST['STSFrom']." AND ".$_POST['STSTo'];
}



$DataTableQuery = "SELECT StrandName,StudentIDDisplay,LastName,FirstName,COALESCE(MiddleName,'') AS 'Middle',COALESCE(ESCNumber,'') AS 'ESC', COALESCE(SectionName,'') AS 'Section', COALESCE(SiblingT.DiscountType,'') AS 'SiblingDiscount',COALESCE(AST.DiscountType,'') AS 'ASDiscount', COALESCE(PT.DiscountType,'') AS 'PromotionalDiscount', COALESCE(ET.DiscountType,'') AS 'ESDiscount', COALESCE(VT.DiscountType,'') AS 'VarsityDiscount',  COALESCE(STS.DiscountType,'') AS 'STSDiscount', COALESCE(EmployeeT.DiscountType,'') AS 'EmployeeDiscount', COALESCE(BOT.DiscountType,'') AS 'BOTDiscount'  FROM tblstudent LEFT JOIN tblstrand ON tblstudent.StudentStrand = tblstrand.StrandID,tblstudentadmission LEFT JOIN tblsection ON tblsection.SectionID = tblstudentadmission.AdmissionSectionID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONSIBLINGDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONSIBLINGDISCOUNTID IS NOT NULL AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS SiblingT ON SiblingT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONACADEMICSCHOLARSHIPDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONACADEMICSCHOLARSHIPDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS AST ON AST.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONPROMOTIONALDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONPROMOTIONALDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS PT ON PT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONENTRANCESCHOLARSHIPDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONENTRANCESCHOLARSHIPDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS ET ON ET.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONVARSITYDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONVARSITYDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS VT ON VT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONSTSDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONSTSDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS STS ON STS.AdmissionStudentID = tblstudentadmission.AdmissionStudentID  LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONEmployeeDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONEmployeeDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS EmployeeT ON EmployeeT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONBOTDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONBOTDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS BOT ON BOT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID    WHERE tblstudentadmission.AdmissionStudentID = tblstudent.StudentID AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear  and ADMISSIONSTATUS = 2 ";

$DataTableQuery .= $GradeLevelQuery;
$DataTableQuery .= $SiblingQuery;
$DataTableQuery .= $ASQuery;
$DataTableQuery .= $PromotionalQuery;
$DataTableQuery .= $ESQuery;
$DataTableQuery .= $VarsityQuery;
$DataTableQuery .= $EmployeeQuery;
$DataTableQuery .= $BOTQuery;
$DataTableQuery .= $STSQuery;
$DataTableQuery .= " )";

?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Student Data Report </h1></center>
     
     
     <div class="row-fluid">
         
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="StudentRecordsList">
              <thead>
                <tr>
                  <th>Student ID</th>
                  <th>Last Name</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>ESC/QVR Reference</th>
                  <th>Section</th>
                  <th>Sibling Discount</th>
                  <th>Academic Scholarship Discount</th>
                  <th>Promotional Discount</th>
                  <th>Entrance Scholarship Discount</th>
                  <th>Varsity Discount</th>
                  <th>STS Discount</th>
                  <th>Employee Discount</th>
                  <th>BOT Discount</th>
                </tr>
              </thead>
              <tbody>
                  
<?php
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($DataTableQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
    foreach($row as $data){
        echo '<tr>';
        echo '<td>'.$data['StudentIDDisplay'].'</td>';
        echo '<td>'.$data['LastName'].'</td>';
        echo '<td>'.$data['FirstName'].'</td>';
        echo '<td>'.$data['Middle'].'</td>';
        echo '<td>'.$data['ESC'].'</td>';
        echo '<td>'.$data['Section'].'</td>';
        echo '<td>'.$data['SiblingDiscount'].'</td>';
        echo '<td>'.$data['ASDiscount'].'</td>';
        echo '<td>'.$data['PromotionalDiscount'].'</td>';
        echo '<td>'.$data['ESDiscount'].'</td>';
        echo '<td>'.$data['VarsityDiscount'].'</td>';
        echo '<td>'.$data['STSDiscount'].'</td>';
        echo '<td>'.$data['EmployeeDiscount'].'</td>';
        echo '<td>'.$data['BOTDiscount'].'</td>';
           
        echo '</tr>';
    
           
    }
    } 
    else {
   
       $LatestSchoolYear = "2019";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                  
                  
                                    
?>
                    
            
              </tbody>
            </table>
          </div>
        </div>
         
          
     </div>
     
 </div> <!-- container fluid end -->


<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<!--<script src="js/jquery.dataTables.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<!--
<script src="http://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> 
<script src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/tabletools/2.2.4/js/dataTables.tableTools.min.js"></script>
-->
   
    
<script type="text/javascript">
    

$(document).ready(function() {
    
    console.log("<?php echo $DataTableQuery; ?>");
    var oTable = $('#StudentRecordsList').dataTable();
    var oSettings = oTable.fnSettings();
    oTable.fnDestroy();
    
    
    //$("#matrixstyle").attr("disabled", "disabled");
    
    
    $('head').append('<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">');
    
    
    
    
    $('#StudentRecordsList').DataTable( {
        "jQueryUI": true,
        "dom": 'Bfrtip',
        "order": [[ 1, "asc" ]],
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "paging": true,
        "pagingType": "full_numbers",
        "scrollX": true
    } );
    
    $('#StudentRecordsList_filter').css('margin-top',"-35px");

    
} );
    
</script>
    
    

    

</body>
</html>