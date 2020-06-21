<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                  Input Barang Keluar
                  <a href="<?= site_url('barang-keluar') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>

                <hr>
              </div>
            </div>

            <form id="barangkeluar-form" role="form">
              <div class="row">
                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Tanggal Keluar</label>
                    <input type="date" name="tgl_keluar" class="form-control" value="<?= date('Y-m-d') ?>">
                  </div>
                </div>


                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Karyawan</label>
                    <select name="karyawan" class="custom-select form-control">
                      <option value="" disabled selected>Pilih Karyawan</option>
                      <?php foreach ($karyawan as $kry) : ?>
                        <option value="<?= $kry['id'] ?>"><?= $kry['namaKaryawan'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan">
                  </div>
                </div>

                <div class="col-lg-12 mt-4">
                  <div class="form-group">
                    <button  type="button" onclick="addBarang()" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Tambah Barang</button>
                  </div>
                </div>

                <div class="col-lg-12">
                  <table class="table table-sm table-bordered" id="form-body">
                    <thead>
                      <th>Barang</th>
                      <th>Harga</th>
                      <th style="width: 120px;">Stok</th>
                      <th style="width: 150px;">Satuan</th>
                      <th style="width: 120px;">Qty</th>
                      <th>Aksi</th>
                    </thead>
                  </table>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <div class="text-center m-t-0">
                      <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa fa-save"></i> Simpan
                      </button>
                    </div>
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
$(document).ready(function() {
  $(document).on('change', '#id_barang', function() {
      var getSatuan = $("#barang-"+this.value).data('satuan');
      var getHarga = $("#barang-"+this.value).data('harga');
      var getStok = $("#barang-"+this.value).data('stok');
      $(this).closest('tr').find("#satuan").val(getSatuan);
      $(this).closest('tr').find("#harga").val(getHarga);
      $(this).closest('tr').find("#stok").val(getStok);
  });

  $('#barangkeluar-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('BarangKeluar/create') ?>",
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
          window.location.href="<?= site_url('barang-keluar'); ?>";
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

  function addBarang()
  {
    var html ='';

    html += '<tr>'
            + '<td>'
            +   '<div class="form-group">'
            +       '<select class="form-control" id="id_barang" name="id_barang[]">'
            +          '<option value="" disabled selected>--Pilih Barang--</option>'
            +           '<?php foreach ($barang as $data): ?>'
            +            '<option id="barang-<?= $data['id'] ?>"'
            +                'value="<?= $data['id'] ?>" data-satuan="<?= $data['satuan'] ?>"'
            +                   ' data-harga = "<?= $data['hargaBeli'] ?>"'
            +                   ' data-stok = "<?= $data['stok'] ?>">'
            +                   '<?= $data['kodeBarang'] . ' - ' . $data['namaBarang'] . ' - ' . $data['stok'] . '  ' . $data['satuan'] ?>'
            +           '</option><?php endforeach ?>'
            +       '</select>'
            +   '</div>'
            + '</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="text" class="form-control" id="harga" name="harga[]" placeholder="Harga" readonly>'
            +   '</div>'
            +'</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="text" class="form-control" id="stok" name="stok[]" placeholder="Stok" readonly>'
            +   '</div>'
            +'</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="text" class="form-control" id="satuan" name="satuan[]" placeholder="Satuan" readonly>'
            +   '</div>'
            +'</td>';

    html +='<td>'
            +   '<div class="form-group">'
            +       '<input type="number" class="form-control" id="qty" name="qty[]" placeholder="Qty">'
            +   '</div>'
            +'</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<button type="button" class="btn btn-sm btn-warning" onclick="removeRow(this)"><i class="fa fa-minus"></i>'
            +       '</button>'
            +   '</div>'
            +'</td>';

    html += '</tr>';

    $('#form-body').append(html);
  }

  function removeRow($id)
  {
    $id.closest('tr').remove();
  }
</script>