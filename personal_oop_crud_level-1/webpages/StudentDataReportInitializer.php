<?php
//Code For User Authentication For Each Web Page
session_start();

/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
*/
include 'DataBaseConnectionFile.php';
include 'adminheader.php';


/*
$dsn = 'mysql:host=localhost;dbname=iucs_ecra_db;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/

?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Student Data Report </h1></center>
     
      <hr>
     <div class="row-fluid">
         <div class="span12">
             <div class="widget-box">
                 <div class="widget-title"><span class="icon"><i class="icon-th"></i></span>
            <h5>Choose Report Type</h5>
                 </div>
         
 <div class="widget-content tab-content">
                  
  
     <form action="StudentDataReportSelect.php" method="post">
        <div class="row-fluid">
             <div class="span3"></div>
             <div class="span4">
                <label class="control-label">*Report Type</label>
                 
                  <div class="controls">
                      <select name="ReportType" id="ReportType">
                          <option value="1">By Grade Level</option>
                          <option value="2">By Strand</option>
                          <option value="3">By Discount</option>
                          <option value="4">By Mode of Payment</option>
                          <option value="5">By Enrollment Status</option>
                          <option value="6">By ESC Grantee</option>
                          <option value="7">By QVR Grantee</option> 
                          <option value="8">By Reference Number</option>
                          <option value="9">By Student Number</option>
                      </select>
                 </div>
            </div>
            
            <div class="span3">
            <button class="btn btn-success btn-md" style="margin-top: 25px;">Select Report</button>
            </div>
         </div>
     </form>

     <br>
     <br>
     <br>
     <br>
</div> <!-- widget content tab-content -->

             </div>
         </div>   
     </div>
     
 </div> <!-- container fluid end -->


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