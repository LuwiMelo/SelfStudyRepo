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
          
              <li class="active"><a data-toggle="tab" href="#tab3">By Discount</a></li>

            </ul>
                
                 </div>
         
 <div class="widget-content tab-content">
                  
   
     
<div id="tab3" class="tab-pane active">
      <form action="DiscountAlphabeticalReport.php" method="post">
             
          
          
          <div class="row-fluid">
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From Grade Level</label>
              
                 <div class="controls">
                <select name="GradeLevelFrom" id="GradeLevelFrom">
                   
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel ");
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
    $statement = $dbh->prepare("SELECT * FROM tblgradelevel ");
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
          <br>
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          <!-- Row 1 -->
             <div class="row-fluid">
                 <div class="span3"></div>
                 
                <div class="span3">
                   <label class="control-label">*From Sibling Discount</label>
              
                 <div class="controls">
                <select name="SiblingFrom" id="SibingFrom">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 1  ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To Sibling Discount</label>
              
                 <div class="controls">
                <select name="SiblingTo" id="SiblingTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 1 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*From Academic Scholarship Discount</label>
              
                 <div class="controls">
                <select name="ASFrom" id="ASFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 2 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To Academic Scholarship Discount</label>
              
                 <div class="controls">
                <select name="ASTo" id="ASTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 2 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From Promotional Discount</label>
              
                 <div class="controls">
                <select name="PromotionalFrom" id="PromotionalFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 3 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To Promotional Discount</label>
              
                 <div class="controls">
                <select name="PromotionalTo" id="PromotionalTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 3 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
<div class="row-fluid">
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From Entrance Scholarship Discount</label>
              
                 <div class="controls">
                <select name="ESFrom" id="ESFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 4 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To Entrance Scholarship Discount:</label>
              
                 <div class="controls">
                <select name="ESTo" id="ESTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 4 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
          
          <div class="row-fluid">
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From Varsity Discount</label>
              
                 <div class="controls">
                <select name="VarsityFrom" id="VarsityFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 5 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To Varsity Discount</label>
              
                 <div class="controls">
                <select name="VarsityTo" id="VarsityTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 5 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
          
          <div class="row-fluid">
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From STS Discount</label>
              
                 <div class="controls">
                <select name="STSFrom" id="STSFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 6 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To STS Discount</label>
              
                 <div class="controls">
                <select name="STSTo" id="STSTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 6 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
          
          <div class="row-fluid">
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From Employee Discount</label>
              
                 <div class="controls">
                <select name="EmployeeFrom" id="EmployeeFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 9 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To Employee Discount</label>
              
                 <div class="controls">
                <select name="EmployeeTo" id="EmployeeTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 9 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
          

          <div class="row-fluid">
    <div class="span3"></div>
    <div class="span3">
                   <label class="control-label">*From BOT Discount</label>
              
                 <div class="controls">
                <select name="BOTFrom" id="BOTFrom">
                    <option value="0">None</option>
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 10 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
                   <label class="control-label">*To BOT Discount</label>
              
                 <div class="controls">
                <select name="BOTTo" id="BOTTo">
                    <option value="0">None</option>
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tbldiscounttype WHERE DiscountTypeDiscountCategoryID = 10 ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['DiscountTypeID'] . '" '. $selected .'>' . $data['DiscountType'] . '</option>';
        
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
          <br>
             <div class="row-fluid">
                 <div class="span4"></div>
                 <div class="span4" style="margin-left: 100px;">
                     <button class="btn btn-success" >Generate Report</button>
                    
                 </div>
                 
             </div>
    
        
        </form>   
    
    
    
    
</div> <!-- tab 3 -->
   
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