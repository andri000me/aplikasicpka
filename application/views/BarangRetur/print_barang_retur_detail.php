<!DOCTYPE html>
<html>
<head>
	<title>Print Barang Retur Detail</title>
	<script type="text/javascript">window.print()</script>
	<link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
</head>
<body>
<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card p-3 mt-1">
					<?php foreach($print_barang_retur as $barang_retur) : ?>
					<div class="row">
						<div class="col-lg-12">
							<h5>
								<img src="<?=base_url('assets/login/images/cpka-logo.png')?>" alt="" width="40"> <strong>PT. CPKA</strong>
								<small class="float-right">Tanggal : <?= date('d/m/Y', strtotime($barang_retur['tgl_retur'])) ?></small>
							</h5>
							<hr>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4 mt-4">
						  Penerima
		                  <address>
		                    <strong><?= $barang_retur['nama_supplier'] ?></strong><br>
		                    Penanggung Jawab : <?= $barang_retur['penanggungJawab'] ?><br>
		                    Alamat : <?= $barang_retur['alamat'] ?><br>
		                    Phone: <?= $barang_retur['telp'] ?><br>
		                  </address>							
						</div>

						<div class="col-sm-4 mt-4">
							Pengirim
		                  	<address>
		                    	<strong>PT. Citra Putra Kebun Sari</strong><br>
		                    	Penanggung Jawab : Fahrul Razzi<br>
		                    	Alamat : Jl. Kebun Sayur<br>
		                    	Phone: 089627306954<br>
		                  	</address>							
						</div>

		                <div class="col-sm-4 mt-4">
		                  <b>Invoice #<?= $barang_retur['kode_retur'] ?></b><br>
		                  <b>Jatuh Tempo:</b> <?= date('d/m/Y', strtotime($barang_retur['tgl_retur'])) ?><br>
		                </div>	
					</div>

					<div class="row">
		                <div class="col-12 table-responsive">
		                	<table class="table table-striped">
		                    	<thead>
		                    		<tr>
		                    			<th>No</th>
		                      			<th>Kode Barang</th>
					                    <th>Nama Barang</th>
				                    	<th>Harga</th>
					                    <th>Qty</th>
					                    <th>Subtotal</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
		                    	<?php 
		                    	$no = 1;
		                    	$total = 0;
		                    	$totalqty = 0;
		                    	$tot = 0;
		                    	foreach($print_barang_retur_detail as $detail_barang) : ?>
		                    	<tr>
		                      		<td><?= $no++; ?></td>
		                      		<td><?= $detail_barang['kodeBarang'] ?></td>
		                      		<td><?= $detail_barang['namaBarang'] ?></td>
		                      		<td><?= rupiah($detail_barang['harga']) ?></td>
		                      		<td><?= $detail_barang['jumlah_retur'].' '.$detail_barang['satuan'] ?></td>
		                      		<td><?= rupiah($detail_barang['subtotal']) ?></td>
		                      		<?php 
		                      			$tot += intval($detail_barang['subtotal']); 
		                      			$total += intval($detail_barang['subtotal']); 
		                      			$ppn = 0.1;
		                      			$hitung_ppn = $total * $ppn;
		                      			$subtotal = $total + $hitung_ppn;
		                      		?>
		                      		<?php $totalqty += intval($detail_barang['jumlah_retur']); ?>
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
		                        	<th style="width:50%">Total Qty</th>
		                        	<td>: <?= $totalqty. ' Qty' ?></td>
		                      	</tr>	
		                      	<tr>
		                        	<th style="width:50%">Total</th>
		                        	<td>: <?= rupiah($tot) ?></td>
		                    	</tr>		                      			                    	
		                      	<tr>
		                        	<th style="width:50%">PPN(10%)</th>
		                        	<td>: <?= rupiah($hitung_ppn) ?></td>
		                    	</tr>
		                      	<tr>
		                        	<th style="width:50%">Total + PPN(10%)</th>
		                        	<td>: <?= rupiah($subtotal) ?></td>
		                    	</tr>			                    	
		                    </table>
                		</div>              		
                	</div>              							
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>