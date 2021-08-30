<?php
//Code For User Authentication For Each Web Page
session_start();
/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}*/

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
    $statement = $dbh->prepare("SELECT SchoolYear FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYear =  $row['SchoolYear'];
          
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
    
    $GradeLevelQuery = "AND AdmissionGradeLevelID = ".$_POST['GradeLevelFrom'];
}
else{
    $GradeLevelQuery = "AND AdmissionGradeLevelID BETWEEN ".$_POST['GradeLevelFrom']." AND ".$_POST['GradeLevelTo'];
}

$StrandQuery = "";

if($_POST['StrandFrom'] == $_POST['StrandTo']){
    
    $StrandQuery = " AND StudentStrand = ".$_POST['StrandFrom'];
}
else{
    $StrandQuery = " AND StudentStrand BETWEEN ".$_POST['StrandFrom']." AND ".$_POST['StrandTo'];
}


$DataTableQuery = "SELECT StrandName,StudentIDDisplay,LastName,FirstName,COALESCE(MiddleName,'') AS 'Middle',COALESCE(ESCNumber,'') AS 'ESC', COALESCE(SectionName,'') AS 'Section' FROM tblstudent LEFT JOIN tblstrand ON tblstudent.StudentStrand = tblstrand.StrandID,tblstudentadmission LEFT JOIN tblsection ON tblsection.SectionID = tblstudentadmission.AdmissionSectionID  WHERE AdmissionStudentID = StudentID AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear and ADMISSIONSTATUS = 2 ";

$DataTableQuery .= $GradeLevelQuery;
$DataTableQuery .= $StrandQuery;

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
                  <th>Strand</th>
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
        echo '<td>'.$data['StrandName'].'</td>';
           
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