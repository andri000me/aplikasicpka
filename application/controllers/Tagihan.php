<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}
		$this->load->helper('access_control');
		$this->load->model('tagihan_model');
		$this->load->model('barang_model');
		$this->load->model('BarangMasuk_model');
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
		$data['barangmasuk'] = $this->BarangMasuk_model->get_all_BarangMasuk();
		$data['barang'] = $this->barang_model->get_all_barang();
		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$this->load->view('layout/header');
		$this->load->view('tagihan/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{
		$validation = [
			[
				'field' => 'idMasuk',
				'label' => 'Kode Masuk',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'idSupplier',
				'label' => 'Supplier',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'

				]
			],
			[
				'field' => 'idBarang',
				'label' => 'Barang',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'ppn',
				'label' => 'PPN',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],			
			[
				'field' => 'tglTempo',
				'label' => 'Tanggal Jatuh Tempo',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'jumlahPembayaran',
				'label' => 'Jumlah Tagihan',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],			
			[
				'field' => 'keterlambatan',
				'label' => 'Keterlambatan',
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
			$keterlambatan = $this->input->post('keterlambatan');
			$denda = 0;

			switch ($keterlambatan) {
				case 'Tepat Waktu':
					$denda = 0;
					break;

				case '1 Bulan' :
					$denda = 100000;
					break;

				case '2 Bulan' :
					$denda = 200000;
					break;
				
				case '3 Bulan' :
					$denda = 300000;
					break;

				case '4 Bulan' :
					$denda = 400000;
					break;

				case '5 Bulan' :
					$denda = 500000;
					break;

				case '6 Bulan' :
					$denda = 600000;
					break;

				case '7 Bulan' :
					$denda = 700000;
					break;

				case '8 Bulan' :
					$denda = 800000;
					break;

				case '9 Bulan' :
					$denda = 900000;
					break;

				case '10 Bulan' :
					$denda = 1000000;
					break;

				case '11 Bulan' :
					$denda = 1100000;
					break;
				
				case '12 Bulan' :
					$denda = 1200000;
					break;

				default:
					$denda = 0;
					break;
			}

			$this->tagihan_model->create([
				'kodeTagihan'			=> 'KT'.time(),
				'idMasuk' 				=> $this->input->post('idMasuk'),
				'idSupplier' 			=> $this->input->post('idSupplier'),
				'idBarang' 				=> $this->input->post('idBarang'),
				'ppn' 					=> $this->input->post('ppn'),	
				'tglTempo' 				=> $this->input->post('tglTempo'),
				'jumlahPembayaran'		=> $this->input->post('jumlahPembayaran'),
				'jumlahRetur' 			=> $this->input->post('jumlahRetur'),
				'keterlambatan' 		=> $keterlambatan,
				'denda' 				=> $denda,
			]);
			echo json_encode(['status' => 'success']);
		}
	}

	public function edit($id)
	{

		$data['barang'] = $this->barang_model->get_all_barang();
		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$data['barangmasuk'] = $this->BarangMasuk_model->get_all_barangmasuk();
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
				'label' => 'Kode Masuk',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'idSupplier',
				'label' => 'Supplier',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'

				]
			],
			[
				'field' => 'idBarang',
				'label' => 'Barang',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'ppn',
				'label' => 'PPN',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],			
			[
				'field' => 'tglTempo',
				'label' => 'Tanggal Jatuh Tempo',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'jumlahPembayaran',
				'label' => 'Jumlah Tagihan',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
				],			
			[
				'field' => 'jumlahRetur',
				'label' => 'Jumlah Retur',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'keterlambatan',
				'label' => 'Keterlambatan',
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
			$keterlambatan = $this->input->post('keterlambatan');
			$denda = 0;
			switch ($keterlambatan) {
				case 'Tepat Waktu':
					$denda = 0;
					break;

				case '1 Bulan' :
					$denda = 100000;
					break;

				case '2 Bulan' :
					$denda = 200000;
					break;
				
				case '3 Bulan' :
					$denda = 300000;
					break;

				case '4 Bulan' :
					$denda = 400000;
					break;

				case '5 Bulan' :
					$denda = 500000;
					break;

				case '6 Bulan' :
					$denda = 600000;
					break;

				case '7 Bulan' :
					$denda = 700000;
					break;

				case '8 Bulan' :
					$denda = 800000;
					break;

				case '9 Bulan' :
					$denda = 900000;
					break;

				case '10 Bulan' :
					$denda = 1000000;
					break;

				case '11 Bulan' :
					$denda = 1100000;
					break;
				
				case '12 Bulan' :
					$denda = 1200000;
					break;

				default:
					$denda = 0;
					break;
			}

			$data = [
				'idMasuk' 				=> $this->input->post('idMasuk'),
				'idSupplier' 			=> $this->input->post('idSupplier'),
				'idBarang' 				=> $this->input->post('idBarang'),
				'ppn' 					=> $this->input->post('ppn'),	
				'tglTempo' 				=> $this->input->post('tglTempo'),
				'jumlahPembayaran'		=> $this->input->post('jumlahPembayaran'),
				'jumlahRetur' 			=> $this->input->post('jumlahRetur'),
				'keterlambatan' 		=> $keterlambatan,
				'denda' 				=> $denda,
			];
			$this->tagihan_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{

		$this->tagihan_model->delete($id);
		echo json_encode(['status' => 'success']);
	}
}