<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="">Registration</a></li>
            <li class="current"><a href="#">Inventory</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>INVENTORY REGISTRATION</h4>
    <div class="row">
        <form action="<?php echo $this->config->base_url(); ?>registration/inventory/edit-mode" name="for_edit" id="for_edit" method="post">
            <input type="text" id="edit_id" name="edit_id" tabindex="1" placeholder="For Edit, Search Here...">
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
                <div class="large-4 columns name-field">
                    <label>Item Name
                        <input type="text" class="focus" name="item_name" id="item_name" value="<?php echo isset($edit_mode[0]->item_name) ? $edit_mode[0]->item_name : '' ?>" tabindex="1" required >
                    </label>
                    <small class="error">Name is required.</small>
                </div>
                <div class="large-4 columns">
                    <label>Wholesale Price
                        <input type="text" name="wholesale_price" id="wholesale_price" value="<?php echo isset($edit_mode[0]->wholesale_price) ? $edit_mode[0]->wholesale_price : '' ?>" tabindex="5" placeholder="" />
                    </label>
                </div>
                <div class="large-4 columns" style="">
                    <label>Purchase Price
                        <input type="text" name="purchase_price" id="purchase_price" value="<?php echo isset($edit_mode[0]->purchase_price) ? $edit_mode[0]->purchase_price : '' ?>" tabindex="9" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns name-field">
                    <label>Item Code
                        <input type="text" name="item_code" id="item_code" value="<?php echo isset($edit_mode[0]->item_code) ? $edit_mode[0]->item_code : '' ?>" tabindex="2" required >
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>Branch Price
                        <input type="text" name="branch_price" id="branch_price" value="<?php echo isset($edit_mode[0]->branch_price) ? $edit_mode[0]->branch_price : '' ?>" tabindex="6" placeholder="" />
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>Current Stock
                        <input type="text" name="opening_stock" id="opening_stock" value="<?php echo isset($edit_mode[0]->current_stock) ? $edit_mode[0]->current_stock : '' ?>" tabindex="10" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns name-field">
                    <label>Group<a onclick="PopupCenter('<?php echo base_url() . "registration/group"; ?>', 'Group', 400, 400);" href="javascript:void(0);" style="float: right;">NEW GROUP?</a>
                        <input type="text" name="group" id="group" value="<?php echo isset($group[0]->group_name) ? $group[0]->group_name : '' ?>" tabindex="3" ><input type="hidden" name="group_hid" id="group_hid" value="<?php echo isset($edit_mode[0]->group) ? $edit_mode[0]->group : '' ?>">
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>Retail Price
                        <input type="text" name="retail_price" id="retail_price" value="<?php echo isset($edit_mode[0]->retail_price) ? $edit_mode[0]->retail_price : '' ?>" tabindex="7" placeholder="" />
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>Minimum Stock
                        <input type="text" name="minimum_stock" id="minimum_stock" value="<?php echo isset($edit_mode[0]->minimum_stock) ? $edit_mode[0]->minimum_stock : '' ?>" tabindex="11" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns name-field">
                    <label>Tax Schedule
                        <select name="tax" id="tax" tabindex="4">
                            <option value="0" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 0) echo 'selected'; ?>>Tax @ 0%</option>
                            <option value="1" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 1) echo 'selected'; ?>>Tax @ 1%</option>
                            <option value="5" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 5) echo 'selected'; ?>>Tax @ 5%</option>
                            <option value="14.5" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 14.5) echo 'selected'; ?>>Tax @ 14.5%</option>
                            <option value="20" <?php if (isset($edit_mode[0]->tax) && $edit_mode[0]->tax == 20) echo 'selected'; ?>>Tax @ 20%</option>
                        </select>
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>MRP
                        <input type="text" name="mrp" id="mrp" value="<?php echo isset($edit_mode[0]->mrp) ? $edit_mode[0]->mrp : '' ?>" tabindex="8" placeholder="" />
                    </label>
                </div>
                <div class="large-4 columns name-field">
                    <label>Brand<a onclick="PopupCenter('<?php echo base_url() . "registration/brand"; ?>', 'Brand', 400, 400);" href="javascript:void(0);" style="float: right;">NEW BRAND?</a>
                        <input type="text" name="brand" id="brand" value="<?php echo isset($edit_mode[0]->brand) ? $edit_mode[0]->brand : '' ?>" tabindex="12" >
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns name-field">
                    <label>Default Unit
                        <input type="text" name="default_unit" id="default_unit" value="<?php echo isset($edit_mode[0]->default_unit) ? $edit_mode[0]->default_unit : 'Nos' ?>" tabindex="13" >
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>Alternative Unit
                        <input type="text" name="alternative_unit" id="alternative_unit" value="<?php echo isset($edit_mode[0]->alternative_unit) ? $edit_mode[0]->alternative_unit : 'Nos' ?>" tabindex="14" placeholder="" />
                    </label>
                </div>
                <div class="large-4 columns">
                    <label>Unit Conversion Number
                        <input type="text" name="alternative_unit_number" id="alternative_unit_number" value="<?php echo isset($edit_mode[0]->alternative_unit_number) ? $edit_mode[0]->alternative_unit_number : '1' ?>" tabindex="15" placeholder="1 D.U = How many A.U" />
                    </label>
                </div>
            </div>
            <div class="row">
                <input type="submit" class="button" value="<?php echo isset($edit_mode) ? 'UPDATE' : 'ADD' ?>" tabindex="16">
            </div>
        </form>

        <script>
            $(document).ready(function() {
                $("#edit_id").autocomplete({
                    url: '<?php echo base_url(); ?>transaction/search/item_list?output=json',
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
                    remoteDataType: 'json'
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
                    remoteDataType: 'json'
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
                    remoteDataType: 'json'
                });
            });

            function PopupCenter(pageURL, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = (screen.height / 2) - (h / 2);
                var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            }
        </script>