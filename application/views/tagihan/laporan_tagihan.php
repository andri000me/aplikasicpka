<html lang="en">
<head>
    <script>window.print()</script>
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <p align="center"><img src="<?= base_url('assets/img/kop.jpg') ?>" alt=""></p>
    <h5 class="text-center"><strong>LAPORAN TAGIHAN PER SUPPLIER</strong></h5>
    <?php $total = 0; $i= 0 ?>
    <?php foreach($data_tagihan as $tagihan) : ?>
    <?php  
        $total += intval($tagihan['subtotal']);
        $ppn = 0.1;
        $hitung_ppn = $total * $ppn;
        $totalppn = $total + $hitung_ppn;
        $retur = $tagihan['jumlah_retur'];
    ?>
    <?php if($i == 0) : ?>
    <h6 class="text-center"><b><?= $tagihan['nama_supplier'] ?></b></h6>
    <h6 class="text-center"><?= $tagihan['alamat_supplier']. ', Telp. '.$tagihan['telp_supplier'] ?></h6>
    <?php endif; ?>
    <?php $i++; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="row mt-4">
                    <div class="col-sm-6 mt-4">
                      <address>
                        Kode Tagihan : <strong><?= $tagihan['kode_tagihan'] ?></strong><br>
                        Nomor Pembelian : <strong><?= $tagihan['kode_barang_masuk'] ?></strong><br>
                        Nomor Retur : <strong><?= $tagihan['no_retur'] ?></strong><br>
                        Jangka Waktu : <strong><?= $tagihan['jangka_waktu']. ' Bulan' ?></strong>                        
                      </address>                            
                    </div>

                    <div class="col-sm-6 mt-4">
                        <address>
                            Tanggal Transaksi : <strong><?= tgl_indo($tagihan['tgl_masuk']) ?></strong><br>
                            Jatuh Tempo : <strong><?= tgl_indo($tagihan['tgl_tempo']) ?></strong><br>
                            Angsuran Perbulan : <strong><?= rupiah($tagihan['angsuran_perbulan']) ?></strong>                   
                        </address>                          
                    </div>
                    
                    <div class="col-lg-12 mt-2 mb-0">
                        <h2 class="text-center"><?= $tagihan['status'] ?></h2>
                    </div>
                </div>
                    

                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Angsuran</th>
                                    <th>Jumlah Angsuran</th>
                                    <th>Tanggal Pembayaran</th>
                                    <th>Tanggal Bayar Selanjutnya</th>
                                    <th>Keterlambatan</th>
                                    <th>Denda</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $no = 1;
                            $totalAngsuran = 0;
                            $denda = 0;
                            foreach($tagihan['tagihan'] as $detail_tagih) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $detail_tagih['angsuran'] ?></td>
                                <td><?= rupiah($detail_tagih['jumlah_bayar']) ?></td>
                                <td><?= tgl_indo($detail_tagih['tgl_bayar']) ?></td>
                                <td><?= tgl_indo($detail_tagih['tgl_byr_selanjutnya']) ?></td>
                                <td><?= $detail_tagih['keterlambatan'] ?></td>
                                <td><?= rupiah($detail_tagih['denda']) ?></td>
                                <?php 
                                    $totalAngsuran += intval($detail_tagih['jumlah_bayar']);
                                    $denda += intval($detail_tagih['denda']);
                                    ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <table class="table">
                            <tr>
                                <th style="width:70%">Denda</th>
                                <td>: <?= rupiah($denda); ?></td>
                            </tr>                                   

                            <tr>
                                <th style="width:70%">Total Hutang</th>
                                <td>: <?= rupiah($totalppn) ?></td>
                            </tr>

                            <tr>
                                <th style="width:70%">Total Retur</th>
                                <td>: <?= rupiah($tagihan['jumlah_retur']) ?></td>
                            </tr>                                                                                         

                            <tr>
                                <th style="width:70%">Total Angsuran</th>
                                <td>: <?= rupiah($totalAngsuran) ?></td>
                            </tr>

                            <tr>
                                <th style="width:70%">Sisa Hutang Yang Harus Di Bayar</th>
                                <?php 
                                    $sisa = ($denda + $totalppn - $totalAngsuran) - $retur;
                                ?>
                                <td>
                                    <?php if($sisa > 0) : ?>
                                        <?= rupiah($sisa) ?>
                                    <?php else : ?>
                                        <?= rupiah(0) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>                               
                        </table>
                    </div>
                </div>
                <?php endforeach; ?>
                <br><br><br>
                <table width="100%" align="right" border="0" style='font-size:15px'>
                    <tr>
                        <td align="left">Dibuat Oleh :<br>Banjarmasin, <?= tgl_indo(date('Y-m-d'));?><br><br><br><br>
                            <?php foreach ($penanggung as $jawab) : ?>
                                <u><?= $jawab['namaKaryawan'] ?></u>
                                <br>NIK. <?= $jawab['nik'] ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>                
            </div>
        </div>
    </div>
</body>
</html>