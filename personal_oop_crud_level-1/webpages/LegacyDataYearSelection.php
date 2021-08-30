<?php

include 'DataBaseConnectionFileNoLogInRequired.php';


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
            <form id="loginform" class="form-vertical" action="LegacyDataInitializer.php" method="post">
				 <div class="control-group normal_text"> <h3><img src="iucslogo.png" alt="Logo" height="150px" width="120px" /></h3> <h3>IUCS Enrollment System</h3></div>
                
                
    
             <div class="control-group" style="margin-left: 50px;">
              
              <div class="controls">
                  <label style="color: white; font-size: 16px;">*LEGACY DATA SCHOOL YEAR :</label>
                  <br>
                <select name="SchoolYear" id="SchoolYear" >

                                         <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblschoolyear WHERE SchoolYearID <> (SELECT SchoolYearID FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1)");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
           echo '<option value ="' . $data['SchoolYearID'] . '" '. $selected .'>' . $data['SchoolYear'] . '</option>';
        
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
              

                
                
                <div class="form-actions">
                    <span class="pull-left" style="margin-left: 10px;"><a href="login.php" class="flip-link btn btn-info" id="to-recover">Back to Login</a></span>
                    
                    
                    
                    <span class="pull-left" style="margin-left: 10px;"><button type="submit" class="btn btn-success" /> Enter Legacy Data</span>
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
    </body>

</html>
