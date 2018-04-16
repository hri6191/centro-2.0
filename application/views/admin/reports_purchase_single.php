<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
              <li class="current"><a href="#">Single Purchase</a></li>
            </ul>
    </div>
</div>
<div class="row" style="background: #ECFAFF; border-radius: 10px; border: 1px solid; border-color: #B6EFFF;">
    <div class="large-2 columns name-field">
        <label>Reference Number
            <input type="text" name="reference_no" value="<?php echo $reference_number; ?>" disabled id="reference_no" >
        </label>
    </div>
    <div class="large-2 columns">
        <label>Vendor
            <input type="text" id="vendor" value="<?php echo $vendor[0]->vendor_name; ?>" disabled name="vendor" >
        </label>
    </div>
    <div class="large-2 columns">
        <label>Invoice Number
            <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice_number; ?>" disabled  />
        </label>
    </div>
    <div class="large-2 columns">
        <label>Purchase Date
            <input type="text" name="purchase_date"  id="purchase_date" disabled value="<?php echo $purchase_date; ?>" />
        </label>
    </div>
    <div class="large-2 columns">
        <label>Stock Date
            <input type="text" name="stock_date"  id="stock_date" disabled value="<?php echo $stock_date; ?>" />
        </label>
    </div>
    <div class="large-2 columns">
        <label>Purchase Type
            <input type="text" name="purchase_type"  id="purchase_type" disabled value="<?php echo $purchase_type; ?>" />
        </label>
    </div>
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
				{ name: 'Quantity'},
				{ name: 'Unit'},
                                { name: 'Tax'},
				{ name: 'PurchasePrice'}
			],
			url: '<?php echo base_url()."reports/reports_purchase_ctrlr/single_purchase_data?purchase_id=".$purchase_id; ?>',
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
			{ text: 'Item Name', datafield: 'ItemName', width: '30%'},
			{ text: 'Quantity', datafield: 'Quantity',filtertype: 'number', width: '15%' },
			{ text: 'Unit', datafield: 'Unit',filtertype: 'none', width: '15%' },
                        { text: 'Tax%', datafield: 'Tax',filtertype: 'none', width: '15%' },
			{ text: 'Purchase Price', datafield: 'PurchasePrice',filtertype: 'number', width: '25%' }
		]
		});        
	});
</script>