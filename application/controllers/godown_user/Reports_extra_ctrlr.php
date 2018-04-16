<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_extra_ctrlr extends CI_Controller {

    public function index() {
        $fp = $this->input->post('fp');
        $gt = $this->input->post('gt');
        $cur_gt = $this->input->post('cur_gt');
        $file_data = '{"gstin":"32AQQPS6204G1ZR","fp":"' . $fp . '","gt":' . $gt . ',"cur_gt":' . $cur_gt . ',"version":"GST2.2","hash":"hash","hsn":{"data":';
        $file_data .= file_get_contents($_FILES['json_file']['tmp_name']);
        $file_data = $file_data . '}}';
        $file_data = str_replace('"qty":"', '"qty":', $file_data);
        $file_data = str_replace('"qty":"', '"qty":', $file_data);
        $file_data = str_replace('","val":"', ',"val":', $file_data);
        $file_data = str_replace('","txval":"', ',"txval":', $file_data);
        $file_data = str_replace('","iamt"', ',"iamt"', $file_data);
        $file_data = str_replace('"camt":"', '"camt":', $file_data);
        $file_data = str_replace('","samt":"', ',"samt":', $file_data);
        $file_data = str_replace('","csamt"', ',"csamt"', $file_data);
        $this->load->helper('download');
        force_download('hsn_' . $fp . '.json', $file_data);
    }

    public function b2c() {
        $fp = $this->input->post('fp');
        $gt = $this->input->post('gt');
        $cur_gt = $this->input->post('cur_gt');
        $file_data = '{"gstin":"32AQQPS6204G1ZR","fp":"' . $fp . '","gt":' . $gt . ',"cur_gt":' . $cur_gt . ',"version":"GST1.2.1","hash":"hash","b2cs":';
        $file_data .= file_get_contents($_FILES['json_file']['tmp_name']);
        $file_data = $file_data . '}';
        $file_data = str_replace('"rt":"', '"rt":', $file_data);
        $file_data = str_replace('","typ"', ',"typ"', $file_data);
        $file_data = str_replace('"},{', '},{', $file_data);
        $file_data = str_replace('"}]}', '}]}', $file_data);
        $file_data = str_replace('"pos":32', '"pos":"32"', $file_data);
        $file_data = str_replace(',"txval":"', ',"txval":', $file_data);
        $file_data = str_replace('","iamt"', ',"iamt"', $file_data);
        $file_data = str_replace('"camt":"', '"camt":', $file_data);
        $file_data = str_replace('","samt":"', ',"samt":', $file_data);
        $file_data = str_replace('","csamt"', ',"csamt"', $file_data);
        $this->load->helper('download');
        force_download('b2c_' . $fp . '.json', $file_data);
    }

}
