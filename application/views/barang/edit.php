<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center  mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <h3>
                Edit Barang
                <a href="<?= site_url('barang') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
              </h3>
              <hr>
            </div>

            <form id="barang-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label class="col-lg-12">Kode Barang</label>
                    <input type="hidden" id="id" name="id" value="<?=$edit_barang['id']?>">
                    <input type="text" name="kodeBarang" class="form-control" placeholder="Kode Barang" value="<?= $edit_barang['kodeBarang'] ?>" readonly>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Barang</label>
                    <input type="text" name="nama" class="form-control" placeholder="Isikan Nama Barang"  value="<?= $edit_barang['namaBarang'] ?>">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" class="custom-select form-control">
                      <option selected disabled >Pilih Satuan</option>
                      <option value="bh" <?= $edit_barang['satuan'] == 'bh' ? 'selected' : null ?>>Bh</option>
                      <option value="btl" <?= $edit_barang['satuan'] == 'btl' ? 'selected' : null ?>>Btl</option>
                      <option value="dus" <?= $edit_barang['satuan'] == 'dus' ? 'selected' : null ?>>Dus</option>
                      <option value="kg" <?= $edit_barang['satuan'] == 'kg' ? 'selected' : null ?>>Kg</option>
                      <option value="liter" <?= $edit_barang['satuan'] == 'liter' ? 'selected' : null ?>>Liter</option>
                      <option value="pcs" <?= $edit_barang['satuan'] == 'pcs' ? 'selected' : null ?>>Pcs</option>
                      <option value="set" <?= $edit_barang['satuan'] == 'set' ? 'selected' : null ?>>Set</option>
                    </select>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control" placeholder="Isikan Harga barang" value="<?= $edit_barang['hargaBeli'] ?>">
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
  $('#barang-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('barang/update/').$this->uri->segment(3) ?>",
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