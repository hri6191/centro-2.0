<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
              <li class="current"><a href="#">Purchase</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Purchase Report</h4>
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
				{ name: 'ReferenceNumber'},
				{ name: 'Vendor'},
				{ name: 'InvoiceNumber'},
                                { name: 'PurchaseDate'},
				{ name: 'PurchaseType'},
                                { name: 'PurchaseTotal'}
			],
			url: '<?php echo base_url()."reports/reports_purchase_ctrlr/purchase_data"; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                pageable: true,
                showstatusbar: true,
                statusbarheight: 35,
                showfilterrow: true,
                filterable: true,
                autoheight: true,
                sortable: true,
                showaggregates: true,
                altrows: true,
                enabletooltips: true,
		
		columns: [
			{ text: 'Reference Number', datafield: 'ReferenceNumber',filtertype: 'number', width: '15%'},
			{ text: 'Vendor', datafield: 'Vendor', width: '20%' },
			{ text: 'Invoice Number', datafield: 'InvoiceNumber',filtertype: 'none', width: '15%', cellsrenderer: function(row, cell, value) {
            return '<a href="<?php echo base_url(); ?>reports/purchase/invoice/'+value+'" target="_blank"/>'+value+'</a>'
} },
                        { text: 'Purchase Date', datafield: 'PurchaseDate',filtertype: 'date', width: '15%' },
			{ text: 'Purchase Type', datafield: 'PurchaseType', width: '15%' },
                        { text: 'Purchase Total', datafield: 'PurchaseTotal',filtertype: 'number', aggregates: ['sum'], width: '20%' }
		]
		});        
	});
</script>