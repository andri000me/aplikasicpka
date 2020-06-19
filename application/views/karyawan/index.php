<div class="container-fluid">
    <h1 class="h4 mb-2 text-gray-800">DATA KARYAWAN</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('karyawan/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;">No</th>
                            <th>NIK</th>
                            <th>Nama Penanggung Jawab</th>
                            <th>No Telepon</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php foreach($karyawan as $kry) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $kry['nik'] ?></td>
                            <td><?= $kry['namaKaryawan'] ?></td>
                            <td><?= $kry['noTelp'] ?></td>
                                <td class="text-center">
                                <a href="<?= site_url('karyawan/edit/').$kry['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('karyawan/delete/').$kry['id'] ?>" class="btn btn-circle btn-sm btn-danger" data-id="<?= $kry['id'] ?>" id="hapus-karyawan" data-title="<?= $kry['namaKaryawan'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-karyawan', function(e) {
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
                    url: "<?= site_url('karyawan/delete/') ?>" + id,
                    method: "post",
                    datatype: "json",
                    success: function() {
                        swal(
                            'Deleted!',
                            'Data berhasil dihapus',
                            'success'
                        )
                    window.location.href="<?= site_url('karyawan'); ?>";
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