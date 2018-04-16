<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Index_ctrlr extends CI_Controller {

    function index() {
    ob_start();
    system('ipconfig /all');
    $mycom=ob_get_contents();
    ob_clean();

    $findme = "Physical";
    $pmac = strpos($mycom, $findme);
    $mac=substr($mycom,($pmac+36),17);
    $troll=round(((hexdec($mac))/19)+9562350055);
    $is_active = $this->general->get_data_wer('firm_reg', 'id', 1);
    if($is_active[0]->troll == $troll && $is_active[0]->icu == $troll+9562350055) {
            $data['title'] = 'Chirippa | Software';
            $data['company_name'] = 'Welcome To Chirippa Software';
            $data['main_content'] = 'index';
            $this->load->view('templates/outside', $data);
} else {
            $data['title'] = 'Chirippa | Software';
            $data['company_name'] = 'Welcome To Chirippa Software';
            $data['troll'] = $troll;
            $data['main_content'] = 'index_troll';
            $this->load->view('templates/outside', $data);
}
        
    }
    
    function validate() {
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $mycom=ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer

        $findme = "Physical";
        $pmac = strpos($mycom, $findme); // Find the position of Physical text
        $mac=substr($mycom,($pmac+36),17); // Get Physical Address
        $troll=round(((hexdec($mac))/19)+9562350055);
        $icu = $this->input->post('secret_key');
        if(($troll+9562350055) == $icu) {
            $update_data = array('troll' => $troll, 'icu' => $icu);
            $this->general->update_wer('firm_reg', $update_data, 'id', 1);
        }
        redirect('/', 'refresh');
    }

    function check_login() {
        $this->load->model('login_mod');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = $this->login_mod->login($username, $password);
        if ($result) {
            foreach ($result as $row) {
                $this->session->set_userdata('id', $row->id);
                $this->session->set_userdata('user_name', $row->user_name);
                $this->session->set_userdata('user_type', $row->user_type);
            }
            redirect('home', 'refresh');
        } else {
            $this->session->set_flashdata('invalid', 'Username / Password Not Matching...!!');
            redirect('/', 'refresh');
        }
    }

    public function home() {
        if (!$this->session->userdata('id')) {
            redirect('/', 'refresh');
        }
        $data['title'] = 'Home';
        $data['company_name'] = $this->general->get_firm();
        $data['main_content'] = 'home';
        $this->load->view('templates/standard', $data);
    }

    public function logout() {
        
        $file_name = 'basico_db_'.date("d-m-y");
        $this->load->dbutil();

        $prefs = array(
            'format' => 'sql',
            'filename' => $file_name
        );


        $backup = & $this->dbutil->backup($prefs);

        $db_name = $file_name.'.sql';
        $save = './database/back_ups/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);
        
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_type');
        $this->session->sess_destroy();
        redirect('/', 'refresh');
    }

}
