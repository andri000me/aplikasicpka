<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card p-3 mb-3">
					<?php $total = 0; ?>
					<?php foreach($detail_penagihan as $penagihan) : ?>
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

					<div class="row">
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
							<?php if($penagihan['status'] == 'Belum Lunas') : ?>
								<h2 class="text-center text-danger"><?= $penagihan['status'] ?></h2>
							<?php else : ?>
								<h2 class="text-center text-success"><?= $penagihan['status'] ?></h2>
							<?php endif; ?>
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
		                    	foreach($detail_penagihan_semua as $detail_tagih) : ?>
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

					<div class="row no-print">
						<div class="col-12">
							<a href="<?= site_url('penagihan') ?>" class="btn btn-secondary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>							
						  	<a href="<?= site_url('penagihan/printDetailPenagihan/').$detail_tagih['id_penagihan'] ?>" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>
						</div>
					</div>              							
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
