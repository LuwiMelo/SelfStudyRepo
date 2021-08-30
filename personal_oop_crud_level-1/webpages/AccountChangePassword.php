<?php 


session_start();


/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
*/

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


$UserID = $_SESSION['SessionUserID'];

$_SESSION['UserIDChangePassword'] = $UserID;
//Get general record of a student
try
{
 
    $statement = $dbh->prepare("SELECT * FROM tblusers WHERE UserID = $UserID");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
        
              $RetrieveUsername = $row['Username'];
          
        
    } 
    else {
   
       echo '<h1>Error in selecting from database </h1>';
    }

    
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}











?>

<!--main-container-part-->
<div id="content"> <!-- this div will have no end tag, end tag will be found in the admin footer page -->

  <div id="content-header">
    
  </div>



     <div class="container-fluid">
         <div class="row-fluid">
             <center><h1>Change Password</h1></center>
             <br>
             <br>
             <div class="span2">
             
             </div>
             <div class="span6">
                 
              <label class="control-label">Username</label>
              <div class="controls">
                <input disabled type="text" name="Username" id="Username" class="span10 m-wrap" placeholder="" value="<?php echo $RetrieveUsername; ?>" />
              </div>
                 
            
             <br>
                 
         <div class="control-group" id="PasswordControlGroup">
              <label class="control-label">*New Password :</label>
              <div class="controls">
                <input type="password" name="Password" id="Password" class="span11" placeholder="" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="PasswordError"  name="PasswordError">Password do not match</span>
              </div>
            </div>
                 
                 <br>
                 
         <div class="control-group" id="Password2ControlGroup">
              <label class="control-label">*Confirm Password :</label>
              <div class="controls">
                <input type="password" name="Password2" id="Password2" class="span11" placeholder="" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="Password2Error"  name="Password2Error">Password do not match</span>
              </div>
            </div>
             
             
                <br>
                 
                 <button class="btn btn-large btn-success pull-right" id="btnSaveChanges">Save Changes</button>
                 
                 
                 
                 <br>
                 <br>
                 <br>
                 <br>
                 <br>
                 
                 
                 
                 
             </div>
             
             
         </div>
         
    </div> <!-- end of container fluid -->
    


<?php

include 'adminfooter.php';

?>

<script type="text/javascript">

       $("#btnSaveChanges").click(function(e){
        if (confirm('Update password?')) {
            
              FormValidator = true;
            
              var Password = $("#Password").val();
              var Password2 = $("#Password2").val();
            
              if(Password == Password2){
                  
                   FormValidator = true;
              }
             
            
              else{
                  FormValidator = false;
                  $("#PasswordControlGroup").addClass("error");
                  $("#Password2ControlGroup").addClass("error");
                  $('#PasswordControlGroup').css('color', "#b94a48");
                  $('#Password2ControlGroup').css('color', "#b94a48");
                  $("#Password").css("border-color","#b94a48");
                  $("#Password2").css("border-color","#b94a48");
                  $("#Password").css("color","#b94a48");
                  $("#Password2").css("color","#b94a48");
                  $("#PasswordError").show();
                  $("#Password2Error").show();
                
                   
              }
            
            
            
                if(FormValidator){
                    
                    
                         var StudentDetails = { Password: Password };
                    
                    
                      $.ajax({
                            type:'POST',
                            url:'ChangePasswordSubmit.php',
                            data:{"RetrieveTransaction" : JSON.stringify(StudentDetails)},
                            success:function(html){
                                 
                                
                                    $("#Password").val("");
                                    $("#Password2").val("");
                                
                                    $("#PasswordControlGroup").removeClass("error");
                                    $('#PasswordControlGroup').css('color', "#333");
                                    $("#Password").css("border-color","#ccc");
                                    $("#Password").css("color","#333");
                                    $("#PasswordError").hide();
                                
                        
                                
                                    $("#Password2ControlGroup").removeClass("error");
                                    $('#Password2ControlGroup').css('color', "#333");
                                    $("#Password2").css("border-color","#ccc");
                                    $("#Password2").css("color","#333");
                                    $("#Password2Error").hide();
                                    
                                
                                
                                
                                
                                
                                
                                $.gritter.add({
			                         title: 'Operation Success!',
			                         text: 'Password successfully changed!',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 //$(".gritter-item").css("background","#ff0000");
                                   
                    
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
                else{
                    
                        document.documentElement.scrollTop = 0;
                 
              $.gritter.add({
			       title: 'Operation Failed!',
			       text: 'Password do not match!',
                   time: 6000,
			       image: 'img/demo/checkmark.png',
			       sticky: false,
                   position: 'center'
		      });	
                    
                $(".gritter-item").css("background","#ff0000");
                    
                    
                    
                    
                    
                    
                    
                }
            
            
        }
           
       });
    
</script>
    

    
    </body>
</html>
    
    
    
    
    
    
    
    
    