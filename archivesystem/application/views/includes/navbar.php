<!-- application/views/includes/navbar.php -->
<nav class="navbar navbar-expand-lg custom-navbar fixed-top px-3">
    <!-- Brand -->
    <a class="navbar-brand d-flex align-items-center ms-3">
        <img src="<?= base_url('assets/images/logo-nav.png'); ?>" 
             alt="Logo" 
             style="max-height: 60px; height: auto; width: auto;" 
         class="rounded-circle me-2">
    </a>

    <!-- Sidebar toggle button -->
    <button class="sidebar-toggle ms-4 me-4" id="sidebarToggle">
        <i class="bi bi-list fs-2"></i>
    </button>

    <!-- Right side menu -->
    <div class="ms-auto d-flex align-items-center">
        <!-- Profile dropdown -->
        <div class="dropdown">
           
               <div class="d-flex ms-auto">
             <!-- Logout Button (small and subtle) -->
  <a href="<?= base_url('Auth/logout'); ?>" 
   class="d-inline-block" 
   style="cursor: pointer; color: inherit;">
  <img src="<?= base_url('assets/images/logout.png'); ?>" 
       alt="Logout" 
       style="height: 24px; width:auto; object-fit: contain;" />
</a>
        </div>
        </div>
    </div>
</nav>
