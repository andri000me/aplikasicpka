<div class="container-fluid">
  <h1 class="h4 mb-2 text-gray-800">DATA BARANG RETUR</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('barang-retur/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 2px;" >No</th>
                            <th>Kode Retur</th>
                            <th>Tanggal</th>
                            <th>Supplier</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;?>
                       <?php $total = 0 ?>
                        <?php foreach($barang_retur as $retur) : ?>
                        <tr>
                            <td class="text-center" ><?= $no++; ?></td>
                            <td><?= $retur['kode_retur'] ?></td>
                            <td><?= date('d M Y', strtotime($retur['tgl_retur'])) ?></td>
                            <td><?= $retur['nama_supplier'] ?></td>
                            <td class="text-center">
                                 <a href="<?= site_url('barang-retur/detail/').$retur['id'] ?>" class="btn btn-circle btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                <a href="<?= site_url('barang-retur/edit/').$retur['id'] ?>" class="btn btn-sm btn-circle btn-success"><i class="fa fa-edit"></i></a>
                                <a href="<?= site_url('barang-retur/delete/').$retur['id'] ?>" class="btn btn-circle btn-sm btn-danger " data-id="<?= $retur['id'] ?>" id="hapus-barang-retur" data-title="<?= $retur['kode_retur'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-barang-retur', function(e) {
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
                    url: "<?= site_url('barang-retur/delete/') ?>" + id,
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
                            window.location.href="<?= site_url('barang-retur'); ?>";
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