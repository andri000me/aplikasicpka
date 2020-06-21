<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center  mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                  Input Barang
                  <a href="<?= site_url('barang') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>
                <hr>
              </div>
            </div>

            <form id="barang-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Barang</label>
                    <input type="text" name="nama" class="form-control" placeholder="Isikan Nama Barang">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" class="custom-select form-control">
                      <option value="" disabled selected>Pilih Satuan</option>
                      <option value="bh">Bh</option>
                      <option value="btl">Btl</option>
                      <option value="dus">Dus</option>
                      <option value="kg">Kg</option>
                      <option value="liter">Liter</option>
                      <option value="pcs">Pcs</option>
                      <option value="set">Set</option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control" placeholder="Isikan Harga Barang">
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
  $('#barang-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('barang/create') ?>",
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
          window.location.href="<?= site_url('barang'); ?>";
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