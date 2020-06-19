<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                  Edit Supplier
                  <a href="<?= site_url('supplier') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>
                <hr>
              </div>
            </div>            

            <form id="supplier-form">
              <div class="row">
                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Perusahaan</label>
                    <input type="hidden" name="id" value="<?= $edit_supplier['id']?>">
                    <input type="text" name="namaSupplier" class="form-control" placeholder="Isikan Nama Perusahaan" value="<?= $edit_supplier['namaSupplier']?>">
                  </div>                  
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Tanggal Persetujuan</label>
                    <input type="date" name="tglPersetujuan" class="form-control" value="<?= $edit_supplier['tglPersetujuan']?>">
                  </div>                  
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="telp" class="form-control" placeholder="Isikan No Telepon " value="<?= $edit_supplier['telp']?>">
                  </div>                  
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Penanggung Jawab</label>
                    <input type="text" name="penanggungJawab" class="form-control" placeholder="Isikan Penanggung Jawab " value="<?= $edit_supplier['penanggungJawab']?>">
                  </div>                  
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <label>Upload Persetujuan</label>
                    <input type="file" name="berkas" class="form-control-file">
                    <input type="text" name="old_berkas" class="form-control" value="<?= $edit_supplier['berkas']?>">
                  </div>
                </div>

                <div class="col-lg-12">
                  <div class="form-group row d-flex align-items-center mb-5">
                    <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Alamat</label>
                    <textarea name="alamat" rows="4" class="form-control"> <?= $edit_supplier['alamat']?> </textarea>
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
  $('#supplier-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('supplier/update/').$this->uri->segment(3) ?>",
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
          window.location.href="<?= site_url('supplier'); ?>";
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