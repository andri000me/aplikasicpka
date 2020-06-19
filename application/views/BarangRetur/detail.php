<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card p-3 mb-3">
					<?php foreach($detail_barang_retur as $barang_retur) : ?>
					<div class="row">
						<div class="col-lg-12">
							<h5>
								<i class="fa fa-globe"></i> Detail Barang Retur
								<small class="float-right">Tanggal : <?= date('d/m/Y', strtotime($barang_retur['tgl_retur'])) ?></small>
							</h5>
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
		                    	$tot = 0;
		                    	$totalqty = 0;
		                    	foreach($detail_barang_retur_semua as $detail_barang) : ?>
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

					<div class="row no-print">
						<div class="col-12">
							<a href="<?= site_url('barang-retur') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>							
						  	<a href="<?= site_url('barang-retur/print-detail-barang-retur/').$detail_barang['id_retur'] ?>" target="_blank" class="btn btn-sm btn-success float-right"><i class="fas fa-print"></i> Print</a>
						</div>
					</div>              							
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
