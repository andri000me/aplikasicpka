<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <h3>
                Kirim Pesan Penagihan
                <a href="<?= site_url('user') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
              </h3>
              <hr>
            </div>            
            <form id="sms-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>No Handphone</label>
                    <input type="text" name="no_hp" class="form-control" placeholder="Isikan Nomor HP 1">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Isi Pesan</label>
                    <textarea name="isi_pesan" class="form-control" rows="5" placeholder="Masukan pesan disini.."></textarea>
                  </div>
                </div>                

                <div class="col-lg-12">
                  <div class="text-center">
                    <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save"></i> Kirim</button>
                    <button type="reset" class="btn btn-sm btn-secondary"><i class="fa fa-undo"></i> Reset</button>
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
  $('#sms-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('sms/kirim_sms') ?>",
      data: $(this).serialize(),
      dataType: "JSON",
      beforeSend: function(){
        $(':input[type="submit"]').prop('disabled', true);
      },
      success: function(data){
        msg = ""
        if (data.status == "success") {
          msg = "Pesan berhasil dikirim.";
            toastr.success(msg, 'success');          
          window.location.href="<?= site_url('sms'); ?>";
        } else {
          $.each(data.msg,function(i,value){
            msg += '<i class="fa fa-warning"></i> ' + data.msg[i] + '<br>'
          });
          toastr.warning(msg, 'Warning').css("width", "100%");             
        }
        $(':input[type="submit"]').prop('disabled', false);
      },
      error: function(){
        toastr.error('Gagal dikirim', 'Error')
        $(':input[type="submit"]').prop('disabled', false);
      }
    });
  });
});
</script>