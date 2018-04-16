<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_wholesale_ctrlr extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('/', 'refresh');
        }
    }

    public function index() {
        $data['title'] = 'WholeSale';
        $data['company_name'] = $this->general->get_firm();
        $purchases = $this->general->get_max_data('whole_sale', 'invoice_number');
        if ($purchases) {
            foreach ($purchases as $purchase)
                ;
            $data['reference_number'] = $purchase->invoice_number + 1;
        } else {
            $data['reference_number'] = 374;
        }
        $data['from_accounts'] = $this->general->get_data_wer('account_reg', 'account_group', 'Bank Accounts');
        $data['main_content'] = 'godown_user/trans_wholesale';
        $this->load->view('templates/standard', $data);
    }

    public function save_sale() {
        $settings = $this->general->get_all_asc('settings', 'id');
        $invo = $this->general->get_max_data('whole_sale', 'invoice_number');
        if ($invo) {
            foreach ($invo as $inv)
                ;
            $invoice = $inv->invoice_number + 1;
        } else {
            $invoice = 374;
        }
        $purchase = array('invoice_number' => $invoice,
            'customer_id' => $this->input->post('customer_id'),
            'real_customer_id' => $this->input->post('real_customer_id'),
            'sale_date' => $this->input->post('sale_date'),
            'sale_type' => $this->input->post('sale_type'),
            'dc_no' => $this->input->post('dc_no'),
            'vehicle_no' => $this->input->post('vehicle_no'),
            'discount' => $this->input->post('discount_all'),
            'cash_recieved' => $this->input->post('cash_paid'),
            'status' => 3,
            'sale_total' => $this->input->post('net_total'));
        if($settings[0]->save_bill == 1) {
        $purchase_id = $this->general->save('whole_sale', $purchase); }

        $inventory_id = $this->input->post('inventory_ids');
        $inventory_name = $this->input->post('item_names');
        $inventory_code = $this->input->post('item_codes');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_tax = $this->input->post('purchase_taxs');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $sale_price = $this->input->post('sale_prices');
        $sale_price_update = $this->input->post('sale_price_updates');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        if($settings[0]->save_bill == 1) {
        for ($i = 0; $i < $n; $i++) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $inventory_id[$i]);
            if ($inventory_update[0]->default_unit == $unit[$i]) {
                $update_data = array(//'mrp' => $sale_price_update[$i],
                    'current_stock' => $inventory_update[0]->current_stock - $quantity[$i]);
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            } else {
                $update_data = array(//'mrp' => $sale_price[$i]*$inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock - ($quantity[$i] / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            }
            $data = array(
                'sale_id' => $purchase_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'sale_tax' => $purchase_tax[$i],
                'discount' => $disc_itemvise[$i],
                'sale_price' => $sale_price[$i],
                'total' => $total[$i]
            );
            $this->general->save('whole_sold_inventory', $data);
        }

        $account_data1 = array(
            'account_name' => $this->input->post('customer'),
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('net_total'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('reference_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'payment',
            'from_or_to' => 'Sale',
            'sale_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data1);

        $account_data11 = array(
            'account_name' => 'Sale',
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('net_total'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('reference_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('customer'),
            'sale_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data11);
        if ($this->input->post('from_account') == 'cash_book') {
            $account_group = 'Cash In Hand';
        } else {
            $account_group = 'Bank Accounts';
        }
        $account_data2 = array(
            'account_name' => $this->input->post('customer'),
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('reference_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('from_account'),
            'sale_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data2);

        $account_data22 = array(
            'account_name' => $this->input->post('from_account'),
            'account_group' => $account_group,
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('reference_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('customer'),
            'sale_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data22);
        }

        //PrinT
        $this->load->helper(array('dompdf'));
        // page info here, db calls, etc.
        $pdf_data = array('sale_data' => $purchase,
            'sale_id' => $purchase_id,
            'inventory_name' => $inventory_name,
            'inventory_code' => $inventory_code,
            'quantity' => $quantity,
            'unit' => $unit,
            'sale_tax' => $purchase_tax,
            'discount' => $disc_itemvise,
            'sale_price' => $sale_price,
            'sale_total_without_discount' => $this->input->post('sale_total_without_discount'),
            'total' => $total);
        if($settings[0]->printer == 1) {
            $html = $this->load->view('print_pdf_wholesale', $pdf_data, true); } else {
            $html = $this->load->view('print_pdf_wholesale_thermal', $pdf_data, true);
        }
        $print['Attachment'] = 0;
        pdf_create($html, 'sale_' . $purchase_id, $print);
    }

    public function update_sale() {
        $data['title'] = 'WholeSale Update';
        $sale_id = $this->input->post('sale_id');
        $sale = array('invoice_number' => $this->input->post('invoice_no'),
            'customer_id' => $this->input->post('customer_id'),
            'real_customer_id' => $this->input->post('real_customer_id'),
            'sale_date' => $this->input->post('sale_date'),
//            'sale_type' => $this->input->post('sale_type'),
            'dc_no' => $this->input->post('dc_no'),
            'vehicle_no' => $this->input->post('vehicle_no'),
            'discount' => $this->input->post('discount_all'),
            'cash_recieved' => $this->input->post('cash_paid'),
            'status' => 3,
            'sale_total' => $this->input->post('net_total'));
        $this->general->update('whole_sale', $sale, $sale_id);

        $old_sold_inventory_datas = $this->general->get_data_wer('whole_sold_inventory', 'sale_id', $sale_id);
        foreach ($old_sold_inventory_datas as $old_sold_inventory_data) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $old_sold_inventory_data->inventory_id);
            if ($inventory_update[0]->default_unit == $old_sold_inventory_data->unit) {
                $update_data = array(//'mrp' => $sale_price_update[$i],
                    'current_stock' => $inventory_update[0]->current_stock + $old_sold_inventory_data->quantity);
                $this->general->update('inventory_reg', $update_data, $old_sold_inventory_data->inventory_id);
            } else {
                $update_data = array(//'mrp' => $sale_price[$i]*$inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock + ($old_sold_inventory_data->quantity / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $old_sold_inventory_data->inventory_id);
            }
        }
        $this->general->delete_wer('whole_sold_inventory', 'sale_id', $sale_id);

        $inventory_id = $this->input->post('inventory_ids');
        $inventory_name = $this->input->post('item_names');
        $inventory_code = $this->input->post('item_codes');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_tax = $this->input->post('purchase_taxs');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $sale_price = $this->input->post('sale_prices');
        $sale_price_update = $this->input->post('sale_price_updates');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        for ($i = 0; $i < $n; $i++) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $inventory_id[$i]);
            if ($inventory_update[0]->default_unit == $unit[$i]) {
                $update_data = array(//'mrp' => $sale_price_update[$i],
                    'current_stock' => $inventory_update[0]->current_stock - $quantity[$i]);
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            } else {
                $update_data = array(//'mrp' => $sale_price[$i]*$inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock - ($quantity[$i] / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $inventory_id[$i]);
            }
            $data = array(
                'sale_id' => $sale_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'sale_tax' => $purchase_tax[$i],
                'discount' => $disc_itemvise[$i],
                'sale_price' => $sale_price[$i],
                'total' => $total[$i]
            );
            $this->general->save('whole_sold_inventory', $data);
        }

        $this->general->delete_wer('account_txn', 'sale_id', $sale_id);

        $account_data1 = array(
            'account_name' => $this->input->post('customer'),
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('net_total'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'payment',
            'from_or_to' => 'Sale',
            'sale_id' => $sale_id
        );
        $this->general->save('account_txn', $account_data1);

        $account_data11 = array(
            'account_name' => 'Sale',
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('net_total'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('customer'),
            'sale_id' => $sale_id
        );
        $this->general->save('account_txn', $account_data11);
        if ($this->input->post('from_account') == 'cash_book') {
            $account_group = 'Cash In Hand';
        } else {
            $account_group = 'Bank Accounts';
        }
        $account_data2 = array(
            'account_name' => $this->input->post('customer'),
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'receipt',
            'from_or_to' => $this->input->post('from_account'),
            'sale_id' => $sale_id
        );
        $this->general->save('account_txn', $account_data2);

        $account_data22 = array(
            'account_name' => $this->input->post('from_account'),
            'account_group' => $account_group,
            'amount' => $this->input->post('cash_paid'),
            'description' => 'Whole Sale - Invoice No: ' . $this->input->post('invoice_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('customer'),
            'sale_id' => $sale_id
        );
        $this->general->save('account_txn', $account_data22);

        //PrinT
        $this->load->helper(array('dompdf'));
        // page info here, db calls, etc.
        $pdf_data = array('sale_data' => $sale,
            'sale_id' => $sale_id,
            'inventory_name' => $inventory_name,
            'inventory_code' => $inventory_code,
            'quantity' => $quantity,
            'unit' => $unit,
            'sale_tax' => $purchase_tax,
            'discount' => $disc_itemvise,
            'sale_price' => $sale_price,
            'sale_total_without_discount' => $this->input->post('sale_total_without_discount'),
            'total' => $total);
        $html = $this->load->view('print_pdf_wholesale', $pdf_data, true);
        $print['Attachment'] = 0;
        pdf_create($html, 'sale_' . $sale_id, $print);
    }

    public function delete_sale() {
        //$data['title'] = 'Sale';
        //$data['company_name'] = $this->general->get_firm();
        $sale_id = $_GET['sale_id'];

        //check
        $invo = $this->general->get_max_data('whole_sale', 'invoice_number');
        foreach ($invo as $inv)
            ;
        $invoice = $inv->invoice_number;
        $current_sale = $this->general->get_data_wer('whole_sale', 'id', $sale_id);
        if ($invoice != $current_sale[0]->invoice_number) {
            $update_data1 = array('status' => 1);
            $this->general->update('whole_sale', $update_data1, $sale_id);
        } else {
            $this->general->delete('whole_sale', $sale_id);
        }
        //check

        $sold_inventorys = $this->general->get_data_wer('whole_sold_inventory', 'sale_id', $sale_id);

        foreach ($sold_inventorys as $sold_inventory) {
            $inventory_update = $this->general->get_data_wer('inventory_reg', 'id', $sold_inventory->inventory_id);
            if ($inventory_update[0]->default_unit == $sold_inventory->unit) {
                $update_data = array(//'mrp' => $sale_price_update[$i],
                    'current_stock' => $inventory_update[0]->current_stock + $sold_inventory->quantity);
                $this->general->update('inventory_reg', $update_data, $sold_inventory->inventory_id);
            } else {
                $update_data = array(//'mrp' => $sale_price[$i]*$inventory_update[0]->alternative_unit_number,
                    'current_stock' => $inventory_update[0]->current_stock + ($sold_inventory->quantity / $inventory_update[0]->alternative_unit_number));
                $this->general->update('inventory_reg', $update_data, $sold_inventory->inventory_id);
            }
            //$data = array('cancel' => 1);
            //$this->general->update('sold_inventory', $data, $sale_id);
        }
        $this->general->delete_wer('whole_sold_inventory', 'sale_id', $sale_id);
        $this->general->delete_wer('account_txn', 'sale_id', $sale_id);

        redirect('reports/wholesale', 'refresh');
    }

    public function edit_sale($invoice_id) {
        $data['title'] = 'Edit WholeSale';
        $data['company_name'] = $this->general->get_firm();
        $sale_details = $this->general->get_data_wer('whole_sale', 'invoice_number', $invoice_id);
        $data['sale_id'] = $sale_details[0]->id;
        $data['invoice_number'] = $sale_details[0]->invoice_number;
        $data['sale_date'] = $sale_details[0]->sale_date;
        $data['real_customer_id'] = $sale_details[0]->real_customer_id;
        $data['sale_total'] = $sale_details[0]->sale_total;
        $data['dc_no'] = $sale_details[0]->dc_no;
        $data['vehicle_no'] = $sale_details[0]->vehicle_no;
        $data['is_cancel'] = $sale_details[0]->status;
        $data['discount_all'] = $sale_details[0]->discount;
        $data['cash_paid'] = $sale_details[0]->cash_recieved;
        $data['customer'] = $this->general->get_data_wer('vendor_reg', 'id', $sale_details[0]->customer_id);
        $data['real_customer'] = $this->general->get_data_wer('real_customer_reg', 'id', $sale_details[0]->real_customer_id);
        $data['main_content'] = 'godown_user/trans_wholesale_edit';
        $this->load->view('templates/standard', $data);
    }

    public function edit_sale_data() {
        $sale_id = $this->input->get('sale_id');
        $single_sales = $this->general->get_data_wer('whole_sold_inventory', 'sale_id', $sale_id);
        $si_no = 1;
        foreach ($single_sales as $single_sale) {
            $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_sale->inventory_id);
            $sales[] = array('si_no' => $si_no,
                'item_id' => $inventory[0]->id,
                'item_name' => $inventory[0]->item_name,
                'item_code' => $inventory[0]->item_code,
                'unit' => $single_sale->unit,
                'sale_price' => $single_sale->sale_price,
                'quantity' => $single_sale->quantity,
                'tax' => $single_sale->sale_tax,
                'disc_itemvise' => $single_sale->discount,
                'total' => $single_sale->total
            );
            $si_no++;
        }
        echo json_encode($sales);
    }

}
