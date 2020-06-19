<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper(['access_control','format_tanggal_indo', 'format_rupiah']);
		$this->load->model('barang_model');
	}

	public function index()
	{

		$data['barang'] = $this->barang_model->get_all_barang();
		$this->load->view('layout/header');
		$this->load->view('barang/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$this->load->view('layout/header');
		$this->load->view('barang/baru');
		$this->load->view('layout/footer');
	}

	public function create()
	{

		$validation = [
			[
				'field' => 'nama',
				'label' => 'Nama Barang',
				'rules' => 'required|min_length[3]|is_unique[barang.namaBarang]',
				'errors' => [
					'is_unique' => '%s sudah pernah digunakan',
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'satuan',
				'label' => 'Satuan',
				'rules' => 'required|min_length[2]',
				'errors' => [
					'required' => '%s harus diisi.'

				]
			],
			[
				'field' => 'harga',
				'label' => 'Harga',
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
			$this->barang_model->create([
				'kodeBarang'       => 'BRG'.time(),
				'namaBarang' 		=> $this->input->post('nama'),
				'satuan' 			=> $this->input->post('satuan'),
				'hargaBeli' 		=> $this->input->post('harga')
			]);
			echo json_encode(['status' => 'success']);
			
		}
	}

	public function edit($id)
	{

		$data['edit_barang'] = $this->barang_model->get_barang($id);
		if (empty($data['edit_barang'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('barang/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{


		$validation = [
			[
				'field' => 'nama',
				'label' => 'Nama Barang',
				'rules' => 'required|min_length[3]|callback_barang_check',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'satuan',
				'label' => 'Satuan',
				'rules' => 'required|min_length[2]',
				'errors' => [
					'required' => '%s harus diisi.'

				]
			],
			[
				'field' => 'harga',
				'label' => 'Harga',
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
				'namaBarang' 				=> $this->input->post('nama'),
				'satuan' 			=> $this->input->post('satuan'),
				'hargaBeli' 	=> $this->input->post('harga')
			];
			$this->barang_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function barang_check()
	{

		$post = $this->input->post(null, true);
		$query = $this->db->query("SELECT * FROM barang WHERE namaBarang ='$post[nama]' AND id !='$post[id]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('barang_check', 'Nama Perusahaan sudah pernah digunakan');
			return false;
		} else {
			return true;
		}
	}

	public function delete($id)
	{

		$this->barang_model->delete($id);
		echo json_encode(['status' => 'success']);
	}

	public function laporan_barang()
	{

		$namaPersetujuan = 'Fahrul Razzi';
		$data['persetujuan'] = $this->barang_model->getPenanggungJawab($namaPersetujuan);
		$data['report_barang'] = $this->barang_model->getLaporanBarang();

		$this->load->view('barang/laporan_barang', $data);

	}
}