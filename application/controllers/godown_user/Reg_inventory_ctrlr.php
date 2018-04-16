<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_inventory_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Inventory Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'godown_user/reg_inventory';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $data = array(
            "item_name" => $this->input->post('item_name'),
            "item_code" => $this->input->post('item_code'),
            "item_desc" => $this->input->post('item_desc'),
            "hsn" => $this->input->post('hsn'),
            "tax" => $this->input->post('tax'),
            "group" => $this->input->post('group_hid'),
            "brand" => $this->input->post('brand'),
            "mrp" => $this->input->post('mrp'),
            //"retail_price" => $this->input->post('retail_price'),
            "wholesale_price" => $this->input->post('wholesale_price'),
            "branch_price" => $this->input->post('branch_price'),
            "purchase_price" => $this->input->post('purchase_price'),
            "current_stock" => $this->input->post('opening_stock'),
            "minimum_stock" => $this->input->post('minimum_stock'),
            "max_stock" => $this->input->post('max_stock'),
            "default_unit" => $this->input->post('default_unit'),
            "alternative_unit" => $this->input->post('alternative_unit'),
            "alternative_unit_number" => $this->input->post('alternative_unit_number'),
            "sgst" => $this->input->post('sgst'),
            "cgst" => $this->input->post('cgst'),
            "igst" => $this->input->post('igst'),
            "pay_inv" => $this->input->post('pay_inv')
        );
        $this->general->save('inventory_reg', $data);
        //$this->general->save('stock', array('item_id' => $this->db->insert_id(),
        //'stock' => $this->input->post('opening_stock')));
        redirect('registration/inventory');
    }

    public function edit_mode() {
        $data['title'] = 'Inventory Registration';
        $data['company_name'] = $this->general->get_firm();
        $edit_id = $this->input->post('edit_id');
        if ($edit_id == '') {
            redirect('registration/inventory');
        }
        $data['edit_id'] = $edit_id;
        $data['edit_mode'] = $this->general->get_data_wer('inventory_reg', 'id', $edit_id);
        $data['group'] = $this->general->get_data_wer('group_reg', 'id', $data['edit_mode'][0]->group);
        $data['main_content'] = 'godown_user/reg_inventory';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $data = array(
            "item_name" => $this->input->post('item_name'),
            "item_code" => $this->input->post('item_code'),
            "item_desc" => $this->input->post('item_desc'),
            "hsn" => $this->input->post('hsn'),
            "tax" => $this->input->post('tax'),
            "group" => $this->input->post('group_hid'),
            "brand" => $this->input->post('brand'),
            "mrp" => $this->input->post('mrp'),
            //"retail_price" => $this->input->post('retail_price'),
            "wholesale_price" => $this->input->post('wholesale_price'),
            "branch_price" => $this->input->post('branch_price'),
            "purchase_price" => $this->input->post('purchase_price'),
            "current_stock" => $this->input->post('opening_stock'),
            "minimum_stock" => $this->input->post('minimum_stock'),
            "max_stock" => $this->input->post('max_stock'),
            "default_unit" => $this->input->post('default_unit'),
            "alternative_unit" => $this->input->post('alternative_unit'),
            "alternative_unit_number" => $this->input->post('alternative_unit_number'),
            "sgst" => $this->input->post('sgst'),
            "cgst" => $this->input->post('cgst'),
            "igst" => $this->input->post('igst'),
            "pay_inv" => $this->input->post('pay_inv')
        );
        $this->general->update('inventory_reg', $data, $id);
        //$this->general->update_wer('stock', array('stock' => $this->input->post('opening_stock')), 'item_id', $id);
        redirect('registration/inventory');
    }
    
    public function delete($id) {
        $purchase = $this->general->get_data_wer('purchased_inventory', 'inventory_id', $id);
        $sale = $this->general->get_data_wer('sold_inventory', 'inventory_id', $id);
        if($sale) {
            redirect('registration/inventory');
        } else if($purchase){
            redirect('registration/inventory');
        } else {
        $this->general->delete('inventory_reg', $id);
        redirect('reports/stock');
        }
    }

}
