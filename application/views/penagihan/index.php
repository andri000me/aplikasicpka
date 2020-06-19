<div class="container-fluid">
  <h1 class="h4 mb-2 text-gray-800">DATA PENAGIHAN</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('penagihan/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;">No</th>
                            <th class="text-center">Aksi</th>
                            <th>Nomor Penagihan</th>
                            <th>Nomor Penjualan</th>
                            <th>Customer</th>
                            <th>Barang</th>
                            <th>Tanggal Penjualan</th>
                            <th>Jatuh Tempo</th>
                            <th>Penagihan(PPN10%)</th>
                            <th>Angsuran Perbulan</th>
                            <th>Sisa Hutang</th>
                            <th>Jangka Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $no = 1;
                            $total = 0;
                        ?>
                        <?php foreach($penagihan as $pg) : ?>
                        <?php
                            $total = $pg['total'];
                            $ppn = 0.1;
                            $hitung_ppn = $total * $ppn;
                            $subtotal = $total + $hitung_ppn;
                        ?>
                        <?php if($pg['status'] == 'Belum Lunas'): ?>
                            <tr class="table-warning">
                        <?php else : ?>
                            <tr class="table-success">
                        <?php endif; ?>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <a href="<?= site_url('penagihan/detail/').$pg['id'] ?>" class="btn btn-circle btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                <a href="<?= site_url('penagihan/edit/').$pg['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-credit-card"></i></a>
                                <a href="<?= site_url('penagihan/delete/').$pg['id'] ?>" class="btn btn-circle btn-sm btn-danger " data-id="<?= $pg['id'] ?>" id="hapus-penagihan" data-title="<?= $pg['kode_penagihan'] ?>"><i class="fa fa-trash"></i></a>
                            </td>
                            <td><?= $pg['kode_penagihan'] ?></td>
                            <td><?= $pg['kode_barang_jual'] ?></td>
                            <td><?= $pg['nama_customer'] ?></td>
                            <td><?= $pg['nama'] ?></td>
                            <td><?= date('d M Y', strtotime($pg['tgl_jual'])) ?></td>
                            <td><?= date('d M Y', strtotime($pg['tgl_tempo'])) ?></td>
                            <td><?= rupiah($subtotal) ?></td>
                            <td><?= rupiah($pg['angsuran_perbulan']) ?></td>
                            <td><?= rupiah($pg['sisa_hutang']) ?></td>
                            <td><?= $pg['jangka_waktu']. ' Bulan' ?></td>
                            <td><?= $pg['status'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready( function () {
    $(document).on('click', '#hapus-penagihan', function(e) {
        e.preventDefault();
        id = $(this).data('id');
        var title = $(this).data('title');
        swal({
            title: 'Apakah kamu yakin ingin menghapus "'+title+'" ?',
            text: "data yang terhapus tidak dapat dikembalikan!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            buttonsStyling: false
        })
        .then((willdelete) => {
            if (willdelete) {
                $.ajax({
                    url: "<?= site_url('penagihan/delete/') ?>" + id,
                    method: "post",
                    datatype: "json",
                    success: function(response) {
                        var response = $.parseJSON(response);
                        if(response.status == 'success') {
                            swal(
                                'Deleted!',
                                'Data berhasil dihapus',
                                'success'
                            )
                            window.location.href="<?= site_url('penagihan'); ?>";
                        } else {
                            swal(
                                'Cancelled',
                                ' "'+title+'" penagihan tidak bisa dihapus, silahkan hapus terlebih dulu data didalamnya',
                                'error'
                            );
                        }
                    },
                    error: function(){
                      swal("oops. something wrong happened.");
                    }
                });
            }
        },
        function(dismiss) {
            if(dismiss == 'cancel') {
                swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        });
    });
  });
</script>