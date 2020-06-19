<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper(['access_control', 'format_tanggal_indo']);
		$this->load->model('supplier_model');
	}

	public function index()
	{

		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$this->load->view('layout/header');
		$this->load->view('supplier/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$this->load->view('layout/header');
		$this->load->view('supplier/baru');
		$this->load->view('layout/footer');
	}

	public function create()
	{
		$validation = [
			[
				'field' => 'namaSupplier',
				'label' => 'Perusahaan',
				'rules' => 'required|min_length[3]|is_unique[supplier.namaSupplier]',
				'errors' => [
					'is_unique' => '%s sudah pernah digunakan',
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'telp',
				'label' => 'Nomor Telepon',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'penanggungJawab',
				'label' => 'Penanggung Jawab',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'tglPersetujuan',
				'label' => 'Tanggal Persetujuan',
				'rules' => 'required|min_length[3]',
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
			$kode = 'SP'.time();
			$config['upload_path']			= './upload/supplier/';
			$config['allowed_types']		= '.gif|jpg|png|pdf|doc|docx';
			$config['file_name']			= $kode;
			$config['overwrite']			= true;
			$config['max_size']				= 10240; //1MB

			$berkas = null;

		$this->load->library('upload', $config);
			if ($this->upload->do_upload('berkas')) {
				$berkas = $this->upload->data('file_name');
			} else {
				$berkas = null;
			}
			$this->supplier_model->create([
				'kodeSupplier'      => $kode,
				'namaSupplier' 		=> $this->input->post('namaSupplier'),
				'alamat' 			=> $this->input->post('alamat'),
				'telp' 				=> $this->input->post('telp'),
				'penanggungJawab' 	=> $this->input->post('penanggungJawab'),
				'tglPersetujuan' 	=> $this->input->post('tglPersetujuan'),
				'berkas'			=> $berkas
			]);
			echo json_encode(['status' => 'success']);
		}
	}

	public function edit($id)
	{

		$data['edit_supplier'] = $this->supplier_model->get_supplier($id);
		if (empty($data['edit_supplier'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('supplier/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{

		$validation = [
			[
				'field' => 'namaSupplier',
				'label' => 'Perusahaan',
				'rules' => 'required|min_length[3]|callback_supplier_check',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'alamat',
				'label' => 'Alamat',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'telp',
				'label' => 'Nomor Telepon',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'penanggungJawab',
				'label' => 'Penanggung Jawab',
				'rules' => 'required|min_length[3]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'tglPersetujuan',
				'label' => 'tglPersetujuan',
				'rules' => 'required|min_length[3]',
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
			$berkas = $this->supplier_model->get_delete_berkas($id);
			$config['upload_path']			= './upload/supplier/';
			$config['allowed_types']		= '.gif|jpg|png|pdf|doc|docx';
			$config['file_name']			= date('Ymd').$berkas->kodeSupplier;
			$config['overwrite']			= true;
			$config['max_size']				= 10240; //1MB

			$berkas = null;

			$this->load->library('upload', $config);
			if (!empty($_FILES["berkas"]["name"])) {
			if ($this->upload->do_upload('berkas')) {
				$berkas = $this->upload->data('file_name');
			}
			} else {
				$berkas = $this->input->post('old_berkas');
			}
			$data = [
				'namaSupplier' 		=> $this->input->post('namaSupplier'),
				'alamat' 			=> $this->input->post('alamat'),
				'telp' 				=> $this->input->post('telp'),
				'penanggungJawab' 	=> $this->input->post('penanggungJawab'),
				'tglPersetujuan' 	=> $this->input->post('tglPersetujuan'),
				'berkas'			=> $berkas
			];
			$this->supplier_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function supplier_check()
	{

		$post = $this->input->post(null, true);
		$query = $this->db->query("SELECT * FROM supplier WHERE namaSupplier ='$post[namaSupplier]' AND id !='$post[id]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('supplier_check', 'Nama Perusahaan sudah pernah digunakan');
			return false;
		} else {
			return true;
		}
	}

	public function delete($id)
	{
		$berkas=$this->supplier_model->get_delete_berkas($id);
		$this->supplier_model->delete($id);
		echo json_encode(['status' => 'success']);
		if($berkas->berkas != null){
			if(file_exists(FCPATH."upload/supplier/".$berkas->berkas)) {
				unlink(FCPATH."upload/supplier/".$berkas->berkas);
			}
		}
		echo json_encode(['status' => 'success']);
	}

	public function laporan()
	{
		$this->load->view('layout/header');
		$this->load->view('supplier/laporan');
		$this->load->view('layout/footer');	
	}

	public function laporan_supplier()
	{
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$data['penanggung'] = $this->supplier_model->penanggung_jawab($namaPersetujuan);
		$data['report_supplier'] = $this->supplier_model->get_laporan_supplier($tglAwal, $tglAkhir);
		$this->load->view('supplier/laporan_supplier', $data);
	}

}