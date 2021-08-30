<!--Footer-part-->

<div class="row-fluid">
  <div id="footer" class="span12"> 2019 &copy; Imus Unida Christian School
  </div>
</div>

<!--end-Footer-part-->

<!--<script src="js/excanvas.min.js"></script> -->
<script src="js/jquery.min.js"></script> 

<script src="js/jquery.ui.custom.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<!--
<script src="js/bootstrap-colorpicker.js"></script> -->
<!--
<script src="js/bootstrap-datepicker.js"></script> -->
<!--
<script src="js/jquery.toggle.buttons.js"></script> -->
<!--
<script src="js/masked.js"></script> -->
<script src="js/jquery.uniform.js"></script> 
<script src="js/select2.min.js"></script> 

<!--
<script src="js/jquery.dataTables.min.js"></script> -->



<script src="js/1-10-7-datatable.min.js"></script> 



<script src="js/matrix.js"></script> 
<!--
<script src="js/matrix.form_common.js"></script>-->
<script src="js/wysihtml5-0.3.0.js"></script> 
<script src="js/jquery.peity.min.js"></script> 
<script src="js/bootstrap-wysihtml5.js"></script> 
<!--
<script src="js/jquery.flot.min.js"></script> -->
<!--
<script src="js/jquery.flot.resize.min.js"></script> -->
<script src="js/jquery.peity.min.js"></script> 
<script src="js/fullcalendar.min.js"></script> 

<!-- Note: I removed matrix.js to prevent the auto closing of submenus in sidebar removed during system upgrade 1. 12/28/20 - Luwi Melo
-->
<!--
<script src="js/matrix.js"></script> -->
<!--
<script src="js/matrix.dashboard.js"></script> -->
<!--
 -->
<!--
<script src="js/matrix.interface.js"></script> -->
<script src="js/matrix.chat.js"></script> 
<script src="js/jquery.validate.js"></script> 
<script src="js/matrix.form_validation.js"></script> 
<script src="js/jquery.wizard.js"></script> 
<script src="js/matrix.popover.js"></script> 


<script src="js/jquery.gritter.min.js"></script>

<script src="js/matrix.tables.js"></script> 
    
<!--
<script type="text/javascript" src="./jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="./bootstrap/js/bootstrap.min.js"></script>
-->
<script type="text/javascript" src="datetimepicker/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="datetimepicker/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>

<script type="text/javascript">
  // This function is called from the pop-up menus to transfer to
  // a different page. Ignore if the value returned is a null string:
  function goPage (newURL) {

      // if url is empty, skip the menu dividers and reset the menu selection to default
      if (newURL != "") {
      
          // if url is "-", it is this page -- reset the menu:
          if (newURL == "-" ) {
              resetMenu();            
          } 
          // else, send page to designated URL            
          else {  
            document.location.href = newURL;
          }
      }
  }

// resets the menu selection upon entry to this page:
function resetMenu() {
   document.gomenu.selector.selectedIndex = 2;
}
</script>

