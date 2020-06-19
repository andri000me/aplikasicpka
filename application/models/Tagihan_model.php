<?php

class Tagihan_model extends CI_Model {

	public function get_all_tagihan()
	{
		$query = $this->db->query("
			select tagihan.*, barang.hargaBeli, barang_masuk.jumlahMasuk, 
			barang.namaBarang as nama_barang, barang.kodeBarang as kode_barang,
			supplier.namaSupplier as nama_supplier,
			barang_masuk.kodeMasuk as kode_masuk, barang_masuk.tglMasuk 
			from tagihan
			inner join barang on barang.id = tagihan.idBarang
			inner join supplier on supplier.id = tagihan.idSupplier
			inner join barang_masuk on barang_masuk.id = tagihan.idMasuk order by tglTempo asc
		");
		return $query->result_array();
	}

	public function get_tagihan($id)
	{

		$query = $this->db->query("select * from tagihan where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create($data)
	{
		$this->db->insert('tagihan', $data);
	}

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('tagihan', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('tagihan');
	}

	public function total_tagihan()
	{
		$query = "select count(*) as total from tagihan";
		return $this->db->query($query)->row_array();
	}	

	public function get_tanggal_jatuh_tempo()
	{
		$query = "select 
					kodeTagihan,tglTempo, supplier.namaSupplier as nama_supplier,
					DATEDIFF(tglTempo, NOW()) as jatuh_tempo 
						from tagihan
						join supplier on supplier.id = tagihan.idSupplier
						join barang_masuk on barang_masuk.id = tagihan.idSupplier
						";

		return $this->db->query($query)->result_array();
	}	
}