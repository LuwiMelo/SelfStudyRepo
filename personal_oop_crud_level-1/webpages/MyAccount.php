<?php 


session_start();


if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
include 'adminheader.php';






$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}




?>

<!--main-container-part-->
<div id="content"> <!-- this div will have no end tag, end tag will be found in the admin footer page -->

  <div id="content-header">
    
  </div>



     <div class="container-fluid">
         <div class="row-fluid">
             <center><h1>My Profile</h1></center>
             <br>
             <br>
             <div class="span2">
             
             </div>
             <div class="span6">
                    <label class="control-label">Username</label>
              <div class="controls">
                <input disabled type="text" name="Username" id="Username" class="span10 m-wrap" placeholder="e.g." value="" />
              </div>
             
             
             </div>
             
             
         </div>
         
    </div> <!-- end of container fluid -->
    


<?php

include 'adminfooter.php';

?>
    
    

    
    </body>
</html>
    
    
    
    
    
    
    
    
    