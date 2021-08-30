<?php
//Code For User Authentication For Each Web Page
session_start();
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}
include 'adminheader.php';


$dsn = 'mysql:host=localhost;dbname=iucs_ecra_db;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


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
              <li class="active"><a data-toggle="tab" href="#tab1">By Grade Level</a></li>
              <li><a data-toggle="tab" href="#tab2">By Strand</a></li>
              <li><a data-toggle="tab" href="#tab3">By Discount</a></li>
              <li><a data-toggle="tab" href="#tab4">By Mode of Payment</a></li>
              <li><a data-toggle="tab" href="#tab5">By Enrollment Status</a></li>
              <li><a data-toggle="tab" href="#tab6">By ESC/QVR Grantee</a></li>
              <li><a data-toggle="tab" href="#tab7">By School of Origin</a></li>
              <li><a data-toggle="tab" href="#tab8">By Reference Number</a></li>
              <li><a data-toggle="tab" href="#tab9">By Student Number</a></li>
            </ul>
                
                 </div>
         
 <div class="widget-content tab-content">
                  
    <div id="tab1" class="tab-pane active">

     
         <form action="GradeSectionAlphabeticalReport.php" method="post">
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
                   <label class="control-label">*From Section</label>
              
                 <div class="controls">
                <select name="SectionFrom" id="SectionFrom">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblsection ");
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
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblsection ");
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
            
                
                     
           
            
             </div> <!-- row 2 --> 
             <br>
<div class="row-fluid">

    
    <div class="span3"></div>
                 
                <div class="span3">
                   <label class="control-label">*From Gender:</label>
              
                 <div class="controls">
                <select name="GenderFrom" id="GenderFrom">
                   <option value="0">Boys</option>
                   <option value="1">Girls</option>
                </select>
              </div>
                          
            </div>
                 
                 
                 
                  <div class="span3">
                   <label class="control-label">*To Gender</label>
              
                 <div class="controls">
                <select name="GenderTo" id="GenderTo">
                   <option value="0">Boys</option>
                    <option value="1">Girls</option>
                </select>
              </div>
                  
                  
            
                      
            </div>
            
                

    
</div>
             <br>
             <div class="row-fluid">
                 <div class="span4"></div>
                 <div class="span4" style="margin-left: 100px;">
                     <button class="btn btn-success" >Generate Report</button>
                    
                 </div>
                 
             </div>
    
        
        </form>
        
        
        
              
      
             
                    
     </div>  <!-- tab 1 -->
     
<!-- tab 2 -->
     
<div id="tab2" class="tab-pane">
     
    <form action="StrandAlphabeticalReport.php" method="post">
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
                   <label class="control-label">*From Strand</label>
              
                 <div class="controls">
                <select name="StrandFrom" id="StrandFrom">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblstrand ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
           
           echo '<option value ="' . $data['StrandID'] . '" '. $selected .'>' . $data['StrandName'] . '</option>';
        
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
                   <label class="control-label">*To Strand</label>
              
                 <div class="controls">
                <select name="StrandTo" id="StrandTo">
                   
    <?php 
             try
{
    $statement = $dbh->prepare("SELECT * FROM tblstrand ");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
          
           echo '<option value ="' . $data['StrandID'] . '" '. $selected .'>' . $data['StrandName'] . '</option>';
        
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
    
    
</div> <!-- tab 2 -->
     
<div id="tab3" class="tab-pane">
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
                 <div class="span4"></div>
                 <div class="span4" style="margin-left: 100px;">
                     <button class="btn btn-success" >Generate Report</button>
                    
                 </div>
                 
             </div>
    
        
        </form>   
    
    
    
    
</div> <!-- tab 3 -->
     
<div id="tab4" class="tab-pane">
         
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

<!-- Tab 5 Tab 5 Tab 5 -->

<div id="tab5" class="tab-pane">
              
    <form action="EnrollmentStatusAlphabeticalReport.php" method="post">
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
                   <label class="control-label">*From Enrollment Status</label>
              
                 <div class="controls">
                <select name="EnrollmentStatusFrom" id="EnrollmentStatusFrom">
                   <option value="0">Enrolled</option>
                   <option value="1">Pulled-out</option>
    
                </select>
              </div>
                  
                        
            </div>
                 
                  
                  <div class="span3">
                   <label class="control-label">*To Enrollment Status</label>
              
                 <div class="controls">
                <select name="EnrollmentStatusTo" id="EnrollmentStatusTo">
                   <option value="0">Enrolled</option>
                   <option value="1">Pulled-out</option>
                </select>
              </div>
                    
                      
            </div>
            
                     
            
             </div> <!-- row 2 --> 
        
        
        
        <br>
        
        
               <!-- Row 3 -->
             <div class="row-fluid">
                 <div class="span3"></div>
                 
                <div class="span3">
                   <label class="control-label">*From Enrollment Update</label>
              
                 <div class="controls">
                <select name="EnrollmentUpdateFrom" id="EnrollmentUpdateFrom">
                   <option value="1">Admitted</option>
                   <option value="2">Dropped</option>
                   <option value="3">Transfer</option>
                   <option value="0">Pulled-out</option>
    
                </select>
              </div>
                  
                        
            </div>
                 
                  
                  <div class="span3">
                   <label class="control-label">*To Enrollment Update</label>
              
                 <div class="controls">
                <select name="EnrollmentUpdateTo" id="EnrollmentUpdateTo">
                   <option value="1">Admitted</option>
                   <option value="2">Dropped</option>
                   <option value="3">Transfer</option>
                   <option value="0">Pulled-out</option>
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
</div> 
     
<div id="tab6" class="tab-pane">
         
    
    
    
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
                   <label class="control-label">*From ESC/QVR</label>
              
                 <div class="controls">
                <select name="ESCQVR" id="ESCQVR">
                   <option value="0">With ESC/QVR</option>
                   <option value="1">Without ESC/QVR</option>
    
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
     
     
     <div id="tab7" class="tab-pane">
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