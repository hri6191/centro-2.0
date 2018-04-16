<div class="">
	<div class="large-12 small-12 columns" id="navigate">
		<ul class="breadcrumbs">
		  <li><a href="<?php echo base_url(); ?>home" >Home</a></li>
                 <li><a href="<?php echo base_url(); ?>home?tab=accounts" >Accounts</a></li>
                  <li class="current"><a>Cash Book - Select Date</a></li>
		</ul>
	</div>
</div>
<div class="large-12 small-12 columns" id="navigate">
    <h4>Select Date</h4>
    <div class="row">
            <form action="<?php echo $this->config->base_url(); ?>accounts/cash-book" name="for_edit" id="for_edit" method="post">
        <input type="text" id="select_date" class="focus" name="select_date" tabindex="1" placeholder="Select Date Here..." role="submit">
            </form>
    </div>
</div>

<script>
$(document).ready(function() {
    $("#edit_id").autocomplete({
            url: '<?php echo base_url(); ?>search/account_list?output=json',
            showResult: function(data, value) {
                return '<span style="z-index: 2000;">' + data + '</span>';
            },
            onItemSelect: function(item) {
                $("#edit_id").val(item.value);
                $('form#for_edit').submit();
            },
            mustMatch: true,
            maxItemsToShow: 10,
            selectFirst: false,
            autoFill: true,
            selectOnly: true,
            remoteDataType: 'json'
        });
        
        $('#select_date').datepicker({ dateFormat: 'yy-mm-dd', onSelect: function(dateText, inst) {
        var date = $(this).val();
        $("#select_date").val(date);
        $('form#for_edit').submit();

    } });
});
</script>