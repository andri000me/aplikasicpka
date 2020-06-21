<div class="wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card p-3 mb-3">
					<?php foreach($detail_barang_keluar as $barang_keluar) : ?>
					<div class="row">
						<div class="col-lg-12">
							<h5>
								<img src="<?=base_url('assets/login/images/cpka-logo.png')?>" alt="" width="40"> Detail Barang Keluar
								<small class="float-right">Tanggal : <?= date('d/m/Y', strtotime($barang_keluar['tgl_keluar'])) ?></small>
							</h5>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4 mt-4">
						  Pemohon
		                  <address>
		                    <strong><?= $barang_keluar['nama_karyawan'] ?></strong><br>
		                    Karyawan : <?= $barang_keluar['keterangan'] ?><br>
		                  </address>							
						</div>

						<div class="col-sm-4 mt-4">
							Admin
		                  	<address>
		                    	<strong>PT. Citra Putra Kebun Sari</strong><br>
		                    	Penanggung Jawab : Fahrul Razzi<br>
		                    	Alamat : Jl. Kebun Sayur<br>
		                    	Phone: 089627306954<br>
		                  	</address>							
						</div>

		                <div class="col-sm-4 mt-4">
		                  <b>Invoice #<?= $barang_keluar['kode_keluar'] ?></b><br>
		                  <b>Tanggal Keluar:</b> <?= date('d/m/Y', strtotime($barang_keluar['tgl_keluar'])) ?><br>
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
		                    	foreach($detail_barang_keluar_semua as $detail_barang) : ?>
		                    	<tr>
		                      		<td><?= $no++; ?></td>
		                      		<td><?= $detail_barang['kodeBarang'] ?></td>
		                      		<td><?= $detail_barang['namaBarang'] ?></td>
		                      		<td><?= rupiah($detail_barang['harga']) ?></td>
		                      		<td><?= $detail_barang['jumlah_keluar'].' '.$detail_barang['satuan'] ?></td>
		                      		<td><?= rupiah($detail_barang['subtotal']) ?></td>
		                      		<?php 
		                      			$tot += intval($detail_barang['subtotal']);
		                      			$total += intval($detail_barang['subtotal']);
		                      			$ppn = 0.1;
		                      			$hitung_ppn = $total * $ppn;
		                      			$subtotal = $total + $hitung_ppn;
		                      		?>
		                      		<?php $totalqty += intval($detail_barang['jumlah_keluar']); ?>
		                    	</tr>
		                    	<?php endforeach; ?>
		                    </tbody>
		                  </table>
		                </div>
					</div>

              		<div class="row">
              			<div class="col-lg-4">
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
							<a href="<?= site_url('barang-keluar') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-arrow-circle-left"></i> Kembali</a>							
						  	<a href="<?= site_url('barang-keluar/print-detail-barang-keluar/').$detail_barang['id_keluar'] ?>" target="_blank" class="btn btn-sm btn-success float-right"><i class="fas fa-print"></i> Print</a>
						</div>
					</div>              							
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>
