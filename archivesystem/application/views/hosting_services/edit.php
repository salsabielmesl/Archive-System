<?php $this->load->view('includes/head'); ?>

<style>
/* Card header styling */
.card-header-custom {
    background-color: #263e60; /* match navbar */
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

/* Buttons row */
.btn-row {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    margin-top: 1rem;
}

/* Buttons colors */
.btn-primary {
    background-color: #263e60;
    border-color: #263e60;
}
.btn-primary:hover {
    background-color: #1f3050;
    border-color: #1f3050;
}
.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}
.btn-secondary:hover {
    background-color: #5a6268;
    border-color: #5a6268;
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
                        <div class="breadcrumb-row d-flex flex-wrap align-items-center justify-content-between">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-custom">
                                <li class="breadcrumb-item"><a href="<?= site_url('hosting_services'); ?>">Hosting Services</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Hosting</li>
                            </ol>
                        </nav>
</div>
                    </div>
                </div>

                <!-- Card -->
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card shadow-sm">
                            <div class="card-header-custom">
                                <i class="fas fa-user-edit"></i> Edit Hosting Service
                            </div>
                            <div class="card-body">
                                <form id="ajaxForm" action="<?= site_url('hosting_services/edit/' . $hosting->id); ?>" method="post">
                                    <div class="mb-3">
                                        <label class="form-label">Hosting Service Name</label>
                                        <input type="text" name="name" class="form-control" 
                                               value="<?= set_value('name', $hosting->name); ?>" required>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="btn-row">
                                        <a href="<?= site_url('hosting_services'); ?>" class="btn btn-danger">
                                            <i class="fas fa-arrow-left me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>Update Hosting
                                        </button>
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
            var hostingTable = window.opener ? window.opener.$('#hosting-table').DataTable() : null;

            $('#ajaxForm').submit(function(e){
                e.preventDefault();
                var form = $(this);

                $.post(form.attr('action'), form.serialize(), function(resp){
                    var res = JSON.parse(resp);

                    Swal.fire({
                        title: res.status === 'success' ? 'Success!' : 'Error!',
                        text: res.message,
                        icon: res.status === 'success' ? 'success' : 'error',
                        showCancelButton: res.status === 'success',
                        confirmButtonText: 'Go back',
                        cancelButtonText: 'Stay here'
                    }).then((result) => {
                        if(res.status === 'success'){
                            if(result.isConfirmed){
                                window.location.href = "<?= site_url('hosting_services'); ?>";
                            } else {
                                // Stay on page, reset form if needed
                                form[0].reset();
                            }

                            // Refresh table if exists
                            if(hostingTable){
                                hostingTable.ajax.reload(null, false);
                            }

                            // Close modal if exists
                            if(window.parent && window.parent.$('#modalContainer').length){
                                window.parent.$('#modalContainer .modal').modal('hide');
                            }
                        }
                    });
                });
            });
        });
        </script>
    </div> <!-- main-wrapper -->
</div> <!-- main-content -->
</body>
