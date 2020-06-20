
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h4 mb-0 text-gray-800">MENU UTAMA</h1>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"><a href="<?= site_url('barang-masuk
              ') ?>">Barang Masuk</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_barang_masuk['total'] ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><a href="<?= site_url('barang-keluar') ?>">Barang Keluar</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_barang_keluar['total'] ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"><a href="<?= site_url('barang-jual') ?>">Transaksi Jual</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_barang_jual['total'] ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-cart-plus fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1"> <a href="<?= site_url('tagihan') ?>">Tagihan</a></div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_tagihan['total'] ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-credit-card fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-12">
      <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Jatuh Tempo Penagihan</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Nomor Penagihan</th>
                <th>Nomor Penjualan</th>
                <th>Nama Customer</th>
                <th>Telp</th>
                <th>Tanggal Jatuh Tempo</th>
                <th>Jatuh Tempo</th>
                <th>Aksi</th>
              </tr>

            </thead>
            <tbody>
              <?php foreach ($data_penagihan as $penagihan) : ?>
                <?php if($penagihan['jatuh_tempo'] >= -7 && $penagihan['jatuh_tempo'] < 0 && $penagihan['jatuh_tempo'] <= 7) : ?>
                <?php if($penagihan['jatuh_tempo'] > 0 and $penagihan['jatuh_tempo'] <= 7) : ?>
                <tr class="table-warning">
                <?php elseif ($penagihan['jatuh_tempo'] < 0 and $penagihan['jatuh_tempo'] >= -7) : ?>
                <tr class="table-danger">
                <?php elseif ($penagihan['jatuh_tempo'] == 0) : ?>
                <tr class="table-info">
                <?php else : ?>
                <tr>
                <?php endif; ?>
                <td><?= $penagihan['kode_penagihan'] ?></td>
                <td><?= $penagihan['kode_jual'] ?></td>
                <td><?= $penagihan['customer'] ?></td>
                <td><?= $penagihan['telp'] ?></td>
                <td><?= tgl_indo($penagihan['tanggal']) ?></td>
                <td><?= $penagihan['jatuh_tempo']. ' Hari lagi' ?></td>
                <td>
                  <a href="<?= site_url('sms') ?>" class="btn btn-sm btn-primary"><i class="fa fa-envelope"></i></a>
                </td>
              </tr>
              <?php endif; ?>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
    </div>

    <div class="col-xl-12">
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary text-center">Jatuh Tempo Tagihan</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-sm table-bordered" id="dataTable1" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Nomor Tagihan</th>
                  <th>Nomor Pembelian</th>
                  <th>Nama Supplier</th>
                  <th>Telp</th>
                  <th>Tanggal Jatuh Tempo</th>
                  <th>Jatuh Tempo</th>
                </tr>

              </thead>
              <tbody>
                <?php foreach ($data_tagihan as $tagihan) : ?>
                  <?php if($tagihan['jatuh_tempo'] >= -7 && $tagihan['jatuh_tempo'] < 0 && $tagihan['jatuh_tempo'] <= 7) : ?>
                  <?php if($tagihan['jatuh_tempo'] > 0 and $tagihan['jatuh_tempo'] <= 7) : ?>
                  <tr class="table-warning">
                  <?php elseif ($tagihan['jatuh_tempo'] < 0 and $tagihan['jatuh_tempo'] >= -7) : ?>
                  <tr class="table-danger">
                  <?php elseif ($tagihan['jatuh_tempo'] == 0) : ?>
                  <tr class="table-info">
                  <?php else : ?>
                  <tr>
                  <?php endif; ?>
                  <td><?= $tagihan['kode_tagihan'] ?></td>
                  <td><?= $tagihan['kode_masuk'] ?></td>
                  <td><?= $tagihan['supplier'] ?></td>
                  <td><?= $tagihan['telp'] ?></td>
                  <td>
                      <?php if($tagihan['tanggal'] == '0000-00-00') : ?>
                          Lunas
                      <?php else : ?>
                      <?= tgl_indo($tagihan['tanggal']) ?>
                      <?php endif; ?>
                  </td>
                  <td><?= $tagihan['jatuh_tempo']. ' Hari lagi' ?></td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->