<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <h3>
                Edit User
                <a href="<?= site_url('user') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
              </h3>
              <hr>
            </div>            
            <form id="user-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="hidden" name="id" value="<?= $edit_user['id']?>">
                    <input type="text" name="username" class="form-control" placeholder="Isikan Username" value="<?= $edit_user['username']?>">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Isikan Password">
                  </div>
                </div>                

                <div class="col-lg-12">  
                  <div class="form-group">
                    <label>Hak Akses</label>
                      <select name="role" class="custom-select form-control">
                          <option selected disabled>Pilih Hak Akses</option>
                          <option value="1" <?= $edit_user['id_role'] == 1 ? 'selected' : null; ?>>Admin</option>
                          <option value="2" <?= $edit_user['id_role'] == 2 ? 'selected' : null; ?>>Manajer</option>
                      </select>
                  </div>  
                </div>

                <div class="col-lg-12">
                  <div class="text-center">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Ubah</button>
                    <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-undo"></i> Reset</button>
                  </div>                  
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('#user-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('user/update/').$this->uri->segment(3) ?>",
      data: $(this).serialize(),
      dataType: "JSON",
      beforeSend: function(){
        $(':input[type="submit"]').prop('disabled', true);
      },
      success: function(data){
        msg = ""
        if (data.status == "success") {
          msg = "Berhasil disimpan.";
            toastr.success(msg, 'success');          
          window.location.href="<?= site_url('user'); ?>";
        } else {
          $.each(data.msg,function(i,value){
            msg += '<i class="fa fa-warning"></i> ' + data.msg[i] + '<br>'
          });
          toastr.warning(msg, 'Warning').css("width", "100%");             
        }
        $(':input[type="submit"]').prop('disabled', false);
      },
      error: function(){
        toastr.error('gagal disimpan', 'Error')
        $(':input[type="submit"]').prop('disabled', false);
      }
    });
  });
});
</script>