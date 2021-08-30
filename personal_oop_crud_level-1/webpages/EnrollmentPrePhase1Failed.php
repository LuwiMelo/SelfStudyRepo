<?php 


include 'DataBaseConnectionFileNoLogInRequired.php';

//session_start();


if(!isset($_SESSION['SessionUserID'])){
    
    include 'phase1header.php';
}
else{
    include 'adminheader.php';
}





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
        <center> <h2>School Year is <?php echo $_SESSION['SessionSelectedSchoolYear']; ?></h2> </center>
     <center> <h2>Ooops! Failed to Enroll Student!</h2> </center>

      
      
      <div class="row-fluid">
          
          
          
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>FAILED TO ENROLL STUDENT</h5>
          </div>
          <div class="widget-content">
                 <div class="alert alert-error alert-block"> <a class="close" data-dismiss="alert" href="#" >×</a>
              <h4 class="alert-heading">Cannot Enroll Student!</h4>
                     
                     <br>
                     
              <label style="font-size: 25px; line-height: 1.3;">
              This is a legacy data of enrollment system. You cannot enroll student in previous school year. You can only enroll student in the current school year. Please navigate to the latest version of system by selecting the current school year! If enrolling this student is really needed, please contact the Developer of this system. </label> </div>
      
          </div>
      
                        
          </div>
      
          
          
          
      </div>
                
        
    

    
</div>


    
</div>
    
    
    



<!-- Modal Old Student -->

            <div id="modalOldStudent" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Enroll Old Student</h3>
              </div>
                
            
             
              <div class="modal-body">
                  
                  
                
                  <div class="row-fluid">
                      <div class="span2"></div>
                            <div class="span10">
                                <br>
            
                            <label class="control-label">Enter Student Number: </label>
                            <div class="controls">
                            <input type="text" name="ModalStudentIDDisplay" id="ModalStudentIDDisplay" class="span10 m-wrap" placeholder="e.g. 2018-00001" value=""/>
                            </div>
                    
                            </div>
                      
                    </div>
                  <br>
               
   
                  
                  
              </div> <!-- modal body -->
              <div class="modal-footer"> <button data-dismiss="modal" id="btnEnrollOldStudent" class="btn btn-primary" href="#">Confirm</button> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
                  
                 
            </div> 
    
    
    

<?php

include 'adminfooter.php';

?>
    
    
    
<script type="text/javascript">
     
        $("#btnEnrollOldStudent").click(function(e){
            
            
            var StudentIDDisplay = $("#ModalStudentIDDisplay").val();
            
            var StudentDetails = { StudentIDDisplay: StudentIDDisplay };
            
            
            /* $.ajax({
                    type:'POST',
                    url:'EnrollmentOldVerify.php',
                    data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                    success:function(html){
                                 
                        window.location.href="/iucsenrollmentsystem/webpages/EnrollmentPhase1Old.php";
                                   
                    
                     }, // After Ajax Submit
                       
                     error: function(request, error) {
                            
                                 $.gritter.add({
			                         title: 'Operation Failed!',
			                         text: 'Student ID entered does not exist! Please try again.',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 $(".gritter-item").css("background","#ff0000");
        
                        }
                });
            
            */
            
            $.ajax({
                    type:'POST',
                    url:'EnrollmentOldVerify.php',
                    data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                    success:function(html){
                                 
                       
                        $.ajax({
                                type:'POST',
                                url:'VerifyIfEnrolled.php',
                                data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                                success:function(html){
                                 
                                        window.location.href="/iucsenrollmentsystem/webpages/EnrollmentPhase1Old.php";
                                   
                    
                        }, // After Ajax Submit
                       
                        error: function(request, error) {
                                
                                 $.gritter.add({
			                         title: 'Operation Failed!',
			                         text: 'Student is already enrolled for this school year',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 $(".gritter-item").css("background","#ff0000");
        
                        }
                    });
                        
                        
                        
               
                     }, // After Ajax Submit
                       
                     error: function(request, error) {
                            
                                 $.gritter.add({
			                         title: 'Operation Failed!',
			                         text: 'Student ID entered does not exist! Please try again.',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 $(".gritter-item").css("background","#ff0000");
        
                        }
                });
            
            
        });
</script>
    
    
    
    </body>
</html>
    
    
    
    
    
    
    
    
    