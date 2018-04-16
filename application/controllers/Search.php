<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function index() {
        $data = array('Firm' => 'registration/firm',
            'Vendor' => 'registration/vendor',
            'Customer' => 'registration/project',
            'Inventory' => 'registration/inventory',
            'Sale' => 'transaction/sale',
            'Purchase' => 'transaction/purchase',
            'Receipts' => 'transaction/receipts',
            'Payments' => 'transaction/payments'
        );
        $this->autocomplete_search($data);
    }
    
    public function user_list() {
        $items = $this->general->get_all_asc('user_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->user_name] = $item->id;
        }
        $this->autocomplete_search($data);
    }
    
    public function account_list() {
        $items = $this->general->get_all_asc('account_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->account_name] = $item->id;
        }
        $this->autocomplete_search($data);
    }
    
    public function account_list_from_or_to() {
        $items = $this->general->get_data_wer('account_reg', 'account_group', 'Bank Accounts');
        $data = array();
        foreach ($items as $item) {
            $data['cash_book'] = 0;
            $data[$item->account_name] = $item->id;
        }
        $this->autocomplete_search($data);
    }
    
    public function account_payment_list() {
        $items = $this->general->get_payment_txn();
        $data = array();
        foreach ($items as $item) {
            $data[$item->account_name . "(" . $item->txn_date . ", ".$item->id.")"] = $item->id;
        }
        $this->autocomplete_search($data);
    }
    
    public function account_receipt_list() {
        $items = $this->general->get_receipt_txn();
        $data = array();
        foreach ($items as $item) {
            $data[$item->account_name . "(" . $item->txn_date . ", ".$item->id.")"] = $item->id;
        }
        $this->autocomplete_search($data);
    }

    function autocomplete_search($data) {
        $results = array();
        if (isset($_GET['q'])) {
            $q = strtolower($_GET['q']);
            if ($q) {
                foreach ($data as $key => $value) {
                    if (strpos(strtolower($key), $q) !== false) {
                        $results[] = array($key, $value);
                    }
                }
            }
        }
        $output = 'autocomplete';
        if (isset($_GET['output'])) {
            $output = strtolower($_GET['output']);
        }
        if ($output === 'json') {
            echo json_encode($results);
        }
    }

}
