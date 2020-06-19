<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangJual extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}
		$this->load->helper(['access_control', 'format_rupiah', 'format_tanggal_indo']);
		$this->load->model('BarangJual_model');
		$this->load->model('barang_model');
		$this->load->model('customer_model');
	}

	public function index()
	{
		$data['BarangJual'] = $this->BarangJual_model->get_all_barang_jual();
		$this->load->view('layout/header');
		$this->load->view('BarangJual/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$data['barang'] = $this->barang_model->get_all_barang();
		$data['customer'] = $this->customer_model->get_all_customer();
		$this->load->view('layout/header');
		$this->load->view('BarangJual/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{

		$validation = [
			[
				'field' => 'tglJual',
				'label' => 'Tanggal Jual',
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
				'field' => 'barang',
				'label' => 'Barang',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'

				]
			],
			[
				'field' => 'customer',
				'label' => 'customer',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'jumlahJual',
				'label' => 'Jumlah',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'hargaJual',
				'label' => 'Harga Jual',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'satuan',
				'label' => 'Satuan',
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
			$this->BarangJual_model->create([
				'kodeBarangJual'		=> 'BJ'.time(),
				'tglJual' 				=> $this->input->post('tglJual'),
				'tglTempo' 				=> $this->input->post('tglTempo'),
				'namaBarangJual' 		=> $this->input->post('barang'),
				'idCustomer'	 		=> $this->input->post('customer'),
				'jumlahJual' 			=> $this->input->post('jumlahJual'),
				'hargaJual' 			=> $this->input->post('hargaJual'),
				'satuan' 				=> $this->input->post('satuan')
			]);
			echo json_encode(['status' => 'success']);
		}
	}

	public function edit($id)
	{

		$data['barang'] = $this->barang_model->get_all_barang();
		$data['customer'] = $this->customer_model->get_all_customer();
		$data['edit_BarangJual'] = $this->BarangJual_model->get_barang_jual($id);
		if (empty($data['edit_BarangJual'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('BarangJual/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{

		$validation = [
			[
				'field' => 'tglJual',
				'label' => 'Tanggal',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'barang',
				'label' => 'Barang',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'

				]
			],
			[
				'field' => 'customer',
				'label' => 'customer',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'jumlahJual',
				'label' => 'Jumlah',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'hargaJual',
				'label' => 'Harga Jual',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'satuan',
				'label' => 'Satuan',
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
				'tglJual' 				=> $this->input->post('tglJual'),
				'tglTempo' 				=> $this->input->post('tglTempo'),				
				'namaBarangJual' 		=> $this->input->post('barang'),
				'idCustomer'	 		=> $this->input->post('customer'),
				'jumlahJual' 			=> $this->input->post('jumlahJual'),
				'hargaJual' 			=> $this->input->post('hargaJual'),
				'satuan' 				=> $this->input->post('satuan')			
			];
			$this->BarangJual_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{

		$this->BarangJual_model->delete($id);
		echo json_encode(['status' => 'success']);
	}

	public function laporan()
	{
		$this->load->view('layout/header');
		$this->load->view('BarangJual/laporan');
		$this->load->view('layout/footer');	
	}

	public function laporan_barang_jual()
	{
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Ibnu Hasfinoza';
		$data['penanggung'] = $this->BarangJual_model->penanggung_jawab($namaPersetujuan);
		$data['report_barang_jual'] = $this->BarangJual_model->get_laporan_barang_jual($tglAwal, $tglAkhir);
		$this->load->view('BarangJual/laporan_barang_jual', $data);
	}
}