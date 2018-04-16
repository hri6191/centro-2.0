<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>reports">Transaction</a></li>
            <li class="current"><a href="#">Sale Orders</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Sale Orders</h4>
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
    $(document).ready(function() {


        var source =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'party'},
                        {name: 'invoice_number'},
                        {name: 'sale_date'},
                        {name: 'sale_total'},
                        {name: 'remarks'}
                    ],
                    url: '<?php echo base_url() . "confirmation_center/trans_sale_confirm_ctrlr/so_c_data"; ?>',
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
                        {text: 'Party', datafield: 'party', width: '30%'},
                        {text: 'Order Number', datafield: 'invoice_number', width: '15%', cellsrenderer: function(row, cell, value) {
                                return '<a href="<?php echo base_url(); ?>transaction/so-c/invoice/' + value + '" />' + value + '</a>'
                            }},
                        {text: 'Sale Date', datafield: 'sale_date', filtertype: 'date', width: '15%'},
                        {text: 'Sale Total', datafield: 'sale_total', filtertype: 'none', width: '20%'},
                        {text: 'Remark', datafield: 'remarks', width: '20%'}
                    ]
                });
    });
</script>