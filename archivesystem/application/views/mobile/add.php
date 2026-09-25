<?php $this->load->view('includes/head'); ?>

<body>
<?php $this->load->view('includes/navbar'); ?>
<div class="main-content">
    <?php $this->load->view('includes/sidebar'); ?>

    <div class="main-wrapper">
        <div class="main-panel">
            <div class="content-wrapper">

                <!-- Add Mobile User Form -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h4 class="fs-5 mb-0"><?= $this->lang->line('add_new_mobile_user'); ?></h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div id="ajaxAlert"></div>

                                <?= form_open('mobile/add', ['id'=>'mobileAddForm']); ?>

                                <!-- Row 1: Customer / App Name / Email -->
                                <div class="row mb-3">
                                    <div class="col-md-4 form-group">
                                        <label>Customer</label>
                                        <select id="customer_id" name="customer_id" class="form-select" required>
                                            <option value="">-- Select Customer --</option>
                                            <?php foreach ($customers as $customer): ?>
                                                <option value="<?= $customer->id; ?>"><?= $customer->name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Application Name</label>
                                        <input type="text" name="app_name" class="form-control" required>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Row 2: Username / Password / Domain -->
                                <div class="row mb-3">
                                    <div class="col-md-4 form-group">
                                        <label>Username</label>
                                        <input type="text" name="username" class="form-control">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>Domain</label>
                                        <select name="domain" id="domain" class="form-select" required>
                                            <option value="">-- Select Domain --</option>
                                            <?php foreach ($domains as $domain): ?>
                                                <option value="<?= $domain->id; ?>"><?= $domain->domain; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Row 3: Admin Page Link / API Main Path / App Key -->
                                <div class="row mb-3">
                                    <div class="col-md-4 form-group">
                                        <label>Admin Page Link</label>
                                        <input type="text" name="admin_page_link" class="form-control">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>API Main Path</label>
                                        <input type="text" name="api_main_path" class="form-control">
                                    </div>

                                    <div class="col-md-4 form-group">
                                        <label>App Key</label>
                                        <input type="text" name="app_key" class="form-control">
                                    </div>
                                </div>

                                <!-- Row 4: Note -->
                                <div class="row mb-3">
                                    <div class="col-md-4 form-group">
                                        <label>Note</label>
                                        <input type="text" name="note" class="form-control">
                                    </div>
                                </div>


                               
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add Platforms -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="mb-3"><?= $this->lang->line('add_platforms') ?: 'Add Platforms' ?></h5>
                                <div id="platforms-container"></div>
                                <button type="button" class="btn btn-primary btn-sm mt-2" id="add-platform-btn">
                                    <i class="fas fa-plus me-1"></i> <?= $this->lang->line('add_platform') ?: 'Add Platform' ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
 <!-- Submit / Cancel -->
                                <div class="text-end mt-4">
                                    <a href="<?= site_url('mobile'); ?>" class="btn btn-danger ms-2">
                                        <i class="fas fa-arrow-left me-2"></i> <?= $this->lang->line('back'); ?>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-host">
                                        <i class="fas fa-save me-2"></i> <?= $this->lang->line('save'); ?>Save
                                    </button>
                                </div>
                                <?= form_close(); ?>
            </div> <!-- content-wrapper -->
        </div> <!-- main-panel -->

        <?php $this->load->view('includes/javascript'); ?>

       <script>
$(document).ready(function() {
    let platformCount = 0;

    function updatePlatformOptions() {
        // Get all selected platform IDs
        let selected = [];
        $('.platform-row select').each(function(){
            const val = $(this).val();
            if(val) selected.push(val);
        });

        // Disable selected options in other selects
        $('.platform-row select').each(function(){
            const current = $(this).val();
            $(this).find('option').each(function(){
                if($(this).val() === "") return;
                if($(this).val() !== current && selected.includes($(this).val())){
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('disabled', false);
                }
            });
        });
    }

    function addPlatformRow(data = {}) {
        platformCount++;
        const rowId = 'platform-row-' + platformCount;
        const email = data.platform_email || '';
        const password = data.platform_password || '';
        const platformId = data.platform_id || '';

        const html = `
            <div class="row mb-2 platform-row" id="${rowId}">
                <div class="col-md-4">
                    <select name="platforms[${platformCount}][platform_id]" class="form-select platform-select" required>
                        <option value="">-- Select Platform --</option>
                        <?php foreach($platforms as $p): ?>
                        <option value="<?= $p->id; ?>" ${platformId == '<?= $p->id ?>' ? 'selected' : ''}>
                            <?= $p->app_platform ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="email" name="platforms[${platformCount}][platform_email]" class="form-control" placeholder="Platform Email" value="${email}" required>
                </div>
                <div class="col-md-3">
                    <input type="password" name="platforms[${platformCount}][platform_password]" class="form-control" placeholder="Platform Password" value="${password}" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-platform-btn">&times;</button>
                </div>
            </div>
        `;
        $('#platforms-container').append(html);
        updatePlatformOptions();
    }

    // Add default row
    addPlatformRow();

    // Add new platform row
    $('#add-platform-btn').click(function() {
        addPlatformRow();
    });

    // Remove row
    $(document).on('click', '.remove-platform-btn', function() {
        $(this).closest('.platform-row').remove();
        updatePlatformOptions();
    });

    // Update options whenever a platform is changed
    $(document).on('change', '.platform-select', function() {
        updatePlatformOptions();
    });

    // AJAX submission
      $('#mobileAddForm').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        const formData = form.serialize();

        $('button[type=submit]').prop('disabled', true).html('Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                if(response.success){
                    const mobile_id = response.mobile_id;
                    const ajaxCalls = [];

                    $('.platform-row').each(function(){
                        const row = $(this);
                        const platform_id = row.find('select').val();
                        const platform_email = row.find('input[name*="platform_email"]').val();
                        const platform_password = row.find('input[name*="platform_password"]').val();

                        ajaxCalls.push($.post('<?= site_url("applications/add") ?>',
                            {
                                mobile_id: mobile_id,
                                platform_id: platform_id,
                                email: platform_email,
                                password: platform_password
                            },
                            null,'json'
                        ));
                    });

                    $.when.apply($, ajaxCalls).done(function(){
                        $('button[type=submit]').prop('disabled', false).html('<i class="fas fa-save me-2"></i> <?= $this->lang->line('save'); ?>');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Mobile user and platforms added successfully!'
                        });

                        form[0].reset();
                        $('#platforms-container').empty();
                        addPlatformRow();
                    });

                } else {
                    $('button[type=submit]').prop('disabled', false).html('<i class="fas fa-save me-2"></i> <?= $this->lang->line('save'); ?>');

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr){
                console.log(xhr.responseText);
                $('button[type=submit]').prop('disabled', false).html('<i class="fas fa-save me-2"></i> <?= $this->lang->line('save'); ?>');

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