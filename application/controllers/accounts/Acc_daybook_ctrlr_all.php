<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acc_daybook_ctrlr_all extends CI_Controller {

	public function index()
	{
            $data['title'] = 'Daybook Report';
            $data['company_name'] = $this->general->get_firm();
            $data['main_content']='accounts/daybook_all';
            $this->load->view('templates/standard',$data);
	}
        
        public function account_data()
	{
            //$txn_date = $_GET['txn_date'];
            $account_datas = $this->general->get_all_day_book('account_txn', 'account_group');
            $i = 1;
            foreach ($account_datas as $account_data)
            {
                if($account_data->txn_type == 'receipt') {
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
	      
}