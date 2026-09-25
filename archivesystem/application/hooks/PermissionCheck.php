<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PermissionCheck
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function check_permission()
    {
        $controller = strtolower($this->CI->router->fetch_class());
        $method     = strtolower($this->CI->router->fetch_method());

        // Skip Auth controller (login/logout)
        if ($controller === 'auth') {
            return;
        }

        // If not logged in, redirect to login and save current URL
        if (!$this->CI->session->userdata('logged_in')) {
            $current_url = current_url();
            $this->CI->session->set_userdata('redirect_url', $current_url);
            redirect('auth/index');
        }

        // Get user role from session
        $role = $this->CI->session->userdata('role');

        // Role-based controller access
        if ($role === 'web') {
            // Web users can access only 'customers' and 'web'
            if (!in_array($controller, ['customers', 'web'])) {
                $this->access_denied();
            }
        } elseif ($role === 'mobile') {
            // Mobile users can access only 'customers' and 'mobile'
            if (!in_array($controller, ['customers', 'mobile'])) {
                $this->access_denied();
            }
        } else {
            // Unknown role
            $this->access_denied();
        }
    }

    private function access_denied()
    {
        // Full HTML page with SweetAlert
        echo '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <title>Access Denied</title>
        </head>
        <body>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Access Denied",
                        text: "You do not have permission to access this page.",
                        confirmButtonText: "Go Back"
                    }).then(() => {
                        window.history.back();
                    });
                });
            </script>
            <noscript>
                <meta http-equiv="refresh" content="3;url=javascript:history.back()">
                <p>You do not have permission to access this page. Please go back.</p>
            </noscript>
        </body>
        </html>';
        exit;
    }
}
