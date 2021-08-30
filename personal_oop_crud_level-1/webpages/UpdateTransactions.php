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



$dsn = 'mysql:host=localhost;dbname=iucs_ecra_db;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}


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




$DataTableQuery = "SELECT AdmissionID,PaymentID,StudentID, ORNumber,DateOfPayment,AmountPaid,StudentIDDisplay,FirstName,MiddleName,LastName FROM `tblpaymenttransactions`,`tblstudent`,`tblstudentadmission` WHERE PaymentAdmissionID = AdmissionID AND AdmissionStudentID = StudentID AND PaymentSchoolYearID = $LatestSchoolYearID ORDER BY DateOfPayment DESC";
?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Update Transactions</h1></center>
     
     
     <div class="row-fluid">
         
       
         
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
              
              
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="StudentRecordsList">
              <thead>
                <tr>
                  <th>OR Number</th>
                  <th>Date of Payment</th>
                  <th>Amount Paid</th>
                  <th>Student ID</th>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Action</th>
                  <th>Action</th>
                 
              
                </tr>
              </thead>
              <tbody>
                  
<?php
                  
                  
try
{
    $LatestSchoolYear;
    $statement = $dbh->prepare($DataTableQuery);
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    if (!empty($row)) {
          $index = 1;
         // $LatestSchoolYear =  $row['SchoolYear'];
        
    foreach($row as $data){
        echo '<tr>';
        echo '<td>'.$data['ORNumber'].'</td>';
        echo '<td>'.$data['DateOfPayment'].'</td>';
        echo '<td>'.$data['AmountPaid'].'</td>';
        echo '<td>'.$data['StudentIDDisplay'].'</td>';
        echo '<td>'.$data['FirstName'].'</td>';
        echo '<td>'.$data['MiddleName'].'</td>';
        echo '<td>'.$data['LastName'].'</td>';
  
        
        
        echo " <td> <form action=\"UpdateTransactionFormInitializer.php\" method=\"post\"><input class=\"btn btn-primary\" type=\"submit\" value=\"Edit\" > <input type=\"hidden\" name=\"id\" value=\"".$data["PaymentID"]."\"><input type=\"hidden\" name=\"id2\" value=\"".$data["StudentID"]."\"><input type=\"hidden\" name=\"id3\" value=\"".$data["AdmissionID"]."\"> </form>  </td>  ";
        
        echo "<td> <button class=\"btn btn-danger btnDeleteTransaction\" data-id=\"".$data['PaymentID']."\">Delete</button>";

         //echo "<td><a href='UpdateTransactionForm.php'><button class='btn btn-primary'>Update </button> </a> </td>";
        
      
        echo "</tr>";
        
        
            $index++;
    }
    } 
    else {
   
       $LatestSchoolYear = "2020";
    }
  
}
catch (PDOException $e)
{
    echo "There is some problem in connection: " . $e->getMessage();
}

                  
                  
                                    
?>
                  
            
            
              </tbody>
            </table>
          </div>
        </div>
         
         
         
         
         
     </div>
     
         
 </div> <!-- container fluid end -->


<?php
    
    
    //unset($_SESSION['GradeLevelSortRetrieve']);
    
?>

    
    
    
<!--

<script src="js/jquery.min.js"></script> 
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<script src="js/jquery.dataTables.min.js"></script> 
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script> -->
    
    
<script src="js/jquery.min.js"></script>  
<script src="https://cdn.datatables.net/1.9.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.9.4/js/jquery.dataTables.min.js"></script>
<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/jquery.gritter.min.js"></script>
<script src="js/jquery.peity.min.js"></script> 
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 
<!--
<script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script> -->
<!--
<script src="js/jquery.dataTables.min.js"></script> -->
<script src="js/matrix.js"></script> 
<script src="js/matrix.tables.js"></script> 
<script src="//cdn.datatables.net/plug-ins/1.10.19/api/fnReloadAjax.js"></script>
    
    
    
    
<script type="text/javascript">
    
    
$( document ).ready(function() {
    
      //alert("TEST");
    
  $('#StudentRecordsList').on('click', '.btnDeleteTransaction', function(){
          
        
          
            if (confirm('Are you sure you want to delete this payment?')) {
                    
                     var PaymentID = $(this).data('id');
                
                     var PaymentDetails = { PaymentID: PaymentID };
                
                    $.ajax({
                            type:'POST',
                            url:'DeletePaymentSubmit.php',
                            data:{"RetrieveTransaction" : JSON.stringify(PaymentDetails)},
                            success:function(html){
                                 
                                   //alert("Success");
                               window.location.href="/iucsenrollmentsystem/webpages/UpdateTransactions.php";
                                   
                    
                            }, // After Ajax Submit
                       
                       error: function(request, error) {
                            
                                 $.gritter.add({
			                         title: 'Operation Failed!',
			                         text: 'System Error! Please contact the IT Team of Imus Unida Christian School',
                                     time: 6000,
			                         image: 'img/demo/checkmark.png',
			                         sticky: false,
                                    position: 'center'
		                          });	
                    
                                 $(".gritter-item").css("background","#ff0000");
        
                        }
                }); 
            }
      });
    
    
      
});

 
</script>

    

</body>
</html>