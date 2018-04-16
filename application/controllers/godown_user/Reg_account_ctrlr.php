<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_account_ctrlr extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('/', 'refresh');
        }
    }

    public function index() {
        $data['title'] = 'Account Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['account_groups'] = $this->general->get_all_asc('account_group', 'id');
        $data['main_content'] = 'godown_user/reg_account';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $data = array(
            "account_name" => $this->input->post('account_name'),
            "account_group" => $this->input->post('account_group')
        );
        $this->general->save('account_reg', $data);
        $this->session->set_flashdata('success', 'Account added Successfully...!!');
        redirect('registration/account', 'refresh');
    }

    public function edit_mode() {
        $data['title'] = 'Account Registration';
        $data['company_name'] = $this->general->get_firm();
        $edit_id = $this->input->post('edit_id');
        if ($edit_id == '') {
            redirect('registration/account');
        }
        $data['edit_id'] = $edit_id;
        $data['account_groups'] = $this->general->get_all_asc('account_group', 'id');
        $data['edit_mode'] = $this->general->get_data_wer('account_reg', 'id', $edit_id);
        $data['main_content'] = 'godown_user/reg_account';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $data = array(
            "account_name" => $this->input->post('account_name'),
            "account_group" => $this->input->post('account_group')
        );
        $this->general->update('account_reg', $data, $id);
        $this->session->set_flashdata('success', 'Account updated Successfully...!!');
        redirect('registration/account');
    }
    
    public function delete($id) {
        $this->general->delete('account_reg', $id);
        redirect('registration/account');
    }

}
