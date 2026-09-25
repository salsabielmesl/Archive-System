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
                    <!-- Breadcrumb Row -->
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="breadcrumb-row d-flex flex-wrap align-items-center justify-content-between">
                                <!-- Breadcrumb -->
                                <nav aria-label="breadcrumb" class="mb-2 mb-md-0">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active" aria-current="page">Email Management</li>
                                    </ol>
                                </nav>
                                <a href="<?= site_url('Web/email_add/' . $web_id); ?>" class="btn btn-sm btn-host">
                                    <i class="fas fa-plus me-1"></i> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Emails Table Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="webtable">

                                    <div class="table-responsive p-3">
                                        <table id="email-table" class="table table-striped table-hover">
                                            <thead class="table-header-custom">
                                                <tr>
                                                    <th>Email</th>
                                                    <th>Domain</th>
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
    var webId = <?= $web_id; ?>;

    var table = $('#email-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= site_url('Web/fetch_emails'); ?>",
            type: "POST",
            data: { web_id: webId }
        },
        pageLength: 10,
        order: [[0, "asc"]],
        columns: [
            { data: "email" },
            { data: "domain" },
            {
                data: "id",
                render: function(data, type, row) {
                    return `
                        <a href="<?= site_url('Web/email_edit/'); ?>${data}" class="btn btn-sm btn-success me-2" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="${data}" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>
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

    // Delete email with SweetAlert2
    $('#email-table').on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?= site_url('Web/delete_email/'); ?>" + id,
                    type: "POST",
                    dataType: "json",
                    success: function(resp) {
                        if(resp.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: resp.message,
                                confirmButtonColor: '#263e60'
                            });
                            table.ajax.reload(null, false); // reload table without changing page
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed!',
                                text: resp.message,
                                confirmButtonColor: '#d33'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText); // helpful for debugging
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An unexpected error occurred while deleting the email.',
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