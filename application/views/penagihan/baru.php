<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                Input Penagihan
                  <a href="<?= site_url('penagihan') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>
              </div>
              <hr>
            </div>

            <form id="penagihan-form">  
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Nomor Penjualan</label>
                    <select name="idJual" id="idJual" class="custom-select form-control">
                      <option disabled selected>Pilih Nomor Penjualan</option>
                      <?php foreach ($barang_jual as $jual) : 
                        $total = $jual['total'];
                        $ppn = 0.1;
                        $hitung_ppn = $total * $ppn;
                        $subtotal = $total + $hitung_ppn;
                      ?>
                        <option id="jual-<?= $jual['id'] ?>" value="<?= $jual['id'] ?>" 
                                data-tanggal="<?= $jual['tglJual'] ?>"
                                data-customer="<?= $jual['Nama_Customer'] ?>"
                                data-barangjual="<?= $jual['namaBarangJual'] ?>"
                                data-jumlah="<?= $jual['jumlahJual'].' '.$jual['satuan'].' x '.rupiah($jual['hargaJual']) ?>"
                                data-subtotal="<?= $subtotal ?>"
                                data-sisahutang="<?= $subtotal ?>"
                        ><?= '['.$jual['kodeBarangJual']. ' - '. $jual['Nama_Customer'].']' ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" readonly>
                  </div>
                </div>
               
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" name="customer" id="customer" class="form-control" readonly>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Barang</label>
                    <input type="text" name="barangjual" id="barangjual" class="form-control" readonly>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" readonly>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Total Hutang + PPN(10%)</label>
                    <input type="text" name="subtotal" id="subtotal" class="form-control" readonly>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Sisa Hutang</label>
                    <input type="text" name="sisa_hutang" id="sisa_hutang" class="form-control" readonly>
                  </div>
                </div>
                                          
                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Jangka Waktu</label>
                    <select name="jangka_waktu" id="jangka_waktu" class="custom-select form-control">
                      <option value="" disabled selected>Pilih Jangka Waktu</option>
                      <option value="1">1 Bulan</option>
                      <option value="2">2 Bulan</option>
                      <option value="3">3 Bulan</option>
                      <option value="4">4 Bulan</option>
                      <option value="5">5 Bulan</option>
                      <option value="6">6 Bulan</option>
                      <option value="7">7 Bulan</option>
                      <option value="8">8 Bulan</option>
                      <option value="9">9 Bulan</option>
                      <option value="10">10 Bulan</option>
                      <option value="11">11 Bulan</option>
                      <option value="12">12 Bulan</option>
                    </select>                    
                  </div>                  
                </div>

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Angsuran Perbulan</label>
                    <input type="text" name="perbulan" id="perbulan" class="form-control">
                  </div>
                </div>
                
                <div class="col-lg-12 mt-4">
                  <div class="form-group">
                    <button  type="button" onclick="addAngsuran()" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Tambah Angsuran</button>
                  </div>
                </div>

                <div class="col-lg-12">
                  <table class="table table-sm table-bordered" id="form-body">
                    <thead>
                      <tr class="text-center">
                        <th style="width: 200px;">Angsuran</th>
                        <th style="width: 200px;">Jumlah Angsuran</th>
                        <th style="width: 80px;">Tanggal Bayar</th>
                        <th style="width: 150px;">Keterlambatan</th>
                        <th style="width: 180px;">Denda</th>
                        <th style="width: 100px;">Pembayaran Selanjutnya</th>
                        <th>Aksi</th>                        
                      </tr>
                    </thead>
                  </table>
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
$(document).ready(function() {
  $(document).on('change, keyup', '#jangka_waktu', function(){
    var totalHutang = $('#subtotal').val();
    var jangka_waktu = $(this).val();
    var sisaHutang = totalHutang / jangka_waktu;
    var round = Math.round(sisaHutang);
    $('#perbulan').val(round);
  });

  $(document).on('change', '#idJual', function() {
      var getTanggal = $("#jual-"+this.value).data('tanggal');
      var getCustomer = $("#jual-"+this.value).data('customer');
      var getBarangJual = $("#jual-"+this.value).data('barangjual');
      var getJumlah = $("#jual-"+this.value).data('jumlah');
      var getTotal = $("#jual-"+this.value).data('subtotal');
      var getSisa = $("#jual-"+this.value).data('sisahutang');
      $("#tanggal").val(getTanggal);
      $("#customer").val(getCustomer);
      $("#barangjual").val(getBarangJual);
      $("#jumlah").val(getJumlah);
      $("#subtotal").val(getTotal);
      $("#sisa_hutang").val(getSisa);
  });

  $(document).on('change', '#keterlambatan', function() {
      var getBulan1 = $(this).find(':selected').data('1bulan');
      var getBulan2 = $(this).find(':selected').data('2bulan');
      var getBulan3 = $(this).find(':selected').data('3bulan');
      var getBulan4 = $(this).find(':selected').data('4bulan');
      var getBulan5 = $(this).find(':selected').data('5bulan');
      var getBulan6 = $(this).find(':selected').data('6bulan');
      var getBulan7 = $(this).find(':selected').data('7bulan');
      var getBulan8 = $(this).find(':selected').data('8bulan');
      var getBulan9 = $(this).find(':selected').data('9bulan');
      var getBulan10 = $(this).find(':selected').data('10bulan');
      var getBulan11 = $(this).find(':selected').data('11bulan');
      var getBulan12 = $(this).find(':selected').data('12bulan');
      if(getBulan1) {
        $(this).closest('tr').find(".denda").val(getBulan1);
      } else if(getBulan2) {
        $(this).closest('tr').find(".denda").val(getBulan2);       
      } else if(getBulan3) {
        $(this).closest('tr').find(".denda").val(getBulan3);       
      } else if(getBulan4) {
        $(this).closest('tr').find(".denda").val(getBulan4);     
      } else if(getBulan5) {
        $(this).closest('tr').find(".denda").val(getBulan5);     
      } else if(getBulan6) {
        $(this).closest('tr').find(".denda").val(getBulan6);      
      } else if(getBulan7) {
        $(this).closest('tr').find(".denda").val(getBulan7);     
      } else if(getBulan8) {
        $(this).closest('tr').find(".denda").val(getBulan8);     
      } else if(getBulan9) {
        $(this).closest('tr').find(".denda").val(getBulan9);     
      } else if(getBulan10) {
        $(this).closest('tr').find(".denda").val(getBulan10);
      } else if(getBulan11) {
        $(this).closest('tr').find(".denda").val(getBulan11);  
      } else if(getBulan12) {
        $(this).closest('tr').find(".denda").val(getBulan12);       
      } else {
        $(this).closest('tr').find(".denda").val("0");
      } 
  });  
  $('#penagihan-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('penagihan/create') ?>",
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
          window.location.href="<?= site_url('penagihan'); ?>";
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

function addAngsuran()
  {
    var html ='';

    html += '<tr class="text-center">'
            + '<td>'
            +     '<div class="form-group">'
            +        '<select name="angsuran[]" id="angsuran" class="custom-select form-control">'
            +           '<option value="" disabled selected>Pilih Angsuran</option>'
            +           '<option value="Angsuran ke-1">Angsuran ke-1</option>'
            +           '<option value="Angsuran ke-2">Angsuran ke-2</option>'
            +           '<option value="Angsuran ke-3">Angsuran ke-3</option>'
            +           '<option value="Angsuran ke-4">Angsuran ke-4</option>'
            +           '<option value="Angsuran ke-5">Angsuran ke-5</option>'
            +           '<option value="Angsuran ke-6">Angsuran ke-6</option>'
            +           '<option value="Angsuran ke-7">Angsuran ke-7</option>'
            +           '<option value="Angsuran ke-8">Angsuran ke-8</option>'
            +           '<option value="Angsuran ke-9">Angsuran ke-9</option>'
            +           '<option value="Angsuran ke-10">Angsuran ke-10</option>'
            +           '<option value="Angsuran ke-11">Angsuran ke-11</option>'
            +           '<option value="Angsuran ke-12">Angsuran ke-12</option>'
            +        '</select>'
            +     '</div>'
            +   '</div>'
            + '</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran[]" placeholder="Jumlah Angsuran">'
            +   '</div>'
            +'</td>';            

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar[]">'
            +   '</div>'
            +'</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +     '<select name="keterlambatan[]" id="keterlambatan" class="custom-select form-control">'
            +       '<option  selected disabled>Pilih</option>'
            +       '<option value="Tepat Waktu" data-tepat="0">Tepat Waktu</option>'
            +       '<option value="1 Bulan" data-1bulan="100000">1 Bulan</option>'
            +       '<option value="2 Bulan" data-2bulan="200000">2 Bulan</option>'
            +       '<option value="3 Bulan" data-3bulan="300000">3 Bulan</option>'
            +       '<option value="4 Bulan" data-4bulan="400000">4 Bulan</option>'
            +       '<option value="5 Bulan" data-5bulan="500000">5 Bulan</option>'
            +       '<option value="6 Bulan" data-6bulan="600000">6 Bulan</option>'
            +       '<option value="7 Bulan" data-7bulan="700000">7 Bulan</option>'
            +       '<option value="8 Bulan" data-8bulan="800000">8 Bulan</option>'
            +       '<option value="9 Bulan" data-9bulan="900000">9 Bulan</option>'
            +       '<option value="10 Bulan" data-10bulan="1000000">10 Bulan</option>'
            +       '<option value="11 Bulan" data-11bulan="1100000">11 Bulan</option>'
            +       '<option value="12 Bulan" data-12bulan="1200000">12 Bulan</option>'
            +     '</select>'
            +   '</div>'
            +'</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="text" class="form-control denda" id="denda" name="denda[]" placeholder="Denda">'
            +   '</div>'
            +'</td>';

    html += '<td>'
            +   '<div class="form-group">'
            +       '<input type="date" class="form-control" id="tgl_byr_selanjutnya" name="tgl_byr_selanjutnya[]">'
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