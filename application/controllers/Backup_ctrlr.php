<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Backup_ctrlr extends CI_Controller {

    function index() {
        $file_name = 'basico_db_'.date("d-m-y");
        $this->load->dbutil();

        $prefs = array(
            'format' => 'sql',
            'filename' => $file_name
        );


        $backup = & $this->dbutil->backup($prefs);

        $db_name = $file_name.'.sql';
        $save = '/xampp/htdocs/basico-best/database/back_ups/' . $db_name;

        $this->load->helper('file');
        write_file($save, $backup);
        redirect('logout', 'refresh');
    }

}
