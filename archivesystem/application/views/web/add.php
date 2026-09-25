<?php $this->load->view('includes/head'); ?>

<style>
/* Card header */
.card-header-custom {
    background-color: #263e60;
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Button styles */
.btn-primary, .btn-host {
    background-color: #1e314d;
    border-color: #1e314d;
}
.btn-primary:hover, .btn-host:hover {
    background-color: #40587c;
    border-color: #40587c;
}
/* Breadcrumb */
.breadcrumb-row {
    background-color: #f8f9fa;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}

.breadcrumb-row .breadcrumb {
    margin-bottom: 0;
    background-color: transparent;
    padding: 0;
}

.breadcrumb-row .breadcrumb a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-row .breadcrumb-item.active {
    color: #6c757d;
}
</style>

<body>
<?php $this->load->view('includes/navbar'); ?>
<div class="main-content">
    <?php $this->load->view('includes/sidebar'); ?>

    <div class="main-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
<!-- Breadcrumb -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="breadcrumb-row">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="<?= site_url('Web'); ?>">Web Management</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Hosting</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <!-- Styled header -->
                            <div class="card-header card-header-custom">
                                <span><i class="fas fa-user-plus"></i> Add Hosting</span>
                            </div>

                            <div class="card-body">
                                <form id="hosting-add-form">

                                    <div class="row mb-3">
                                        <!-- Customer -->
                                        <div class="col-md-4">
                                            <label class="form-label">Customer</label>
                                            <select id="customer_id" name="customer_id" class="form-select" required>
                                                <option value="">Select Customer</option>
                                                <?php foreach($customers as $c): ?>
                                                    <option value="<?= $c->id ?>"><?= $c->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Domain -->
                                        <div class="col-md-4">
                                            <label class="form-label">Domain</label>
                                            <input type="text" id="domain" name="domain" class="form-control" required>
                                        </div>

                                        <!-- Username -->
                                        <div class="col-md-4">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control" required>
                                        </div>

                                        <!-- Password -->
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Password</label>
                                            <input type="text" name="password" class="form-control" required>
                                        </div>

                                        <!-- Hosting Link -->
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Hosting Link</label>
                                            <input type="text" name="hosting_link" class="form-control">
                                        </div>

                                        <!-- IP Address -->
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">IP Address</label>
                                            <input type="text" name="ip_address" class="form-control">
                                        </div>

                                        <!-- Start Date -->
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Start Date</label>
                                            <input type="date" id="start_date" name="start_date" class="form-control" required>
                                        </div>

                                        <!-- Hosting Company -->
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Hosting Company</label>
                                            <select id="hosting_company" name="hosting_company" class="form-select">
                                                <option value="VioletPro" selected>VioletPro</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>

                                        <!-- Hosting Service -->
                                        <div class="col-md-4 mt-3">
                                            <label class="form-label">Hosting Service</label>
                                            <select id="hosting_id" name="hosting_id" class="form-select">
                                                <option value="">Select Hosting Service</option>
                                                <?php foreach($hosting_services as $h): ?>
                                                    <option value="<?= $h->id ?>"><?= $h->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Period -->
                                        <div class="col-md-2 mt-3">
                                            <label class="form-label">Period (months)</label>
                                            <input type="number" id="period" name="period" class="form-control" min="1">
                                        </div>

                                        <!-- Cost -->
                                        <div class="col-md-2 mt-3">
                                            <label class="form-label">Cost</label>
                                            <input type="number" id="cost" name="cost" class="form-control" min="0" step="0.01">
                                        </div>

                                        <!-- Price -->
                                        <div class="col-md-2 mt-3">
                                            <label class="form-label">Price</label>
                                            <input type="number" id="price" name="price" class="form-control" min="0" step="0.01">
                                        </div>

                                        <!-- Expiry Date -->
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Expiry Date</label>
                                            <input type="date" id="expiring_date" name="expiring_date" class="form-control">
                                        </div>

                                        <!-- Recharge Date -->
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Last Recharge Date</label>
                                            <input type="date" id="recharge_date" name="recharge_date" class="form-control">
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <a href="<?= site_url('Web'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Hosting</button>
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

                // Toggle required fields for VioletPro
                function toggleVioletProFields() {
                    const isViolet = $('#hosting_company').val() === 'VioletPro';
                    $('#period, #cost, #price, #hosting_id').prop('required', isViolet);

                    $('#period, #cost, #price, #hosting_id').closest('.form-group').find('label').each(function() {
                        if (isViolet) {
                            if ($(this).text().indexOf('*') === -1) $(this).append(' *');
                        } else {
                            $(this).text($(this).text().replace(' *',''));
                        }
                    });
                }

                toggleVioletProFields();

                $('#hosting_company').on('change', function() {
                    toggleVioletProFields();
                });

                // AJAX form submission
                 $('#hosting-add-form').on('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        $.ajax({
            url: "<?= site_url('Web/add'); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Hosting Added!',
                        text: response.message,
                        confirmButtonColor: '#263e60',
                        confirmButtonText: 'Back to Web Management'
                    }).then(() => {
                        window.location.href = "<?= site_url('Web'); ?>";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Unexpected Error',
                    text: 'An unexpected error occurred. Check console.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    });
});
        </script>

    </div> <!-- main-wrapper -->
</div> <!-- main-content -->
</body>
