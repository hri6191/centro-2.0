<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acc_ledger_ctrlr extends CI_Controller {

	public function index()
	{
            $data['title'] = 'Ledger Report';
            $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
            $data['account_name'] = $this->input->post('edit_id');
            $data['main_content']='accounts/ledger';
            $this->load->view('templates/standard',$data);
	}
        
        public function select_account()
	{
            $data['title'] = 'Select Ledger';
            $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
            $data['main_content']='accounts/select_ledger';
            $this->load->view('templates/standard',$data);
	}
        
        public function account_data()
	{
            $account_name = $_GET['ac_nm'];
            $account_datas = $this->general->get_data_wer('account_txn', 'account_name', $account_name);
            $i = 1;
            foreach ($account_datas as $account_data)
            {
                
                if($account_data->txn_type == 'receipt') {
                    $credit = $account_data->amount;
                    $debit = '';
                } else {
                    $credit = '';
                    $debit = $account_data->amount;
                }
                $accounts[] = array('SI' => $account_data->id,
                                    'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                    'Account' => $account_data->account_name,
                                    'AccountGroup' => $account_data->account_group,
                                    'Narration' => $account_data->description,
                                    //'VoucherType' => $account_data->txn_type,
                                    'Debit' => $debit,
                                    'Credit' => $credit
                                    );
                $i++;
            }
            echo json_encode($accounts);
	}
        
        public function printing() {
            $txn_date = $this->input->post('txn_dates');
            $account = $this->input->post('accounts');
            $account_group = $this->input->post('account_groups');
            $narration = $this->input->post('narrations');
            $credit = $this->input->post('credits');
            $debit = $this->input->post('debits');
            $credit_sum = $this->input->post('credit_sums');
            $debit_sum = $this->input->post('debit_sums');
            $balance_sum = $this->input->post('balances');
            //PrinT
            $this->load->helper(array('dompdf_a4'));
            // page info here, db calls, etc. 
            $pdf_data = array('txn_date' => $txn_date,
                                'account'	=> $account,
                                'account_group' => $account_group,
                                'narration' => $narration,
                                'credit' => $credit,
                                'debit' => $debit,
                                'credit_sum' => $credit_sum,
                                'debit_sum' => $debit_sum,
                                'balance_sum' => $balance_sum);
            $pdf_data['firm_details'] = $this->general->get_firm($this->session->userdata('firm_id'));
            $html = $this->load->view('print_ledger_pdf', $pdf_data, true);
            //$dompdf->set_option("enable_remote",true);
            $print['Attachment'] = 0;
            pdf_create($html, 'Report', $print);
        }
	      
}