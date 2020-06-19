<div class="container-fluid">
    <h1 class="h4 mb-2 text-gray-800">DATA BARANG JUAL</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('barang-jual/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;">No</th>
                            <th>Kode Jual</th>
                            <th>Tanggal Jual</th>
                            <th>Tanggal Tempo</th>
                            <th>Customer</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Total + (PPN 10%)</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php $total = 0 ?>
                        <?php foreach($BarangJual as $jual) : ?>
                            <?php if($jual['jatuh_tempo'] > 0 and $jual['jatuh_tempo'] <= 7) : ?>
                            <tr class="table-warning">
                            <?php elseif ($jual['jatuh_tempo'] < 0 and $jual['jatuh_tempo'] >= -7) : ?>
                            <tr class="table-danger">
                            <?php elseif ($jual['jatuh_tempo'] == 0) : ?>
                            <tr class="table-info">
                            <?php else : ?>
                            <tr>
                            <?php endif; ?>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $jual['kodeBarangJual'] ?></td>
                            <td><?= date('d M Y', strtotime($jual['tglJual'])) ?></td>
                            <td><?= date('d M Y', strtotime($jual['tglTempo'])) ?></td>
                            <td><?= $jual['Nama_Customer'] ?></td>
                            <td><?= $jual['namaBarangJual'] ?></td>
                            <td><?= $jual['jumlahJual'].' '.$jual['satuan'] ?></td>
                            <td><?= rupiah($jual['hargaJual']) ?></td>
                            <?php
                                $total = intval($jual['total']);
                                $ppn = 0.1;
                                $hitung_ppn = $total * $ppn;
                                $subtotal = $total + $hitung_ppn;
                            ?>
                            <td><?= rupiah($subtotal) ?></td>
                            <td>
                                <a href="<?= site_url('barang-jual/edit/').$jual['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('barang-jual/delete/').$jual['id'] ?>" class="btn btn-circle btn-sm btn-danger " data-id="<?= $jual['id'] ?>" id="hapus-barang-jual" data-title="<?= $jual['kodeBarangJual'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-barang-jual', function(e) {
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
                    url: "<?= site_url('barang-jual/delete/') ?>" + id,
                    method: "post",
                    datatype: "json",
                    success: function() {
                        swal(
                            'Deleted!',
                            'Data berhasil dihapus',
                            'success'
                        )
                    window.location.href="<?= site_url('BarangJual'); ?>";
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