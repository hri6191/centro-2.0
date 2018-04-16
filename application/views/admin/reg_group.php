<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="">Registration</a></li>
            <li class="current"><a href="#">Group</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Group Registration</h4>
    <div class="row">
        <form action="<?php echo base_url(); ?>registration/group/edit-mode" name="for_edit" id="for_edit" method="post">
            <input type="text" id="edit_id" name="edit_id" tabindex="1" placeholder="For Edit, Search Here..." role="submit">
        </form>
    </div>
</div>
<?php if (isset($edit_mode)) { ?>
    <form data-abide name="form_group" action="<?php echo $this->config->base_url(); ?>registration/group/edit" method="post">
        <input type="hidden" name="id" value="<?php echo $edit_mode[0]->id; ?>">
    <?php } else { ?>
        <form data-abide name="form_group" action="<?php echo $this->config->base_url(); ?>registration/group/add" method="post">
        <?php } ?>
        <div class="row">
            <div class="large-4 columns name-field">
                <label>Group Name *
                    <input type="text" class="focus" name="group_name" id="group_name" value="<?php echo isset($edit_mode[0]->group_name) ? $edit_mode[0]->group_name : '' ?>" tabindex="1" required >
                </label>
                <small class="error">Group Name is required.</small>
            </div>
        </div>
        <div class="row">
            <input type="submit" class="button" value="<?php echo isset($edit_mode) ? 'UPDATE' : 'ADD' ?>" tabindex="13">
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#edit_id").autocomplete({
                url: '<?php echo base_url(); ?>transaction/search/group_list?output=json',
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