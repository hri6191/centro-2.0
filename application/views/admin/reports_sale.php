<style>
    .green {
        color: black\9;
        background-color: #b6ff00\9;
    }
    .yellow {
        color: black\9;
        background-color: yellow\9;
    }
    .red {
        color: black\9;
        background-color: #e83636\9;
    }

    .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .green:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
        color: black;
        background-color: #b6ff00;
    }
    .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .yellow:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
        color: black;
        background-color: yellow;
    }
    .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected), .jqx-widget .red:not(.jqx-grid-cell-hover):not(.jqx-grid-cell-selected) {
        color: black;
        background-color: #e83636;
    }
</style>
<div class="">
    <div class="large-12 small-12 columns" id="navigate">
        <ul class="breadcrumbs">
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li><a href="<?php echo base_url(); ?>reports">Reports</a></li>
            <li class="current"><a href="#">Sale</a></li>
        </ul>
    </div>
</div>
<div class="large-12 small-12 columns">
    <h4>Sale Order Report</h4>
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
                        {name: 'Customer'},
                        {name: 'School'},
                        {name: 'InvoiceNumber'},
                        {name: 'SaleDate'},
                        {name: 'SaleTotal'},
                        {name: 'Status'}
                    ],
                    url: '<?php echo base_url() . "reports/reports_sale_ctrlr/sale_data"; ?>',
                    cache: false
                };

        var cellclass = function(row, columnfield, value) {
            status = $('#jqxgrid').jqxGrid('getcellvalue', row, 'Status');
            if (status == 2) {
                return 'yellow';
            }
                else if (status == 3) {
                    return 'green';
                }
                else if (status == 3) {
                    return 'red';
                }
        }

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
                        {text: 'Customer', datafield: 'Customer', cellclassname: cellclass, width: '25%'},
                        {text: 'School', datafield: 'School', cellclassname: cellclass, width: '25%'},
                        {text: 'Invoice Number', datafield: 'InvoiceNumber', cellclassname: cellclass, width: '15%', cellsrenderer: function(row, cell, value) {
                                return '<a href="<?php echo base_url(); ?>reports/sale/invoice/' + value + '" />' + value + '</a>'
                            }},
                        {text: 'Sale Date', datafield: 'SaleDate', filtertype: 'date', cellclassname: cellclass, width: '15%'},
                        {text: 'Status', datafield: 'Status', hidden: true, width: '25%'},
                        {text: 'Sale Total', datafield: 'SaleTotal', filtertype: 'number', cellclassname: cellclass, aggregates: ['sum'], width: '20%'}
                    ]
                });
    });
</script>