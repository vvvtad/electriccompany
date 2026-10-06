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

    private function isLoggedIn(): bool
    {
        return session()->get('isLogged') === true;
    }

    private function saveAccount(?int $id = null)
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please log in to manage customer accounts.');
        }

        $rules = [
            'account_number' => 'required|max_length[50]',
            'customer_name' => 'required|min_length[2]|max_length[150]',
            'address' => 'required|min_length[5]|max_length[255]',
            'phone' => 'required|min_length[7]|max_length[20]',
            'email' => 'required|valid_email|max_length[255]',
            'meter_number' => 'required|max_length[50]',
            'connection_type' => 'required|in_list[residential,commercial,industrial]',
            'status' => 'required|in_list[active,inactive,suspended]',
        ];

        if (! $this->validate($rules)) {
            session()->setFlashdata('validation', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }

        $data = $this->request->getPost([
            'account_number', 'customer_name', 'address', 'phone', 'email',
            'meter_number', 'connection_type', 'status'
        ]);

        $duplicate = $this->customerModel->where('account_number', $data['account_number']);
        if ($id !== null) {
            $duplicate->where('id !=', $id);
        }
        if ($duplicate->first()) {
            session()->setFlashdata('validation', ['account_number' => 'That account number is already in use.']);
            return redirect()->back()->withInput();
        }

        if ($id === null) {
            $this->customerModel->insert($data);
            $message = 'Customer account created successfully.';
        } else {
            $this->customerModel->update($id, $data);
            $message = 'Customer account updated successfully.';
        }

        return redirect()->to('/accounts')->with('success', $message);
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

        return view('customeraccounts', $data);
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

        return view('viewaccount', $data);
    }

    public function edit($id)
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please log in to edit customer accounts.');
        }

        $account = $this->customerModel->find($id);
        if (! $account) {
            return redirect()->to('/accounts')->with('error', 'Account not found.');
        }

        return view('editaccount', [
            'title' => 'Edit Customer Account - Puihaha Electric',
            'page' => 'accounts',
            'account' => $account,
            'formAction' => base_url('account/update/' . $id),
            'formTitle' => 'Edit Customer Account',
            'validation' => session()->getFlashdata('validation'),
        ]);
    }

    public function update($id)
    {
        return $this->saveAccount($id);
    }

    public function delete($id)
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to('/login')->with('error', 'Please log in to delete customer accounts.');
        }

        if (! $this->customerModel->find($id)) {
            return redirect()->to('/accounts')->with('error', 'Account not found.');
        }

        $this->customerModel->delete($id);
        return redirect()->to('/accounts')->with('success', 'Customer account deleted successfully.');
    }
}