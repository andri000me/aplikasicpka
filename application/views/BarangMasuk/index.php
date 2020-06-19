<div class="container-fluid">
    <h2 class="h4 mb-2 text-gray-800">DATA BARANG MASUK</h2>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('barang-masuk/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;">No</th>
                            <th>Kode Masuk</th>
                            <th>Tanggal Barang Masuk</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Supplier</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php $total = 0 ?>
                        <?php foreach($barang_masuk as $masuk) : ?>
                            <?php if($masuk['jatuh_tempo'] > 0 and $masuk['jatuh_tempo'] <= 7) : ?>
                            <tr class="table-warning">
                            <?php elseif ($masuk['jatuh_tempo'] < 0 and $masuk['jatuh_tempo'] >= -7) : ?>
                            <tr class="table-danger">
                            <?php elseif ($masuk['jatuh_tempo'] == 0) : ?>
                            <tr class="table-info">
                            <?php else : ?>
                            <tr>
                            <?php endif; ?>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $masuk['kode_masuk'] ?></td>
                            <td><?= date('d M Y', strtotime($masuk['tgl_masuk'])) ?></td>
                            <td><?= date('d M Y', strtotime($masuk['tgl_tempo'])) ?></td>
                            <td><?= $masuk['nama_supplier'] ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('barang-masuk/detail/').$masuk['id'] ?>" class="btn btn-circle btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                <a href="<?= site_url('barang-masuk/edit/').$masuk['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('barang-masuk/delete/').$masuk['id'] ?>" class="btn btn-circle btn-sm btn-danger " data-id="<?= $masuk['id'] ?>" id="hapus-barang-masuk" data-title="<?= $masuk['kode_masuk'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-barang-masuk', function(e) {
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
                    url: "<?= site_url('barang-masuk/delete/') ?>" + id,
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
                            window.location.href="<?= site_url('barang-masuk'); ?>";
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