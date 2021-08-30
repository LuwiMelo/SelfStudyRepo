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


$DataTableQuery = "SELECT StudentID,StudentIDDisplay,CONCAT(LastName,' ',FirstName,' ',COALESCE(MiddleName,'')) AS 'Fullname',MAX(AdmissionReferenceNum) AS 'MaxNum',GradeLevel,COALESCE(SectionName,'') AS 'Section' FROM tblstudent,tblgradelevel,tblstudentadmission LEFT JOIN tblsection ON tblstudentadmission.AdmissionSectionID = tblsection.SectionID WHERE AdmissionStudentID = StudentID AND GradeLevelID = AdmissionGradeLevelID  AND StudentStatus = 0 ".$GradeLevelFilterQuery." GROUP BY StudentID ORDER BY Fullname ASC";

?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Student Records </h1></center>
     
     
     <div class="row-fluid">
         
         <div class="span3" style="position: relative; top: 20px; left: 700px;z-index: 999999;">
             
             <form method="post" action="StudentRecordsListGradeLevelSort.php">
             <label style="position:relative; top: 30px; right: 90px;">Grade Level: </label>

             
              <select name="GradeLevelSort" id="GradeLevelSort">
                  <option value="0">All</option>
                <?php 
             try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel ORDER BY GradeLevel ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            if($_SESSION['GradeLevelSortRetrieve'] == $data['GradeLevelID']){
                $selected = "selected";
                
            }else{
                $selected = "";
            }
           
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected .'>' . $data['GradeLevel'] . '</option>';
        
        }
        
    } 
    else {
   
      echo '<option> No data </option>';
    }

      
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

      
                       
    ?>
              </select>
     
             
             <button type="submit" class="btn btn-primary" style="position: relative; left: 230px;bottom: 28px;">Sort</button>
                    
                 </form>
             </div>
         
         
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
                  <th>Latest Reference #</th>
                  <th>Student Name</th>
                  <th>Grade Level</th>
                  <th>Section</th>
                  <th>Action</th>
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
        echo '<td>'.$data['MaxNum'].'</td>';
        echo '<td>'.$data['Fullname'].'</td>';
        echo '<td>'.$data['GradeLevel'].'</td>';
        echo '<td>'.$data['Section'].'</td>';
           
        echo " <td> <form action=\"EditStudentProfileInitializer.php\" method=\"post\"><input class=\"btn btn-success\" type=\"submit\" value=\"Edit\" > <input type=\"hidden\" name=\"id\" value=\"".$data["StudentID"]."\">
        
        </form>    
        </td>  ";
        
        
        
        echo " <td> <form action=\"DeleteStudentRecord.php\" method=\"post\" onsubmit=\"return confirm('Are you sure you want to delete this record?');\"><input class=\"btn btn-danger\" type=\"submit\" value=\"Delete\" > <input type=\"hidden\" name=\"id\" value=\"".$data["StudentID"]."\">
        
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