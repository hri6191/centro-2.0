<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_wholesale_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'WholeSale Report';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'godown_user/reports_wholesale';
        $this->load->view('templates/standard', $data);
    }

    public function sale_data() {
        $sale_datas = $this->general->get_data_wer('whole_sale', 'created_by', $this->session->userdata('id'));
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

    public function single_sale($invoice_id) {
        $data['title'] = 'WholeSale Report';
        $data['company_name'] = $this->general->get_firm();
        $sale_details = $this->general->get_data_wer('whole_sale', 'invoice_number', $invoice_id);
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
        $data['main_content'] = 'godown_user/reports_wholesale_single';
        $this->load->view('templates/standard', $data);
    }

    public function single_sale_data() {
        $sale_id = $this->input->get('sale_id');
        $single_sales = $this->general->get_data_wer('whole_sold_inventory', 'sale_id', $sale_id);
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

}
