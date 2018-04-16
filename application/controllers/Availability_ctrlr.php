<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Availability_ctrlr extends CI_Controller {

    public function customer_availability() {
        $customer_name = $this->input->post('customer_name');

        if (isset($customer_name)) {
            $customer = $this->general->get_data_wer('vendor_reg', 'vendor_name', $customer_name);
            if (sizeof($customer)) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
    
    public function item_code_availability() {
        $item_code = $this->input->post('item_code');

        if (isset($item_code)) {
            $item = $this->general->get_data_wer('inventory_reg', 'item_code', $item_code);
            if (sizeof($item)) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
    
    public function item_name_availability() {
        $item_name = $this->input->post('item_name');

        if (isset($item_name)) {
            $item = $this->general->get_data_wer('inventory_reg', 'item_name', $item_name);
            if (sizeof($item)) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }
    
    public function account_name_availability() {
        $account_name = $this->input->post('account_name');

        if (isset($account_name)) {
            $account = $this->general->get_data_wer('account_reg', 'account_name', $account_name);
            if (sizeof($account)) {
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

}
