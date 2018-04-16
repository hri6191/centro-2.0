<style>
    .image-card img {
        -webkit-transition: 0.4s ease;
        transition: 0.4s ease;
    }

    .image-card:hover img {
        -webkit-transform: scale(1.08);
        transform: scale(1.08);
    }
    .image-card a {
        color: darkred;
    }
</style>
<div class="">
    <div class="large-3 columns"  >
        <center><a class="th" onclick="show_hide('reg');"><img id="reg_img" src="<?php echo IMAGES_PATH ?>general.png" width="100" height="100"></a>
            <a onclick="show_hide('reg');"><p>REGISTRATION</p></a></center>
    </div>
    <div class="large-3 columns"  >
        <center><a class="th" onclick="show_hide('txn');"><img src="<?php echo IMAGES_PATH ?>general.png" width="100" height="100"></a>
            <a onclick="show_hide('txn');"><p>TRANSACTIONS</p></a></center>
    </div>
    <div class="large-3 columns"  >
        <center><a class="th" onclick="show_hide('reports');"><img src="<?php echo IMAGES_PATH ?>general.png" width="100" height="100"></a>
            <a onclick="show_hide('reports');"><p>REPORTS</p></a></center>
    </div>
    <div class="large-3 columns"  >
        <center><a class="th" onclick="show_hide('accounts');"><img src="<?php echo IMAGES_PATH ?>general.png" width="100" height="100"></a>
            <a onclick="show_hide('accounts');"><p>ACCOUNTS</p></a></center>
    </div>
</div>
<div style="text-align: center;" id="centro">
    <img src="<?php echo base_url(); ?>assets/images/slider1.png">
</div>

<div class="row" id="reg" style="display: none;"><hr><h4>REGISTRATION</h4><hr>
    <div class="large-4 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>registration/vendor"><img src="<?php echo IMAGES_PATH ?>vendor.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>registration/vendor"><p>VENDOR</p></a></center>
    </div>
    <div class="large-4 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>registration/customer"><img src="<?php echo IMAGES_PATH ?>customer.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>registration/customer"><p>CUSTOMER</p></a></center>
    </div>
    <div class="large-4 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>registration/inventory"><img src="<?php echo IMAGES_PATH ?>inventory.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>registration/inventory"><p>INVENTORY</p></a></center>
    </div>
<!--    <div class="large-3 columns image-card"  >    
        <center><a class="" href="<?php echo base_url() ?>registration/firm"><img src="<?php echo IMAGES_PATH ?>firm.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>registration/firm"><p>FIRM</p></a></center>
    </div>-->
</div>

<div id="txn" style="display: none;">
    <div class="row"><hr><h4>TRANSACTION</h4><hr>
        <div class="large-3 columns image-card"  >
            <center><a class="" href="<?php echo base_url() ?>transaction/sale"><img src="<?php echo IMAGES_PATH ?>verthe.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>transaction/sale"><p>SALE</p></a></center>
        </div>
        <div class="large-3 columns image-card"  >
            <center><a class="" href="<?php echo base_url() ?>transaction/sale-return"><img src="<?php echo IMAGES_PATH ?>verthe.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>transaction/sale-return"><p>SALE RETURN</p></a></center>
        </div>
        <div class="large-3 columns image-card"  >    
            <center><a class="" href="<?php echo base_url() ?>transaction/purchase"><img src="<?php echo IMAGES_PATH ?>verthe.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>transaction/purchase"><p>PURCHASE</p></a></center>
        </div>
        <div class="large-3 columns image-card"  >    
            <center><a class="" href="<?php echo base_url() ?>transaction/purchase-return"><img src="<?php echo IMAGES_PATH ?>verthe.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>transaction/purchase-return"><p>PURCHASE RETURN</p></a></center>
        </div>
    </div>
    <div class="row">
        <div class="large-3 columns image-card"  >    
            <center><a class="" href="<?php echo base_url() ?>transaction/payments"><img src="<?php echo IMAGES_PATH ?>verthe.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>transaction/payments"><p>PAYMENTS</p></a></center>
        </div>
        <div class="large-3 columns image-card"  >    
            <center><a class="" href="<?php echo base_url() ?>transaction/receipts"><img src="<?php echo IMAGES_PATH ?>verthe.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>transaction/receipts"><p>RECEIPTS</p></a></center>
        </div>
        <div class="large-3 columns"  >
        </div>
    </div>
</div>

<div class="row" id="reports" style="display: none;"><hr><h4>REPORTS</h4><hr>
    <div class="large-3 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>reports/stock"><img src="<?php echo IMAGES_PATH ?>reports.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>reports/stock"><p>STOCK REPORT</p></a></center>
    </div>
    <div class="large-3 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>reports/sale"><img src="<?php echo IMAGES_PATH ?>reports.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>reports/sale"><p>SALE REPORT</p></a></center>
    </div>
    <div class="large-3 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>reports/sale-return"><img src="<?php echo IMAGES_PATH ?>reports.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>reports/sale-return"><p>SALES RETURN REPORT</p></a></center>
    </div>
    <div class="large-3 columns image-card"  >
        <center><a class="" href="<?php echo base_url() ?>reports/purchase"><img src="<?php echo IMAGES_PATH ?>reports.png" width="75" height="75"></a>
            <a href="<?php echo base_url() ?>reports/purchase"><p>PURCHASE REPORT</p></a></center>
    </div>
</div>

<div id="accounts" style="display: none;">
    <div class="row"><hr><h4>ACCOUNTS</h4><hr>
        <div class="large-4 columns image-card"  >
            <center><a class="" href="<?php echo base_url() ?>accounts/select-cash-book"><img src="<?php echo IMAGES_PATH ?>accounts.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>accounts/select-cash-book"><p>CASH BOOK</p></a></center>
        </div>
        <div class="large-4 columns image-card"  >
            <center><a class="" href="<?php echo base_url() ?>accounts/select-day-book"><img src="<?php echo IMAGES_PATH ?>accounts.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>accounts/select-day-book"><p>DAY BOOK</p></a></center>
        </div>
        <div class="large-4 columns image-card"  >
            <center><a class="" href="<?php echo base_url() ?>accounts/select-ledger"><img src="<?php echo IMAGES_PATH ?>accounts.png" width="75" height="75"></a>
                <a href="<?php echo base_url() ?>accounts/select-ledger"><p>LEDGER</p></a></center>
        </div>
    </div>
    <div class="row">
        <div class="large-4 columns image-card"  >    
            <center><a class="" href="#"><img src="<?php echo IMAGES_PATH ?>accounts.png" width="75" height="75"></a>
                <a href="#"><p>TRIAL BALANCE</p></a></center>
        </div>
        <div class="large-4 columns image-card"  >    
            <center><a class="" href="#"><img src="<?php echo IMAGES_PATH ?>accounts.png" width="75" height="75"></a>
                <a href="#"><p>BALANCE SHEET</p></a></center>
        </div>
        <div class="large-4 columns image-card"  >    
            <center><a class="" href="#"><img src="<?php echo IMAGES_PATH ?>accounts.png" width="75" height="75"></a>
                <a href="#"><p>P&L ACCOUNT</p></a></center>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
<?php if (isset($_GET['tab'])) {
    $tab = $_GET['tab']; ?>show_hide('<?php echo $tab; ?>');<?php } ?>
            });

            function show_hide(tab)
            {
                if (tab == 'reg') {
                    $("#centro").hide();
                    $("#txn").hide();
                    $("#reports").hide();
                    $("#accounts").hide();
                    $("#reg").show('fast');
                }
                if (tab == 'txn') {
                    $("#centro").hide();
                    $("#reg").hide();
                    $("#reports").hide();
                    $("#accounts").hide();
                    $("#txn").show();
                }
                if (tab == 'reports') {
                    $("#centro").hide();
                    $("#txn").hide();
                    $("#reg").hide();
                    $("#accounts").hide();
                    $("#reports").show('fast');
                }
                if (tab == 'accounts') {
                    $("#centro").hide();
                    $("#txn").hide();
                    $("#reports").hide();
                    $("#reg").hide();
                    $("#accounts").show();
                }

            }
</script>