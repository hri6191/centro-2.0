<div class="">
	<div class="large-12 small-12 columns" id="navigate">
		<ul class="breadcrumbs">
		  <li><a href="<?php echo base_url(); ?>home">Home</a></li>
                  <li><a href="#">Registration</a></li>
                  <li class="current"><a href="">User</a></li>
		</ul>
	</div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>User Registration</h4>
    <div class="row">
            <form action="<?php echo $this->config->base_url(); ?>registration/user/edit-mode" name="for_edit" id="for_edit" method="post">
        <input type="text" id="edit_id" class="focus" name="edit_id" tabindex="1" placeholder="For Edit, Search Here..." role="submit">
            </form>
    </div>
</div>
<?php if(isset($edit_mode)) { ?>
<form data-abide name="form_user" action="<?php echo $this->config->base_url(); ?>registration/user/edit" method="post">
    <input type="hidden" name="id" value="<?php echo isset($edit_mode[0]->id)?$edit_mode[0]->id:''  ?>">
 <?php } else { ?>
<form data-abide name="form_user" action="<?php echo $this->config->base_url(); ?>registration/user/add" method="post">
 <?php } ?>
    <div class="row">
            <div class="large-4 columns name-field">
              <label>Username *
                  <input type="text" name="user_name" id="user_name" value="<?php echo isset($edit_mode[0]->user_name)?$edit_mode[0]->user_name:''  ?>" tabindex="2" required >
              </label>
<!--              <small class="error">Firm Address is required.</small>-->
            </div>
            <div class="large-4 columns">
              <label>Password *
                  <input type="password" name="password" id="password" value="<?php echo isset($edit_mode[0]->password)?$edit_mode[0]->password:''  ?>" tabindex="6" required />
              </label>
            </div>
            <div class="large-4 columns">
              <label>User Type
                  <select name="user_type" tabindex="10">
                      <option value="1" <?php if(isset($edit_mode[0]->user_type) && $edit_mode[0]->user_type=='1') echo 'selected';  ?>>Call Center</option>
                      <option value="2" <?php if(isset($edit_mode[0]->user_type) && $edit_mode[0]->user_type=='2') echo 'selected';  ?>>Confirmation Center</option>
                      <option value="3" <?php if(isset($edit_mode[0]->user_type) && $edit_mode[0]->user_type=='3') echo 'selected';  ?>>Godown User</option>
                      <option value="4" <?php if(isset($edit_mode[0]->user_type) && $edit_mode[0]->user_type=='4') echo 'selected';  ?>>Administrator</option>
                  </select>
              </label>
            </div>
    </div>
    <div class="row">
        <input type="submit" id="submit_button" class="button" value="<?php echo isset($edit_mode)?'UPDATE':'ADD'  ?>" tabindex="13">
    </div>
</form>

<script>
$(document).ready(function() {
    $("#edit_id").autocomplete({
            url: '<?php echo base_url(); ?>search/user_list?output=json',
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

$("#terms_check").change(function() {
    if ( $(this).is(':checked') ) {
        $('#submit_button').attr("disabled", false);
    } else {
        $('#submit_button').attr("disabled", "disabled");
    }
});
</script>