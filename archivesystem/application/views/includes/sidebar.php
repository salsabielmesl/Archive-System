<div id="sidebar" class="sidebar shadow-sm">
    <ul class="nav flex-column pt-4">
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(1) == 'customers') ? 'active' : '' ?>" 
               href="<?= base_url('customers'); ?>">
                <i class="bi bi-people me-2"></i> Customers
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(1) == 'web') ? 'active' : '' ?>" 
               href="<?= base_url('web'); ?>">
                <i class="bi bi-globe me-2"></i> Web
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(1) == 'mobile') ? 'active' : '' ?>" 
               href="<?= base_url('mobile'); ?>">
                <i class="bi bi-phone me-2"></i> Mobile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(1) == 'platforms') ? 'active' : '' ?>" 
               href="<?= base_url('platforms'); ?>">
                <i class="bi bi-cloud me-2"></i> Platforms
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($this->uri->segment(1) == 'hosting_services') ? 'active' : '' ?>" 
               href="<?= base_url('hosting_services'); ?>">
                <i class="bi bi-server me-2"></i> Hosting Services
            </a>
        </li>
    </ul>
</div>
