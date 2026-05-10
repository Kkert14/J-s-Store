<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LogModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $lockout = 0;
        $expiry  = session()->get('lockout_expiry');

        if ($expiry && time() < $expiry) {
            $lockout = $expiry - time();
        } else {
            session()->remove('lockout_expiry');
            $this->clearFailedAttempts();
        }

        return view('login', ['lockout' => $lockout]);
    }

    public function auth()
    {
        $session  = session();
        $model    = new UserModel();
        $db       = \Config\Database::connect();

        // Get name instead of email
        $name     = trim($this->request->getPost('name'));
        $password = trim($this->request->getPost('password'));
        $ip       = $this->request->getIPAddress();
        $userAgent = $this->request->getUserAgent();

        $maxAttempts = 5;
        $lockoutTime = 3 * 60; // 3 minutes
        $timeWindow  = date('Y-m-d H:i:s', strtotime('-15 minutes'));

        // Count recent failed attempts from this IP
        $builder  = $db->table('login_attempts');
        $attempts = $builder
            ->where('ip_address', $ip)
            ->where('attempt_time >=', $timeWindow)
            ->countAllResults();

        if ($attempts >= $maxAttempts) {
            $lastAttempt = $builder
                ->selectMax('attempt_time')
                ->where('ip_address', $ip)
                ->get()
                ->getRow();

            $lastTime      = strtotime($lastAttempt->attempt_time);
            $lockoutExpiry = $lastTime + $lockoutTime;
            $remaining     = $lockoutExpiry - time();

            if ($remaining > 0) {
                session()->set('lockout_expiry', $lockoutExpiry);
                return redirect()->to('/login');
            }
        }

        // Look up user by name instead of email
        $user = $model->where('name', $name)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Clear failed attempts for this IP on success
            $builder->where('ip_address', $ip)->delete();

            $session->regenerate();
            $session->set([
                'user_id'       => $user['id'],
                'email'         => $user['email'],
                'name'          => $user['name'],
                'role'          => $user['role'],
                'logged_in'     => true,
                'last_activity' => time(),
            ]);

            $logModel = new LogModel();
            $logModel->addLog('Login: ' . $user['name'], 'LOGIN');

            return redirect()->to('/dashboard');
        } else {
            // Log the failed attempt
            $builder->insert([
                'email'        => $name, // storing the entered name in the email column for audit
                'ip_address'   => $ip,
                'user_agent'   => $userAgent,
                'attempt_time' => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/login')->with('error', 'Invalid name or password.');
        }
    }

    public function logout()
    {
        $logModel = new LogModel();
        $logModel->addLog('Logout', 'LOGOUT');

        session()->destroy();
        return redirect()->to('/login');
    }

    private function clearFailedAttempts()
    {
        $db       = \Config\Database::connect();
        $builder  = $db->table('login_attempts');
        $ip       = $this->request->getIPAddress();
        $threshold = date('Y-m-d H:i:s', strtotime('-1 minute'));

        $builder->where('ip_address', $ip)
                ->where('attempt_time <', $threshold)
                ->delete();
    }
}