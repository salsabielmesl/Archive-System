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
    padding: 0.75rem 1rem;
    border-bottom: none;
}

/* Form row spacing */
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

.btn-success {
    color: #fff !important;
    background-color: #198754 !important;
    border-color: #198754 !important;
}
.btn-danger {
    color: #fff !important;
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}
.btn-primary {
    background-color: #1e314d;
    border-color: #1e314d;
}
.btn-primary:hover {
    background-color: #40587c;
    border-color: #40587c;
}

/* Breadcrumb styling */
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
                        <div class="breadcrumb-row d-flex align-items-center justify-content-between">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="<?= site_url('customers'); ?>">Customers</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Add Customer</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="card shadow-sm">
                                <!-- Card Header -->
                                <div class="card-header card-header-custom"> <i class="fas fa-user-plus"></i> 
                                    Add Customer
                                </div>

                                <div class="card-body">
                                    <!-- Alert placeholder for AJAX -->
                                    <div id="ajax-alert"></div>

                                    <form id="addCustomerForm" method="post">

                                        <!-- Name & Email side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" required>
                                            </div>
                                        </div>

                                        <!-- Phone, Phone2 & Active side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" name="phone" id="phone" class="form-control" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone2" class="form-label">Phone 2 (Optional)</label>
                                                <input type="text" name="phone2" id="phone2" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="active" class="form-label">Active</label>
                                                <select name="active" id="active" class="form-select" required>
                                                    <option value="yes" selected>Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Start Date & End Date side by side -->
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="start_date" class="form-label">Start Date</label>
                                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_date" class="form-label">
                                                    End Date <span id="end-date-required" class="text-danger" style="display:none;">*</span>
                                                    <span id="end-date-optional">(Optional)</span>
                                                </label>
                                                <input type="date" name="end_date" id="end_date" class="form-control">
                                            </div>
                                        </div>

                                        <!-- Buttons side by side -->
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?= site_url('customers'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Add Customer</button>
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

    // Function to toggle required attribute and label for End Date
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

    // Initialize on page load
    toggleEndDateRequired();

    // Listen to Active dropdown change
    $('#active').change(function() {
        toggleEndDateRequired();
    });

    // AJAX form submit
    $('#addCustomerForm').on('submit', function(e) {
        e.preventDefault(); // prevent default form submit

        var formData = $(this).serialize();

        $.ajax({
            url: '<?= site_url('customers/add'); ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
           success: function(response) {
    if (response.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Customer Added!',
            text: response.message,
            confirmButtonColor: '#263e60'
        }).then(() => {
            // redirect after success
            window.location.href = "<?= site_url('customers'); ?>";
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Add Failed',
            text: response.message,
            confirmButtonColor: '#d33'
        });
    }
},
error: function() {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'An error occurred. Please try again.',
        confirmButtonColor: '#d33'
    });
}

        });
    });

});
</script>

</body>  
