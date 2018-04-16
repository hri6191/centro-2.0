<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>">Home</a></li>
              <li><a href="<?php echo base_url(); ?>registration">Registration</a></li>
              <li class="current"><a href="#">Firm</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Firm Registration</h4>
    <div class="row">
        <form action="<?php echo base_url(); ?>registration/firm/edit-mode" name="for_edit" id="for_edit" method="post">
                <input type="text" id="edit_id" class="focus" name="edit_id" tabindex="1" placeholder="For Edit, Search Here..." role="submit">
            </form>
    </div>
</div>
<?php if(isset($edit_mode)) { ?>
<form data-abide name="form_firm" action="<?php echo $this->config->base_url(); ?>registration/firm/edit" method="post">
    <input type="hidden" name="id" value="<?php echo $edit_mode[0]->id; ?>">
 <?php } else { ?>
<form data-abide name="form_firm" action="<?php echo $this->config->base_url(); ?>registration/firm/add" method="post">
 <?php } ?>
    <div class="row">
            <div class="large-4 columns name-field">
              <label>Firm Name *
                  <input type="text" name="firm_name" id="firm_name" value="<?php echo isset($edit_mode[0]->firm_name)?$edit_mode[0]->firm_name:''  ?>" tabindex="1" required >
              </label>
              <small class="error">Firm Name is required.</small>
            </div>
            <div class="large-4 columns">
              <label>District *
                  <input type="text" name="district" id="district" value="<?php echo isset($edit_mode[0]->district)?$edit_mode[0]->district:''  ?>" tabindex="5" required />
              </label>
              <small class="error">Please enter the District</small>
            </div>
            <div class="large-4 columns">
              <label>PIN Number
                  <input type="text" name="pin_no" id="pinn_no" value="<?php echo isset($edit_mode[0]->pin_no)?$edit_mode[0]->pin_no:''  ?>" tabindex="9" placeholder="" />
              </label>
            </div>
    </div>
    <div class="row">
            <div class="large-4 columns name-field">
              <label>Address1 *
                  <input type="text" name="address1" id="address1" value="<?php echo isset($edit_mode[0]->address1)?$edit_mode[0]->address1:''  ?>" tabindex="2" required >
              </label>
              <small class="error">Firm Address is required.</small>
            </div>
            <div class="large-4 columns">
              <label>Phone Number *
                  <input type="text" name="phone_no" id="phone_no" value="<?php echo isset($edit_mode[0]->phone_no)?$edit_mode[0]->phone_no:''  ?>" tabindex="6" required />
              </label>
              <small class="error">Enter Phone Number.</small>
            </div>
            <div class="large-4 columns">
              <label>TIN Number
                  <input type="text" name="tin_no" id="tin_no" value="<?php echo isset($edit_mode[0]->tin_no)?$edit_mode[0]->tin_no:''  ?>" tabindex="10" placeholder="" />
              </label>
            </div>
    </div>
    <div class="row">
            <div class="large-4 columns name-field">
              <label>Address2
                  <input type="text" name="address2" id="address2" value="<?php echo isset($edit_mode[0]->address2)?$edit_mode[0]->address2:''  ?>" tabindex="3" >
              </label>
            </div>
            <div class="large-4 columns">
              <label>Email ID
                  <input type="text" name="email_id" id="email_id" value="<?php echo isset($edit_mode[0]->email_id)?$edit_mode[0]->email_id:''  ?>" tabindex="7" placeholder="" />
              </label>
            </div>
            <div class="large-4 columns">
              <label>KGST
                  <input type="text" name="kgst" id="kgst" value="<?php echo isset($edit_mode[0]->kgst)?$edit_mode[0]->kgst:''  ?>" tabindex="11" placeholder="" />
              </label>
            </div>
    </div>
    <div class="row">
            <div class="large-4 columns name-field">
              <label>Pin Code
                  <input type="text" name="pin_code" id="pin_code" value="<?php echo isset($edit_mode[0]->pin_code)?$edit_mode[0]->pin_code:''  ?>" tabindex="4" >
              </label>
            </div>
            <div class="large-4 columns">
              <label>Website
                  <input type="text" name="website" id="website" value="<?php echo isset($edit_mode[0]->website)?$edit_mode[0]->website:''  ?>" tabindex="8" placeholder="" />
              </label>
            </div>
            <div class="large-4 columns">
              <label>CST
                  <input type="text" name="cst" id="cst" value="<?php echo isset($edit_mode[0]->cst)?$edit_mode[0]->cst:''  ?>" tabindex="12" placeholder="" />
              </label>
            </div>
    </div>
    <div class="row">
        <input type="submit" class="button" value="<?php echo isset($edit_mode)?'UPDATE':'ADD'  ?>" tabindex="13">
    </div>
</form>
    
<script>
$(document).ready(function() {
    $("#edit_id").autocomplete({
            url: '<?php echo base_url(); ?>transaction/search/firm_list?output=json',
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
});
</script>