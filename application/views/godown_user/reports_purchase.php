<style>
    .green {
        color: black\9;
        background-color: #b6ff00\9;
    }
    .yellow {
        color: black\9;
        background-color: yellow\9;
    }
    .red {
        color: black\9;
        background-color: #e83636\9;
    }

    .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
        color: black;
        background-color: #b6ff00;
    }
    .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
        color: black;
        background-color: yellow;
    }
    .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
        color: black;
        background-color: #e83636;
    }
</style>
<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>home">Home</a></li>
              <li><a href="<?php echo base_url(); ?>home?tab=reports">Reports</a></li>
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
<div class="row" style="text-align: center;">
    <input type="button" style="margin: 10px;" value="Export to Excel" id='excelExport' class="button tiny" />
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
				{ name: 'Description'},
                                { name: 'PurchaseDate'},
				{ name: 'PurchaseType'},
                                { name: 'PurchaseTotal'},
                                {name: 'Status'},
                                { name: 'Edit'}
			],
			url: '<?php echo base_url()."godown_user/Reports_purchase_ctrlr/purchase_data"; ?>',
			cache: false
		};
                
                var cellclass = function(row, columnfield, value) {
            status = $('#jqxgrid').jqxGrid('getcellvalue', row, 'Status');
            if (status == 2) {
                return 'yellow';
            }
                else if (status == 3) {
                    return 'green';
                }
                else if (status == 1) {
                    return 'red';
                }
        }

		var dataAdapter = new $.jqx.dataAdapter(source);
                
                var linkrenderer = function (row, column, value) {
                    if (value.indexOf('#') != -1) {
                        value = value.substring(0, value.indexOf('#'));
                    }
                    href =  $('#jqxgrid').jqxGrid('getcellvalue', row, 'ReferenceNumber');
                    var html = "<a href=\"<?php echo base_url(); ?>transaction/purchase/edit/"+href+"\">"+value+"</a>";
                    return html;
                };
                
                var linkrenderer2 = function (row, column, value) {
                    if (value.indexOf('#') != -1) {
                        value = value.substring(0, value.indexOf('#'));
                    }
                    href =  $('#jqxgrid').jqxGrid('getcellvalue', row, 'ReferenceNumber');
                    var html = "<a href=\"<?php echo base_url(); ?>reports/purchase/invoice/"+href+"\">"+value+"</a>";
                    return html;
                };
			
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
			{ text: 'Reference Number', datafield: 'ReferenceNumber',filtertype: 'number', width: '10%', cellclassname: cellclass},
			{ text: 'Vendor', datafield: 'Vendor', width: '15%', cellclassname: cellclass },
			{ text: 'Invoice Number', datafield: 'InvoiceNumber',filtertype: 'none', width: '15%', cellsrenderer: linkrenderer2, cellclassname: cellclass },
                        { text: 'Purchase Date', datafield: 'PurchaseDate',filtertype: 'date', width: '15%', cellclassname: cellclass },
			{ text: 'Purchase Type', datafield: 'PurchaseType', width: '10%', hidden: 'true' },
                        { text: 'Purchase Total', datafield: 'PurchaseTotal',filtertype: 'number', cellsformat: 'f2', aggregates: ['sum'], width: '20%', cellclassname: cellclass, cellsalign: 'right' },
                        {text: 'Status', datafield: 'Status', hidden: true, width: '25%'},
                        { text: 'Description', datafield: 'Description', width: '15%', cellclassname: cellclass },
			{ text: 'Edit', datafield: 'Edit', width: '10%', cellsrenderer: linkrenderer, cellclassname: cellclass }
		]
		});  
                
                $("#excelExport").jqxButton();
                
                $("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'jqxGrid');           
            });
	});
</script>