<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_group_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Item Group Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['edit_id'] = '';
        $data['main_content'] = 'registration/reg_group';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $data = array(
            "group_name" => $this->input->post('group_name')
        );
        $this->general->save('group_reg', $data);
        redirect('registration/group');
    }

    public function edit_mode() {
        $data['title'] = 'Item Group Registration';
        $data['company_name'] = $this->general->get_firm();
        $edit_id = $this->input->post('edit_id');
        if ($edit_id == '') {
            redirect('registration/group');
        }
        $data['edit_id'] = $edit_id;
        $data['edit_mode'] = $this->general->get_data_wer('group_reg', 'id', $edit_id);
        $data['main_content'] = 'registration/reg_group';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $data = array(
            "group_name" => $this->input->post('group_name')
        );
        $this->general->update('group_reg', $data, $id);
        redirect('registration/group');
    }

}
