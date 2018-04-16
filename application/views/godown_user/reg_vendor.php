<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>home">Home</a></li>
            <li><a href="<?php echo base_url(); ?>home?tab=reg">Registration</a></li>
            <li class="current"><a href="#">Vendor</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>Vendor Registration</h4>
    <div class="row">
        <form action="<?php echo $this->config->base_url(); ?>registration/vendor/edit-mode" name="for_edit" id="for_edit" method="post">
            <input type="text" id="edit_id" name="edit_id" tabindex="1" placeholder="For Edit, Search Here..." role="submit">
        </form>
    </div>
</div>
<?php if (isset($edit_mode)) { ?>
    <form data-abide name="form_vendor" action="<?php echo $this->config->base_url(); ?>registration/vendor/edit" method="post">
        <input type="hidden" name="id" value="<?php echo $edit_mode[0]->id; ?>">
    <?php } else { ?>
        <form data-abide name="form_vendor" action="<?php echo $this->config->base_url(); ?>registration/vendor/add" method="post">
        <?php } ?>
        <div class="row">
            <div class="large-4 columns name-field">
                <label>Vendor Name *&nbsp;&nbsp;<span class="" id="status"></span>
                    <input type="text" class="focus" name="vendor_name" id="vendor_name" value="<?php echo isset($edit_mode[0]->vendor_name) ? $edit_mode[0]->vendor_name : '' ?>" tabindex="1" required parameter="<?php echo isset($edit_mode[0]->vendor_name)?$edit_mode[0]->vendor_name:null ?>">
                    <input type="hidden" name="old_vendor_name" id="old_vendor_name" value="<?php echo isset($edit_mode[0]->vendor_name) ? $edit_mode[0]->vendor_name : '' ?>" tabindex="1" >
                </label>
                <small class="error">Vendor Name is required.</small>
            </div>
            <div class="large-4 columns name-field">
                <label>Address Line 1 *
                    <input type="text" name="address1" id="address1" value="<?php echo isset($edit_mode[0]->address1) ? $edit_mode[0]->address1 : '' ?>" tabindex="2" required >
                </label>
                <small class="error">Address is required.</small>
            </div>
            <div class="large-4 columns name-field">
                <label>Address Line 2
                    <input type="text" name="address2" id="address2" value="<?php echo isset($edit_mode[0]->address2) ? $edit_mode[0]->address2 : '' ?>" tabindex="3" >
                </label>
            </div>
        </div>
        <div class="row">
            <div class="large-4 columns">
                <label>District *
                    <input type="text" name="district" id="district" value="<?php echo isset($edit_mode[0]->district) ? $edit_mode[0]->district : '' ?>" tabindex="4" required />
                </label>
                <small class="error">Please enter the District</small>
            </div>
            <div class="large-4 columns name-field">
                <label>Pin Code
                    <input type="text" name="pin_code" id="pin_code" value="<?php echo isset($edit_mode[0]->pin_code) ? $edit_mode[0]->pin_code : '' ?>" tabindex="5" >
                </label>
            </div>
            <div class="large-4 columns">
                <label>Phone Number
                    <input type="text" name="phone_no" id="phone_no" value="<?php echo isset($edit_mode[0]->phone_no) ? $edit_mode[0]->phone_no : '' ?>" tabindex="6" />
                </label>
                <small class="error">Enter Phone Number.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-4 columns">
                <label>Email ID
                    <input type="text" name="email_id" id="email_id" value="<?php echo isset($edit_mode[0]->email_id) ? $edit_mode[0]->email_id : '' ?>" tabindex="7" placeholder="" />
                </label>
            </div>
            <div class="large-4 columns">
                <label>Website
                    <input type="text" name="website" id="website" value="<?php echo isset($edit_mode[0]->website) ? $edit_mode[0]->website : '' ?>" tabindex="8" placeholder="" />
                </label>
            </div>
            <div class="large-4 columns">
                <label>GSTIN
                    <input type="text" name="kgst" id="kgst" value="<?php echo isset($edit_mode[0]->kgst) ? $edit_mode[0]->kgst : '' ?>" tabindex="9" placeholder="" />
                </label>
            </div>
        </div>
        <div class="row">
            <input type="submit" id="add_button" class="button" value="<?php echo isset($edit_mode) ? 'UPDATE' : 'ADD' ?>" tabindex="10">
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#edit_id").autocomplete({
                url: '<?php echo base_url(); ?>transaction/Search/vendor_list?output=json',
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
            $("#vendor_name").keyup(function()
            {
                if (ajax) {
                    ajax.abort();
                }
                var vendor_name = $("#vendor_name").val().toLowerCase();
                var edit = $(this).attr("parameter").toLowerCase();
                    $("#status").html('<img src="<?php echo base_url(); ?>assets/img/indicator.gif" align="absmiddle">');
                    var server_response;
                    ajax = $.ajax({
                        type: "post",
                        url: "<?php echo base_url() . "Availability_ctrlr/customer_availability"; ?>",
                        data: {customer_name: vendor_name},
                        success: function(server_respons) { 
                        server_response = server_respons;
                            if (server_response == 0)
                            {
                                $("#status").html('<img src="<?php echo base_url(); ?>assets/img/available.png" align="absmiddle">');
                                $('#add_button').attr("disabled", false);
                            }
                            else if (server_response == 1)
                            {
                                if (edit == vendor_name) {
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
    </script>