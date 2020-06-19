<?php

class BarangJual_model extends CI_Model {

	public function get_all_barang_jual()
	{
		$query = $this->db->query("
			select barang_jual.*, DATEDIFF(tglTempo, NOW()) as jatuh_tempo,
			(barang_jual.hargaJual * barang_jual.jumlahJual) as total,
			customer.namaCustomer as Nama_Customer 
			from barang_jual
			inner join customer on customer.id = barang_jual.idCustomer	order by tglJual desc
		");
		return $query->result_array();
	}

	public function get_barang_jual($id)
	{

		$query = $this->db->query("select * from barang_jual where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create($data)
	{
		$this->db->insert('barang_jual', $data);
	}

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('barang_jual', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('barang_jual');
	}

	public function total_barang_jual()
	{
		$query = "select count(*) as total from barang_jual";
		return $this->db->query($query)->row_array();
	}	

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_laporan_barang_jual($tglAwal, $tglAkhir)
	{
		$query = "select 
						 (barang_jual.hargaJual * barang_jual.jumlahJual) as total, barang_jual.id,
						 barang_jual.kodeBarangJual, barang_jual.tglJual, barang_jual.jumlahJual,
						 barang_jual.namaBarangJual as nama_barang, barang_jual.satuan as satuan,
						 barang_jual.hargaJual as harga, customer.namaCustomer as nama_customer
				  from barang_jual 
				  inner join customer on customer.id = barang_jual.idCustomer
				  where tgljual between '$tglAwal' and '$tglAkhir'"; 	 	
		return $this->db->query($query)->result_array();
	}	
}