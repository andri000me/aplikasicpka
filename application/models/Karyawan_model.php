<?php

class Karyawan_model extends CI_Model {

	public function get_all_karyawan()
	{
		$query = $this->db->query("select * from karyawan order by namaKaryawan asc");
		return $query->result_array();
	}

	public function create($data)
	{
		$this->db->insert('karyawan', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('karyawan', $data);
	}

	public function delete($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('karyawan');
	}

	public function get_karyawan($id)
	{
		$query = $this->db->query("select * from karyawan where id =?",$id);
		return $query->row_array();
	}
}