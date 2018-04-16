<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_customer_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Customer Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'registration/reg_customer';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $data = array(
            "vendor_name" => $this->input->post('customer_name'),
            "address1" => $this->input->post('address1'),
            "address2" => $this->input->post('address2'),
            "pin_code" => $this->input->post('pin_code'),
            "district" => $this->input->post('district'),
            "phone_no" => $this->input->post('phone_no'),
            "email_id" => $this->input->post('email_id'),
            "website" => $this->input->post('website'),
            "pin_no" => $this->input->post('pin_no'),
            "tin_no" => $this->input->post('tin_no'),
            "kgst" => $this->input->post('kgst'),
            "cst" => $this->input->post('cst')
        );
        $this->general->save('vendor_reg', $data);

        $data2 = array(
            "account_name" => $this->input->post('customer_name'),
            "account_group" => 'Sales Accounts'
        );
        $this->general->save('account_reg', $data2);
        redirect('registration/customer');
    }

    public function edit_mode() {
        $data['title'] = 'Customer Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['firms'] = $this->general->get_all_asc('vendor_reg', 'id');
        $edit_id = $this->input->post('edit_id');
        if($edit_id=='') {
                redirect('registration/customer');
            }
        $data['edit_id'] = $edit_id;
        $data['edit_mode'] = $this->general->get_data_wer('vendor_reg', 'id', $edit_id);
        $data['main_content'] = 'registration/reg_customer';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $data = array(
            "vendor_name" => $this->input->post('customer_name'),
            "address1" => $this->input->post('address1'),
            "address2" => $this->input->post('address2'),
            "pin_code" => $this->input->post('pin_code'),
            "district" => $this->input->post('district'),
            "phone_no" => $this->input->post('phone_no'),
            "email_id" => $this->input->post('email_id'),
            "website" => $this->input->post('website'),
            "pin_no" => $this->input->post('pin_no'),
            "tin_no" => $this->input->post('tin_no'),
            "kgst" => $this->input->post('kgst'),
            "cst" => $this->input->post('cst')
        );
        $this->general->update('vendor_reg', $data, $id);
        redirect('registration/customer');
    }

}
