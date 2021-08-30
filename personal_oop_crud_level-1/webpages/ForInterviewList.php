<?php
//Code For User Authentication For Each Web Page

session_set_cookie_params(7200,"/");
session_start();

include 'DataBaseConnectionFile.php';
include 'adminheader.php';
/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}




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


$LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
                
$LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];



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

$DataTableQuery = "SELECT AdmissionStatus,GradeLevel, AdmissionID, StudentID,AdmissionAssessmentIDDisplay,CONCAT(LastName,' ',FirstName,' ',COALESCE(MiddleName,'')) AS 'Fullname',AdmissionSchoolOfOrigin,InterviewDate,AdmissionPhase2ID, LEFT(AdmissionReferenceNum,4) AS 'RefNum' FROM tblstudent,tblstudentadmission LEFT JOIN tbladmissionphase2 ON tblstudentadmission.AdmissionID = tbladmissionphase2.AdmissionStudentAdmissionID
LEFT JOIN tblgradelevel ON tblstudentadmission.AdmissionGradeLevelId = tblgradelevel.GradeLevelID WHERE AdmissionStudentID = StudentID  AND StudentStatus = 0 AND LEFT(AdmissionAssessmentIdDisplay,4) = $LatestSchoolYear AND isReenrollee IS NULL GROUP BY StudentID ORDER BY AdmissionAssessmentIDDisplay ASC";

?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>List of Transferees</h1></center>
     
     
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
                  <th>Enrollee ID</th>
                  <th>Student Name</th>
				   <th>Grade Level </th>
                   <th>School of Origin </th>
				   <th>Enrollment Status </th>
                  <th>Interview Date</th>
                  <th>General Details</th>
                  <th>Interview</th>
                  <th>Update Interview</th>
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
        
        $DisableInterview = "";
        
        if($_SESSION['SessionUserPositionLevel'] != 5 && $_SESSION['SessionUserPositionLevel'] != 1  ){
            $DisableInterview = " disabled ";
        }
        
        
        
    foreach($row as $data){
        
        
        $InterviewDone = false;
        
        if(is_null($data['AdmissionPhase2ID'])){
           
            $DisabledIndicator = "";
        }
        else{
            
            $DisabledIndicator = " disabled "; 
            $InterviewDone = true;
        }
        
        
        
        echo '<tr>';
        echo '<td>'.$index.'</td>';
        echo '<td>'."T-".$data['AdmissionAssessmentIDDisplay'].'</td>';
        echo '<td>'.$data['Fullname'].'</td>';
		echo '<td>'.$data['GradeLevel'].'</td>';
        echo '<td>'.$data['AdmissionSchoolOfOrigin'].'</td>';
        
      //  if($data['RefNum'] == $LatestSchoolYear){
            //echo '<td>'.'Officially Enrolled'.'</td>';
       // }
       // else{
            
            $selectedWithdrawn = "";
            $selectedRegisteredOnly = "";
            $selectedOfficiallyEnrolled = "";
            
           if($data['AdmissionStatus'] == 1){
               $selectedRegisteredOnly = " selected ";
               
           }
           if($data['AdmissionStatus'] == 2){
               $selectedOfficiallyEnrolled = " selected ";
               
           }
           if($data['AdmissionStatus'] == 3){
               $selectedWithdrawn = " selected ";
               
           }
            
         echo '<td>';
            
        
                echo '<select style = "width:137px;" name="RegistrationStatus" class="RegistrationStatus" data-id = "'.$data['AdmissionID'].' ">
                    <option value="1" '.$selectedRegisteredOnly. ' >Registered Only</option>
                    <option value="2" '.$selectedOfficiallyEnrolled. ' >Enrolled</option>
                    <option value="3" '.$selectedWithdrawn. ' >Withdrawn</option>
                    
                </select> 
               
              
                </td>';
            
            
       // }
        //  
        
        echo '<td>'.$data['InterviewDate'].'</td>';
        echo " <td> <form action=\"ViewStudentForInterviewInitializer.php\" method=\"post\"><input class=\"btn btn-success\" type=\"submit\" value=\"Phase 1 Data\" > <input type=\"hidden\" name=\"id\" value=\"".$data["StudentID"]."\"> <input type=\"hidden\" name=\"admissionid\" value=\"".$data["AdmissionID"]."\"  >
        
        </form>    
        </td>  ";
        
        
        if($InterviewDone){
            
            echo "<td>Interview Done</td> ";
            
            
        }
        else{
            echo " <td> <form action=\"InterviewFormInitializer.php\" method=\"post\"><input class=\"btn btn-info\" type=\"submit\" value=\"Interview\" $DisableInterview > <input type=\"hidden\"  name=\"id\" value=\"".$data["StudentID"]."\"> <input type=\"hidden\" name=\"admissionid\" value=\"".$data["AdmissionID"]."\">
        
        </form>    
        </td>  ";
            
        }
         
        
        
        if($InterviewDone){
             echo " <td> <form action=\"ViewInterviewFormInitializer.php\" method=\"post\"><input class=\"btn btn-primary\" type=\"submit\" value=\"Update Interview\" $DisableInterview > <input type=\"hidden\" name=\"id\" value=\"".$data["StudentID"]."\"> <input type=\"hidden\" name=\"admissionid\" value=\"".$data["AdmissionID"]."\">
        
        </form>    
        </td>  ";
            
        }
        else{
            
            echo '<td>No result yet </td>';
        }
         
         echo "</tr>";
           $DisabledIndicator = "";
        
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

    
    
    
    
    
<!--
<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script>
    
    -->
    
<script src="js/jquery.min.js"></script>  
<script src="https://cdn.datatables.net/1.9.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.9.4/js/jquery.dataTables.min.js"></script>
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.gritter.min.js"></script>
<script src="js/jquery.peity.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<!--
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script> -->
<!--
<script src="js/jquery.dataTables.min.js"></script> -->
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script> 
<script src="//cdn.datatables.net/plug-ins/1.10.19/api/fnReloadAjax.js"></script>
<script type="text/javascript">
    
    
    
 $(document).ready(function() {
     
     
   var oTable = $('#StudentRecordsList').dataTable();
    var oSettings = oTable.fnSettings();
    oTable.fnDestroy();

    
    var oTable2 = $('#StudentRecordsList').dataTable({
        
                            "bPaginate": true,
                            "bJQueryUI": true,  // ThemeRoller-stöd
                            "bLengthChange": true,
                            "bFilter": true,
                            "bSort": true,
                            "bInfo": true,
                            "bAutoWidth": true,
                            "bProcessing": true,
                          //"bServerSide": true, //Removing bServerSide fix the problem. I don't know why.
                            "sPaginationType": "full_numbers",
                           // "sAjaxSource": "UserLoadData.php",
                            "sDom": '<"top"fl<"clear">>rt<"bottom"ifLp<"clear">>',
                            "sScrollX": "100%",
                            "sScrollXInner": "110%",
                            "bScrollCollapse": true
                            //"sScrollX": 100% 
                            //"sScrollY": true
                          //"iDisplayLength": 10,
                          //"bJQueryUI": true,
                          //"bFilter": true,
                          //"sDom": '<""l>t<"F"fp>',
                          //"iDisplayLength":5,
                          //"iDisplayStart ":5,
                           // "sDom": '<"top"i>rt<"bottom"flp><"clear">',
                          //"bPaginate": true,
                          //"bDestroy": true,
                          //"bProcessing": true,
                          //"bServerSide": true,
                          //"sAjaxDataProp": "demo",
                          //"aoColumns": [
                                //{ mData: 'id' } ,
                                //{ mData: 'name' },
                                //{ mData: 'age' }
                         //]
   });

     
     
     
     
     
     
     
     
     
     
//Triggered upon changing dropdown value
$('#StudentRecordsList').on('change', '.RegistrationStatus', function(){
    
    if (confirm('Change admission status? You will be liable for the change of the registration of this student! ')) {
          
       
        
            //if($(this).prop('selectedIndex') == 1){
                
                
                
                var AdmissionID = $(this).data('id');
                var SelectedIndex = $(this).val();
                
                var AdmissionDetails = { AdmissionID: AdmissionID, SelectedIndex: SelectedIndex };
        
        
               
                $.ajax({
                            type:'POST',
                            url:'ChangeAdmissionStatus.php',
                            data:{"RetrieveTransaction" : JSON.stringify(AdmissionDetails)},
                            success:function(html){
                                 
                                   window.location.href="/iucsenrollmentsystem/webpages/ForInterviewList.php";
                                   
                    
                            }, // After Ajax Submit
                       
                       error: function(request, error) {
                            
                                 $.gritter.add({
			                         title: 'Operation Failed!',
			                         text: 'System Error! Please contact the IT Team of Imus Unida Christian School',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 $(".gritter-item").css("background","#ff0000");
        
                        }
                });
                
                
                
                
                
            //}
            
          
          
        
        
        
    }
    else{
        
           //$(this).prop('selectedIndex') = 0;
            $(this)[0].selectedIndex = 0;
            $('#s2id_RegistrationStatus span').text('Registration Only');
        
        
    }
 
            
            
});

    
     
    });
 
</script>
    

    

</body>
</html>