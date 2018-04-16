<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_vendor_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Vendor Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'godown_user/reg_vendor';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $data = array(
            "vendor_name" => $this->input->post('vendor_name'),
            "address1" => $this->input->post('address1'),
            "address2" => $this->input->post('address2'),
            "pin_code" => $this->input->post('pin_code'),
            "district" => $this->input->post('district'),
            "phone_no" => $this->input->post('phone_no'),
            "email_id" => $this->input->post('email_id'),
            "website" => $this->input->post('website'),
            //"pin_no" => $this->input->post('pin_no'),
            //"tin_no" => $this->input->post('tin_no'),
            "kgst" => $this->input->post('kgst'),
            //"cst" => $this->input->post('cst')
        );
        $this->general->save('vendor_reg', $data);

        $data2 = array(
            "account_name" => $this->input->post('vendor_name'),
            "account_group" => 'Purchase Account'
        );
        $this->general->save('account_reg', $data2);
        redirect('registration/vendor');
    }

    public function edit_mode() {
        if ($this->input->post('edit_id') == '') {
            redirect('registration/vendor');
        }
        $data['title'] = 'Vendor Registartion';
        $data['company_name'] = $this->general->get_firm();
        $data['firms'] = $this->general->get_all_asc('vendor_reg', 'id');
        $edit_id = $this->input->post('edit_id');
        $data['edit_id'] = $edit_id;
        $data['edit_mode'] = $this->general->get_data_wer('vendor_reg', 'id', $edit_id);
        $data['main_content'] = 'godown_user/reg_vendor';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $data = array(
            "vendor_name" => $this->input->post('vendor_name'),
            "address1" => $this->input->post('address1'),
            "address2" => $this->input->post('address2'),
            "pin_code" => $this->input->post('pin_code'),
            "district" => $this->input->post('district'),
            "phone_no" => $this->input->post('phone_no'),
            "email_id" => $this->input->post('email_id'),
            "website" => $this->input->post('website'),
            //"pin_no" => $this->input->post('pin_no'),
            //"tin_no" => $this->input->post('tin_no'),
            "kgst" => $this->input->post('kgst'),
            //"cst" => $this->input->post('cst')
        );
        $this->general->update('vendor_reg', $data, $id);
        
        $new_customer = $this->input->post('vendor_name');
        $old_customer = $this->input->post('old_vendor_name');
        $update_account_info1 = array('account_name' => $new_customer);
        $update_account_info2 = array('from_or_to' => $new_customer);
        $this->general->update_wer('account_reg', $update_account_info1, 'account_name', $old_customer);
        $this->general->update_wer('account_txn', $update_account_info1, 'account_name', $old_customer);
        $this->general->update_wer('account_txn', $update_account_info2, 'from_or_to', $old_customer);
        
        redirect('registration/vendor');
    }

    public function db() {
        // Load the DB utility class
        $this->load->dbutil();

// Backup your entire database and assign it to a variable
        $backup = & $this->dbutil->backup();

// Load the file helper and write the file to your server
        $this->load->helper('file');
        write_file('/mybackup.gz', $backup);

// Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('mybackup.gz', $backup);
    }

}
