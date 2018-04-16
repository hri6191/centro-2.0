<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bil_sale_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Estimate/Bill';
        $data['company_name'] = $this->general->get_firm();
        $purchases = $this->general->get_max_data('bill_sale', 'invoice_number');
        if ($purchases) {
            foreach ($purchases as $purchase)
                ;
            $data['reference_number'] = $purchase->invoice_number + 1;
        } else {
            $data['reference_number'] = 671;
        }
        $data['from_accounts'] = $this->general->get_data_wer('account_reg', 'account_group', 'Bank Accounts');
        $data['main_content'] = 'billing/bill_sale';
        $this->load->view('templates/standard', $data);
    }

    public function save_sale() {
        $data['title'] = 'Estimate';
        $invo = $this->general->get_max_data('bill_sale', 'invoice_number');
        if ($invo) {
            foreach ($invo as $inv);
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
            'status' => 3,
            'sale_total' => $this->input->post('net_total'));
        $purchase_id = $this->general->save('bill_sale', $purchase);

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
                'sale_id' => $purchase_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'sale_tax' => $purchase_tax[$i],
                'discount' => $disc_itemvise[$i],
                'sale_price' => $sale_price[$i],
                'total' => $total[$i]
            );
            $this->general->save('billed_sale_inventory', $data);
        }
        
        $account_data1 = array(
            'account_name' => $this->input->post('customer'),
            'account_group' => 'Sales Accounts',
            'amount' => $this->input->post('net_total'),
            'description' => 'Bill No: ' . $this->input->post('reference_no'),
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
            'description' => 'Bill No: ' . $this->input->post('reference_no'),
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
            'description' => 'Bill No: ' . $this->input->post('reference_no'),
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
            'description' => 'Bill No: ' . $this->input->post('reference_no'),
            'txn_date' => date("Y-m-d", strtotime($this->input->post('sale_date'))),
            'txn_type' => 'payment',
            'from_or_to' => $this->input->post('customer'),
            'sale_id' => $purchase_id
        );
        $this->general->save('account_txn', $account_data22);

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
        $html = $this->load->view('print_bill_pdf', $pdf_data, true);
        $print['Attachment'] = 0;
        pdf_create($html, 'bill_'.$purchase_id, $print);
    }

    public function pdf() {
        $this->load->helper(array('dompdf'));
        // page info here, db calls, etc.
        $data[''] = '';
        $html = $this->load->view('print_pdf', $data, true);
        $print['Attachment'] = 0;
        pdf_create($html, 'haii', $print);
        //or
        //$data = pdf_create($html, '', false);
        //write_file('name', $data);
        //if you want to write it to disk and/or send it as an attachment
        //
            //PDF VIEW
        //
//            $file = 'assets/sale_bills/sale_8.pdf';
//            $filename = 'sale_8.pdf';
//            header('Content-type: application/pdf');
//            header('Content-Disposition: inline; filename="' . $filename . '"');
//            header('Content-Transfer-Encoding: binary');
//            header('Accept-Ranges: bytes');
//            @readfile($file); exit;
    }

}
