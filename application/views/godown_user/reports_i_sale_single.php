<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
              <li class="current"><a href="#">Single Interstate Sale</a></li>
            </ul>
    </div>
</div>
<form action="<?php echo base_url(); ?>reports/interstate-sale/create-pdf" method="post">
    <div class="row" style="background: #ECFAFF; border-radius: 10px; border: 1px solid; border-color: #B6EFFF;">
        <div class="large-4 columns">
            <label>Customer
                <input type="text" id="customer" value="<?php echo $customer[0]->vendor_name; ?>" readonly name="customer" >
                <input type="hidden" id="customer_id" value="<?php echo $customer[0]->id; ?>" name="customer_id" >
            </label>
        </div>
        <input type="hidden" id="dc_no" value="<?php echo $dc_no; ?>" name="dc_no" >
        <input type="hidden" id="vehicle_no" value="<?php echo $vehicle_no; ?>" name="vehicle_no" >
<!--        <div class="large-2 columns">
            <label>School
                <input type="text" name="school"  id="school" readonly value="<?php echo $school; ?>" />
            </label>
        </div>-->
        <div class="large-2 columns">
            <label>Invoice Number
                <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice_number; ?>" readonly  />
            </label>
        </div>
        <div class="large-3 columns">
            <label>Sale Date
                <input type="text" name="sale_date"  id="sale_date" readonly value="<?php echo $sale_date; ?>" />
            </label>
        </div>
        <div class="large-3 columns">
            <label>Sale Total
                <input type="text" name="sale_total" id="sale_total" value="<?php echo $sale_total; ?>" readonly  />
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
    <div class="row">
        <div class="large-3 columns">
            <label>Discount
                <input type="text" id="total_discount" value="<?php echo $total_discount; ?>" name="total_discount" readonly >
            </label>
        </div>
<!--        <div class="large-3 columns">
            <label>Net Total
                <input type="text" id="total_discount" value="<?php //echo $total_discount; ?>" name="total_discount" readonly >
            </label>
        </div>-->
    </div>
    <div id="pdf_data">
    </div>
    <br/>
    <?php if($is_cancel != 1) { ?>
    <div class="row">
        <div class="">
            <div class="large-12 small-12 columns name-field">
                <a href="<?php echo base_url().'transaction/interstate-sale/delete?sale_id='.$sale_id; ?>"><input type="button" value="Delete Sale" class="button_zie button radius" id="delete_sale" onclick="return confirm('Are You Sure to Delete?')" style="float: left;"></a>  
                <input type="submit" value="Print" class="button_zie button radius focus" id="print" onclick="return confirm('Are You Sure to Print?')" style="float: right;">
            </div>
        </div>
    </div>
    <?php } ?>
</form>

<?php $this->view('includes/grid_assets'); ?>

<script type="text/javascript">
$(document).ready(function () {
	   
         
		var source =
		{
			datatype: "json",
			datafields: [
				{ name: 'ItemName'},
				{ name: 'ItemCode'},
				{ name: 'SalePrice'},
				{ name: 'Quantity'},
                                { name: 'Unit'},
                                { name: 'Tax'},
				{ name: 'DiscountAmount'},
				{ name: 'NetValue'}
			],
			url: '<?php echo base_url()."godown_user/Reports_i_sale_ctrlr/single_sale_data?sale_id=".$sale_id; ?>',
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
			{ text: 'Item Name', datafield: 'ItemName',filtertype: 'none', width: '20%'},
			{ text: 'Description', datafield: 'ItemCode',filtertype: 'none', width: '15%'},
			{ text: 'Rate', datafield: 'SalePrice',filtertype: 'none', width: '10%' },
			{ text: 'Quantity', datafield: 'Quantity',filtertype: 'none', width: '10%' },
			{ text: 'Unit', datafield: 'Unit',filtertype: 'none', width: '10%' },
			{ text: 'Tax', datafield: 'Tax',filtertype: 'none', width: '5%' },
                        { text: 'Discount Amount', datafield: 'DiscountAmount',filtertype: 'none', width: '15%' },
                        { text: 'Net Value', datafield: 'NetValue',filtertype: 'none', aggregates: ['sum'], width: '15%' }
		]
		});        
                
                
                $("#print").on('click', function () {
            var rows = $('#jqxgrid').jqxGrid('getrows');
            var rowscount = rows.length;
            if(rowscount<=0)
            {
             alert('Add Atleast one item');
             $('body,html').animate({scrollTop:0},1000);
             return false;
            }
            var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'NetValue', ['sum']);
            //alert("Total: " + summaryData.sum);
            $('#pdf_data').empty();
            var gd     =  $("#jqxgrid").jqxGrid('getrows');
            var datas  = new Array();
            var datasb = new Array();
            var datasc = new Array(); 
            for (var i = 0; i < gd.length; i++) 
            {
              datas.push(gd[i]);
            }

            for (var j = 0; j < datas.length; j++)
            {
              datasb.push(datas[j]);
            }
            for (var k = 0; k < datasb.length; k++) 
            {
                var inventory_name = $("<input>").attr("type", "hidden")
                                                          .attr('name','item_names[]')
                                                          .val(datasb[k]['ItemName']);
                var inventory_code = $("<input>").attr("type", "hidden")
                                                          .attr('name','item_codes[]')
                                                          .val(datasb[k]['ItemCode']);
                var quantity = $("<input>").attr("type", "hidden")
                                                          .attr('name','quantitys[]')
                                                          .val(datasb[k]['Quantity']);
                var sale_price = $("<input>").attr("type", "hidden")
                                                          .attr('name','sale_prices[]')
                                                          .val(datasb[k]['SalePrice']);
                var unit = $("<input>").attr("type", "hidden")
                                                          .attr('name','units[]')
                                                          .val(datasb[k]['Unit']);
                var disc_itemvise = $("<input>").attr("type", "hidden")
                                                          .attr('name','disc_itemvises[]')
                                                          .val(datasb[k]['DiscountAmount']);
                var sale_tax = $("<input>").attr("type", "hidden")
                                                          .attr('name','sale_taxs[]')
                                                          .val(datasb[k]['Tax']);
                var total = $("<input>").attr("type", "hidden")
                                                          .attr('name','total[]')
                                                          .val(datasb[k]['NetValue']);
                $('#pdf_data').append($(inventory_name));
                $('#pdf_data').append($(inventory_code));
                $('#pdf_data').append($(quantity));
                $('#pdf_data').append($(sale_price));
                $('#pdf_data').append($(unit));
                $('#pdf_data').append($(disc_itemvise));
                $('#pdf_data').append($(sale_tax));
                $('#pdf_data').append($(total));
        }
        });
                
	});
</script>