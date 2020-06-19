<?php

class BarangMasuk_model extends CI_Model {

	public function get_all_barang_masuk()
	{
		$query = $this->db->query("
			select barang_masuk.*, DATEDIFF(tgl_tempo, NOW()) as jatuh_tempo,
			supplier.namaSupplier as nama_supplier 
			from barang_masuk
			inner join supplier on supplier.id = barang_masuk.id_supplier order by tgl_masuk desc	
		");
		return $query->result_array();
	}

	public function get_all_barang_masuk_detail()
	{
		$query = $this->db->query("
			select barang_masuk_detail.id_barang, 
			sum(barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal, barang_masuk.kode_masuk, barang_masuk.tgl_masuk,
			tgl_tempo, barang_masuk.id_supplier, supplier.namaSupplier as nama_supplier,
			barang.namaBarang as nama_barang, barang_masuk.id
			from barang_masuk_detail
			inner join barang_masuk on barang_masuk.id =barang_masuk_detail.id_masuk
			inner join supplier on supplier.id = barang_masuk.id_supplier
			inner join barang on barang.id =barang_masuk_detail.id_barang group by barang_masuk_detail.id_masuk
		");
		return $query->result_array();
	}	

	public function get_barang_masuk($id)
	{

		$query = $this->db->query("select * from barang_masuk where id = ?", $id);
		return $query->row_array();
	}

	public function create_barang_masuk($data)
	{
		$this->db->insert('barang_masuk', $data);
		return $this->db->insert_id();
	}

    public function generate_kode_masuk($id_masuk)
    {
		$this->db->query(
			"update barang_masuk
			 set kode_masuk = CONCAT( 'INV', LPAD($id_masuk,7,'0') )
        	 where id = $id_masuk "
		);
        $query = $this->db->query("select kode_masuk from barang_masuk where id = $id_masuk");
        return $query->row_array()['kode_masuk'];
    }

	public function create_barang_masuk_detail($id_masuk, $data)
	{
		$this->db->trans_start();
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = array(
				'id_masuk' => $id_masuk,
				'id_barang' => $_POST['id_barang'][$key],
				'jumlah_masuk' => $_POST['qty'][$key]
			);

			$this->db->set('stok', 'stok+'.$_POST['qty'][$key], false);
			$this->db->where('id', $_POST['id_barang'][$key]);
			$this->db->update('barang');
		}
			$this->db->insert_batch('barang_masuk_detail', $result);
		$this->db->trans_complete();
	}    

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('barang_masuk', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('barang_masuk');
	}

	public function check_detail_barang_masuk($id)
	{
		$query = $this->db->query(
			'select 
				    count(*) as total 
			from barang_masuk_detail 
			where id_masuk = ?
			', $id);
		return $query->row()->total;
	}	

	public function get_barang_masuk_detail($id)
	{
		$query = $this->db->query(
			"select
					(barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal,
				    barang_masuk_detail.id as id_barang_masuk_detail, barang_masuk_detail.id_masuk,
					barang_masuk_detail.id_barang, barang.kodeBarang, barang.namaBarang,
					barang.hargaBeli as harga, barang.stok, barang.satuan, barang_masuk_detail.jumlah_masuk
			 from barang_masuk_detail
			 join barang on barang.id = barang_masuk_detail.id_barang
			 where barang_masuk_detail.id_masuk = ? ", $id
		);

		return $query->result_array();
	}

	public function create_barang_masuk_detail_satuan($data)
	{
		$this->db->set('stok', 'stok+'.$data['jumlah_masuk'], false);
		$this->db->where('id', $data['id_barang']);
		$this->db->update('barang');
		$this->db->insert('barang_masuk_detail', $data);
	}    

	public function update_barang_masuk_detail($id, $data)
	{
		$sql = "update barang_masuk_detail, barang
				set barang_masuk_detail.jumlah_masuk = " .$data['jumlah_masuk'] . ",
					barang.stok = stok + ".$data['jumlah_masuk']."
				where barang_masuk_detail.id = " . $id." and barang.id = ".$data['id_barang']."";

		$this->db->query($sql);
	}

	public function delete_qty_barang($id, $data)
	{
		$sql = "update barang_masuk_detail, barang
				set barang_masuk_detail.jumlah_masuk = jumlah_masuk -".$data['jumlah_masuk'].", 
					barang.stok = stok - ".$data['jumlah_masuk']."
				where barang_masuk_detail.id = " . $id." and barang.id = ".$data['id_barang']."";
		$this->db->query($sql);
	}	

	public function delete_barang_masuk_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('barang_masuk_detail');
	}

	public function detail_barang_masuk($id)
	{
		$query = $this->db->query(
			'select 
				    barang_masuk.*, supplier.namaSupplier as nama_supplier, supplier.alamat,supplier.telp, supplier.penanggungJawab, DATEDIFF(tgl_tempo, NOW()) as jatuh_tempo
			 from barang_masuk
			 inner join supplier on supplier.id = barang_masuk.id_supplier
			 where barang_masuk.id = ?', $id);
		return $query->result_array();
	}			

	public function total_barang_masuk()
	{
		$query = "select count(*) as total from barang_masuk";
		return $this->db->query($query)->row_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_laporan_barang_masuk($tglAwal, $tglAkhir)
	{
		$query = "select 
						 barang_masuk.*, supplier.namaSupplier as nama_supplier
						 from barang_masuk
						 inner join supplier on supplier.id = barang_masuk.id_supplier
						 where tgl_masuk between '$tglAwal' and '$tglAkhir';
				 ";
		return $this->db->query($query)->result_array();
	}

	public function get_barang_masuk_detail_laporan($id)
	{
		$query = "select
						 barang.kodeBarang as kode_barang, barang.namaBarang as nama_barang,
						 barang_masuk_detail.jumlah_masuk, barang.satuan, barang.hargaBeli as harga_beli,
						 (barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal
				  from barang_masuk_detail
				  inner join barang on barang.id = barang_masuk_detail.id_barang
				  where barang_masuk_detail.id_masuk = '$id'
				 ";
		return $this->db->query($query)->result_array();
	}
}