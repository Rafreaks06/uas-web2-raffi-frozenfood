    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="sidebar-brand-text mx-3">USER</div>
        </a>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('user/dashboard') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Menu User</div>

        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('user/produk') ?>">
                <i class="fas fa-box"></i>
                <span>Produk</span>
            </a>
        </li>
        <li class="nav-item">
        <a href="<?= base_url('user/order'); ?>" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            <span>Order Online</span>
        </a>
    </li>


        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('Auth/logout') ?>">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>

    </ul>
