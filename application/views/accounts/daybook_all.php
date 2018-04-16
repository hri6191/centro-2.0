<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
              <li><a href="<?php echo base_url(); ?>home" >Home</a></li>
              <li><a href="<?php echo base_url(); ?>home?tab=accounts" >Accounts</a></li>
              <li class="current"><a >Daybook</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Daybook Report</h4>
</div>
<div class="large-12 small-12 columns" style="">
    <div class="row">
        <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
            <div id="jqxgrid"></div>
        </div>
    </div>
</div>

<?php $this->view('includes/grid_assets'); ?>

<script type="text/javascript">
$(document).ready(function () {
	   
         
		var source =
		{
			datatype: "json",
			datafields: [
                                { name: 'SI'},
                                {name: 'Date'},
				{ name: 'Account'},
				{ name: 'Narration'},
				{ name: 'VoucherType'},
                                { name: 'Debit'},
				{ name: 'Credit'}
			],
			url: '<?php echo base_url()."accounts/Acc_daybook_ctrlr_all/account_data"; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                pageable: true,
                showstatusbar: true,
                statusbarheight: 35,
                showfilterrow: true,
                filterable: true,
                autoheight: true,
                sortable: true,
                showaggregates: true,
                altrows: true,
                enabletooltips: true,
		
		columns: [
			{ text: 'ID', datafield: 'SI',filtertype: 'none', width: '5%'},
			{ text: 'Date', datafield: 'Date',filtertype: 'date', width: '15%' },
                        { text: 'Account Name', datafield: 'Account', width: '20%' },
			{ text: 'Narration', datafield: 'Narration',filtertype: 'none', width: '20%' },
                        { text: 'Voucher Type', datafield: 'VoucherType', width: '20%', aggregates: [{ '<b>Closing Balance</b>':
                        function (aggregatedValue, currentValue, column, record) {
                            var sumCredit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Credit', ['sum']);
                            var sumDebit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Debit', ['sum']);
                            return sumDebit.sum - sumCredit.sum;
                        }
                  }] },
                        { text: 'Debit', datafield: 'Debit', width: '10%', aggregates: ['sum'], },
                        { text: 'Credit', datafield: 'Credit', width: '10%', aggregates: ['sum'] }
		]
		});
	});
</script>