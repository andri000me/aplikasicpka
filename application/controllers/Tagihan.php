<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}
		$this->load->helper(['format_tanggal_indo', 'format_rupiah','access_control']);
		$this->load->model('tagihan_model');
		$this->load->model('barang_model');
		$this->load->model('BarangMasuk_model');
		$this->load->model('BarangRetur_model');
		$this->load->model('supplier_model');
	}

	public function index()
	{
		$data['tagihan'] = $this->tagihan_model->get_all_tagihan();
		$this->load->view('layout/header');
		$this->load->view('tagihan/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$data['barang_masuk'] = $this->BarangMasuk_model->get_all_barang_masuk_detail();
		$data['barang_retur'] = $this->BarangRetur_model->get_all_barang_retur_detail();
		$this->load->view('layout/header');
		$this->load->view('tagihan/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{
		$validation = [
			[
				'field' => 'idMasuk',
				'label' => 'Nomor Pembelian',
				'rules' => 'required|is_unique[tagihan.id_masuk]',
				'errors' => [
					'is_unique' => '%s sudah dalam proses pembayaran',
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'idRetur',
				'label' => 'Nomor Retur',
				'rules' => 'is_unique[tagihan.no_retur]',
				'errors' => [
					'is_unique' => '%s sudah pernah diretur',
				]
			],
			[
				'field' => 'jangka_waktu',
				'label' => 'Jangka Waktu',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			]
		];

		$this->form_validation->set_rules($validation);
		if ($this->form_validation->run() == false) {
			$errors = validation_errors();
			$errors = str_replace(["<p>","</p>"], "", $errors);
			$errors = explode("\n", rtrim($errors, "\n"));
			echo json_encode(['status' => 'error', 'msg' => $errors]);
		} else {
			$id_tagihan = $this->tagihan_model->create_tagihan([
				'id_masuk' 			=> $this->input->post('idMasuk'),
				'no_retur' 			=> $this->input->post('idRetur'),
				'jangka_waktu' 		=> $this->input->post('jangka_waktu'),
				'sisa_hutang' 		=> $this->input->post('sisa_hutang'),
				'jumlah_retur' 		=> $this->input->post('totalretur'),
				'angsuran_perbulan'	=> $this->input->post('perbulan'),
				'status' 			=> 'Belum Lunas'
			]);

			$kode_tagihan = $this->tagihan_model->generate_kode_tagihan($id_tagihan);
            $data = $this->input->post('angsuran');

            $this->tagihan_model->create_tagihan_detail($id_tagihan, $data);			
			echo json_encode(['status' => 'success', 'data' => ['kode_tagihan' => $kode_tagihan]]);
		}
	}

	public function edit($id)
	{
		$data['barang_masuk'] = $this->BarangMasuk_model->get_all_barang_masuk_detail();
		$data['barang_retur'] = $this->BarangRetur_model->get_all_barang_retur_detail();
		$data['edit_tagihan'] = $this->tagihan_model->get_tagihan($id);
		if (empty($data['edit_tagihan'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('tagihan/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{
		$validation = [
			[
				'field' => 'idMasuk',
				'label' => 'Nomor Pembelian',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'idRetur',
				'label' => 'Nomor Retur',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi',
				]
			],
			[
				'field' => 'jangka_waktu',
				'label' => 'Jangka Waktu',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			]
		];

		$this->form_validation->set_rules($validation);
		if ($this->form_validation->run() == false) {
			$errors = validation_errors();
			$errors = str_replace(["<p>","</p>"], "", $errors);
			$errors = explode("\n", rtrim($errors, "\n"));
			echo json_encode(['status' => 'error', 'msg' => $errors]);
		} else {

			$data = [
				'id_masuk' 			=> $this->input->post('idMasuk'),
				'no_retur' 			=> $this->input->post('idRetur'),
				'jangka_waktu' 		=> $this->input->post('jangka_waktu'),
				'jumlah_retur' 		=> $this->input->post('totalretur'),
				'angsuran_perbulan'	=> $this->input->post('perbulan'),
				'status' 			=> $this->input->post('status')
			];
			$this->tagihan_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{
        if ($this->tagihan_model->check_detail_tagihan($id) > 0) {
            echo json_encode(['status' => 'failed']);
        } else {
            $this->tagihan_model->delete($id);
            echo json_encode(['status' => 'success']);
        }
	}

    public function detail($id)
    {
        $data['detail_tagihan'] = $this->tagihan_model->detail_tagihan($id);
        $data['detail_tagihan_semua'] = $this->tagihan_model->get_tagihan_detail($id);
        $this->load->view('layout/header');
        $this->load->view('tagihan/detail', $data);
        $this->load->view('layout/footer');
    }

    public function printTagihanDetail($id)	
    {
    	$data['print_tagihan'] = $this->tagihan_model->detail_tagihan($id);
    	$data['print_tagihan_semua'] = $this->tagihan_model->get_tagihan_detail($id);
    	$this->load->view('print_tagihan_detail', $data);
    }

    public function printDetailtagihan($id)
    { 
        $data['print_tagihan'] = $this->tagihan_model->detail_tagihan($id);
        $data['print_tagihan_semua'] = $this->tagihan_model->get_tagihan_detail($id);
        $this->load->view('tagihan/print_tagihan_detail', $data);
    }	

    public function getTagihanDetail($id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data['data'] = $this->tagihan_model->get_tagihan_detail($id);
        echo json_encode($data);
    }

    public function createTagihanDetail()
    {
        $data['angsuran'] = $this->input->post('angsuran');
        $data['jumlah_bayar'] = $this->input->post('jumlah_pembayaran');
        $data['tgl_bayar'] = $this->input->post('tgl_bayar');
        $data['tgl_byr_selanjutnya'] = $this->input->post('tgl_byr_selanjutnya');
        $data['keterlambatan'] = $this->input->post('keterlambatan');
        $data['denda'] = $this->input->post('denda');
        $data['id_tagihan'] = $this->input->post('id_tagih');
        $this->tagihan_model->create_tagihan_detail_satuan($data);
        echo json_encode(['status' => 'success']);
    }    

    public function updateTagihanDetail($id)
    {
        $data['angsuran'] = $this->input->post('angsuran');
        $data['jumlah_pembayaran'] = $this->input->post('jumlah_pembayaran');
        $data['tgl_bayar'] = $this->input->post('tgl_bayar');
        $data['tgl_byr_selanjutnya'] = $this->input->post('tgl_byr_selanjutnya');
        $data['keterlambatan'] = $this->input->post('keterlambatan');
        $data['denda'] = $this->input->post('denda');
        $data['id_tagihan'] = $this->input->post('id_tagihan');
        $this->tagihan_model->update_tagihan_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function batalAngsuran($id)
    {
    	$data['jumlah_pembayaran'] = $this->input->post('jumlah_pembayaran');
        $data['denda'] = $this->input->post('denda');
        $data['id_tagihan'] = $this->input->post('id_tagihan');
        $this->tagihan_model->batal_tagihan_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteTagihanDetail($id)
    {
        $this->tagihan_model->delete_tagihan_detail($id);
        echo json_encode(['status' => 'success']);
    }

	public function laporan()
	{
		$data['data_supplier'] = $this->supplier_model->get_all_supplier();
		$this->load->view('layout/header');
		$this->load->view('tagihan/laporan', $data);
		$this->load->view('layout/footer');	
	}

	public function laporan_tagihan()
	{
		$data['data_tagihan'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$supplier = $this->input->post('supplier');
		$data['penanggung'] = $this->tagihan_model->penanggung_jawab($namaPersetujuan);
		$tagihan = $this->tagihan_model->get_laporan_tagihan($supplier);
		$i = 0;
		foreach ($tagihan as $tagihan) {
			$data['data_tagihan'][$i]['kode_tagihan'] = $tagihan['kode_tagihan'];
			$data['data_tagihan'][$i]['kode_barang_masuk'] = $tagihan['kode_barang_masuk'];
			$data['data_tagihan'][$i]['nama_supplier'] = $tagihan['nama_supplier'];
			$data['data_tagihan'][$i]['alamat_supplier'] = $tagihan['alamat_supplier'];
			$data['data_tagihan'][$i]['telp_supplier'] = $tagihan['telp_supplier'];
			$data['data_tagihan'][$i]['tgl_masuk'] = $tagihan['tgl_masuk'];
			$data['data_tagihan'][$i]['tgl_tempo'] = $tagihan['tgl_tempo'];
			$data['data_tagihan'][$i]['jangka_waktu'] = $tagihan['jangka_waktu'];
			$data['data_tagihan'][$i]['sisa_hutang'] = $tagihan['sisa_hutang'];
			$data['data_tagihan'][$i]['angsuran_perbulan'] = $tagihan['angsuran_perbulan'];
			$data['data_tagihan'][$i]['status'] = $tagihan['status'];
			$data['data_tagihan'][$i]['subtotal'] = $tagihan['subtotal'];
			$data['data_tagihan'][$i]['jumlah_retur'] = $tagihan['jumlah_retur'];
			$data['data_tagihan'][$i]['no_retur'] = $tagihan['no_retur'];

			$tagihan_detail = $this->tagihan_model->get_tagihan_detail($tagihan['id_tagihan']);
			$data['data_tagihan'][$i]['tagihan'] = [];
			foreach ($tagihan_detail as $detail) {
				$data['data_tagihan'][$i]['tagihan'][] = [
					'angsuran'	=> $detail['angsuran'],
					'jumlah_bayar'	=> $detail['jumlah_bayar'],
					'tgl_bayar'	=> $detail['tgl_bayar'],
					'tgl_byr_selanjutnya'	=> $detail['tgl_byr_selanjutnya'],
					'keterlambatan'	=> $detail['keterlambatan'],
					'denda'	=> $detail['denda']
				];
			}
			$i++;
		}
		$this->load->view('tagihan/laporan_tagihan', $data);
	}

	public function laporan_jatuh_tempo()
	{
		$this->load->view('layout/header');
		$this->load->view('tagihan/laporan_jatuh_tempo');
		$this->load->view('layout/footer');	
	}

	public function laporan_tagihan_jatuh_tempo()
	{
		$data['data_tagihan'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$data['penanggung'] = $this->tagihan_model->penanggung_jawab($namaPersetujuan);
		$tagihan = $this->tagihan_model->get_laporan_tagihan_jatuh_tempo($tglAwal, $tglAkhir);
		$i = 0;
		foreach ($tagihan as $tagihan) {
			$data['data_tagihan'][$i]['kode_tagihan'] = $tagihan['kode_tagihan'];
			$data['data_tagihan'][$i]['kode_barang_masuk'] = $tagihan['kode_barang_masuk'];
			$data['data_tagihan'][$i]['nama_supplier'] = $tagihan['nama_supplier'];
			$data['data_tagihan'][$i]['alamat_supplier'] = $tagihan['alamat_supplier'];
			$data['data_tagihan'][$i]['telp_supplier'] = $tagihan['telp_supplier'];
			$data['data_tagihan'][$i]['tgl_masuk'] = $tagihan['tgl_masuk'];
			$data['data_tagihan'][$i]['tgl_tempo'] = $tagihan['tgl_tempo'];
			$data['data_tagihan'][$i]['jangka_waktu'] = $tagihan['jangka_waktu'];
			$data['data_tagihan'][$i]['sisa_hutang'] = $tagihan['sisa_hutang'];
			$data['data_tagihan'][$i]['angsuran_perbulan'] = $tagihan['angsuran_perbulan'];
			$data['data_tagihan'][$i]['status'] = $tagihan['status'];
			$data['data_tagihan'][$i]['subtotal'] = $tagihan['subtotal'];
			$data['data_tagihan'][$i]['jumlah_retur'] = $tagihan['jumlah_retur'];
			$data['data_tagihan'][$i]['no_retur'] = $tagihan['no_retur'];

			$tagihan_detail = $this->tagihan_model->get_tagihan_detail($tagihan['id_tagihan']);
			$data['data_tagihan'][$i]['tagihan'] = [];
			foreach ($tagihan_detail as $detail) {
				$data['data_tagihan'][$i]['tagihan'][] = [
					'angsuran'	=> $detail['angsuran'],
					'jumlah_bayar'	=> $detail['jumlah_bayar'],
					'tgl_bayar'	=> $detail['tgl_bayar'],
					'tgl_byr_selanjutnya'	=> $detail['tgl_byr_selanjutnya'],
					'keterlambatan'	=> $detail['keterlambatan'],
					'denda'	=> $detail['denda']
				];
			}
			$i++;
		}
		$this->load->view('tagihan/laporan_tagihan_jatuh_tempo', $data);
	}	    
}