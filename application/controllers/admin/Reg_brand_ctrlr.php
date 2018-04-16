<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reg_brand_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Item Brand Registration';
        $data['company_name'] = $this->general->get_firm();
        $data['edit_id'] = '';
        $data['main_content'] = 'registration/reg_brand';
        $this->load->view('templates/standard', $data);
    }

    public function add() {
        $data = array(
            "brand_name" => $this->input->post('brand_name')
        );
        $this->general->save('brand_reg', $data);
        redirect('registration/brand');
    }

    public function edit_mode() {
        $data['title'] = 'Item Brand Registration';
        $data['company_name'] = $this->general->get_firm();
        $edit_id = $this->input->post('edit_id');
        if ($edit_id == '') {
            redirect('registration/brand');
        }
        $data['edit_id'] = $edit_id;
        $data['edit_mode'] = $this->general->get_data_wer('brand_reg', 'id', $edit_id);
        $data['main_content'] = 'registration/reg_brand';
        $this->load->view('templates/standard', $data);
    }

    public function edit() {
        $id = $this->input->post('id');
        $data = array(
            "brand_name" => $this->input->post('brand_name')
        );
        $this->general->update('brand_reg', $data, $id);
        redirect('registration/brand');
    }

}
