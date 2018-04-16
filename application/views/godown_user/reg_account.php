<div id="myModal" class="reveal-modal tiny" style="text-align: center;" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <img src="<?php echo base_url(); ?>assets/images/success.png" >
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li><a href="<?php echo base_url(); ?>home?tab=reg">Registration</a></li>
            <li class="current"><a href="#">Account</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>ACCOUNT REGISTRATION</h4>
    <div class="row">
        <form action="<?php echo $this->config->base_url(); ?>registration/account/edit-mode" name="for_edit" id="for_edit" method="post">
            <input type="text" id="edit_id" name="edit_id" placeholder="For Edit, Search Here...">
        </form>
    </div>
</div>
<?php if (isset($edit_mode)) { ?>
    <form data-abide name="form_inventory" action="<?php echo $this->config->base_url(); ?>registration/account/edit" method="post">
        <input type="hidden" name="id" value="<?php echo $edit_mode[0]->id; ?>">
    <?php } else { ?>
        <form data-abide name="form_firm" action="<?php echo $this->config->base_url(); ?>registration/account/add" method="post">
        <?php } ?>
        <form data-abide>
            <div class="row">
                <div class="large-6 columns name-field">
                    <label>Account Name&nbsp;&nbsp;<span class="" id="status"></span>
                        <input type="text" class="focus" name="account_name" id="account_name" value="<?php echo isset($edit_mode[0]->account_name) ? $edit_mode[0]->account_name : '' ?>" required <?php if($edit_mode) echo 'readonly'; ?> >
                    </label>
                    <small class="error">Account Name is required.</small>
                </div>
                <div class="large-6 columns name-field">
                    <label>Account Group
                        <select name="account_group" id="account_group">
                            <?php foreach ($account_groups as $account_group) { ?>
                            <option value="<?php echo $account_group->name; ?>"><?php echo $account_group->name; ?></option>
                            <?php } ?>
                        </select>
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <input type="submit" id="add_button" class="button" value="<?php echo isset($edit_mode) ? 'UPDATE' : 'ADD' ?>">
                </div> <a href="#" id="success_modal" data-reveal-id="myModal" style="display: none;">Click Me For A Modal</a>
                <?php if($edit_mode) { ?>
                <div class="large-6 columns" style="text-align: right;">
                    <a href="<?php echo base_url(); ?>registration/account/delete/<?php echo $edit_mode[0]->id; ?>" onclick="return confirm('Are you sure to delete?')"><input type="button" id="delete_button" class="button" value="DELETE"></a>
                </div>
                <?php } ?>
            </div>
        </form>

        <script>
            $(document).ready(function() {
                <?php if ($this->session->flashdata('success')) { ?>
                $('#success_modal').click();
                <?php } ?>
                $("#edit_id").autocomplete({
                    url: '<?php echo base_url(); ?>transaction/Search/account_list?output=json',
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
                
                var ajax = '';
            $("#account_name").keyup(function()
            {
                if (ajax) {
                    ajax.abort();
                }
                var account_name = $("#account_name").val().toLowerCase();
                    $("#status").html('<img src="<?php echo base_url(); ?>assets/img/indicator.gif" align="absmiddle">');
                    var server_response;
                    ajax = $.ajax({
                        type: "post",
                        url: "<?php echo base_url() . "Availability_ctrlr/account_name_availability"; ?>",
                        data: {account_name: account_name},
                        success: function(server_respons) { 
                        server_response = server_respons;
                            if (server_response == 0)
                            {
                                $("#status").html('<img src="<?php echo base_url(); ?>assets/img/available.png" align="absmiddle">');
                                $('#add_button').attr("disabled", false);
                            }
                            else if (server_response == 1)
                            {
                                    $("#status").html('<img src="<?php echo base_url(); ?>assets/img/not_available.png" align="absmiddle">');
                                    $('#add_button').attr("disabled", "disabled");
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