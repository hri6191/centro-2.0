<div class="">
	<div class="large-12 small-12 columns" id="navigate">
		<ul class="breadcrumbs">
		  <li><a href="<?php echo base_url(); ?>home" >Home</a></li>
                  <li><a href="<?php echo base_url(); ?>home?tab=reports" >Reports</a></li>
                  <li class="current"><a >Tax Report - Select Date</a></li>
		</ul>
	</div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>Select Date</h4>
    <div class="row">
            <form action="<?php echo base_url(); ?>reports/tax-report" name="for_edit" id="for_edit" method="post">
                <div class="large-4 columns">
                    <input type="text" id="select_date1" name="select_date1" value="<?php echo date('Y-m-d'); ?>" tabindex="1" placeholder="Select From Date Here...">
                </div>
                <div class="large-4 columns">
                    <input type="text" id="select_date2" name="select_date2" value="<?php echo date('Y-m-d'); ?>" tabindex="1" placeholder="Select To Date Here...">
                </div>
                <div class="large-4 columns">
                    <input type="submit" value="Submit" class="tiny button focus">
                </div>
            </form>
    </div>
</div>

<script>
$(document).ready(function() {      
        $('#select_date1').datepicker({ dateFormat: 'yy-mm-dd'});
        $('#select_date2').datepicker({ dateFormat: 'yy-mm-dd'});
});
</script>