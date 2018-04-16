<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li><a href="<?php echo base_url(); ?>home?tab=txn">Transaction</a></li>
            <li class="current"><a >Payment</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>Payment</h4>
    <div class="row">
        <form action="<?php echo $this->config->base_url(); ?>transaction/payments/edit-mode" name="for_edit" id="for_edit" method="post">
            <input type="text" id="edit_id" name="edit_id" tabindex="1" placeholder="For Edit, Search Here...">
        </form>
    </div>
</div>
<?php if (isset($edit_mode)) { ?>
    <form data-abide name="form_material" action="<?php echo $this->config->base_url(); ?>transaction/payments/edit" method="post">
        <input type="hidden" name="id" value="<?php echo $edit_mode[0]->id; ?>">
    <?php } else { ?>
        <form data-abide name="form_firm" action="<?php echo $this->config->base_url(); ?>transaction/payments/add" method="post">
        <?php } ?>
        <form data-abide>
            <div class="row">
                <div class="large-4 columns name-field">
                    <label>Account
                        <input type="text" <?php if(isset($edit_mode)) echo 'readonly'; ?> name="account_name" id="account_name" class="focus" value="<?php echo isset($edit_mode[0]->account_name) ? $edit_mode[0]->account_name : '' ?>" tabindex="1" required >
                    </label>
                </div>
                <div class="large-4 columns name-field">
                    <label>Account Group
                        <select name="account_group" tabindex="1" id="account_group">
                            <?php foreach ($account_groups as $account_group) { ?>
                            <option value="<?php echo $account_group->name; ?>" <?php if(isset($edit_mode[0]->account_group) && $edit_mode[0]->account_group==$account_group->name) echo 'selected'; ?>><?php echo $account_group->name; ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
                <div class="large-4 columns" style="">
                    <label>Amount
                      <input type="text" name="amount" id="amount" value="<?php echo isset($edit_mode[0]->amount)?$edit_mode[0]->amount:''  ?>" tabindex="1" placeholder="" />
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-4 columns name-field">
                    <label>Description / Check Details
                        <textarea name="description" tabindex="1"><?php echo isset($edit_mode[0]->description) ? $edit_mode[0]->description : '' ?></textarea>
                    </label>
                </div>
                <div class="large-4 columns name-field">
                    <label>From Account
                        <input type="text" <?php if(isset($edit_mode)) echo 'readonly'; ?> name="to_account_name" id="to_account_name" value="<?php echo isset($edit_mode[0]->from_or_to) ? $edit_mode[0]->from_or_to : 'cash_book' ?>" tabindex="1" required >
                    </label>
                </div>
                <div class="large-4 columns name-field">
                    <label>Date
                        <input type="text" name="payment_date" id="payment_date" value="<?php echo isset($edit_mode[0]->txn_date) ? $edit_mode[0]->txn_date : date('Y-m-d'); ?>" tabindex="1" required >
                    </label>
                </div>
            </div>
            <div class="row">
                <input type="submit" class="button" value="<?php echo isset($edit_mode) ? 'UPDATE' : 'ADD' ?>" tabindex="12">
                <?php if(isset($edit_mode)) { ?> <a href="<?php echo base_url().'transaction/payments/delete/'.$edit_mode[0]->id; ?>"><?php } ?>
                    <input type="<?php echo isset($edit_mode) ? 'button' : 'reset' ?>" class="button" value="<?php echo isset($edit_mode) ? 'DELETE' : 'RESET' ?>" tabindex="12" style="float: right;">
                <?php if(isset($edit_mode)) { ?></a><?php } ?>
            </div>
        </form>

        <script>
            $(document).ready(function() {
                $("#edit_id").autocomplete({
                    url: '<?php echo base_url(); ?>Search/account_payment_list?output=json',
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
            
            $("#account_name").autocomplete({
                url: '<?php echo base_url(); ?>Search/account_list?output=json',
                showResult: function(data, value) {
                    return '<span style="z-index: 2000;">' + data + '</span>';
                },
                onItemSelect: function(item) {
                    $("#account_name").val(item.value);
                    var account_name = $("#account_name").val();
                    var datas;
                    $.ajax({
                        type: "post",
                        data: {account_name: account_name},
                        url: "<?php echo base_url() . "Json/get_account_group"; ?>",
                        dataType: "json",
                        success: function(data) {
                            datas = data;
                            //$('#account_group option[value="' + datas.account_group + '"]').prop('selected', true);
                            $('#account_group').val(datas.account_group);
                        }
                    });
                },
                mustMatch: false,
                maxItemsToShow: 10,
                selectFirst: false,
                autoFill: true,
                selectOnly: false,
                remoteDataType: 'json',
                useCache: false
            });
            
            $("#to_account_name").autocomplete({
                url: '<?php echo base_url(); ?>Search/account_list_from_or_to?output=json',
                showResult: function(data, value) {
                    return '<span style="z-index: 2000;">' + data + '</span>';
                },
                onItemSelect: function(item) {
                    $("#to_account_name").val(item.value);
                },
                mustMatch: true,
                maxItemsToShow: 10,
                selectFirst: false,
                autoFill: true,
                selectOnly: false,
                remoteDataType: 'json',
                useCache: false
            });
            
            $('#payment_date').datepicker({ dateFormat: 'yy-mm-dd' });
            });
        </script>