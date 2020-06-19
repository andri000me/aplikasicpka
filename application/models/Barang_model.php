<?php

class Barang_model extends CI_Model {

	public function get_all_barang()
	{
		$query = $this->db->query("select * from barang order by namaBarang asc");
		return $query->result_array();
	}

	public function get_barang($id)
	{

		$query = $this->db->query("select * from barang where id = ?", $id);
		return $query->row_array();
	}

	public function create($data)
	{
		$this->db->insert('barang', $data);
	}

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('barang', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('barang');
	}

	public function getLaporanBarang()
	{
		$query = "select * from barang";
		return $this->db->query($query)->result_array();
	}

	public function getPenanggungJawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}
}