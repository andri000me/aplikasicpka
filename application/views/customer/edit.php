<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                  Edit Customer
                  <a href="<?= site_url('customer') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>
                <hr>
              </div>
            </div>

            <form id="customer-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Perusahaan</label>
                    <input type="hidden" name="id" value="<?= $edit_customer['id']?>">
                    <input type="text" name="namaCustomer" class="form-control" placeholder="Isikan Nama Perusahaan" value="<?= $edit_customer['namaCustomer']?>">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Tanggal Persetujuan</label>
                    <input type="date" name="tglPersetujuan" class="form-control" value="<?= $edit_customer['tglPersetujuan']?>">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telp" class="form-control" placeholder="Isikan No Telepon " value="<?= $edit_customer['telp']?>">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Penanggung Jawab</label>
                    <input type="text" name="penanggungJawab" class="form-control" placeholder="Isikan Penanggung Jawab " value="<?= $edit_customer['penanggungJawab']?>">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Upload Persetujuan</label>
                    <input type="file" name="berkas" class="form-control-file">
                    <input type="text" name="old_berkas" class="form-control" value="<?= $edit_customer['berkas']?>">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group row d-flex align-items-center mb-5">
                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Alamat</label>
                    <textarea name="alamat" rows="4" class="form-control"> <?= $edit_customer['alamat']?> </textarea>
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="text-center">
                      <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-pen"></i> Ubah</button>
                      <button class="btn btn-sm btn-warning" type="reset"><i class="fa fa-undo"></i> Reset</button>
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
  $('#customer-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('customer/update/').$this->uri->segment(3) ?>",
      data: new FormData(this),
      processData: false,
      contentType: false,
      cache: false,
      dataType: "JSON",
      beforeSend: function(){
        $(':input[type="submit"]').prop('disabled', true);
      },
      success: function(data){
        msg = ""
        if (data.status == "success") {
          msg = "Berhasil disimpan.";
            toastr.success(msg, 'success');
          window.location.href="<?= site_url('customer'); ?>";
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