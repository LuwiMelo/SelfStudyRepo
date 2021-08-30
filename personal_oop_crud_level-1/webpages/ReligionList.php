<?php
//Code For User Authentication For Each Web Page
session_start();

include 'DataBaseConnectionFile.php';
include 'adminheader.php';
/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}




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


<div id="content">
    
<div id="content-header">
    
</div>

 <div class="container-fluid">
         
          <hr>
 <center><h1>Religion Maintenance 
     </h1></center>
     
     
     <div class="row-fluid">
         
         <div class="span10"></div>
         <button class="btn btn-primary" id="btnAddNewReligion">Add New Religion</button>
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered" id="StudentRecordsList">
              <thead>
            <tr>
                <th>ID</th>
                <th>Religion</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
                
            </table>
            
          </div>
        </div>
         
     </div>
     
     
<div id="AddNewReligionModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add New Religion</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*Religion ID(System Generated) :</label>
              <div class="controls">
                <input type="text" name="ReligionIDAdd" id="ReligionIDAdd" class="span4" placeholder="Religion ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="ReligionIDEditError"  name="ReligionIDEditError">Invalid Religion ID</span>
              </div>

              
            <label class="control-label">*Religion :</label>
              <div class="controls">
                <input type="text" name="ReligionNameAdd" id="ReligionNameAdd" class="span4" placeholder="e.g. Born-Again Christian" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="ReligionNameEditError"  name="ReligionNameEditError">Invalid Religion</span>
              </div>
                
              </div>
    
    
              <div class="modal-footer"> <a id="AddReligionSaveChanges" data-dismiss="modal" class="btn btn-success" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
     
     
     
<div id="EditReligionModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Edit Religion</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*Religion ID :</label>
              <div class="controls">
                <input type="text" name="ReligionIDEdit" id="ReligionIDEdit" class="span4" placeholder="Religion ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="ReligionIDEditError"  name="ReligionIDEditError">Invalid Religion ID</span>
              </div>

              
            <label class="control-label">*Religion :</label>
              <div class="controls">
                <input type="text" name="ReligionNameEdit" id="ReligionNameEdit" class="span4" placeholder="e.g. Born-Again Christian" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="ReligionNameEditError"  name="ReligionNameEditError">Invalid Religion</span>
              </div>
                  
            
     
              </div>
    
    
              <div class="modal-footer"> <a id="EditSaveChanges" data-dismiss="modal" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     


     
     
     
     
     <div id="DeleteReligionModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Warning! Delete Religion</h3>
              </div>
              <div class="modal-body" style="">

                <h4>Are you sure you want to delete this religion? All students registered with this religion will be updated to Religion not set</h4>
            
                  
              </div>
    
    
              <div class="modal-footer"> <a id="DeleteReligionSaveChanges" data-dismiss="modal" class="btn btn-danger" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
      
 </div> <!-- container fluid end -->



    
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
    
    
$(document).ready(function() {
    
    
    
/* Last Resort in doing Ajax DataTable upon page load
$.ajax({
         type: "POST",
         url: "NationalityLoadDatatest.php",
         //data: 'id='+id,
         dataType: 'json',
         cache: false,
         success: function(data) {
         var table;
         table = $('#StudentRecordsList').dataTable(); 
             

         if(data!='') {               
          $.each(data, function(i, item) {
             table.row.add([ data[i].user_name, data[i].user_phone, data[i].user_email ]);
         });    
             
         }
         else {
         $('#StudentRecordsList').html('<h3>No users are available</h3>');
         }
             
         table.draw();
      }
});
    
End of Last Resort in doing Ajax DataTable upon page load */ 

//Data Table Initialization
    var oTable = $('#StudentRecordsList').dataTable();
    var oSettings = oTable.fnSettings();
    oTable.fnDestroy();

    
    var oTable2 = $('#StudentRecordsList').dataTable({
        
                            "bPaginate": true,
                            "bJQueryUI": true,  // ThemeRoller-stöd
                            "bLengthChange": true,
                            "bFilter": true,
                            "bSort": true,
                            "bInfo": true,
                            "bAutoWidth": true,
                            "bProcessing": true,
                          //"bServerSide": true, //Removing bServerSide fix the problem. I don't know why.
                            "sPaginationType": "full_numbers",
                            "sAjaxSource": "ReligionLoadData.php",
                            "sDom": '<"top"fl<"clear">>rt<"bottom"ifLp<"clear">>'
                          //"iDisplayLength": 10,
                          //"bJQueryUI": true,
                          //"bFilter": true,
                          //"sDom": '<""l>t<"F"fp>',
                          //"iDisplayLength":5,
                          //"iDisplayStart ":5,
                           // "sDom": '<"top"i>rt<"bottom"flp><"clear">',
                          //"bPaginate": true,
                          //"bDestroy": true,
                          //"bProcessing": true,
                          //"bServerSide": true,
                          //"sAjaxDataProp": "demo",
                          //"aoColumns": [
                                //{ mData: 'id' } ,
                                //{ mData: 'name' },
                                //{ mData: 'age' }
                         //]
   });

    
    
    
//Triggered upon clicking Add New Religion Button
$("#btnAddNewReligion").click(function(e){
     let NewReligionID;
    
         $.ajax({
                    type:'GET',
                    url:'GetLatestReligionID.php',
                    async: false,
                    //data:{"RetrieveTransaction" : JSON.stringify(EditNationalityDetails)},
                    success:function(data){
                        NewReligionID = data;
                    },     
                    error: function(request, error) {    
                
                        
                    
                   }
                 
        });
    
    $("#ReligionIDAdd").val(NewReligionID);
    $("#ReligionNameAdd").val("");
    $("#AddNewReligionModal").modal("show");
    
    
    
    
});

    
//Triggered upon clicking Edit Religion Button in Data Table
$('#StudentRecordsList').on('click', '.btnEditReligion', function(){
            
            var ReligionID = $(this).data('id');
            var ReligionName = $(this).data('name');
            
            $("#EditReligionModal").modal("show");
            $("#ReligionIDEdit").val(ReligionID);
            $("#ReligionNameEdit").val(ReligionName);
});
    
    
//Triggered upon clicking Delete Nationality Button in Data Table   
$('#StudentRecordsList').on('click', '.btnDeleteReligion', function(){
            
            var ReligionID = $(this).data('id');
            var ReligionID2 = $(this).attr('data-id');
            var ReligionName = $(this).data('name');
    
             //alert(ReligionName);
            //alert(ReligionID2);
    
              
                 $('#DeleteReligionSaveChanges').data('id', ReligionID);
                 $('#DeleteReligionSaveChanges').data('name', ReligionName);
                  //$('#DeleteReligionSaveChanges').attr('data-id', ReligionID);
                  //$('#DeleteReligionSaveChanges').attr('data-name', ReligionName);
    
    
         
            $("#DeleteReligionModal").modal("show");
            
            
});

    
    

//Add Record Save Changes
$("#AddReligionSaveChanges").click(function(e){
     
     var AddID = $("#ReligionIDAdd").val();
     var AddReligionName = $("#ReligionNameAdd").val();
     var AddReligionDetails = { ReligionID: AddID, ReligionName: AddReligionName };
     
             $.ajax({
                    type:'POST',
                    url:'AddReligionSaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(AddReligionDetails)},
                    success:function(data){
                        
                           //alert("Successfully Edited");
                        	$.gritter.add({
			                     title:	'Operation Successful',
			                     text:	'Successfully created new record!',
                                 time: 6000,
			                     image: 'img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                        
                        
                         //Manual Code for Refresh Data Table using Ajax
                          $.getJSON("ReligionLoadData.php", null, function( json ){
                                table = $("#StudentRecordsList").dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);

                                for (var i=0; i<json.aaData.length; i++){
                                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                                }
                                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                    table.fnDraw();
                          });
                          
                        
                        
                    },     
                error: function(request, error) {    
                            //alert("Error");
                    
                            $.gritter.add({
			                     title:	'Operation Failed!',
			                     text:	'Creating New Record failed due to internal server error!',
                                 time: 6000,
			                     image: 'img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                    
                             $(".gritter-item").css("background","#ff0000");
                    
                }
                 
               });
              
 });
    
    
        
//Edit Record Save Changes
$("#EditSaveChanges").click(function(e){
     
     var EditID = $("#ReligionIDEdit").val();
     var EditReligionName = $("#ReligionNameEdit").val();
     var EditReligionDetails = { ReligionID: EditID, ReligionName: EditReligionName };
     
             $.ajax({
                    type:'POST',
                    url:' EditReligionSaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(EditReligionDetails)},
                    success:function(data){
                        
                           //alert("Successfully Edited");
                        	$.gritter.add({
			                     title:	'Operation Successful',
			                     text:	'Successfully edited.',
                                 time: 6000,
			                     image: 'img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                        
                           
                        
                         //Manual Code for Refresh Data Table using Ajax
                          $.getJSON("ReligionLoadData.php", null, function( json ){
                                table = $("#StudentRecordsList").dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);

                                for (var i=0; i<json.aaData.length; i++){
                                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                                }
                                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                    table.fnDraw();
                          });
                          
                        
                        /* Ajax Refresh using JQuery Plugin Code (fnReloadAjax). Datatable API
                        var table = $('#StudentRecordsList').dataTable();
 
                        // Example call to load a new file
                        table.fnReloadAjax( 'NationalityLoadData.php' );
 
                        // Example call to reload from original file
                        table.fnReloadAjax();
                        */
                        
                    },     
                error: function(request, error) {    
                            //alert("Error");
                    
                            $.gritter.add({
			                     title:	'Operation Failed!',
			                     text:	'Updating Record failed due to internal server error!',
                                 time: 6000,
			                     image: 'img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                    
                             $(".gritter-item").css("background","#ff0000");
                    
                }
                 
               });
              
 });
    
    
    

    
    
//Delete Record Save Changes
$("#DeleteReligionSaveChanges").click(function(e){
     
            var DeleteReligionID = $(this).data('id');
            //var DeleteReligionDetails = { ReligionID: DeleteReligionID};
            //var DeleteReligionID = $(this).attr('data-id');
            var DeleteReligionDetails = { ReligionID: DeleteReligionID};
    
          $.ajax({
                    type:'POST',
                    url:' DeleteReligionSaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(DeleteReligionDetails)},
                    success:function(data){
                        
                           //alert("Successfully Edited");
                        	$.gritter.add({
			                     title:	'Operation Successful',
			                     text:	'Successfully deleted the record.',
                                 time: 6000,
			                     image: 'img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                        
                           
                        
                         //Manual Code for Refresh Data Table using Ajax
                          $.getJSON("ReligionLoadData.php", null, function( json ){
                                table = $("#StudentRecordsList").dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);

                                for (var i=0; i<json.aaData.length; i++){
                                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                                }
                                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                    table.fnDraw();
                          });
                          
                        
                        
                    },     
                error: function(request, error) {    
                    
                            $.gritter.add({
			                     title:	'Operation Failed!',
			                     text:	'Deleting Record failed due to internal server error!',
                                 time: 6000,
			                     image: 'img/demo/checkmark.png',
			                     sticky: false,
                                 position: 'center'
		                    });	
                    
                             $(".gritter-item").css("background","#ff0000");
                    
                }
                 
               });
               
              
 });

     //oTable2.fnDraw();
     //var oSettings2 = oTable2.fnSettings()
     //console.log(oSettings2);
    
    
});
    
     
    
   
    
       
</script>
    


</body>
</html>