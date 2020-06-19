<?php

class BarangKeluar_model extends CI_Model {

	public function get_all_barang_keluar()
	{
		$query = $this->db->query("
			select barang_keluar.*, karyawan.namaKaryawan as nama_karyawan
			from barang_keluar 
			join karyawan on karyawan.id = barang_keluar.id_karyawan
			order by tgl_keluar desc

		");
		return $query->result_array();
	}

	public function get_barang_keluar($id)
	{

		$query = $this->db->query("select * from barang_keluar where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create_barang_keluar($data)
	{
		$this->db->insert('barang_keluar', $data);
		return $this->db->insert_id();
	}

    public function generate_kode_keluar($id_keluar)
    {
		$this->db->query(
			"update barang_keluar
			 set kode_keluar = CONCAT( 'BK', LPAD($id_keluar,7,'0') )
        	 where id = $id_keluar"
		);
        $query = $this->db->query("select kode_keluar from barang_keluar where id = $id_keluar");
        return $query->row_array()['kode_keluar'];
    }

	public function create_barang_keluar_detail($id_keluar, $data)
	{
		$this->db->trans_start();
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = array(
				'id_keluar' => $id_keluar,
				'id_barang' => $_POST['id_barang'][$key],
				'jumlah_keluar' => $_POST['qty'][$key]
			);

			$this->db->set('stok', 'stok-'.$_POST['qty'][$key], false);
			$this->db->where('id', $_POST['id_barang'][$key]);
			$this->db->update('barang');
		}
			$this->db->insert_batch('barang_keluar_detail', $result);
		$this->db->trans_complete();
	}	

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('barang_keluar', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('barang_keluar');
	}

	public function check_detail_barang_keluar($id)
	{
		$query = $this->db->query(
			'select 
				    count(*) as total 
			from barang_keluar_detail 
			where id_keluar = ?
			', $id);
		return $query->row()->total;
	}	

public function get_barang_keluar_detail($id)
	{
		$query = $this->db->query(
			"select
					(barang_keluar_detail.jumlah_keluar * barang.hargaBeli) as subtotal,
				    barang_keluar_detail.id as id_barang_keluar_detail, barang_keluar_detail.id_keluar,
					barang_keluar_detail.id_barang, barang.kodeBarang, barang.namaBarang,
					barang.hargaBeli as harga, barang.stok, barang.satuan, barang_keluar_detail.jumlah_keluar
			 from barang_keluar_detail
			 join barang on barang.id = barang_keluar_detail.id_barang
			 where barang_keluar_detail.id_keluar = ? ", $id
		);

		return $query->result_array();
	}

	public function create_barang_keluar_detail_satuan($data)
	{
		$this->db->set('stok', 'stok-'.$data['jumlah_keluar'], false);
		$this->db->where('id', $data['id_barang']);
		$this->db->update('barang');
		$this->db->insert('barang_keluar_detail', $data);
	}    

	public function update_barang_keluar_detail($id, $data)
	{
		$sql = "update barang_keluar_detail, barang
				set barang_keluar_detail.jumlah_keluar = " .$data['jumlah_keluar'] . ",
					barang.stok = stok - ".$data['jumlah_keluar']."
				where barang_keluar_detail.id = " . $id." and barang.id = ".$data['id_barang']."";

		$this->db->query($sql);
	}

	public function delete_qty_barang($id, $data)
	{
		$sql = "update barang_keluar_detail, barang
				set barang_keluar_detail.jumlah_keluar = jumlah_keluar -".$data['jumlah_keluar'].", 
					barang.stok = stok + ".$data['jumlah_keluar']."
				where barang_keluar_detail.id = " . $id." and barang.id = ".$data['id_barang']."";
		$this->db->query($sql);
	}	

	public function delete_barang_keluar_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('barang_keluar_detail');
	}

	public function detail_barang_keluar($id)
	{
		$query = $this->db->query(
			'select barang_keluar.*, karyawan.namaKaryawan as nama_karyawan
			 from barang_keluar
			 join karyawan on karyawan.id = barang_keluar.id_karyawan
			 where barang_keluar.id = ?', $id);
		return $query->result_array();
	}	

	public function total_barang_keluar()
	{
		$query = "select count(*) as total from barang_keluar";
		return $this->db->query($query)->row_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}	

	public function get_laporan_barang_keluar($tglAwal, $tglAkhir)
	{
		$query = "select
						 barang_keluar.kode_keluar, karyawan.namaKaryawan as nama_karyawan,
						 barang_keluar.tgl_keluar, barang_keluar.keterangan, barang_keluar.id as id_keluar
				  from barang_keluar
				  inner join karyawan on karyawan.id = barang_keluar.id_karyawan
				  where tgl_keluar between '$tglAwal' and '$tglAkhir'
				 ";
		return $this->db->query($query)->result_array();
	}

	public function get_barang_keluar_detail_laporan($id)
	{
		$query = $this->db->query("
			select 
				   barang.kodeBarang as kode_barang, barang.namaBarang as nama_barang, 
				   barang_keluar_detail.jumlah_keluar, barang.satuan, barang.hargaBeli as harga_beli, 
				   (barang_keluar_detail.jumlah_keluar * barang.hargaBeli) as subtotal
			from barang_keluar_detail
			inner join barang on barang.id = barang_keluar_detail.id_barang
			where barang_keluar_detail.id_keluar = ?
			", $id);
		return $query->result_array();
	}
}