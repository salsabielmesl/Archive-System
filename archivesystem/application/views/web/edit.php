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

.breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
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
/* Align buttons to the right */
.btn-row {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 1.5rem;
}

/* Optional: make buttons a bit more elegant */
.btn-row .btn {
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 500;
    transition: 0.2s;
}

.btn-row .btn:hover {
    opacity: 0.9;
}

    </style>
<body>
<?php $this->load->view('includes/navbar'); ?>
<div class="main-content">
    <?php $this->load->view('includes/sidebar'); ?>

    <div class="main-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
 <!-- Breadcrumb at the top -->
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="<?= site_url('Web'); ?>">Websites</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Website</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card shadow-sm">
                             <!-- Styled header -->
                            <div class="card-header card-header-custom">
                                 <h4 >Edit Website</h4>
</div>
                            <div class="card-body">
                               

                                <?php if ($this->session->flashdata('success')): ?>
                                    <div class="alert alert-success">
                                        <?= $this->session->flashdata('success'); ?>
                                    </div>
                                <?php endif; ?>

                                <form id="hosting-edit-form">
                                    <!-- Row 1 -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="domain" class="form-label">Domain</label>
                                            <input type="text" class="form-control" id="domain" name="domain" 
                                                value="<?= set_value('domain', $web->domain); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="hosting_link" class="form-label">Hosting Link</label>
                                            <input type="text" class="form-control" id="hosting_link" name="hosting_link" 
                                                value="<?= set_value('hosting_link', $web->hosting_link); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                value="<?= set_value('username', $web->username); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="text" class="form-control" id="password" name="password" 
                                                value="<?= set_value('password', $web->password); ?>" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="customer_id" class="form-label">Customer</label>
                                            <select id="customer_id" name="customer_id" class="form-select" required>
                                                <option value="">Select Customer</option>
                                                <?php foreach ($customers as $customer): ?>
                                                    <option value="<?= $customer->id; ?>" 
                                                        <?= set_select('customer_id', $customer->id, $customer->id == $web->customer_id); ?>>
                                                        <?= $customer->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="hosting_company" class="form-label">Hosting Company</label>
                                            <select id="hosting_company" name="hosting_company" class="form-select">
                                                <option value="VioletPro" <?= $web->hosting_company === 'VioletPro' ? 'selected' : ''; ?>>VioletPro</option>
                                                <option value="Other" <?= $web->hosting_company === 'Other' ? 'selected' : ''; ?>>Other</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Row 3 -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="hosting_id" class="form-label">Hosting Service</label>
                                            <select id="hosting_id" name="hosting_id" class="form-select">
                                                <option value="">Select Hosting Service</option>
                                                <?php foreach ($hosting_services as $hosting): ?>
                                                    <option value="<?= $hosting->id; ?>" 
                                                        <?= set_select('hosting_id', $hosting->id, $hosting->id == $web->hosting_id); ?>>
                                                        <?= $hosting->name; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="period" class="form-label">Period (months)</label>
                                            <input type="number" class="form-control" id="period" name="period" 
                                                value="<?= set_value('period', $web->period); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cost" class="form-label">Cost</label>
                                            <input type="number" step="0.01" class="form-control" id="cost" name="cost" 
                                                value="<?= set_value('cost', $web->cost); ?>">
                                        </div>
                                    </div>

                                    <!-- Row 4 -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" step="0.01" class="form-control" id="price" name="price" 
                                                value="<?= set_value('price', $web->price); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ip_address" class="form-label">IP Address</label>
                                            <input type="text" class="form-control" id="ip_address" name="ip_address" 
                                                value="<?= set_value('ip_address', $web->ip_address); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="start_date" class="form-label">Start Date</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                                value="<?= set_value('start_date', $web->start_date); ?>" required>
                                        </div>
                                    </div>

                                    <!-- Row 5 -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="expiring_date" class="form-label">Expiry Date</label>
                                            <input type="date" class="form-control" id="expiring_date" name="expiring_date" 
                                                value="<?= set_value('expiring_date', $web->expiring_date); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="recharge_date" class="form-label">Last Recharge Date</label>
                                            <input type="date" class="form-control" id="recharge_date" name="recharge_date" 
                                                value="<?= set_value('recharge_date', $web->recharge_date); ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="1"><?= set_value('description', $web->description); ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="btn-row">
                                        <a href="<?= site_url('Web'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Website</button>
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

                    $('#period, #cost, #price, #hosting_id').closest('.mb-3').find('label').each(function() {
                        if (isViolet) {
                            if ($(this).text().indexOf('*') === -1) $(this).append(' *');
                        } else {
                            $(this).text($(this).text().replace(' *',''));
                        }
                    });
                }

                toggleVioletProFields();
                $('#hosting_company').on('change', toggleVioletProFields);

                // AJAX form submission
               // AJAX form submission with SweetAlert
    $('#hosting-edit-form').on('submit', function(e) {
        e.preventDefault();

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        $.ajax({
            url: "<?= site_url('Web/edit/' . $web->id); ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Website Updated!',
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
