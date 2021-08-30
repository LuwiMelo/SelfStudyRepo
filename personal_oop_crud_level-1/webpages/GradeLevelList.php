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
 <center><h1>Grade Level and Fees Maintenance 
     </h1></center>
     <br>
     
 <center><h1>School Fees are listed for S.Y. <?php echo $_SESSION['SessionSelectedSchoolYear'];?> 
     </h1></center>
     
     
     
     <div class="row-fluid">
         
         <div class="span10"></div>
         <button class="btn btn-primary" id="btnAddNewNationality">Add New Grade Level</button>
         
         <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Data table</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered" id="StudentRecordsList">
              <thead>
            <tr>
                <th>ID</th>
                <th>Grade Level</th>
                <th>Cash Basis</th>
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
                <h3>Add New Grade Level</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">

         
              <label class="control-label">*Grade Level ID(System Generated) :</label>
              <div class="controls">
                <input type="text" name="NationalityIDAdd" id="NationalityIDAdd" class="span4" placeholder="Nationality ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityIDAddError"  name="NationalityIDAddError">Invalid Nationality ID</span>
              </div>

                  <br>
                  
                  
             <label class="control-label">*School Year (System Generated) :</label>
              <div class="controls">
                <input type="text" name="SchoolYearDisplayAdd" id="SchoolYearDisplay" class="span4" placeholder="Nationality ID" value = "<?php echo $_SESSION['SessionSelectedSchoolYear']; ?>" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;"   >Invalid School Year </span>
              </div>

                  <br>
                  
                  
              
            <label class="control-label">*Grade Level :</label>
              <div class="controls">
                <input type="text" name="NationalityNameAdd" id="NationalityNameAdd" class="span4" placeholder="e.g. 	001-Pre-Kinder 1 (3 yrs old)" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="NameAddError"  name="NameAddError">This field is required</span>
              </div>
                  
                
             <br>
             <label class="control-label">*Tuition Fee (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="TuitionFeeAdd" id="TuitionFeeAdd" class="span4" placeholder="e.g. 27530" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="TuitionFeeAddError"  name="TuitionFeeAddError">Invalid Amount</span>
              </div>
                  
            <br>
                  
             <label class="control-label">*Registration Fee (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="RegistrationFeeAdd" id="RegistrationFeeAdd" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="RegistrationFeeAddError"  name="RegistrationFeeAddError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
             <label class="control-label">*Miscellaneous Fee (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="MiscFeeAdd" id="MiscFeeAdd" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="MiscFeeAddError"  name="MiscFeeAddError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
              <label class="control-label">*Option A Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionAAdd" id="OptionAAdd" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionAAddError"  name="OptionAAddError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
                  
              <label class="control-label">*Option B Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionBAdd" id="OptionBAdd" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionBAddError"  name="OptionBAddError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
                  
              <label class="control-label">*Option C Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionCAdd" id="OptionCAdd" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionCAddError"  name="OptionCAddError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
              <label class="control-label">*Option D Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionDAdd" id="OptionDAdd" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionDAddError"  name="OptionDAddError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
              <label class="control-label">*Distance Learning Discount (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="DistanceLearningDiscount" id="DistanceLearningDiscount" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="DistanceLearningDiscountError"  name="DistanceLearningDiscountError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
                  
                  
                
              </div>
    
    
              <div class="modal-footer"> <a id="AddNationalitySaveChanges"  class="btn btn-success" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     
     
     
     
<div id="EditNationalityModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Edit Grade Level</h3>
              </div>
              <div class="modal-body" style="margin-left: 80px;">
                  
               <input type="hidden" id="SFID" name="SFID">      
                  
              <label class="control-label">*Grade Level ID :</label>
              <div class="controls">
                <input type="text" name="NationalityIDEdit" id="NationalityIDEdit" class="span4" placeholder="Nationality ID" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityIDEditError"  name="NationalityIDEditError">Invalid Nationality ID</span>
              </div>

                  <br>
                  
              <label class="control-label">*School Year (System Generated) :</label>
              <div class="controls">
                <input type="text" name="SchoolYearDisplayEdit" id="SchoolYearDisplayEdit" class="span4" placeholder="Nationality ID" value = "<?php echo $_SESSION['SessionSelectedSchoolYear']; ?>" disabled/>
                <span class="help-inline" style="color: #b94a48; display: none;"   >Invalid School Year </span>
              </div>

                  <br>
              
            <label class="control-label">*Grade Level :</label>
              <div class="controls">
                <input type="text" name="NationalityNameEdit" id="NationalityNameEdit" class="span4" placeholder="e.g. 	001-Pre-Kinder 1 (3 yrs old)" />
                <span class="help-inline" style="color: #b94a48; display: none;" id="NationalityNameEditError"  name="NationalityNameEditError">Invalid Grade Level</span>
              </div>
            
                  
            <br>
                  
                  
                  
             <label class="control-label">*Tuition Fee (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="TuitionFeeEdit" id="TuitionFeeEdit" class="span4" placeholder="e.g. 27530" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="TuitionFeeEditError"  name="TuitionFeeEditError">Invalid Amount</span>
              </div>
                  
            <br>
                  
             <label class="control-label">*Registration Fee (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="RegistrationFeeEdit" id="RegistrationFeeEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="RegistrationFeeEditError"  name="RegistrationFeeEditError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
             <label class="control-label">*Miscellaneous Fee (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="MiscFeeEdit" id="MiscFeeEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="MiscFeeEditError"  name="MiscFeeEditError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
              <label class="control-label">*Option A Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionAEdit" id="OptionAEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionAEditError"  name="OptionAEditError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
                  
              <label class="control-label">*Option B Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionBEdit" id="OptionBEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionBEditError"  name="OptionBEditError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
                  
              <label class="control-label">*Option C Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionCEdit" id="OptionCEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionCEditError"  name="OptionCEditError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
              <label class="control-label">*Option D Add On (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="OptionDEdit" id="OptionDEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="OptionDEditError"  name="OptionDEditError">Invalid Amount</span>
              </div>
                  
                  <br>
                  
              <label class="control-label">*Distance Learning Discount (DO NOT USE COMMA):</label>
              <div class="controls">
                <input type="text" name="DistanceLearningDiscountEdit" id="DistanceLearningDiscountEdit" class="span4" placeholder="e.g. 1000" value=""/>
                <span class="help-inline" style="color: #b94a48; display: none;" id="DistanceLearningDiscountEditError"  name="DistanceLearningDiscountEditError">Invalid Amount</span>
              </div>
                  
                  <br>
            
     
              </div>
    
    
              <div class="modal-footer"> <a id="EditSaveChanges" class="btn btn-primary" href="#">Confirm</a> <a data-dismiss="modal" class="btn" href="#">Cancel</a> </div>
</div>
     


     
     
     
     
     <div id="DeleteNationalityModal" class="modal hide">
              <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">×</button>
                <h3>Warning! Delete Grade Level</h3>
              </div>
              <div class="modal-body" style="">

                <h4>Are you sure you want to delete this grade level? All STUDENTS and SECTIONS registered with this grade level will be updated to grade level not set </h4>
            
                  
            
     
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
                            "sAjaxSource": "GradeLevelLoadData.php",
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
                    url:'GetLatestGradeLevelID.php',
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
            var SFId = $(this).data('sfid');
    
            var tuition = $(this).data('tuition');
            var registration = $(this).data('registration');
            var misc = $(this).data('misc');
            var optiona = $(this).data('optiona');
            var optionb = $(this).data('optionb');
            var optionc = $(this).data('optionc');
            var optiond = $(this).data('optiond');
            var distance = $(this).data('distance');
        
    
            $("#EditNationalityModal").modal("show");
            $("#NationalityIDEdit").val(NationalityID);
            $("#NationalityNameEdit").val(NationalityName);
    
    
            $("#TuitionFeeEdit").val(tuition);
            $("#RegistrationFeeEdit").val(registration);
            $("#MiscFeeEdit").val(misc);
            $("#OptionAEdit").val(optiona);
            $("#OptionBEdit").val(optionb);
            $("#OptionCEdit").val(optionc);
            $("#OptionDEdit").val(optiond);
            $("#DistanceLearningDiscountEdit").val(distance);

    
            $("#SFID").val(SFId);
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
     
     var FormValidator = true;
     var AddID = $("#NationalityIDAdd").val();
     var AddNationalityName = $("#NationalityNameAdd").val();

            if(AddNationalityName == null || AddNationalityName == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#NameAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#NameAddError").hide();
            }
     
     var TuitionFeeAdd = $("#TuitionFeeAdd").val();
    
    
            if(isNaN(TuitionFeeAdd) || TuitionFeeAdd == null || TuitionFeeAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#TuitionFeeAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#TuitionFeeAddError").hide();
            }
    
    

    
    
    var RegistrationFeeAdd = $("#RegistrationFeeAdd").val();
    
    
            if(isNaN(RegistrationFeeAdd) || RegistrationFeeAdd == null || RegistrationFeeAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#RegistrationFeeAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#RegistrationFeeAddError").hide();
            }
    
    
    
    var MiscFeeAdd = $("#MiscFeeAdd").val();
    
    
            if(isNaN(MiscFeeAdd) || MiscFeeAdd == null || MiscFeeAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#MiscFeeAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#MiscFeeAddError").hide();
            }
    
    
    var OptionAAdd  = $("#OptionAAdd").val();
    
            if(isNaN(OptionAAdd) || OptionAAdd == null || OptionAAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionAAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionAAddError").hide();
            }
    
    
    var OptionBAdd = $("#OptionBAdd").val();

            if(isNaN(OptionBAdd) || OptionBAdd == null || OptionBAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionBAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionBAddError").hide();
            }
    
    var OptionCAdd = $("#OptionCAdd").val();
    
            if(isNaN(OptionCAdd) || OptionCAdd == null || OptionCAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionCAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionCAddError").hide();
            }
    
    var OptionDAdd = $("#OptionDAdd").val();
    
            if(isNaN(OptionDAdd) || OptionDAdd == null || OptionDAdd == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionDAddError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionDAddError").hide();
            }
    
    
    var DistanceLearningDiscount = $("#DistanceLearningDiscount").val();
    

            if(isNaN(DistanceLearningDiscount) || DistanceLearningDiscount == null || DistanceLearningDiscount == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#DistanceLearningDiscountError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#DistanceLearningDiscountError").hide();
            }
    
    
    
    
    
     var AddNationalityDetails = { GradeLevelID: AddID, GradeLevel: AddNationalityName, TuitionFeeAdd: TuitionFeeAdd, RegistrationFeeAdd: RegistrationFeeAdd, MiscFeeAdd: MiscFeeAdd, OptionAAdd: OptionAAdd, OptionBAdd: OptionBAdd, OptionCAdd: OptionCAdd, OptionDAdd: OptionDAdd, DistanceLearningDiscount: DistanceLearningDiscount };
     
    
    if(FormValidator){
             $.ajax({
                    type:'POST',
                    url:'AddGradeLevelSaveChanges.php',
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
                          $.getJSON("GradeLevelLoadData.php", null, function( json ){
                                table = $("#StudentRecordsList").dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);

                                for (var i=0; i<json.aaData.length; i++){
                                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                                }
                                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                    table.fnDraw();
                          });
                          
                        
                        $("#AddNewNationalityModal").modal('hide');
                        
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
        
        
    }
    

      
    
    
    
 });
    
    
        
//Edit Record Save Changes
$("#EditSaveChanges").click(function(e){
     
     var EditID = $("#NationalityIDEdit").val();
     var SFID = $("#SFID").val();
     var EditNationalityName = $("#NationalityNameEdit").val();
     var FormValidator = true;
    
    
       if(EditNationalityName == null || EditNationalityName == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#NationalityNameEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#NationalityNameEditError").hide();
            }
     
     var TuitionFeeEdit = $("#TuitionFeeEdit").val();
    
    
            if(isNaN(TuitionFeeEdit) || TuitionFeeEdit == null || TuitionFeeEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#TuitionFeeEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#TuitionFeeEditError").hide();
            }

    
    
    var RegistrationFeeEdit = $("#RegistrationFeeEdit").val();
    
    
            if(isNaN(RegistrationFeeEdit) || RegistrationFeeEdit == null || RegistrationFeeEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#RegistrationFeeEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#RegistrationFeeEditError").hide();
            }
    
    
    
    var MiscFeeEdit = $("#MiscFeeEdit").val();
    
    
            if(isNaN(MiscFeeEdit) || MiscFeeEdit == null || MiscFeeEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#MiscFeeEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#MiscFeeEditError").hide();
            }
    
    
    var OptionAEdit  = $("#OptionAEdit").val();
    
            if(isNaN(OptionAEdit) || OptionAEdit == null || OptionAEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionAEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionAEditError").hide();
            }
    
    
    var OptionBEdit = $("#OptionBEdit").val();

            if(isNaN(OptionBEdit) || OptionBEdit == null || OptionBEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionBEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionBEditError").hide();
            }
    
    var OptionCEdit = $("#OptionCEdit").val();
    
            if(isNaN(OptionCEdit) || OptionCEdit == null || OptionCEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionCEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionCEditError").hide();
            }
    
    var OptionDEdit = $("#OptionDEdit").val();
    
            if(isNaN(OptionDEdit) || OptionDEdit == null || OptionDEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#OptionDEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#OptionDEditError").hide();
            }
    
    
    var DistanceLearningDiscountEdit = $("#DistanceLearningDiscountEdit").val();
    

            if(isNaN(DistanceLearningDiscountEdit) || DistanceLearningDiscountEdit == null || DistanceLearningDiscountEdit == ""){
                FormValidator = false;
                //$("#LRNNumControlGroup").addClass("error");
                $("#DistanceLearningDiscountEditError").show();
            }
            else{
              // $("#LRNNumControlGroup").removeClass("error");
               $("#DistanceLearningDiscountEditError").hide();
            }
    
    
    
     var EditNationalityDetails = { GradeLevelID: EditID, GradeLevel: EditNationalityName, TuitionFeeEdit: TuitionFeeEdit, RegistrationFeeEdit: RegistrationFeeEdit, MiscFeeEdit: MiscFeeEdit, OptionAEdit: OptionAEdit, OptionBEdit: OptionBEdit, OptionCEdit: OptionCEdit, OptionDEdit: OptionDEdit, DistanceLearningDiscountEdit: DistanceLearningDiscountEdit, SFID: SFID };
     
    
    
    
    if(FormValidator){
             $.ajax({
                    type:'POST',
                    url:' EditGradeLevelSaveChanges.php',
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
                          $.getJSON("GradeLevelLoadData.php", null, function( json ){
                                table = $("#StudentRecordsList").dataTable();
                                oSettings = table.fnSettings();
                                table.fnClearTable(this);

                                for (var i=0; i<json.aaData.length; i++){
                                    table.oApi._fnAddData(oSettings, json.aaData[i]);
                                }
                                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                                    table.fnDraw();
                          });
                          
                        $("#EditNationalityModal").modal('hide');
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
        
        
    }//if form validator is true
              
 });
    
    
    

    
    
//Delete Record Save Changes
$("#DeleteNationalitySaveChanges").click(function(e){
     
            var DeleteNationalityID = $(this).data('id');
            var DeleteNationalityDetails = { GradeLevelID: DeleteNationalityID};
     
            //alert(DeleteNationalityID);
    
          $.ajax({
                    type:'POST',
                    url:' DeleteGradeLevelSaveChanges.php',
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
                          $.getJSON("GradeLevelLoadData.php", null, function( json ){
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