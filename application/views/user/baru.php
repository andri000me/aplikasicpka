<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <h3>
                Input User
                <a href="<?= site_url('user') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
              </h3>
              <hr>
            </div>            
            <form id="user-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Isikan Username">
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
                        <option  disabled selected>Pilih Hak Akses</option>
                        <option value="1">Admin</option>
                        <option value="2">Manajer</option>
                      </select>
                  </div>  
                </div>

                <div class="col-lg-12">
                  <div class="text-center">
                    <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i> Simpan</button>
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
      url: "<?= site_url('user/create') ?>",
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