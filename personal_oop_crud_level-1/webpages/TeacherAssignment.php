<?php
//Code For User Authentication For Each Web Page
session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
include 'adminheader.php';



$dsn = 'mysql:host=localhost;dbname=iucs_ecra_db;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


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



$DataTableQuery = "SELECT tblsection.*,tblgradelevel.GradeLevel ,COUNT(tblCount.AdmissionID) AS 'Total' FROM tblgradelevel,tblsection LEFT JOIN (SELECT * from tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearID) AS tblCount ON tblCount.AdmissionSectionID = SectionID WHERE SectionGradeLevel = GradeLevelID  GROUP BY SectionID ";
?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Sectioning of Students</h1></center>
     
     
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
                  <th>Section Name</th>
                  <th>Grade Level</th>
                  <th>Total Students</th>
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
        echo '<td>'.$data['SectionName'].'</td>';
        echo '<td>'.$data['GradeLevel'].'</td>';
        echo '<td>'.$data['Total'].'</td>';
  
        
          echo " <td> <form action=\"AddStudentsToSectionInitializer.php\" method=\"post\"><input class=\"btn btn-primary\" type=\"submit\" value=\"Edit Students\" > <input type=\"hidden\" name=\"id\" value=\"".$data["SectionID"]."\">
        
        </form>    
        </td>  ";
        
      
        
        
            $index++;
    }
    } 
    else {
   
       $LatestSchoolYear = "2020";
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
    
    
    //unset($_SESSION['GradeLevelSortRetrieve']);
    
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