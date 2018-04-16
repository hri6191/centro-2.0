<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>home">Home</a></li>
              <li><a href="<?php echo base_url(); ?>home?tab=reports">Reports</a></li>
              <li class="current"><a href="#">Stock</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Stock Report</h4>
</div>
<div class="large-12 small-12 columns" style="">
    <div class="">
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
				{ name: 'ItemCode', type: 'string'},
				{ name: 'Hsn', type: 'string'},
				{ name: 'ItemGroup'},
				{ name: 'Sale'},
				{ name: 'Purchase'},
				{ name: 'CurrentStock'},
				{ name: 'Amount'},
				{ name: 'Delete'},
				{ name: 'Id'}
			],
			url: '<?php echo base_url()."godown_user/Reports_stock_ctrlr/stock_data"; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
                
                var linkrenderer = function (row, column, value) {
                    if (value.indexOf('#') != -1) {
                        value = value.substring(0, value.indexOf('#'));
                    }
                    href =  $('#jqxgrid').jqxGrid('getcellvalue', row, 'Id');
                    var html = "<a href=\"<?php echo base_url(); ?>registration/inventory/delete/"+href+"\">"+value+"</a>";
                    return html;
                };
			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                pageable: true,
                showstatusbar: true,
                showfilterrow: true,
                filterable: true,
                autoheight: true,
                sortable: true,
                altrows: true,
                enabletooltips: true,
                showaggregates: true,
		
		columns: [
			{ text: 'Item Name', datafield: 'ItemName', width: '15%', align: 'center'},
			{ text: 'Item Code', datafield: 'ItemCode', width: '10%', align: 'center'},
			{ text: 'HSN Code', datafield: 'Hsn', width: '10%', align: 'center'},
			{ text: 'Item Group', datafield: 'ItemGroup', filtertype: 'list', width: '15%', align: 'center'},
			{ text: 'Sale', datafield: 'Sale', filtertype: 'none', width: '10%', align: 'center', cellsalign: 'right'},
			{ text: 'Purchase', datafield: 'Purchase', filtertype: 'none', width: '10%', align: 'center', cellsalign: 'right'},
			{ text: 'Stock', datafield: 'CurrentStock',filtertype: 'none', width: '10%',align: 'center', cellsalign: 'center' },
			{ text: 'Stock Amount', datafield: 'Amount', filtertype: 'none', width: '10%',align: 'center', aggregates: ['sum'], cellsalign: 'right',  },
			{ text: 'Delete', datafield: 'Delete', filtertype: 'none', width: '10%',cellsrenderer: linkrenderer,align: 'center', cellsalign: 'center',  },
			{ text: 'Id', datafield: 'Id', filtertype: 'none', hidden: 'true', width: '10%',align: 'center', cellsalign: 'center',  }
		]
		});        
	});
</script>