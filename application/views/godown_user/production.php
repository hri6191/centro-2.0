<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li><a href="<?php echo base_url(); ?>home?tab=txn">Transaction</a></li>
            <li class="current"><a >Retail</a></li>
        </ul>
    </div>
    
</div>
<div class="row"></div>
<form action="<?php echo base_url(); ?>transaction/production/save_raw" method="post">
    <div class="" style="background: #ECFAFF; border-radius: 10px; border: 1px solid; border-color: #B6EFFF;">
        <div class="large-1 columns">
            <label>Sale Date
                <input type="text" name="sale_date"  id="sale_date" readonly value="<?php echo date("d-m-Y"); ?>" tabindex="1" />
            </label>
        </div>
    </div>
    <hr>
    <div class="large-12 small-12 columns" style="">
        <div class="row" style="background: #E8E8E8; border-right: 1px solid; border-color: #C7C7C7;">
            <div class="large-8 columns">
                <label>Item <span id="current_stock" style="color: red;"></span>
                    <input type="text" id="item_name" name="item_name" class="focus" tabindex="1" placeholder="Type Name/Code">
                </label>
            </div>
            <div class="large-1 columns">
                <label>Quantity
                    <input type="text" name="quantity" id="quantity" onkeyup="enter_key();" value="" tabindex="1" />
                </label>
            </div>
            <div class="large-2 columns">
                <label>Unit
                    <select id="unit" name="unit" tabindex="1" onchange="unit_change()" onkeyup="unit_change()" role="submit">
                    </select>
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

        <div class="row">
            <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
                <div id="jqxgrid">
                </div>
            </div>
        </div>

        <div class="row"><br/>
            
            <div class="large-4 columns name-field" style="float: right">
                <input type="submit" value="Submit" tabindex="1" class="button_zie button radius" id="save" onclick="return confirm('Are You Sure to Save?')" style="float: right;">
            </div>
        </div>

        <div id="purchased_data">
        </div>

    </div>
</form>

<?php $this->view('includes/grid_assets'); ?>

<script type="text/javascript">
    $(document).ready(function() {

        // initialize jqxGrid
        $("#jqxgrid").jqxGrid(
                {
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
                        container.append('<input style="margin-left: 5px;" id="deleterowbutton" type="button" value="Delete" />');
                        $("#deleterowbutton").jqxButton();
                    },
                    columns: [
                        {text: 'SI No', datafield: 'si_no', width: '5%'},
                        {text: 'Inventory Id', editable: false, datafield: 'item_id', width: '1%', hidden: true},
                        {text: 'SalePriceUpdate', editable: false, datafield: 'sale_price_update', width: '1%', hidden: true},
                        {text: 'Item Name', columngroup: 'ProductDetails', editable: false, datafield: 'item_name', width: '40%'},
                        {text: 'Description', columngroup: 'ProductDetails', editable: false, datafield: 'item_code', width: '35%'},
                        {text: 'Quantity', columngroup: 'ProductDetails', datafield: 'quantity', width: '10%'},
                        {text: 'Unit', columngroup: 'ProductDetails', editable: false, datafield: 'unit', width: '10%'}
                        
                    ]
                });
        $("#deleterowbutton").jqxButton();
        // delete row.
        $("#deleterowbutton").bind('click', function() {
            var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
            var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
            if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                var commit = $("#jqxgrid").jqxGrid('deleterow', id);
            }
            var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
            //$('#net_total').val(summaryData.sum);
            //$('#cash_paid').val(summaryData.sum);
            disc_all_change();
        });

        $('#add').click(function() {
             var rows = $('#jqxgrid').jqxGrid('getrows');
             for(var count=0; count<rows.length; count++) {
                 if(rows[count].item_id == $("#item_id").val()) {
                 alert("This item already added...!!");
                 return false; }
             }
            if($('#item_name').val() == '' || $('#quantity').val() == '') {
                $('#item_name').focus();
                return false;
            } else {
            var data = new Array();
            var row = new Array();
            row.si_no = ($("#jqxgrid").jqxGrid('getrows')).length + 1;
            row.item_id = $("#item_id").val();
            row.sale_price = $("#sale_price").val();
            row.sale_price_update = $("#sale_price").val();
            row.item_code = $("#item_code_selected").val();
            row.item_name = $("#item_name_selected").val();
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

            var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
            //$('#net_total').val(summaryData.sum);
            //$('#cash_paid').val(summaryData.sum);
//            disc_all_change();
        }
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
                    $('#item_name_selected').val(datas.item_name);
                    $('#item_code_selected').val(datas.item_code);
                    $('#purchase_price').val(datas.purchase_price);
                    $('#current_stock').html(' [STOCK: '+datas.current_stock+']');
                    if ($('#sale_type').val() == 1) {
                        $('#sale_price').val(datas.mrp);
                        $('#sold_price').val(datas.mrp);
                    } else if ($('#sale_type').val() == 2) {
                        $('#sale_price').val(datas.wholesale_price);
                        $('#sold_price').val(datas.wholesale_price);
                    } else if ($('#sale_type').val() == 3) {
                        $('#sale_price').val(datas.branch_price);
                        $('#sold_price').val(datas.branch_price);
                    }
                    $('#_unit').val(datas.default_unit);
                    var model = $('#unit');
                    model.empty();
                    model.append("<option value='" + datas.default_unit + "' selected>" + datas.default_unit + "</option>");
                    model.append("<option value='" + datas.alternative_unit + "'>" + datas.alternative_unit + "</option>");
                    $('#quantity').focus();
                }
            });
        }

        $("#customer").autocomplete({
            url: '<?php echo base_url(); ?>transaction/Search/vendor_list?output=json',
            sortFunction: function(a, b, filter) {
                var f = filter.toLowerCase();
                var fl = f.length;
                var a1 = a.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
                var a1 = a1 + String(a.data[0]).toLowerCase();
                var b1 = b.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
                var b1 = b1 + String(b.data[0]).toLowerCase();
                if (a1 > b1) {
                    return 1;
                }
                if (a1 < b1) {
                    return -1;
                }
                return 0;
            },
            showResult: function(data, value) {
                return '<span style="z-index: 2000;">' + data + '</span>';
            },
            onItemSelect: function(item) {
                $('#customer_selected').val(parseInt(item.data));
            },
            mustMatch: true,
            maxItemsToShow: 5,
            selectFirst: false,
            autoFill: true,
            selectOnly: true,
            remoteDataType: 'json',
            useCache: false
        });

        $("#real_customer").autocomplete({
            url: '<?php echo base_url(); ?>transaction/Search/vendor_list?output=json',
            sortFunction: function(a, b, filter) {
                var f = filter.toLowerCase();
                var fl = f.length;
                var a1 = a.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
                var a1 = a1 + String(a.data[0]).toLowerCase();
                var b1 = b.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
                var b1 = b1 + String(b.data[0]).toLowerCase();
                if (a1 > b1) {
                    return 1;
                }
                if (a1 < b1) {
                    return -1;
                }
                return 0;
            },
            showResult: function(data, value) {
                return '<span style="z-index: 2000;">' + data + '</span>';
            },
            onItemSelect: function(item) {
                $('#real_customer_selected').val(parseInt(item.data));
            },
            mustMatch: true,
            maxItemsToShow: 5,
            selectFirst: false,
            autoFill: true,
            selectOnly: true,
            remoteDataType: 'json',
            useCache: false
        });

        $("#item_name").autocomplete({
            url: '<?php echo base_url(); ?>transaction/Search/item_list?output=json',
            showResult: function(data, value) {
                return '<span style="z-index: 2000;">' + data + '</span>';
            },
            onItemSelect: function(item) {
                item_change(item.data);
            },
            mustMatch: true,
            maxItemsToShow: 30,
            selectFirst: false,
            autoFill: true,
            selectOnly: true,
            remoteDataType: 'json',
            minChars: 1,
            scrollHeight: 150,
            width: 185,
            max: 20,
            scroll: true,
            useCache: false
        });

        $("#save").on('click', function() { 
            var rows = $('#jqxgrid').jqxGrid('getrows');
            var rowscount = rows.length;
            if (rowscount <= 0)
            {
                alert('Add Atleast one item');
                $('body,html').animate({scrollTop: 0}, 1000);
                return false;
            }
            var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
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
                var inventory_code = $("<input>").attr("type", "hidden")
                        .attr('name', 'item_codes[]')
                        .val(datasb[k]['item_code']);
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
                var total = $("<input>").attr("type", "hidden")
                        .attr('name', 'total[]')
                        .val(((datasb[k]['sale_price'] * datasb[k]['quantity']) + +(datasb[k]['sale_price']*datasb[k]['quantity']*datasb[k]['tax']/100)).toFixed(2));

                $('#purchased_data').append($(inventory_id));
                $('#purchased_data').append($(inventory_name));
                $('#purchased_data').append($(inventory_code));
                $('#purchased_data').append($(quantity));
                $('#purchased_data').append($(unit));
                $('#purchased_data').append($(purchase_price));
                $('#purchased_data').append($(purchase_tax));
                $('#purchased_data').append($(sale_price));
                $('#purchased_data').append($(sale_price_update));
                $('#purchased_data').append($(disc_itemvise));
                $('#purchased_data').append($(total));
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
                        if ($('#sale_type').val() == 1) {
                        $('#sale_price').val((datas.sale_price / datas.alternative_unit_number));
                        $('#sold_price').val((datas.sale_price / datas.alternative_unit_number));
                    } else if ($('#sale_type').val() == 2) {
                        $('#sale_price').val((datas.sale_price2 / datas.alternative_unit_number));
                        $('#sold_price').val((datas.sale_price2 / datas.alternative_unit_number));
                    } else if ($('#sale_type').val() == 3) {
                        $('#sale_price').val((datas.sale_price3 / datas.alternative_unit_number));
                        $('#sold_price').val((datas.sale_price3 / datas.alternative_unit_number));
                    }
                    }
                    else
                    {
                        if ($('#sale_type').val() == 1) {
                        $('#sale_price').val(datas.sale_price);
                        $('#sold_price').val(datas.sale_price);
                    } else if ($('#sale_type').val() == 2) {
                        $('#sale_price').val(datas.sale_price2);
                        $('#sold_price').val(datas.sale_price2);
                    } else if ($('#sale_type').val() == 3) {
                        $('#sale_price').val(datas.sale_price3);
                        $('#sold_price').val(datas.sale_price3);
                    }
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
        var sale_price = sold_price - (sold_price*discount/100);
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
        var net_total = net_total - (net_total*discount/100);
        $('#net_total').val(Math.round(net_total));
        $('#cash_paid').val(Math.round(net_total));
        //saleprofit();
    }

    function PopupCenter(pageURL, title, w, h)
    {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
    
    function enter_key()
    {
        $('#quantity').bind('keydown', function(e) {
 
// detecting keycode returned from keydown and comparing if its equal to 13 (enter key code)
if (e.keyCode == 13) {
// by default if you hit enter key while on textbox so below code will prevent that default behaviour
e.preventDefault();

            if($('#item_name').val() == '' || $('#quantity').val() == '') {
                $('#item_name').focus();
                return false;
            } else {
                var rows = $('#jqxgrid').jqxGrid('getrows');
             for(var count=0; count<rows.length; count++) {
                 if(rows[count].item_id == $("#item_id").val()) {
                     var new_qn = $("#quantity").val();
                     var old_qn = $("#jqxgrid").jqxGrid('getcellvalue', count, 'quantity');
                     var qn = parseInt(new_qn)+parseInt(old_qn);
                     $("#jqxgrid").jqxGrid('setcellvalue', count, 'quantity', qn);
                     disc_all_change();
                     $('#item_name').focus();
                    $('#item_name').val('');
                    $('#quantity').val('');
                    $('#purchase_price').val('');
                    $('#sale_price').val('');
                    $('#sold_price').val('');
                    $('#disc_itemvise').val(0);
                    $('#profit_per').val('');
                     var updated = 1;
        }
             } if(updated != 1) {
            var data = new Array();
            var row = new Array();
            row.si_no = ($("#jqxgrid").jqxGrid('getrows')).length + 1;
            row.item_id = $("#item_id").val();
            row.sale_price = $("#sale_price").val();
            row.sale_price_update = $("#sale_price").val();
            row.item_code = $("#item_code_selected").val();
            row.item_name = $("#item_name_selected").val();
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
        }
    }

}
});
    }
</script>