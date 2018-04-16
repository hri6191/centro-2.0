<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reg_firm_ctrlr extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            $data['title'] = 'Chiripa | ERP';
            $data['company_name'] = 'The Company';
            $data['edit_id']='';
            $data['main_content']='registration/reg_firm';
            $this->load->view('templates/standard',$data);
	}
        
        public function add()
	{
            $data = array(
                            "firm_name" => $this->input->post('firm_name'),
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
            $this->general->save('firm_reg', $data);
            redirect('registration/firm');
	}
        
        public function edit_mode()
	{
            $data['title'] = 'Chiripa | ERP';
            $data['company_name'] = 'The Company';
            $edit_id = $this->input->post('edit_id');
            $data['edit_id'] = $edit_id;
            $data['edit_mode'] = $this->general->get_data_wer('firm_reg', 'id', $edit_id);
            $data['main_content']='registration/reg_firm';
            $this->load->view('templates/standard',$data);
	}
        
        public function edit()
	{
            $id = $this->input->post('id');
            $data = array(
                            "firm_name" => $this->input->post('firm_name'),
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
            $this->general->update('firm_reg', $data, $id);
            redirect('registration/firm');
	}
        
        public function pdf()
        {
            $this->load->helper(array('dompdf'));
            // page info here, db calls, etc. 
            $data['']='';
            $html = $this->load->view('print_pdf_old', $data, true);
            $print['Attachment'] = 0;
            pdf_create($html, 'haii', $print);
            //or
            //$data = pdf_create($html, '', false);
            //write_file('name', $data);
            //if you want to write it to disk and/or send it as an attachment
        }
	      
}