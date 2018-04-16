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
    <form action="<?php echo base_url(); ?>accounts/creat-pdf" method="post">
    <div class="row">
        <div id='jqxWidget' style="font-size: 13px; font-family: Verdana;">
            <div id="jqxgrid"></div>
        </div>
    </div><br/>
    <div id="pdf_data">
    </div>
    <div class="row">
        <input type="submit" value="Print" class="button_zie button radius" id="print" style="float: right;">
    </div>
    </form>
<!--    <div class="row">
        <input type="button" value="Export to Excel" id='excelExport' />
        <input type="button" style="float: right;" value="Print" id='print2' />
    </div>-->
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
			url: '<?php echo base_url()."accounts/Acc_ledger_ctrlr/account_data?ac_nm=".$account_name; ?>',
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
                        { text: 'Ledger Name', datafield: 'Account', width: '19%' },
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

//                $("#excelExport").jqxButton();
//
//                $("#excelExport").click(function () {
//                $("#jqxgrid").jqxGrid('exportdata', 'xls', 'jqxGrid');
//            });
//
//            $("#print2").jqxButton();
//
//            $("#print2").click(function () {
//                var gridContent = $("#jqxgrid").jqxGrid('exportdata', 'html');
//                var newWindow = window.open('', '', 'width=800, height=500'),
//                document = newWindow.document.open(),
//                pageContent =
//                    '<!DOCTYPE html>\n' +
//                    '<html>\n' +
//                    '<head>\n' +
//                    '<meta charset="utf-8" />\n' +
//                    '<title>MEMBERS</title>\n' +
//                    '</head>\n' +
//                    '<body>\n' + gridContent + '\n</body>\n</html>';
//                document.write(pageContent);
//                document.close();
//                newWindow.print();
//            });



           $("#print").on('click', function () {
            var rows = $('#jqxgrid').jqxGrid('getrows');
            var rowscount = rows.length;
            if(rowscount<=0)
            {
             alert('Add Atleast one item');
             $('body,html').animate({scrollTop:0},1000);
             return false;
            }
            var sumCredit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Credit', ['sum']);
            var sumDebit = $("#jqxgrid").jqxGrid('getcolumnaggregateddata', 'Debit', ['sum']);
            var balance_sum = sumCredit.sum - sumDebit.sum;
            $('#pdf_data').empty();
            var gd     =  $("#jqxgrid").jqxGrid('getrows');
            var datas  = new Array();
            var datasb = new Array();
            var datasc = new Array();
            for (var i = 0; i < gd.length; i++)
            {
              datas.push(gd[i]);
            }

            for (var j = 0; j < datas.length; j++)
            {
              datasb.push(datas[j]);
            }
            for (var k = 0; k < datasb.length; k++)
            {
                var txn_date = $("<input>").attr("type", "hidden")
                                                          .attr('name','txn_dates[]')
                                                          .val(datasb[k]['Date']);
                var account = $("<input>").attr("type", "hidden")
                                                          .attr('name','accounts[]')
                                                          .val(datasb[k]['Account']);
                var account_group = $("<input>").attr("type", "hidden")
                                                          .attr('name','account_groups[]')
                                                          .val(datasb[k]['AccountGroup']);
                var narration = $("<input>").attr("type", "hidden")
                                                          .attr('name','narrations[]')
                                                          .val(datasb[k]['Narration']);
                var credit = $("<input>").attr("type", "hidden")
                                                          .attr('name','credits[]')
                                                          .val(datasb[k]['Credit']);
                var debit = $("<input>").attr("type", "hidden")
                                                          .attr('name','debits[]')
                                                          .val(datasb[k]['Debit']);
                $('#pdf_data').append($(txn_date));
                $('#pdf_data').append($(account));
                $('#pdf_data').append($(account_group));
                $('#pdf_data').append($(narration));
                $('#pdf_data').append($(credit));
                $('#pdf_data').append($(debit));
        }
            var debit_sum = $("<input>").attr("type", "hidden")
                                                          .attr('name','debit_sums[]')
                                                          .val(sumDebit.sum);
            var credit_sum = $("<input>").attr("type", "hidden")
                                                          .attr('name','credit_sums[]')
                                                          .val(sumCredit.sum);
            var balance = $("<input>").attr("type", "hidden")
                                                          .attr('name','balances[]')
                                                          .val(balance_sum);

                $('#pdf_data').append($(debit_sum));
                $('#pdf_data').append($(credit_sum));
                $('#pdf_data').append($(balance));
        });




	});
</script>