<?php

include_once '../layout/headerlayout.php';
include_once '../config/connection.php';
include_once '../objects/tbldepartment.php';

$db = new Database();
$dbh = $db->getConnection();
$Department = new Department($dbh);

$stmt = $Department->ReadAllActiveDepartments();


?>


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <h1><center>Department Maintenance </h1></center>
     
     
     <div class="row-fluid">
         
         <div class="span10"></div>
         <button class="btn btn-primary" id="btnAddNewDepartment">Add New Department</button>
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table" id="DepartmentTable">
              <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>

        <tbody>
         <?php
            //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
                //extract($row);
      
                //echo "<tr>";
                    //echo "<td>{$DepartmentID}</td>";
                    //echo "<td>{$DepartmentName}</td>";
      
                    //echo "<td>";
                    //echo "<button class=\"btn btn-success btnEditDepartment\" data-id='{$DepartmentID}'  >Edit</button>";
                    //echo "</td>";
                    //echo "<td>";
                    //echo "<button class=\"btn btn-danger btnDeleteDepartment\" data-id='{$DepartmentID}'  >Delete</button>";
                    //echo "</td>";
      
                //echo "</tr>";
      
            //}
      

?>


        </tbody>
                
            </table>
            
          </div>
        </div>
         
     </div>
     
     
<div id="AddNewDepartmentModal" class="modal hide">
  
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add New Department</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

    

          <div class="control-group" id="DepartmentControlGroup">
            <label class="control-label">*Department Name :</label>
              <div class="controls">
                <input type="text" name="DepartmentNameAdd" id="DepartmentNameAdd" class="span4" placeholder="e.g. Department 1 " />
                <span class="help-inline" style="color: #b94a48; display: none;" id="DepartmentNameAddError"  name="DepartmentNameAddError">Department Name is required</span>
              </div>
            </div>

                
              </div>
    
    
              <div class="modal-footer"> <a id="AddDepartmentSaveChanges"  class="btn btn-success" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
     
     
    
     
     <div id="DeleteDepartmentModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Warning! Delete Department</h3>
              </div>
              <div class="modal-body" style="">

                <h4>Are you sure you want to delete this department? </h4>
            
                  
            
     
              </div>
    
    
              <div class="modal-footer"> <a id="DeleteDepartmentSaveChanges" data-dismiss="modal" class="btn btn-danger" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
      
 </div> <!-- container fluid end -->





 <?php

   include_once '../javascriptfiles/javascriptincludes.php';

 ?>


<script type="text/javascript">
    


    
$(document).ready(function() {


  //$("#DepartmentTable").DataTable().destroy();
  /*
  var DepartmentTable = $('#DepartmentTable').DataTable({
       
         "processing": true,
         "retrieve": true,
         //"serverSide": true,
         "ajax": 'test.txt',
         "bJQueryUI": true,
		     "sPaginationType": "full_numbers",
         "sDom": '<""l>t<"F"fp>'
            

   });
*/

  $("#DepartmentTable").DataTable().ajax.url( 'GetDepartmentList.php' ).load();




//Triggered upon clicking Add New Department Button
$("#btnAddNewDepartment").click(function(e){
     let NewNationalityID;
     /*
         $.ajax({
                    type:'GET',
                    url:'GetLatestUserID.php',
                    async: false,
                    //data:{"RetrieveTransaction" : JSON.stringify(EditNationalityDetails)},
                    success:function(data){
                        NewNationalityID = data;
                    },     
                    error: function(request, error) {    
            
                    
                   }
                 
        });
    */
    //$("#MiddleNameAdd").val("");
    $("#AddNewDepartmentModal").modal("show");


});


//Add Department Save Changes
$("#AddDepartmentSaveChanges").click(function(e){
     

     var AddDepartmentName = $("#DepartmentNameAdd").val();

     var FormValidator = true;

      //if(isNaN(AddDepartmentName) || LRNNumber.length > 12 || LRNNumber == null || LRNNumber == ""){
      /*
      if(AddDepartmentName == null || AddDepartmentName == ""){
                FormValidator = false;
                $("#DepartmentControlGroup").addClass("error");
                $("#DepartmentNameAddError").show();
      }
      else{
               $("#DepartmentControlGroup").removeClass("error");
               $("#DepartmentNameAddError").hide();
       }
      */




     //var AddDepartmentDetails = $("#DepartmentDetails").val();

     var AddDepartment = { AddDepartmentName: AddDepartmentName, SQLAction: "ADD"   };
     
  if(FormValidator){
 
             $.ajax({
                    type:'POST',
                    url:'../controllers/DepartmentController.php',
                    dataType: "json",
                    data:{"RetrieveTransaction" : JSON.stringify(AddDepartment)},
                    success:function(data){
                        

                        if(data.AddDepartmentValidationResult == "FieldNoErrors"){ // if field no errors
                              
                          $("#AddNewDepartmentModal").modal("hide");
                              
                              $.gritter.add({
			                            title:	'Operation Successful',
			                            text:	'Successfully created new department!',
                                  time: 6000,
			                            image: '../img/demo/checkmark.png',
			                            sticky: false,
                                  position: 'center'
		                          });	

                              setTimeout(
                               function() 
                                     {
                                
                                       $("#DepartmentTable").DataTable().ajax.url( 'GetDepartmentList.php' ).load();
                                     }, 1000);


                        }// if field no errors


                        if(data.AddDepartmentValidationResult == "WithFieldErrors"){
                                
                                alert("With field errors");

                                 if(data.AddDepartmentNameError != null){

                                    $('#DepartmentNameAddError').text(data.AddDepartmentNameError);
                                    $("#DepartmentControlGroup").addClass("error");
                                    $("#DepartmentNameAddError").show();
                                 }
                                 else{
                                    $("#DepartmentControlGroup").removeClass("error");
                                    $('#DepartmentNameAddError').text("");
                                    $("#DepartmentNameAddError").hide();
                                 }
                        }



                        
                        
                        /*
                         //Manual Code for Refresh Data Table using Ajax
                          $.getJSON("DepartmentLoadData.php", null, function( json ){
                                table = $("#StudentRecordsList").dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);

                                for (var i=0; i<json.aaData.length; i++){
                                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                                }
                                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                    table.fnDraw();
                          });
                          */



                           
                        
                    },     
                error: function(request, error) {    
                       
                    
                        $.gritter.add({
			                     title:	'Operation Failed!',
			                     text:	'Creating New Record failed due to internal server error!',
                           time: 6000,
			                     image: '../img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                    
                             $(".gritter-item").css("background","#ff0000");
                    
                }
   
               });


    }//if Form Validator
              
 });





});




</script>