<?php

class Penagihan_model extends CI_Model {

	public function get_all_penagihan()
	{
		$query = $this->db->query("select penagihan.*, barang_jual.idCustomer,
			barang_jual.kodeBarangJual as kode_barang_jual, namaBarangJual as nama, customer.namaCustomer as nama_customer, barang_jual.tglJual as tgl_jual, barang_jual.tglTempo as tgl_tempo, (barang_jual.jumlahJual * hargaJual) as total, sisa_hutang
			from penagihan
			inner join barang_jual on barang_jual.id = penagihan.id_jual
			inner join customer on customer.id = barang_jual.idCustomer order by status = 'Belum Lunas' desc
			");
		return $query->result_array();
	}

	public function get_penagihan($id)
	{

		$query = $this->db->query("select * from penagihan where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create_penagihan($data)
	{
		$this->db->insert('penagihan', $data);
		return $this->db->insert_id();
	}

    public function generate_kode_penagihan($id_penagihan)
    {
		$this->db->query(
			"update penagihan
			 set kode_penagihan = CONCAT( 'PGN', LPAD($id_penagihan,7,'0') )
        	 where id = $id_penagihan "
		);
        $query = $this->db->query("select kode_penagihan from penagihan where id = $id_penagihan");
        return $query->row_array()['kode_penagihan'];
    }

	public function create_penagihan_detail($id_penagihan, $data)
	{
		$this->db->trans_start();
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = array(
				'id_penagihan' => $id_penagihan,
				'angsuran' => $_POST['angsuran'][$key],
				'jumlah_bayar' => $_POST['jumlah_pembayaran'][$key],
				'tgl_bayar' => $_POST['tgl_bayar'][$key],
				'tgl_byr_selanjutnya' => $_POST['tgl_byr_selanjutnya'][$key],
				'keterlambatan' => $_POST['keterlambatan'][$key],
				'denda' => $_POST['denda'][$key]
			);
			$this->db->set('sisa_hutang', 'sisa_hutang-'.$_POST['jumlah_pembayaran'][$key].'+'.$_POST['denda'][$key], false);
			$this->db->where('id', $id_penagihan);
			$this->db->update('penagihan');
		}
			$this->db->insert_batch('penagihan_detail', $result);
		$this->db->trans_complete();
	}    

	public function update($id, $data)
	{

		$this->db->where('id', $id);
		$this->db->update('penagihan', $data);
	}

	public function delete($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('penagihan');
	}

	public function check_detail_penagihan($id)
	{
		$query = $this->db->query(
			'select 
				    count(*) as total 
			from penagihan_detail 
			where id_penagihan = ?
			', $id);
		return $query->row()->total;
	}	

	public function get_penagihan_detail($id)
	{
		$query = $this->db->query(
			"select penagihan_detail.*, id as id_penagihan_detail, DATEDIFF(tgl_byr_selanjutnya, NOW()) as jatuh_tempo
			 from penagihan_detail
			 where penagihan_detail.id_penagihan = ? ", $id
		);

		return $query->result_array();
	}

	public function create_penagihan_detail_satuan($data)
	{
		$this->db->set('sisa_hutang', 'sisa_hutang-'.$data['jumlah_bayar'].'+'.$data['denda'], false);
		$this->db->where('id', $data['id_penagihan']);
		$this->db->update('penagihan');
		$this->db->insert('penagihan_detail', $data);
	}    

	public function update_penagihan_detail($id, $data)
	{
		$sql = "update penagihan_detail, penagihan
				set 
					penagihan_detail.angsuran = '".$data['angsuran'] ."',
					penagihan_detail.jumlah_bayar = " .$data['jumlah_pembayaran'] . ",
					penagihan_detail.tgl_bayar = '" .$data['tgl_bayar'] . "',
					penagihan_detail.tgl_byr_selanjutnya = '" .$data['tgl_byr_selanjutnya'] . "',
					penagihan_detail.keterlambatan = '" .$data['keterlambatan'] . "',
					penagihan_detail.denda = " .$data['denda'] . ",
					penagihan.sisa_hutang = sisa_hutang - ".$data['jumlah_pembayaran'].'+'.$data['denda']."
				where penagihan_detail.id = " . $id." and penagihan.id = ".$data['id_penagihan']."";

		$this->db->query($sql);
	}

	public function batal_penagihan_detail($id, $data)
	{
		$sql = "update penagihan_detail, penagihan
				set penagihan_detail.jumlah_bayar = jumlah_bayar -".$data['jumlah_pembayaran'].", 
				 	penagihan_detail.denda = denda -".$data['denda'].", 
					penagihan.sisa_hutang = sisa_hutang + ".$data['jumlah_pembayaran'].'-'.$data['denda']."
				where penagihan_detail.id = " . $id." and penagihan.id = ".$data['id_penagihan']."";
		$this->db->query($sql);
	}	

	public function delete_penagihan_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('penagihan_detail');
	}

	public function detail_penagihan($id)
	{
		$query = $this->db->query(
			'select 
				    penagihan.kode_penagihan, barang_jual.kodeBarangJual as kode_barang_jual, barang_jual.namaBarangJual as nama_barang_jual, customer.namaCustomer as nama_customer, customer.alamat as alamat_customer, customer.telp as telp_customer, barang_jual.tglJual as tgl_jual, barang_jual.tglTempo as tgl_tempo, barang_jual.jumlahJual as jumlah_jual, barang_jual.satuan, barang_jual.hargaJual as harga_jual, penagihan.jangka_waktu, penagihan.sisa_hutang, penagihan.angsuran_perbulan, penagihan.status, (barang_jual.hargaJual * barang_jual.jumlahJual) as subtotal
			 from penagihan
			 inner join barang_jual on barang_jual.id = penagihan.id_jual
			 inner join customer on customer.id = barang_jual.idCustomer
			 where penagihan.id = ?', $id);
		return $query->result_array();
	}			

	public function total_penagihan()
	{
		$query = "select count(*) as total from penagihan";
		return $this->db->query($query)->row_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_laporan_penagihan($customer)
	{
		$query = "select penagihan.id as id_penagihan, penagihan.kode_penagihan, penagihan.jangka_waktu, penagihan.sisa_hutang, customer.namaCustomer as nama_customer, customer.alamat, customer.telp,
 						 penagihan.angsuran_perbulan, penagihan.status, barang_jual.kodeBarangJual as kode_barang_jual, barang_jual.namaBarangJual as nama_barang_jual, barang_jual.idCustomer, barang_jual.tglJual as tgl_jual, barang_jual.tglTempo as tgl_tempo, barang_jual.jumlahJual as jumlah_jual, barang_jual.satuan, barang_jual.hargaJual as harga_jual, (barang_jual.jumlahJual * barang_jual.hargaJual) as subtotal
 						 from penagihan
 						 inner join barang_jual on barang_jual.id = penagihan.id_jual
 						 inner join customer on customer.id = barang_jual.idCustomer
 						 where barang_jual.idCustomer = '$customer'";
		return $this->db->query($query)->result_array();
	}

	public function get_laporan_penagihan_jatuh_tempo($tglAwal, $tglAkhir)
	{
		$query = "select penagihan.id as id_penagihan, penagihan.kode_penagihan, penagihan.jangka_waktu, penagihan.sisa_hutang, customer.namaCustomer as nama_customer, customer.alamat, customer.telp,
 						 penagihan.angsuran_perbulan, penagihan.status, barang_jual.kodeBarangJual as kode_barang_jual, barang_jual.namaBarangJual as nama_barang_jual, barang_jual.idCustomer, barang_jual.tglJual as tgl_jual, barang_jual.tglTempo as tgl_tempo, barang_jual.jumlahJual as jumlah_jual, barang_jual.satuan, barang_jual.hargaJual as harga_jual, (barang_jual.jumlahJual * barang_jual.hargaJual) as subtotal
 						 from penagihan
 						 inner join barang_jual on barang_jual.id = penagihan.id_jual
 						 inner join customer on customer.id = barang_jual.idCustomer
 						 where barang_jual.tglTempo between '$tglAwal' and '$tglAkhir' and penagihan.status = 'Belum Lunas' order by customer.namaCustomer asc";
		return $this->db->query($query)->result_array();
	}

	public function get_tanggal_jatuh_tempo()
	{
		$query = $this->db->query(
			"select penagihan_detail.*, DATEDIFF(tgl_byr_selanjutnya, NOW()) as jatuh_tempo,
			 kode_penagihan, penagihan.id_jual, customer.namaCustomer as nama_customer, customer.telp, barang_jual.kodeBarangJual as kode_jual
			 from penagihan_detail
			 inner join penagihan on penagihan.id = penagihan_detail.id_penagihan
			 inner join barang_jual on barang_jual.id = penagihan.id_jual
			 inner join customer on customer.id = barang_jual.idCustomer order by tgl_byr_selanjutnya desc
			"
		);

		return $query->result_array();		
	}		
}