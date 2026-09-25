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
/* Make DataTable compact */
#web-table {
    font-size: 0.85rem; /* smaller text */
    border-radius: 8px;
    overflow: hidden;
}

/* Reduce padding for compact rows */
#web-table th,
#web-table td {
    padding: 6px 10px !important;
    vertical-align: middle;
}

/* Elegant table header */
#web-table thead th {
    background-color: #263e60;
    color: #ffffff;
    font-weight: 600;
    text-align: center;
    font-size: 0.9rem;
}

/* Zebra rows with subtle hover */
#web-table tbody tr:nth-child(even) {
    background-color: #f8f9fc;
}
#web-table tbody tr:hover {
    background-color: #eef3fb;
    transition: 0.2s ease-in-out;
}

/* Buttons in table */
#web-table .btn {
    border-radius: 6px;
    padding: 4px 8px;
    font-size: 0.75rem;
}

/* Card styling for elegance */
.card {
    border-radius: 10px;
    border: none;
}
/* Actions column */
#web-table td .action-buttons {
    display: flex;
    justify-content: center;
    gap: 5px;
    flex-wrap: nowrap;        /* Prevent wrapping */
    white-space: nowrap;      /* Keep buttons on one line */
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
                            <div class="breadcrumb-row d-flex flex-wrap align-items-center justify-content-between">
                                <!-- Breadcrumb -->
                                <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Web Management</li>
                                    </ol>
                                </nav>
                                <a href="<?= site_url('Web/add'); ?>" class="btn btn-sm btn-host">
                                    <i class="fas fa-plus me-1"></i> Add
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Web Table Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="webtable">
                                    

                                    <div class="table-responsive pt-3">
                                        <table id="web-table" class="table table-striped table-hover">
                                            <thead class="table-header-custom">
                                                <tr>
                                                    <th>Customer</th>
                                                    <th>Domain</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Hosting Link</th>
                                                    <th>Hosting Service</th>
                                                    <th>Hosting Company</th>
                                                    <th>Period</th>
                                                    <th>Cost</th>
                                                    <th>Price</th>
                                                    <th>IP Address</th>
                                                    <th>Start Date</th>
                                                    <th>Expiry Date</th>
                                                    <th>Last Recharge Date</th>
                                                    <th>Description</th>
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

                </div> <!-- content-wrapper -->
            </div> <!-- main-panel -->

            <?php $this->load->view('includes/javascript'); ?>

            <script>
                $(document).ready(function() {
                    var table = $('#web-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "<?= site_url('Web/fetch_web_datatable'); ?>",
                            type: "POST"
                        },
                        pageLength: 10,
                        order: [[1, "asc"]], // order by Domain
                        columns: [
                            { data: "customer_name" },
                            { data: "domain" },
                            { data: "username" },
                            { data: "password" },
                            { data: "hosting_link" },
                            { data: "hosting_service_name" },
                            { data: "hosting_company" },
                            { data: "period" },
                            { data: "cost" },
                            { data: "price" },
                            { data: "ip_address" },
                            { data: "start_date" },
                            { data: "expiring_date" },
                            { data: "recharge_date" },
                            { data: "description" },
                            {
                                data: "id",
                                render: function(data, type, row) {
                                    return `
                                     <div class="action-buttons">
                                       <a href="<?= site_url('Web/edit/'); ?>${data}" class="btn btn-sm btn-success me-2" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="${data}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                        <a href="<?= site_url('Web/email/'); ?>${data}" class="btn btn-sm btn-primary me-2" title="Emails">
                                           <i class="fas fa-envelope"></i>
                                        </a>
                                        </div>
                                    `;
                                },
                                orderable: false
                            }
                        ],
                        language: {
                            info: "Showing _START_ to _END_ of _TOTAL_ entries",
                            infoFiltered: ""
                        }
                    });

                    // Handle delete button click
                   // Handle delete button click
$('#web-table').on('click', '.btn-delete', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This website record will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= site_url('Web/delete/'); ?>" + id,
                type: "POST",
                dataType: "json",
                success: function(resp) {
                    if (resp.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: resp.message,
                            confirmButtonText: 'Back to Web Management', // 👈 updated text
                            confirmButtonColor: '#263e60'
                        }).then(() => {
                            table.ajax.reload(null, false); // reload DataTable after confirmation
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: resp.message,
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete website.',
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
