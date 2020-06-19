<div class="container-fluid">
  <h1 class="h4 mb-2 text-gray-800">DATA TAGIHAN</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('tagihan/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"> Tambah Data</i></a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;">No</th>
                            <th class="text-center">Aksi</th>
                            <th>Nomor Tagihan</th>
                            <th>Nomor Pembelian</th>
                            <th>Supplier</th>
                            <th>Tanggal Pembelian</th>
                            <th>Jatuh Tempo</th>
                            <th>Nomor Retur</th>
                            <th>Tagihan(10%)</th>
                            <th>Retur</th>
                            <th>Angsuran Perbulan</th>
                            <th>Sisa Hutang</th>
                            <th>Jangka Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach($tagihan as $tagih) : ?>
                        <?php 
                            $total = $tagih['subtotal'];
                            $ppn = 0.1;
                            $hitung_ppn = $total * $ppn;
                            $subtotal = $total + $hitung_ppn;
                        ?>
                        <tr>
                        <?php if($tagih['status'] == 'Belum Lunas'): ?>
                            <tr class="table-warning">
                        <?php else : ?>
                            <tr class="table-success">
                        <?php endif; ?>
                            <td class="text-center"><?= $no++; ?></td>
                            <td>
                                <a href="<?= site_url('tagihan/detail/').$tagih['id'] ?>" class="btn btn-circle btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                <a href="<?= site_url('tagihan/edit/').$tagih['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-credit-card"></i></a>
                                <a href="<?= site_url('tagihan/delete/').$tagih['id'] ?>" class="btn btn-circle btn-sm btn-danger " data-id="<?= $tagih['id'] ?>" id="hapus-tagihan" data-title="<?= $tagih['kode_tagihan'] ?>"><i class="fa fa-trash"></i></a>
                            </td>
                            <td><?= $tagih['kode_tagihan'] ?></td>
                            <td><?= $tagih['kode_barang_masuk'] ?></td>
                            <td><?= $tagih['nama_supplier'] ?></td>
                            <td><?= tgl_indo($tagih['tgl_masuk']) ?></td>
                            <td><?= tgl_indo($tagih['tgl_tempo']) ?></td>
                            <td class="text-center"> 
                                <?php if($tagih['no_retur'] == '') : ?>
                                    <span class="badge badge-info">tidak ada retur</span>
                                <?php else : ?>
                                    <?= $tagih['no_retur'] ?>
                                <?php endif; ?>
                            </td>
                            <td><?= rupiah($subtotal) ?></td>
                            <td><?= rupiah($tagih['jumlah_retur']) ?></td>
                            <td><?= rupiah($tagih['angsuran_perbulan']) ?></td>
                            <td><?= rupiah($tagih['sisa_hutang']) ?></td>
                            <td><?= $tagih['jangka_waktu']. ' Bulan' ?></td>
                            <td><?= $tagih['status'] ?></td>
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
                    success: function(response) {
                        var response = $.parseJSON(response);
                        if(response.status == 'success') {
                            swal(
                                'Deleted!',
                                'Data berhasil dihapus',
                                'success'
                            )
                            window.location.href="<?= site_url('tagihan'); ?>";
                        } else {
                            swal(
                                'Cancelled',
                                ' "'+title+'" masih memiliki barang, silahkan hapus barang terlebih dahulu',
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