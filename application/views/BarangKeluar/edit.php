<div class="wrapper">
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card">
          <div class="card-body">
            <div class="card-title">
              <div class="text-center">
                <h3>
                Edit Barang keluar
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
                    <input type="hidden" name="id_barang_keluar" id="id_barang_keluar" value="<?= $edit_barang_keluar['id'] ?>">                    
                    <input type="date" name="tgl_keluar" class="form-control" value="<?= $edit_barang_keluar['tgl_keluar'] ?>">
                  </div>
                </div>

                <div class="col-lg-3">
                  <div class="form-group">
                    <label>Nama Karyawan</label>
                    <select name="karyawan" class="custom-select form-control">
                      <option value="" disabled selected>Pilih Karyawan</option>
                      <?php foreach ($karyawan as $kry) : ?>
                        <?php if($kry['id'] == $edit_barang_keluar['id_karyawan']) : ?>
                        <option value="<?= $kry['id'] ?>" selected><?= $kry['namaKaryawan'] ?></option>
                        <?php else : ?>
                        <option value="<?= $kry['id'] ?>"><?= $kry['namaKaryawan'] ?></option>
                        <?php endif ?>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>                

                <div class="col-lg-6">
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= $edit_barang_keluar['keterangan'] ?>">
                  </div>
                </div>

                <div class="col-lg-12 mt-4">
                  <div class="form-group">
                    <button  type="button" onclick="addBarang()" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Tambah Barang</button>
                  </div>
                </div>

                <div class="col-lg-12">
                  <table class="table table-sm table-bordered" id="tabelBarang">
                    <thead>
                      <th>Barang</th>
                      <th>Harga</th>
                      <th style="width: 120px;">Stok</th>
                      <th style="width: 150px;">Satuan</th>
                      <th style="width: 120px;">Qty</th>
                      <th colspan="3" class="text-center">Aksi</th>
                    </thead>

                    <tbody id="form-body-edit">
                      
                    </tbody>
                  </table>
                </div>

                <div class="col-lg-12">
                  <div class="form-group">
                    <div class="text-center m-t-0">
                      <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa fa-save"></i> Ubah
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
      loadBarang();  
});

    function loadBarang(){
        $.ajax({
            url: "<?= site_url('BarangKeluar/getBarangKeluarDetail/' . $this->uri->segment(3)) ?>",
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
                    html += '<tr>'
                            + '<td>'
                            +   '<div class="form-group">'
                            +     '<input type="hidden" class="form-control" id="id_barang_keluar_detail" name="id_barang_keluar_detail" placeholder="" readonly value="'+v.id_barang_keluar_detail+'">'
                            +     '<input type="hidden" class="form-control" id="id_barang" name="id_beli" value="'+v.id_barang+'" >'
                            +     '<input type="text" class="form-control" id="id_barang" name="id_barang" placeholder="" readonly value="'+v.namaBarang+'">'
                            +   '</div>'
                            + '</td>';

                    html += '<td>'
                            + '<div class="form-group">'
                            +   '<input type="text" class="form-control" id="harga" name="harga" placeholder="harga" readonly value="'+v.harga+'">'
                            + '</div>'
                            +'</td>';

                    html += '<td>'
                            + '<div class="form-group">'
                            +   '<input type="text" class="form-control" id="stok" name="stok" placeholder="stok" readonly value="'+v.stok+'">'
                            + '</div>'
                            +'</td>';                            

                    html += '<td>'
                            + '<div class="form-group">'
                            +   '<input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan" readonly value="'+v.satuan+'">'
                            + '</div>'
                            +'</td>';

                    html +='<td>'
                            + '<div class="form-group">'
                            +   '<input type="text" class="form-control" id="qty" name="qty" placeholder="Qty" value="'+v.jumlah_keluar+'">'
                            + '</div>'
                            +'</td>';

                    html += '<td>'
                            + '<div class="form-group">'
                            +   '<button type="button" class="btn btn-sm btn-success" onclick="updateBarang(this)"><i class="fa fa-check"></i>'
                            +   '</button>'
                            + '</div>'
                            +'</td>';

                    html += '<td>'
                            + '<div class="form-group">'
                            +   '<button type="button" class="btn btn-sm btn-warning" onclick="deleteQty(this)"><i class="fa fa-minus"></i>'
                            +   '</button>'
                            + '</div>'
                            +'</td>';

                    html += '<td>'
                            + '<div class="form-group">'
                            +   '<button type="button" class="btn btn-sm btn-danger" onclick="deleteBarang('+v.id_barang_keluar_detail+')"><i class="fa fa-trash"></i>'
                            +   '</button>'
                            + '</div>'
                            +'</td>';

                    html += '</tr>';
                });
                $('#form-body-edit').append(html);
            }
        })
    }

  function addBarang()
  {
    var html ='';

    html += '<tr>'
            + '<td>'
            +   '<div class="form-group">'
            +     '<select class="form-control" id="id_barang" name="id_barang[]">'
            +       '<option value="" disabled selected>--Pilih Barang--</option>'
            +       '<?php foreach ($barang as $data): ?>'
            +       '<option id="barang-<?= $data['id'] ?>"'
            +         'value="<?= $data['id'] ?>" data-satuan="<?= $data['satuan'] ?>"'
            +         ' data-harga = "<?= $data['hargaBeli'] ?>"'
            +         ' data-stok = "<?= $data['stok'] ?>">'
            +         '<?= $data['kodeBarang'] . ' - ' . $data['namaBarang'] . ' - ' . $data['stok'] . '  ' . $data['satuan'] ?>'
            +       '</option><?php endforeach ?>'
            +      '</select>'
            +   '</div>'
            + '</td>';

    html += '<td>'
            + '<div class="form-group">'
            +   '<input type="text" class="form-control" id="harga" name="harga[]" placeholder="Harga" readonly>'
            + '</div>'
            +'</td>';            

    html += '<td>'
            + '<div class="form-group">'
            +   '<input type="text" class="form-control" id="stok" name="stok[]" placeholder="Stok" readonly>'
            + '</div>'
            +'</td>';

    html += '<td>'
            + '<div class="form-group">'
            +   '<input type="text" class="form-control" id="satuan" name="satuan[]" placeholder="Satuan" readonly>'
            + '</div>'
            +'</td>';

    html +='<td>'
            + '<div class="form-group">'
            +   '<input type="number" class="form-control" id="qty" name="qty[]" placeholder="Qty">'
            + '</div>'
            +'</td>';

    html += '<td>'
            + '<div class="form-group">'
            +   '<button type="button" class="btn btn-sm btn-success" onclick="createBarang(this)"><i class="fa fa-check"></i>'
            +   '</button>'
            + '</div>'
            +'</td>';            

    html += '<td class="text-center">'
            + '<div class="form-group">'
            +   '<button type="button" class="btn btn-sm btn-warning" onclick="removeRow(this)"><i class="fa fa-minus"></i>'
            +   '</button>'
            + '</div>'
            +'</td>';

    html += '</tr>';

    $('#form-body-edit').append(html);
  }

  function removeRow($id)
  {
    $id.closest('tr').remove();
  }

  function updateBarang(id){
    var qty = $(id).closest('tr').find('#qty').val();
    var id_barang = $(id).closest('tr').find('#id_barang').val();
    var id_barang_keluar_detail = $(id).closest('tr').find('#id_barang_keluar_detail').val();
    $.ajax({
        url: "<?= site_url('BarangKeluar/updateBarangKeluarDetail/') ?>" + id_barang_keluar_detail,
        method: 'post',
        data: {
        qty: qty,
        id_barang: id_barang
      },
      success: function(response){
        loadBarang();
        toastr.success('Qty berhasil diubah')
      },
      error: function(error){
        toastr.error('Qty gagal ditambah')
      }
    });
  }

  function deleteQty(id){
    var qty = $(id).closest('tr').find('#qty').val();
    var id_barang = $(id).closest('tr').find('#id_barang').val();
    var id_barang_keluar_detail = $(id).closest('tr').find('#id_barang_keluar_detail').val();
      $.ajax({
          url: "<?= site_url('BarangKeluar/deleteQtyBarang/') ?>" + id_barang_keluar_detail,
          method: 'post',
          data: {
          qty: qty,
          id_barang: id_barang
        },
        success: function(response){
          loadBarang();
          toastr.success('Qty berhasil dihapus')
        },
        error: function(error){
          toastr.error('Qty gagal dihapus')
        }
      });
    }

    function createBarang(id)
    {
        var id_barang = $(id).closest('tr').find('#id_barang').val();
        var qty = $(id).closest('tr').find('#qty').val();
        var id_barang_keluar = $('#id_barang_keluar').val();
        $.ajax({
          url: '<?= site_url('BarangKeluar/createBarangKeluarDetail') ?>',
          method: 'post',
          data: {
            id_barang:id_barang,
            qty: qty,
            id_barang_keluar: id_barang_keluar
          },
          success: function(response){
            loadBarang();
            toastr.success('Barang berhasil ditambahkan')
          },
          error: function(error){
            toastr.error('Barang gagal ditambahkan')
          }
        });
    }

    function deleteBarang(id)
    {
        $.ajax({
          url: '<?= site_url('BarangKeluar/deleteBarangKeluarDetail/') ?>' + id,
          method: 'post',
          success: function(response){
            loadBarang();
            toastr.success('Barang berhasil dihapus');
          },
          error: function(error){
            toastr.error('Barang gagal dihapus')
          }
        });
    }

  $('#barangkeluar-form').submit(function(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url: "<?= site_url('BarangKeluar/update/').$this->uri->segment(3) ?>",
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
          window.location.href="<?= site_url('BarangKeluar'); ?>";
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
</script>