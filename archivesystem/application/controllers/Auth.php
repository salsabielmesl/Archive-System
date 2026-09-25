<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Default login page
    public function index()
    {
        // Redirect already logged-in users
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role');
            $this->redirect_by_role($role);
        }

        // Handle login submission
        if ($this->input->post('username')) {
            $this->login_process();
            return;
        }

        // Load login view
        $this->load->view('auth/login');
    }

    // Separate login processing method
    public function login_process()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        $user = $this->Auth_model->login($username, $password);

        if ($user) {
            // Set session
            $this->session->set_userdata([
                'logged_in' => true,
                'user_id'   => $user->id,
                'username'  => $user->username,
                'role'      => $user->role
            ]);

            // Redirect to attempted page if stored by PermissionCheck hook
            if ($this->session->userdata('redirect_url')) {
                $redirect = $this->session->userdata('redirect_url');
                $this->session->unset_userdata('redirect_url');
                redirect($redirect);
            }

            // Otherwise, redirect by role
            $this->redirect_by_role($user->role);

        } else {
            $this->session->set_flashdata('error', 'Invalid credentials');
            redirect('auth/index');
        }
    }

    // Redirect users based on role
    private function redirect_by_role($role)
    {
        switch ($role) {
            case 'web':
                redirect('customers');   // web users go to web dashboard/customers page
                break;
            case 'mobile':
                redirect('mobile');      // mobile users go to mobile dashboard
                break;
            default:
                show_error('Unauthorized role', 403);
        }
    }

    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/index');
    }
}
