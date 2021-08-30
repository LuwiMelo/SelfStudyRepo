<?php

//include 'dbconnection.php';
session_start();




?>

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
                    
                    <!-- <span class="pull-left" style="margin-left: 10px;"><a href="LegacyDataYearSelection.php" class="flip-link btn btn-warning" id="to-recover">Legacy Data</a></span> -->
                    
                    
                    <span class="pull-right"><button type="submit" class="btn btn-success" /> Login</span>
                </div>
            </form>
        </div>
        
        <script src="js/jquery.min.js"></script>  
        <script src="js/matrix.login.js"></script> 
    

<?php


    
if(isset ($_SESSION['IsLoginFailed']) && $_SESSION['IsLoginFailed'] == true  ){
    
    echo '<script>alert("System Log-in failed!")</script>';
    
    $_SESSION['IsLoginFailed'] = false;
}
    

if(isset ($_SESSION['LogOutFromAddSY']) && $_SESSION['LogOutFromAddSY'] == true ){
        echo '<script>alert("You are logged out to process the newly added school year! Please log in again.")</script>';
    
    $_SESSION['LogOutFromAddSY'] = false;
    
    
}

   
  
?>
    
    </body>

</html>
