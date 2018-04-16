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
    <?php if($select_date1 == $select_date2) { ?>
    <h4>Daybook Report as on <?php echo date("F j, Y", strtotime($select_date1)); ?></h4> <?php } else { ?>
    <h4>Daybook Report From <?php echo date("F j, Y", strtotime($select_date1)); ?> to <?php echo date("F j, Y", strtotime($select_date2)); ?></h4><?php } ?>
</div>
<div class="row">
    <?php echo '<b>OPENING BALANCE: Rs. '.round($opening_balance).'</b>'; ?>
</div><br/>
<div class="large-12 small-12 columns" style="">
    <div class="row">
        <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
            <div id="jqxgrid"></div>
        </div>
    </div>
</div>
<div class="row" style="text-align: right;"><hr>
    <?php echo '<b>CLOSING BALANCE: Rs. '.round($closing_balance, 2).'</b>'; ?>
</div>

<div class="row" style="text-align: center;">
    <input type="button" style="margin: 10px;" value="Export to Excel" id='excelExport' class="button tiny" />
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
			url: '<?php echo base_url()."accounts/Acc_daybook_ctrlr/account_data?txn_date1=".$select_date1."&txn_date2=".$select_date2; ?>',
			cache: false
		};

		var dataAdapter = new $.jqx.dataAdapter(source);
                
                
                var groupsrenderer = function (text, group, expanded, data) {
                if (data.groupcolumn.datafield == 'Account') {
                    var number = dataAdapter.formatNumber(group, data.groupcolumn.cellsformat);
                    var text = data.groupcolumn.text + ': ' + number;
                    if (data.subItems.length > 0) {
                        var aggregate1 = this.getcolumnaggregateddata('Debit', ['sum'], true, data.subItems);
                        var aggregate2 = this.getcolumnaggregateddata('Credit', ['sum'], true, data.subItems);
                    }
                    else {
                        var rows = new Array();
                        var getRows = function (group, rows) {
                            if (group.subGroups.length > 0) {
                                for (var i = 0; i < group.subGroups.length; i++) {
                                    getRows(group.subGroups[i], rows);
                                }
                            }
                            else {
                                for (var i = 0; i < group.subItems.length; i++) {
                                    rows.push(group.subItems[i]);
                                }
                            }
                        }
                        getRows(data, rows);
                        var aggregate1 = this.getcolumnaggregateddata('Debit', ['sum'], true, rows);
                        var aggregate2 = this.getcolumnaggregateddata('Credit', ['sum'], true, rows);
                    }
                    
                    return '<div style="position: absolute;"><span>' + text + ', </span>' + '<strong>' + "Total" + ' (' + (aggregate1.sum -aggregate2.sum ).toFixed(2) + ')' + '</strong></div>';
                }
                else {
                    return '<div class="' + toThemeProperty('jqx-grid-groups-row') + '" style="position: absolute;"><span>' + text + '</span>';
                }
            }
                
                
			
		$("#jqxgrid").jqxGrid(
		{
		source: source,
                width: '100%',
                pageable: false,
                showstatusbar: true,
                statusbarheight: 35,
                showfilterrow: true,
                filterable: true,
                autoheight: true,
                sortable: true,
                showaggregates: true,
                altrows: true,
                enabletooltips: true,
                groupable: true,
                showgroupsheader: true,
                groupsexpandedbydefault: false,
                groupsrenderer: groupsrenderer,
                groups: ['Account'],
		
		columns: [
			{ text: 'ID', datafield: 'SI',filtertype: 'none', hidden: 'true', width: '5%'},
			{ text: 'Date', datafield: 'Date',filtertype: 'none', width: '15%' },
                        { text: 'Account Name', datafield: 'Account', width: '20%' },
			{ text: 'Narration', datafield: 'Narration',filtertype: 'none', width: '20%' },
                        { text: 'Voucher Type', datafield: 'VoucherType', width: '15%', aggregates: [{ '<b>Balance</b>':
                        function (aggregatedValue, currentValue, column, record) {
                            var sumCredit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Credit', ['sum']);
                            var sumDebit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Debit', ['sum']);
                            return (sumDebit.sum - sumCredit.sum).toFixed(2);
                        }
                  }] },
                        { text: 'Credit', datafield: 'Debit', width: '15%', aggregates: [{ 'Sum':
                        function (aggregatedValue, currentValue, column, record) {
                            var credit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Debit', ['sum']);
                            return credit.sum.toFixed(2);
                        }
                  }], },
                        { text: 'Debit', datafield: 'Credit', width: '15%', aggregates: ['sum'] }
		]
		});
                
                $("#excelExport").jqxButton();
                
                $("#excelExport").click(function () {
                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'jqxGrid');           
            });
                
	});
</script>