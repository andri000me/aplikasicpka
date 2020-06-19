<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper('access_control');
		$this->load->model('karyawan_model');
	}

	public function index()
	{

		$data['karyawan'] = $this->karyawan_model->get_all_karyawan();
		$this->load->view('layout/header');
		$this->load->view('karyawan/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$this->load->view('layout/header');
		$this->load->view('karyawan/baru');
		$this->load->view('layout/footer');
	}

	public function create()
	{

		$validation = [
			[
				'field' => 'nik',
				'label' => 'NIK',
				'rules' => 'required|min_length[3]|is_unique[karyawan.nik]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'namaKaryawan',
				'label' => 'Nama Karyawan',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'noTelp',
				'label' => 'No Telp',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
		];

		$this->form_validation->set_rules($validation);
		if ($this->form_validation->run() == false) {
			$errors = validation_errors();
			$errors = str_replace(["<p>","</p>"], "", $errors);
			$errors = explode("\n", rtrim($errors, "\n"));
			echo json_encode(['status' => 'error', 'msg' => $errors]);
		} else {
			$this->karyawan_model->create([
				'nik'    				=> $this->input->post('nik'),
				'namaKaryawan' 	=> $this->input->post('namaKaryawan'),
				'noTelp' 				=> $this->input->post('noTelp'),
			]);
			echo json_encode(['status' => 'success']);
			
		}
	}

	public function edit($id)
	{

		$data['edit_karyawan'] = $this->karyawan_model->get_karyawan($id);
		if (empty($data['edit_karyawan'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('karyawan/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{


		$validation = [
			[
				'field' => 'nik',
				'label' => 'NIK',
				'rules' => 'required|min_length[3]callback_karyawan_check',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'namaKaryawan',
				'label' => 'Nama Karyawan',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'noTelp',
				'label' => 'No Telp',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
		];

		$this->form_validation->set_rules($validation);
		if ($this->form_validation->run() == false) {
			$errors = validation_errors();
			$errors = str_replace(["<p>","</p>"], "", $errors);
			$errors = explode("\n", rtrim($errors, "\n"));
			echo json_encode(['status' => 'error', 'msg' => $errors]);
		} else {

			$data = [
				'nik'    				=> $this->input->post('nik'),
				'namaKaryawan' 	=> $this->input->post('namaKaryawan'),
				'noTelp' 				=> $this->input->post('noTelp'),
			];

			$this->karyawan_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function karyawan_check()
	{

		$post = $this->input->post(null, true);
		$query = $this->db->query("SELECT * FROM karyawan WHERE nik ='$post[nik]' AND id !='$post[id]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('karyawan_check', 'NIK sudah pernah digunakan');
			return false;
		} else {
			return true;
		}
	}

	public function delete($id)
	{

		$this->karyawan_model->delete($id);
		echo json_encode(['status' => 'success']);
	}
}