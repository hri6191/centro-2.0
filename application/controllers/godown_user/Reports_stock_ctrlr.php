<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports_stock_ctrlr extends CI_Controller {

	public function index()
	{
            $data['title'] = 'Stock Report';
            $data['company_name'] = $this->general->get_firm();
            $data['main_content']='godown_user/reports_stock';
            $this->load->view('templates/standard',$data);
	}
        
        public function stock_data()
	{
            $stock_datas = $this->general->get_data_wer('inventory_reg', 'pay_inv', 0);
            foreach ($stock_datas as $stock_data)
            {
                $total_sale = $this->general->get_sum('sold_inventory', 'inventory_id', $stock_data->id, 'total');
                $total_purchase = $this->general->get_sum('purchased_inventory', 'inventory_id', $stock_data->id, 'total');
                $group = $this->general->get_data_wer('group_reg', 'id', $stock_data->group);
                $stocks[] = array('ItemName' => $stock_data->item_name,
                                    'ItemCode' => $stock_data->item_code,
                                    'Hsn' => $stock_data->hsn,
                                    'ItemGroup' => $group[0]->group_name,
                                    'Sale' => $total_sale[0]->total,
                                    'Purchase' => $total_purchase[0]->total,
                                    'CurrentStock' => $stock_data->current_stock.' '.$stock_data->default_unit,
                                    'Amount' => $stock_data->current_stock * ($stock_data->purchase_price + ($stock_data->purchase_price * $stock_data->tax/100)),
                                    'Delete' => 'Delete',
                                    'Id' => $stock_data->id,
                                    );
            }
            echo json_encode($stocks);
	}
	      
}