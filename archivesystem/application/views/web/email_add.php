<?php $this->load->view('includes/head'); ?>
<style>
    /* Breadcrumb styling */
    .breadcrumb-custom {
        background-color: #f8f9fa;
        padding: 8px 15px;
        margin: 1rem 0;
        border-radius: 0.35rem;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }

    .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
        content: ">";
        padding: 0 5px;
        color: #6c757d;
    }

    .breadcrumb-custom a {
        text-decoration: none;
        color: #263e60;
        font-weight: 500;
    }

    .breadcrumb-custom a:hover {
        text-decoration: underline;
    }
</style>

<body>
    <?php $this->load->view('includes/navbar'); ?>
    <div class="main-content">
        <?php $this->load->view('includes/sidebar'); ?>

        <div class="main-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Breadcrumb Row -->
                    <div class="row mb-3">
                        <div class="col-12">    
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-custom">
                                    <li class="breadcrumb-item"><a href="<?= site_url('Web/email/' . $web_id); ?>">Emails</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Email</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- Card with Header -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm">

                                <!-- Card Header -->
                                <div class="card-header text-white" style="background-color: #263e60;">
                                    <h5 class="mb-0">Add Email for Domain: <?= htmlspecialchars($web->domain); ?></h5>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body p-4">
                                    <form id="email-add-form">
                                        <input type="hidden" name="web_id" value="<?= $web_id; ?>">
                                        <input type="hidden" name="domain" value="<?= htmlspecialchars($web->domain); ?>">

                                        <div class="row mb-3">
                                            <div class="col-md-6 form-group">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                            </div>

                                            <div class="col-md-6 form-group">
                                                <label>Domain</label>
                                                <input type="text" class="form-control" value="<?= htmlspecialchars($web->domain); ?>" readonly>
                                            </div>
                                        </div>

                                        <div class="text-end mt-4">
                                             <a href="<?= site_url('Web/email/' . $web_id); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                            <button type="submit" class="btn btn-host me-2"><i class="fas fa-save me-2"></i>Save</button>             
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div> <!-- content-wrapper -->
            </div> <!-- main-panel -->

            <?php $this->load->view('includes/javascript'); ?>

        <script>
$(document).ready(function() {
    $('#email-add-form').on('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        $.ajax({
            url: "<?= site_url('Web/email_add_action'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message || 'Email added successfully.',
                        showCancelButton: true,
                        confirmButtonText: 'Stay',
                        cancelButtonText: 'Go to Email List',
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#263e60'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Stay on the page: reset the form
                            $('#email-add-form')[0].reset();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Go back to the email list page
                            window.location.href = "<?= site_url('Web/email/' . $web_id); ?>";
                        }

                        // Reload parent DataTable if exists
                        if (window.opener && window.opener.$('#email-table').length) {
                            window.opener.$('#email-table').DataTable().ajax.reload(null, false);
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to add email.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred. Check console for details.',
                    confirmButtonColor: '#dc3545'
                });
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

        </div> <!-- main-wrapper -->
    </div> <!-- main-content -->
</body>