<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Json_m extends CI_Model
{
    
    public function get_inventory_by_vendor($vendor_id)
    {
        $qry=$this->db->select('id, item_name, item_code')->from('inventory_reg')->where('vendor',$vendor_id)->get();
	return $qry->result();
    }
    
    public function get_inventory_by_id($item_id)
    {
        $qry=$this->db->select('*')->from('inventory_reg')->where('id',$item_id)->get();
	return $qry->result();
    }
    
    public function get_account_group($account_name) {
        $qry = $this->db->select('*')->from('account_reg')->where('account_name', $account_name)->get();
        return $qry->result();
    }
   
}

?>
