<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
              <li class="current"><a href="#">Single Sale Order</a></li>
            </ul>
    </div>
</div>
<form action="<?php echo base_url(); ?>transaction/so-c/save" method="post">
    <input type="hidden" id="sale_id" value="<?php echo $sale_id; ?>" name="sale_id" >
    <div class="row" style="background: #ECFAFF; border-radius: 10px; border: 1px solid; border-color: #B6EFFF;">
        <div class="large-4 columns">
            <label>Agent
                <input type="text" id="customer" value="<?php echo $customer[0]->vendor_name; ?>" readonly name="customer" >
                <input type="hidden" id="customer_id" value="<?php echo $customer[0]->id; ?>" name="customer_id" >
            </label>
        </div>
        <div class="large-6 columns">
            <label>Party
                <input type="hidden" name="real_customer_id"  id="real_customer_id" readonly value="<?php echo $real_customer_id; ?>" />
                <input type="text" name="real_customer"  id="real_customer" readonly value="<?php echo $real_customer[0]->real_customer_name.'('.$real_customer[0]->phone_no.')'; ?>" />
            </label>
        </div>
        <div class="large-2 columns">
            <label>Sale Date
                <input type="text" name="sale_date"  id="sale_date" readonly value="<?php echo $sale_date; ?>" />
            </label>
        </div>
        <input type="hidden" name="invoice_no" id="invoice_no" value="<?php echo $invoice_number; ?>" readonly  />
        <input type="hidden" name="sale_total" id="sale_total" value="<?php echo $sale_total; ?>" readonly  />
    </div>
    <div class="row" style="background: #E8E8E8; border-right: 1px solid; border-color: #C7C7C7;">
            <div class="large-4 columns">
                <label>Item
                    <input type="text" id="item_name" name="item_name" tabindex="1" placeholder="Type Name/Code">
                </label>
            </div>
            <div class="large-1 columns">
                <label>Quantity
                    <input type="text" name="quantity" id="quantity" value="" tabindex="1" />
                </label>
            </div>
            <div class="large-2 columns">
                <label>Unit
                    <select id="unit" name="unit" tabindex="1" onchange="unit_change()" onkeyup="unit_change()" role="submit">
                    </select>
                </label>
            </div>
            <div class="large-2 columns name-field">
                <label>Price
                    <input type="text" name="sold_price" tabindex="1" id="sold_price" onkeyup="disc_change()" >
                </label>
            </div>
            <input type="hidden" name="sale_price" id="sale_price" >
            <div class="large-1 columns">
                <label>Discount
                    <input type="text" name="disc_itemvise"  id="disc_itemvise" value="0" tabindex="1" onkeyup="disc_change()" />
                </label>
            </div>
            <div class="large-1 columns name-field">
                <label>Tax<br/>
                    <input type="checkbox" name="i_tax" tabindex="1" id="i_tax" onkeyup="disc_change()" >
                </label>
            </div>
            <input type="hidden" name="item_name_selected"  id="item_name_selected"/>
            <input type="hidden" name="item_code_selected"  id="item_code_selected"/>
            <input type="hidden" name="item_id"  id="item_id"/>
            <input type="hidden" name="tax_hid"  id="tax_hid"/>
            <input type="hidden" name="unit_hid"  id="unit_hid"/>
            <div class="large-1 columns">
                <label>Add
                    <input type="button" name="add" class="tiny button"  id="add" value="ADD" tabindex="1" />
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
        <div class="large-2 columns name-field">
                <label>Discount
                    <input type="text" name="discount_all" value="<?php echo $discount_all; ?>" tabindex="" id="discount_all" onkeyup="disc_all_change()" >
                </label>
            </div>
            <div class="large-2 columns name-field">
                <label>Net Total
                    <input type="text" name="net_total" tabindex="" id="net_total" readonly >
                </label>
            </div>
            <div class="large-8 columns name-field">
                <label>Remark
                    <input type="text" name="remarks" tabindex="" id="remarks" value="<?php echo $remarks; ?>" >
                </label>
            </div>
    </div>
    <div id="purchased_data">
        </div>
    <br/>
    <?php if($is_cancel == 1) { ?>
    <div class="row">
                <div class="large-4 columns" style="text-align: center;">
                    <a href="<?php echo base_url().'transaction/so-c/delete?sale_id='.$sale_id; ?>"><input type="button" value="Delete Order" class="button_zie button radius" id="delete_sale" onclick="return confirm('Are You Sure to Delete?')" style="background-color: red;"></a>
                </div>
                <div class="large-4 column" style="text-align: center;">
                    <input type="submit" name="update" value="Update Order" class="button_zie button radius save" id="update" onclick="return confirm('Are You Sure to Update Order?')" style="background-color: #ffcc00;">
                </div>
                <div class="large-4 column" style="text-align: center;">
                    <input type="submit" name="confirm" value="Confirm Order" class="button_zie button radius save" id="save" onclick="return confirm('Are You Sure to Confirm Order?')" style="background-color: green;">
                </div>
    </div>
    <?php } ?>
</form>

<?php $this->view('includes/grid_assets'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        
        var source =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'si_no'},            
                            {name: 'item_id'},
                            {name: 'item_name'},
                            //{name: 'item_code'},
                            {name: 'quantity'},
                            {name: 'unit'},
                            {name: 'sale_price'},
                            {name: 'disc_itemvise'},
                            {name: 'tax'},
                            {name: 'total'}
                        ],
                        url: '<?php echo base_url() . "confirmation_center/trans_sale_confirm_ctrlr/single_so_c_data?sale_id=" . $sale_id; ?>',
                        cache: false
                    };

            var dataAdapter = new $.jqx.dataAdapter(source);

        // initialize jqxGrid
        $("#jqxgrid").jqxGrid(
                {
                    source: source,
                    width: '100%',
                    //pageable: true,
                    showstatusbar: true,
                    statusbarheight: 35,
                    autoheight: true,
                    sortable: true,
                    altrows: true,
                    enabletooltips: true,
                    showaggregates: true,
                    editable: true,
                    showtoolbar: true,
                    rendertoolbar: function(toolbar) {
                            var me = this;
                            var container = $("<div style='margin: 5px;'></div>");
                            toolbar.append(container);
                            container.append('<input style="margin-left: 5px;" id="deleterowbutton" type="button" value="Delete Selected Item" /><input type="button" style="margin-left: 5px;" id="clearbutton" value="Clear All Items" />');
                            $("#deleterowbutton").jqxButton();
                            // delete row.
                            $("#deleterowbutton").on('click', function() {
                                var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                                if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                                    var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                                    var commit = $("#jqxgrid").jqxGrid('deleterow', id);
                                }
                            });
    //                    $("#jqxgrid").jqxGrid('selectionmode', 'multiplerows');
                            $("#clearbutton").jqxButton();

                            $('#clearbutton').click(function() {
                                $('#jqxgrid').jqxGrid('clear');

                            });
                        },
                    columns: [
                        {text: 'SI No', datafield: 'si_no', width: '5%'},
                        {text: 'Inventory Id', editable: false, datafield: 'item_id', width: '1%', hidden: true},
                        //{text: 'Item Code', columngroup: 'ProductDetails', editable: false, datafield: 'item_code', width: '15%'},
                        {text: 'Item Name', columngroup: 'ProductDetails', editable: false, datafield: 'item_name', width: '22%'},
                        {text: 'Quantity', columngroup: 'ProductDetails', datafield: 'quantity', width: '11%'},
                        {text: 'Unit', columngroup: 'ProductDetails', editable: false, datafield: 'unit', width: '11%'},
                        {text: 'Price', columngroup: 'CashDetails', editable: true, datafield: 'sale_price', width: '16%', columntype: 'numberinput',
                            validation: function(cell, value) {
                                if (value < 0) {
                                    return {result: false, message: "Price should positive value"};
                                }
                                return true;
                            },
                            createeditor: function(row, cellvalue, editor) {
                                editor.jqxNumberInput({decimalDigits: 2, digits: 7});
                            }},
                        {text: 'Discount', columngroup: 'CashDetails', editable: false, datafield: 'disc_itemvise', width: '11%'},
                        {text: 'Tax %', columngroup: 'CashDetails', datafield: 'tax', width: '8%'},
                        {text: 'Total', columngroup: 'CashDetails', editable: false, datafield: 'total', width: '16%',
                            cellsrenderer: function(index, datafield, value, defaultvalue, column, rowdata) {
                                disc_all_change();
                                var total2 = (parseFloat(rowdata.sale_price) * parseFloat(rowdata.quantity)) + +(parseFloat(rowdata.sale_price)* parseFloat(rowdata.quantity) * parseFloat(rowdata.tax)/100);
                                return "<div style='margin: 4px;' class='jqx-right-align'>" + total2 + "</div>";
                            },
                        }
                    ],
                    columngroups: [
                        {text: 'Product Details', align: 'center', name: 'ProductDetails'},
                        {text: 'Cash Details', align: 'center', name: 'CashDetails'}
                    ]
                });

        $('#add').click(function() {
            var data = new Array();
            var row = new Array();
            row.si_no = ($("#jqxgrid").jqxGrid('getrows')).length + 1;
            row.item_id = $("#item_id").val();
            row.sale_price = $("#sale_price").val();
            row.sale_price_update = $("#sale_price").val();
            row.item_code = $("#item_code_selected").val();
            row.item_name = $("#item_name").val();
            row.unit = $("#unit").val();
            row.quantity = $("#quantity").val();
            row.disc_itemvise = $('#disc_itemvise').val();
            row.tax = $('#tax_hid').val();
            if ($('#i_tax').is(':checked')) {
                row.total = parseFloat(row.quantity) * (parseFloat(row.sale_price) + (parseFloat(row.sale_price) * parseFloat(row.tax) / 100));
            } else {
                row.total = parseFloat(row.quantity) * (parseFloat(row.sale_price));
                row.sale_price = (parseFloat(row.sale_price) * (100 / (100 + parseFloat(row.tax)))).toFixed(2);
            }
            data.push(row);
            $("#jqxgrid").jqxGrid('addrow', null, data);
            $('#item_name').focus();
            $('#item_name').val('');
            $('#quantity').val('');
            $('#purchase_price').val('');
            $('#sale_price').val('');
            $('#sold_price').val('');
            $('#disc_itemvise').val(0);
            $('#profit_per').val('');

            var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'total', ['sum']);
            //$('#net_total').val(summaryData.sum);
            //$('#cash_paid').val(summaryData.sum);
            disc_all_change();
        });

        function item_change(item_id)
        {
            var datas;
            $.ajax({
                type: "post",
                data: {item_id: parseInt(item_id)},
                url: "<?php echo base_url() . "json/get_inventory_by_id"; ?>",
                dataType: "json",
                success: function(data) {
                    datas = data;
                    $('#item_id').val(item_id);
                    $('#tax_hid').val(datas.tax);
                    //$('#item_name').val(datas.item_name);
                    $('#item_code_selected').val(datas.item_code);
                    $('#purchase_price').val(datas.purchase_price);
                    if ($('#sale_type').val() != 2) {
                        $('#sale_price').val(datas.mrp);
                        $('#sold_price').val(datas.mrp);
                    } else {
                        $('#sale_price').val(datas.wholesale_price);
                        $('#sold_price').val(datas.wholesale_price);
                    }
                    $('#_unit').val(datas.default_unit);
                    var model = $('#unit');
                    model.empty();
                    model.append("<option value='" + datas.default_unit + "' selected>" + datas.default_unit + "</option>");
                    model.append("<option value='" + datas.alternative_unit + "'>" + datas.alternative_unit + "</option>");
                }
            });
        }

        $("#item_name").autocomplete({
            url: '<?php echo base_url(); ?>transaction/search/item_list?output=json',
            showResult: function(data, value) {
                return '<span style="z-index: 2000;">' + data + '</span>';
            },
            onItemSelect: function(item) {
                item_change(item.data);
            },
            mustMatch: true,
            maxItemsToShow: 10,
            selectFirst: false,
            autoFill: true,
            selectOnly: true,
            remoteDataType: 'json'
        });

        $(".save").on('click', function() {
            var rows = $('#jqxgrid').jqxGrid('getrows');
            var rowscount = rows.length;
            if (rowscount <= 0)
            {
                alert('Add Atleast one item');
                $('body,html').animate({scrollTop: 0}, 1000);
                return false;
            }
            var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'total', ['sum']);
            //alert("Total: " + summaryData.sum);
            $('#purchased_data').empty();
            var gd = $("#jqxgrid").jqxGrid('getrows');
            var datas = new Array();
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

                var inventory_id = $("<input>").attr("type", "hidden")
                        .attr('name', 'inventory_ids[]')
                        .val(datasb[k]['item_id']);
                var inventory_name = $("<input>").attr("type", "hidden")
                        .attr('name', 'item_names[]')
                        .val(datasb[k]['item_name']);
                var quantity = $("<input>").attr("type", "hidden")
                        .attr('name', 'quantitys[]')
                        .val(datasb[k]['quantity']);
                var unit = $("<input>").attr("type", "hidden")
                        .attr('name', 'units[]')
                        .val(datasb[k]['unit']);
                var purchase_price = $("<input>").attr("type", "hidden")
                        .attr('name', 'purchase_prices[]')
                        .val(datasb[k]['purchase_price']);
                var purchase_tax = $("<input>").attr("type", "hidden")
                        .attr('name', 'purchase_taxs[]')
                        .val(datasb[k]['tax']);
                var sale_price = $("<input>").attr("type", "hidden")
                        .attr('name', 'sale_prices[]')
                        .val(datasb[k]['sale_price']);
                var sale_price_update = $("<input>").attr("type", "hidden")
                        .attr('name', 'sale_price_updates[]')
                        .val(datasb[k]['sale_price_update']);
                var disc_itemvise = $("<input>").attr("type", "hidden")
                        .attr('name', 'disc_itemvises[]')
                        .val(datasb[k]['disc_itemvise']);
//                var total = $("<input>").attr("type", "hidden")
//                        .attr('name', 'total[]')
//                        .val(datasb[k]['total']);

                $('#purchased_data').append($(inventory_id));
                $('#purchased_data').append($(inventory_name));
                $('#purchased_data').append($(quantity));
                $('#purchased_data').append($(unit));
                $('#purchased_data').append($(purchase_price));
                $('#purchased_data').append($(purchase_tax));
                $('#purchased_data').append($(sale_price));
                $('#purchased_data').append($(sale_price_update));
                $('#purchased_data').append($(disc_itemvise));
//                $('#purchased_data').append($(total));
            }
//            var sale_total_without_discount = $("<input>").attr("type", "hidden")
//                    .attr('name', 'sale_total_without_discount')
//                    .val(summaryData.sum);
//            $('#purchased_data').append($(sale_total_without_discount));
        });

    });
</script>

<script>
    function unit_change()
    {
        if ($('#sale_type').val() != 2) {
            var item_id = $("#item_id").val();
            var datas;
            $.ajax({
                type: "post",
                data: {item_id: parseInt(item_id)},
                url: "<?php echo base_url() . "json/get_inventory_for_unit_change"; ?>",
                dataType: "json",
                success: function(data) {
                    datas = data;
                    if ($('#unit').val() != datas.default_unit)
                    {
                        //$('#purchase_price').val((datas.purchase_price/datas.alternative_unit_number));
                        $('#sale_price').val((datas.sale_price / datas.alternative_unit_number));
                        $('#sold_price').val((datas.sale_price / datas.alternative_unit_number));
                    }
                    else
                    {
                        //$('#purchase_price').val(datas.purchase_price);
                        $('#sale_price').val(datas.sale_price);
                        $('#sold_price').val(datas.sale_price);
                    }
                    //saleprofit();
                }
            });
        } else {
            var item_id = $("#item_id").val();
            var datas;
            $.ajax({
                type: "post",
                data: {item_id: parseInt(item_id)},
                url: "<?php echo base_url() . "json/get_inventory_for_unit_change2"; ?>",
                dataType: "json",
                success: function(data) {
                    datas = data;
                    if ($('#unit').val() != datas.default_unit)
                    {
                        //$('#purchase_price').val((datas.purchase_price/datas.alternative_unit_number));
                        $('#sale_price').val((datas.sale_price / datas.alternative_unit_number));
                        $('#sold_price').val((datas.sale_price / datas.alternative_unit_number));
                    }
                    else
                    {
                        //$('#purchase_price').val(datas.purchase_price);
                        $('#sale_price').val(datas.sale_price);
                        $('#sold_price').val(datas.sale_price);
                    }
                    //saleprofit();
                }
            });
        }
    }

    $('#stock_date').datepicker().keydown(function(e) {
        //e.preventDefault();
        var code = e.keyCode || e.which;
        if (code != '9') {
            if (code == '37' || code == '38' || code == '39' || code == '40') {
                var parts = $(this).val().split("/");
                var currentDate = new Date(parts[2], parts[0] - 1, parts[1]);
                switch (code) {
                    case 37:
                        currentDate.setDate(currentDate.getDate() - 1);
                        break;
                    case 38:
                        currentDate.setDate(currentDate.getDate() - 7);
                        break;
                    case 39:
                        currentDate.setDate(currentDate.getDate() + 1);
                        break;
                    case 40:
                        currentDate.setDate(currentDate.getDate() + 7);
                        break;
                }
                if (currentDate != null) {
                    $(this).datepicker("setDate", currentDate);
                }
            } else {
                return false;
            }
        }
    });
    $('#sale_date').datepicker().keydown(function(e) {
        //e.preventDefault();
        var code = e.keyCode || e.which;
        if (code != '9') {
            if (code == '37' || code == '38' || code == '39' || code == '40') {
                var parts = $(this).val().split("/");
                var currentDate = new Date(parts[2], parts[0] - 1, parts[1]);
                switch (code) {
                    case 37:
                        currentDate.setDate(currentDate.getDate() - 1);
                        break;
                    case 38:
                        currentDate.setDate(currentDate.getDate() - 7);
                        break;
                    case 39:
                        currentDate.setDate(currentDate.getDate() + 1);
                        break;
                    case 40:
                        currentDate.setDate(currentDate.getDate() + 7);
                        break;
                }
                if (currentDate != null) {
                    $(this).datepicker("setDate", currentDate);
                }
            } else {
                return false;
            }
        }
    });

//    function saleprofit()
//    {
//        var purchase_price = parseFloat($('#purchase_price').val());
//        var sale_price = parseFloat($('#sale_price').val());
//        //var profit_per = parseFloat($('#profit_per').val());
//        var profit_per = ((sale_price - purchase_price) / purchase_price) * 100;
//        $('#profit_per').val(profit_per.toFixed(2));
//    }
//
//    function saleprofit2()
//    {
//        var purchase_price = parseFloat($('#purchase_price').val());
//        var profit_per = parseFloat($('#profit_per').val());
//        var sale_price = purchase_price + (purchase_price * profit_per / 100);
//        $('#sale_price').val(sale_price.toFixed(2));
//    }

    function disc_change()
    {
        var sold_price = $('#sold_price').val();
        var discount = $('#disc_itemvise').val();
        var sale_price = sold_price - discount;
        $('#sale_price').val(sale_price);
    }

    function disc_all_change()
    {
        var gd = $("#jqxgrid").jqxGrid('getrows');
                                var datas = new Array();
                                var datasb = new Array();
                                var datasc = new Array();
                                for (var i = 0; i < gd.length; i++) {
                                    datas.push(gd[i]);
                                }
                                for (var j = 0; j < datas.length; j++) {
                                    datasb.push(datas[j]);
                                }
                                var total = '';
                                for (var k = 0; k < datasb.length; k++) {
                                    total = +total + +((+datasb[k]['sale_price'] * datasb[k]['quantity']) + +(+datasb[k]['sale_price']*+datasb[k]['quantity']*+datasb[k]['tax']/100));
                                }
        
        var net_total = total.toFixed(2);
        var discount = $('#discount_all').val();
        var net_total = net_total - discount;
        $('#net_total').val(Math.round(net_total));
//        $('#cash_paid').val(net_total);
        //saleprofit();
    }

    function PopupCenter(pageURL, title, w, h)
    {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>