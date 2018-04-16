<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_sale_confirm_ctrlr extends CI_Controller {

    public function so_c() {
        $data['title'] = 'Sale Orders';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'confirmation_center/trans_so_c';
        $this->load->view('templates/standard', $data);
    }

    public function so_c_data() {
        $sale_datas = $this->general->get_data_wer('sale', 'status', 1);
        foreach ($sale_datas as $sale_data) {
//                $vendor = $this->general->get_data_wer('vendor_reg', 'id', $sale_data->customer_id);
            $real_customer = $this->general->get_data_wer('real_customer_reg', 'id', $sale_data->real_customer_id);
            $sales[] = array('party' => $real_customer[0]->real_customer_name,
                'invoice_number' => $sale_data->sale_order_invoice_no,
                'sale_date' => $sale_data->sale_date,
                'sale_total' => $sale_data->sale_total,
                'remarks' => $sale_data->remarks
            );
        }
        echo json_encode($sales);
    }

    public function single_so_c($invoice_id) {
        $data['title'] = 'Confirm Sale Order';
        $data['company_name'] = $this->general->get_firm();
        $sale_details = $this->general->get_data_wer('sale', 'sale_order_invoice_no', $invoice_id);
        $data['sale_id'] = $sale_details[0]->id;
        $data['invoice_number'] = $sale_details[0]->sale_order_invoice_no;
        $data['sale_date'] = $sale_details[0]->sale_date;
        $data['real_customer_id'] = $sale_details[0]->real_customer_id;
        $data['sale_total'] = $sale_details[0]->sale_total;
        $data['is_cancel'] = $sale_details[0]->status;
        $data['discount_all'] = $sale_details[0]->discount;
        $data['remarks'] = $sale_details[0]->remarks;
        $data['customer'] = $this->general->get_data_wer('vendor_reg', 'id', $sale_details[0]->customer_id);
        $data['real_customer'] = $this->general->get_data_wer('real_customer_reg', 'id', $sale_details[0]->real_customer_id);
        $data['main_content'] = 'confirmation_center/trans_so_c_single';
        $this->load->view('templates/standard', $data);
    }

    public function single_so_c_data() {
        $sale_id = $this->input->get('sale_id');
        $single_sales = $this->general->get_data_wer('sold_inventory', 'sale_id', $sale_id);
        $si_no = 1;
        foreach ($single_sales as $single_sale) {
            $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_sale->inventory_id);
            $sales[] = array('si_no' => $si_no,
                'item_id' => $inventory[0]->id,
                'item_name' => $inventory[0]->item_name,
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

    public function save_so_c() {

        if (isset($_POST['update'])) {
            $purchase = array(
            //'customer_id' => $this->input->post('customer_id'),
            //'real_customer_id' => $this->input->post('real_customer_id'),
            //'sale_type' => $this->input->post('sale_type'),
            'sale_date' => $this->input->post('sale_date'),
            'discount' => $this->input->post('discount_all'),
            'status' => 1,
            'sale_total' => $this->input->post('net_total'));
        $sale_id = $this->input->post('sale_id');
        $this->general->update('sale', $purchase, $sale_id);

        $inventory_id = $this->input->post('inventory_ids');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_tax = $this->input->post('purchase_taxs');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $sale_price = $this->input->post('sale_prices');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        $this->general->delete_wer('sold_inventory', 'sale_id', $sale_id);
        for ($i = 0; $i < $n; $i++) {
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
            $this->general->save('sold_inventory', $data);
        }
        } else if(isset($_POST['confirm'])) {
            $purchase = array(
            //'customer_id' => $this->input->post('customer_id'),
            //'real_customer_id' => $this->input->post('real_customer_id'),
            //'sale_type' => $this->input->post('sale_type'),
            'sale_date' => $this->input->post('sale_date'),
            'discount' => $this->input->post('discount_all'),
            'status' => 2,
            'sale_total' => $this->input->post('net_total'));
        $sale_id = $this->input->post('sale_id');
        $this->general->update('sale', $purchase, $sale_id);

        $inventory_id = $this->input->post('inventory_ids');
        $quantity = $this->input->post('quantitys');
        $unit = $this->input->post('units');
        $purchase_tax = $this->input->post('purchase_taxs');
        $disc_itemvise = $this->input->post('disc_itemvises');
        $sale_price = $this->input->post('sale_prices');
        $total = $this->input->post('total');

        $n = sizeof($inventory_id);
        $this->general->delete_wer('sold_inventory', 'sale_id', $sale_id);
        for ($i = 0; $i < $n; $i++) {
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
            $this->general->save('sold_inventory', $data);
        }
        }
        redirect('transaction/so-c', 'refresh');
    }

    public function delete_so_c() {
        $sale_id = $_GET['sale_id'];
        $status = $this->general->get_data_wer('sale', 'id', $sale_id);
        if ($status[0]->status == 1) {
            $update_data = array('is_active' => 0);
            $this->general->update('sale', $update_data, $sale_id);
            $this->general->update_wer('sold_inventory', $update_data, 'sale_id', $sale_id);
        }
        redirect('transaction/so-c', 'refresh');
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
