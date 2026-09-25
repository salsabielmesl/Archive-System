<?php $this->load->view('includes/head'); ?>

<style>
/* Card header style */
.card-header-custom {
    background-color: #263e60; /* match navbar */
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Button colors */
.btn-primary {
    background-color: #1e314d;
    border-color: #1e314d;
}
.btn-primary:hover {
    background-color: #40587c;
    border-color: #40587c;
}
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
                                    <li class="breadcrumb-item active" aria-current="page">Edit Email</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card shadow-sm">
                            <!-- Styled Card Header -->
                            <div class="card-header card-header-custom">
                                <span>Edit Email for <strong><?= htmlspecialchars($web->domain); ?></strong></span>
                            </div>

                            <div class="card-body">
                                <form id="editEmailForm" action="<?= site_url('Web/email_update/' . $email->id); ?>" method="post">
                                    <input type="hidden" name="web_id" value="<?= $web_id; ?>">

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : ''; ?>" 
                                               id="email" name="email" 
                                               value="<?= set_value('email', $email->email); ?>" required>
                                        <div class="invalid-feedback"><?= form_error('email'); ?></div>
                                    </div>

                                    <!-- Domain (readonly) -->
                                    <div class="mb-3">
                                        <label for="domain" class="form-label">Domain</label>
                                        <input type="text" class="form-control" id="domain" value="<?= htmlspecialchars($web->domain); ?>" readonly>
                                    </div>

                                    <!-- Buttons aligned right -->
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="<?= site_url('Web/email/' . $web_id); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Email</button>
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
    $('#editEmailForm').on('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message || 'Email updated successfully.',
                        showCancelButton: true,
                        confirmButtonText: 'Stay',
                        cancelButtonText: 'Go to Email List',
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Stay on page, optionally reset form
                            $('#editEmailForm')[0].reset();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            // Navigate back to email list
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
                        text: response.message || 'Failed to update email.',
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
