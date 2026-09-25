<?php $this->load->view('includes/head'); ?>

<style>
    /* Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body, html {
        height: 100%;
        font-family: 'Poppins', sans-serif;
        background: #263e60;
        overflow: hidden; /* Prevent scrolling */
    }

    .login-container {
    min-height: 90vh;
    display: flex;
    justify-content: center;
    align-items: flex-start; /* align card to top */
    padding-top: 60px;       /* distance from the very top */
}


    /* Glassmorphism card */
    .login-card {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        color: #fff;
    }

    .login-card h4 {
        font-weight: 600;
        font-size: 1.5rem;
        letter-spacing: 0.5px;
    }

    /* Circular logo */
    .login-image {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.6);
        margin-bottom: 1rem;
    }

    /* Form styles */
    .form-label {
        font-weight: 500;
        color: #fff;
    }

    .form-control {
        border-radius: 8px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.3);
        color: #fff;
    }

    .form-control::placeholder {
        color: rgba(255,255,255,0.7);
    }

    .form-control:focus {
        background: rgba(255,255,255,0.25);
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(255,193,7,0.3);
    }

    /* Button */
    .btn-custom {
        border-radius: 10px;
        background: linear-gradient(135deg, #ffc107, #ff9800);
        border: none;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: transform 0.2s ease-in-out;
        color: #263e60;
    }

    .btn-custom:hover {
        transform: scale(1.05);
    }

    hr {
        border-color: rgba(255,255,255,0.2);
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="text-center mb-3">
            <img src="<?= base_url('assets/images/logo.jpeg'); ?>" 
                 alt="archivesystem"
                 class="login-image">
            <h4>Welcome Back</h4>
            <hr>
        </div>

        <form action="<?= site_url('auth/login_process') ?>" method="POST">
            <input type="date" name="current_date" id="current_date" hidden>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required autofocus placeholder="Enter username">
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password" autocomplete="off">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-custom">Login</button>
            </div>
        </form>
    </div>
</div>

<?php $this->load->view('includes/javascript'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set current date in hidden field
    const dateField = document.getElementById("current_date");
    const now = new Date();
    const formattedDate = now.toISOString().split('T')[0];
    dateField.value = formattedDate;

    // Show SweetAlert if login failed
    <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: <?= json_encode($this->session->flashdata('error')) ?>,
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>
});
</script>
