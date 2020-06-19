<?php

class BarangRetur_model extends CI_Model {

	public function get_all_barang_retur()
	{
		$query = $this->db->query("
			select barang_retur.*,
			supplier.namaSupplier as nama_supplier 
			from barang_retur
			inner join supplier on supplier.id = barang_retur.id_supplier order by tgl_retur desc	
		");
		return $query->result_array();
	}

	public function get_all_barang_retur_detail()
	{
		$query = $this->db->query("
			select barang_retur_detail.id_barang, 
			sum(barang_retur_detail.jumlah_retur * barang.hargaBeli) as subtotal, barang_retur.kode_retur, barang_retur.tgl_retur,
			barang_retur.id_supplier, supplier.namaSupplier as nama_supplier,
			barang.namaBarang as nama_barang, barang_retur.id
			from barang_retur_detail
			inner join barang_retur on barang_retur.id =barang_retur_detail.id_retur
			inner join supplier on supplier.id = barang_retur.id_supplier
			inner join barang on barang.id =barang_retur_detail.id_barang group by barang_retur_detail.id_retur
		");
		return $query->result_array();
	}	

	public function get_barang_retur($id)
	{

		$query = $this->db->query("select * from barang_retur where id = ?", $id);
		return $query->row_array();
	}

	public function create_barang_retur($data)
	{
		$this->db->insert('barang_retur', $data);
		return $this->db->insert_id();
	}

    public function generate_kode_retur($id_retur)
    {
		$this->db->query(
			"update barang_retur
			 set kode_retur = CONCAT( 'RTR', LPAD($id_retur,7,'0') )
        	 where id = $id_retur "
		);
        $query = $this->db->query("select kode_retur from barang_retur where id = $id_retur");
        return $query->row_array()['kode_retur'];
    }

	public function create_barang_retur_detail($id_retur, $data)
	{
		$this->db->trans_start();
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = array(
				'id_retur' => $id_retur,
				'id_barang' => $_POST['id_barang'][$key],
				'jumlah_retur' => $_POST['qty'][$key],
				'keterangan' => $_POST['keterangan'][$key],
			);

			$this->db->set('stok', 'stok-'.$_POST['qty'][$key], false);
			$this->db->where('id', $_POST['id_barang'][$key]);
			$this->db->update('barang');
		}
			$this->db->insert_batch('barang_retur_detail', $result);
		$this->db->trans_complete();
	}    

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('barang_retur', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('barang_retur');
	}

	public function check_detail_barang_retur($id)
	{
		$query = $this->db->query(
			'select 
				    count(*) as total 
			from barang_retur_detail 
			where id_retur = ?
			', $id);
		return $query->row()->total;
	}	

	public function get_barang_retur_detail($id)
	{
		$query = $this->db->query(
			"select
					(barang_retur_detail.jumlah_retur * barang.hargaBeli) as subtotal, barang_retur_detail.keterangan,
				    barang_retur_detail.id as id_barang_retur_detail, barang_retur_detail.id_retur,
					barang_retur_detail.id_barang, barang.kodeBarang, barang.namaBarang,
					barang.hargaBeli as harga, barang.stok, barang.satuan, barang_retur_detail.jumlah_retur
			 from barang_retur_detail
			 join barang on barang.id = barang_retur_detail.id_barang
			 where barang_retur_detail.id_retur = ? ", $id
		);

		return $query->result_array();
	}

	public function create_barang_retur_detail_satuan($data)
	{
		$this->db->set('stok', 'stok-'.$data['jumlah_retur'], false);
		$this->db->where('id', $data['id_barang']);
		$this->db->update('barang');
		$this->db->insert('barang_retur_detail', $data);
	}    

	public function update_barang_retur_detail($id, $data)
	{
		$sql = "update barang_retur_detail, barang
				set barang_retur_detail.jumlah_retur = " .$data['jumlah_retur'] . ",
					barang_retur_detail.keterangan = '".$data['keterangan']."',
					barang.stok = stok - ".$data['jumlah_retur']."
				where barang_retur_detail.id = " . $id." and barang.id = ".$data['id_barang']."";

		$this->db->query($sql);
	}

	public function delete_qty_barang($id, $data)
	{
		$sql = "update barang_retur_detail, barang
				set barang_retur_detail.jumlah_retur = jumlah_retur -".$data['jumlah_retur'].", 
					barang.stok = stok + ".$data['jumlah_retur']."
				where barang_retur_detail.id = " . $id." and barang.id = ".$data['id_barang']."";
		$this->db->query($sql);
	}	

	public function delete_barang_retur_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('barang_retur_detail');
	}

	public function detail_barang_retur($id)
	{
		$query = $this->db->query(
			'select 
				    barang_retur.*, supplier.namaSupplier as nama_supplier, supplier.alamat,supplier.telp, supplier.penanggungJawab
			 from barang_retur
			 inner join supplier on supplier.id = barang_retur.id_supplier
			 where barang_retur.id = ?', $id);
		return $query->result_array();
	}			

	public function total_barang_retur()
	{
		$query = "select count(*) as total from barang_retur";
		return $this->db->query($query)->row_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_laporan_barang_retur($tglAwal, $tglAkhir)
	{
		$query = "select 
						 barang_retur.*, supplier.namaSupplier as nama_supplier, barang_retur.id as id_retur
						 from barang_retur
						 inner join supplier on supplier.id = barang_retur.id_supplier
						 where tgl_retur between '$tglAwal' and '$tglAkhir';
				 ";
		return $this->db->query($query)->result_array();
	}

	public function get_barang_retur_detail_laporan($id)
	{
		$query = "select
						 barang.kodeBarang as kode_barang, barang.namaBarang as nama_barang,
						 barang_retur_detail.jumlah_retur, barang.satuan, barang.hargaBeli as harga_beli,
						 (barang_retur_detail.jumlah_retur * barang.hargaBeli) as subtotal, barang_retur_detail.keterangan
				  from barang_retur_detail
				  inner join barang on barang.id = barang_retur_detail.id_barang
				  where barang_retur_detail.id_retur = '$id'
				 ";
		return $this->db->query($query)->result_array();
	}
}