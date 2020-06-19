<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Detail Hutang</title>
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
					<?php foreach($print_tagihan as $tagihan) : ?>
					<?php  
						$total += intval($tagihan['subtotal']);
						$ppn = 0.1;
						$hitung_ppn = $total * $ppn;
						$totalppn = $total + $hitung_ppn;
							$retur = $tagihan['jumlah_retur'];
					?>
					<div class="row">
						<div class="col-lg-12">
							<h5>
								<i class="fa fa-globe"></i> Detail Hutang
								<small class="float-right"><h5><b>#<?= $tagihan['kode_tagihan'] ?></b></h5></small>
							</h5>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-5 mt-4">
						  Supplier
		                  <address>
		                    <strong><?= $tagihan['nama_supplier'] ?></strong><br>
		                    Alamat<br><strong><?= $tagihan['alamat_supplier']. ' | Telp : '.$tagihan['telp_supplier'] ?></strong><br>
		                    Nomor Pembelian<br><strong><?= $tagihan['kode_barang_masuk'] ?></strong><br>
		                    Nomor Retur<br><strong><?= $tagihan['no_retur'] ?></strong><br>
		                  </address>							
						</div>

						<div class="col-sm-4 mt-4">
							Jangka Waktu
		                  	<address>
		                    	<strong><?= $tagihan['jangka_waktu']. ' Bulan' ?></strong><br>
		                  		Tanggal Transaksi<br><strong><?= tgl_indo($tagihan['tgl_masuk']) ?></strong><br>
		                  		Jatuh Tempo<br><strong><?= tgl_indo($tagihan['tgl_tempo']) ?></strong><br>
		                  	</address>							
						</div>

						<div class="col-sm-3 mt-4">
							Hutang + PPN(10%)
		                  	<address>
		                    	<strong><?= rupiah($totalppn) ?></strong><br>
		                  		Retur + PPN(10%)<br><strong><?= rupiah($tagihan['jumlah_retur']) ?></strong><br>
		                  		Angsuran Perbulan<br><strong><?= rupiah($tagihan['angsuran_perbulan']) ?></strong><br>
		                  		Sisa Hutang<br>
		                  		<strong>
		                  		<?php if($tagihan['sisa_hutang'] > 0) : ?>
			                  		<?= rupiah($tagihan['sisa_hutang']) ?>
			                  	<?php else : ?>
			                  		<?= rupiah(0) ?>
			                  	<?php endif; ?>
		                  		</strong><br>
		                  	</address>	
						</div>
						
						<div class="col-lg-12 mt-4 mb-0">
							<?php if($tagihan['status'] == 'Belum Lunas') : ?>
								<h2 class="text-center text-danger"><?= $tagihan['status'] ?></h2>
							<?php else : ?>
								<h2 class="text-center text-success"><?= $tagihan['status'] ?></h2>
							<?php endif; ?>
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
		                    	foreach($print_tagihan_semua as $detail_tagih) : ?>
	                            <?php if($detail_tagih['jatuh_tempo'] > 0 and $detail_tagih['jatuh_tempo'] <= 7) : ?>
	                            <tr class="table-warning">
	                            <?php elseif ($detail_tagih['jatuh_tempo'] < 0 and $detail_tagih['jatuh_tempo'] >= -7) : ?>
	                            <tr class="table-danger">
	                            <?php elseif ($detail_tagih['jatuh_tempo'] == 0) : ?>
	                            <tr class="table-info">
	                            <?php else : ?>
	                            <tr>
	                            <?php endif; ?>
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
		                        	<th style="width:50%">Denda</th>
		                        	<td>: <?= rupiah($denda); ?></td>
		                    	</tr>			                    	

		                      	<tr>
		                        	<th style="width:50%">Total Hutang</th>
		                        	<td>: <?= rupiah($totalppn) ?></td>
		                      	</tr>		                      				                    	

		                      	<tr>
		                        	<th style="width:50%">Total Angsuran</th>
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
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
