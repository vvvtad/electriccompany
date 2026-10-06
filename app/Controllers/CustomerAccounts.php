<?php

namespace App\Controllers;

use App\Models\CustomerAccountModel;

class CustomerAccounts extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerAccountModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('search');
        $status = $this->request->getGet('status');
        $type = $this->request->getGet('type');

        // Show 10 customers per page
        $perPage = 10;

        if ($keyword) {
            $accounts = $this->customerModel
                ->searchAccounts($keyword, $perPage);
        } elseif ($status) {
            $accounts = $this->customerModel
                ->getAccountsByStatus($status, $perPage);
        } elseif ($type) {
            $accounts = $this->customerModel
                ->getAccountsByType($type, $perPage);
        } else {
            $accounts = $this->customerModel
                ->getAccountsPaginated($perPage);
        }

        $data = [
            'title' => 'Customer Accounts - Puihaha Electric',
            'page' => 'accounts',

            'accounts' => $accounts,
            'pager' => $this->customerModel->pager,

            'total_accounts' =>
                $this->customerModel->getTotalAccounts(),

            'active_accounts' =>
                $this->customerModel->getCountByStatus('active'),

            'inactive_accounts' =>
                $this->customerModel->getCountByStatus('inactive'),

            'suspended_accounts' =>
                $this->customerModel->getCountByStatus('suspended'),

            'current_page' =>
                $this->request->getGet('page') ?? 1,

            'search_keyword' => $keyword,
            'filter_status' => $status,
            'filter_type' => $type
        ];

        return view('customer_accounts', $data);
    }

    public function viewAccount($id)
    {
        $account = $this->customerModel->find($id);

        if (!$account) {
            return redirect()
                ->to('/accounts')
                ->with('error', 'Account not found');
        }

        $data = [
            'title' => 'Account Details - Puihaha Electric',
            'page' => 'accounts',
            'account' => $account
        ];

        return view('customeraccounts', $data);
    }
}