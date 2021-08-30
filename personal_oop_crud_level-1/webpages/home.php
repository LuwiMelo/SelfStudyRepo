<?php


//Code For User Authentication For Each Web Page
session_start();
/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}


$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost';
$user = 'root';
$password = '';

try {
     $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

*/
include 'DataBaseConnectionFile.php';

include 'adminheader.php';



//Get the latest school year
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare("SELECT SchoolYear,SchoolYearID FROM tblschoolyear ORDER BY SchoolYear DESC LIMIT 1");
    $statement->execute();
    $row = $statement->fetch();
    
    if (!empty($row)) {
          
          $LatestSchoolYear =  $row['SchoolYear'];
          $LatestSchoolYearID =  $row['SchoolYearID'];
          
    } 
    else {
   
       $LatestSchoolYear = "2019"; //I set school year 2019 as the default because this system is developed year 2019.
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





if(isset($_SESSION['SessionSelectedSchoolYearID'])){
    
    $LatestSchoolYearID = $_SESSION['SessionSelectedSchoolYearID'];
    $LatestSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
}




/* Enrollees per grade level query // Enrolles Per Grade Level Query */

$EnrolleesPerGradeLevelQuery = "";
$EnrolleesPerGradeLevelEchoVariable = "";

$EnrolleesPerGradeLevelQuery = "SELECT COUNT(AdmissionStudentID) AS 'AdmissionCount', AdmissionGradeLevelId, GradeLevel FROM tblstudentadmission, tblgradelevel WHERE GradeLevelID = AdmissionGradeLevelID AND AdmissionStatus = 2 AND AdmissionSchoolYearID = $LatestSchoolYearID AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear GROUP BY AdmissionGradeLevelID ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($EnrolleesPerGradeLevelQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
                
           
                $EnrolleesPerGradeLevelEchoVariable .= " { y: '".substr($data['GradeLevel'],4)."', a:  ".$data['AdmissionCount']."},";
              
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



// TOTAL NUMBER OF OFFICIAL ENROLLEES--TOTAL NUMBER OF OFFICIAL ENROLLEES -- TOTAL NUMBER OF OFFICIAL ENROLLEES //

    
$TotalOfficialEnrolleesQuery = "";
$TotalOfficialEnrolleesEchoVariable = "";

$TotalOfficialEnrolleesQuery = "SELECT COUNT(`AdmissionID`) AS 'TotalEnrollees' FROM tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearID and AdmissionID IN (SELECT DISTINCT PaymentAdmissionID FROM tblpaymenttransactions WHERE PaymentSchoolYearID = $LatestSchoolYearID)  AND AdmissionStatus = 2  ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($TotalOfficialEnrolleesQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $TotalOfficialEnrolleesEchoVariable .= " {label: 'Official Enrollees', value: ".$data['TotalEnrollees']." },";
              
    }
    } 
    else {
   
      // $LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





// TOTAL NUMBER OF REGISTERED ONLY ENROLLEES--TOTAL NUMBER OF REGISTERED ONLY ENROLLEES -- TOTAL NUMBER OF REGISTERED ONLY ENROLLEES //

    
$TotalRegisteredOnlyEnrolleesQuery = "";
$TotalRegisteredOnlyEnrolleesEchoVariable = "";

$TotalRegisteredOnlyEnrolleesQuery = "SELECT COUNT(`AdmissionID`) AS 'TotalEnrollees' FROM tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearID AND AdmissionID NOT IN (SELECT DISTINCT PaymentAdmissionID FROM tblpaymenttransactions WHERE PaymentSchoolYearID = $LatestSchoolYearID)";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($TotalRegisteredOnlyEnrolleesQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $TotalRegisteredOnlyEnrolleesEchoVariable .= " {label: 'Registered-Only', value: ".$data['TotalEnrollees']." },";
              
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}





// TOTAL RE ENROLLEES QUERY TOTAL RE ENROLLEES QUERY TOTAL RE ENROLLEES QUERY TOTAL RE ENROLLEES QUERY //

    
$TotalReenrolleesQuery = "";
$TotalReenrolleesEchoVariable = "";


$LatestSchoolYearIDMinusOne = $LatestSchoolYearID - 1 ;
$LatestSchoolYearMinusOne = $LatestSchoolYear - 1;

$TotalReenrolleesQuery = "SELECT COUNT(`AdmissionID`) AS 'TotalEnrollees' FROM tblstudentadmission WHERE AdmissionStudentID IN (SELECT AdmissionStudentID FROM tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearIDMinusOne OR LEFT(AdmissionReferenceNum,4) = $LatestSchoolYearMinusOne  )  AND AdmissionSchoolYearID = $LatestSchoolYearID AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear AND AdmissionStatus = 2    ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($TotalReenrolleesQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $TotalReenrolleesEchoVariable .= " {label: 'Re-enrollees', value: ".$data['TotalEnrollees']." },";
              
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}



// TOTAL PENDING STUDENTS TOTAL PENDING STUDENTS TOTAL PENDING STUDENTS - STUDENTS ENROLLED LAST SY BUT NOT YET ENROLLED //

    
$TotalPendingQuery = "";
$TotalPendingEchoVariable = "";



$TotalPendingQuery = "SELECT COUNT(AdmissionStudentID) AS 'TotalPending' FROM tblstudentadmission WHERE AdmissionStudentID NOT IN (SELECT AdmissionStudentID FROM tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearID and LEFT(AdmissionReferenceNum,4) = $LatestSchoolYear AND AdmissionStatus = 2  ) AND LEFT(AdmissionReferenceNum,4) = $LatestSchoolYearMinusOne AND AdmissionSchoolYearID = $LatestSchoolYearIDMinusOne AND AdmissionStudentID NOT IN (SELECT AdmissionStudentID FROM tblstudentadmission WHERE AdmissionSchoolYearID = $LatestSchoolYearIDMinusOne AND AdmissionGradeLevelID = 15)  ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($TotalPendingQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $TotalPendingEchoVariable .= " {label: 'For Follow-up', value: ".$data['TotalPending']." },";
              
    }
    } 
    else {
   
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}








// TOTAL ENROLLEES LAST SEVEN DAYS TOTAL ENROLLEES LAST SEVEN DAYS TOTAL ENROLLEES LAST SEVEN DAYS TOTAL ENROLLEES LAST SEVEN DAYS//

    
$LastSevenDaysQuery = "";
$LastSevenDaysEchoVariable = "";



$LastSevenDaysQuery = "SELECT COUNT(MainTable.TotalEnrollees) AS 'FinalTotalEnrollees' FROM (SELECT COUNT(PaymentAdmissionID) AS 'TotalEnrollees',MIN(DateOfPayment) AS 'DateEnrolled'
FROM tblpaymenttransactions
WHERE `PaymentSchoolYearID` = $LatestSchoolYearID 
GROUP BY PaymentAdmissionID
HAVING MIN(DateOfPayment)  BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND NOW()) AS MainTable ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($LastSevenDaysQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $LastSevenDaysEchoVariable = " { y: 'Last 7 days', a: ".$data['FinalTotalEnrollees']." },";
              
        // { y: '2006', a: 100},
    }
    } 
    else {
          $LastSevenDaysEchoVariable = "{ y: 'Last 7 days', a: 0},";
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}







// TOTAL ENROLLEES LAST FOURTEEN DAYS TOTAL ENROLLEES LAST FOURTEEN DAYS TOTAL ENROLLEES LAST FOURTEEN DAYS TOTAL ENROLLEES LAST FOURTEEN DAYS//

    
$LastFourteenDaysQuery = "";
$LastFourteenDaysEchoVariable = "";



$LastFourteenDaysQuery = "SELECT COUNT(MainTable.TotalEnrollees) AS 'FinalTotalEnrollees' FROM (SELECT COUNT(PaymentAdmissionID) AS 'TotalEnrollees',MIN(DateOfPayment) AS 'DateEnrolled'
FROM tblpaymenttransactions
WHERE `PaymentSchoolYearID` = $LatestSchoolYearID 
GROUP BY PaymentAdmissionID
HAVING MIN(DateOfPayment)  BETWEEN DATE_SUB(CURDATE(), INTERVAL 14 DAY) AND DATE_SUB(CURDATE(), INTERVAL 8 DAY)) AS MainTable ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($LastFourteenDaysQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $LastFourteenDaysEchoVariable = " { y: 'Last 14 days', a: ".$data['FinalTotalEnrollees']." },";
              
        // { y: '2006', a: 100},
    }
    } 
    else {
          $LastFourteenDaysEchoVariable = "{ y: 'Last 14 days', a: 0},";
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




// TOTAL ENROLLEES LAST TWENTY ONE DAYS TOTAL ENROLLEES LAST TWENTY ONE  DAYS TOTAL ENROLLEES LAST TWENTY ONE DAYS TOTAL ENROLLEES LAST TWENTY ONE DAYS//

    
$LastTwentyOneDaysQuery = "";
$LastTwentyOneDaysEchoVariable = "";



$LastTwentyOneDaysQuery = "SELECT COUNT(MainTable.TotalEnrollees) AS 'FinalTotalEnrollees' FROM (SELECT COUNT(PaymentAdmissionID) AS 'TotalEnrollees',MIN(DateOfPayment) AS 'DateEnrolled'
FROM tblpaymenttransactions
WHERE `PaymentSchoolYearID` = $LatestSchoolYearID 
GROUP BY PaymentAdmissionID
HAVING MIN(DateOfPayment) BETWEEN DATE_SUB(CURDATE(), INTERVAL 21 DAY) AND DATE_SUB(CURDATE(), INTERVAL 15 DAY)) AS MainTable ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($LastTwentyOneDaysQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $LastTwentyOneDaysEchoVariable = " { y: 'Last 21 days', a: ".$data['FinalTotalEnrollees']." },";
              
        // { y: '2006', a: 100},
    }
    } 
    else {
          $LastTwentyOneDaysEchoVariable = "{ y: 'Last 21 days', a: 0},";
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




// TOTAL ENROLLEES LAST TWENTY EIGHT DAYS TOTAL ENROLLEES LAST TWENTY EIGHT  DAYS TOTAL ENROLLEES LAST TWENTY EIGHT DAYS TOTAL ENROLLEES LAST TWENTY EIGHT DAYS//

    
$LastTwentyEightDaysQuery = "";
$LastTwentyEightDaysEchoVariable = "";



$LastTwentyEightDaysQuery = "SELECT COUNT(MainTable.TotalEnrollees) AS 'FinalTotalEnrollees' FROM (SELECT COUNT(PaymentAdmissionID) AS 'TotalEnrollees',MIN(DateOfPayment) AS 'DateEnrolled'
FROM tblpaymenttransactions
WHERE `PaymentSchoolYearID` = $LatestSchoolYearID 
GROUP BY PaymentAdmissionID
HAVING MIN(DateOfPayment) BETWEEN DATE_SUB(CURDATE(), INTERVAL 28 DAY) AND  DATE_SUB(CURDATE(), INTERVAL 22 DAY)) AS MainTable ";
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($LastTwentyEightDaysQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    $RunningTotal = 0;
    $Blank = "";
    
    if (!empty($row)) {
        
    foreach($row as $data){
      
               
           
                $LastTwentyEightDaysEchoVariable = " { y: 'Last 28 days', a: ".$data['FinalTotalEnrollees']." },";
              
        // { y: '2006', a: 100},
    }
    } 
    else {
          $LastTwentyEightDaysEchoVariable = "{ y: 'Last 28 days', a: 0},";
       //$LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}




?>
<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb"> <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Dashboard</a></div>
  </div>
<!--End-breadcrumbs-->

<!--Action boxes-->
  <div class="container-fluid">
        <hr>
    <center>    <img  style="width: 800px; height: 150px;" src="phase1logo.png"> </center>
      <br>
 <center><h1>Enrollment System Dashboard </h1></center>
      
      
    <br>
      
  <center><h1><?php 
      
      $SelectedSchoolYear = $_SESSION['SessionSelectedSchoolYear'];
      $SelectedSchoolYearPlusOne = $SelectedSchoolYear + 1;
      
       echo 'S.Y. '.$SelectedSchoolYear.' - '.$SelectedSchoolYearPlusOne;
      
      ?>  </h1></center>
      
      
      <div class="row-fluid">
      
              <div class="span12">
        <div class="widget-box" style="overflow-x:scroll; overflow-y:hidden;">
          <div class="widget-title" > <span class="icon"> <i class="icon-list"></i> </span>
            <h5>Official Enrollees Per Grade Level </h5>
          </div>
          <div class="widget-content" > 
                        <div class="panel-body">
                                    <div id="morris-bar-example" ></div>
                        </div>
            
                            <br>
              <br>
          </div>
        </div>
      </div>
      
      
      </div>
      
      
            <div class="row-fluid">
      
              <div class="span12">
        <div class="widget-box" style="overflow-x:scroll; overflow-y:hidden;">
          <div class="widget-title" > <span class="icon"> <i class="icon-list"></i> </span>
            <h5>Enrollees Per Week </h5>
          </div>
          <div class="widget-content" > 
                        <div class="panel-body">
                                    <div id="morris-area-example" style="height: 300px;"></div>
                        </div>
            
                            <br>
              <br>
          </div>
        </div>
      </div>
      
      
      </div>
      
      
      
      
<div class="row-fluid">
      
              <div class="span6">
        <div class="widget-box" style="overflow-x:scroll; overflow-y:hidden;">
          <div class="widget-title" > <span class="icon"> <i class="icon-list"></i> </span>
            <h5>Official Enrollees versus Registered-only Enrollees </h5>
          </div>
          <div class="widget-content" > 
                        <div class="panel-body">
                                    <div id="morris-donut-example" style="height: 300px;"></div>
                        </div>
            
                            <br>
              <br>
          </div>
        </div>
      </div>
    
    
                  <div class="span6">
        <div class="widget-box" style="overflow-x:scroll; overflow-y:hidden;">
          <div class="widget-title" > <span class="icon"> <i class="icon-list"></i> </span>
            <h5>Re-enrollees versus Students Last S.Y. Not Yet Enrolled</h5>
          </div>
          <div class="widget-content" > 
                        <div class="panel-body">
                                    <div id="morris-donut-example2" style="height: 300px;"></div>
                        </div>
            
                            <br>
              <br>
          </div>
        </div>
      </div>
    
    <div id="data"></div>
      
</div>
      
      
                        
  </div>
</div>

<!--end-main-container-part-->

<?php 

include 'EnrollmentPhase2Footer.php';

?>


 
        
        <script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
        <script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>       
     

        <!-- START TEMPLATE -->

        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>
        
      


<script type="text/javascript">
    
    
    $(document).ready(function () {
        $('head').append('<link rel="stylesheet" href="morriscss.css" type="text/css" />');
        
        console.log("<?php echo $TotalPendingQuery; ?>");
        
        console.log("<?php echo $LastSevenDaysEchoVariable; ?>");
          console.log("<?php echo $LastFourteenDaysEchoVariable; ?>");
          console.log("<?php echo $LastTwentyOneDaysEchoVariable; ?>");
          console.log("<?php echo $LastTwentyEightDaysEchoVariable; ?>");
    });
    
    
    
     Morris.Bar({
        element: 'morris-bar-example',
        data: [
            <?php echo $EnrolleesPerGradeLevelEchoVariable; ?>
            /*
              { y: 'Pre-Kinder 1', a: 75 },
              { y: 'Pre-Kinder 2', a: 75 },
              { y: 'Kinder', a: 75 },
            { y: 'Grade 1', a: 200 },
            { y: 'Grade 2', a: 75 },
            { y: 'Grade 3', a: 50 },
            { y: 'Grade 3', a: 75 },
            { y: 'Grade 4', a: 50 },
            { y: 'Grade 5', a: 75},
              { y: 'Grade 6', a: 75},
              { y: 'Grade 7', a: 75 },
              { y: 'Grade 8', a: 75},
              { y: 'Grade 9', a: 75 },
              { y: 'Grade 10', a: 75 },
              { y: 'Grade 11', a: 75},
              { y: 'Grade 12', a: 100 }
              
              */
        ],
        xkey: 'y',
        ykeys: 'a',
        labels: ['Enrollees',],
        //barColors: ['#62f442', '#FEA223', '#418ff4', '#1caf9a'],
         xLabelMargin: 10,
          padding: 40,
         xLabelAngle: 90,
         barColors: function(row, series, type) {
                if(series.key == 'a'){
                        if(row.y >= 100){
                            return "green";
                        }
                        else if(row.y < 81 && row.y > 50){
                            return "blue"; 
                        }
                        else if(row.y <= 51){
                            return "#FEA223"; 
                        }
                        else if(row.y < 10){
                            return "red"; 
                        }
                        else{
                            return "red";
                        }
                }
                else{
                    return "green";
                }
         }
    });
    
 
    
    
    
    Morris.Area({
        element: 'morris-area-example',
        data: [
            
            /*
            { y: '2006', a: 100},
            { y: '2007', a: 75 },
            { y: '2008', a: 50 },
            { y: '2009', a: 75},
            { y: '2010', a: 50},
            { y: '2011', a: 75 },
            { y: '2012', a: 100 }
            */
       
     
                 <?php echo $LastTwentyEightDaysEchoVariable; ?>
            
            <?php echo $LastTwentyOneDaysEchoVariable; ?>
            
       
            
                   <?php echo $LastFourteenDaysEchoVariable;  ?>
            
             <?php 
            
            echo $LastSevenDaysEchoVariable; 
            
            
            ?>
            
       
            

        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Total Enrollees'],
        resize: true,
        lineColors: ['#1caf9a', '#FEA223'],
        parseTime: false
    });

    
    
     Morris.Donut({
        element: 'morris-donut-example',
        data: [
            
            <?php echo $TotalOfficialEnrolleesEchoVariable; ?>
            <?php echo $TotalRegisteredOnlyEnrolleesEchoVariable; ?>
            
            /*
            {label: "Download Sales", value: 12},
            {label: "In-Store Sales", value: 30},
            {label: "Mail-Order Sales", value: 20}
            */
            
            
        ],
        colors: ['#95B75D', '#1caf9a', '#FEA223']
    });
    
    
    Morris.Donut({
        element: 'morris-donut-example2',
        data: [
            
     
            
            <?php echo $TotalReenrolleesEchoVariable; ?>
            <?php echo $TotalPendingEchoVariable; ?>
            /*
            {label: "Download Sales", value: 12},
            {label: "In-Store Sales", value: 30},
            {label: "Mail-Order Sales", value: 20}
            
            */
            
        ],
        colors: ['#95B75D', '#1caf9a', '#FEA223'],
        
    }).on('click', function (i, row) {  
    // Do your actions
    // Example:
                redirectFunction1(i, row);
        });
    
    
function redirectFunction1(i, row) {
        //$('#data').html(row.label + ": " + row.value);
        //alert("Nice try");
    
    if(row.label == "For Follow-up"){
        window.location.href = "ForFollowUpList.php";
    }
    else{
        window.location.href = "FinanceReenrolleesReport.php";
    }
}

</script>
</body>
</html>