<?php

class Customer_model extends CI_Model {

	public function get_all_customer()
	{
		$query = $this->db->query("select * from customer order by namaCustomer asc");
		return $query->result_array();
	}

	public function get_customer($id)
	{

		$query = $this->db->query("select * from customer where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create($data)
	{
		$this->db->insert('customer', $data);
	}

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('customer', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('customer');
	}

public function get_laporan_customer($tglAwal, $tglAkhir)
	{
		$query = "select * from customer where tglPersetujuan between '$tglAwal' and '$tglAkhir'";
		return $this->db->query($query)->result_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_delete_berkas($id)
	{
		$query="select * from customer where id= '$id'";
		return $this->db->query($query)->row();
	}
}
