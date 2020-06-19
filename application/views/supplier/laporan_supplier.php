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
    <h5 class="text-center"><strong>DAFTAR KERJASAMA SUPPLIER</strong></h5>
    <br><br><br>
    <div class="container-fluid">
        <table border="1" width="100%" class="table table-bordered" style="font-size:0.9em; margin-left=-10px;">
            <thead>
                <tr>
                <th align="center" width="5%">NO</th>
                <th align="center" width="5%">Kode Supplier</th>
                <th width="20%">Perusahaan</th>
                <th width="20%">Penanggung Jawab</th>
                <th width="13%">Telepon</th>
                <th width="35%">Alamat</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach($report_supplier as $report) : ?>
                <tr>
                    <td align="center"><?= $no++; ?></td>
                    <td width="15%"><?= $report['kodeSupplier'] ?></td>
                    <td width="15%"><?= $report['namaSupplier'] ?></td>
                    <td><?= $report['penanggungJawab'] ?></td>
                    <td><?= $report['telp'] ?></td>
                    <td><?= $report['alamat'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table><br><br><br>

        <table width="100%" align="right" border="0" style='font-size:15px'>
            <tr>
                <td align="left">Dibuat Oleh :<br>Banjarmasin, <?php echo tgl_indo(date('Y-m-d'));?><br><br><br><br>
                    <?php foreach ($penanggung as $jawab) : ?>
                        <u><?= $jawab['namaKaryawan'] ?></u>
                        <br>NIK.<?= $jawab['nik'] ?>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>        
    </div>
</body>
</html>