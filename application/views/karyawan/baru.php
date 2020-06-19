<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <h3>
                Input Karyawan
                <a href="<?= site_url('karyawan') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
              </h3>
              <hr>
            </div>            
            <form id="karyawan-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>NIK</label>
                      <input type="text" name="nik" class="form-control" placeholder="Isikan NIK">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Penanggung Jawab</label>
                    <input type="text" name="namaKaryawan" class="form-control" placeholder="Isikan Nama Penanggung Jawab">
                  </div>
                </div>                

                <div class="col-lg-12">  
                  <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="noTelp" class="form-control" placeholder="Isikan No Telepon">
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
  $('#karyawan-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('karyawan/create') ?>",
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
          window.location.href="<?= site_url('karyawan'); ?>";
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