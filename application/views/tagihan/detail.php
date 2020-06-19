<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card p-3 mb-3">
					<?php $total = 0; ?>
					<?php foreach($detail_tagihan as $tagihan) : ?>
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
		                    	foreach($detail_tagihan_semua as $detail_tagih) : ?>
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

					<div class="row no-print">
						<div class="col-12">
							<a href="<?= site_url('tagihan') ?>" class="btn btn-secondary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>							
						  	<a href="<?= site_url('tagihan/printDetailTagihan/').$detail_tagih['id_tagihan'] ?>" target="_blank" class="btn btn-success float-right"><i class="fas fa-print"></i> Print</a>
						</div>
					</div>              							
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
