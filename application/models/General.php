<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General extends CI_Model {

    public function get_firm() {
        $firms = $this->db->get('firm_reg')->result();
        foreach ($firms as $firm);
        return $firm->firm_name;
    }

    public function get_max_data($table, $id) {
        $this->db->where('is_active', 1);
        $this->db->select_max($id);
        return $this->db->get($table)->result();
    }

    public function get_data_wer($table, $row, $position) {
        $this->db->where($row, $position);
        $this->db->where('is_active', 1);
        return $this->db->get($table)->result();
    }

    public function get_data_wer_not($table, $row, $position) {
        $this->db->where($row . " !=", $position);
        $this->db->where('is_active', 1);
        return $this->db->get($table)->result();
    }

    public function get_data_wer_wer($table, $row1, $row2, $position1, $position2) {
        $this->db->where($row1, $position1);
        $this->db->where($row2, $position2);
        $this->db->where('is_active', 1);
        return $this->db->get($table)->result();
    }

    public function get_all_asc($table, $order) {
        $this->db->where('is_active', 1);
        $this->db->order_by($order . ' asc');
        return $this->db->get($table)->result();
    }

    public function get_all_dec($table, $order) {
        $this->db->where('is_active', 1);
        $this->db->order_by($order . ' desc');
        return $this->db->get($table)->result();
    }

    public function delete($table, $id) {
        $del = $this->db->delete($table, array('id' => $id));
        if ($del == 1) {
            return 1;
        } else {
            return false;
        }
    }

    public function delete_wer($table, $wer, $id) {
        $del = $this->db->delete($table, array($wer => $id));
        if ($del == 1) {
            return 1;
        } else {
            return false;
        }
    }

    public function get_data_wer_asc($table, $row, $position, $order) {
        $this->db->order_by($order . ' asc');
        $this->db->where('is_active', 1);
        $this->db->where($row, $position);
        return $this->db->get($table)->result();
    }

    public function save($table, $data) {
        $data = array_merge($data, array('created_by' => $this->session->userdata('id'), 'created_at' => date("Y-m-d H:i:s"), 'is_active' => 1));
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update($table, $data, $id) {
        $data = array_merge($data, array('updated_by' => $this->session->userdata('id'), 'updated_at' => date("Y-m-d H:i:s")));
        $this->db->update($table, $data, array('id' => $id));
    }

    public function update_wer($table, $data, $where, $value) {
        $this->db->update($table, $data, array($where => $value));
    }

    public function update_txn($table, $data, $id) {
        $this->db->update($table, $data, array('txn_id' => $id));
    }

    public function get_distinct($table, $order) {
        $this->db->where('is_active', 1);
        $this->db->distinct();
        $this->db->order_by($order . ' asc');
        return $this->db->get($table)->result();
    }

    public function update_account($account_name, $account_data) {
        $result = $this->db->where('account_name', $account_name)->get('account_reg')->result();
        if (!$result) {
            $account_data = array_merge($account_data, array('created_by' => $this->session->userdata('id'), 'created_at' => date("Y-m-d H:i:s"), 'is_active' => 1));
            $this->db->insert('account_reg', $account_data);
        } else {
            $this->db->update('account_reg', $account_data, array('account_name' => $account_name));
        }
    }

    public function get_payment_txn() {
        $where = array('txn_type' => 'payment', 'purchase_id' => 0, 'sale_id' => 0, 'sale_return_id' => 0, 'purchase_return_id' => 0, 'txn_id' => 0, 'is_active' => 1);
        $this->db->where($where);
        return $this->db->get('account_txn')->result();
    }

    public function get_receipt_txn() {
        $where = array('txn_type' => 'receipt', 'purchase_id' => 0, 'sale_id' => 0, 'sale_return_id' => 0, 'purchase_return_id' => 0, 'txn_id' => 0, 'is_active' => 1);
        $this->db->where($where);
        return $this->db->get('account_txn')->result();
    }

    public function delete_txn($table, $id) {
        $del = $this->db->delete($table, array('txn_id' => $id));
        if ($del == 1) {
            return 1;
        } else {
            return false;
        }
    }
    
    public function get_opening_balance($select_date) {
        $this->db->where('from_or_to', 'cash_book');
        $this->db->where('txn_date <',$select_date);
        $this->db->where('txn_type', 'receipt');
        $this->db->select_sum('amount');
        $receipts = $this->db->get('account_txn')->result();
        
        $this->db->where('from_or_to', 'cash_book');
        $this->db->where('txn_date <',$select_date);
        $this->db->where('txn_type', 'payment');
        $this->db->select_sum('amount');
        $payments = $this->db->get('account_txn')->result();
        
        $opening_balance = $receipts[0]->amount-$payments[0]->amount;
        return $opening_balance;
    }
    
    public function get_opening_balance2($select_date) {
        $this->db->where("(account_group != 'Cash In Hand' AND account_group != 'Bank Accounts')");
        //$this->db->where('from_or_to', 'cash_book');
        $this->db->where('txn_date <',$select_date);
        $this->db->where('txn_type', 'receipt');
        $this->db->select_sum('amount');
        $receipts = $this->db->get('account_txn')->result();
        
        $this->db->where("(account_group != 'Cash In Hand' AND account_group != 'Bank Accounts')");
        $this->db->where('txn_date <',$select_date);
        $this->db->where('txn_type', 'payment');
        $this->db->select_sum('amount');
        $payments = $this->db->get('account_txn')->result();
        
        $opening_balance = $receipts[0]->amount-$payments[0]->amount;
        return $opening_balance;
    }
    
    public function get_closing_balance($select_date) {
        $this->db->where('from_or_to', 'cash_book');
        $this->db->where('txn_date <=',$select_date);
        $this->db->where('txn_type', 'receipt');
        $this->db->select_sum('amount');
        $receipts = $this->db->get('account_txn')->result();
        
        $this->db->where('from_or_to', 'cash_book');
        $this->db->where('txn_date <=',$select_date);
        $this->db->where('txn_type', 'payment');
        $this->db->select_sum('amount');
        $payments = $this->db->get('account_txn')->result();
        
        $opening_balance = $receipts[0]->amount-$payments[0]->amount;
        return $opening_balance;
    }
    
    public function get_closing_balance2($select_date) {
        $this->db->where("(account_group != 'Cash In Hand' AND account_group != 'Bank Accounts')");
        //$this->db->where('from_or_to', 'cash_book');
        $this->db->where('txn_date <=',$select_date);
        $this->db->where('txn_type', 'receipt');
        $this->db->select_sum('amount');
        $receipts = $this->db->get('account_txn')->result();
        
        $this->db->where("(account_group != 'Cash In Hand' AND account_group != 'Bank Accounts')");
        $this->db->where('txn_date <=',$select_date);
        $this->db->where('txn_type', 'payment');
        $this->db->select_sum('amount');
        $payments = $this->db->get('account_txn')->result();
        
        $opening_balance = $receipts[0]->amount-$payments[0]->amount;
        return $opening_balance;
    }
    
    public function get_where_or($table, $field, $row, $position1, $position2) {
        //$this->db->where($row, $position);
        $this->db->where("($field != 'Cash In Hand' AND $field != 'Bank Accounts') 
                   AND $row >= '$position1' AND $row <= '$position2'");
        //$this->db->where('firm_id', $this->session->userdata('firm_id'));
        $this->db->where('is_active', 1);
        return $this->db->get($table)->result();
    }
    
    public function get_this_or_that($table, $field, $position1, $position2) {
        //$this->db->where($row, $position);
        $this->db->where("$field = '$position1' OR $field = '$position2'");
        //$this->db->where('firm_id', $this->session->userdata('firm_id'));
        $this->db->where('is_active', 1);
        return $this->db->get($table)->result();
    }
    
    public function get_all_day_book($table, $field) {
        //$this->db->where($row, $position);
        $this->db->where("($field != 'Cash In Hand' AND $field != 'Bank Accounts')");
        //$this->db->where('firm_id', $this->session->userdata('firm_id'));
        $this->db->where('is_active', 1);
        return $this->db->get($table)->result();
    }
    
    public function split($table, $field, $value, $group_by, $price) {
        $this->db->where($field, $value);
        $this->db->where('is_active', 1);
        $this->db->select('SUM(quantity * '.$price.') as '.$price, false);
        $this->db->select_sum('total');
        $this->db->select($group_by);
        //$this->db->select('quantity');
        $this->db->group_by($group_by);
        return $this->db->get($table)->result();
    }
    
    public function get_sum($table, $field, $value, $select_sum) {
        $this->db->where($field, $value);
        $this->db->select_sum($select_sum);
        $results = $this->db->get($table)->result();
        return $results;
    }

}

?>
