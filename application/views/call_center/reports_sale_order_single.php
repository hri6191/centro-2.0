<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
              <li class="current"><a href="#">Single Sale Order</a></li>
            </ul>
    </div>
</div>
<form action="<?php echo base_url(); ?>reports/create-pdf" method="post">
    <div class="row" style="background: #ECFAFF; border-radius: 10px; border: 1px solid; border-color: #B6EFFF;">
        <div class="large-3 columns">
            <label>Agent
                <input type="text" id="customer" value="<?php echo $customer[0]->vendor_name; ?>" readonly name="customer" >
                <input type="hidden" id="customer_id" value="<?php echo $customer[0]->id; ?>" name="customer_id" >
            </label>
        </div>
        <div class="large-2 columns">
            <label>Party
                <input type="text" name="school"  id="school" readonly value="<?php echo $real_customer[0]->real_customer_name; ?>" />
            </label>
        </div>
        <div class="large-2 columns">
            <label>Invoice Number
                <input type="text" name="invoice_no" id="invoice_no" value="<?php echo $invoice_number; ?>" readonly  />
            </label>
        </div>
        <div class="large-2 columns">
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
    <div id="pdf_data">
    </div>
    <br/>
    <?php if($is_cancel == 1) { ?>
    <div class="row">
        <div class="">
            <div class="large-12 small-12 columns name-field" style="text-align: center;">
<!--                <a href="<?php echo base_url().'transaction/sale-order/delete?sale_id='.$sale_id; ?>"><input type="button" value="Delete Sale Order" class="button_zie button radius" id="delete_sale" onclick="return confirm('Are You Sure to Delete?')"></a> -->
<!--                <input type="submit" value="Print" class="button_zie button radius" id="print" onclick="return confirm('Are You Sure to Print?')" style="float: right;">-->
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
				{ name: 'item_name'},
				{ name: 'sale_price'},
				{ name: 'quantity'},
                                { name: 'gross'},
                                { name: 'discount'},
				{ name: 'net_value'}
			],
			url: '<?php echo base_url()."call_center/reports_sale_order_ctrlr/single_sale_order_data?sale_id=".$sale_id; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                //pageable: true,
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
			{ text: 'Item Name', datafield: 'item_name',filtertype: 'none', width: '30%'},
			{ text: 'Rate', datafield: 'sale_price',filtertype: 'none', width: '15%' },
			{ text: 'Quantity', datafield: 'quantity',filtertype: 'none', width: '10%' },
			{ text: 'Gross', datafield: 'gross',filtertype: 'none', width: '15%' },
			{ text: 'Discount%', datafield: 'discount',filtertype: 'none', width: '10%' },
                        { text: 'Net Value', datafield: 'net_value',filtertype: 'none', aggregates: ['sum'], width: '20%' }
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
                var quantity = $("<input>").attr("type", "hidden")
                                                          .attr('name','quantitys[]')
                                                          .val(datasb[k]['Quantity']);
                var sale_price = $("<input>").attr("type", "hidden")
                                                          .attr('name','sale_prices[]')
                                                          .val(datasb[k]['SalePrice']);
                var disc_itemvise = $("<input>").attr("type", "hidden")
                                                          .attr('name','disc_itemvises[]')
                                                          .val(datasb[k]['DiscountAmount']);
                var disc_per = $("<input>").attr("type", "hidden")
                                                          .attr('name','disc_pers[]')
                                                          .val(datasb[k]['DiscountPer']);
                var total = $("<input>").attr("type", "hidden")
                                                          .attr('name','total[]')
                                                          .val(datasb[k]['NetValue']);
                $('#pdf_data').append($(inventory_name));
                $('#pdf_data').append($(quantity));
                $('#pdf_data').append($(sale_price));
                $('#pdf_data').append($(disc_itemvise));
                $('#pdf_data').append($(disc_per));
                $('#pdf_data').append($(total));
        }
        });
                
	});
</script>