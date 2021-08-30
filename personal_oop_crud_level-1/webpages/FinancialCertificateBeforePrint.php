<?php 


session_start();


include 'DataBaseConnectionFile.php';
include 'adminheader.php';


/*
$dsn = 'mysql:dbname=iucs_ecra_db;host=localhost;';
$user = 'root';
$password = '';

try {
    $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
*/



?>

<!--main-container-part-->
<div id="content"> <!-- this div will have no end tag, end tag will be found in the admin footer page -->

  <div id="content-header">
    
  </div>



     <div class="container-fluid">
         <hr>
    <center>    <img  style="width: 800px; height: 150px;" src="phase1logo.png"> </center>
      <br>
         <h1><center>Financial Certificate</center></h1>
          <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-hand-right"></i> </span>
            <h5>Generate Financial Certificate</h5>
          </div>
          <div class="widget-content">
            
       
              
    <div class="row-fluid">
                     
                     <div class="span1"></div>
                
                       <div class="span5" >
            
                
              <label class="control-label">Requestor of Certificate:</label>
              <div class="controls">
                <input type="text" name="Requestor" id="Requestor" class="span10 m-wrap" placeholder="e.g.Mother's Name" />
              </div>
          
      
         </div>
              
                     
                 <div class="span5 control-group" id="TotalAmountControlGroup">
              
                   <label class="control-label">*Total Amount</label>
              <div class="controls">
                <input type="text" name="TotalAmount" id="TotalAmount" class="span10 m-wrap" placeholder="e.g. 33500"/>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="TotalAmountError"  name="TotalAmountError">Please enter a valid amount</span> 
              </div>
                      
           
                
                 </div>
                     
                     
             
		
                     
</div>
         
            <br>
                 
    <div class="row-fluid">
                     
                     <div class="span1"></div>
                
                 <div class="span5 control-group" id="BooksBreakdownControlGroup">
              
                   <label class="control-label">*Books Breakdown</label>
              <div class="controls">
                <input type="text" name="BooksBreakdown" id="BooksBreakdown" class="span10 m-wrap" placeholder="e.g. 14000"/>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="BooksBreakdownError"  name="BooksBreakdownError">Please enter a valid amount</span> 
              </div>
                      
           
                
                 </div>
              
                     
                 <div class="span5 control-group" id="UniformsBreakdownControlGroup">
              
                   <label class="control-label">*Uniforms Breakdown</label>
              <div class="controls">
                <input type="text" name="UniformsBreakdown" id="UniformsBreakdown" class="span10 m-wrap" placeholder="e.g. 8000"/>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="UniformsBreakdownError"  name="UniformsBreakdownError">Please enter a valid amount</span> 
              </div>
                      
           
                
                 </div>
                     
                     
             
		
                     
</div>
        
                          <br>
                 
    <div class="row-fluid">
                     
                     <div class="span1"></div>
                
                 <div class="span5 control-group" id="OthersBreakdownControlGroup">
              
                   <label class="control-label">*Others/Miscellaneous Breakdown</label>
              <div class="controls">
                <input type="text" name="OthersBreakdown" id="OthersBreakdown" class="span10 m-wrap" placeholder="e.g. 14000"/>
                   <span class="help-inline" style="color: #b94a48; display: none;" id="OthersBreakdownError"  name="OthersBreakdownError">Please enter a valid amount</span> 
              </div>
                      
           
                
                 </div>
              
                     
    
                     
                     
             
		
                     
</div>
                 
                 

            <br>
                 
    <div class="row-fluid">
                     
                     <div class="span1"></div>
                
                   <div class="span5">
              
                   <label class="control-label">Purpose:</label>
              <div class="controls">
                <select name="Purpose" id="Purpose">
                    <option value="0">--Select Purpose--</option>
                    <?php 
                                                        
                                                 
        try
{
 
    
    $statement = $dbh->prepare("SELECT * FROM tblcertpurpose");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
            
 
           echo '<option value ="' . $data['CertPurposeID'] . '" '. $selected .'>' . $data['CertPurpose'] .'</option>';
            
            
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
              
                     
            <div class="span5" >
            
                
              <label class="control-label">Other Purpose (if not listed):</label>
              <div class="controls">
                <input type="text" name="OtherPurpose" id="OtherPurpose" class="span10 m-wrap" placeholder="e.g. Family Assistance" />
              </div>
          
      
         </div>
                     
                     
             
		
                     
</div>
                 
              <br>
              <br>
                 
<div class="row-fluid">
                 		     
   <div class="span7"></div>
    
    <div class="span4" style="margin-top: 25px; margin-bottom: 100px;">
       
        <button type="button"  id="btnGenerateCert" class="btn btn-large btn-success" >Generate Certificate</button>      
    
    </div>
            
</div>
                   
    
           
         

          </div>
        </div>
         
         
         
         
         
         
    </div> <!-- end of container fluid -->
    
    

<?php

include 'adminfooter.php';

?>
    
<script type="text/javascript">
    
    
    $("#btnGenerateCert").click(function(e){
              
            var FormValidator = true;
            
            var Requestor = $("#Requestor").val();
            var Purpose = $("#Purpose").val();
            var OtherPurpose = $("#OtherPurpose").val();

            //Total Amount Validation
            var TotalAmount = $("#TotalAmount").val();
            if(isNaN(TotalAmount) || TotalAmount == null || TotalAmount == ""){
                FormValidator = false;
                $("#TotalAmountControlGroup").addClass("error");
                $("#TotalAmountError").show();
            }
            else{
               $("#TotalAmountControlGroup").removeClass("error");
               $("#TotalAmountError").hide();
            }
        
        
            //Books Breakdown Validation
            var BooksBreakdown = $("#BooksBreakdown").val();
            if(isNaN(BooksBreakdown) || BooksBreakdown == null || BooksBreakdown == ""){
                FormValidator = false;
                $("#BooksBreakdownControlGroup").addClass("error");
                $("#BooksBreakdownError").show();
            }
            else{
               $("#BooksBreakdownControlGroup").removeClass("error");
               $("#BooksBreakdownError").hide();
            }
        
            //Uniforms Breakdown Validation
            var UniformsBreakdown = $("#UniformsBreakdown").val();
            if(isNaN(UniformsBreakdown) || UniformsBreakdown == null || UniformsBreakdown == ""){
                FormValidator = false;
                $("#UniformsBreakdownControlGroup").addClass("error");
                $("#UniformsBreakdownError").show();
            }
            else{
               $("#UniformsBreakdownControlGroup").removeClass("error");
               $("#UniformsBreakdownError").hide();
            }
        
            //Others Breakdown Validation
            var OthersBreakdown = $("#OthersBreakdown").val();
            if(isNaN(OthersBreakdown) || OthersBreakdown == null || OthersBreakdown == ""){
                FormValidator = false;
                $("#OthersBreakdownControlGroup").addClass("error");
                $("#OthersBreakdownError").show();
            }
            else{
               $("#OthersBreakdownControlGroup").removeClass("error");
               $("#OthersBreakdownError").hide();
            }
        
        
        
        
            var CertDetails = { Requestor: Requestor, Purpose: Purpose, OtherPurpose: OtherPurpose, TotalAmount: TotalAmount, BooksBreakdown: BooksBreakdown, UniformsBreakdown: UniformsBreakdown, OthersBreakdown: OthersBreakdown };
        
            
        
            if(FormValidator){
                   $.ajax({
                            type:'POST',
                            url:'GenerateFinancialCert.php',
                            data:{"RetrieveTransaction" : JSON.stringify(CertDetails)},
                            success:function(html){
                                 
                                   //alert("Success");
                                var win = window.open('/iucsenrollmentsystem/webpages/FinancialCertificate.php', '_blank');
                                if (win) {
                                    //Browser has allowed it to be opened
                                    win.focus();
                                } else {
                                    //Browser has blocked it
                                    alert('Please allow popups for this website');
                                }
                                
                                   
                    
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
            else{
                // document.documentElement.scrollTop = 0;
                 
              $.gritter.add({
			       title: 'Operation Failed!',
			       text: 'Some fields might not be inputted properly! Check for errors!',
                   time: 6000,
			       image: 'img/demo/checkmark.png',
			       sticky: false,
                   position: 'center'
		      });	
                    
                $(".gritter-item").css("background","#ff0000");
    
                
                
                
                
            }
        
        
    });
    
</script>
    

    
    </body>
</html>
    
    
    
    
    
    
    
    
    