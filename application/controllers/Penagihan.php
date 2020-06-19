<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penagihan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}
		$this->load->helper(['access_control', 'format_rupiah', 'format_tanggal_indo']);
		$this->load->model(['penagihan_model', 'customer_model', 'BarangJual_model']);

	}

	public function index()
	{
		$data['penagihan'] = $this->penagihan_model->get_all_penagihan();
		$this->load->view('layout/header');
		$this->load->view('penagihan/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$data['barang_jual'] = $this->BarangJual_model->get_all_barang_jual();
		$this->load->view('layout/header');
		$this->load->view('penagihan/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{
		$validation = [
			[
				'field' => 'idJual',
				'label' => 'Nomor Penjualan',
				'rules' => 'required|is_unique[penagihan.id_jual]',
				'errors' => [
					'is_unique' => '%s sudah dalam proses pembayaran',
					'required' => '%s harus diisi.'
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
			$id_penagihan = $this->penagihan_model->create_penagihan([
				'id_jual' 		=> $this->input->post('idJual'),
				'jangka_waktu' 		=> $this->input->post('jangka_waktu'),
				'sisa_hutang' 		=> $this->input->post('sisa_hutang'),
				'angsuran_perbulan' 		=> $this->input->post('perbulan'),
				'status' 		=> 'Belum Lunas'
			]);

			$kode_penagihan = $this->penagihan_model->generate_kode_penagihan($id_penagihan);
            $data = $this->input->post('angsuran');

            $this->penagihan_model->create_penagihan_detail($id_penagihan, $data);			
			echo json_encode(['status' => 'success', 'data' => ['kode_penagihan' => $kode_penagihan]]);
		}
	}

	public function edit($id)
	{

		$data['barang_jual'] = $this->BarangJual_model->get_all_barang_jual();
		$data['edit_penagihan'] = $this->penagihan_model->get_penagihan($id);
		if (empty($data['edit_penagihan'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('penagihan/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{

		$validation = [
			[
				'field' => 'idJual',
				'label' => 'Nomor Penjualan',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'jangka_waktu',
				'label' => 'Jangka Waktu',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'status',
				'label' => 'Status',
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
				'id_jual' 			=> $this->input->post('idJual'),
				'jangka_waktu' 		=> $this->input->post('jangka_waktu'),
				'angsuran_perbulan' => $this->input->post('perbulan'),
				'status' 			=> $this->input->post('status')
			];
			$this->penagihan_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{
        if ($this->penagihan_model->check_detail_penagihan($id) > 0) {
            echo json_encode(['status' => 'failed']);
        } else {
            $this->penagihan_model->delete($id);
            echo json_encode(['status' => 'success']);
        }
	}

    public function detail($id)
    {
        $data['detail_penagihan'] = $this->penagihan_model->detail_penagihan($id);
        $data['detail_penagihan_semua'] = $this->penagihan_model->get_penagihan_detail($id);
        $this->load->view('layout/header');
        $this->load->view('penagihan/detail', $data);
        $this->load->view('layout/footer');
    }

    public function printPenagihanDetail($id)	
    {
    	$data['print_penagihan'] = $this->penagihan_model->detail_penagihan($id);
    	$data['print_penagihan_semua'] = $this->penagihan_model->get_penagihan_detail($id);
    	$this->load->view('print_penagihan_detail', $data);
    }

    public function printDetailPenagihan($id)
    { 
        $data['print_penagihan'] = $this->penagihan_model->detail_penagihan($id);
        $data['print_penagihan_semua'] = $this->penagihan_model->get_penagihan_detail($id);
        $this->load->view('penagihan/print_penagihan_detail', $data);
    }    

    public function getPenagihanDetail($id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data['data'] = $this->penagihan_model->get_penagihan_detail($id);
        echo json_encode($data);
    }

    public function createPenagihanDetail()
    {
        $data['angsuran'] = $this->input->post('angsuran');
        $data['jumlah_bayar'] = $this->input->post('jumlah_pembayaran');
        $data['tgl_bayar'] = $this->input->post('tgl_bayar');
        $data['tgl_byr_selanjutnya'] = $this->input->post('tgl_byr_selanjutnya');
        $data['keterlambatan'] = $this->input->post('keterlambatan');
        $data['denda'] = $this->input->post('denda');
        $data['id_penagihan'] = $this->input->post('id_tagih');
        $this->penagihan_model->create_penagihan_detail_satuan($data);
        echo json_encode(['status' => 'success']);
    }    

    public function updatePenagihanDetail($id)
    {
        $data['angsuran'] = $this->input->post('angsuran');
        $data['jumlah_pembayaran'] = $this->input->post('jumlah_pembayaran');
        $data['tgl_bayar'] = $this->input->post('tgl_bayar');
        $data['tgl_byr_selanjutnya'] = $this->input->post('tgl_byr_selanjutnya');
        $data['keterlambatan'] = $this->input->post('keterlambatan');
        $data['denda'] = $this->input->post('denda');
        $data['id_penagihan'] = $this->input->post('id_penagihan');
        $this->penagihan_model->update_penagihan_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function batalAngsuran($id)
    {
    	$data['jumlah_pembayaran'] = $this->input->post('jumlah_pembayaran');
        $data['denda'] = $this->input->post('denda');
        $data['id_penagihan'] = $this->input->post('id_penagihan');
        $this->penagihan_model->batal_penagihan_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deletePenagihanDetail($id)
    {
        $this->penagihan_model->delete_penagihan_detail($id);
        echo json_encode(['status' => 'success']);
    }

	public function laporan()
	{
		$data['data_customer'] = $this->customer_model->get_all_customer();
		$this->load->view('layout/header');
		$this->load->view('penagihan/laporan', $data);
		$this->load->view('layout/footer');	
	}

	public function laporan_penagihan()
	{
		$data['data_penagihan'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$customer = $this->input->post('customer');
		$data['penanggung'] = $this->penagihan_model->penanggung_jawab($namaPersetujuan);
		$penagihan = $this->penagihan_model->get_laporan_penagihan($customer);
		$i = 0;
		foreach ($penagihan as $tagihan) {
			$data['data_penagihan'][$i]['nama_customer'] = $tagihan['nama_customer'];
			$data['data_penagihan'][$i]['kode_penagihan'] = $tagihan['kode_penagihan'];
			$data['data_penagihan'][$i]['kode_barang_jual'] = $tagihan['kode_barang_jual'];
			$data['data_penagihan'][$i]['nama_barang_jual'] = $tagihan['nama_barang_jual'];
			$data['data_penagihan'][$i]['satuan'] = $tagihan['satuan'];
			$data['data_penagihan'][$i]['harga_jual'] = $tagihan['harga_jual'];
			$data['data_penagihan'][$i]['jumlah_jual'] = $tagihan['jumlah_jual'];
			$data['data_penagihan'][$i]['alamat_customer'] = $tagihan['alamat'];
			$data['data_penagihan'][$i]['telp_customer'] = $tagihan['telp'];
			$data['data_penagihan'][$i]['no_penjualan'] = $tagihan['kode_barang_jual'];
			$data['data_penagihan'][$i]['jangka_waktu'] = $tagihan['jangka_waktu'];
			$data['data_penagihan'][$i]['tgl_jual'] = $tagihan['tgl_jual'];
			$data['data_penagihan'][$i]['tgl_tempo'] = $tagihan['tgl_tempo'];
			$data['data_penagihan'][$i]['subtotal'] = $tagihan['subtotal'];
			$data['data_penagihan'][$i]['sisa_hutang'] = $tagihan['sisa_hutang'];
			$data['data_penagihan'][$i]['angsuran_perbulan'] = $tagihan['angsuran_perbulan'];
			$data['data_penagihan'][$i]['status'] = $tagihan['status'];

			$penagihan_detail = $this->penagihan_model->get_penagihan_detail($tagihan['id_penagihan']);
			$data['data_penagihan'][$i]['tagihan'] = [];
			foreach ($penagihan_detail as $detail) {
				$data['data_penagihan'][$i]['tagihan'][] = [
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
		$this->load->view('penagihan/laporan_penagihan', $data);
	}

	public function laporan_jatuh_tempo()
	{
		$this->load->view('layout/header');
		$this->load->view('penagihan/laporan_jatuh_tempo');
		$this->load->view('layout/footer');	
	}

	public function laporan_penagihan_jatuh_tempo()
	{
		$data['data_penagihan'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$data['penanggung'] = $this->penagihan_model->penanggung_jawab($namaPersetujuan);
		$penagihan = $this->penagihan_model->get_laporan_penagihan_jatuh_tempo($tglAwal, $tglAkhir);
		$i = 0;
		foreach ($penagihan as $tagihan) {
			$data['data_penagihan'][$i]['nama_customer'] = $tagihan['nama_customer'];
			$data['data_penagihan'][$i]['kode_penagihan'] = $tagihan['kode_penagihan'];
			$data['data_penagihan'][$i]['kode_barang_jual'] = $tagihan['kode_barang_jual'];
			$data['data_penagihan'][$i]['nama_barang_jual'] = $tagihan['nama_barang_jual'];
			$data['data_penagihan'][$i]['satuan'] = $tagihan['satuan'];
			$data['data_penagihan'][$i]['harga_jual'] = $tagihan['harga_jual'];
			$data['data_penagihan'][$i]['jumlah_jual'] = $tagihan['jumlah_jual'];
			$data['data_penagihan'][$i]['alamat_customer'] = $tagihan['alamat'];
			$data['data_penagihan'][$i]['telp_customer'] = $tagihan['telp'];
			$data['data_penagihan'][$i]['no_penjualan'] = $tagihan['kode_barang_jual'];
			$data['data_penagihan'][$i]['jangka_waktu'] = $tagihan['jangka_waktu'];
			$data['data_penagihan'][$i]['tgl_jual'] = $tagihan['tgl_jual'];
			$data['data_penagihan'][$i]['tgl_tempo'] = $tagihan['tgl_tempo'];
			$data['data_penagihan'][$i]['subtotal'] = $tagihan['subtotal'];
			$data['data_penagihan'][$i]['sisa_hutang'] = $tagihan['sisa_hutang'];
			$data['data_penagihan'][$i]['angsuran_perbulan'] = $tagihan['angsuran_perbulan'];
			$data['data_penagihan'][$i]['status'] = $tagihan['status'];

			$penagihan_detail = $this->penagihan_model->get_penagihan_detail($tagihan['id_penagihan']);
			$data['data_penagihan'][$i]['tagihan'] = [];
			foreach ($penagihan_detail as $detail) {
				$data['data_penagihan'][$i]['tagihan'][] = [
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
		$this->load->view('penagihan/laporan_penagihan_jatuh_tempo', $data);
	}	
}