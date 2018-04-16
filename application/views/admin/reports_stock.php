<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
              <li class="current"><a href="#">Stock</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Stock Report</h4>
</div>
<div class="large-12 small-12 columns" style="">
    <div class="row">
        <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
            <div id="jqxgrid"></div>
        </div>
    </div>
</div>

<?php $this->view('includes/grid_assets'); ?>

<script type="text/javascript">
$(document).ready(function () {
	   
         
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'ItemName'},
				{ name: 'ItemGroup'},
				{ name: 'CurrentStock'},
                                { name: 'Unit'},
				{ name: 'MinimumStock'}
			],
			url: '<?php echo base_url()."reports/reports_stock_ctrlr/stock_data"; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                pageable: true,
                showfilterrow: true,
                filterable: true,
                autoheight: true,
                sortable: true,
                altrows: true,
                enabletooltips: true,
		
		columns: [
			{ text: 'Item Name', datafield: 'ItemName', width: '25%'},
			{ text: 'Item Group', datafield: 'ItemGroup', width: '20%' },
			{ text: 'Current Stock', datafield: 'CurrentStock',filtertype: 'number', width: '20%' },
                        { text: 'Unit', datafield: 'Unit',filtertype: 'none', width: '15%' },
			{ text: 'Minimum Stock', datafield: 'MinimumStock',filtertype: 'none', width: '20%' }
		]
		});        
	});
</script>