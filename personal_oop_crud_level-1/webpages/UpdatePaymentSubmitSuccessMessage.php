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



?>

<!--main-container-part-->
<div id="content"> <!-- this div will have no end tag, end tag will be found in the admin footer page -->

  <div id="content-header">
    
  </div>



     <div class="container-fluid">
         <hr>
    <center>    <img  style="width: 800px; height: 150px;" src="phase1logo.png"> </center>
      <br>
          <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Notifications</h5>
          </div>
          <div class="widget-content">
            
            <div class="alert alert-success alert-block"> <a class="close" data-dismiss="alert" href="#">×</a>
              <center><h1 class="alert-heading">Payment Update Success!</h1></center>
                
            <h3>
               Payment has been successfully updated! 
                
                </h3>
              
            </div>
              
                 <div class="row-fluid">
                     <div class="span5"></div>
             
				     <!--<div class="span5" style="margin-top: 25px; margin-left: 150px; margin-bottom: 100px;">
       <a href="PrintStatementOfAccount.php" target="_blank"><button type="button" id="SubmitButton" class="btn btn-large btn-success">Generate SOA</button></a> -->
              
            
    
    </div>
                <br>
                <br>
                <br>
                     <br>
                     <br>
                     <br>
                     
            </div>
                   
          
           
         

          </div>
        </div>
         
         
         
         
         
         
    </div> <!-- end of container fluid -->
    
    

<?php

include 'adminfooter.php';

?>
    
    

    
    </body>
</html>
    
    
    
    
    
    
    
    
    