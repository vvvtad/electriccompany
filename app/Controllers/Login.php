<?php

namespace App\Controllers;

use App\Models\User;

class Login extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    
    public function index()
    {
        if (session()->get('isLogged') === true) {
            return redirect()->to('/accounts');
        }

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'username' => 'required|max_length[100]',
                'password' => 'required|max_length[255]',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', 'Enter both your username and password.');
            }

            $credentials = $this->request->getPost(['username', 'password']);
            $user = $this->userModel->where('username', $credentials['username'])->first();

            // New accounts should store passwords with password_hash(). The second
            // condition keeps existing classroom databases with plaintext passwords working.
            $validPassword = $user !== null
                && (password_verify($credentials['password'], $user['password'])
                    || hash_equals((string) $user['password'], (string) $credentials['password']));

            if (! $validPassword) {
                return redirect()->back()->withInput()->with('error', 'Invalid username or password.');
            }

            session()->regenerate();
            session()->set([
                'isLogged' => true,
                'user_id'  => $user['id'],
                'username' => $user['username'],
            ]);

            return redirect()->to('/accounts');
        }

        return view('login');
    }

    public function authenticate()
    {
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()
                ->to('/login')
                ->withInput()
                ->with('error', 'Please enter your email and password.');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return redirect()
                ->to('/login')
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        if (!$user['is_active']) {
            return redirect()
                ->to('/login')
                ->with('error', 'Your account is inactive.');
        }

        if (!$this->userModel->verifyPassword(
            $password,
            $user['password']
        )) {
            return redirect()
                ->to('/login')
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        // Prevent session fixation after successful login
        session()->regenerate(true);

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['first_name'] . ' ' . $user['last_name'],
            'user_type' => $user['user_type'],
            'isLogged' => true,
        ]);

        return redirect()->to('/accounts');
    }

    public function logout()
    {
        if (session()->get('isLogged') !== true) {
            return redirect()->to('/login');
        }

        session()->destroy();
        return redirect()->to('/login')->with('success', 'You have been logged out.');
    }
}