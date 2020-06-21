<div class="container-fluid">
    <h1 class="h4 mb-2 text-gray-800">DATA STOK BARANG</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('barang/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;" class="text-center">No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1;?>
                        <?php foreach($barang as $item) : ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $item['kodeBarang'] ?></td>
                            <td><?= $item['namaBarang'] ?></td>
                            <td><?= $item['satuan'] ?></td>
                            <td><?= $item['stok'] ?></td>
                            <td><?= rupiah($item['hargaBeli']) ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('barang/edit/').$item['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('barang/delete/').$item['id'] ?>" class="btn btn-circle btn-sm btn-danger" data-id="<?= $item['id'] ?>" id="hapus-barang" data-title="<?= $item['namaBarang'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-barang', function(e) {
        e.preventDefault();
        id = $(this).data('id');
        var title = $(this).data('title');
        swal({
            title: 'Apakah kamu yakin ingin menghapus "'+title+'" ?',
            text: "Data yang terhapus tidak dapat dikembalikan!",
            type: 'Warning',
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
                    url: "<?= site_url('barang/delete/') ?>" + id,
                    method: "post",
                    datatype: "json",
                    success: function() {
                        swal(
                            'Deleted!',
                            'Data berhasil dihapus',
                            'success'
                        )
                    window.location.href="<?= site_url('barang'); ?>";
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