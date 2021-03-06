<html lang="en">
<head>
    <script>window.print()</script>
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
        table.table-bordered{
            border:1px solid black;
        }
        table.table-bordered > thead > tr > th{
            border:1px solid black;
        }
        table.table-bordered > tbody > tr > td{
            border:1px solid black;
        }
    </style>
</head>

<body>
    <p align="center"><img src="<?= base_url('assets/img/kop.jpg') ?>" alt=""></p>
    <h5 class="text-center"><strong>LAPORAN BARANG KELUAR</strong></h5>
    <br><br><br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <?php foreach($data_barang_keluar as $barang_keluar) : ?>
                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-sm table-secondary">
                            <thead>
                                <tr>
                                    <th>NO. Keluar</th>
                                    <td> : <?= $barang_keluar['kode_keluar'] ?></td>
                                    <th>Tanggal Keluar</th>
                                    <td> : <?= tgl_indo($barang_keluar['tgl_keluar']) ?></td>
                                    <th>Nama Pemohon</th>
                                    <td> : <?= $barang_keluar['nama_karyawan'] ?></td>
                                    <th>Keterangan</th>
                                    <td> : <?= $barang_keluar['keterangan'] ?></td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-lg-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 1px;">NO</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Harga Beli</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $no = 1;
                                    $total = 0;
                                    $totalppn = 0;
                                    $totalqty= 0;
                                ?>
                                <?php foreach($barang_keluar['keluar'] as $keluar) : ?>
                                <?php
                                    $total += intval($keluar['subtotal']);
                                    $totalqty += intval($keluar['jumlah_keluar']);
                                    $ppn = 0.1;
                                    $hitung_ppn = $total * $ppn;
                                    $totalppn = $total + $hitung_ppn;
                                 ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $keluar['kode_barang'] ?></td>
                                    <td><?= $keluar['nama_barang'] ?></td>
                                    <td><?= $keluar['jumlah_keluar'].' '.$keluar['satuan'] ?></td>
                                    <td><?= rupiah($keluar['harga_beli']) ?></td>
                                    <td><?= rupiah($keluar['subtotal']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        <table class="table-sm">
                            <tr>
                                <th style="width:50%">Total Qty</th>
                                <td>: <?= $totalqty. ' Qty' ?></td>
                            </tr>
                             <tr>
                                <th style="width:50%">Total</th>
                                <td>: <?= rupiah($total) ?></td>
                            </tr>
                            <tr>
                                <th style="width:50%">PPN(10%)</th>
                                <td>: <?= rupiah($hitung_ppn) ?></td>
                            </tr>
                            <tr>
                            <th style="width:50%">Total + PPN(10%)</th>
                            <td>: <?= rupiah($totalppn) ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br><br><br>
                <?php endforeach; ?>
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