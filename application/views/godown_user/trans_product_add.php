<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li><a href="<?php echo base_url(); ?>home?tab=txn">Transaction</a></li>
            <li class="current"><a href="#">Purchase</a></li>
        </ul>
    </div>
</div>
<div class="row"></div>
<form action="<?php echo base_url(); ?>transaction/production/add_product" method="post">
    <div class="" style="background: #ECFAFF; border-radius: 10px; border: 1px solid; border-color: #B6EFFF;">
        
        <div class="large-2 columns">
            <label>Production Date
                <input type="text" name="purchase_date"  id="purchase_date" readonly value="<?php echo date("d-m-Y"); ?>" tabindex="2" />
            </label>
        </div>
        <div class="large-2 columns">
            <label>Description
                <input type="text" placeholder="Enter LR No or Courier No etc..." name="description"  id="description" tabindex="2" />
            </label>
        </div>
    </div>
    <hr>
    <div class="large-12 small-12 columns" style="">
        <div class="large-12 columns" style="background: #E8E8E8;">
            <div class="large-8 columns">
                <label>Item<a onclick="PopupCenter('<?php echo base_url() . "registration/inventory"; ?>', 'Inventory', 400, 400);" href="javascript:void(0);" style="float: right;">NEW ITEM?</a>
                    <input type="text" id="item_name" name="item_name" tabindex="6" placeholder="Type Name/Code">
                </label>
            </div>
            <div class="large-1 columns">
                <label>Quantity
                    <input type="text" name="quantity" id="quantity" value="1" tabindex="7" />
                </label>
            </div>
            <div class="large-2 columns">
                <label>Unit
                    <select id="unit" name="unit" tabindex="8" onchange="unit_change()" onkeyup="unit_change()" role="submit">
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
                    <input type="button" name="add" class="tiny button"  id="add" value="ADD" tabindex="12" />
                </label>
            </div>
        </div>

        <div class="large-12 columns" style="background: #E8E8E8;">
            <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
                <div id="jqxgrid">
                </div>
            </div>
        </div>

        <div class="large-12 columns"><br/>
            <div class="large-3 columns name-field" id="interex_amount_div" style="display: none;">
                <label>Tax Amount
                    <input type="text" id="interex_amount" tabindex="12" value="0" name="interex_amount" onkeyup="interex_keyup()">
                </label>
            </div>
            <div class="large-3 columns name-field" id="interex_percentage_div" style="display: none;">
                <label>Tax Percentage
                    <input type="text" id="interex_percentage" tabindex="12" value="0" name="interex_percentage" onkeyup="interex_keyup2()">
                </label>
            </div>
            <div class="large-3 columns name-field">
            </div>
        </div>

        <div class="large-12 columns"><br/>
            <div class="large-2 columns name-field" style="float: right">
                <input type="submit" value="Save Purchase" tabindex="12" class="button_zie button radius" id="save" onclick="return confirm('Are You Sure to Save?')" style="float: right;">
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
                    pageable: true,
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
                        {text: 'Sales Price', editable: false, datafield: 'sale_price', width: '1%', hidden: true},
                        {text: 'Profit Per', editable: false, datafield: 'profit_per', width: '1%', hidden: true},
                        {text: 'Item Code', columngroup: 'ProductDetails', editable: false, datafield: 'item_code', width: '35%'},
                        {text: 'Item Name', columngroup: 'ProductDetails', editable: false, datafield: 'item_name', width: '35%'},
                        {text: 'Quantity', columngroup: 'ProductDetails', datafield: 'quantity', width: '15%'},
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
            $('#net_total').val(summaryData.sum);
            $('#cash_paid').val(summaryData.sum);
        });

        $('#add').click(function() {
            if ($('#item_name').val() == '' || $('#quantity').val() == '') {
                $('#item_name').focus();
                return false;
            } else {
                var data = new Array();
                var row = new Array();
                row.si_no = ($("#jqxgrid").jqxGrid('getrows')).length + 1;
                row.item_id = $("#item_id").val();
                row.sale_price = $("#sale_price").val();
                row.profit_per = $("#profit_per").val();
                row.item_code = $("#item_code_selected").val();
                row.item_name = $("#item_name").val();
                row.unit = $("#unit").val();
                row.quantity = $("#quantity").val();
                row.purchase_price = $('#purchase_price').val();
                row.disc_itemvise = $('#disc_itemvise').val();
                row.tax = $('#tax_hid').val();
                row.total = parseFloat(row.quantity) * (parseFloat(row.purchase_price) + (parseFloat(row.purchase_price) * parseFloat(row.tax) / 100));
//                if($('#purchase_type').val() != 1) {
//                    row.total = parseFloat(row.quantity) * (parseFloat(row.purchase_price));
//                }
                data.push(row);
                $("#jqxgrid").jqxGrid('addrow', null, data);
                $('#item_name').focus();
                $('#item_name').val('');
                $('#quantity').val('');
                $('#purchase_price').val('');
                $('#purchased_price').val('');
                $('#disc_itemvise').val(0);
                $('#sale_price').val('');
                $('#profit_per').val('');

                var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
                $('#net_total').val(summaryData.sum);
                $('#cash_paid').val(summaryData.sum);
            }
        });

        function item_change(item_id)
        {
            var datas;
            $.ajax({
                type: "post",
                data: {item_id: parseInt(item_id)},
                url: "<?php echo base_url() . "Json/get_inventory_by_id"; ?>",
                dataType: "json",
                success: function(data) {
                    datas = data;
                    $('#item_id').val(item_id);
                    $('#tax_hid').val(datas.tax);
                    //$('#item_name').val(datas.item_name);
                    $('#item_code_selected').val(datas.item_code);
                    $('#purchase_price').val(datas.purchase_price);
                    $('#purchased_price').val(datas.purchase_price);
                    $('#sale_price').val(datas.mrp);
                    $('#_unit').val(datas.default_unit);
                    var model = $('#unit');
                    model.empty();
                    model.append("<option value='" + datas.default_unit + "' selected>" + datas.default_unit + "</option>");
                    model.append("<option value='" + datas.alternative_unit + "'>" + datas.alternative_unit + "</option>");
                }
            });
        }

        $("#vendor").autocomplete({
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
                $('#vendor_selected').val(parseInt(item.data));
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
            maxItemsToShow: 10,
            selectFirst: false,
            autoFill: true,
            selectOnly: true,
            remoteDataType: 'json',
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
                var quantity = $("<input>").attr("type", "hidden")
                        .attr('name', 'quantitys[]')
                        .val(datasb[k]['quantity']);
                var unit = $("<input>").attr("type", "hidden")
                        .attr('name', 'units[]')
                        .val(datasb[k]['unit']);
                var purchase_price = $("<input>").attr("type", "hidden")
                        .attr('name', 'purchase_prices[]')
                        .val(datasb[k]['purchase_price']);
                var disc_itemvise = $("<input>").attr("type", "hidden")
                        .attr('name', 'disc_itemvises[]')
                        .val(datasb[k]['disc_itemvise']);
                var purchase_tax = $("<input>").attr("type", "hidden")
                        .attr('name', 'purchase_taxs[]')
                        .val(datasb[k]['tax']);
                var sale_price = $("<input>").attr("type", "hidden")
                        .attr('name', 'sale_prices[]')
                        .val(datasb[k]['sale_price']);
                var profit_per = $("<input>").attr("type", "hidden")
                        .attr('name', 'profit_pers[]')
                        .val(datasb[k]['profit_per']);
                var total = $("<input>").attr("type", "hidden")
                        .attr('name', 'total[]')
                        .val(datasb[k]['total']);

                $('#purchased_data').append($(inventory_id));
                $('#purchased_data').append($(quantity));
                $('#purchased_data').append($(unit));
                $('#purchased_data').append($(purchase_price));
                $('#purchased_data').append($(disc_itemvise));
                $('#purchased_data').append($(purchase_tax));
                $('#purchased_data').append($(sale_price));
                $('#purchased_data').append($(profit_per));
                $('#purchased_data').append($(total));
            }
            var purchase_total = $("<input>").attr("type", "hidden")
                    .attr('name', 'purchase_total')
                    .val($('#net_total').val());
            $('#purchased_data').append($(purchase_total));
        });

        
        $("#from_account").on('change', function() {
            var hh = $(this).children(":selected").attr("id");
        if ($('#from_account').val() != 'cash_book') {
            var group = $('#'+hh).attr("label");
            $('#from_account_group').val(group);
            $('#check_div').show();
        } else {
            $('#from_account_group').val('Cash In Hand');
            $('#check_div').hide();
        }
    });


    });
</script>

<script>
    function unit_change()
    {
        var item_id = $("#item_id").val();
        var datas;
        $.ajax({
            type: "post",
            data: {item_id: parseInt(item_id)},
            url: "<?php echo base_url() . "Json/get_inventory_for_unit_change"; ?>",
            dataType: "json",
            success: function(data) {
                datas = data;
                if ($('#unit').val() != datas.default_unit)
                {
                    $('#purchase_price').val((datas.purchase_price / datas.alternative_unit_number));
                    $('#purchased_price').val((datas.purchase_price / datas.alternative_unit_number));
                    $('#sale_price').val((datas.sale_price / datas.alternative_unit_number));
                }
                else
                {
                    $('#purchase_price').val(datas.purchase_price);
                    $('#purchased_price').val(datas.purchase_price);
                    $('#sale_price').val(datas.sale_price);
                }
                saleprofit();
            }
        });
    }

    function disc_change()
    {
        var purchased_price = $('#purchased_price').val();
        var discount = $('#disc_itemvise').val();
        var purchase_price = purchased_price - discount;
        $('#purchase_price').val(purchase_price);
        saleprofit();
    }

    function disc_all_change()
    {
        var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
        var net_total = summaryData.sum + parseFloat($('#interex_amount').val());
        var discount = $('#discount_all').val();
        var net_total = net_total - discount;
        $('#net_total').val(net_total);
        $('#cash_paid').val(net_total);
        //saleprofit();
    }

    function interex_change()
    {
        $("#jqxgrid").jqxGrid('clear');
        if ($('#purchase_type').val() == 10) {
            $('#interex_amount_div').show();
            $('#interex_percentage_div').show();
        } else {
            $('#interex_amount').val(0);
            $('#interex_amount_div').hide();
            $('#interex_percentage').val(0);
            $('#interex_percentage_div').hide();
        }
    }

    function interex_keyup()
    {
        var interex_amount = parseFloat($('#interex_amount').val());
        if ($('#interex_amount').val() == '')
            interex_amount = 0;
        var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
        var net_total = summaryData.sum - $('#discount_all').val();
        var interex_percentage = (100 * interex_amount) / net_total;
        $('#interex_percentage').val(interex_percentage.toFixed(2));
        $('#net_total').val(net_total + parseFloat(interex_amount));
        $('#cash_paid').val(net_total + parseFloat(interex_amount));
    }

    function interex_keyup2()
    {
        var interex_percentage = parseFloat($('#interex_percentage').val());
        if ($('#interex_percentage').val() == '')
            interex_percentage = 0;
        var summaryData = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'quantity', ['sum']);
        var net_total = summaryData.sum - $('#discount_all').val();
        var interex_amount = (net_total * interex_percentage) / 100;
        $('#interex_amount').val(interex_amount.toFixed(2));
        $('#net_total').val(net_total + parseFloat(interex_amount));
        $('#cash_paid').val(net_total + parseFloat(interex_amount));
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
    $('#purchase_date').datepicker().keydown(function(e) {
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

    function saleprofit()
    {
        var purchase_price = parseFloat($('#purchase_price').val());
        var sale_price = parseFloat($('#sale_price').val());
        //var profit_per = parseFloat($('#profit_per').val());
        var profit_per = ((sale_price - purchase_price) / purchase_price) * 100;
        $('#profit_per').val(profit_per.toFixed(2));
    }

    function saleprofit2()
    {
        var purchase_price = parseFloat($('#purchase_price').val());
        var profit_per = parseFloat($('#profit_per').val());
        var sale_price = purchase_price + (purchase_price * profit_per / 100);
        $('#sale_price').val(sale_price.toFixed(2));
    }

    function PopupCenter(pageURL, title, w, h)
    {
        var left = (screen.width / 2) - (w / 2);
        var top = (screen.height / 2) - (h / 2);
        var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    }
</script>