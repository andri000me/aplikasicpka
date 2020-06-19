<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detail Piutang</title>
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
				<div class="card p-3 mb-3">
					<?php $total = 0; ?>
					<?php foreach($print_penagihan as $penagihan) : ?>
					<?php  
						$total += intval($penagihan['subtotal']);
						$ppn = 0.1;
						$hitung_ppn = $total * $ppn;
						$totalppn = $total + $hitung_ppn;
					?>
					<div class="row">
						<div class="col-lg-12">
							<h5>
								<i class="fa fa-globe"></i> Detail Piutang
								<small class="float-right"><h5><b>#<?= $penagihan['kode_penagihan'] ?></b></h5></small>
							</h5>
						</div>
					</div>

					<div class="row mt-4">
						<div class="col-sm-5 mt-4">
						  Customer
		                  <address>
		                    <strong><?= $penagihan['nama_customer'] ?></strong><br>
		                    Alamat<br><strong><?= $penagihan['alamat_customer']. ' | Telp : '.$penagihan['telp_customer'] ?></strong><br>
		                    Nomor Penjualan<br><strong><?= $penagihan['kode_barang_jual'] ?></strong><br>
		                  </address>							
						</div>

						<div class="col-sm-4 mt-4">
							Jangka Waktu
		                  	<address>
		                    	<strong><?= $penagihan['jangka_waktu']. ' Bulan' ?></strong><br>
		                  		Tanggal Transaksi<br><strong><?= tgl_indo($penagihan['tgl_jual']) ?></strong><br>
		                  		Jatuh Tempo<br><strong><?= tgl_indo($penagihan['tgl_tempo']) ?></strong><br>
		                  	</address>							
						</div>

						<div class="col-sm-3 mt-4">
							Hutang + PPN(10%)
		                  	<address>
		                    	<strong><?= rupiah($totalppn) ?></strong><br>
		                  		Angsuran Perbulan<br><strong><?= rupiah($penagihan['angsuran_perbulan']) ?></strong><br>
		                  		Sisa Hutang<br>
		                  		<strong>
		                  		<?php if($penagihan['sisa_hutang'] > 0) : ?>
			                  		<?= rupiah($penagihan['sisa_hutang']) ?>
			                  	<?php else : ?>
			                  		<?= rupiah(0) ?>
			                  	<?php endif; ?>
		                  		</strong><br>
		                  	</address>	
						</div>
						
						<div class="col-lg-12 mt-4 mb-0">
							<h2 class="text-center"><?= $penagihan['status'] ?></h2>
						</div>

						<div class="col-lg-12">
							<table class="table table-info mt-0">
								<thead>
									<tr>
										<th>Nama Barang</th>
										<th>Jumlah</th>
										<th>Satuan</th>
										<th>Harga</th>
										<th>Total</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><?= $penagihan['nama_barang_jual'] ?></td>
										<td><?= $penagihan['jumlah_jual'] ?></td>
										<td><?= $penagihan['satuan'] ?></td>
										<td><?= rupiah($penagihan['harga_jual']) ?></td>
										<td><?= rupiah($penagihan['subtotal']) ?></td>
									</tr>
								</tbody>
							</table>
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
		                    	foreach($print_penagihan_semua as $detail_tagih) : ?>
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
		                        	<th style="width:70%">Total Angsuran</th>
		                        	<td>: <?= rupiah($totalAngsuran) ?></td>
		                      	</tr>

		                      	<tr>
		                        	<th style="width:70%">Sisa Hutang Yang Harus Di Bayar</th>
		                        	<?php 
		                        		$sisa = ($denda + $totalppn) - $totalAngsuran;
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
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
