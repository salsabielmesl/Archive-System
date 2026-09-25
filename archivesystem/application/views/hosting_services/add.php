<?php $this->load->view('includes/head'); ?>

<style>
/* Card header styling */
.card-header-custom {
    background-color: #263e60; /* same as navbar */
    color: #fff;
    font-weight: 500;
    font-size: 1.25rem;
    padding: 12px 20px;
    border-top-left-radius: 0.35rem;
    border-top-right-radius: 0.35rem;
    display: flex;
    align-items: center;
}

.card-header-custom i {
    margin-right: 10px;
}

/* Card body styling */
.card-body {
    padding: 2rem;
}

/* Form input styling */
.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    border-radius: 0.35rem;
    height: calc(2.25rem + 2px);
}

/* Buttons styling */
.btn-host {
    background-color: #263e60;
    color: #fff;
    border-radius: 0.35rem;
    padding: 0.45rem 1rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.btn-host:hover {
    background-color: #1f3050;
    color: #fff;
}

.btn-host i {
    margin-right: 5px;
}
/* Breadcrumb */
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
<!-- Breadcrumb Row -->
     <div class="row mb-3">
        <div class="col-12">
            <div class="breadcrumb-row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="<?= site_url('hosting_services'); ?>">Hosting Services</S></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Add Hosting Services</li>
                </ol>
            </nav>
        </div>
    </div>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card shadow-sm">
                            <!-- Card Header -->
                            <div class="card-header-custom">
                                <i class="fas fa-user-plus"></i> Add Hosting Service
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                <form id="ajaxForm" action="<?= site_url('hosting_services/add'); ?>" method="post">
                                    <div class="mb-3">
                                        <label class="form-label">Hosting Service Name</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="text-end">
                                        <a href="<?= site_url('hosting_services'); ?>" class="btn btn-danger"> 
                                            <i class="fas fa-arrow-left me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-host"><i class="fas fa-save"></i> Add Hosting</button>
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
            $('#ajaxForm').submit(function(e){
                e.preventDefault();
                var form = $(this);

                $.post(form.attr('action'), form.serialize(), function(resp){
                    var res = JSON.parse(resp);

                    // Use SweetAlert instead of alert
                    Swal.fire({
                        title: res.status === 'success' ? 'Success!' : 'Error!',
                        text: res.message,
                        icon: res.status === 'success' ? 'success' : 'error',
                        showCancelButton: res.status === 'success', // only show for success
                        confirmButtonText: 'Go back',
                        cancelButtonText: 'Stay here'
                    }).then((result) => {
                        if(res.status === 'success' && result.isConfirmed){
                            window.location.href = "<?= site_url('hosting_services'); ?>";
                        } else if(res.status === 'success'){
                            form[0].reset();
                        }
                    });

                    // Refresh table if exists
                    if(res.status === 'success' && window.opener && window.opener.$('#hosting-table').length){
                        window.opener.$('#hosting-table').DataTable().ajax.reload(null, false);
                    }

                    // Close modal if exists
                    if(res.status === 'success' && window.parent && window.parent.$('#modalContainer').length){
                        window.parent.$('#modalContainer .modal').modal('hide');
                    }
                });
            });
        });
        </script>

    </div> <!-- main-wrapper -->
</div> <!-- main-content -->
</body>
