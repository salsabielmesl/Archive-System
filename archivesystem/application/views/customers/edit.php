<?php $this->load->view('includes/head'); ?>

<style>
    /* Card header styling */
    .card-header-custom {
        background-color: #263e60;
        color: #fff;
        font-weight: 600;
        font-size: 1.25rem;
        padding: 12px 20px;
        border-top-left-radius: 0.35rem;
        border-top-right-radius: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    /* Form row layout */
    .form-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .form-row .form-group {
        flex: 1;
        min-width: 150px;
    }

    /* Buttons row */
    .btn-row {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    /* Button colors */
    .btn-primary {
        background-color: #263e60;
        border-color: #263e60;
    }

    .btn-primary:hover {
        background-color: #1f3050;
        border-color: #1f3050;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #bb2d3b;
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
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb breadcrumb-custom">
                                    <li class="breadcrumb-item"><a href="<?= site_url('customers'); ?>">Customers</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Customer</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card shadow-sm">
                                <!-- Card Header -->
                                <div class="card-header card-header-custom">
                                    <span><i class="fas fa-user-edit"></i>Edit Customer</span>
                                </div>

                                <div class="card-body">
                                    <!-- Alert placeholder for AJAX -->
                                    <div id="ajax-alert"></div>

                                    <form id="editCustomerForm" method="post">

                                        <!-- Name & Email side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="<?= set_value('name', $customer->name); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="<?= set_value('email', $customer->email); ?>" required>
                                            </div>
                                        </div>

                                        <!-- Phone, Phone2 & Active side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="<?= set_value('phone', $customer->phone); ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone2" class="form-label">Phone 2</label>
                                                <input type="text" class="form-control" id="phone2" name="phone2"
                                                    value="<?= set_value('phone2', $customer->phone2); ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="active" class="form-label">Active</label>
                                                <select name="active" id="active" class="form-select" required>
                                                    <option value="yes" <?= $customer->active === 'yes' ? 'selected' : ''; ?>>Yes</option>
                                                    <option value="no" <?= $customer->active === 'no' ? 'selected' : ''; ?>>No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Start Date & End Date side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="start_date" name="start_date"
                                                    value="<?= set_value('start_date', $customer->start_date); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_date" class="form-label">
                                                    End Date <span id="end-date-required" class="text-danger" style="display:none;">*</span>
                                                    <span id="end-date-optional">(Optional)</span>
                                                </label>
                                                <input type="date" class="form-control" id="end_date" name="end_date"
                                                    value="<?= set_value('end_date', $customer->end_date); ?>">
                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?= site_url('customers'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update Customer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- content-wrapper -->
            </div> <!-- main-panel -->

            <?php $this->load->view('includes/javascript'); ?>
        </div> <!-- main-wrapper -->
    </div> <!-- main-content -->

    <script>
        $(document).ready(function() {

            function toggleEndDateRequired() {
                if ($('#active').val() === 'no') {
                    $('#end_date').attr('required', true);
                    $('#end-date-required').show();
                    $('#end-date-optional').hide();
                } else {
                    $('#end_date').removeAttr('required');
                    $('#end-date-required').hide();
                    $('#end-date-optional').show();
                }
            }

            toggleEndDateRequired();

            $('#active').change(function() {
                toggleEndDateRequired();
            });

            $('#editCustomerForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '<?= site_url("customers/edit/" . $customer->id); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: response.message,
            confirmButtonColor: '#263e60'
        }).then(() => {
            // redirect after clicking OK
            window.location.href = "<?= site_url('customers'); ?>";
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Update Failed',
            text: response.message,
            confirmButtonColor: '#d33'
        });
    }
},

                });
            });

        });
    </script>

</body>