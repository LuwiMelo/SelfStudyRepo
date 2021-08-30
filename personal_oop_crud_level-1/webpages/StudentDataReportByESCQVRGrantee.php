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
            
              <li class="active"><a data-toggle="tab" href="#tab6">By ESC Grantee</a></li>
              
            </ul>
                
                 </div>
         
 <div class="widget-content tab-content">
                  
  
<div id="tab6" class="tab-pane active">
         

    
    <form action="ESCQVRAlphabeticalReport.php" method="post">
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
             
        
        
        <div class="row-fluid">
                 <div class="span3"></div>
                 
                <div class="span3">
                   <label class="control-label">*From Section</label>
              
                 <div class="controls">
                <select name="SectionFrom" id="SectionFrom">
                   <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblsection ORDER BY SectionName ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           echo '<option value ="' . $data['SectionID'] . '" '. $selected .'>' . $data['SectionName'] . '</option>';
        
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
                   <label class="control-label">*To Section</label>
              
                 <div class="controls">
                <select name="SectionTo" id="SectionTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblsection ORDER BY SectionName ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           echo '<option value ="' . $data['SectionID'] . '" '. $selected .'>' . $data['SectionName'] . '</option>';
        
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
        
        
        
               <!-- Row 2 -->
             <div class="row-fluid">
                 <div class="span5"></div>
                 
                <div class="span3" style="margin-left: -30px;">
                   <label class="control-label">*From ESC</label>
              
                 <div class="controls">
                <select name="ESCQVR" id="ESCQVR">
                   <option value="0">With ESC</option>
                   <option value="1">Without ESC</option>
    
                </select>
              </div>
                          
            </div>
                 
              
            
             </div> <!-- row 2 --> 
        
        
        <br>
        
        
             <br>
             <div class="row-fluid">
                 <div class="span4"></div>
                 <div class="span4" style="margin-left: 100px;">
                     <button class="btn btn-success" >Generate Report</button>
                    
                 </div>
                 
             </div>
    
        
        </form>

    
</div> 
     

                     
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