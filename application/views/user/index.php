<div class="container-fluid">
  <h1 class="h4 mb-2 text-gray-800">DATA USER</h1>
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <a href="<?=site_url('user/baru')?>" class="btn btn-sm btn-success"> <i class="fa fa-plus-circle"></i> Tambah Data</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-sm table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
                <th style="width: 2px;">No</th>
                <th>Username</th>
                <th>Hak Akses</th>
                <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;?>
            <?php foreach($users as $user) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $user['username'] ?></td>
                <td>
                    <?php if ($user['id_role'] == 1) : ?>
                    <span class="badge badge-success">Admin</span>
                    <?php else : ?>
                    <span class="badge badge-info">Manajer</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <a href="<?= site_url('user/edit/').$user['id'] ?>" class="btn btn-circle btn-sm btn-success"><i class="fa fa-edit"></i></a>
                    <a href="<?= site_url('user/delete/').$user['id'] ?>"  class="btn btn-circle btn-sm btn-danger " data-id="<?= $user['id'] ?>" id="hapus-user" data-title="<?= $user['username'] ?>"><i class="fa fa-trash"></i></a>
                    </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<script type="text/javascript">
$(document).ready( function () {
$(document).on('click', '#hapus-user', function(e) {
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
                url: "<?= site_url('user/delete/') ?>" + id,
                method: "post",
                datatype: "json",
                success: function() {
                    swal(
                        'Deleted!',
                        'Data berhasil dihapus',
                        'success'
                    )
                window.location.href="<?= site_url('user'); ?>";
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