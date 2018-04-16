<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_sale_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Sale Report';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'godown_user/reports_sale';
        $this->load->view('templates/standard', $data);
    }

    public function sale_data() {
        $sale_datas = $this->general->get_data_wer('sale', 'created_by', $this->session->userdata('id'));
        foreach ($sale_datas as $sale_data) {
                $vendor = $this->general->get_data_wer('vendor_reg', 'id', $sale_data->customer_id);
                $real_customer = $this->general->get_data_wer('real_customer_reg', 'id', $sale_data->real_customer_id);
                $due= $sale_data->sale_total-$sale_data->cash_recieved;
                if($due==0) {
                    $diff='';
                } else {
                    $date1 = strtotime($sale_data->sale_date);
                    $date2 = time();
                    $datediff = $date2 - $date1;
                    $diff = floor($datediff / (60 * 60 * 24)).' Days';
                }
                
                $sales[] = array('Customer' => $vendor[0]->vendor_name,
                    'School' => $real_customer[0]->real_customer_name,
                    'InvoiceNumber' => $sale_data->invoice_number,
                    'SaleDate' => $sale_data->sale_date,
                    'SaleTotal' => $sale_data->sale_total,
                    'Description' => $sale_data->description,
                    'CashRecieved' => $due,
                    'DueDate' => $diff,
                    'Status' => $sale_data->status,
                    'Edit' => 'Edit'
                );
        }
        echo json_encode($sales);
    }

    public function single_sale($invoice_id) {
        $data['title'] = 'Sale Report';
        $data['company_name'] = $this->general->get_firm();
        $sale_details = $this->general->get_data_wer('sale', 'invoice_number', $invoice_id);
        $data['sale_id'] = $sale_details[0]->id;
        $data['invoice_number'] = $sale_details[0]->invoice_number;
        $data['sale_date'] = $sale_details[0]->sale_date;
        $data['sale_type'] = $sale_details[0]->sale_type;
        $data['school'] = $sale_details[0]->real_customer_id;
        $data['total_discount'] = $sale_details[0]->discount;
        $data['sale_total'] = $sale_details[0]->sale_total;
        $data['dc_no'] = $sale_details[0]->dc_no;
        $data['vehicle_no'] = $sale_details[0]->vehicle_no;
        $data['is_cancel'] = $sale_details[0]->status;
        $data['customer'] = $this->general->get_data_wer('vendor_reg', 'id', $sale_details[0]->customer_id);
        $data['main_content'] = 'godown_user/reports_sale_single';
        $this->load->view('templates/standard', $data);
    }

    public function single_sale_data() {
        $sale_id = $this->input->get('sale_id');
        $single_sales = $this->general->get_data_wer('sold_inventory', 'sale_id', $sale_id);
        foreach ($single_sales as $single_sale) {
            $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_sale->inventory_id);
            $sales[] = array('ItemName' => $inventory[0]->item_name,
                'ItemCode' => $inventory[0]->item_code,
                'SalePrice' => $single_sale->sale_price,
                'Quantity' => $single_sale->quantity,
                'Unit' => $single_sale->unit,
                'Tax' => $single_sale->sale_tax,
                'DiscountAmount' => $single_sale->discount,
                'NetValue' => ($single_sale->total)
            );
        }
        echo json_encode($sales);
    }
    
    public function sale_return() {
        $data['title'] = 'Sale Return Report';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'godown_user/reports_sale_return';
        $this->load->view('templates/standard', $data);
    }

    public function sale_return_data() {
        $sale_datas = $this->general->get_data_wer('sale_return', 'created_by', $this->session->userdata('id'));
        foreach ($sale_datas as $sale_data) {
                $vendor = $this->general->get_data_wer('vendor_reg', 'id', $sale_data->customer_id);
                $real_customer = $this->general->get_data_wer('real_customer_reg', 'id', $sale_data->real_customer_id);
                $due= $sale_data->sale_total-$sale_data->cash_recieved;
                if($due==0) {
                    $diff='';
                } else {
                    $date1 = strtotime($sale_data->sale_date);
                    $date2 = time();
                    $datediff = $date2 - $date1;
                    $diff = floor($datediff / (60 * 60 * 24)).' Days';
                }
                
                $sales[] = array('Customer' => $vendor[0]->vendor_name,
                    'School' => $real_customer[0]->real_customer_name,
                    'InvoiceNumber' => $sale_data->invoice_number,
                    'SaleDate' => $sale_data->sale_date,
                    'SaleTotal' => $sale_data->sale_total,
                    'CashRecieved' => $due,
                    'DueDate' => $diff,
                    'Status' => $sale_data->status,
                    'Edit' => 'Edit'
                );
        }
        echo json_encode($sales);
    }

    public function single_sale_return($invoice_id) {
        $data['title'] = 'Sale Return Report';
        $data['company_name'] = $this->general->get_firm();
        $sale_details = $this->general->get_data_wer('sale_return', 'invoice_number', $invoice_id);
        $data['sale_id'] = $sale_details[0]->id;
        $data['invoice_number'] = $sale_details[0]->invoice_number;
        $data['sale_date'] = $sale_details[0]->sale_date;
        $data['school'] = $sale_details[0]->real_customer_id;
        $data['total_discount'] = $sale_details[0]->discount;
        $data['sale_total'] = $sale_details[0]->sale_total;
        $data['dc_no'] = $sale_details[0]->dc_no;
        $data['vehicle_no'] = $sale_details[0]->vehicle_no;
        $data['is_cancel'] = $sale_details[0]->status;
        $data['customer'] = $this->general->get_data_wer('vendor_reg', 'id', $sale_details[0]->customer_id);
        $data['main_content'] = 'godown_user/reports_sale_return_single';
        $this->load->view('templates/standard', $data);
    }

    public function single_sale_return_data() {
        $sale_id = $this->input->get('sale_id');
        $single_sales = $this->general->get_data_wer('sold_return_inventory', 'sale_id', $sale_id);
        foreach ($single_sales as $single_sale) {
            $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_sale->inventory_id);
            $sales[] = array('ItemName' => $inventory[0]->item_name,
                'ItemCode' => $inventory[0]->item_code,
                'SalePrice' => $single_sale->sale_price,
                'Quantity' => $single_sale->quantity,
                'Unit' => $single_sale->unit,
                'Tax' => $single_sale->sale_tax,
                'DiscountAmount' => $single_sale->discount,
                'NetValue' => ($single_sale->total)
            );
        }
        echo json_encode($sales);
    }
    
    public function all_sale_order() {
        $data['title'] = 'Sale Order Report';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'reports/reports_sale_order_all';
        $this->load->view('templates/standard', $data);
    }

    public function sale_order_data() {
        $sale_datas = $this->general->get_data_wer_not('sale', 'sale_order_invoice_no', '');
        foreach ($sale_datas as $sale_data) {
                $customer_care = $this->general->get_data_wer('user_reg', 'id', $sale_data->created_by);
                $real_customer = $this->general->get_data_wer('real_customer_reg', 'id', $sale_data->real_customer_id);
                $sales[] = array('party' => $real_customer[0]->real_customer_name,
                    'invoice_number' => $sale_data->sale_order_invoice_no,
                    'sale_date' => $sale_data->sale_date,
                    'sale_total' => $sale_data->sale_total,
                    'status' => $sale_data->status,
                    'remarks' => $sale_data->remarks,
                    'user' => $customer_care[0]->user_name
                );
        }
        echo json_encode($sales);
    }

    public function single_sale_order($invoice_id) {
        $data['title'] = 'Sale Order Report';
        $data['company_name'] = $this->general->get_firm();
        $sale_details = $this->general->get_data_wer('sale', 'sale_order_invoice_no', $invoice_id);
        $data['real_customer'] = $this->general->get_data_wer('real_customer_reg', 'id', $sale_details[0]->real_customer_id);
        $data['sale_id'] = $sale_details[0]->id;
        $data['invoice_number'] = $sale_details[0]->sale_order_invoice_no;
        $data['sale_date'] = $sale_details[0]->sale_date;
        //$data['school'] = $sale_details[0]->real_customer_id;
        $data['sale_total'] = $sale_details[0]->sale_total;
        $data['is_cancel'] = $sale_details[0]->status;
        $data['customer'] = $this->general->get_data_wer('vendor_reg', 'id', $sale_details[0]->customer_id);
        $data['main_content'] = 'reports/reports_sale_order_single_all';
        $this->load->view('templates/standard', $data);
    }

    public function single_sale_order_data() {
        $sale_id = $this->input->get('sale_id');
        $single_sales = $this->general->get_data_wer('sold_inventory', 'sale_id', $sale_id);
        foreach ($single_sales as $single_sale) {
            $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_sale->inventory_id);
            $sales[] = array('item_name' => $inventory[0]->item_name,
                'sale_price' => $single_sale->sale_price,
                'quantity' => $single_sale->quantity,
                'gross' => $single_sale->sale_price * $single_sale->quantity,
                'discount' => $single_sale->discount,
                'net_value' => ($single_sale->total)
            );
        }
        echo json_encode($sales);
    }

}
