<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Aplikasi PT.Citra Putra Kebun Asri</title>

  <!-- Custom fonts for this template -->
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">

  <!-- Core plugin JavaScript-->

  <!-- Custom scripts for all pages-->

  <!-- Page level plugins -->
  <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

  <!-- Page level custom scripts -->
  <script src="<?= base_url('assets/js/demo/datatables-demo.js') ?>"></script>
  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="<?= base_url('assets/plugins/sweet-alert2/sweetalert2.min.css') ?>">
  <script src="<?= base_url('assets/plugins/sweet-alert2/sweetalert2.min.js') ?>"></script>

  <!-- Custom styles for this page -->
  <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/js/toastr/toastr.min.css') ?>" rel="stylesheet">
  <script src="<?= base_url('assets/js/toastr/toastr.min.js') ?>"></script>


</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/') ?>">
        <!--  -->
        <div class="sidebar-brand-icon rotate-n-15">
          <img src="<?= base_url('assets/img/logo-sm.png') ?>" alt="" width="40">
        </div>
        <div class="sidebar-brand-text mx-3">PT. CPKA</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
  <?php if (is_admin()) : ?>
  <li class="nav-item  <?= $this->uri->segment(1) == 'home' ? 'active' : '' ?>">
      <a class="nav-link" href="<?= base_url('home') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>MENU UTAMA</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Master Data
      </div>
      <li class="nav-item <?= $this->uri->segment(1) == 'barang' ? 'active' : '' ?>">
        <a class="nav-link" href="<?=site_url('barang')?>">
          <i class="fas fa-fw fa-box"></i>
          <span>Barang</span></a>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'customer' ? 'active' : '' ?>">
        <a class="nav-link" href="<?=site_url('customer')?>">
          <i class="fas fa-fw fa-briefcase
"></i>
          <span>Customer</span></a>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'supplier' ? 'active' : '' ?>">
        <a class="nav-link" href="<?=site_url('supplier')?>">
          <i class="fas fa-fw fa-store-alt"></i>
          <span>Supplier</span></a>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'karyawan' ? 'active' : '' ?>">
        <a class="nav-link" href="<?=site_url('karyawan')?>">
          <i class="fas fa-fw fa-users"></i>
          <span>Karyawan</span></a>
      </li>

      </li>

        <!-- Heading -->
      <div class="sidebar-heading">
        Transaksi
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?= $this->uri->segment(1) == 'barang-masuk' || $this->uri->segment(1) == 'barang-keluar' || $this->uri->segment(1) == 'barang-retur' || $this->uri->segment(1) == 'barang-jual' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transaksi" aria-expanded="true" aria-controls="transaksi">
          <i class="fas fa-fw fa-luggage-cart"></i>
          <span>Transaksi Barang</span>
        </a>
        <div id="transaksi" class="collapse <?= $this->uri->segment(1) == 'barang-masuk' || $this->uri->segment(1) == 'barang-keluar' || $this->uri->segment(1) == 'barang-retur' || $this->uri->segment(1) == 'barang-jual' ? 'show' : '' ?>" aria-labelledby="headingTransaksi" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $this->uri->segment(1) == 'barang-masuk' ? 'active' : '' ?>" href="<?=site_url('barang-masuk')?>">Barang Masuk</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'barang-keluar' ? 'active' : '' ?>" href="<?=site_url('barang-keluar')?>">Barang Keluar</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'barang-retur' ? 'active' : '' ?>" href="<?=site_url('barang-retur')?>">Barang Retur</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'barang-jual' ? 'active' : '' ?>" href="<?=site_url('barang-jual')?>">Barang Jual</a>
          </div>
        </div>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'penagihan' || $this->uri->segment(1) == 'tagihan' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#hutang" aria-expanded="true" aria-controls="hutang">
          <i class="fas fa-fw fa-credit-card"></i>
          <span>Hutang Piutang</span>
        </a>
        <div id="hutang" class="collapse <?= $this->uri->segment(1) == 'penagihan' || $this->uri->segment(1) == 'tagihan' ? 'show' : '' ?>" aria-labelledby="headingHutang" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $this->uri->segment(1) == 'tagihan' ? 'active' : '' ?>" href="<?= site_url('tagihan') ?>">Tagihan</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'penagihan' ? 'active' : '' ?>" href="<?= site_url('penagihan') ?>">Penagihan</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <?php endif; ?>
      <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
        Laporan
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?= $this->uri->segment(1) == 'laporan-customer' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-supplier' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang-masuk' && $this->uri->segment(2) == 'laporan'  || $this->uri->segment(1) == 'laporan-barang-keluar' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang-retur' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang-jual' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-penagihan' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-penagihan-jatuh-tempo' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-tagihan' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-tagihan-jatuh-tempo' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true" aria-controls="laporan">
          <i class="fas fa-fw fa-print"></i>
          <span>Laporan</span>
        </a>
        <div id="laporan" class="collapse <?= $this->uri->segment(1) == 'laporan-customer' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-supplier' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang-masuk' && $this->uri->segment(2) == 'laporan'  || $this->uri->segment(1) == 'laporan-barang-keluar' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang-retur' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-barang-jual' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-penagihan' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-penagihan-jatuh-tempo' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-tagihan' && $this->uri->segment(2) == 'laporan' || $this->uri->segment(1) == 'laporan-tagihan-jatuh-tempo' && $this->uri->segment(2) == 'laporan' ? 'show' : '' ?>" aria-labelledby="headingLaporan" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-customer' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-customer/laporan') ?>">Kerjasama Customer</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-supplier' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-supplier/laporan') ?>">Kerjasama Supplier</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-barang' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-barang/laporan') ?>" target="_blank">Stok Barang</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-barang-masuk' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-barang-masuk/laporan') ?>">Barang Masuk</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-barang-keluar' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-barang-keluar/laporan') ?>">Barang Keluar</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-barang-retur' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-barang-retur/laporan') ?>">Barang Retur</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-barang-jual' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-barang-jual/laporan') ?>">Barang Jual</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-penagihan' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-penagihan/laporan') ?>">Penagihan</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-penagihan-jatuh-tempo' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-penagihan-jatuh-tempo/laporan') ?>">Penagihan Jatuh Tempo</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-tagihan' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-tagihan/laporan') ?>">Tagihan</a>
            <a class="collapse-item <?= $this->uri->segment(1) == 'laporan-tagihan-jatuh-tempo' && $this->uri->segment(2) == 'laporan' ? 'active' : '' ?>" href="<?= site_url('laporan-tagihan-jatuh-tempo/laporan') ?>">Tagihan Jatuh Tempo</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Tables -->
      <?php if (is_admin()) : ?>
      <li class="nav-item <?= $this->uri->segment(1) == 'user' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= site_url('user') ?>">
          <i class="fas fa-fw fa-user"></i>
          <span>Pengguna</span></a>
      </li>

      <li class="nav-item <?= $this->uri->segment(1) == 'sms' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= site_url('sms') ?>">
          <i class="fas fa-fw fa-envelope"></i>
          <span>Kirim Pesan</span></a>
      </li>
      <?php endif;?>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hi, <?= $this->session->userdata('name') ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url('assets/img/avatar3.png') ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= site_url('auth/logout') ?>">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
