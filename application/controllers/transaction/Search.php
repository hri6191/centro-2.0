<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

    public function index() {
        $data = array('Firm' => 'registration/firm',
            'Vendor' => 'registration/vendor',
            'Customer' => 'registration/customer',
            'Inventory' => 'registration/inventory',
            'Sale' => 'transaction/sale',
            'Purchase' => 'transaction/purchase',
            'Receipts' => 'transaction/receipts',
            'Payments' => 'transaction/payments'
        );
        $this->autocomplete_search($data);
    }

    public function item_list() {
        $items = $this->general->get_all_asc('inventory_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->item_name . "(" . $item->item_code . ")"] = $item->id;
        }
        $this->autocomplete_search($data);
    }

    public function real_customer_list() {
        $items = $this->general->get_all_asc('real_customer_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->real_customer_name.'('.$item->phone_no.')'] = $item->id;
        }
        $this->autocomplete_search($data);
    }

    public function vendor_list() {
        $items = $this->general->get_all_asc('vendor_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->vendor_name] = $item->id;
        }
        $this->autocomplete_search($data);
    }

    public function firm_list() {
        $items = $this->general->get_all_asc('firm_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->firm_name] = $item->id;
        }
        $this->autocomplete_search($data);
    }

    public function group_list() {
        $items = $this->general->get_all_asc('group_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->group_name] = $item->id;
        }
        $this->autocomplete_search($data);
    }

    public function brand_list() {
        $items = $this->general->get_all_asc('brand_reg', 'id');
        $data = array();
        foreach ($items as $item) {
            $data[$item->brand_name] = $item->id;
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
