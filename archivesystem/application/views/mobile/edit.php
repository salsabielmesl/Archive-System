<style>
    /* All h5 headers black except where overridden */


    /* Card header styled like navbar */
    .card-header-navbar {
        background-color: #263e60; /* same as navbar */
        color: white;
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #dee2e6;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    /* Modal header styled like navbar */
    .modal-header-navbar {
        background-color: #263e60;
        color: white;
    }

    /* Website cards inside modal */
   

    .website-card:hover,
    .website-card.selected {
        border-color: #263e60;
        box-shadow: 0 0 10px rgba(38, 62, 96, 0.3);
    }

    /* Buttons spacing */
    .btn + .btn {
        margin-left: 10px;
    }

    /* Input group icon button */
    .input-group .btn-outline-info {
        border-left: 0;
    }

    /* Card body form spacing */
    .card-body .row + .row {
        margin-top: 1rem;
    }

    /* Small muted text for password info */
    .text-muted {
        font-size: 0.85rem;
    }
    .btn-primary {
    background-color: #263e60 !important;
    border-color: #263e60 !important;
}
.btn-primary:hover {
    background-color: #1f3050 !important;
    border-color: #1f3050 !important;
}
 

/* Breadcrumb */
.breadcrumb-custom {
    background-color: #f8f9fa;
    padding: 8px 15px;
    border-radius: 0.35rem;
    margin-bottom: 20px;
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
</style>

<?php $this->load->view('includes/head'); ?>

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
                                <li class="breadcrumb-item"><a href="<?= site_url('mobile'); ?>">Mobile Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Mobile User</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="card shadow-sm">
                            <div class="card-header text-white" style="background-color: #263e60;">
                                <h4 >Edit Mobile User</h4>
                            </div>
                            <div class="card-body">
                                <div id="ajaxAlert"></div>

                                <?= form_open('mobile/edit/' . $mobile->id, ['id' => 'editMobileForm']); ?>

                                <!-- Row 1: Customer / App Name / Email -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="customer_id" class="form-label">Customer</label>
                                        <select name="customer_id" id="customer_id" class="form-select" required>
                                            <option value="">-- Select Customer --</option>
                                            <?php foreach ($customers as $customer): ?>
                                                <?php $customer_domain = $domains[$customer->id]->domain ?? ''; ?>
                                                <option value="<?= $customer->id; ?>" data-domain="<?= $customer_domain; ?>" <?= ($mobile->customer_id == $customer->id) ? 'selected' : ''; ?>>
                                                    <?= $customer->name; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="app_name" class="form-label">Application Name</label>
                                        <input type="text" class="form-control" id="app_name" name="app_name" value="<?= set_value('app_name', $mobile->app_name); ?>" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email', $mobile->email); ?>" required>
                                    </div>
                                </div>

                                <!-- Row 2: Username / Password / Domain -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?= set_value('username', $mobile->username); ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        <small class="text-muted">Leave blank to keep current password.</small>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="domain" class="form-label">Domain</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="domain" name="domain" value="<?= set_value('domain', $domains[$mobile->customer_id]->domain ?? ''); ?>">
                                            <button type="button" class="btn btn-outline-info" id="domainInfoBtn" title="View Customer Websites">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3: Admin Page Link / API Main Path / App Key -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="admin_page_link" class="form-label">Admin Page Link</label>
                                        <input type="text" class="form-control" id="admin_page_link" name="admin_page_link" value="<?= set_value('admin_page_link', $mobile->admin_page_link); ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="api_main_path" class="form-label">API Main Path</label>
                                        <input type="text" class="form-control" id="api_main_path" name="api_main_path" value="<?= set_value('api_main_path', $mobile->api_main_path); ?>">
                                    </div>

                                    <div class="col-md-4">
                                        <label for="app_key" class="form-label">App Key</label>
                                        <input type="text" class="form-control" id="app_key" name="app_key" value="<?= set_value('app_key', $mobile->app_key); ?>">
                                    </div>
                                </div>

                                <!-- Row 4: Note -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="note" class="form-label">Note</label>
                                        <input type="text" class="form-control" id="note" name="note" value="<?= set_value('note', $mobile->note); ?>">
                                    </div>
                                </div>

                                <!-- Buttons -->
                                 <div class="text-end mt-4">
                                    <a href="<?= site_url('mobile'); ?>" class="btn btn-danger"><i class="fas fa-arrow-left me-2"></i>Cancel</a>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update Mobile User</button>
                                </div>

                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>

               <!-- Customer Websites Modal -->
<div class="modal fade" id="domainInfoModal" tabindex="-1" aria-labelledby="domainInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header card-header-navbar">
                <h5 class="modal-title" id="domainInfoModalLabel">Customer Websites</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="customerWebList"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-2"></i>Cancel</button>
                <a href="#" id="editSelectedWebsite" class="btn btn-success"><i class="bi bi-pencil"></i>Edit</a>
            </div>
        </div>
    </div>
</div>


            </div> <!-- content-wrapper -->
        </div> <!-- main-panel -->

        <?php $this->load->view('includes/javascript'); ?>

        <script>
        $(document).ready(function() {
            let domainManuallyEdited = false;

            // Detect manual edits
            $('#domain').on('input', function() {
                domainManuallyEdited = true;
            });

            // Auto-fill domain only if not manually edited
            $('#customer_id').on('change', function() {
                const domain = $(this).find('option:selected').data('domain') || '';
                if (!domainManuallyEdited) {
                    $('#domain').val(domain);
                }
            });

            // Customer Websites Modal
            $('#domainInfoBtn').on('click', function() {
                var customerId = $('#customer_id').val();
                if (!customerId) return alert('Please select a customer first.');

                $.ajax({
                    url: "<?= site_url('Web/fetch_web_by_customer'); ?>",
                    type: "POST",
                    data: { customer_id: customerId },
                    dataType: "json",
                    success: function(websites) {
                        $('#customerWebList').empty();
                        let html = '';
                        if(websites.length === 0){
                            html = '<p class="text-muted">No websites found for this customer.</p>';
                            $('#editSelectedWebsite').attr('href', '#').removeAttr('target');
                        } else {
                            websites.forEach(function(w, index){
                                html += `
                                    <div class="card mb-2 website-card" data-web-id="${w.id}">
                                        <div class="card-body p-2">
                                            <div class="row g-2">
                                                <div class="col-md-3"><strong>Domain:</strong> ${w.domain}</div>
                                                <div class="col-md-3"><strong>Username:</strong> ${w.username}</div>
                                                <div class="col-md-3"><strong>Password:</strong> ${w.password}</div>
                                                <div class="col-md-3"><strong>Hosting Service:</strong> ${w.hosting_service_name}</div>
                                            </div>
                                            <div class="row g-2 mt-1">
                                                <div class="col-md-3"><strong>Hosting Company:</strong> ${w.hosting_company}</div>
                                                <div class="col-md-3"><strong>Period:</strong> ${w.period}</div>
                                                <div class="col-md-3"><strong>Cost:</strong> ${w.cost}</div>
                                                <div class="col-md-3"><strong>Price:</strong> ${w.price}</div>
                                            </div>
                                            <div class="row g-2 mt-1">
                                                <div class="col-md-3"><strong>Start Date:</strong> ${w.start_date}</div>
                                                <div class="col-md-3"><strong>Expiring Date:</strong> ${w.expiring_date}</div>
                                                <div class="col-md-3"><strong>Recharge Date:</strong> ${w.recharge_date}</div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                if(index === 0){
                                    $('#editSelectedWebsite')
                                        .attr('href', '<?= site_url('Web/edit/'); ?>' + w.id)
                                        .attr('target', '_blank');
                                }
                            });
                        }

                        $('#customerWebList').html(html);
                        $('#domainInfoModal').modal('show');

                        $('.website-card').off('click').on('click', function() {
                            $('.website-card').removeClass('border-primary shadow-sm');
                            $(this).addClass('border-primary shadow-sm');
                            let webId = $(this).data('web-id');
                            $('#editSelectedWebsite')
                                .attr('href', '<?= site_url('Web/edit/'); ?>' + webId)
                                .attr('target', '_blank');
                        });
                    },
                    error: function(xhr){
                        alert('Failed to fetch websites. Check console.');
                        console.error(xhr.responseText);
                    }
                });
            });

            // AJAX form submission
              $('#editMobileForm').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('button[type=submit]').prop('disabled', true).text('Updating...');
            },
            success: function(response) {
                $('button[type=submit]').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Update Mobile User');
                if (response.success) {
    Swal.fire({
        icon: 'success',
        title: 'Updated',
        text: response.message,
        confirmButtonText: 'Back to Mobile Users'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "<?= site_url('mobile'); ?>";
        }
    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                $('button[type=submit]').prop('disabled', false).html('<i class="fas fa-save me-1"></i> Update Mobile User');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.'
                });
            }
        });
    });
});
        </script>

    </div> <!-- main-wrapper -->
</div> <!-- main-content -->
</body>
