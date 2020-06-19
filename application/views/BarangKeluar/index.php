<div class="container-fluid">
    <h2 class="h4 mb-2 text-gray-800">DATA BARANG KELUAR</h2>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('barang-keluar/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;">No</th>
                            <th>Kode Keluar</th>
                            <th>Tanggal Barang Keluar</th>
                            <th>Karyawan</th>
                            <th>Keterangan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                        <?php $total = 0 ?>
                        <?php foreach($barang_keluar as $keluar) : ?>
                            <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= $keluar['kode_keluar'] ?></td>
                            <td><?= date('d M Y', strtotime($keluar['tgl_keluar'])) ?></td>
                            <td><?= $keluar['nama_karyawan'] ?></td>
                            <td><?= $keluar['keterangan'] ?></td>
                            <td class="text-center">
                                <a href="<?= site_url('barang-keluar/detail/').$keluar['id'] ?>" class="btn btn-circle btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                <a href="<?= site_url('barang-keluar/edit/').$keluar['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('barang-keluar/delete/').$keluar['id'] ?>" class="btn btn-circle btn-sm btn-danger " data-id="<?= $keluar['id'] ?>" id="hapus-barang-keluar" data-title="<?= $keluar['kode_keluar'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-barang-keluar', function(e) {
        e.preventDefault();
        id = $(this).data('id');
        var title = $(this).data('title');
        swal({
            title: 'Apakah kamu yakin ingin menghapus "'+title+'" ?',
            text: "data yang terhapus tidak dapat dikembalikan!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus ',
            cancelButtonText: 'Batal',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            buttonsStyling: false
        })
        .then((willdelete) => {
            if (willdelete) {
                $.ajax({
                    url: "<?= site_url('barang-keluar/delete/') ?>" + id,
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
                            window.location.href="<?= site_url('barang-keluar'); ?>";
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