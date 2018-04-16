<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'index_ctrlr';

$route['home'] = "Index_ctrlr/home";
$route['logout'] = "Index_ctrlr/logout";
$route['backup'] = "Backup_ctrlr";

//Call Center Routes//
$route['registration/real-customer'] = "call_center/reg_real_customer_ctrlr";
$route['registration/real-customer/add'] = "call_center/reg_real_customer_ctrlr/add";
$route['registration/real-customer/edit-mode'] = "call_center/reg_real_customer_ctrlr/edit_mode";
$route['registration/real-customer/edit'] = "call_center/reg_real_customer_ctrlr/edit";
$route['registration/real-customer/delete'] = "call_center/reg_real_customer_ctrlr/delete";

$route['transaction/sale-order'] = "call_center/trans_sale_order_ctrlr";
$route['transaction/sale-order/save'] = "call_center/trans_sale_order_ctrlr/save";

$route['reports/sale-order'] = "call_center/reports_sale_order_ctrlr";
$route['reports/sale-order/invoice/(:any)'] = "call_center/reports_sale_order_ctrlr/single_sale_order/$1";
$route['reports/customer-history'] = "call_center/reports_sale_order_ctrlr/customer_history";
$route['reports/customer-history/invoice/(:any)'] = "call_center/reports_sale_order_ctrlr/single_customer_history/$1";
//Call Center Routes//


//Confirmation Center Routes
$route['transaction/so-c'] = "confirmation_center/trans_sale_confirm_ctrlr/so_c";
$route['transaction/so-c/save'] = "confirmation_center/trans_sale_confirm_ctrlr/save_so_c";
$route['transaction/so-c/delete'] = "confirmation_center/trans_sale_confirm_ctrlr/delete_so_c";
$route['transaction/so-c/invoice/(:any)'] = "confirmation_center/trans_sale_confirm_ctrlr/single_so_c/$1";
$route['transaction/sale-order/delete'] = "confirmation_center/trans_sale_confirm_ctrlr/delete_sale_order";

$route['reports/sale-order-all'] = "confirmation_center/reports_sale_confirm_ctrlr/all_sale_order";
$route['reports/sale-order-all/invoice/(:any)'] = "confirmation_center/reports_sale_confirm_ctrlr/single_sale_order/$1";
//Confirmation Center Routes


//Godown User
$route['registration/vendor'] = "godown_user/Reg_vendor_ctrlr";
$route['registration/vendor/add'] = "godown_user/Reg_vendor_ctrlr/add";
$route['registration/vendor/edit-mode'] = "godown_user/Reg_vendor_ctrlr/edit_mode";
$route['registration/vendor/edit'] = "godown_user/Reg_vendor_ctrlr/edit";
$route['registration/vendor/delete'] = "godown_user/Reg_vendor_ctrlr/delete";
$route['registration/customer'] = "godown_user/Reg_customer_ctrlr";
$route['registration/customer/add'] = "godown_user/Reg_customer_ctrlr/add";
$route['registration/customer/edit-mode'] = "godown_user/Reg_customer_ctrlr/edit_mode";
$route['registration/customer/edit'] = "godown_user/Reg_customer_ctrlr/edit";
$route['registration/customer/delete'] = "godown_user/Reg_customer_ctrlr/delete";
$route['registration/inventory'] = "godown_user/Reg_inventory_ctrlr";
$route['registration/inventory/add'] = "godown_user/Reg_inventory_ctrlr/add";
$route['registration/inventory/edit-mode'] = "godown_user/Reg_inventory_ctrlr/edit_mode";
$route['registration/inventory/edit'] = "godown_user/Reg_inventory_ctrlr/edit";
$route['registration/inventory/delete/(:any)'] = "godown_user/Reg_inventory_ctrlr/delete/$1";
$route['registration/group'] = "godown_user/Reg_group_ctrlr";
$route['registration/group/add'] = "godown_user/Reg_group_ctrlr/add";
$route['registration/group/edit-mode'] = "godown_user/Reg_group_ctrlr/edit_mode";
$route['registration/group/edit'] = "godown_user/Reg_group_ctrlr/edit";
$route['registration/group/delete'] = "godown_user/Reg_group_ctrlr/delete";
$route['registration/brand'] = "godown_user/Reg_brand_ctrlr";
$route['registration/brand/add'] = "godown_user/Reg_brand_ctrlr/add";
$route['registration/brand/edit-mode'] = "godown_user/Reg_brand_ctrlr/edit_mode";
$route['registration/brand/edit'] = "godown_user/Reg_brand_ctrlr/edit";
$route['registration/brand/delete'] = "godown_user/Reg_brand_ctrlr/delete";
$route['registration/account'] = "godown_user/Reg_account_ctrlr";
$route['registration/account/add'] = "godown_user/Reg_account_ctrlr/add";
$route['registration/account/edit-mode'] = "godown_user/Reg_account_ctrlr/edit_mode";
$route['registration/account/edit'] = "godown_user/Reg_account_ctrlr/edit";
$route['registration/account/delete'] = "godown_user/Reg_account_ctrlr/delete";

$route['transaction/purchase'] = "godown_user/Trans_purchase_ctrlr";
$route['transaction/purchase/save'] = "godown_user/Trans_purchase_ctrlr/save_purchase";
$route['transaction/purchase-return'] = "godown_user/Trans_purchase_ctrlr/purchase_return";
$route['transaction/purchase/edit/(:any)'] = "godown_user/Trans_purchase_ctrlr/edit_purchase/$1";
$route['transaction/purchase/update'] = "godown_user/Trans_purchase_ctrlr/update_purchase";
$route['transaction/purchase/delete'] = "godown_user/Trans_purchase_ctrlr/delete_purchase";
$route['transaction/purchase-return/save'] = "godown_user/Trans_purchase_ctrlr/save_return";
$route['transaction/sale'] = "godown_user/Trans_sale_ctrlr";
$route['transaction/production'] = "godown_user/Production_ctrlr";
$route['transaction/production/add_product'] = "godown_user/Production_ctrlr/add_product";
$route['transaction/production/save_raw'] = "godown_user/Production_ctrlr/save_raw";
$route['transaction/production/product_add'] = "godown_user/Production_ctrlr/product_add";
$route['transaction/sale/save'] = "godown_user/Trans_sale_ctrlr/save_sale";
$route['transaction/sale/update'] = "godown_user/Trans_sale_ctrlr/update_sale";
$route['transaction/sale/delete'] = "godown_user/Trans_sale_ctrlr/delete_sale";
$route['transaction/sale/edit/(:any)'] = "godown_user/Trans_sale_ctrlr/edit_sale/$1";
$route['transaction/wholesale'] = "godown_user/Trans_wholesale_ctrlr";
$route['transaction/wholesale/save'] = "godown_user/Trans_wholesale_ctrlr/save_sale";
$route['transaction/wholesale/update'] = "godown_user/Trans_wholesale_ctrlr/update_sale";
$route['transaction/wholesale/delete'] = "godown_user/Trans_wholesale_ctrlr/delete_sale";
$route['transaction/wholesale/edit/(:any)'] = "godown_user/Trans_wholesale_ctrlr/edit_sale/$1";
$route['transaction/interstate-sale'] = "godown_user/Trans_i_sale_ctrlr";
$route['transaction/interstate-sale/save'] = "godown_user/Trans_i_sale_ctrlr/save_sale";
$route['transaction/interstate-sale/update'] = "godown_user/Trans_i_sale_ctrlr/update_sale";
$route['transaction/interstate-sale/delete'] = "godown_user/Trans_i_sale_ctrlr/delete_sale";
$route['transaction/interstate-sale/edit/(:any)'] = "godown_user/Trans_i_sale_ctrlr/edit_sale/$1";
$route['transaction/sale-return'] = "godown_user/Trans_sale_ctrlr/sale_return";
$route['transaction/sale-return/save'] = "godown_user/Trans_sale_ctrlr/save_return";
$route['transaction/sale-return/update'] = "godown_user/Trans_sale_ctrlr/update_return";
$route['transaction/sale-return/delete'] = "godown_user/Trans_sale_ctrlr/delete_return";
$route['transaction/sale-return/edit/(:any)'] = "godown_user/Trans_sale_ctrlr/edit_return/$1";
$route['transaction/payments'] = "godown_user/Trans_payment_ctrlr";
$route['transaction/payments/add'] = "godown_user/Trans_payment_ctrlr/add";
$route['transaction/payments/edit-mode'] = "godown_user/Trans_payment_ctrlr/edit_mode";
$route['transaction/payments/edit'] = "godown_user/Trans_payment_ctrlr/edit";
$route['transaction/payments/delete/(:any)'] = "godown_user/Trans_payment_ctrlr/delete/$1";
$route['transaction/receipts'] = "godown_user/Trans_receipts_ctrlr";
$route['transaction/receipts/add'] = "godown_user/Trans_receipts_ctrlr/add";
$route['transaction/receipts/edit-mode'] = "godown_user/Trans_receipts_ctrlr/edit_mode";
$route['transaction/receipts/edit'] = "godown_user/Trans_receipts_ctrlr/edit";
$route['transaction/receipts/delete/(:any)'] = "godown_user/Trans_receipts_ctrlr/delete/$1";

$route['transaction/payment-purchase'] = "godown_user/Trans_pay_purchase_ctrlr";
$route['transaction/payment-purchase/save'] = "godown_user/Trans_pay_purchase_ctrlr/save_purchase";
$route['transaction/payment-purchase/edit/(:any)'] = "godown_user/Trans_pay_purchase_ctrlr/edit_purchase/$1";
$route['transaction/payment-purchase/update'] = "godown_user/Trans_pay_purchase_ctrlr/update_purchase";
$route['transaction/payment-purchase/delete'] = "godown_user/Trans_pay_purchase_ctrlr/delete_purchase";

$route['reports/stock'] = "godown_user/Reports_stock_ctrlr";
$route['reports/purchase'] = "godown_user/Reports_purchase_ctrlr";
$route['reports/purchase/invoice/(:any)'] = "godown_user/Reports_purchase_ctrlr/single_purchase/$1";
$route['reports/sale'] = "godown_user/Reports_sale_ctrlr";
$route['reports/sale/invoice/(:any)'] = "godown_user/Reports_sale_ctrlr/single_sale/$1";
$route['reports/sale-group'] = "godown_user/Reports_sale_ctrlr/group_sale";
$route['reports/wholesale'] = "godown_user/Reports_wholesale_ctrlr";
$route['reports/wholesale/invoice/(:any)'] = "godown_user/Reports_wholesale_ctrlr/single_sale/$1";
$route['reports/interstate-sale'] = "godown_user/Reports_i_sale_ctrlr";
$route['reports/interstate-sale/invoice/(:any)'] = "godown_user/Reports_i_sale_ctrlr/single_sale/$1";
$route['reports/sale-return'] = "godown_user/Reports_sale_ctrlr/sale_return";
$route['reports/sale-return/invoice/(:any)'] = "godown_user/Reports_sale_ctrlr/single_sale_return/$1";
$route['reports/sale/create-pdf'] = "godown_user/Reports_sale_pdf_ctrlr";
$route['reports/select-tax-report'] = "godown_user/Reports_tax_ctrlr/select_date";
$route['reports/tax-report'] = "godown_user/Reports_tax_ctrlr";
$route['reports/select-gst-report'] = "godown_user/Reports_tax_ctrlr/select_gst";
$route['reports/gst-report'] = "godown_user/Reports_tax_ctrlr/gst";
$route['reports/select-gst-report1'] = "godown_user/Reports_tax_ctrlr/select_gst1";
$route['reports/gst-report1'] = "godown_user/Reports_tax_ctrlr/gst1";
$route['reports/gst-upload'] = "godown_user/Reports_extra_ctrlr";
$route['reports/gst-upload1'] = "godown_user/Reports_extra_ctrlr/b2c";
//Godown User


//Admin
$route['registration/user'] = "registration/Reg_user_ctrlr";
$route['registration/user/add'] = "registration/Reg_user_ctrlr/add";
$route['registration/user/edit-mode'] = "registration/Reg_user_ctrlr/edit_mode";
$route['registration/user/edit'] = "registration/Reg_user_ctrlr/edit";
$route['registration/user/delete'] = "registration/Reg_user_ctrlr/delete";

$route['accounts/select-day-book'] = "accounts/Acc_daybook_ctrlr/select_date";
$route['accounts/day-book'] = "accounts/Acc_daybook_ctrlr";
$route['accounts/all-day-book'] = "accounts/Acc_daybook_ctrlr_all";
$route['accounts/select-cash-book'] = "accounts/Acc_cashbook_ctrlr/select_date";
$route['accounts/cash-book'] = "accounts/Acc_cashbook_ctrlr";
$route['accounts/all-cash-book'] = "accounts/Acc_cashbook_ctrlr_all";
$route['accounts/select-ledger'] = "accounts/Acc_ledger_ctrlr/select_account";
$route['accounts/ledger'] = "accounts/Acc_ledger_ctrlr";
$route['accounts/all-ledger'] = "accounts/Acc_ledger_ctrlr_all";
$route['accounts/trial-balance'] = "accounts/Acc_trial_ctrlr";
$route['accounts/recievable-payable'] = "accounts/Acc_recievable_payable_ctrlr";
$route['accounts/creat-pdf'] = "accounts/Acc_ledger_ctrlr/printing";
$route['cash-book/creat-pdf'] = "accounts/Acc_cashbook_ctrlr/printing";
//Admin


//Service Menu
$route['registration'] = "registration/reg_index_ctrlr";
$route['registration/firm'] = "registration/reg_firm_ctrlr";
$route['registration/firm/add'] = "registration/reg_firm_ctrlr/add";
$route['registration/firm/edit-mode'] = "registration/reg_firm_ctrlr/edit_mode";
$route['registration/firm/edit'] = "registration/reg_firm_ctrlr/edit";
$route['registration/firm/delete'] = "registration/reg_firm_ctrlr/delete";
//Service Menu

//Billing
$route['billing/sale'] = "billing/Bil_sale_ctrlr";
$route['billing/sale/save'] = "billing/Bil_sale_ctrlr/save_sale";
//Billing

$route['transaction'] = "transaction/Trans_index_ctrlr";
$route['reports'] = "reports/Reports_index_ctrlr";
$route['reports/sale-order/create-pdf'] = "reports/Reports_sale_order_ctrlr/pdf";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
