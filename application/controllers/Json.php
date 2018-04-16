<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json extends CI_Controller {
        
        public function get_inventory_by_vendor()
        {
            $this->load->model('json_m');
            $vendor_id = $this->input->post('vendor_id');		
            $result = $this->json_m->get_inventory_by_vendor($vendor_id);		
            echo json_encode($result);
        }
        
        public function get_inventory_by_id()
        {
            $this->load->model('json_m');
            $item_id = $this->input->post('item_id');		
            $result = $this->json_m->get_inventory_by_id($item_id);	
            $data = array(
                            'purchase_price' => $result[0]->purchase_price,
                            'default_unit' => $result[0]->default_unit,
                            'alternative_unit' => $result[0]->alternative_unit,
                            'tax' => $result[0]->tax,
                            'mrp' => $result[0]->mrp,
                            'wholesale_price' => $result[0]->wholesale_price,
                            'branch_price' => $result[0]->branch_price,
                            'item_name' => $result[0]->item_name,
                            'item_code' => $result[0]->item_code,
                            'current_stock' => $result[0]->current_stock
                            );
            echo json_encode($data);
        }
        
        public function get_inventory_for_sale()
        {
            $this->load->model('json_m');
            $item_id = $this->input->post('item_id');		
            $result = $this->json_m->get_inventory_by_id($item_id);	
            $data = array(
                            'mrp' => $result[0]->mrp,
                            'wholesale_price' => $result[0]->wholesale_price,
                            'current_stock' => $result[0]->current_stock,
                            'minimum_stock' => $result[0]->minimum_stock,
                            'default_unit' => $result[0]->default_unit,
                            'alternative_unit' => $result[0]->alternative_unit,
                            'tax' => $result[0]->tax,
                            'item_name' => $result[0]->item_name,
                            'item_code' => $result[0]->item_code
                            );
            echo json_encode($data);
        }
        
        public function get_inventory_for_unit_change()
        {
            $this->load->model('json_m');
            $item_id = $this->input->post('item_id');		
            $result = $this->json_m->get_inventory_by_id($item_id);	
            $data = array(
                            'purchase_price' => $result[0]->purchase_price,
                            'sale_price' => $result[0]->mrp,
                            'sale_price2' => $result[0]->wholesale_price,
                            'sale_price3' => $result[0]->branch_price,
                            'alternative_unit_number' => $result[0]->alternative_unit_number,
                            'default_unit' => $result[0]->default_unit
                            );
            echo json_encode($data);
        }
        
        public function get_inventory_for_unit_change2()
        {
            $this->load->model('json_m');
            $item_id = $this->input->post('item_id');		
            $result = $this->json_m->get_inventory_by_id($item_id);	
            $data = array(
                            'purchase_price' => $result[0]->purchase_price,
                            'sale_price' => $result[0]->wholesale_price,
                            'alternative_unit_number' => $result[0]->alternative_unit_number,
                            'default_unit' => $result[0]->default_unit
                            );
            echo json_encode($data);
        }
        
        public function get_account_group()
        {
            $this->load->model('json_m');
            $account_name = $this->input->post('account_name');		
            $result = $this->json_m->get_account_group($account_name);	
            $data = array(
                            'account_group' => $result[0]->account_group
                            );
            echo json_encode($data);
        }
	      
}