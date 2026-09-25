<?php $this->load->view('includes/head'); ?>
<style>
/* Table header custom style */
table.dataTable thead th {
    background-color: #263e60; 
    color: #f8f9fa; 
    font-weight: 600;
    vertical-align: middle;
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
</style>
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
                                        <li class="breadcrumb-item active" aria-current="page">Customers Management</li>
                                    </ol>
                                </nav>

                                <!-- Add Button -->
                                <a href="<?= site_url('customers/add'); ?>" class="btn btn-sm btn-host">
                                    <i class="fas fa-plus me-1"></i> Add <?= $this->lang->line('Add'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Customers Table Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="webtable">
                                    

                                    <div class="table-responsive pt-3">
                                        <table id="customers-table" class="table table-striped table-hover w-100">
                                            <thead class="table-header-custom">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Phone2</th>
                                                    <th>Email</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Active</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data populated via AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- content-wrapper -->
            </div> <!-- main-panel -->

            <!-- JavaScript includes -->
            <?php $this->load->view('includes/javascript'); ?>

            <script>
                $(document).ready(function() {
                    var table = $('#customers-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "<?= site_url('customers/fetch'); ?>",
                            type: "POST"
                        },
                        pageLength: 10,
                        order: [[0, "asc"]],
                        columns: [
                            { data: "name" },
                            { data: "phone" },
                            { data: "phone2" },
                            { data: "email" },
                            { data: "start_date" },
                            { data: "end_date" },
                            { data: "active" },
                            {
                                data: "id",
                                render: function(data, type, row) {
                                    return `
                                         <a href="<?= site_url('customers/edit/'); ?>${data}" class="btn btn-sm btn-success me-2" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="${data}" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    `;
                                },
                                orderable: false
                            }
                        ],
                        language: {
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            infoEmpty: "Showing 0 to 0 of 0 entries",
                            infoFiltered: ""
                        }
                    });

                    // ===== AJAX Delete =====
                   // ===== AJAX Delete with SweetAlert2 =====
$('#customers-table').on('click', '.btn-delete', function() {
    var customerId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= site_url("customers/delete/"); ?>' + customerId,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        table.ajax.reload(null, false); // reload table without resetting paging
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            confirmButtonColor: '#198754'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
                            text: 'Failed to delete customer.',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error deleting customer. Please try again.',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        }
    });
});

                });
            </script>
        </div> <!-- main-wrapper -->
    </div> <!-- main-content -->
</body>
