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
                 <div class="widget-title"> 
                  <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#tab4">By Mode of Payment</a></li>
           
            </ul>
                
                 </div>
         
 <div class="widget-content tab-content">
                  
 
<div id="tab4" class="tab-pane active">
         
    <form action="ModeOfPaymentAlphabeticalReport.php" method="post">
             <!-- Row 1 -->
             <div class="row-fluid">
                 <div class="span3"></div>
                 
                <div class="span3">
                   <label class="control-label">*From Grade Level</label>
              
                 <div class="controls">
                <select name="GradeLevelFrom" id="GradeLevelFrom">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel ORDER BY GradeLevel ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected .'>' . $data['GradeLevel'] . '</option>';
        
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
                 
                 
                 
                  <div class="span3">
                   <label class="control-label">*To Grade Level</label>
              
                 <div class="controls">
                <select name="GradeLevelTo" id="GradeLevelTo">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel ORDER BY GradeLevel ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           echo '<option value ="' . $data['GradeLevelID'] . '" '. $selected .'>' . $data['GradeLevel'] . '</option>';
        
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
        <!-- Row 1 End -->
             
             
            
        
        <br>
             
               <!-- Row 2 -->
             <div class="row-fluid">
                 <div class="span3"></div>
                 
                <div class="span3">
                   <label class="control-label">*From Mode Of Payment</label>
              
                 <div class="controls">
                <select name="ModeOfPaymentFrom" id="ModeOfPaymentFrom">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblpaymentoption ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['PaymentOptionID'] . '" '. $selected .'>' . $data['PaymentOptionName'] . '</option>';
        
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
                 
                 
                 
                  <div class="span3">
                   <label class="control-label">*To Mode of Payment</label>
              
                 <div class="controls">
                <select name="ModeOfPaymentTo" id="ModeOfPaymentTo">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblpaymentoption ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['PaymentOptionID'] . '" '. $selected .'>' . $data['PaymentOptionName'] . '</option>';
        
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
            
                
                     
           
            
             </div> <!-- row 2 --> 
             <br>
             <div class="row-fluid">
                 <div class="span4"></div>
                 <div class="span4" style="margin-left: 100px;">
                     <button class="btn btn-success" >Generate Report</button>
                    
                 </div>
                 
             </div>
    
        
        </form>
</div> <!-- tab 4 -->


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