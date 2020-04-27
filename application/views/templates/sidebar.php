        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Pustaka Booking</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

           

            <!-- Looping Menu-->
                <div class="sidebar-heading">
                    Home
                </div>
                    <li class="nav-item active">
                        <!-- Nav Item - Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link pb-0" href="<?= base_url('admin'); ?>">
                                <i class="fa fa-fw fa book"></i>
                                <span>Dashboard</span></a>
                        </li>
                    </li>

                <!-- Divider -->
                <hr class="sidebar-divider mt-3">

                <!-- Heading -->
                <div class="sidebar-heading">
                    Transaksi
                </div>
                    <!-- Nav Item - Dashboard -->
                    <li class="nav-item active">
                        <!-- Nav Item - Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link pb-0" href="<?= base_url('pinjam'); ?>">
                                <i class="fa fa-fw fa-shopping-cart"></i>
                                <span>Data Peminjaman</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link pb-0" href="<?= base_url('pinjam/daftarbooking'); ?>">
                                <i class="fa fa-fw fa-list"></i>
                                <span>Data Booking</span></a>
                        </li>
                        </li>
                <!-- Divider -->
                <hr class="sidebar-divider mt-3">

        </ul>
        <!-- End of Sidebar --   > 
        
        