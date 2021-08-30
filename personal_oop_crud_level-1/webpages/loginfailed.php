<?php

include 'dbconnection.php';
session_start();
session_destroy();

?>


<!DOCTYPE html>
<html lang="en">
    
<head>
        <title>IUCS Enrollment System</title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" href="css/matrix-login.css" />
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

    </head>
    <body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" action="checkCredentials.php" method="post">
				 <div class="control-group normal_text"> <h3><img src="iucslogo.png" alt="Logo" height="150px" width="120px" /></h3> <h3>IUCS Enrollment System</h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"> </i></span>
                            <input type="text" placeholder="Username" name="UserUsername" id="UserUsername"/>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span>
                            <input type="password" placeholder="Password" id="UserPassword" name="UserPassword" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left" style="margin-left: 10px;"><a href="EnrollmentPrePhase1.php" class="flip-link btn btn-info" id="to-recover">Enroll Student</a></span>
                    <span class="pull-right"><button type="submit" class="btn btn-success" /> Login</a></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
				
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
               
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form>
        </div>
        
        <script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 


<script>

$(document).ready( function() {
    alert("Login failed");
});


</script>
    </body>

</html>
