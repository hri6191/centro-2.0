<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>home" >Home</a></li>
              <li><a href="<?php echo base_url(); ?>home?tab=reports" >Reports</a></li>
              <li class="current"><a >Gst Report</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <?php if($select_date1 == $select_date2) { ?>
    <h4>GST [B2C] Data as on <?php echo date("F j, Y", strtotime($select_date1)); ?></h4> <?php } else { ?>
    <h4>GST [B2C] Data From <?php echo date("F j, Y", strtotime($select_date1)); ?> to <?php echo date("F j, Y", strtotime($select_date2)); ?></h4><?php } ?>
</div>
<div class="large-12 small-12 columns" style="">
    <div class="row">
        <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
            <div id="jqxgrid"></div>
        </div>
    </div>
</div>

<div class="row" style="text-align: center;">
    <input type="button" style="margin: 10px;" value="Export to JSON" id='excelExport' class="button tiny" />
</div>

<?php $this->view('includes/grid_assets'); ?>

<script type="text/javascript">
$(document).ready(function () {
	   
         
		var source =
		{
			datatype: "json",
			datafields: [
                                { name: 'sply_ty', type: 'string'},
                                {name: 'rt', type: 'string'},
				{ name: 'typ', type: 'string'},
				{ name: 'pos', type: 'string'},
                                { name: 'txval', type: 'string'},
				{ name: 'iamt', type: 'string'},
				{ name: 'csamt', type: 'string'},
				{ name: 'camt', type: 'string'},
				{ name: 'samt', type: 'string'}
			],
			url: '<?php echo base_url()."godown_user/Reports_tax_ctrlr/gst_data1?txn_date1=".$select_date1."&txn_date2=".$select_date2; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
 			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                pageable: false,
                showstatusbar: true,
                statusbarheight: 35,
                showfilterrow: true,
                filterable: true,
                autoheight: true,
                sortable: true,
                showaggregates: true,
                altrows: true,
                enabletooltips: true,
                groupable: true,
                showgroupsheader: true,
		
		columns: [
			{ text: 'sply_ty', datafield: 'sply_ty', width: '12%', filtertype: 'none'},
			{ text: 'rt', datafield: 'rt', width: '11%', filtertype: 'none' },
                        { text: 'typ', datafield: 'typ', width: '11%', filtertype: 'none' },
                        { text: 'pos', datafield: 'pos', width: '11%', filtertype: 'none' },
                        { text: 'txval', datafield: 'txval', width: '11%', filtertype: 'none' },
                        { text: 'iamt', datafield: 'iamt', width: '11%', filtertype: 'none' },
                        { text: 'csamt', datafield: 'csamt', width: '11%', filtertype: 'none' },
                        { text: 'camt', datafield: 'camt', width: '11%', filtertype: 'none' },
                        { text: 'samt', datafield: 'samt', width: '11%', filtertype: 'none' }
		]
		});
                
                $("#excelExport").jqxButton();
                
                $("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'json', 'jqxGrid');           
            });
                
	});
</script>