<?php 


session_start();

include 'DataBaseConnectionFile.php';
include 'adminheader.php';


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
   
       $LatestSchoolYear = "2019";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

$LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
$LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];






$SectionID = $_SESSION['EditSectionSectionID'];


$_SESSION['EditSectionSectionID'] = $SectionID;




$SectionAdviserUserID;


//Get section adviser
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT UserID,LastName,MiddleName,FirstName FROM tblusers LEFT JOIN tbladvisory ON tbladvisory.AdvisoryUserID = tblusers.UserID WHERE AdvisorySchoolYearID = $LatestSchoolYearID AND AdvisorySectionID = :AdvisorySectionID");
    $statement->execute(array(':AdvisorySectionID' => $SectionID ));
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $SectionAdviserUserID =  $row['UserID'];
          $SectionAdviserFirstName = $row['FirstName'];
          $SectionAdviserLastName = $row['LastName'];          
    } 
    else {
   
       //$LatestSchoolYear = "2019";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



if(isset($SectionAdviserFirstName) && isset($SectionAdviserLastName) ){
    
    $SectionAdviserFullName = $SectionAdviserFirstName.' '.$SectionAdviserLastName;
}
else{
    $SectionAdviserFullName = "";
}






//Get section details
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT * FROM tblsection WHERE SectionID = $SectionID");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $SectionName =  $row['SectionName'];
          $SectionGradeLevelID =  $row['SectionGradeLevel'];
    } 
    else {
   
       //$LatestSchoolYear = "2019";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




//Get department
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT GradeLevelDepartment FROM tblgradelevel WHERE GradeLevelID = $SectionGradeLevelID");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $GradeLevelDepartment =  $row['GradeLevelDepartment'];
          
    } 
    else {
   
      
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}






?>

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
      <hr>
    <center>    <img  style="width: 800px; height: 150px;" src="phase1logo.png"> </center>
      <br>
 <center><h1> Edit Students of a Section  </h1></center>
      <br>
      <br>
    
     
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Section Details</h5>
        </div>
        <div class="widget-content nopadding">
              <div class="row-fluid">
            
            
                 <div class="span1"></div>
                 <div class="span5">
              
                   <label class="control-label">Section Name:</label>
              <div class="controls">
                <input type="text" name="SectionName" id="SectionName" class="span10 m-wrap" value="<?php echo $SectionName; ?>" disabled/>
                  
                <input type="hidden" name="SectionID" id="SectionID" class="span10 m-wrap" value="<?php echo $SectionID; ?>" disabled/>
                  
                  
              </div>
                      
                
                 </div>
            
                
                   <div class="span5">
              
                   <label class="control-label">Section Grade Level:</label>
              <div class="controls">
                <select name="GradeLevel" id="GradeLevel" disabled>
                    <?php 
                                                        
                          
        try
{
 
    
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
            if($SectionGradeLevelID == $data['GradeLevelID']){
                $selected = "selected";
            
                
            }
            else{
                $selected = "";
            }
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected .'>' . $data['GradeLevel'] .'</option>';
            
            
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
                  
                  
              </div>
                      
           
                
                 </div>
  
            
           
                
                
            
            </div>
              <br>
            
            
            
            
            
            
            
            
            
            
            <div class="row-fluid">
            
            
                 <div class="span1"></div>
                
                <div class="span5">
                
                         <label class="control-label">Current Adviser:</label>
              <div class="controls">
                <input type="text" name="CurrentAdviser" id="CurrentAdviser" class="span10 m-wrap" value="<?php echo $SectionAdviserFullName; ?>" disabled/>
         
                
                
                </div>
                
                </div>
                
                
                 <div class="span4">
              
                    <label class="control-label">Adviser:</label>
              <div class="controls">
                <select name="Adviser" id="Adviser" >
                    <option value="0">No Adviser Assigned</option>
                    <?php 
                                                        
                          
        try
{
 
    
    if(isset($SectionAdviserUserID)){
        $AdditionalQuery = " AND UserID <> ".$SectionAdviserUserID." ";
    }
    else{
        $AdditionalQuery = "";
    }
       
    $Query = "SELECT * FROM tblusers WHERE AssignedDepartment = $GradeLevelDepartment AND (UserPositionLevel = 7 OR UserPositionLevel = 4) $AdditionalQuery AND UserID NOT IN (SELECT AdvisoryUserID FROM tbladvisory WHERE AdvisorySchoolYearID = $LatestSchoolYearID and AdvisoryUserID IS NOT NULL)  ";
       
            
  
    $statement = $dbh->prepare($Query);
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
         
           echo '<option value ="' . $data['UserID'] . '" '.'>' . $data['FirstName'] .' '.$data['LastName']. '</option>';
            
            
        }
        
    } 
    else {
   
      echo '<option> No more teachers available </option>';
    }
    
    
    
    
    
    
    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}


                                                        


                                                        
                     ?> 
                
                </select>
                  
                  
              </div>
                     
                      
                
                 </div>
            
                
                   <div class="span1">
              
                      <button id="btnAssignAdviser" class="btn btn btn-info" style="margin-top: 25px;">Assign Adviser</button>
           
                
                 </div>
  
            
           
                
                
            
            </div>
            
            
            
            
            
            
            
            
            
            
            
     
            
<div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-briefcase"></i> </span>
            <h5 >Students</h5>
          </div>
          <div class="widget-content">
    
              
    <div class="row-fluid" >
           
  
           <button type="button" id="AddStudent" class="btn btn-success pull-right" href="#modalAddStudent" data-toggle="modal">Click to Add Student</button>
        
            <h3><center>List of Students in this Section</center></h3>
      <table class="table table-bordered data-table" id="StudentsInSectionList">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Admission ID Hidden</th>
                  <th>Action</th>
                </tr>
              </thead>
             <tbody>
                
                 
                 <?php
                  
                  
try
{
  
    $statement = $dbh->prepare("SELECT * from tblstudent,tblstudentadmission,tblpaymenttransactions WHERE StudentID = AdmissionStudentID AND PaymentAdmissionID = AdmissionID AND AdmissionSchoolYearID = $LatestSchoolYearID AND AdmissionGradeLevelID = $SectionGradeLevelID AND AdmissionSectionID = $SectionID AND PaymentSchoolYearID = $LatestSchoolYearID  GROUP BY AdmissionID");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
         // $LatestSchoolYear =  $row['SchoolYear'];
        
    foreach($row as $data){
        echo '<tr>';
        echo '<td>'.$index.'</td>';
        echo '<td>'.$data['StudentIDDisplay'].'</td>';
        echo '<td>'.$data['LastName'].','.$data['FirstName'].' '.$data['MiddleName'].'</td>';
        echo '<td>'.$data['AdmissionID'].'</td>';
        echo '<td><button class="btn btn-danger" id="btnRemoveStudent">Remove Student</button></td>  ';
        
        echo"</tr>";
        
        
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
        
        <br>
        <br>
        <br>
    </div>
              

        </div> <!-- widget content -->
      </div>
    </div>
           

 
        </div>
        
<!-- widget content padding -->
        
        
        
        
    </div>
<!-- widget box -->
        
        
     

    
  
  </div>
      
      <!-- end 2nd row fluid -->


    
    <!-- end-container -->
    
</div>

<!--end-main-container-part-->
    
    
    

      </div>
    
      
      
      
      
      
      
      
            <div id="modalAddStudent" class="modal hide" style="width: 850px; left: 40%;">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add Student</h3>
              </div>
              <div class="modal-body">
                  
                    <table class="table table-bordered data-table" id="AvailableStudentsList">
              <thead>
                <tr>
                  <th>Number</th>
                  <th>Student ID</th>
                  <th>Student Name</th>
                  <th>Strand</th>
                  <th>Admission ID Hidden</th>
                  <th>Action</th>
                </tr>
              </thead>
             <tbody>
                
        
                 <?php
                  
                  
try
{
  
    $statement = $dbh->prepare("SELECT tblstudent.*,StrandName,tblstudentadmission.* from tblstudentadmission,tblpaymenttransactions,tblstudent  LEFT JOIN tblstrand ON tblstrand.StrandID = tblstudent.StudentStrand WHERE StudentID = AdmissionStudentID AND PaymentAdmissionID = AdmissionID AND AdmissionSchoolYearID = $LatestSchoolYearID and ADMISSIONSTATUS = 2 AND AdmissionUpdate = 1 AND AdmissionGradeLevelID = $SectionGradeLevelID AND AdmissionSectionID IS NULL AND PaymentSchoolYearID = $LatestSchoolYearID  GROUP BY AdmissionID");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
         // $LatestSchoolYear =  $row['SchoolYear'];
        
    foreach($row as $data){
        echo '<tr>';
        echo '<td>'.$index.'</td>';
        echo '<td>'.$data['StudentIDDisplay'].'</td>';
        echo '<td>'.$data['LastName'].','.$data['FirstName'].' '.$data['MiddleName'].'</td>';
        echo '<td>'.$data['StrandName'].'</td>';
        echo '<td>'.$data['AdmissionID'].'</td>';
        echo '<td><button class="btn btn-success" id="btnAddStudent">Add Student</button></td>  ';
        
        echo"</tr>";
        
        
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
            
                  
                  
              </div> <!-- modal body -->
              <div class="modal-footer">  <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
            </div> 
    

<?php

include 'EnrollmentPhase2Footer.php';

?>
    
    
    
    
    
<script type="text/javascript">
    
    /*
  $( document ).ready(function() {
      console.log("TEST");
      alert("");
      
});
    
    */
    
      $( document ).ready(function() {
          
           console.log("<?php echo $Query; ?>");
          
             var AvailableStudentsTable = $('#AvailableStudentsList').DataTable({
       
                "bRetrieve": true,
    
             });
    
      
            AvailableStudentsTable.column( 4 ).visible( false );
          
          
            var StudentsInSectionTable = $('#StudentsInSectionList').DataTable({
       
                "bRetrieve": true,
    
             });
    
            
            StudentsInSectionTable.column( 3 ).visible( false );
          
            $('#AvailableStudentsList_filter').css('margin-top',"-20px");
            
            $('#StudentsInSectionList_filter').css('margin-top',"80px");
        
          
            
            //$('#StudentsInSectionList_filter').css('position',"static");
            
          
          
AvailableStudentsTable.on('click', '#btnAddStudent', function () {
    
    var data = AvailableStudentsTable.row($(this).closest('tr')).data();

    var SectionID = $("#SectionID").val();
    var StudentID = data[Object.keys(data)[1]];
    var StudentName = data[Object.keys(data)[2]];
    var AdmissionID = data[Object.keys(data)[4]];
 
    var StudentDetails = { AdmissionID: AdmissionID, SectionID: SectionID };

    
     $.ajax({
            type:'POST',
            url:'AddStudentToSection.php',
            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
            success:function(html){
                                 
                    window.location.href="/iucsenrollmentsystem/webpages/EditSectionStudents.php";
                
                 
                                   
                    
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
    
    
        
 });
          
          
          
          
StudentsInSectionTable.on('click', '#btnRemoveStudent', function () { 
    
    
    if (confirm('Remove student?')) {
     var data = StudentsInSectionTable.row($(this).closest('tr')).data();

    var SectionID = $("#SectionID").val();
    var StudentID = data[Object.keys(data)[1]];
    var StudentName = data[Object.keys(data)[2]];
    var AdmissionID = data[Object.keys(data)[3]];
 
    var StudentDetails = { AdmissionID: AdmissionID, SectionID: SectionID };

    
     $.ajax({
            type:'POST',
            url:'RemoveStudentToSection.php',
            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
            success:function(html){
                                 
                    window.location.href="/iucsenrollmentsystem/webpages/EditSectionStudents.php";
                                   
                    
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
    
    
    
    }
    
    
    
    
    
    
    
    
    
});     
          
          
          
          
          
        
    
$('#modalAddStudent').css('width',"760px;");
          
          
          
      });
    
    

    
 
$("#btnAssignAdviser").click(function() {
    
       
      
    if (confirm('Assign Adviser?')) {
    

        var Adviser = $("#Adviser").val();
    
        
        var StudentDetails = { Adviser: Adviser };

    
     $.ajax({
            type:'POST',
            url:'AssignAdviser.php',
            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
            success:function(html){
                                 
                   window.location.href="/iucsenrollmentsystem/webpages/EditSectionStudents.php";
                                   
                    
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
        
        
        
        
    }
    
    
    
});
    
    
    
 



</script>
    
    
    
    
    </body>
</html>
    
    

    