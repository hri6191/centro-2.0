<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

        <link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url(); ?>assets/images/favicon.jpg' />

        <link type="text/css" rel="stylesheet" href='<?php echo CSS_PATH . "normalize.css" ?>' />
        <link type="text/css" rel="stylesheet" href='<?php echo CSS_PATH . "foundation.css" ?>' />
        <link type="text/css" rel="stylesheet" href='<?php echo CSS_PATH . "foundation.min.css" ?>' />
        <link type="text/css" rel="stylesheet" href='<?php echo CSS_PATH . "jquery-ui.css" ?>' />
        <link type="text/css" rel="stylesheet" href='<?php echo CSS_PATH . "style.css" ?>' />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/jqwidgets/styles/jqx.base.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href='<?php echo CSS_PATH . "jquery.autocomplete.css" ?>' />

        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-1.7.2.js"></script>
        <script type="text/javascript" src="<?php echo JS_PATH ?>jquery-ui.min.js"></script>

        <title><?php echo $title; ?></title>
    </head>

    <body style="background-image: url('assets/images/background.jpg')">
        <div class="">
            <nav class="top-bar" data-topbar>
                <ul class="title-area">
                    <li class="name">
                        <h1><a href="<?php echo base_url() . "home"; ?>"><?php echo $company_name; ?></a></h1>
                    </li>
                    <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
                </ul>

                <section class="top-bar-section">
                    <?php if($this->session->userdata('user_type') == 0) { ?>
                    <ul class="right">
                            <li class="has-dropdown">
                                <a href="#">Registration</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class=""><a href="<?php echo base_url() . "registration/firm"; ?>">Firm</a></li>
                                </ul>
                            </li>
                            
                            <li class="has-dropdown">
                                <a href="#">Bill Settings</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class=""><a href="<?php echo base_url() . "reports/sale-order"; ?>">Bill Design</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/customer-history"; ?>">Bill Fields</a></li>
                                </ul>
                            </li>
                            <li style="">
                                <b><a >Welcome, <?php echo $this->session->userdata('user_name'); ?></a></b>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout">Logout</a>
                            </li>
                        </ul>
                    <?php } else if ($this->session->userdata('user_type') == 1) { ?>
                        <ul class="right">
                            <li class="has-dropdown">
                                <a href="#">Registration</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class=""><a href="<?php echo base_url() . "registration/real-customer"; ?>">Party</a></li>
                                </ul>
                            </li>
                            <li class="has-dropdown" style="z-index: 2000;">
                                <a href="#">Transaction</a>
                                <ul class="dropdown">
                                    <li class=""><a href="<?php echo base_url() . "transaction/sale-order"; ?>">Sale Order</a></li>
                                </ul>
                            </li>
                            <li class="has-dropdown">
                                <a href="#">Reports</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class=""><a href="<?php echo base_url() . "reports/sale-order"; ?>">Sale Order Report</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/customer-history"; ?>">Customer History</a></li>
                                </ul>
                            </li>
                            <li style="">
                                <b><a >Welcome, <?php echo $this->session->userdata('user_name'); ?></a></b>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout">Logout</a>
                            </li>
                        </ul>
                    <?php } else if ($this->session->userdata('user_type') == 2) { ?>
                        <ul class="right">
                            <li class="">
                                <a href="<?php echo base_url() . "transaction/so-c"; ?>">Sale Orders</a>
                            </li>
                            <li class="">
                                <a href="<?php echo base_url() . "reports/sale-order-all"; ?>">Status</a>
                            </li>
                            <li style="">
                                <b><a >Welcome, <?php echo $this->session->userdata('user_name'); ?></a></b>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout">Logout</a>
                            </li>
                        </ul>
                    <?php } else if ($this->session->userdata('user_type') == 3) { ?>
                        <ul class="right">
                            <li class="has-dropdown">
                                <a href="#">Registration</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class=""><a href="<?php echo base_url() . "registration/vendor"; ?>">Vendor</a></li>
                                    <li class=""><a href="<?php echo base_url() . "registration/customer"; ?>">Customer</a></li>
                                    <li class=""><a href="<?php echo base_url() . "registration/inventory"; ?>">Inventory</a></li>
                                    <li class=""><a href="<?php echo base_url() . "registration/account"; ?>">Account</a></li>
                                </ul>
                            </li>
                            <li class="has-dropdown" style="z-index: 2000;">
                                <a href="#">Transaction</a>
                                <ul class="dropdown">
                                    <li class="has-dropdown"><a>Production</a>
                                        <ul class="dropdown">
                                            <li class=""><a href="<?php echo base_url() . "transaction/production"; ?>">Raw Material</a></li>
<!--                                            <li class=""><a href="<?php echo base_url() . "transaction/sale-group"; ?>">Sale [Group]</a></li>-->
                                            <li class=""><a href="<?php echo base_url() . "transaction/production/product_add"; ?>">Product</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown"><a>Sales</a>
                                        <ul class="dropdown">
                                            <li class=""><a href="<?php echo base_url() . "transaction/sale"; ?>">Sale</a></li>
<!--                                            <li class=""><a href="<?php echo base_url() . "transaction/sale-group"; ?>">Sale [Group]</a></li>-->
                                            <li class=""><a href="<?php echo base_url() . "transaction/sale-return"; ?>">Sales Return</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-dropdown"><a>Purchase</a>
                                        <ul class="dropdown">
                                            <li class=""><a href="<?php echo base_url() . "transaction/purchase"; ?>">Purchase</a></li>
                                            <li class=""><a href="<?php echo base_url() . "transaction/payment-purchase"; ?>">Payments</a></li>
                                            <li class=""><a href="<?php echo base_url() . "transaction/purchase-return"; ?>">Purchase Return</a></li>
                                        </ul>
                                    </li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/receipts"; ?>">Receipts</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/payments"; ?>">Payments</a></li>
                                </ul>
                            </li>
                            <li class="has-dropdown">
                                <a href="#">Reports</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class="has-dropdown"><a>Sales</a>
                                        <ul class="dropdown">
                                            <li class=""><a href="<?php echo base_url() . "reports/sale"; ?>">Sales</a></li>
<!--                                            <li class=""><a href="<?php echo base_url() . "reports/wholesale"; ?>">Whole Sales</a></li>
                                            <li class=""><a href="<?php echo base_url() . "reports/interstate-sale"; ?>">Interstate Sales</a></li>-->
                                            <li class=""><a href="<?php echo base_url() . "reports/sale-return"; ?>">Sales Return</a></li>
                                        </ul>
                                    </li>
                                    <li class=""><a href="<?php echo base_url() . "reports/purchase"; ?>">Purchase</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/stock"; ?>">Stock</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/select-tax-report"; ?>">Tax Report</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/select-gst-report"; ?>">GSTR1 [HSN]</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/select-gst-report1"; ?>">GSTR1 [B2C]</a></li>
                                    
                                    
                                </ul>
                            </li>
                            <li class="has-dropdown" style="z-index: 2000;">
                                <a href="#">Accounts</a>
                                <ul class="dropdown">
                                    <li class=""><a href="<?php echo base_url() . "accounts/all-cash-book"; ?>">Cash Book</a></li>
                                    <li class=""><a href="<?php echo base_url() . "accounts/select-day-book"; ?>">Day Book</a></li>
                                    <li class=""><a href="<?php echo base_url() . "accounts/select-ledger"; ?>">Ledger</a></li>
                                </ul>
                            </li>
                            <li style="">
                                <b><a >Welcome, <?php echo $this->session->userdata('user_name'); ?></a></b>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout">Logout</a>
                            </li>
                        </ul>
                    <?php } else if ($this->session->userdata('user_type') == 4) { ?>
                        <ul class="right">
                            <li class="has-dropdown">
                                <a href="#">Registration</a>
                                <ul class="dropdown" style="z-index: 2000;">
    <!--                                <li class=""><a href="<?php echo base_url() . "registration/firm"; ?>">Firm</a></li>-->
                                    <li class=""><a href="<?php echo base_url() . "registration/vendor"; ?>">Vendor</a></li>
                                    <li class=""><a href="<?php echo base_url() . "registration/customer"; ?>">Agent</a></li>
    <!--                                    <li class=""><a href="<?php echo base_url() . "registration/real-customer"; ?>">Party</a></li>-->
                                    <li class=""><a href="<?php echo base_url() . "registration/inventory"; ?>">Inventory</a></li>
                                    <li class=""><a href="<?php echo base_url() . "registration/user"; ?>">User</a></li>
                                </ul>
                            </li>
                            <!--<li class="has-dropdown" style="z-index: 2000;">
                                <a href="#">Transaction</a>
                                <ul class="dropdown">
                                    <li class=""><a href="<?php echo base_url() . "transaction/sale-order"; ?>">Sale Order</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/so-s"; ?>">Sale Order -> Sale</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/sale"; ?>">Sale</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/purchase"; ?>">Purchase</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/receipts"; ?>">Receipts</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/payments"; ?>">Payments</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/sale-return"; ?>">Sale Return</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/purchase-return"; ?>">Purchase Return</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/sale-edit"; ?>">Sale Edit</a></li>
                                    <li class=""><a href="<?php echo base_url() . "transaction/purchase-edit"; ?>">Purchase Edit</a></li>
                                </ul>
                            </li>-->
                            <li class="has-dropdown" style="z-index: 2000;">
                                <a href="#">Accounts</a>
                                <ul class="dropdown">
                                    <li class=""><a href="<?php echo base_url() . "accounts/cash-book"; ?>">Cash Book</a></li>
                                    <li class=""><a href="<?php echo base_url() . "accounts/ledger"; ?>">Ledger</a></li>
                                    <li class=""><a href="<?php echo base_url() . "accounts/trial-balance"; ?>">Trial Balance</a></li>
                                    <li class=""><a href="<?php echo base_url() . "accounts/recievable-payable"; ?>">Receivable/Payable</a></li>
                                </ul>
                            </li>
                            <li class="has-dropdown">
                                <a href="#">Reports</a>
                                <ul class="dropdown" style="z-index: 2000;">
                                    <li class=""><a href="<?php echo base_url() . "reports/stock"; ?>">Stock</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/purchase"; ?>">Purchase</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/sale-order-all"; ?>">Sale Order</a></li>
                                    <li class=""><a href="<?php echo base_url() . "reports/sale"; ?>">Sales</a></li>
                                </ul>
                            </li>
                            <li style="">
                                <b><a >Welcome, <?php echo $this->session->userdata('user_name'); ?></a></b>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>logout">Logout</a>
                            </li>
                        </ul>
                    <?php } ?>
                </section>
            </nav>
        </div>
        <br/>