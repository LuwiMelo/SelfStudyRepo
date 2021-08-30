<?php
//Code For User Authentication For Each Web Page
session_start();

include 'DataBaseConnectionFile.php';

include 'adminheader.php';
/*
if(!isset($_SESSION['SessionUserID'])){
    header('Location: login.php');
}




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
 <center><h1>Nationality Maintenance 
     </h1></center>
     
     
     <div class="row-fluid">
         
         <div class="span10"></div>
         <button class="btn btn-primary" id="btnAddNewNationality">Add New Nationality</button>
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered" id="StudentRecordsList">
              <thead>
            <tr>
                <th>ID</th>
                <th>Nationality</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
                
            </table>
            
          </div>
        </div>
         
     </div>
     
     
<div id="AddNewNationalityModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add New Nationality</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*Nationality ID(System Generated) :</label>
              <div class="controls">
                <input type="text" name="NationalityIDAdd" id="NationalityIDAdd" class="span4" placeholder="Nationality ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityIDEditError"  name="NationalityIDEditError">Invalid Nationality ID</span>
              </div>

              
            <label class="control-label">*Nationality :</label>
              <div class="controls">
                <input type="text" name="NationalityNameAdd" id="NationalityNameAdd" class="span4" placeholder="e.g. American" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityNameEditError"  name="NationalityNameEditError">Invalid Nationality</span>
              </div>
                
              </div>
    
    
              <div class="modal-footer"> <a id="AddNationalitySaveChanges" data-dismiss="modal" class="btn btn-success" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
     
     
     
<div id="EditNationalityModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Edit Nationality</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*Nationality ID :</label>
              <div class="controls">
                <input type="text" name="NationalityIDEdit" id="NationalityIDEdit" class="span4" placeholder="Nationality ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityIDEditError"  name="NationalityIDEditError">Invalid Nationality ID</span>
              </div>

              
            <label class="control-label">*Nationality :</label>
              <div class="controls">
                <input type="text" name="NationalityNameEdit" id="NationalityNameEdit" class="span4" placeholder="e.g. American" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityNameEditError"  name="NationalityNameEditError">Invalid Nationality</span>
              </div>
                  
            
     
              </div>
    
    
              <div class="modal-footer"> <a id="EditSaveChanges" data-dismiss="modal" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     


     
     
     
     
     <div id="DeleteNationalityModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Warning! Delete Nationality</h3>
              </div>
              <div class="modal-body" style="">

                <h4>Are you sure you want to delete this nationality? All students registered with this nationality will be updated to Nationality not set</h4>
            
                  
            
     
              </div>
    
    
              <div class="modal-footer"> <a id="DeleteNationalitySaveChanges"  data-dismiss="modal" class="btn btn-danger" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
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
                            "sAjaxSource": "NationalityLoadData.php",
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

    
    
    
//Triggered upon clicking Add New Nationality Button
$("#btnAddNewNationality").click(function(e){
     let NewNationalityID;
    
         $.ajax({
                    type:'GET',
                    url:'GetLatestNationalityID.php',
                    async: false,
                    //data:{"RetrieveTransaction" : JSON.stringify(EditNationalityDetails)},
                    success:function(data){
                        NewNationalityID = data;
                    },     
                    error: function(request, error) {    
                
                        
                    
                   }
                 
        });
    
    $("#NationalityIDAdd").val(NewNationalityID);
    $("#NationalityNameAdd").val("");
    $("#AddNewNationalityModal").modal("show");
    
    
    
    
});

    
//Triggered upon clicking Edit Nationality Button in Data Table
$('#StudentRecordsList').on('click', '.btnEditNationality', function(){
            
            var NationalityID = $(this).data('id');
            var NationalityName = $(this).data('name');
            
            $("#EditNationalityModal").modal("show");
            $("#NationalityIDEdit").val(NationalityID);
            $("#NationalityNameEdit").val(NationalityName);
});
    
    
//Triggered upon clicking Delete Nationality Button in Data Table   
$('#StudentRecordsList').on('click', '.btnDeleteNationality', function(){
            
            var NationalityID = $(this).data('id');
            var NationalityName = $(this).data('name');
    
            $('#DeleteNationalitySaveChanges').data('id', NationalityID);
            $('#DeleteNationalitySaveChanges').data('name', NationalityName);
            //$('#DeleteNationalitySaveChanges').attr('data-id', NationalityID);
            //$('#DeleteNationalitySaveChanges').attr('data-name', NationalityName);
            $("#DeleteNationalityModal").modal("show");
            
            
});

    
    

//Add Record Save Changes
$("#AddNationalitySaveChanges").click(function(e){
     
     var AddID = $("#NationalityIDAdd").val();
     var AddNationalityName = $("#NationalityNameAdd").val();
     var AddNationalityDetails = { NationalityID: AddID, NationalityName: AddNationalityName };
     
             $.ajax({
                    type:'POST',
                    url:'AddNationalitySaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(AddNationalityDetails)},
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
                          $.getJSON("NationalityLoadData.php", null, function( json ){
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
     
     var EditID = $("#NationalityIDEdit").val();
     var EditNationalityName = $("#NationalityNameEdit").val();
     var EditNationalityDetails = { NationalityID: EditID, NationalityName: EditNationalityName };
     
             $.ajax({
                    type:'POST',
                    url:' EditNationalitySaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(EditNationalityDetails)},
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
                          $.getJSON("NationalityLoadData.php", null, function( json ){
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
$("#DeleteNationalitySaveChanges").click(function(e){
     
            var DeleteNationalityID = $(this).data('id');
            var DeleteNationalityDetails = { NationalityID: DeleteNationalityID};
     
            //alert(DeleteNationalityID);
    
          $.ajax({
                    type:'POST',
                    url:' DeleteNationalitySaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(DeleteNationalityDetails)},
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
                          $.getJSON("NationalityLoadData.php", null, function( json ){
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