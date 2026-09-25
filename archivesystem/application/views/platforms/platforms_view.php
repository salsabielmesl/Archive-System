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
<?php $this->load->view('includes/head'); ?>

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
                            <div class="breadcrumb-row d-flex flex-wrap align-items-center justify-content-between">
                                <!-- Breadcrumb -->
                                <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                                    <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item active" aria-current="page">Platforms</li>
                                </ol>
                            </nav>
                            <button id="btnAdd" class="btn btn-sm btn-host"><i class="fas fa-plus me-1"></i> Add Platform</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="webtable">
                              

                                <div class="table-responsive pt-3">
                                    <table id="platforms-table" class="table table-striped table-hover w-100">
                                        <thead class="table-header-custom">
                                            <tr>
                                                <th>App Platform</th>
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
                var table = $('#platforms-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= site_url('platforms/fetch'); ?>",
                        type: "POST"
                    },
                    columns: [
                        { data: "app_platform" },
                        {
                            data: "id",
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm btn-success edit-btn" data-id="${data}"> <i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="${data}"><i class="bi bi-trash"></i></button>
                                `;
                            },
                            orderable: false
                        }
                    ]
                });

                // Add platform
                $('#btnAdd').click(function() {
                    window.location.href = "<?= site_url('platforms/add'); ?>";
                });

                // Edit platform
                $('#platforms-table').on('click', '.edit-btn', function() {
                    var id = $(this).data('id');
                    window.location.href = "<?= site_url('platforms/edit/'); ?>" + id;
                });

                // Delete platform
                // Delete platform with SweetAlert
$('#platforms-table').on('click', '.delete-btn', function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: "This platform will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= site_url("platforms/delete/"); ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(resp) {
                    if(resp.status === 'success') {
                        Swal.fire(
                            'Deleted!',
                            resp.message || 'Platform deleted successfully.',
                            'success'
                        );
                        table.ajax.reload(null, false); // reload table without resetting paging
                    } else {
                        Swal.fire(
                            'Error!',
                            resp.message || 'Failed to delete platform.',
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire(
                        'Error!',
                        'Failed to delete platform.',
                        'error'
                    );
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
