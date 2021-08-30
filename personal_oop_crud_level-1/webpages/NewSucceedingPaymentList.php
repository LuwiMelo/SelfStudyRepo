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



$LatestSchoolYearMinus15 = $LatestSchoolYear - 15;


$GradeLevelFilterQuery = "";


if(isset($_SESSION['GradeLevelSortRetrieve'])){
    if($_SESSION['GradeLevelSortRetrieve'] == 0){
        $GradeLevelFilterQuery = "";
    }
    else{
    $GradeLevelFilterQuery = " AND AdmissionGradeLevelID = ".$_SESSION['GradeLevelSortRetrieve'];
    }
}
else{
    $GradeLevelFilterQuery = "";
}


//$DataTableQuery = "SELECT StudentID,AdmissionAssessmentIDDisplay,CONCAT(LastName,' ',FirstName,' ',COALESCE(MiddleName,'')) AS 'Fullname',AdmissionSchoolOfOrigin,InterviewDate FROM tblstudent,tblstudentadmission WHERE AdmissionStudentID = StudentID  AND StudentStatus = 0 AND LEFT(AdmissionAssessmentIdDisplay,4) = $LatestSchoolYear AND isReenrollee IS NULL GROUP BY StudentID ORDER BY AdmissionAssessmentIDDisplay ASC";

$DataTableQuery = "SELECT AdmissionID,GradeLevel, AdmissionAssessmentIDDisplay,AdmissionReenrollmentID,StudentID,StudentIDDisplay,CONCAT(LastName,' ',FirstName,' ',COALESCE(MiddleName,'')) AS 'Fullname',AdmissionSchoolOfOrigin,InterviewDate FROM tblstudent,tblstudentadmission 
LEFT JOIN tblgradelevel ON tblstudentadmission.AdmissionGradeLevelId = tblgradelevel.GradeLevelID WHERE AdmissionStudentID = StudentID  AND StudentStatus = 0 AND (LEFT(AdmissionAssessmentIdDisplay,4) = $LatestSchoolYear OR LEFT(AdmissionReenrollmentID,4) = $LatestSchoolYear    )and ADMISSIONSTATUS = 2 AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear  ORDER BY StudentIDDisplay ASC";
?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>List of Students for Succeeding Payment</h1></center>
     
     
     <div class="row-fluid">
         
       
         
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
              
              
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="StudentRecordsList">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Student ID</th>
                  <th>Enrollee ID</th>
                  <th>Student Name</th>
                  <th>Grade Level</th>
                 
              
                  <th>Action</th>
                 
              
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
          $index = 1;
         // $LatestSchoolYear =  $row['SchoolYear'];
        
    foreach($row as $data){
        echo '<tr>';
        echo '<td>'.$index.'</td>';
        echo '<td>'.$data['StudentIDDisplay'].'</td>';
        
        if(isset($data['AdmissionAssessmentIDDisplay'])){
            echo '<td>'."T-".$data['AdmissionAssessmentIDDisplay'].'</td>';
        }
        else{
             echo '<td>'."R-".$data['AdmissionReenrollmentID'].'</td>';
        }
       
        echo '<td>'.strtoupper($data['Fullname']).'</td>';
        echo '<td>'.strtoupper($data['GradeLevel']).'</td>';
     
       
  
        
          echo " <td> <form action=\"AddSucPaymentTransfereeInitializer.php\" method=\"post\"><input class=\"btn btn-primary\" type=\"submit\" value=\"Add New Transaction\" > <input type=\"hidden\" name=\"id\" value=\"".$data["StudentID"]."\">
          <input type=\"hidden\" name=\"admissionid\" value=\"".$data["AdmissionID"]."\">
        
        </form>    
        </td>  ";
        
      
        
        
            $index++;
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


<?php
    
    
    unset($_SESSION['GradeLevelSortRetrieve']);
    
?>
<script type="text/javascript">
    

 
</script>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>
    
    
    

    

</body>
</html>