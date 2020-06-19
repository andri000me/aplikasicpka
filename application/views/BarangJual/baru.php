<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                  Input Barang Jual
                  <a href="<?= site_url('barang-jual') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>
                <hr>
              </div>
            </div>
            <form id="barangjual-form">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Tanggal Jual</label>
                    <input type="date" name="tglJual" class="form-control" value="<?= date('Y-m-d') ?>">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Tanggal Tempo</label>
                      <input type="date" name="tglTempo" class="form-control" value="<?= date('Y-m-d') ?>">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="barang" class="form-control" placeholder="Isikan Nama Barang" value="Palm Oil" readonly>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Satuan</label>
                      <input type="text" name="satuan" class="form-control" placeholder="Isikan Satuan" value="Liter" readonly>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Customer</label>
                    <select name="customer" class="custom-select form-control">
                      <option  selected disabled>Pilih Customer</option>
                        <?php foreach ($customer as $cus) : ?>
                          <option value="<?= $cus['id'] ?>"><?= $cus['namaCustomer'] ?></option>
                        <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Liter</label>
                      <input type="text" name="jumlahJual" class="form-control" placeholder="Isikan Jumlah Barang">
                  </div>
                </div>

                <div class="col-lg-9">
                  <div class="form-group">
                    <label>Harga Jual</label>
                      <input type="text" name="hargaJual" class="form-control" placeholder="Isikan Harga Jual">
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
  $('#barangjual-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('BarangJual/create') ?>",
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
          window.location.href="<?= site_url('barang-jual'); ?>";
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