<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Trans_receipts_ctrlr extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('/', 'refresh');
        }
    }

    public function index() {
        $data['title'] = 'Receipt';
        $data['company_name'] = $this->general->get_firm();
        $data['account_groups'] = $this->general->get_all_asc('account_group', 'id');
        $data['main_content'] = 'godown_user/trans_receipts';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $description = $this->input->post('description');
        $amount = $this->input->post('amount');
        $account_name = $this->input->post('account_name');
        $account_group = $this->input->post('account_group');
        $txn_date = $this->input->post('payment_date');
        
        $account_data = array('account_name' => $account_name, 'account_group' => $account_group);
        $this->general->update_account($account_name, $account_data);
        
            $data = array(
                'account_name' => $account_name,
                'account_group' => $account_group,
                'amount' => $amount,
                'description' => $description,
                'txn_date' => $txn_date,
                'txn_type' => 'receipt',
                'from_or_to' => $this->input->post('from_account_name')
            );
            $txn_id = $this->general->save('account_txn', $data);
            
            if($this->input->post('from_account_name') == 'cash_book') {
                $data = array(
                'account_name' => $this->input->post('from_account_name'),
                'account_group' => 'Cash In Hand',
                'amount' => $amount,
                'description' => $description,
                'txn_date' => $txn_date,
                'txn_type' => 'payment',
                'from_or_to' => $account_name,
                'txn_id' => $txn_id
            );
            $this->general->save('account_txn', $data);
            }
            
            if($this->input->post('from_account_name') != 'cash_book') {
                $data = array(
                'account_name' => $this->input->post('from_account_name'),
                'account_group' => 'Bank Accounts',
                'amount' => $amount,
                'description' => $description,
                'txn_date' => $txn_date,
                'txn_type' => 'payment',
                'from_or_to' => $account_name,
                'txn_id' => $txn_id
            );
            $this->general->save('account_txn', $data);
            }
        redirect('transaction/receipts', 'refresh');
    }

    public function edit_mode() {
        $data['title'] = 'Receipt Edit';
        $data['company_name'] = $this->general->get_firm();
        $data['account_groups'] = $this->general->get_all_asc('account_group', 'id');
        $edit_id = $this->input->post('edit_id');
        if($edit_id == '') {
            redirect('transaction/receipts', 'refresh');
        }
        $data['edit_id'] = $edit_id;
        $data['edit_mode'] = $this->general->get_data_wer('account_txn', 'id', $edit_id);
        $data['main_content'] = 'godown_user/trans_receipts';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $description = $this->input->post('description');
        $amount = $this->input->post('amount');
        $account_name = $this->input->post('account_name');
        $account_group = $this->input->post('account_group');
        $txn_date = $this->input->post('payment_date');
        $data = array(
                'account_name' => $account_name,
                'account_group' => $account_group,
                'amount' => $amount,
                'description' => $description,
                'txn_date' => $txn_date,
                'txn_type' => 'receipt',
                'from_or_to' => $this->input->post('from_account_name')
            );
        $this->general->update('account_txn', $data, $id);
        
        if($this->input->post('from_account_name') == 'cash_book') {
            $data = array(
            'account_name' => $this->input->post('from_account_name'),
            'account_group' => 'Cash In Hand',
            'amount' => $amount,
            'description' => $description,
            'txn_date' => $txn_date,
            'txn_type' => 'payment',
            'from_or_to' => $account_name
        );
        $this->general->update_txn('account_txn', $data, $id);
        }

        if($this->input->post('from_account_name') != 'cash_book') {
            $data = array(
            'account_name' => $this->input->post('from_account_name'),
            'account_group' => 'Bank Accounts',
            'amount' => $amount,
            'description' => $description,
            'txn_date' => $txn_date,
            'txn_type' => 'payment',
            'from_or_to' => $account_name
        );
        $this->general->update_txn('account_txn', $data, $id);
        }
        redirect('transaction/receipts', 'refresh');
    }
    
    public function delete($id) {
        $this->general->delete('account_txn', $id);
        $this->general->delete_txn('account_txn', $id);
        redirect('transaction/receipts', 'refresh');
    }

}
