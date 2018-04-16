<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reports_tax_ctrlr extends CI_Controller {

    public function index() {
        $data['title'] = 'Tax Report';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['select_date1'] = date("Y-m-d", strtotime($this->input->post('select_date1')));
        $data['select_date2'] = date("Y-m-d", strtotime($this->input->post('select_date2')));
        $data['opening_balance'] = $this->general->get_opening_balance2($data['select_date1']);
        $data['closing_balance'] = $this->general->get_closing_balance2($data['select_date2']);
        $data['main_content'] = 'godown_user/reports_tax';
        $this->load->view('templates/standard', $data);
    }

    public function select_date() {
        $data['title'] = 'Tax Report - Select Date';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['main_content'] = 'godown_user/reports_select_tax';
        $this->load->view('templates/standard', $data);
    }

    public function tax_data() {
        $txn_date1 = $_GET['txn_date1'];
        $txn_date2 = $_GET['txn_date2'];
        $account_datas = $this->general->get_where_or('account_txn', 'account_group', 'txn_date', $txn_date1, $txn_date2);
        //$i = 1;
        foreach ($account_datas as $account_data) {
            if ($account_data->txn_type == 'receipt') {
                $debit = $account_data->amount;
                $credit = '';
            } else {
                $debit = '';
                $credit = $account_data->amount;
            }
            if ($account_data->txn_id == -1) {
                if ($account_data->account_name == 'Purchase') {
                    $purchase_type = $this->general->get_data_wer('purchase', 'id', $account_data->purchase_id);
                    $split_datas = $this->general->split('purchased_inventory', 'purchase_id', $account_data->purchase_id, 'purchase_tax', 'purchase_price');
                    if ($purchase_type[0]->purchase_type == 1) {
                        foreach ($split_datas as $split_data) {
                            $account_name1 = 'Purchase at ' . $split_data->purchase_tax / 2 . '% - Taxable';
                            $account_name2 = 'Input Tax Paid CGST ' . $split_data->purchase_tax / 2 . '%';
                            $account_name3 = 'Input Tax Paid SGST ' . $split_data->purchase_tax / 2 . '%';
                            $credit1 = $split_data->purchase_price;
                            $credit2 = ($split_data->total - $split_data->purchase_price) / 2;
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name1,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit1
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name2,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit2
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name3,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit2
                            );
                        }
                    } else if($purchase_type[0]->purchase_type == 2) {
                        foreach ($split_datas as $split_data) {
                            $account_name1 = 'Purchase at ' . $split_data->purchase_tax . '% - Taxable';
                            $account_name2 = 'Input Tax Paid IGST ' . $split_data->purchase_tax . '%';
                            $credit1 = $split_data->purchase_price;
                            $credit2 = $split_data->total - $split_data->purchase_price;
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name1,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit1
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name2,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit2
                            );
                        }
                    } else if($purchase_type[0]->purchase_type == 4) {
                        foreach ($split_datas as $split_data) {
                            $account_name1 = 'Payment at ' . $split_data->purchase_tax / 2 . '% - Taxable';
                            $account_name2 = 'Input Tax Paid CGST ' . $split_data->purchase_tax / 2 . '%';
                            $account_name3 = 'Input Tax Paid SGST ' . $split_data->purchase_tax / 2 . '%';
                            $credit1 = $split_data->purchase_price;
                            $credit2 = ($split_data->total - $split_data->purchase_price) / 2;
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name1,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit1
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name2,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit2
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name3,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit,
                                'Credit' => $credit2
                            );
                        }
                    }
                } else if ($account_data->account_name == 'Purchase Return') {
                    $split_datas = $this->general->split('purchased_return_inventory', 'purchase_id', $account_data->purchase_return_id, 'purchase_tax', 'purchase_price');
                    foreach ($split_datas as $split_data) {
                        $account_data->account_name = 'Purchase Return at ' . $split_data->purchase_tax . '%';
                        $debit = $split_data->total;
                        $accounts[] = array('SI' => $account_data->id,
                            'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                            'Account' => $account_data->account_name,
                            'Narration' => $account_data->description,
                            'VoucherType' => $account_data->txn_type,
                            'Debit' => $debit,
                            'Credit' => $credit
                        );
                    }
                } else if ($account_data->account_name == 'Sale') {
                    $sale_type = $this->general->get_data_wer('sale', 'id', $account_data->sale_id);
                    $split_datas = $this->general->split('sold_inventory', 'sale_id', $account_data->sale_id, 'sale_tax', 'sale_price');
                    if ($sale_type[0]->sale_type != 3) {
                        foreach ($split_datas as $split_data) {
                            $account_name1 = 'Sale at ' . $split_data->sale_tax / 2 . '% - Taxable';
                            $account_name2 = 'Output Tax Collected CGST ' . $split_data->sale_tax / 2 . '%';
                            $account_name3 = 'Output Tax Collected SGST ' . $split_data->sale_tax / 2 . '%';
                            $debit1 = $split_data->sale_price;
                            $debit2 = ($split_data->total - $split_data->sale_price) / 2;
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name1,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit1,
                                'Credit' => $credit
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name2,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit2,
                                'Credit' => $credit
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name3,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit2,
                                'Credit' => $credit
                            );
                        }
                    } else {
                        foreach ($split_datas as $split_data) {
                            $account_name1 = 'Sale at ' . $split_data->sale_tax . '% - Taxable';
                            $account_name2 = 'Output Tax Collected IGST ' . $split_data->sale_tax . '%';
                            $debit1 = $split_data->sale_price;
                            $debit2 = $split_data->total - $split_data->sale_price;
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name1,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit1,
                                'Credit' => $credit
                            );
                            $accounts[] = array('SI' => $account_data->id,
                                'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                                'Account' => $account_name2,
                                'Narration' => $account_data->description,
                                'VoucherType' => $account_data->txn_type,
                                'Debit' => $debit2,
                                'Credit' => $credit
                            );
                        }
                    }
                } else if ($account_data->account_name == 'Sales Return') {
                    $split_datas = $this->general->split('sold_return_inventory', 'sale_id', $account_data->sale_return_id, 'sale_tax', 'sale_price');
                    foreach ($split_datas as $split_data) {
                        $account_data->account_name = 'Sale Return at ' . $split_data->sale_tax / 2 . '%';
                        $credit = $split_data->total;
                        $accounts[] = array('SI' => $account_data->id,
                            'Date' => date('d-m-Y', strtotime($account_data->txn_date)),
                            'Account' => $account_data->account_name,
                            'Narration' => $account_data->description,
                            'VoucherType' => $account_data->txn_type,
                            'Debit' => $debit,
                            'Credit' => $credit
                        );
                    }
                }
            }
        }
        echo json_encode($accounts);
    }

    public function gst() {
        $data['title'] = 'GST Report';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['select_date1'] = date("Y-m-d", strtotime($this->input->post('select_date1')));
        $data['select_date2'] = date("Y-m-d", strtotime($this->input->post('select_date2')));
        $data['main_content'] = 'godown_user/reports_gst';
        $this->load->view('templates/standard', $data);
    }

    public function select_gst() {
        $data['title'] = 'GST Report - Select Date';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['main_content'] = 'godown_user/reports_select_gst';
        $this->load->view('templates/standard', $data);
    }

    public function gst_data() {
        $txn_date1 = $_GET['txn_date1'];
        $txn_date2 = $_GET['txn_date2'];
        $this->load->model('gst_mod');
        $split_datas = $this->gst_mod->split('sale_date', $txn_date1, $txn_date2);
        $i = 0;
        foreach ($split_datas as $split_data) {
            if ($split_data->sale_type != 3) { $i++;
                $inventory = $this->general->get_data_wer('inventory_reg', 'id', $split_data->inventory_id);
                $debit2 = ($split_data->total - $split_data->sale_price) / 2;
                $accounts[] = array('num' => $i,
                    'hsn_sc' => $inventory[0]->hsn,
                    'desc' => '', //'desc' => $inventory[0]->item_name,
                    'uqc' => $split_data->unit,
                    'qty' => $split_data->quantity,
                    'val' => number_format((float) $split_data->total, 2, '.', ''),
                    'txval' => number_format((float) $split_data->sale_price, 2, '.', ''),
                    'iamt' => 0,
                    'camt' => number_format((float) $debit2, 2, '.', ''),
                    'samt' => number_format((float) $debit2, 2, '.', ''),
                    'csamt' => 0
                );
            } else { $i++;
                $inventory = $this->general->get_data_wer('inventory_reg', 'id', $split_data->inventory_id);
                $debit2 = $split_data->total - $split_data->sale_price;
                $accounts[] = array('num' => $i,
                    'hsn_sc' => $inventory[0]->hsn,
                    'desc' => $inventory[0]->item_name,
                    'uqc' => $split_data->unit,
                    'qty' => $split_data->quantity,
                    'val' => $split_data->total,
                    'txval' => $split_data->sale_price,
                    'iamt' => $debit2,
                    'camt' => 0,
                    'samt' => 0,
                    'csamt' => 0
                );
            }
        }
        echo json_encode($accounts);
    }

    public function gst1() {
        $data['title'] = 'GST Report';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['select_date1'] = date("Y-m-d", strtotime($this->input->post('select_date1')));
        $data['select_date2'] = date("Y-m-d", strtotime($this->input->post('select_date2')));
        $data['main_content'] = 'godown_user/reports_gst1';
        $this->load->view('templates/standard', $data);
    }

    public function select_gst1() {
        $data['title'] = 'GST Report - Select Date';
        $data['company_name'] = $this->general->get_firm($this->session->userdata('firm_id'));
        $data['main_content'] = 'godown_user/reports_select_gst1';
        $this->load->view('templates/standard', $data);
    }

    public function gst_data1() {
        $txn_date1 = $_GET['txn_date1'];
        $txn_date2 = $_GET['txn_date2'];
        $this->load->model('gst_mod');
        $account_datas = $this->gst_mod->get_gst('sale_date', $txn_date1, $txn_date2);
        //$i = 1;
        foreach ($account_datas as $account_data) {
                            $debit2 = ($account_data->total - $account_data->sale_price) / 2;
                            $accounts[] = array('sply_ty' => 'INTRA',
                                'rt' => $account_data->sale_tax,
                                'typ' => 'OE',
                                'pos' => 32,
                                'txval' => number_format((float) $account_data->sale_price, 2, '.', ''),
                                'iamt' => 0,
                                'csamt' => 0,
                                'camt' => number_format((float) $debit2, 2, '.', ''),
                                'samt' => number_format((float) $debit2, 2, '.', '')
                            );
        }
        echo json_encode($accounts);
    }

}
