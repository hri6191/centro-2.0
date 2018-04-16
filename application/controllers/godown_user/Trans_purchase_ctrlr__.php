<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_purchase_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Purchase';
        $data['company_name'] = $this->general->get_firm();
        $purchases = $this->general->get_max_data('purchase', 'reference_number');
        if ($purchases) {
            foreach ($purchases as $purchase)
                ;
            $data['reference_number'] = $purchase->reference_number + 1;
        } else {
            $data['reference_number'] = 374;
        }
        $data['from_accounts'] = $this->general->get_this_or_that('account_reg', 'account_group', 'Bank Accounts', 'Loans & Liabilities');
        $data['main_content'] = 'godown_user/trans_purchase';
        $this->load->view('templates/standard', $data);
    }

    public function save_purchase() {
        $invo = $this->general->get_max_data('purchase', 'reference_number');
        if ($invo) {
            foreach ($invo as $inv)
                ;
            $ref = $inv->reference_number + 1;
        } else {
            $ref = 374;
        }

        $purchase = array('reference_number' => $ref,
            'vendor_id' => $this->input->post('vendor_id'),
            'invoice_number' => $this->input->post('invoice_no'),
            'purchase_date' => $this->input->post('purchase_date'),
            'stock_date' => $this->input->post('stock_date'),
            'purchase_type' => $this->input->post('purchase_type'),
            'discount' => $this->input->post('discount_all'),
            'purchase_total' => $this->input->post('net_total'));
        $purchase_id = $this->general->save('purchase', $purchase);

        $inventory_id = $this->input->post('inventory_ids');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_price = $this->input->post('purchase_prices');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $purchase_tax = $this->input->post('purchase_taxs');
        $sale_price = $this->input->post('sale_prices');
        $profit_per = $this->input->post('profit_pers');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        for ($i = 0; $i < $n; $i++) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $inventory_id[$i]);
            if ($inventory_update[0]->default_unit == $unit[$i]) {
                $update_data = array('mrp' => $sale_price[$i],
                    'purchase_price' => $purchase_price[$i],
                    'current_stock' => $inventory_update[0]->current_stock + $quantity[$i]);
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            } else {
                $update_data = array('mrp' => $sale_price[$i] * $inventory_update[0]->alternative_unit_number,
                    'purchase_price' => $purchase_price[$i] * $inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock + ($quantity[$i] / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            }
            $data = array(
                'purchase_id' => $purchase_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'purchase_price' => $purchase_price[$i],
                'discount' => $disc_itemvise[$i],
                'purchase_tax' => $purchase_tax[$i],
                'sale_price' => $sale_price[$i],
                'profit_per' => $profit_per[$i],
                'total' => $total[$i]
            );
            $this->general->save('purchased_inventory', $data);
        }

        $account_data1 = array(
            'account_name' => $this->input->post('vendor'),
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('purchase_total'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => 'Purchase',
            'purchase_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data1);

        $account_data11 = array(
            'account_name' => 'Purchase',
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('purchase_total'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('vendor'),
            'purchase_id' => $purchase_id,
            'txn_id' => -1
        );
        $this->general->save('account_txn', $account_data11);
        if ($this->input->post('check_no') != '') {
            $cheque_details = ' Cheque: ' . $this->input->post('check_no');
        } else {
            $cheque_details = '';
        }
        $account_data2 = array(
            'account_name' => $this->input->post('vendor'),
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no') . '' . $cheque_details,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('from_account'),
            'purchase_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data2);

        $account_data22 = array(
            'account_name' => $this->input->post('from_account'),
            'account_group' => $this->input->post('from_account_group'),
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no') . '' . $cheque_details,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('vendor'),
            'purchase_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data22);

        redirect('transaction/purchase', 'refresh');
    }

    public function purchase_return() {
        $data['title'] = 'Purchase Return';
        $data['company_name'] = $this->general->get_firm();
        $purchases = $this->general->get_max_data('purchase_return', 'reference_number');
        if ($purchases) {
            foreach ($purchases as $purchase)
                ;
            $data['reference_number'] = $purchase->reference_number + 1;
        } else {
            $data['reference_number'] = 374;
        }
        $data['from_accounts'] = $this->general->get_data_wer('account_reg', 'account_group', 'Bank Accounts');
        $data['main_content'] = 'godown_user/trans_purchase_return';
        $this->load->view('templates/standard', $data);
    }

    public function save_return() {
        $data['company_name'] = $this->general->get_firm();
        $invo = $this->general->get_max_data('purchase_return', 'reference_number');
        if ($invo) {
            foreach ($invo as $inv)
                ;
            $ref = $inv->reference_number + 1;
        } else {
            $ref = 374;
        }

        $purchase = array('reference_number' => $ref,
            'vendor_id' => $this->input->post('vendor_id'),
            'invoice_number' => $this->input->post('invoice_no'),
            'purchase_date' => $this->input->post('purchase_date'),
            'stock_date' => $this->input->post('stock_date'),
            'purchase_type' => $this->input->post('purchase_type'),
            'discount' => $this->input->post('discount_all'),
            'purchase_total' => $this->input->post('net_total'));
        $purchase_id = $this->general->save('purchase_return', $purchase);

        $inventory_id = $this->input->post('inventory_ids');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_price = $this->input->post('purchase_prices');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $purchase_tax = $this->input->post('purchase_taxs');
        $sale_price = $this->input->post('sale_prices');
        $profit_per = $this->input->post('profit_pers');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        for ($i = 0; $i < $n; $i++) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $inventory_id[$i]);
            if ($inventory_update[0]->default_unit == $unit[$i]) {
                $update_data = array('mrp' => $sale_price[$i],
                    'purchase_price' => $purchase_price[$i],
                    'current_stock' => $inventory_update[0]->current_stock - $quantity[$i]);
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            } else {
                $update_data = array('mrp' => $sale_price[$i] * $inventory_update[0]->alternative_unit_number,
                    'purchase_price' => $purchase_price[$i] * $inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock - ($quantity[$i] / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            }
            $data = array(
                'purchase_id' => $purchase_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'purchase_price' => $purchase_price[$i],
                'discount' => $disc_itemvise[$i],
                'purchase_tax' => $purchase_tax[$i],
                'sale_price' => $sale_price[$i],
                'profit_per' => $profit_per[$i],
                'total' => $total[$i]
            );
            $this->general->save('purchased_return_inventory', $data);
        }

        $account_data1 = array(
            'account_name' => $this->input->post('vendor'),
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('purchase_total'),
            'description' => 'Purchase Return - Reference No: ' . $ref,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'payment',
            'from_or_to' => 'Purchase Return',
            'purchase_return_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data1);

        $account_data11 = array(
            'account_name' => 'Purchase Return',
            'account_group' => 'Purchase Return Account',
            'amount' => $this->input->post('purchase_total'),
            'description' => 'Purchase Return - Reference No: ' . $ref,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('vendor'),
            'purchase_return_id' => $purchase_id,
            'txn_id' => -1
        );
        $this->general->save('account_txn', $account_data11);
        if ($this->input->post('from_account') == 'cash_book') {
            $account_group = 'Cash In Hand';
        } else {
            $account_group = 'Bank Accounts';
        }
        $account_data2 = array(
            'account_name' => $this->input->post('vendor'),
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Purchase Return - Reference No: ' . $ref,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('from_account'),
            'purchase_return_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data2);

        $account_data22 = array(
            'account_name' => $this->input->post('from_account'),
            'account_group' => $account_group,
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Purchase Return - Reference No: ' . $ref,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('vendor'),
            'purchase_return_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data22);

        redirect('transaction/purchase-return', 'refresh');
    }

    public function edit_purchase($reference_no) {
        $data['title'] = 'Edit Purchase';
        $data['company_name'] = $this->general->get_firm();
        $purchase_details = $this->general->get_data_wer('purchase', 'reference_number', $reference_no);
        $data['purchase_id'] = $purchase_details[0]->id;
        $data['reference_number'] = $purchase_details[0]->reference_number;
        $data['invoice_number'] = $purchase_details[0]->invoice_number;
        $data['purchase_date'] = $purchase_details[0]->purchase_date;
        $data['stock_date'] = $purchase_details[0]->stock_date;
        $data['purchase_total'] = $purchase_details[0]->purchase_total;
        $data['discount_all'] = $purchase_details[0]->discount;
        //$data['cash_paid'] = $purchase_details[0]->cash_recieved;
        $data['vendor'] = $this->general->get_data_wer('vendor_reg', 'id', $purchase_details[0]->vendor_id);
        $data['from_accounts'] = $this->general->get_this_or_that('account_reg', 'account_group', 'Bank Accounts', 'Loans & Liabilities');
        $data['main_content'] = 'godown_user/trans_purchase_edit';
        $this->load->view('templates/standard', $data);
    }

    public function edit_purchase_data() {
        $purchase_id = $this->input->get('purchase_id');
        $single_purchases = $this->general->get_data_wer('purchased_inventory', 'purchase_id', $purchase_id);
        $si_no = 1;
        foreach ($single_purchases as $single_purchase) {
            $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_purchase->inventory_id);
            $purchases[] = array('si_no' => $si_no,
                'item_id' => $inventory[0]->id,
                'item_name' => $inventory[0]->item_name,
                'item_code' => $inventory[0]->item_code,
                'unit' => $single_purchase->unit,
                'sale_price' => $single_purchase->sale_price,
                'purchase_price' => $single_purchase->purchase_price,
                'quantity' => $single_purchase->quantity,
                'tax' => $single_purchase->purchase_tax,
                'disc_itemvise' => $single_purchase->discount,
                'total' => $single_purchase->total
            );
            $si_no++;
        }
        echo json_encode($purchases);
    }

    public function update_purchase() {
        $purchase_id = $this->input->post('purchase_id');

        $purchase = array('reference_number' => $this->input->post('reference_no'),
            'vendor_id' => $this->input->post('vendor_id'),
            'invoice_number' => $this->input->post('invoice_no'),
            'purchase_date' => $this->input->post('purchase_date'),
            'stock_date' => $this->input->post('stock_date'),
            'purchase_type' => $this->input->post('purchase_type'),
            'discount' => $this->input->post('discount_all'),
            'purchase_total' => $this->input->post('net_total'));
        $this->general->update('purchase', $purchase, $purchase_id);

        $old_purchased_inv_datas = $this->general->get_data_wer('purchased_inventory', 'purchase_id', $purchase_id);
        foreach ($old_purchased_inv_datas as $old_purchased_inv_data) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $old_purchased_inv_data->inventory_id);
            if ($inventory_update[0]->default_unit == $old_purchased_inv_data->unit) {
                $update_data = array(//'mrp' => $sale_price_update[$i],
                    'current_stock' => $inventory_update[0]->current_stock - $old_purchased_inv_data->quantity);
                $this->general->update('inventory_reg', $update_data, $old_purchased_inv_data->inventory_id);
            } else {
                $update_data = array(//'mrp' => $sale_price[$i]*$inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock - ($old_purchased_inv_data->quantity / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $old_purchased_inv_data->inventory_id);
            }
        }
        $this->general->delete_wer('purchased_inventory', 'purchase_id', $purchase_id);

        $inventory_id = $this->input->post('inventory_ids');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_price = $this->input->post('purchase_prices');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $purchase_tax = $this->input->post('purchase_taxs');
        $sale_price = $this->input->post('sale_prices');
        $profit_per = $this->input->post('profit_pers');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        for ($i = 0; $i < $n; $i++) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $inventory_id[$i]);
            if ($inventory_update[0]->default_unit == $unit[$i]) {
                $update_data = array('mrp' => $sale_price[$i],
                    'purchase_price' => $purchase_price[$i],
                    'current_stock' => $inventory_update[0]->current_stock + $quantity[$i]);
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            } else {
                $update_data = array('mrp' => $sale_price[$i] * $inventory_update[0]->alternative_unit_number,
                    'purchase_price' => $purchase_price[$i] * $inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock + ($quantity[$i] / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            }
            $data = array(
                'purchase_id' => $purchase_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'purchase_price' => $purchase_price[$i],
                'discount' => $disc_itemvise[$i],
                'purchase_tax' => $purchase_tax[$i],
                'sale_price' => $sale_price[$i],
                'profit_per' => $profit_per[$i],
                'total' => $total[$i]
            );
            $this->general->save('purchased_inventory', $data);
        }

        $this->general->delete_wer('account_txn', 'purchase_id', $purchase_id);

        $account_data1 = array(
            'account_name' => $this->input->post('vendor'),
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('purchase_total'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => 'Purchase',
            'purchase_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data1);

        $account_data11 = array(
            'account_name' => 'Purchase',
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('purchase_total'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('vendor'),
            'purchase_id' => $purchase_id,
            'txn_id' => -1
        );
        $this->general->save('account_txn', $account_data11);
        if ($this->input->post('check_no') != '') {
            $cheque_details = ' Cheque: ' . $this->input->post('check_no');
        } else {
            $cheque_details = '';
        }
        $account_data2 = array(
            'account_name' => $this->input->post('vendor'),
            'account_group' => 'Purchase Account',
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no') . '' . $cheque_details,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('from_account'),
            'purchase_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data2);

        $account_data22 = array(
            'account_name' => $this->input->post('from_account'),
            'account_group' => $this->input->post('from_account_group'),
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Purchase Invoice No: ' . $this->input->post('invoice_no') . '' . $cheque_details,
            'txn_date' => date("Y-m-d", strtotime($this->input->post('purchase_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('vendor'),
            'purchase_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data22);

        redirect('reports/purchase', 'refresh');
    }

    public function delete_purchase() {
        $purchase_id = $_GET['purchase_id'];

        //check
        $invo = $this->general->get_max_data('purchase', 'reference_number');
        foreach ($invo as $inv)
            ;
        $invoice = $inv->reference_number;
        $current_sale = $this->general->get_data_wer('purchase', 'id', $purchase_id);
        if ($invoice != $current_sale[0]->reference_number) {
            $update_data1 = array('status' => 1);
            $this->general->update('purchase', $update_data1, $purchase_id);
        } else {
            $this->general->delete('purchase', $purchase_id);
        }
        //check

        $sold_inventorys = $this->general->get_data_wer('purchased_inventory', 'purchase_id', $purchase_id);

        foreach ($sold_inventorys as $sold_inventory) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $sold_inventory->inventory_id);
            if ($inventory_update[0]->default_unit == $sold_inventory->unit) {
                $update_data = array(//'mrp' => $sale_price_update[$i],
                    'current_stock' => $inventory_update[0]->current_stock - $sold_inventory->quantity);
                $this->general->update('inventory_reg', $update_data, $sold_inventory->inventory_id);
            } else {
                $update_data = array(//'mrp' => $sale_price[$i]*$inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock - ($sold_inventory->quantity / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $sold_inventory->inventory_id);
            }
            //$data = array('cancel' => 1);
            //$this->general->update('sold_inventory', $data, $sale_id);
        }
        $this->general->delete_wer('purchased_inventory', 'purchase_id', $purchase_id);
        $this->general->delete_wer('account_txn', 'purchase_id', $purchase_id);

        redirect('reports/purchase', 'refresh');
    }

}
