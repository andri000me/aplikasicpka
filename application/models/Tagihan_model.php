<?php

class Tagihan_model extends CI_Model {

	public function get_all_tagihan()
	{
		$query = $this->db->query("
			select 
			       tagihan.*, barang_masuk.id_supplier, barang_masuk.kode_masuk as kode_barang_masuk, 
			       supplier.namaSupplier as nama_supplier, barang_masuk.tgl_masuk as tgl_masuk, barang_masuk.tgl_tempo as tgl_tempo, sum(barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal
			from tagihan
			inner join barang_masuk on barang_masuk.id = tagihan.id_masuk
			inner join barang_masuk_detail on barang_masuk_detail.id_masuk = tagihan.id_masuk
			inner join barang on barang.id = barang_masuk_detail.id_barang			
			inner join supplier on supplier.id = barang_masuk.id_supplier group by barang_masuk_detail.id_masuk order by status = 'Belum Lunas' desc
		");
		return $query->result_array();
	}

	public function get_tagihan($id)
	{

		$query = $this->db->query("select * from tagihan where id = ? limit 1", $id);
		return $query->row_array();
	}

	public function create_tagihan($data)
	{
		$this->db->insert('tagihan', $data);
		return $this->db->insert_id();
	}

    public function generate_kode_tagihan($id_tagihan)
    {
		$this->db->query(
			"update tagihan
			 set kode_tagihan = CONCAT( 'TG', LPAD($id_tagihan,7,'0') )
        	 where id = $id_tagihan "
		);
        $query = $this->db->query("select kode_tagihan from tagihan where id = $id_tagihan");
        return $query->row_array()['kode_tagihan'];
    }

	public function create_tagihan_detail($id_tagihan, $data)
	{
		$this->db->trans_start();
		$result = array();
		foreach ($data as $key => $value) {
			$result[] = array(
				'id_tagihan' => $id_tagihan,
				'angsuran' => $_POST['angsuran'][$key],
				'jumlah_bayar' => $_POST['jumlah_pembayaran'][$key],
				'tgl_bayar' => $_POST['tgl_bayar'][$key],
				'tgl_byr_selanjutnya' => $_POST['tgl_byr_selanjutnya'][$key],
				'keterlambatan' => $_POST['keterlambatan'][$key],
				'denda' => $_POST['denda'][$key]
			);
			$this->db->set('sisa_hutang', 'sisa_hutang-'.$_POST['jumlah_pembayaran'][$key].'+'.$_POST['denda'][$key], false);
			$this->db->where('id', $id_tagihan);
			$this->db->update('tagihan');
		}
			$this->db->insert_batch('tagihan_detail', $result);
		$this->db->trans_complete();
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

	public function check_detail_tagihan($id)
	{
		$query = $this->db->query(
			'select 
				    count(*) as total 
			from tagihan_detail 
			where id_tagihan = ?
			', $id);
		return $query->row()->total;
	}	

	public function get_tagihan_detail($id)
	{
		$query = $this->db->query(
			"select tagihan_detail.*, id as id_tagihan_detail, DATEDIFF(tgl_byr_selanjutnya, NOW()) as jatuh_tempo
			 from tagihan_detail
			 where tagihan_detail.id_tagihan = ? ", $id
		);

		return $query->result_array();
	}	

	public function create_tagihan_detail_satuan($data)
	{
		$this->db->set('sisa_hutang', 'sisa_hutang-'.$data['jumlah_bayar'].'+'.$data['denda'], false);
		$this->db->where('id', $data['id_tagihan']);
		$this->db->update('tagihan');
		$this->db->insert('tagihan_detail', $data);
	}    

	public function update_tagihan_detail($id, $data)
	{
		$sql = "update tagihan_detail, tagihan
				set 
					tagihan_detail.angsuran = '".$data['angsuran'] ."',
					tagihan_detail.jumlah_bayar = " .$data['jumlah_pembayaran'] . ",
					tagihan_detail.tgl_bayar = '" .$data['tgl_bayar'] . "',
					tagihan_detail.tgl_byr_selanjutnya = '" .$data['tgl_byr_selanjutnya'] . "',
					tagihan_detail.keterlambatan = '" .$data['keterlambatan'] . "',
					tagihan_detail.denda = " .$data['denda'] . ",
					tagihan.sisa_hutang = sisa_hutang - ".$data['jumlah_pembayaran'].'+'.$data['denda']."
				where tagihan_detail.id = " . $id." and tagihan.id = ".$data['id_tagihan']."";

		$this->db->query($sql);
	}

	public function batal_tagihan_detail($id, $data)
	{
		$sql = "update tagihan_detail, tagihan
				set tagihan_detail.jumlah_bayar = jumlah_bayar -".$data['jumlah_pembayaran'].", 
				 	tagihan_detail.denda = denda -".$data['denda'].", 
					tagihan.sisa_hutang = sisa_hutang + ".$data['jumlah_pembayaran'].'-'.$data['denda']."
				where tagihan_detail.id = " . $id." and tagihan.id = ".$data['id_tagihan']."";
		$this->db->query($sql);
	}	

	public function delete_tagihan_detail($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('tagihan_detail');
	}

	public function detail_tagihan($id)
	{
		$query = $this->db->query(
			'select 
				    tagihan.kode_tagihan, barang_masuk.kode_masuk as kode_barang_masuk, supplier.namasupplier as nama_supplier, supplier.alamat as alamat_supplier, supplier.telp as telp_supplier, barang_masuk.tgl_masuk as tgl_masuk, barang_masuk.tgl_tempo as tgl_tempo, tagihan.jangka_waktu, tagihan.sisa_hutang, tagihan.angsuran_perbulan, tagihan.status,sum(barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal, tagihan.jumlah_retur, tagihan.no_retur
			 from tagihan
			 inner join barang_masuk_detail on barang_masuk_detail.id_masuk = tagihan.id_masuk
			 inner join barang on barang.id = barang_masuk_detail.id_barang			 
			 inner join barang_masuk on barang_masuk.id = tagihan.id_masuk
			 inner join supplier on supplier.id = barang_masuk.id_supplier
			 where tagihan.id = ? group by barang_masuk_detail.id_masuk', $id);
		return $query->result_array();
	}			

	public function total_tagihan()
	{
		$query = "select count(*) as total from tagihan";
		return $this->db->query($query)->row_array();
	}

	public function penanggung_jawab($namaPersetujuan)
	{
		$query = "select * from karyawan where namaKaryawan = '$namaPersetujuan'";
		return $this->db->query($query)->result_array();
	}

	public function get_laporan_tagihan($supplier)
	{
		$query = $this->db->query(
			'select 

					 tagihan.id as id_tagihan, tagihan.kode_tagihan, barang_masuk.kode_masuk as kode_barang_masuk, supplier.namasupplier as nama_supplier, supplier.alamat as alamat_supplier, supplier.telp as telp_supplier, barang_masuk.tgl_masuk as tgl_masuk, barang_masuk.tgl_tempo as tgl_tempo, tagihan.jangka_waktu, tagihan.sisa_hutang, tagihan.angsuran_perbulan, tagihan.status,sum(barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal, tagihan.jumlah_retur, tagihan.no_retur
			 from tagihan
			 inner join barang_masuk_detail on barang_masuk_detail.id_masuk = tagihan.id_masuk
			 inner join barang on barang.id = barang_masuk_detail.id_barang			 
			 inner join barang_masuk on barang_masuk.id = tagihan.id_masuk
			 inner join supplier on supplier.id = barang_masuk.id_supplier
			 where barang_masuk.id_supplier = ? group by barang_masuk_detail.id_masuk', $supplier);
		return $query->result_array();
	}

	public function get_laporan_tagihan_jatuh_tempo($tglAwal, $tglAkhir)
	{
		$query = "select 
					 tagihan.id as id_tagihan, tagihan.kode_tagihan, barang_masuk.kode_masuk as kode_barang_masuk, supplier.namasupplier as nama_supplier, supplier.alamat as alamat_supplier, supplier.telp as telp_supplier, barang_masuk.tgl_masuk as tgl_masuk, barang_masuk.tgl_tempo as tgl_tempo, tagihan.jangka_waktu, tagihan.sisa_hutang, tagihan.angsuran_perbulan, tagihan.status,sum(barang_masuk_detail.jumlah_masuk * barang.hargaBeli) as subtotal, tagihan.jumlah_retur, tagihan.no_retur
			 from tagihan
			 inner join barang_masuk_detail on barang_masuk_detail.id_masuk = tagihan.id_masuk
			 inner join barang on barang.id = barang_masuk_detail.id_barang			 
			 inner join barang_masuk on barang_masuk.id = tagihan.id_masuk
			 inner join supplier on supplier.id = barang_masuk.id_supplier
			 where barang_masuk.tgl_tempo between '$tglAwal' and '$tglAkhir' group by barang_masuk_detail.id_masuk";
		return $this->db->query($query)->result_array();
	}	

	public function get_tanggal_jatuh_tempo()
	{
		$query = $this->db->query(
			"select tagihan_detail.*, DATEDIFF(tgl_byr_selanjutnya, NOW()) as jatuh_tempo,
			 kode_tagihan, tagihan.id_masuk, supplier.namaSupplier as nama_supplier, supplier.telp, barang_masuk.kode_masuk
			 from tagihan_detail
			 inner join tagihan on tagihan.id = tagihan_detail.id_tagihan
			 inner join barang_masuk on barang_masuk.id = tagihan.id_masuk
			 inner join supplier on supplier.id = barang_masuk.id_supplier order by tgl_byr_selanjutnya desc
			"
		);

		return $query->result_array();		
	}
}