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
            <form action="<?php echo base_url(); ?>reports/gst-report1" name="for_edit" id="for_edit" method="post">
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
    <hr>
    <h4><u>GSTR1 [B2C] DOWNLOAD</u></h4><br/>
    <div class="row">
        <form action="<?php echo base_url(); ?>reports/gst-upload1" name="for_edit" enctype="multipart/form-data" id="for_edit" method="post">
                <div class="large-3 columns">Month-Year(mmyyyy)
                    <input type="text" id="fp" name="fp" value="<?php echo date(mY); ?>" tabindex="1">
                </div>
                <div class="large-2 columns">GT
                    <input type="text" id="gt" name="gt" value="0" tabindex="1">
                </div>
                <div class="large-2 columns">Current GT
                    <input type="text" id="cur_gt" name="cur_gt" value="0" tabindex="1">
                </div>
                <div class="large-3 columns">Import
                    <input type="file" id="json_file" name="json_file" tabindex="1">
                </div>
                <div class="large-2 columns"><br/>
                    <input type="submit" value="GSTR1 DOWNLOAD" class="small button focus">
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