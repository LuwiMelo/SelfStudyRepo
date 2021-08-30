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




$DataTableQuery = "SELECT COUNT(AdmissionStudentID) AS 'AdmissionCount', AdmissionGradeLevelId, GradeLevel FROM tblstudentadmission, tblgradelevel WHERE GradeLevelID = AdmissionGradeLevelID AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID  AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear GROUP BY AdmissionGradeLevelID ";



?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Enrollees Data Report </h1></center>
     
     
     <div class="row-fluid">
         
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="StudentRecordsList">
              <thead>
                <tr>
                  <th>Total Enrollees</th>
                  <th>Grade Level</th>
            
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
        echo '<td>'.$data['AdmissionCount'].'</td>';
        $RunningTotal = $RunningTotal + $data['AdmissionCount'];
        echo '<td>'.$data['GradeLevel'].'</td>';
 
           
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

          echo '<tr>';
          echo '<td>'.$Blank.'</td>';
          echo '<td>'.$Blank.'</td></tr>';
     
          echo '<tr>';
          echo '<td>'.$RunningTotal.'</td>';
          echo '<td>Total Enrollees</td></tr>';
     
                 
                  
                                    
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
        //"order": [[ 1, "asc" ]],
         "ordering": false,
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