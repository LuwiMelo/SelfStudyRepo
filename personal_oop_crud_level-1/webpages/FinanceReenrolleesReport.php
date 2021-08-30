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


$DataTableQuery = "SELECT 
    AdmissionReenrollmentID AS Number, StudentIDDisplay, CONCAT(COALESCE(LastName,''),', ',COALESCE(FirstName,''),' ',COALESCE(MiddleName,'')) As Fullname,  CONCAT(COALESCE(AddressPrefix,''),COALESCE(StudentBarangay,''),' ',COALESCE(StudentVillageOrDistrict,''),' ',COALESCE(MunicipalityName,''),' ',COALESCE(ProvinceName,'')) AS 'Address', ContactPersonContactNumber As 'Contact#', ContactPerson As 'Contact Person', DATE_FORMAT(StudentBirthday,'%d-%b-%Y')  As 'Birthday' , GradeLevel As 'Grade Level', COALESCE(SectionName,'') AS 'Section', COALESCE(StrandName,'') AS 'Strand',  COALESCE(SiblingT.DiscountType,'') AS 'Sibling Discount',COALESCE(AST.DiscountType,'') AS 'Academic Scholarship Discount', COALESCE(PT.DiscountType,'') AS 'Promotional Discount', COALESCE(ET.DiscountType,'') AS 'Entrance Scholarship Discount', COALESCE(VT.DiscountType,'') AS 'Varsity Discount',COALESCE(STS.DiscountType,'') AS 'STS Discount', COALESCE(EmployeeT.DiscountType,'') AS 'EmployeeDiscount', COALESCE(BOT.DiscountType,'') AS 'BOTDiscount', COALESCE(DateOfEnrollmentTable.DateOfEnrollment,'') AS 'Date Of Enrollment'


FROM
    tblprovince,tblmunicipality,tblgradelevel,tblstudentadmission LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONSIBLINGDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONSIBLINGDISCOUNTID IS NOT NULL AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS SiblingT ON SiblingT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONACADEMICSCHOLARSHIPDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONACADEMICSCHOLARSHIPDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID ) AS AST ON AST.AdmissionStudentID = tblstudentadmission.AdmissionStudentID 
    
    LEFT JOIN(SELECT PaymentAdmissionID, MIN(DateOfPayment) AS 'DateOfEnrollment' FROM     tblpaymenttransactions WHERE PaymentSchoolYearID = $LatestSchoolYearID GROUP BY PaymentAdmissionID ORDER BY `tblpaymenttransactions`.`PaymentAdmissionID`  DESC) AS DateOfEnrollmentTable ON DateOfEnrollmentTable.PaymentAdmissionID = tblstudentadmission.AdmissionID
        
        
    LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONPROMOTIONALDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONPROMOTIONALDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS PT ON PT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID
    LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONENTRANCESCHOLARSHIPDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONENTRANCESCHOLARSHIPDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS ET ON ET.AdmissionStudentID = tblstudentadmission.AdmissionStudentID
    LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONVARSITYDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONVARSITYDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS VT ON VT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID
    
    LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONSTSDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONSTSDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS STS ON STS.AdmissionStudentID = tblstudentadmission.AdmissionStudentID
    
    LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONEmployeeDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONEmployeeDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS EmployeeT ON EmployeeT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID
    
    LEFT JOIN(SELECT AdmissionStudentID,DISCOUNTTYPE FROM TBLSTUDENTADMISSION LEFT JOIN TBLDISCOUNTTYPE ON ADMISSIONBOTDISCOUNTID = DISCOUNTTYPEID WHERE ADMISSIONBOTDISCOUNTID IS NOT NULL  AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID) AS BOT ON BOT.AdmissionStudentID = tblstudentadmission.AdmissionStudentID
    
    
    LEFT JOIN tblsection ON tblstudentadmission.`AdmissionSectionID` = tblsection.SectionID
    ,tblstudent LEFT JOIN tblstrand ON tblstudent.StudentStrand = tblstrand.StrandID
    

    
    
    
WHERE
	 tblstudent.StudentID = tblstudentadmission.AdmissionStudentID AND tblstudentadmission.AdmissionSchoolYearID = $LatestSchoolYearID AND      tblmunicipality.MunicipalityID = tblstudent.StudentMunicipalityID AND tblgradelevel.GradeLevelID = tblstudentadmission.AdmissionGradeLevelID  AND AdmissionStatus = 2 AND tblprovince.ProvinceID = tblstudent.StudentProvinceID AND `AdmissionReenrollmentID` IS NOT NULL
ORDER BY AdmissionReenrollmentID ASC 





 ";



?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Re-enrollees Data Report </h1></center>
     
     
     <div class="row-fluid">
         
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="StudentRecordsList" style="table-layout:fixed;">
              <thead>
                <tr>
                  <th>Enrollee ID</th>
                  <th>Date Of Enrollment</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Address</th>
                  <th>Contact Number</th>
                  <th>Contact Person</th>
                  <th>Birthday</th>
                  <th>Grade Level</th>
                  <th>Section</th>
                  <th>Strand</th>
                  <th>Sibling Discount</th>
                  <th>Academic Discount</th>
                  <th>Promotional Discount</th>
                  <th>Entrance Discount</th>
                  <th>Athlete Discount</th>
                  <th>STS Discount</th>
                    <th>Employee Discount</th>
                    <th>BOT Discount</th>
              </thead>
              <tbody>
                  
<?php
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($DataTableQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
        echo '<tr>';
        echo '<td>'."R-".$data['Number'].'</td>';
        echo '<td>'.$data['Date Of Enrollment'].'</td>';
        echo '<td>'.$data['StudentIDDisplay'].'</td>';
        echo '<td>'.$data['Fullname'].'</td>';
        echo '<td>'.$data['Address'].'</td>';
        echo '<td>'.$data['Contact#'].'</td>';
        echo '<td>'.$data['Contact Person'].'</td>';
        echo '<td>'.$data['Birthday'].'</td>';
        echo '<td>'.$data['Grade Level'].'</td>';
        echo '<td>'.$data['Section'].'</td>';
        echo '<td>'.$data['Strand'].'</td>';
        echo '<td>'.$data['Sibling Discount'].'</td>';
        echo '<td>'.$data['Academic Scholarship Discount'].'</td>';
        echo '<td>'.$data['Promotional Discount'].'</td>';
        echo '<td>'.$data['Entrance Scholarship Discount'].'</td>';
        echo '<td>'.$data['Varsity Discount'].'</td>';
        echo '<td>'.$data['STS Discount'].'</td>';
        echo '<td>'.$data['EmployeeDiscount'].'</td>';
        echo '<td>'.$data['BOTDiscount'].'</td>';
           
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

          //echo '<tr>';
          //echo '<td>'.$Blank.'</td>';
          //echo '<td>'.$Blank.'</td></tr>';
     
          //echo '<tr>';
          //echo '<td>'.$RunningTotal.'</td>';
          //echo '<td>Total Enrollees</td></tr>';
     
                 
                  
                                    
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
    
    //console.log("<?php ?>");
    
    var oTable = $('#StudentRecordsList').dataTable();
    var oSettings = oTable.fnSettings();
    oTable.fnDestroy();
    
    
    //$("#matrixstyle").attr("disabled", "disabled");
    
    
    $('head').append('<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">');
    
    
    
    
    $('#StudentRecordsList').DataTable( {
        "jQueryUI": true,
        "dom": 'Bfrtip',
        //"order": [[ 1, "asc" ]],
         "ordering": false,
         buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "paging": true,
        "pagingType": "full_numbers",
        "scrollX": true,
        "scrollY": true,
        
    } );
    
    $('#StudentRecordsList_filter').css('margin-top',"-35px");

    
} );
    
</script>
    
    

    

</body>
</html>