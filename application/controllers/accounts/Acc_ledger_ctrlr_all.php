<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acc_ledger_ctrlr_all extends CI_Controller {

	public function index()
	{
            $data['title'] = 'Ledger Report';
            $data['company_name'] = $this->general->get_firm();
            $data['main_content']='accounts/ledger_all';
            $this->load->view('templates/standard',$data);
	}
        
        public function account_data()
	{
            $account_datas = $this->general->get_all_dec('account_txn', 'txn_date');
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
                                    'Date' => $account_data->txn_date,
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
        
        public function single_project($project_id)
	{
            $data['title'] = 'Project Report | BOCE';
            $data['company_name'] = $this->general->get_firm();
            $project_details = $this->general->get_data_wer('project_reg', 'id', $project_id);
            $data['project_id'] = $project_details[0]->id;
            $data['project_name'] = $project_details[0]->name;
            $data['area'] = $project_details[0]->area;
            $data['height_of_floor'] = $project_details[0]->height_of_floor;
            $data['location'] = $project_details[0]->location;
            $data['date_started'] = $project_details[0]->date_started;
            $data['total'] = $project_details[0]->total;
            $data['main_content']='reports/reports_project_single';
            $this->load->view('templates/standard',$data);
	}
        
        public function single_project_data()
	{
            $project_id = $this->input->get('project_id');
            $single_projects = $this->general->get_data_wer('project_details', 'project_id', $project_id);
            foreach ($single_projects as $single_project)
            {
                $projects[] = array('ActivityName' => $single_project->activity_name,
                                    'Rate' => $single_project->activity_rate,
                                    'Labour' => $single_project->labour_rate,
                                    'Quantity' => $single_project->activity_quantity,
                                    'TotalRate' => $single_project->activity_amount,
                                    'TotalLabour' => $single_project->labour_amount,
                                    'TotalAmount' => $single_project->total_amount
                                    );
            }
            echo json_encode($projects);
	}
        
        public function single_labour_project_data()
	{
            $project_id = $this->input->get('project_id');
            $single_projects = $this->general->get_data_wer('project_labour', 'project_id', $project_id);
            foreach ($single_projects as $single_project)
            {
                $projects[] = array('ActivityName' => $single_project->activity_name,
                                    'LabourCharge' => $single_project->labour_charge,
                                    'Days' => $single_project->days,
                                    'TotalLabourCharge' => $single_project->labour_charge*$single_project->days
                                    );
            }
            echo json_encode($projects);
	}
	      
}