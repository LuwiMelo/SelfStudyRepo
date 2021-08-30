<?php


//include 'DataBaseConnectionFile.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Enrollment System</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/colorpicker.css" />
<link rel="stylesheet" href="css/datepicker.css" />
<link rel="stylesheet" href="css/uniform.css" />
<link rel="stylesheet" href="css/select2.css" />
<link rel="stylesheet" href="css/fullcalendar.css" />
<link rel="stylesheet" href="css/matrix-style.css" id="matrixstyle" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link rel="stylesheet" href="css/bootstrap-wysihtml5.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="css/jquery.gritter.css" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
  
<link href="datetimepicker/bootstrap-datetimepicker-master/sample%2520in%2520bootstrap%2520v3/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="datetimepicker/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<!--<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"> -->
<!--
<link href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css" rel="stylesheet" type='text/css'>
-->
<!--
<link href="https://cdn.datatables.net/tabletools/2.2.4/css/dataTables.tableTools.css" rel="stylesheet" type='text/css'>
<link href="https://cdn.datatables.net/tabletools/2.0.0/css/TableTools_JUI.css" rel="stylesheet" type='text/css'> -->

</head> 
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="dashboard.html">Enrollment System</a></h1>
</div>
<!--close-Header-part--> 


<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    
    <!--
    <li  class="dropdown" id="profile-messages" ><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text">Welcome User</span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="#"><i class="icon-user"></i> My Profile</a></li>
        <li class="divider"></li>
       
        <li><a href="login.html"><i class="icon-key"></i> Log Out</a></li>
      </ul>
    </li>

    -->
    <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-book"></i> <span class="text">School Year</span>  <b class="caret"></b></a>
      <ul class="dropdown-menu">
                     <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblschoolyear ORDER BY SchoolYear DESC");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
        
            
            
            echo '<div style="margin-top: -20px;"><li>&nbsp;&nbsp;&nbsp; <form action="LegacyDataInitializer.php" method="post"> <input type="hidden" value="'.$data['SchoolYearID'].'" name="LegacyDataSYID"><a class="sAdd" title=""  onclick="$(this).closest(\'form\').submit();"><i class="icon-book"></i>&nbsp;&nbsp;&nbsp;'.$data['SchoolYear'].'</a>
            </form>
            </li> 
        <li class="divider"></li> </div>';
        
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


                                                        
//echo '</form>';

                                                        
                     ?> 


      </ul>
    </li>

    <li class=""><a title="" href="systemlogout.php"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->
<!--start-top-serch-->
<div id="search">
  <input type="text" placeholder="Search here..."/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</div>
<!--close-top-serch-->
<!--sidebar-menu-->
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> </a>
  <ul>
      
      
<!-- User Authorization For Dashboard -->
    <?php 
            echo '<li class="active"><a href="home.php"><i class="icon icon-bar-chart"></i> <span>Dashboard</span></a> </li>';

      
      ?>
   
<!-- User Authorization For Dashboard End -->
      
      
      
      
      
      
      
<!-- User Authorization For Enrollment Transaction -->
    <?php if($_SESSION['SessionUserPositionLevel'] == 1 || $_SESSION['SessionUserPositionLevel'] == 3 ){
    
    
       
    } ?>
      
<!-- User Authorization For Enrollment Transaction End -->
      
      
      
      
      
   
<!-- User Authorization For Maintenance -->
      <?php  if($_SESSION['SessionUserPositionLevel'] == 1){
    
           echo ' <li class="submenu"> <a href="#"><i class="icon icon-wrench"></i> <span>Maintenance</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="UserList.php">Users</a></li>  
        <li><a href="NationalityList.php">Nationality</a></li>
        <li><a href="ReligionList.php">Religion</a></li>
        <li><a href="GradeLevelList.php">Grade Level and Fees</a></li>
        <li><a href="SectionList.php">Section</a></li>
        <li><a href="StrandList.php">Strands</a></li>
        <li><a href="ModeOfPaymentList.php">Mode Of Payment</a></li>
        <li><a href="DiscountList.php">Discounts</a></li>
        <li><a href="SchoolYearList.php">School Year</a></li>
        
      </ul>
    </li>';
      }?>
      
      
<!-- User Authorization For Maintenance End -->
      
      
      
      
      
      
      
      
 <!-- User Authorization For Admission Phase 1 and Phase 2 -->
      <?php  if($_SESSION['SessionUserPositionLevel'] != 4 && $_SESSION['SessionUserPositionLevel'] != 7 ){
    
    
       if($_SESSION['SessionUserPositionLevel'] == 1 || $_SESSION['SessionUserPositionLevel'] == 2 || $_SESSION['SessionUserPositionLevel'] == 3 || $_SESSION['SessionUserPositionLevel'] == 5 || $_SESSION['SessionUserPositionLevel'] == 6  ){
              echo '<li> <a href="EnrollmentPrePhase1Initializer.php"><i class="icon icon-book"></i> <span>Enroll Student</span> <span class="label label-important"></span></a> </li>';
           
        }
    
    
    
    
    
             echo '<li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Registration List</span> <span class="label label-important"></span></a>
      <ul>';
    
     
        echo ' <li><a href="ForInterviewList.php">Transferees List</a></li> <li><a href="ReEnrolleesList.php">Re-Enrollees List</a></li> 
      </ul>
      </li>';
    
    
      }?>
      
      
<!-- User Authorization For Admission Phase 1 and Phase 2 -->
      
      
      
      

      
      
           <?php  if($_SESSION['SessionUserPositionLevel'] == 6 || $_SESSION['SessionUserPositionLevel'] == 1  ){
    
    
  
            //  echo '<li> <a href="TeacherAssignment.php"><i class="icon icon-th-list"></i> <span>Teacher Assignment</span> <span class="label label-important"></span></a> </li>';
           
        
      
            }
      
      
      ?>
      
      
      
      
      
      
<!-- User Authorization For Sectioning and Assignment For Principal and Admin Only -->
      <?php  if($_SESSION['SessionUserPositionLevel'] == 1 || $_SESSION['SessionUserPositionLevel'] ==  6 ){
    
             echo '<li> <a href="SectioningList.php"><i class="icon icon-sitemap"></i> <span>Sectioning and Assignment</span> <span class="label label-important"></span></a> </li>
      ';
    
       
  
    
    
      }?>
      
      
<!-- User Authorization For Sectioning and Assignment For Principal and Admin Only -->
      
      
      
      
      
      
<!-- User Authorization For Sectioning and Assignment For Supervisors ONLY -->
      <?php  if($_SESSION['SessionUserPositionLevel'] ==  4 ){
    
             echo '<li> <a href="SectioningListPerDept.php"><i class="icon icon-sitemap"></i> <span>Sectioning Per Department</span> <span class="label label-important"></span></a> </li>
      ';
    
       
  
    
    
      }?>
      
      
<!-- User Authorization For Sectioning and Assignment For Supervisors ONLY -->
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      

 <!-- User Authorization For Admission Phase 3 -->
      <?php  if($_SESSION['SessionUserPositionLevel'] == 1 || $_SESSION['SessionUserPositionLevel'] == 3){
    
    
    
    //echo '<li class="submenu"> <a href="#"><i class="icon icon-money"></i> <span>Initial Payment</span> <span class="label label-important"></span></a><ul>';
    
       
    //echo ' <li><a href="PaymentTransfereesList.php">Transferees</a></li><li><a href="PaymentReEnrolleesList.php">Re-Enrollees</a></li> </ul> </li>';
    
    echo '<li> <a href="NewInitialPaymentList.php"><i class="icon icon-money"></i> <span>Initial Transactions</span> <span class="label label-important"></span></a> </li>
      ';
    
    
    
    
     //echo '<li class="submenu"> <a href="#"><i class="icon icon-money"></i> <span>Succeeding Payment</span> <span class="label label-important"></span></a><ul>';
    
       
    //echo ' <li><a href="SucPaymentTransfereesList.php">Transferees</a></li><li><a href="SucPaymentReEnrolleesList.php">Re-Enrollees</a></li> </ul></li>';
    
        echo '<li> <a href="NewSucceedingPaymentList.php"><i class="icon icon-money"></i> <span>Succeeding Transactions</span> <span class="label label-important"></span></a> </li>
      ';
    
    
             echo '<li> <a href="UpdateTransactions.php"><i class="icon icon-money"></i> <span>Update Transactions</span> <span class="label label-important"></span></a> </li>
      ';
    
    
    
    
    
    
    
      }?>
      
      
<!-- User Authorization For Admission Phase 3 -->
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
      
    <li class="submenu"> <a href="#"><i class="icon  icon-folder-close"></i> <span>Reports</span> <span class="label label-important"></span></a>
      <ul>
          
        <?php 
          
          if($_SESSION['SessionUserPositionLevel'] >= 1 && $_SESSION['SessionUserPositionLevel'] != 7 )
          {
              echo '<li><a href="StudentDataReportInitializer.php">Student Data Report</a></li>';
          }
          
         if($_SESSION['SessionUserPositionLevel'] == 7 || $_SESSION['SessionUserPositionLevel'] == 4  )
          {
              echo '<li><a href="TeacherMyStudents.php">My Students</a></li>';
          }
          
          
        ?>
          
          
        
        <?php if($_SESSION['SessionUserPositionLevel'] == 1 || $_SESSION['SessionUserPositionLevel'] == 3 ){
              echo '<li><a href="EnrolleesDataReport.php">Enrollees Per Grade Level Report</a></li>';
              echo '<li><a href="FinanceReenrolleesReport.php">Re-enrollees Report (Unofficial)</a></li>';
              echo '<li><a href="FinanceTransfereesReport.php">Transferees Report (Unofficial)</a></li>';
              echo '<li><a href="FinancialCertificateEligibleList.php">Financial Certificate</a></li>';
        }
          
                 if($_SESSION['SessionUserPositionLevel'] == 1 || $_SESSION['SessionUserPositionLevel'] == 2 || $_SESSION['SessionUserPositionLevel'] == 3)
              {
                  
              echo '<li><a href="CheckSOAList.php">Statement of Account Report</a></li>';
                  
              }
          
        ?>
       
  
      </ul>
    </li>
  
      
   <li class="submenu"> <a href="#"><i class="icon icon-user"></i> <span>My Account</span> <span class="label label-important"></span></a>
      
        <ul>
           <li><a href="AccountChangePassword.php">Change Password</a></li>
       
       </ul>
    
      </li>
      
    
  </ul>
</div>
<!--sidebar-menu-->
