<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li><a href="<?php echo base_url(); ?>home?tab=reg">Registration</a></li>
            <li class="current"><a href="#">Inventory</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>INVENTORY REGISTRATION</h4>
    <div class="row">
        <form action="<?php echo $this->config->base_url(); ?>registration/inventory/edit-mode" name="for_edit" id="for_edit" method="post">
            <input type="text" id="edit_id" name="edit_id" placeholder="For Edit, Search Here...">
        </form>
    </div>
</div>
<?php if (isset($edit_mode)) { ?>
    <form data-abide name="form_inventory" action="<?php echo $this->config->base_url(); ?>registration/inventory/edit" method="post">
        <input type="hidden" name="id" value="<?php echo $edit_mode[0]->id; ?>">
    <?php } else { ?>
        <form data-abide name="form_firm" action="<?php echo $this->config->base_url(); ?>registration/inventory/add" method="post">
        <?php } ?>
        <form data-abide>
            <div class="row">
                <div class="large-3 columns name-field">
                    <label>Item Name
                        <input type="text" class="focus" name="item_name" id="item_name" value="<?php echo isset($edit_mode[0]->item_name) ? $edit_mode[0]->item_name : '' ?>" required >
                    </label>
                    <small class="error">Name is required.</small>
                </div>
                <div class="large-3 columns name-field">
                    <label>Item Code&nbsp;&nbsp;<span class="" id="status"></span>
                        <input type="text" name="item_code" id="item_code" value="<?php echo isset($edit_mode[0]->item_code) ? $edit_mode[0]->item_code : '' ?>"  parameter="<?php echo isset($edit_mode[0]->item_code)?$edit_mode[0]->item_code:null ?>">
                    </label>
                </div>
                <div class="large-3 columns name-field">
                    <label>Description
                        <input type="text" name="item_desc" id="item_desc" value="<?php echo isset($edit_mode[0]->item_desc) ? $edit_mode[0]->item_desc : '' ?>" >
                    </label>
                </div>
                <div class="large-3 columns name-field">
                    <label>HSN Code
                        <input type="text" name="hsn" id="hsn" value="<?php echo isset($edit_mode[0]->hsn) ? $edit_mode[0]->hsn : '' ?>" >
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns name-field">
                    <label>Group<a onclick="PopupCenter('<?php echo base_url() . "registration/group"; ?>', 'Group', 400, 400);" href="javascript:void(0);" style="float: right;">NEW GROUP?</a>
                        <input type="text" name="group" id="group" value="<?php echo isset($group[0]->group_name) ? $group[0]->group_name : '' ?>" ><input type="hidden" name="group_hid" id="group_hid" value="<?php echo isset($edit_mode[0]->group) ? $edit_mode[0]->group : '1' ?>">
                    </label>
                </div>
                <div class="large-3 columns name-field">
                    <label>Brand<a onclick="PopupCenter('<?php echo base_url() . "registration/brand"; ?>', 'Brand', 400, 400);" href="javascript:void(0);" style="float: right;">NEW BRAND?</a>
                        <input type="text" name="brand" id="brand" value="<?php echo isset($edit_mode[0]->brand) ? $edit_mode[0]->brand : '' ?>" >
                    </label>
                </div>
                <div class="large-3 columns" style="">
                    <label>Purchase Price
                        <input type="text" name="purchase_price" id="purchase_price" value="<?php echo isset($edit_mode[0]->purchase_price) ? $edit_mode[0]->purchase_price : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>Wholesale Price
                        <input type="text" name="wholesale_price" id="wholesale_price" value="<?php echo isset($edit_mode[0]->wholesale_price) ? $edit_mode[0]->wholesale_price : '' ?>" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns">
                    <label>Retail Price
                        <input type="text" name="mrp" id="mrp" value="<?php echo isset($edit_mode[0]->mrp) ? $edit_mode[0]->mrp : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>Interstate Price
                        <input type="text" name="branch_price" id="branch_price" value="<?php echo isset($edit_mode[0]->branch_price) ? $edit_mode[0]->branch_price : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>Current Stock
                        <input type="text" name="opening_stock" id="opening_stock" value="<?php echo isset($edit_mode[0]->current_stock) ? $edit_mode[0]->current_stock : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>Minimum Stock
                        <input type="text" name="minimum_stock" id="minimum_stock" value="<?php echo isset($edit_mode[0]->minimum_stock) ? $edit_mode[0]->minimum_stock : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns" style="display: none;">
                    <label>Maximum Stock
                        <input type="text" name="max_stock" id="max_stock" value="<?php echo isset($edit_mode[0]->max_stock) ? $edit_mode[0]->max_stock : '500' ?>" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns name-field">
                    <label>GST Schedule
                        <select name="tax" id="gst" onchange="gstin();" onkeyup="gstin();">
                            <option value="0" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 0) echo 'selected'; ?>>Tax @ 0%</option>
                            <option value="3" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 3) echo 'selected'; ?>>Tax @ 3%</option>
                            <option value="5" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 5) echo 'selected'; ?>>Tax @ 5%</option>
                            <option value="12" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 12) echo 'selected'; ?>>Tax @ 12%</option>
                            <option value="18" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 18) echo 'selected'; ?>>Tax @ 18%</option>
                            <option value="28" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 28) echo 'selected'; ?>>Tax @ 28%</option>
                        </select>
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>SGST
                        <input type="text" name="sgst" id="sgst" value="<?php echo isset($edit_mode[0]->sgst) ? $edit_mode[0]->sgst : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>CGST
                        <input type="text" name="cgst" id="cgst" value="<?php echo isset($edit_mode[0]->cgst) ? $edit_mode[0]->cgst : '' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>IGST
                        <input type="text" name="igst" id="igst" value="<?php echo isset($edit_mode[0]->igst) ? $edit_mode[0]->igst : '' ?>" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-3 columns name-field">
                    <label>Default Unit
                        <input type="text" name="default_unit" id="default_unit" value="<?php echo isset($edit_mode[0]->default_unit) ? $edit_mode[0]->default_unit : 'NOS' ?>" >
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>Alternative Unit
                        <input type="text" name="alternative_unit" id="alternative_unit" value="<?php echo isset($edit_mode[0]->alternative_unit) ? $edit_mode[0]->alternative_unit : 'NOS' ?>" placeholder="" />
                    </label>
                </div>
                <div class="large-3 columns">
                    <label>Unit Conversion Number
                        <input type="text" name="alternative_unit_number" id="alternative_unit_number" value="<?php echo isset($edit_mode[0]->alternative_unit_number) ? $edit_mode[0]->alternative_unit_number : '1' ?>" placeholder="1 D.U = How many A.U" />
                    </label>
                </div>
                <div class="large-3 columns name-field">
                    <label>Ordinary Inventory ?
                        <select name="pay_inv" id="pay_inv">
                            <option value="0" <?php if (isset($edit_mode[0]->pay_inv) && $edit_mode[0]->pay_inv == 0) echo 'selected'; ?>>Yes</option>
                            <option value="1" <?php if (isset($edit_mode[0]->pay_inv) && $edit_mode[0]->pay_inv == 1) echo 'selected'; ?>>No</option>
                        </select>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <input type="submit" id="add_button" class="button" value="<?php echo isset($edit_mode) ? 'UPDATE' : 'ADD' ?>">
                </div>
                <?php if($edit_mode) { ?>
                <div class="large-6 columns" style="text-align: right;">
                    <a href="<?php echo base_url(); ?>registration/inventory/delete/<?php echo $edit_mode[0]->id; ?>" onclick="return confirm('Are you sure to delete?')"><input type="button" id="delete_button" class="button" value="DELETE"></a>
                </div>
                <?php } ?>
            </div>
        </form>

        <script>
            $(document).ready(function() {
                $("#edit_id").autocomplete({
                    url: '<?php echo base_url(); ?>transaction/Search/item_list?output=json',
                    showResult: function(data, value) {
                        return '<span style="z-index: 2000;">' + data + '</span>';
                    },
                    onItemSelect: function(item) {
                        $("#edit_id").val(item.data);
                        $('form#for_edit').submit();
                    },
                    mustMatch: true,
                    maxItemsToShow: 10,
                    selectFirst: false,
                    autoFill: true,
                    selectOnly: true,
                    remoteDataType: 'json',
                    useCache: false
                });

                $("#group").autocomplete({
                    url: '<?php echo base_url(); ?>transaction/search/group_list?output=json',
                    showResult: function(data, value) {
                        return '<span style="z-index: 2000;">' + data + '</span>';
                    },
                    onItemSelect: function(item) {
                        $('#group_hid').val(item.data);
                    },
                    mustMatch: true,
                    maxItemsToShow: 10,
                    selectFirst: false,
                    autoFill: true,
                    selectOnly: true,
                    remoteDataType: 'json',
                    useCache: false
                });

                $("#brand").autocomplete({
                    url: '<?php echo base_url(); ?>transaction/search/brand_list?output=json',
                    showResult: function(data, value) {
                        return '<span style="z-index: 2000;">' + data + '</span>';
                    },
                    onItemSelect: function(item) {
                        //$("#brand").val(item.data);
                    },
                    mustMatch: true,
                    maxItemsToShow: 10,
                    selectFirst: false,
                    autoFill: true,
                    selectOnly: true,
                    remoteDataType: 'json',
                    useCache: false
                });
                
                var ajax = '';
            $("#item_code").keyup(function()
            {
                if (ajax) {
                    ajax.abort();
                }
                var item_code = $("#item_code").val().toLowerCase();
                var edit = $(this).attr("parameter").toLowerCase();
                    $("#status").html('<img src="<?php echo base_url(); ?>assets/img/indicator.gif" align="absmiddle">');
                    var server_response;
                    ajax = $.ajax({
                        type: "post",
                        url: "<?php echo base_url() . "Availability_ctrlr/item_code_availability"; ?>",
                        data: {item_code: item_code},
                        success: function(server_respons) { 
                        server_response = server_respons;
                            if (server_response == 0)
                            {
                                $("#status").html('<img src="<?php echo base_url(); ?>assets/img/available.png" align="absmiddle">');
                                $('#add_button').attr("disabled", false);
                            }
                            else if (server_response == 1)
                            {
                                if (edit == item_code) {
                                    $("#status").html('');
                                    $('#add_button').attr("disabled", false);
                                }
                                else {
                                    $("#status").html('<img src="<?php echo base_url(); ?>assets/img/not_available.png" align="absmiddle">');
                                    $('#add_button').attr("disabled", "disabled");
                                }
                            }
                        }
                    });
                return false;
            });
                
            });

            function PopupCenter(pageURL, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = (screen.height / 2) - (h / 2);
                var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            }
            function gstin() {
            var gst = $("#gst").val();
            $("#sgst").val(gst/2);
            $("#cgst").val(gst/2);
            $("#igst").val(gst);
        }
        </script>