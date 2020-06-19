<div class="container-fluid">
  <h1 class="h3 mb-2 text-gray-800">DATA TAGIHAN</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('tagihan/baru')?>" class="btn btn-success"> <i class="fa fa-plus"> Tambah Data</i></a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Masuk</th>
                            <th>Tempo</th>
                            <th>Supplier</th>
                            <th>Kode Barang</th>
                            <th>Barang</th>
                            <th>Retur</th>
                            <th>Uang Retur</th>
                            <th>Total Harga</th>
                            <th>PPN</th>
                            <th>Total Tagihan</th>
                            <th>Terbayar</th>
                            <th>Keterlambatan</th>
                            <th>Denda</th>
                            <th>Hutang</th>
                            <th>Bukti Pembayaran</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php $totalTagihan = 0; ?>
                        <?php foreach($tagihan as $tg) : ?>
                        <tr>
                        <?php $totalRetur = $tg['hargaBeli'] * $tg['jumlahRetur']; ?>
                        <?php $totalHarga = ($tg['hargaBeli'] * $tg['jumlahMasuk'])- $totalRetur; ?>
                        <?php $totalTagihan = $totalHarga + ($totalHarga*0.1)?>
                        <?php $hutang = $totalTagihan - $tg['jumlahPembayaran'] ?>
                        <?php $totalHutang = $tg['denda'] + $hutang ?>

                            <td><?= $no++; ?></td>
                            <td><?= date('d M Y', strtotime($tg['tglMasuk'])) ?></td>
                            <td><?= date('d M Y', strtotime($tg['tglTempo'])) ?></td>
                            <td><?= $tg['nama_supplier'] ?></td>
                            <td><?= $tg['kode_barang'] ?></td>
                            <td><?= $tg['nama_barang'] ?></td>
                            <td>
                                <?php if ($tg['jumlahRetur'] <= 0) : ?>
                                    <p>Tidak Ada Retur</p>
                                <?php elseif($tg['jumlahRetur'] > 0) : ?>
                                    <p><?= $tg['jumlahRetur'] ?></p>
                                <?php endif; ?>
                            </td>
                            <td>Rp. <?= number_format($totalRetur,0,".",".") ?></td>
                            <td>Rp. <?= number_format($totalHarga,0,".",".") ?></td>
                            <td><?= $tg['ppn'] ?></td>
                            <td>Rp. <?= number_format($totalTagihan,0,".",".") ?></td>
                            <td>Rp. <?= number_format($tg['jumlahPembayaran'],0,".",".") ?></td>
                            <td>Rp. <?=  $tg['keterlambatan'] ?></td>
                            <td>Rp. <?= number_format($tg['denda'],0,".",".") ?></td>
                            <td>
                                    <?php if ($totalHutang <= 0) : ?>
                                        <p>Lunas</p>
                                    <?php elseif($totalHutang > 0) : ?>
                                        <p>Rp. <?= number_format($totalHutang,0,".",".") ?></p>
                                    <?php endif?>
                            </td>
                            <td><?= $tg['kodeTagihan'] ?></td>
                            <td>
                                <a href="<?= site_url('tagihan/edit/').$tg['id'] ?>" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('tagihan/delete/').$tg['id'] ?>" class="btn btn-danger " data-id="<?= $tg['id'] ?>" id="hapus-tagihan" data-title="<?= $tg['kodeTagihan'] ?>"><i class="fa fa-trash"></i></a>
                            </td>
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
    $(document).on('click', '#hapus-tagihan', function(e) {
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
                    url: "<?= site_url('tagihan/delete/') ?>" + id,
                    method: "post",
                    datatype: "json",
                    success: function() {
                        swal(
                            'Deleted!',
                            'Data berhasil dihapus',
                            'success'
                        )
                    window.location.href="<?= site_url('tagihan'); ?>";
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