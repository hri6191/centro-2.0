<div class="">
    <div class="large-12 small-12 columns" id="navigate">
            <ul class="breadcrumbs">
                <li><a href="<?php echo base_url(); ?>home" >Home</a></li>
                <li><a href="<?php echo base_url(); ?>home?tab=accounts" >Accounts</a></li>
              <li class="current"><a >Ledger</a></li>
            </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Ledger Report</h4>
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
                                { name: 'AccountGroup'},
				{ name: 'Narration'},
				//{ name: 'VoucherType'},
                                { name: 'Debit'},
				{ name: 'Credit'}
			],
			url: '<?php echo base_url()."accounts/Acc_ledger_ctrlr_all/account_data"; ?>',
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
			{ text: 'ID', datafield: 'SI',filtertype: 'none', width: '3%'},
			{ text: 'Date', datafield: 'Date',filtertype: 'date', width: '10%' },
                        { text: 'Ledger Name', datafield: 'Account', filtertype: 'list', width: '19%' },
                        { text: 'Account Group', datafield: 'AccountGroup', width: '13%' },
			{ text: 'Narration', datafield: 'Narration',filtertype: 'none', width: '25%', aggregates: [{ '<b>Closing Balance</b>':
                        function (aggregatedValue, currentValue, column, record) {
                            var sumCredit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Credit', ['sum']);
                            var sumDebit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Debit', ['sum']);
                            return sumDebit.sum - sumCredit.sum;
                        }
                  }]},
                        //{ text: 'Voucher Type', datafield: 'VoucherType', width: '10%' },
                        { text: 'Debit', datafield: 'Debit', width: '15%', aggregates: ['sum'], },
                        { text: 'Credit', datafield: 'Credit', width: '15%', aggregates: ['sum'] }
		]
		});
	});
</script>