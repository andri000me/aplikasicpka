<?php

class Supplier_model extends CI_Model {

	public function get_all_supplier()
	{
		$query = $this->db->query("select * from supplier order by namaSupplier asc");
		return $query->result_array();
	}

	public function get_supplier($id)
	{

		$query = $this->db->query("select * from supplier where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create($data)
	{
		$this->db->insert('supplier', $data);
	}

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('supplier', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('supplier');
	}

	public function get_laporan_supplier($tglAwal, $tglAkhir)
	{
		$query = "select * from supplier where tglPersetujuan between '$tglAwal' and '$tglAkhir'";
		return $this->db->query($query)->result_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_delete_berkas($id)
	{
		$query="select * from supplier where id= '$id'";
		return $this->db->query($query)->row();
	}
} 