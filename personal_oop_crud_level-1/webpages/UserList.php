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
 <center><h1>Users Maintenance 
     </h1></center>
     
     
     <div class="row-fluid">
         
         <div class="span10"></div>
         <button class="btn btn-primary" id="btnAddNewUser">Add New User</button>
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered" id="StudentRecordsList">
              <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>User Type</th>
                <th>Academic Department</th>
                <th>Action</th>
                <th>Action</th>
            
            </tr>
        </thead>
                
            </table>
            
          </div>
        </div>
         
     </div>
     
     
<div id="AddNewUserModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Add New User</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*User ID(System Generated) :</label>
              <div class="controls">
                <input type="text" name="UserIDAdd" id="UserIDAdd" class="span4" placeholder="User ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="UserIDEditError"  name="UserIDEditError">Invalid User ID</span>
              </div>

              
            <label class="control-label">*Username :</label>
              <div class="controls">
                <input type="text" name="UsernameAdd" id="UsernameAdd" class="span4" placeholder="e.g. 20171234" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="UsernameEditError"  name="UsernameEditError">Invalid Username</span>
              </div>
                  
             <label class="control-label">*Password :</label>
              <div class="controls">
                <input type="password" name="UserPasswordAdd" id="UserPasswordAdd" class="span4" placeholder="e.g. *********" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="UserPasswordEditError"  name="UserPasswordEditError">Password</span>
              </div>
                  
             <label class="control-label">*Last Name :</label>
              <div class="controls">
                <input type="text" name="LastNameAdd" id="LastNameAdd" class="span4" placeholder="e.g. Melo" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="LastNameAddError"  name="LastNameAddError">Invalid Last Name</span>
              </div>
                  
                  
             <label class="control-label">*First Name :</label>
              <div class="controls">
                <input type="text" name="FirstNameAdd" id="FirstNameAdd" class="span4" placeholder="e.g. Louie" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="FirstNameAddError"  name="FirstNameAddError">Invalid First Name</span>
              </div>
                  
                  
             <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="MiddleNameAdd" id="MiddleNameAdd" class="span4" placeholder="e.g. Rivera" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="MiddleNameAddError"  name="MiddleNameAddError">Invalid Middle Name</span>
              </div>
                  

                  
                  
                  
              <label class="control-label">*User Type :</label>
              <div class="controls">
              <select name="UserTypeAdd" id="UserTypeAdd" >
                     <?php 
                                                        
                                                        
        try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblposition WHERE PositionID <> 1");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
           echo '<option value ="' . $data['PositionID'] . '" '. $selected .'>' . $data['PositionName'] . '</option>';
        
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
                  
                  
                  
                  
                  
                  <br>
                  
             <label class="control-label">*Academic Department :</label>
              <div class="controls">
              <select name="AcademicDepartmentAdd" id="AcademicDepartmentAdd" >
                  <option value="0">For Teachers and Supervisor Only</option>
              </select>
             
              </div>
                  
                  
                <br>
                  <br>
                  
                  
                  
                    
              </div>
    
    
              <div class="modal-footer"> <a id="AddUserSaveChanges" data-dismiss="modal" class="btn btn-success" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
     
     
     
<div id="EditUserModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Edit User</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*User ID :</label>
              <div class="controls">
                <input type="text" name="UserIDEdit" id="UserIDEdit" class="span4" placeholder="User ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="UserIDEditError"  name="UserIDEditError">Invalid User ID</span>
              </div>

              
            <label class="control-label">*Username :</label>
              <div class="controls">
                <input type="text" name="UsernameEdit" id="UsernameEdit" class="span4" placeholder="e.g. Louie Melo" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="UsernameEditError"  name="UsernameEditError">Invalid Username</span>
              </div>
                  
              <label class="control-label">*Password :</label>
              <div class="controls">
                <input type="password" name="UserPasswordEdit" id="UserPasswordEdit" class="span4" placeholder="e.g. *********" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="UserPasswordEditError"  name="UserPasswordEditError">Password</span>
              </div>
                  
               <label class="control-label">*Last Name :</label>
              <div class="controls">
                <input type="text" name="LastNameEdit" id="LastNameEdit" class="span4" placeholder="e.g.Melo" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="LastNameEditError"  name="LastNameEditError">Invalid Last Name</span>
              </div>  
                
               <label class="control-label">*First Name :</label>
              <div class="controls">
                <input type="text" name="FirstNameEdit" id="FirstNameEdit" class="span4" placeholder="e.g.Louie" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="FirstNameEditError"  name="FirstNameEditError">Invalid First Name</span>
              </div> 
                  
              <label class="control-label">Middle Name :</label>
              <div class="controls">
                <input type="text" name="MiddleNameEdit" id="MiddleNameEdit" class="span4" placeholder="e.g.Rivera" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="MiddleNameEditError"  name="MiddleNameEditError">Invalid Middle Name</span>
              </div> 
                  
                  
                     
              <label class="control-label">*User Type :</label>
              <div class="controls">
              <select name="UserTypeEdit" id="UserTypeEdit" >
                     <?php 
                                                                                                       
 try
{
 
    
   
    $statement = $dbh->prepare("SELECT * FROM tblposition WHERE PositionID <> 1");
    $statement->execute();
    $row = $statement->fetchAll();
    
    
    
    if (!empty($row)) {
        
        foreach($row as $data){
           echo '<option value ="' . $data['PositionID'] . '" '. $selected .'>' . $data['PositionName'] . '</option>';
        
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
                  
                  
                  <br>
                               
             <label class="control-label">*Academic Department :</label>
              <div class="controls">
              <select name="AcademicDepartmentEdit" id="AcademicDepartmentEdit" >
                  <option value="0">For Teachers and Supervisor Only</option>
              </select>
             
              </div>
                  
                  
                  <br>
                  <br>
                  
                  
            
     
              </div>
    
    
              <div class="modal-footer"> <a id="EditSaveChanges" data-dismiss="modal" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     


     
     
     
     
     <div id="DeleteUserModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Warning! Delete User</h3>
              </div>
              <div class="modal-body" style="">

                <h4>Are you sure you want to delete this user? This feature is not recommended to be used AS OF NOW.</h4>
            
                  
        
     
              </div>
    
    
              <div class="modal-footer"> <a id="DeleteUserSaveChanges"  data-dismiss="modal" class="btn btn-danger" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
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
                            "sAjaxSource": "UserLoadData.php",
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
$("#btnAddNewUser").click(function(e){
     let NewNationalityID;
    
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
    
    $("#UserIDAdd").val(NewNationalityID);
    $("#UsernameAdd").val("");
    $("#UserPasswordAdd").val("");
    $("#AddNewUserModal").modal("show");
    
    
});

    
//Triggered upon clicking Edit Nationality Button in Data Table
$('#StudentRecordsList').on('click', '.btnEditUser', function(){
            
            var NationalityID = $(this).data('id');
            var NationalityName = $(this).data('name');
            var UserMaskedPassword = $(this).data('password');
            var FirstName =  $(this).data('firstname'); 
            var MiddleName = $(this).data('middlename'); 
            var LastName = $(this).data('lastname');
    
    
    
    
            UserDetails = { UserID: NationalityID };
        
              $.ajax({
                    type:'POST',
                    url:'GetUserTypeEditUser.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(UserDetails)},
                    success:function(html){
                        
                         $("#UserIDEdit").val(NationalityID);
                         $("#UsernameEdit").val(NationalityName);
                         $("#UserPasswordEdit").val(UserMaskedPassword);
                         $("#FirstNameEdit").val(FirstName);
                         $("#LastNameEdit").val(LastName);
                         $("#MiddleNameEdit").val(MiddleName);
                         $('#UserTypeEdit').empty();
                         $('#s2id_UserTypeEdit span').text('');
                         $('#UserTypeEdit').html(html);
                         var NewSelected = $("#UserTypeEdit option:selected").text();
                         $('#s2id_UserTypeEdit span').text(NewSelected);
                         //$("#EditUserModal").modal("show");  
                    },     
                error: function(request, error) {    
                      
                    alert("There is an internal problem within the server");
                }
                  
                          
              });
    
    
    
              $.ajax({
                    type:'POST',
                    url:'GetDepartmentEditUser.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(UserDetails)},
                    success:function(html){
                        
  
                         $('#AcademicDepartmentEdit').html(html);
                         var NewSelected = $("#AcademicDepartmentEdit option:selected").text();
                         $('#s2id_AcademicDepartmentEdit span').text(NewSelected);
                         $("#EditUserModal").modal("show");  
                    },     
                error: function(request, error) {    
                      
                    alert("There is an internal problem within the server");
                }
                  
                          
              });
    
});
    
    
//Triggered upon clicking Delete Nationality Button in Data Table   
$('#StudentRecordsList').on('click', '.btnDeleteUser', function(){
            
            var NationalityID = $(this).data('id');
            var NationalityName = $(this).data('name');
    
            $('#DeleteUserSaveChanges').data('id', NationalityID);
            $('#DeleteUserSaveChanges').data('name', NationalityName);
            //$('#DeleteNationalitySaveChanges').attr('data-id', NationalityID);
            //$('#DeleteNationalitySaveChanges').attr('data-name', NationalityName);
            $("#DeleteUserModal").modal("show");
            
            
});

    
    

//Add Record Save Changes
$("#AddUserSaveChanges").click(function(e){
     
     var AddID = $("#UserIDAdd").val();
     var AddNationalityName = $("#UsernameAdd").val();
     var AddUserPassword = $("#UserPasswordAdd").val();
     var AddUserLastName = $("#LastNameAdd").val();
     var AddUserFirstName = $("#FirstNameAdd").val();
     var AddUserMiddleName = $("#MiddleNameAdd").val();
     var AddUserUserType = $("#UserTypeAdd").val();
     var AddUserDepartment = $("#AcademicDepartmentAdd").val();
    
     var AddUserDetails = { UserID: AddID, Username: AddNationalityName, Password: AddUserPassword, UserPositionLevel: AddUserUserType, AddUserDepartment: AddUserDepartment, AddUserLastName: AddUserLastName, AddUserFirstName: AddUserFirstName, AddUserMiddleName: AddUserMiddleName   };
     
             $.ajax({
                    type:'POST',
                    url:'AddUserSaveChanges.php',
                    async: false,
                    data:{"RetrieveTransaction" : JSON.stringify(AddUserDetails)},
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
                        
                        
        
                         $("#FirstNameAdd").val("");
                         $("#LastNameAdd").val("");
                         $("#MiddleNameAdd").val("");


                        
                         //Manual Code for Refresh Data Table using Ajax
                          $.getJSON("UserLoadData.php", null, function( json ){
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
     
     var EditID = $("#UserIDEdit").val();
     var EditNationalityName = $("#UsernameEdit").val();
     var EditPassword = $("#UserPasswordEdit").val();
     var EditUserType = $("#UserTypeEdit").val();
     var EditDepartment = $("#AcademicDepartmentEdit").val();
     var EditUserLastName = $("#LastNameEdit").val();
     var EditUserFirstName = $("#FirstNameEdit").val();
     var EditUserMiddleName = $("#MiddleNameEdit").val();
    
     var EditNationalityDetails = { UserID: EditID, Username: EditNationalityName, Password: EditPassword, UserPositionLevel: EditUserType, EditDepartment: EditDepartment, EditUserLastName: EditUserLastName, EditUserFirstName: EditUserFirstName, EditUserMiddleName: EditUserMiddleName   };
     
             $.ajax({
                    type:'POST',
                    url:' EditUserSaveChanges.php',
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
                          $.getJSON("UserLoadData.php", null, function( json ){
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
$("#DeleteUserSaveChanges").click(function(e){
     
            var DeleteNationalityID = $(this).data('id');
            var DeleteNationalityDetails = { UserID: DeleteNationalityID};
     
            //alert(DeleteNationalityID);
    
          $.ajax({
                    type:'POST',
                    url:' DeleteUserSaveChanges.php',
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
                          $.getJSON("UserLoadData.php", null, function( json ){
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
    
    
    
    
    
$('#UserTypeAdd').change(function() {
        
        var UserTypeAddID = $(this).val();
        var UserTypeAddIndex = $("#UserTypeAdd").prop('selectedIndex');
        
         if(UserTypeAddIndex == 2 || UserTypeAddIndex == 5){
             
             //alert("teacher or supervisor");
             
            $.ajax({
                type:'POST',
                url:'GetUserDepartmentList.php',
                data:'country_id='+UserTypeAddID,
                success:function(html){
                    $('#AcademicDepartmentAdd').empty();
                    $('#s2id_AcademicDepartmentAdd span').text('');
                    $('#AcademicDepartmentAdd').html(html);
                    $("select#AcademicDepartmentAdd")[0].selectedIndex = 0;
                     var NewSelected = $("#AcademicDepartmentAdd option:selected").text();
                    $('#s2id_AcademicDepartmentAdd span').text(NewSelected);
                    
                }
            }); 
            
             
             
         }
        
        else{
            
                    $('#AcademicDepartmentAdd').empty();
                    $('#s2id_AcademicDepartmentAdd span').text('');
                    $('#AcademicDepartmentAdd').html('<option value="0">For Teachers and Supervisors Only </option>');
                    $("select#AcademicDepartmentAdd")[0].selectedIndex = 0;
                     var NewSelected = $("#AcademicDepartmentAdd option:selected").text();
                    $('#s2id_AcademicDepartmentAdd span').text(NewSelected);
            
            
        }
    
    
    });
    
    
    
    
});
    
     

    
    
    
    
$('#UserTypeEdit').change(function() {
        
        var UserTypeEditID = $(this).val();
        var UserTypeEditIndex = $("#UserTypeEdit").prop('selectedIndex');
        
         if(UserTypeEditIndex == 3 || UserTypeEditIndex == 6){
             
             //alert("teacher or supervisor");
             
            $.ajax({
                type:'POST',
                url:'GetUserDepartmentList.php',
                data:'country_id='+UserTypeEditID,
                success:function(html){
                    $('#AcademicDepartmentEdit').empty();
                    $('#s2id_AcademicDepartmentEdit span').text('');
                    $('#AcademicDepartmentEdit').html(html);
                    $("select#AcademicDepartmentEdit")[0].selectedIndex = 0;
                     var NewSelected = $("#AcademicDepartmentEdit option:selected").text();
                    $('#s2id_AcademicDepartmentEdit span').text(NewSelected);
                    
                }
            }); 
            
             
             
         }
        
        else{
            
                    $('#AcademicDepartmentEdit').empty();
                    $('#s2id_AcademicDepartmentEdit span').text('');
                    $('#AcademicDepartmentEdit').html('<option value="0">For Teachers and Supervisors Only </option>');
                    $("select#AcademicDepartmentEdit")[0].selectedIndex = 0;
                     var NewSelected = $("#AcademicDepartmentEdit option:selected").text();
                    $('#s2id_AcademicDepartmentEdit span').text(NewSelected);
            
            
        }
    
    
    });
    
    
    
    
//});
   
    
       
</script>
    


</body>
</html>