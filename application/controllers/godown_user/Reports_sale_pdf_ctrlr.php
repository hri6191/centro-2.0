<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_sale_pdf_ctrlr extends CI_Controller {
        
        public function index()
	{
            $data['title'] = 'Sale';
            $settings = $this->general->get_all_asc('settings', 'id');
            $data['company_name'] = $this->general->get_firm();
            
            $purchase = array('invoice_number' => $this->input->post('invoice_no'),
                        'customer_id' => $this->input->post('customer_id'),
                        'sale_date' => $this->input->post('sale_date'),
                        'sale_type' => $this->input->post('sale_type'),
                        'sale_total' => $this->input->post('sale_total'),
                        'dc_no' => $this->input->post('dc_no'),
                        'vehicle_no' => $this->input->post('vehicle_no'),
                        'discount' => $this->input->post('total_discount'),
                        'real_customer_id' => $this->input->post('real_customer_id'));
            
            $inventory_name = $this->input->post('item_names');
            $inventory_code = $this->input->post('item_codes');
            $quantity = $this->input->post('quantitys');
            $disc_itemvise = $this->input->post('disc_itemvises');
            $sale_tax = $this->input->post('sale_taxs');
            $unit = $this->input->post('units');
            $sale_price = $this->input->post('sale_prices');
            $total = $this->input->post('total');

            //PrinT
            $this->load->helper(array('dompdf'));
            // page info here, db calls, etc. 
            $pdf_data = array('sale_data' => $purchase, 
                                'inventory_name' => $inventory_name,
                                'inventory_code' => $inventory_code,
                                'quantity'	=> $quantity,
                                'discount' => $disc_itemvise,
                                'sale_tax' => $sale_tax,
                                'unit' => $unit,
                                'sale_price' => $sale_price,
                                'total' => $total);
            $pdf_data['firm_details'] = $this->general->get_firm();
            if($settings[0]->printer == 1) {
                $html = $this->load->view('print_pdf', $pdf_data, true); } else {
                $html = $this->load->view('print_pdf_thermal', $pdf_data, true);
            }
            //$dompdf->set_option("enable_remote",true);
            $print['Attachment'] = 0;
            pdf_create($html, 'sale_bill'.$purchase['invoice_number'], $print);
            //or
            //$data = pdf_create($html, 'sale_'.$purchase_id, false);
            //write_file('sale_'.$purchase_id, $data);
            //if you want to write it to disk and/or send it as an attachment
            
            //PrinT
            
            //redirect('godown_user/sale', 'refresh');
	}
	      
}