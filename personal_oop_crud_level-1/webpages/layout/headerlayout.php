<!DOCTYPE html>
<html lang="en">
<head>
<title>PHP OOP CRUD AJAX</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="../css/bootstrap.min.css" />
<link rel="stylesheet" href="../css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="../css/colorpicker.css" />
<link rel="stylesheet" href="../css/datepicker.css" />
<link rel="stylesheet" href="../css/uniform.css" />
<link rel="stylesheet" href="../css/select2.css" />
<link rel="stylesheet" href="../css/fullcalendar.css" />
<link rel="stylesheet" href="../css/matrix-style.css" id="matrixstyle" />
<link rel="stylesheet" href="../css/matrix-media.css" />
<link rel="stylesheet" href="../css/bootstrap-wysihtml5.css" />
<link href="../font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/jquery.gritter.css" />

<!--
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
-->
<link href="../layout/OpenSansFontFromInternet.css" rel="stylesheet" type="text/css" >
<!--
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
-->
<link href="../layout/buttons.dataTables.min.css" rel="stylesheet" >



<link href="../datetimepicker/bootstrap-datetimepicker-master/sample%2520in%2520bootstrap%2520v3/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../datetimepicker/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
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
  <h1><a href="#">PHP OOP CRUD AJAX</a></h1>
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
      
      
      
      
      
  
      
      
      
      
      
   
<!-- User Authorization For Maintenance -->
      <?php  
    
           echo ' <li class="submenu"> <a href="#"><i class="icon icon-wrench"></i> <span>Maintenance</span> <span class="label label-important"></span></a>
      <ul>
        <li><a href="DepartmentList.php">Department</a></li>  
        
      </ul>
    </li>';
      ?>
      
      
<!-- User Authorization For Maintenance End -->
      
      
   <li class="submenu"> <a href="#"><i class="icon icon-user"></i> <span>My Account</span> <span class="label label-important"></span></a>
      
        <ul>
           <li><a href="AccountChangePassword.php">Change Password</a></li>
       
       </ul>
    
      </li>
      
    
  </ul>
</div>
<!--sidebar-menu-->
