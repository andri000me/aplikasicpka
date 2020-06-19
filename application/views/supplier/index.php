<div class="container-fluid">
    <h1 class="h4 mb-2 text-gray-800">DATA SUPPLIER</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?=site_url('supplier/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th style="width: 2px;">No</th>
                        <th>Nama Perusahan</th>
                        <th>Penanggung Jawab</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Tanggal Persetujuan</th>
                        <th class="text-center">Berkas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;?>
                    <?php foreach($supplier as $cs) : ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $cs['namaSupplier'] ?></td>
                        <td><?= $cs['penanggungJawab'] ?></td>
                        <td><?= $cs['telp'] ?></td>
                        <td><?= $cs['alamat'] ?></td>
                        <td><?= date('d M Y', strtotime($cs['tglPersetujuan'] ))?></td>
                        <td>
                            <?php if ($cs['berkas'] == true) : ?>
                            <div class="text-center">
                                <a target="_blank" href="<?= base_url('upload/supplier/').$cs['berkas'] ?>" class="btn btn-circle btn-sm btn-info">
                                    <i class="fa fa-file-pdf"></i>
                                </a>
                            </div>
                            <?php else : ?>
                            <div class="text-center">
                                <a target="_blank" class="btn btn-circle btn-sm btn-info">
                                    <i class="fa fa-file-pdf"></i>
                                </a>
                            </div>
                            <?php endif ?>
                        </td>
                        <td class="text-center">
                            <a href="<?= site_url('supplier/edit/').$cs['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                            <a href="<?= site_url('supplier/delete/').$cs['id'] ?>"  class="btn btn-circle btn-sm btn-danger " data-id="<?= $cs['id'] ?>" id="hapus-supplier" data-title="<?= $cs['namaSupplier'] ?>"><i class="fa fa-trash"></i></a>
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
    $(document).on('click', '#hapus-supplier', function(e) {
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
                    url: "<?= site_url('supplier/delete/') ?>" + id,
                    method: "post",
                    datatype: "json",
                    success: function() {
                        swal(
                            'Deleted!',
                            'Data berhasil dihapus',
                            'success'
                        )
                    window.location.href="<?= site_url('supplier'); ?>";
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