<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gst_mod extends CI_Model {
    
    public function get_gst($row, $position1, $position2) {
        $this->db->where("$row >= '$position1' AND $row <= '$position2'");
        $this->db->group_by('sale_tax');
        $this->db->select('SUM(quantity * sale_price) as sale_price', false);
        $this->db->select_sum('total');
        $this->db->select('sale_tax');
        $this->db->where('is_active', 1);
        $results = $this->db->get('sold_inventory')->result();
        return $results;
    }
    
    public function split($row, $position1, $position2) {
        $this->db->where("$row >= '$position1' AND $row <= '$position2'");
        $this->db->where('is_active', 1);
        //$this->db->group_by('inventory_id');
        $this->db->group_by('hsn');
        $this->db->select('SUM(quantity * sale_price) as sale_price', false);
        $this->db->select_sum('total');
        $this->db->select('inventory_id');
        $this->db->select('sale_tax');
        $this->db->select('sale_type');
        $this->db->select_sum('quantity');
        $this->db->select('unit');
        return $this->db->get('sold_inventory')->result();
    }

}

?>
