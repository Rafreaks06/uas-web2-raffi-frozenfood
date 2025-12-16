<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-box-open"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Frozen Food</div>
    </a>

    <hr class="sidebar-divider">

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Master Data</div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/supplier'); ?>">
            <i class="fas fa-truck"></i>
            <span>Supplier</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/kategori') ?>">
            <i class="fas fa-list"></i>
            <span>Kategori</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/produk'); ?>">
            <i class="fas fa-drumstick-bite"></i>
            <span>Produk</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/customer'); ?>">
            <i class="fas fa-users"></i>
            <span>Customer</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Transaksi</div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/order-offline'); ?>">
            <i class="fas fa-cash-register"></i>
            <span>Order Offline</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/order-online'); ?>">
            <i class="fas fa-globe"></i>
            <span>Order Online</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Laporan</div>

    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">
            <i class="fas fa-file-alt"></i>
            <span>Laporan Penjualan</span>
        </a>
    </li>
    
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
