<div class="container-fluid">
  <div class="row" align="center">
    <div class="col-lg-12">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h4>FORM UBAH TAGIHAN</h4>
        </div>

        <div class="card-body ">
          <form id="tagihan-form" method="post" role="form">
            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Kode Masuk</label>
              <div class="col-lg-5">
                <div class="select">
                <input type="hidden" id="id" name="id" value="<?= $edit_tagihan['id'] ?>">
                  <select name="idMasuk" class="custom-select form-control">
                    <option  selected disabled>Pilih Kode Masuk</option>
                    <?php foreach ($barangmasuk as $masuk) : ?>
                    <?php if($masuk['id'] == $edit_tagihan['idMasuk']) : ?>
                      <option value="<?= $masuk['id'] ?>" selected><?= $masuk['kodeMasuk'] ?> [Tanggal Terima : <?= date('d M Y', strtotime($masuk['tglMasuk'])) ?>]- [<?= $masuk['Nama_Barang'] ?> <?= $masuk['Nama_Supplier']?>]</option>
                    <?php else : ?>
                      <option value="<?= $masuk['id'] ?>"><?= $masuk['kodeMasuk'] ?> [Tanggal Terima : <?= date('d M Y', strtotime($masuk['tglMasuk'])) ?>]- [<?= $masuk['Nama_Barang'] ?> <?= $masuk['Nama_Supplier']?>]</option>
                    <?php endif; ?>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Supplier</label>
              <div class="col-lg-5">
                <div class="select">
                  <select name="idSupplier" class="custom-select form-control">
                    <option  selected disabled>Pilih Supplier</option>
                      <?php foreach ($supplier as $sup) : ?>
                      <?php if ($sup['id'] == $edit_tagihan['idSupplier']) : ?>
                        <option value="<?= $sup['id'] ?>" selected><?= $sup['namaSupplier'] ?></option>
                      <?php else : ?>                        
                        <option value="<?= $sup['id'] ?>"><?= $sup['namaSupplier'] ?></option>
                      <?php endif; ?>
                      <?php endforeach ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Nama Barang</label>
              <div class="col-lg-5">
                <div class="select">
                  <select name="idBarang" class="custom-select form-control">
                    <option  selected disabled>Pilih Barang</option>
                    <?php foreach ($barang as $item) : ?>
                      <?php if($item['id'] == $edit_tagihan['idBarang']) : ?>
                      <option value="<?= $item['id'] ?>"><?= $item['namaBarang'] ?></option>
                      <?php else :?>
                      <option value="<?= $item['id'] ?>" selected><?= $item['namaBarang'] ?></option>
                      <?php endif; ?>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">PPN</label>
              <div class="col-lg-5">
                <input type="text" name="ppn" class="form-control" value="<?= $edit_tagihan['ppn']?>" readonly>
              </div>
            </div>

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Tanggal Jatuh Tempo</label>
              <div class="col-lg-5">
                <input type="date" name="tglTempo" class="form-control" value="<?= $edit_tagihan['tglTempo'] ?>">
              </div>
            </div>                                   

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Jumlah Retur</label>
              <div class="col-lg-5">
                <input type="text" name="jumlahRetur" class="form-control" placeholder="*Kosongkan jika tidak ada barang yang diretur" value="<?= $edit_tagihan['jumlahRetur'] ?>">
              </div>
            </div>

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Jumlah Pembayaran</label>
              <div class="col-lg-5">
                <input type="text" name="jumlahPembayaran" class="form-control" placeholder="Isikan jumlah pembayaran" value="<?= $edit_tagihan['jumlahPembayaran'] ?>">
              </div>
            </div>

            <div class="form-group row d-flex align-items-center mb-5">
              <label class="col-lg-4 form-control-label d-flex justify-content-lg-end">Keterlambatan</label>
              <div class="col-lg-5">
                <div class="select">
                  <select name="keterlambatan" class="custom-select form-control">
                    <option  selected disabled>Pilih Keterlambatan</option>
                      <option value="Tepat Waktu" <?= $edit_tagihan['keterlambatan'] == 'Tepat Waktu' ? 'selected' : null ?>>Tepat Waktu</option>
                      <option value="1 Bulan" <?= $edit_tagihan['keterlambatan'] == '1 Bulan' ? 'selected' : null ?>>1 Bulan</option>
                      <option value="2 Bulan" <?= $edit_tagihan['keterlambatan'] == '2 Bulan' ? 'selected' : null ?>>2 Bulan</option>
                      <option value="3 Bulan" <?= $edit_tagihan['keterlambatan'] == '3 Bulan' ? 'selected' : null ?>>3 Bulan</option>
                      <option value="4 Bulan" <?= $edit_tagihan['keterlambatan'] == '4 Bulan' ? 'selected' : null ?>>4 Bulan</option>
                      <option value="5 Bulan" <?= $edit_tagihan['keterlambatan'] == '5 Bulan' ? 'selected' : null ?>>5 Bulan</option>
                      <option value="6 Bulan" <?= $edit_tagihan['keterlambatan'] == '6 Bulan' ? 'selected' : null ?>>6 Bulan</option>
                      <option value="7 Bulan" <?= $edit_tagihan['keterlambatan'] == '7 Bulan' ? 'selected' : null ?>>7 Bulan</option>
                      <option value="8 Bulan" <?= $edit_tagihan['keterlambatan'] == '8 Bulan' ? 'selected' : null ?>>8 Bulan</option>
                      <option value="9 Bulan" <?= $edit_tagihan['keterlambatan'] == '9 Bulan' ? 'selected' : null ?>>9 Bulan</option>
                      <option value="10 Bulan" <?= $edit_tagihan['keterlambatan'] == '10 Bulan' ? 'selected' : null ?>>10 Bulan</option>
                      <option value="11 Bulan" <?= $edit_tagihan['keterlambatan'] == '11 Bulan' ? 'selected' : null ?>>11 Bulan</option>
                      <option value="12 Bulan" <?= $edit_tagihan['keterlambatan'] == '12 Bulan' ? 'selected' : null ?>>12 Bulan</option>
                  </select>
                </div>
              </div>
            </div>              
            
            <div class="text-center">
                <button class="btn btn-success" type="submit"><i class="fa fa-pen"> Ubah </i></button>
                <a href="<?= site_url('tagihan') ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"> Kembali</i></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('#tagihan-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('tagihan/update/').$this->uri->segment(3) ?>",
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
          window.location.href="<?= site_url('tagihan'); ?>";
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