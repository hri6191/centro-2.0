<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_purchase_ctrlr extends CI_Controller {

	public function index()
	{
            $data['title'] = 'Purchase Report';
            $data['company_name'] = $this->general->get_firm();
            $data['main_content']='godown_user/reports_purchase';
            $this->load->view('templates/standard',$data);
	}
        
        public function purchase_data()
	{
            $purchase_datas = $this->general->get_data_wer_not('purchase', 'purchase_type', 4);
            foreach ($purchase_datas as $purchase_data)
            {
                if($purchase_data->purchase_type == 1) { $purchase_type = 'VAT Dealer'; }
                if($purchase_data->purchase_type == 2) { $purchase_type = 'Interstate'; }
                if($purchase_data->purchase_type == 3) { $purchase_type = 'Imported'; }
                if($purchase_data->purchase_type == 4) { $purchase_type = 'Purchase'; }
                $vendor = $this->general->get_data_wer('vendor_reg', 'id', $purchase_data->vendor_id);
                $purchases[] = array('ReferenceNumber' => $purchase_data->reference_number,
                                    'Vendor' => $vendor[0]->vendor_name,
                                    'InvoiceNumber' => $purchase_data->invoice_number,
                                    'PurchaseDate' => $purchase_data->purchase_date,
                                    'PurchaseType' => $purchase_type,
                                    'PurchaseTotal' => number_format((float) $purchase_data->purchase_total, 2, '.', ''),
                                    'Status' => $purchase_data->status,
                                    'Description' => $purchase_data->description,
                                    'Edit' => 'Edit'
                                    );
            }
            echo json_encode($purchases);
	}
        
        public function single_purchase($reference_no)
	{
            $data['title'] = 'Purchase Report';
            $data['company_name'] = $this->general->get_firm();
            $purchase_details = $this->general->get_data_wer('purchase', 'reference_number', $reference_no);
            $data['purchase_id'] = $purchase_details[0]->id;
            $data['invoice_number'] = $purchase_details[0]->invoice_number;
            $data['purchase_date'] = $purchase_details[0]->purchase_date;
            $data['stock_date'] = $purchase_details[0]->stock_date;
            $data['reference_number'] = $purchase_details[0]->reference_number;
            $data['vendor'] = $this->general->get_data_wer('vendor_reg', 'id', $purchase_details[0]->vendor_id);
            if($purchase_details[0]->purchase_type == 1) { $data['purchase_type'] = 'VAT Dealer'; }
            if($purchase_details[0]->purchase_type == 2) { $data['purchase_type'] = 'Interstate'; }
            if($purchase_details[0]->purchase_type == 3) { $data['purchase_type'] = 'Imported'; }
            if($purchase_details[0]->purchase_type == 4) { $data['purchase_type'] = 'Purchase'; }
            $data['main_content']='godown_user/reports_purchase_single';
            $this->load->view('templates/standard',$data);
	}
        
        public function single_purchase_data()
	{
            $purchase_id = $this->input->get('purchase_id');
            $single_purchases = $this->general->get_data_wer('purchased_inventory', 'purchase_id', $purchase_id);
            foreach ($single_purchases as $single_purchase)
            {
                $inventory = $this->general->get_data_wer('inventory_reg', 'id', $single_purchase->inventory_id);
                $purchases[] = array('ItemName' => $inventory[0]->item_name,
                                    'Quantity' => $single_purchase->quantity,
                                    'Unit' => $single_purchase->unit,
                                    'Tax' => $single_purchase->purchase_tax,
                                    'PurchasePrice' => $single_purchase->purchase_price
                                    );
            }
            echo json_encode($purchases);
	}
	      
}