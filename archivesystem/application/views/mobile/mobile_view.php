<style>
    /* Table header custom style */
    table.dataTable thead th {
        background-color: #263e60; 
        color: #f8f9fa; 
        font-weight: 600;
        vertical-align: middle;
    }
    .modal-header{
        background-color: #263e60; /* match navbar */
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-bottom: none;
    }
     /* Breadcrumb row container styling */
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
            .btn-success {
    color: #fff !important;
    background-color: #198754 !important;
    border-color: #198754 !important ;
}
.btn-danger
 {
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
</style>
<?php $this->load->view('includes/head'); ?>

<body>
<?php $this->load->view('includes/navbar'); ?>
<div class="main-content">
    <?php $this->load->view('includes/sidebar'); ?>

    <div class="main-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">
<div class="row mb-3">
                        <div class="col-12">
                            <div class="breadcrumb-row d-flex flex-wrap align-items-center justify-content-between">
                                <!-- Breadcrumb -->
                                <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                                    <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Mobile Users</li>
                </ol>
            </nav>
                   <!-- Add Button -->
               <a href="<?= site_url('mobile/add'); ?>" class="btn btn-sm btn-host d-flex align-items-center">
    <i class="fas fa-plus me-2"></i> Add
</a>
</div>
</div>
</div>
                <!-- Mobile Users Table Row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="webtable p-3">
                                

                                <div class="table-responsive">
                                    <table id="mobile-table" class="table table-striped table-hover w-100">
                                        <thead class="table-header-custom">
                                            <tr>
                                                <th>Customer</th>
                                                <th>Application Name</th>
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Username</th>
                                                <th>Domain</th>
                                                <th>Admin Page</th>
                                                <th>API Path</th>
                                                <th>App Key</th>
                                                <th>Note</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Applications Modal -->
                <div class="modal fade" id="mobileAppsModal" tabindex="-1" aria-labelledby="mobileAppsModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-indigo ">
                                <h5 class="modal-title" id="mobileAppsModalLabel">Applications Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <table id="mobile-apps-table" class="table table-striped table-hover w-100">
                                        <thead class="table-header-custom">
                                            <tr>
                                                <th>Mobile ID</th>
                                                <th>Platform</th>
                                                <th>Platform Email</th>
                                                <th>Platform Password</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-2"></i>Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Application Modal -->
                <div class="modal fade" id="editAppModal" tabindex="-1" aria-labelledby="editAppModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header  text-white">
                                <h5 class="modal-title" id="editAppModalLabel">Edit Application</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="editAppForm">
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="editAppId">
                                    
                                    <!-- Platform Dropdown -->
                                    <div class="mb-3">
                                        <label for="editPlatformId" class="form-label">Platform</label>
                                        <select class="form-control" name="platform_id" id="editPlatformId" required>
                                            <option value="">Select Platform</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="editPlatformEmail" class="form-label">Platform Email</label>
                                        <input type="email" class="form-control" name="platform_email" id="editPlatformEmail">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editPlatformPassword" class="form-label">Platform Password</label>
                                        <input type="text" class="form-control" name="platform_password" id="editPlatformPassword">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-arrow-left me-2"></i>Cancel</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div> <!-- content-wrapper -->
        </div> <!-- main-panel -->

        <?php $this->load->view('includes/javascript'); ?>

        <style>
            #mobile-table th,
            #mobile-table td,
            #mobile-apps-table th,
            #mobile-apps-table td {
                white-space: nowrap;
                vertical-align: middle;
            }
        </style>

<script>
let mobileTable, mobileAppsTable;

function initMobileTable() {
    if ($.fn.DataTable.isDataTable('#mobile-table')) {
        $('#mobile-table').DataTable().destroy();
    }

    mobileTable = $('#mobile-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('mobile/fetch'); ?>",
            type: "POST",
            error: function(xhr) {
                console.error('AJAX error:', xhr.responseText);
                Swal.fire('Error', 'Error fetching data. Check console for details.', 'error');
            }
        },
        pageLength: 10,
        order: [[1, "asc"]],
        scrollX: true,
        responsive: false,
        autoWidth: false,
        columns: [
            { data: "customer_name" },
            { data: "app_name" },
            { data: "email" },
            { data: "password" },
            { data: "username" },
            { data: "domain_name" },
            {
                data: "admin_page_link",
                render: function(data) {
                    return data ? `<a href="${data}" target="_blank">${data}</a>` : '';
                }
            },
            { data: "api_main_path" },
            { data: "app_key" },
            { data: "note" },
            {
                data: "id",
                render: function(data) {
                    return `
                        <a href="<?= site_url('mobile/edit/'); ?>${data}" class="btn btn-sm btn-success me-2" title="Edit Mobile User">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= site_url('mobile/delete/'); ?>${data}" class="btn btn-sm btn-danger btn-delete" title="Delete">
                           <i class="bi bi-trash"></i>
                        </a>
                        <a href="#" data-id="${data}" class="btn btn-sm btn-primary btn-view me-2" title="View Applications">
                            <i class="fas fa-eye"></i>
                        </a>
                    `;
                },
                orderable: false
            }
        ]
    });
}

$(document).ready(function() {
    initMobileTable();

    // SweetAlert delete for mobile user
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'This mobile user will be deleted permanently!',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    success: function(resp){
                        if(resp.success){
                            Swal.fire('Deleted!', resp.message, 'success');
                            mobileTable.ajax.reload(null, false);
                        } else {
                            Swal.fire('Error', resp.message || 'Failed to delete user.', 'error');
                        }
                    },
                    error: function(xhr){
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'An unexpected error occurred.', 'error');
                    }
                });
            }
        });
    });

    // View Mobile Applications
    $(document).on('click', '.btn-view', function(e) {
        e.preventDefault();
        const mobileId = $(this).data('id');

        if ($.fn.DataTable.isDataTable('#mobile-apps-table')) {
            $('#mobile-apps-table').DataTable().destroy();
            $('#mobile-apps-table tbody').empty();
        }

        mobileAppsTable = $('#mobile-apps-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('applications/get_by_mobile/'); ?>" + mobileId,
                type: "POST",
                error: function(xhr) {
                    console.error('Error fetching applications:', xhr.responseText);
                    Swal.fire('Error', 'Failed to fetch applications. Check console.', 'error');
                }
            },
            pageLength: 10,
            order: [[0, 'asc']],
            columns: [
                { data: 'mobile_id' },
                { data: 'platform_name' },
                { data: 'platform_email' },
                { data: 'platform_password' },
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <a href="#" class="btn btn-sm btn-success me-2 btn-edit-app" data-id="${data}" title="Edit Application">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-danger btn-delete-app" data-id="${data}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </a>
                        `;
                    },
                    orderable: false
                }
            ]
        });

        $('#mobileAppsModal').modal('show');
    });

    // SweetAlert delete for applications
    $(document).on('click', '.btn-delete-app', function(e) {
        e.preventDefault();
        const btn = $(this);
        const appId = btn.data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: 'This application will be deleted permanently!',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.ajax({
                    url: "<?= site_url('applications/delete/'); ?>" + appId,
                    type: "POST",
                    dataType: "json",
                    success: function(res){
                        if(res.success){
                            Swal.fire('Deleted!', res.message, 'success');
                            mobileAppsTable.row(btn.parents('tr')).remove().draw();
                        } else {
                            Swal.fire('Error', res.message || 'Failed to delete application.', 'error');
                        }
                    },
                    error: function(xhr){
                        console.error('Delete error:', xhr.responseText);
                        Swal.fire('Error', 'An unexpected error occurred.', 'error');
                    }
                });
            }
        });
    });

    // Edit Application
    $(document).on('click', '.btn-edit-app', function(e){
        e.preventDefault();
        const appId = $(this).data('id');

        // Load Platforms into dropdown
        $.ajax({
            url: "<?= site_url('applications/get_platforms'); ?>",
            method: "GET",
            dataType: "json",
            success: function(platforms){
                const $select = $('#editPlatformId');
                $select.empty().append('<option value="">Select Platform</option>');
                platforms.forEach(function(p){
                    $select.append(`<option value="${p.id}">${p.app_platform}</option>`);
                });

                // Fetch Application data
                $.ajax({
                    url: "<?= site_url('applications/get/'); ?>" + appId,
                    method: "GET",
                    dataType: "json",
                    success: function(data){
                        $('#editAppId').val(data.id);
                        $('#editPlatformId').val(data.platform_id);
                        $('#editPlatformEmail').val(data.platform_email);
                        $('#editPlatformPassword').val(data.platform_password);
                        $('#editAppModal').modal('show');
                    },
                    error: function(xhr){
                        console.error('Fetch error:', xhr.responseText);
                        Swal.fire('Error', 'Failed to fetch application data.', 'error');
                    }
                });
            },
            error: function(xhr){
                console.error('Platforms fetch error:', xhr.responseText);
                Swal.fire('Error', 'Failed to load platforms.', 'error');
            }
        });
    });

    // Submit Edit Application form
    $('#editAppForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('applications/update'); ?>",
            method: "POST",
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
                $('#editAppModal').modal('hide');
                mobileAppsTable.ajax.reload(null, false);
                Swal.fire('Success', response.message, 'success');
            },
            error: function(xhr){
                console.error('Update error:', xhr.responseText);
                Swal.fire('Error', 'Failed to update application.', 'error');
            }
        });
    });
});
</script>

    </div>
</div>
</body>
