<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_sale_order_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Sale Order';
        $data['company_name'] = $this->general->get_firm();
        $purchases = $this->general->get_max_data('sale', 'sale_order_invoice_no');
        if ($purchases) {
            foreach ($purchases as $purchase)
                ;
            $data['reference_number'] = $purchase->sale_order_invoice_no + 1;
        } else {
            $data['reference_number'] = 1;
        }
        $data['from_accounts'] = $this->general->get_data_wer('account_reg', 'account_group', 'Bank Accounts');
        $data['main_content'] = 'call_center/trans_sale_order';
        $this->load->view('templates/standard', $data);
    }

    public function save() {
        $invo = $this->general->get_max_data('sale', 'sale_order_invoice_no');
        if ($invo) {
            foreach ($invo as $inv)
                ;
            $invoice = $inv->sale_order_invoice_no + 1;
        } else {
            $invoice = 1;
        }
        $purchase = array('sale_order_invoice_no' => $invoice,
            'customer_id' => $this->input->post('customer_id'),
            'real_customer_id' => $this->input->post('real_customer_id'),
            'sale_date' => $this->input->post('sale_date'),
            'sale_type' => $this->input->post('sale_type'),
            'discount' => $this->input->post('discount_all'),
            'sale_total' => $this->input->post('net_total'),
            'remarks' => $this->input->post('remarks'));
        $purchase_id = $this->general->save('sale', $purchase);

        $inventory_id = $this->input->post('inventory_ids');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_tax = $this->input->post('purchase_taxs');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $sale_price = $this->input->post('sale_prices');
//        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        for ($i = 0; $i < $n; $i++) {
            $data = array(
                'sale_id' => $purchase_id,
                'inventory_id' => $inventory_id[$i],
                'quantity' => $quantity[$i],
                'unit' => $unit[$i],
                'sale_tax' => $purchase_tax[$i],
                'discount' => $disc_itemvise[$i],
                'sale_price' => $sale_price[$i],
                'total' => (($sale_price[$i]*$quantity[$i])+($quantity[$i]*$sale_price[$i]*$purchase_tax[$i]/100))
            );
            $this->general->save('sold_inventory', $data);
        }

        //PrinT
//        $this->load->helper(array('dompdf'));
        // page info here, db calls, etc.
//        $pdf_data = array('sale_data' => $purchase,
//            'sale_id' => $purchase_id,
//            'inventory_name' => $inventory_name,
//            'quantity' => $quantity,
//            'unit' => $unit,
//            'sale_tax' => $purchase_tax,
//            'discount' => $disc_itemvise,
//            'sale_price' => $sale_price,
//            'sale_total_without_discount' => $this->input->post('sale_total_without_discount'),
//            'total' => $total);
//        $html = $this->load->view('print_pdf', $pdf_data, true);
        //$dompdf->set_option("enable_remote",true);
//        $print['Attachment'] = 0;
//        pdf_create($html, 'sale_'.$purchase_id, $print);
        //or
//        $data = pdf_create($html, 'sale_' . $purchase_id, false);
//        write_file('sale_' . $purchase_id, $data);
        //if you want to write it to disk and/or send it as an attachment
        //PrinT
        redirect('transaction/sale-order', 'refresh');
    }

    public function delete_sale_order() {
        $sale_id = $_GET['sale_id'];
        $status = $this->general->get_data_wer('sale', 'id', $sale_id);
        if($status[0]->status == 1) {
            $update_data = array('is_active' => 0);
            $this->general->update('sale', $update_data, $sale_id);
            $this->general->update_wer('sold_inventory', $update_data, 'sale_id', $sale_id);
        }
        redirect('reports/sale-order', 'refresh');
    }

}
