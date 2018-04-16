<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Acc_cashbook_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Cashbook Report';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['select_date'] = date("Y-m-d", strtotime($this->input->post('select_date')));
        $data['opening_balance'] = $this->general->get_opening_balance($data['select_date']);
        $data['closing_balance'] = $this->general->get_closing_balance($data['select_date']);
        $data['main_content'] = 'accounts/cashbook';
        $this->load->view('templates/standard', $data);
    }

    public function select_date() {
        $data['title'] = 'Cash Book - Select Date';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['main_content'] = 'accounts/select_cash_book';
        $this->load->view('templates/standard', $data);
    }

    public function account_data() {
        $txn_date = $_GET['txn_date'];
        $account_datas = $this->general->get_data_wer_wer('account_txn', 'from_or_to', 'txn_date', 'cash_book', $txn_date);
        $i = 1;
        foreach ($account_datas as $account_data) {
            if ($account_data->txn_type == 'receipt') {
                $debit = $account_data->amount;
                $credit = '';
            } else {
                $debit = '';
                $credit = $account_data->amount;
            }
            $accounts[] = array('SI' => $account_data->id,
                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                'Account' => $account_data->account_name,
                'Narration' => $account_data->description,
                'VoucherType' => $account_data->txn_type,
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
                                'narration' => $narration,
                                'credit' => $credit,
                                'debit' => $debit,
                                'credit_sum' => $credit_sum,
                                'debit_sum' => $debit_sum,
                                'balance_sum' => $balance_sum,
                                'opening_balance' => $this->input->post('opening_bal'),
                                'closing_balance' => $this->input->post('closing_bal'),
                                'select_date' => $this->input->post('select_date'));
            $pdf_data['firm_details'] = $this->general->get_firm($this->session->userdata('firm_id'));
            $html = $this->load->view('print_cashbook_pdf', $pdf_data, true);
            //$dompdf->set_option("enable_remote",true);
            $print['Attachment'] = 0;
            pdf_create($html, 'Report', $print);
        }

}
