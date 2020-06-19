<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                Input Pembayaran tagihan
                  <a href="<?= site_url('tagihan') ?>" class="btn btn-sm btn-secondary float-right"><i class="fa fa-arrow-circle-right"></i> Kembali</a>
                </h3>
              </div>
              <hr>
            </div>

            <form id="tagihan-form">  
              <div class="row">
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Nomor Pembelian</label>
                    <input type="hidden" name="id_tagih" id="id_tagih" value="<?= $edit_tagihan['id'] ?>">
                    <?php foreach ($barang_masuk as $masuk) : 
                      $total = $masuk['subtotal'];
                      $ppn = 0.1;
                      $hitung_ppn = $total * $ppn;
                      $subtotal = $total + $hitung_ppn;
                    ?>
                    <?php if($masuk['id'] == $edit_tagihan['id_masuk']) : ?>
                    <input type="hidden" name="idMasuk" value="<?= $masuk['id'] ?>">              
                    <input type="text" name="kode" value="<?= '['.$masuk['kode_masuk']. ' - '. $masuk['nama_supplier'].']' ?>" class="form-control" readonly>
                  </div>
                </div>

                <div class="col-lg-2">
                  <div class="form-group">
                    <label>Tanggal Pembelian</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $masuk['tgl_masuk'] ?>" readonly>
                  </div>
                </div>
               
                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Nama Supplier</label>
                    <input type="text" name="supplier" id="supplier" class="form-control" value="<?= $masuk['nama_supplier'] ?>" readonly>
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Total Hutang + PPN(10%)</label>
                    <input type="text" name="subtotal" id="subtotal" class="form-control" value="<?= $subtotal ?>" readonly>
                  </div>
                </div>
                <?php endif; ?>  
                <?php endforeach ?>                

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Nomor Retur</label>
                    <?php foreach ($barang_retur as $retur) : ?>
                    <?php if($retur['kode_retur'] == $edit_tagihan['no_retur']) : ?>
                    <input type="text" name="idRetur" value="<?= '['.$retur['kode_retur']. ' - '. $retur['nama_supplier'].']' ?>" class="form-control" readonly>
                    <?php endif; ?>  
                    <?php endforeach ?>                                    
                  </div>
                </div>                               

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Total Retur + PPN(10%)</label>
                    <input type="text" name="totalretur" id="totalretur" value="<?= $edit_tagihan['jumlah_retur'] ?>" class="form-control" readonly>
                  </div>
                </div>                 

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Sisa Hutang</label>
                    <input type="text" name="sisa_hutang" id="sisa_hutang" value="<?= rupiah($edit_tagihan['sisa_hutang']) ?>" class="form-control" readonly>
                  </div>
                </div> 


                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Jangka Waktu</label>
                    <select name="jangka_waktu" id="jangka_waktu" class="custom-select form-control">
                      <option value="" disabled selected>Pilih Jangka Waktu</option>
                      <option value="1" <?= $edit_tagihan['jangka_waktu'] == 1 ? 'selected' : '' ?>>1 Bulan</option>
                      <option value="2" <?= $edit_tagihan['jangka_waktu'] == 2 ? 'selected' : '' ?>>2 Bulan</option>
                      <option value="3" <?= $edit_tagihan['jangka_waktu'] == 3 ? 'selected' : '' ?>>3 Bulan</option>
                      <option value="4" <?= $edit_tagihan['jangka_waktu'] == 4 ? 'selected' : '' ?>>4 Bulan</option>
                      <option value="5" <?= $edit_tagihan['jangka_waktu'] == 5 ? 'selected' : '' ?>>5 Bulan</option>
                      <option value="6" <?= $edit_tagihan['jangka_waktu'] == 6 ? 'selected' : '' ?>>6 Bulan</option>
                      <option value="7" <?= $edit_tagihan['jangka_waktu'] == 7 ? 'selected' : '' ?>>7 Bulan</option>
                      <option value="8" <?= $edit_tagihan['jangka_waktu'] == 8 ? 'selected' : '' ?>>8 Bulan</option>
                      <option value="9" <?= $edit_tagihan['jangka_waktu'] == 9 ? 'selected' : '' ?>>9 Bulan</option>
                      <option value="10" <?= $edit_tagihan['jangka_waktu'] == 10 ? 'selected' : '' ?>>10 Bulan</option>
                      <option value="11" <?= $edit_tagihan['jangka_waktu'] == 11 ? 'selected' : '' ?>>11 Bulan</option>
                      <option value="12" <?= $edit_tagihan['jangka_waktu'] == 12 ? 'selected' : '' ?>>12 Bulan</option>
                    </select>                    
                  </div>                  
                </div>

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Angsuran Perbulan</label>
                    <input type="text" name="perbulan" id="perbulan" class="form-control" value="<?= $edit_tagihan['angsuran_perbulan'] ?>">
                  </div>
                </div>                

                <div class="col-lg-4">
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="custom-select form-control">
                      <option value="" disabled selected>Pilih Status</option>
                      <option value="Lunas" <?= $edit_tagihan['status'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                      <option value="Belum Lunas" <?= $edit_tagihan['status'] == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                    </select>                    
                  </div>                  
                </div>

                <div class="col-lg-12 mt-4">
                  <div class="form-group">
                    <button  type="button" onclick="addAngsuran()" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Tambah Angsuran</button>
                  </div>
                </div>

                <div class="col-lg-12">
                  <table class="table table-sm table-bordered" id="form-body" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr class="text-center">
                        <th style="width: 190px;">Angsuran</th>
                        <th>Jumlah</th>
                        <th style="width: 120px;">Tgl Bayar</th>
                        <th>Keterlambatan</th>
                        <th style="width: 140px;">Denda</th>
                        <th>Tgl Byr Kembali</th>
                        <th colspan="3">Aksi</th>                        
                      </tr>
                    </thead>

                    <tbody id="form-body-edit">
                      
                    </tbody>
                  </table>
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
$(document).ready(function() {
  $(document).on('change, keyup', '#jangka_waktu', function(){
    var totalHutang = $('#subtotal').val();
    var totalRetur = $('#totalretur').val();
    var jangka_waktu = $(this).val();
    var sisaHutang = (totalHutang - totalRetur);
    var angsuran = (totalHutang - totalRetur) / jangka_waktu;
    var round = Math.round(angsuran);
    $('#perbulan').val(round);
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
          window.location.href="<?= site_url('tagihan/edit/').$this->uri->segment(3) ?>";
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
  loadAngsuran();
});  
    function loadAngsuran(){
        $.ajax({
            url: "<?= site_url('tagihan/getTagihanDetail/' . $this->uri->segment(3)) ?>",
            method: 'GET',
            dataType: 'JSON',
            beforeSend: function(){
                $('#form-body-edit').empty();
                loading = '<tr>'
                        + '<td colspan="9"><p class="text-center">Loading....</p>'
                        + '</td>'
                +'</tr>';
                $('#form-body-edit').append(loading);
            },
            success: function(response){
                var html ='';

                $.each(response.data,function(k, v){
                    $('#form-body-edit').empty();

                    html += '<tr class="text-center">'
                            + '<td>'
                            +     '<div class="form-group">'
                            +       '<input type="hidden" class="form-control" id="id_tagihan_detail" name="id_tagihan_detail" value="'+v.id_tagihan_detail+'">'  
                            +       '<input type="hidden" class="form-control" id="id_tagihan" name="id_tagihan" placeholder="" readonly value="'+v.id_tagihan+'">'                                                      
                            +        '<select name="angsuran" id="angsuran" class="custom-select form-control">'
                            +           '<option value="'+v.angsuran+'" selected>'+v.angsuran+'</option><hr>'
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
                            + '</td>';                    

                    html += '<td>'
                            +   '<div class="form-group">'
                            +       '<input type="text" class="form-control" id="jumlah_pembayaran" name="jumlah_pembayaran" value="'+v.jumlah_bayar+'">'
                            +   '</div>'
                            +'</td>';

                    html += '<td>'
                            +   '<div class="form-group">'
                            +       '<input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar"  value="'+v.tgl_bayar+'">'
                            +   '</div>'
                            +'</td>';                            

                    html += '<td>'
                            +   '<div class="form-group">'
                            +     '<select name="keterlambatan" id="keterlambatan" class="custom-select form-control">'
                            +       '<option value="'+v.keterlambatan+'" selected>'+v.keterlambatan+'</option>'
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
                            +       '<input type="text" class="form-control denda" id="denda" name="denda" value="'+v.denda+'">'
                            +   '</div>'
                            +'</td>';

                    html += '<td>'
                            +   '<div class="form-group">'
                            +       '<input type="date" class="form-control" id="tgl_byr_selanjutnya" name="tgl_byr_selanjutnya" value="'+v.tgl_byr_selanjutnya+'">'
                            +   '</div>'
                            +'</td>';


                    html += '<td>'
                            +   '<div class="form-group">'
                            +       '<button type="button" class="btn btn-sm btn-success" onclick="updateAngsuran(this)"><i class="fa fa-check"></i>'
                            +       '</button>'
                            +   '</div>'
                            +'</td>';

                    html += '<td>'
                            +   '<div class="form-group">'
                            +       '<button type="button" class="btn btn-sm btn-warning" onclick="batalAngsuran(this)"><i class="fa fa-minus"></i>'
                            +       '</button>'
                            +   '</div>'
                            +'</td>';                            

                    html += '<td>'
                            +   '<div class="form-group">'
                            +       '<button type="button" class="btn btn-sm btn-danger" onclick="deleteAngsuran('+v.id_tagihan_detail+')"><i class="fa fa-trash"></i>'
                            +       '</button>'
                            +   '</div>'
                            +'</td>';

                    html += '</tr>';
                });
                $('#form-body-edit').append(html);
            }
        })
    }

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
            +       '<button type="button" class="btn btn-sm btn-success" onclick="createAngsuran(this)"><i class="fa fa-check"></i>'
            +       '</button>'
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


  function updateAngsuran(id){
    var angsuran = $(id).closest('tr').find('#angsuran').val();
    var jumlah_pembayaran = $(id).closest('tr').find('#jumlah_pembayaran').val();
    var tgl_bayar = $(id).closest('tr').find('#tgl_bayar').val();
    var tgl_byr_selanjutnya = $(id).closest('tr').find('#tgl_byr_selanjutnya').val();
    var keterlambatan = $(id).closest('tr').find('#keterlambatan').val();
    var denda = $(id).closest('tr').find('#denda').val();
    var id_tagihan_detail = $(id).closest('tr').find('#id_tagihan_detail').val();
    var id_tagihan = $(id).closest('tr').find('#id_tagihan').val();
    $.ajax({
        url: "<?= site_url('tagihan/updateTagihanDetail/') ?>" + id_tagihan_detail,
        method: 'post',
        data: {
        angsuran: angsuran,
        jumlah_pembayaran: jumlah_pembayaran,
        tgl_bayar: tgl_bayar,
        tgl_byr_selanjutnya: tgl_byr_selanjutnya,
        keterlambatan: keterlambatan,
        denda: denda,
        id_tagihan : id_tagihan
      },
      success: function(response){
        loadAngsuran();
        window.location.href="<?= site_url('tagihan/edit/').$this->uri->segment(3) ?>";
        toastr.success('Angsuran Berhasil diubah')
      },
      error: function(error){
        toastr.error('Angsuran gagal diubah')
      }
    });
  }

  function batalAngsuran(id){
    var jumlah_pembayaran = $(id).closest('tr').find('#jumlah_pembayaran').val();
    var denda = $(id).closest('tr').find('#denda').val();
    var id_tagihan_detail = $(id).closest('tr').find('#id_tagihan_detail').val();
    var id_tagihan = $(id).closest('tr').find('#id_tagihan').val();
      $.ajax({
          url: "<?= site_url('tagihan/batalAngsuran/') ?>" + id_tagihan_detail,
          method: 'post',
          data: {
          jumlah_pembayaran: jumlah_pembayaran,
          denda: denda,
          id_tagihan: id_tagihan
        },
        success: function(response){
          loadAngsuran();
          window.location.href="<?= site_url('tagihan/edit/').$this->uri->segment(3) ?>";
          toastr.success('Berhasil diubah')
        },
        error: function(error){
          toastr.error('Gagal diubah')
        }
      });
    }  

    function createAngsuran(id)
    {
        var angsuran = $(id).closest('tr').find('#angsuran').val();
        var jumlah_pembayaran = $(id).closest('tr').find('#jumlah_pembayaran').val();
        var tgl_bayar = $(id).closest('tr').find('#tgl_bayar').val();
        var tgl_byr_selanjutnya = $(id).closest('tr').find('#tgl_byr_selanjutnya').val();
        var keterlambatan = $(id).closest('tr').find('#keterlambatan').val();
        var denda = $(id).closest('tr').find('#denda').val();
        var id_tagih = $('#id_tagih').val();
        $.ajax({
          url: '<?= site_url('tagihan/createTagihanDetail') ?>',
          method: 'post',
          data: {
          angsuran: angsuran,
          jumlah_pembayaran: jumlah_pembayaran,
          tgl_bayar: tgl_bayar,
          tgl_byr_selanjutnya: tgl_byr_selanjutnya,
          keterlambatan: keterlambatan,
          denda: denda,
          id_tagih : id_tagih
          },
          success: function(response){
            loadAngsuran();
            window.location.href="<?= site_url('tagihan/edit/').$this->uri->segment(3) ?>";
            toastr.success('Angsuran berhasil dibayar')
          },
          error: function(error){
            toastr.error('Gagal menyimpan')
          }
        });
    }

    function deleteAngsuran(id)
    {
        $.ajax({
          url: '<?= site_url('tagihan/deleteTagihanDetail/') ?>' + id,
          method: 'post',
          success: function(response){
            loadAngsuran();
            toastr.success('Angsuran Berhasil dihapus');
          },
          error: function(error){
            toastr.error('Angsuran gagal dihapus')
          }
        });
    }
</script>