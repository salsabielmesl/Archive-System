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
    <!-- Breadcrumb + Add Button Row -->
 <div class="row mb-3">
                        <div class="col-12">
                            <div class="breadcrumb-row d-flex flex-wrap align-items-center justify-content-between">
                                <!-- Breadcrumb -->
                                <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                                    <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active" aria-current="page">Hosting Services</li>
                        </ol>
                    </nav>
                    <a href="<?= site_url('hosting_services/add'); ?>" class="btn btn-sm btn-host">
                        <i class="fas fa-plus"></i> Add Hosting
                    </a>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="webtable">
                                

                                <div class="table-responsive pt-3">
                                    <table id="hosting-table" class="table table-striped table-hover w-100">
                                        <thead class="table-header-custom">
                                            <tr>
                                                <th>Name</th>
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
    var table = $('#hosting-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('hosting_services/fetch'); ?>",
            type: "POST"
        },
        columns: [
            { data: "name" },
            {
                data: "id",
                render: function(data, type, row) {
                    return `
                        <a href="<?= site_url('hosting_services/edit/'); ?>${data}" class="btn btn-sm btn-success edit-btn">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="${data}">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                },
                orderable: false
            }
        ]
    });

    // Delete hosting service using SweetAlert
    $('#hosting-table').on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This hosting service will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= site_url("hosting_services/delete/"); ?>' + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(resp) {
                        if(resp.status === 'success') {
                            Swal.fire(
                                'Deleted!',
                                resp.message || 'Hosting service deleted successfully.',
                                'success'
                            );
                            table.ajax.reload(null, false); // reload table without resetting pagination
                        } else {
                            Swal.fire(
                                'Error!',
                                resp.message || 'Failed to delete hosting service.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Failed to delete hosting service.',
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
