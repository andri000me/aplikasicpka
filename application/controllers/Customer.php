<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper(['access_control', 'format_tanggal_indo']);
		$this->load->model('customer_model');
	}

	public function index()
	{

		$data['customer'] = $this->customer_model->get_all_customer();
		$this->load->view('layout/header');
		$this->load->view('customer/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$this->load->view('layout/header');
		$this->load->view('customer/baru');
		$this->load->view('layout/footer');
	}

	public function create()
	{
		$validation = [
			[
				'field' => 'namaCustomer',
				'label' => 'Nama Perusahaan',
				'rules' => 'required|min_length[3]|is_unique[customer.namaCustomer]',
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
			$kode = 'CS'.time();
			$config['upload_path']			= './upload/customer/';
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
			$this->customer_model->create([
				'kodeCustomer'      => $kode,
				'namaCustomer' 		=> $this->input->post('namaCustomer'),
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

		$data['edit_customer'] = $this->customer_model->get_customer($id);
		if (empty($data['edit_customer'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('customer/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{

		$validation = [
			[
				'field' => 'namaCustomer',
				'label' => 'Perusahaan',
				'rules' => 'required|min_length[3]|callback_customer_check',
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
			$berkas = $this->customer_model->get_delete_berkas($id);
			$config['upload_path']			= './upload/customer/';
			$config['allowed_types']		= '.gif|jpg|png|pdf|doc|docx';
			$config['file_name']			= date('Ymd').$berkas->kodeCustomer;
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
				'namaCustomer' 		=> $this->input->post('namaCustomer'),
				'alamat' 			=> $this->input->post('alamat'),
				'telp' 				=> $this->input->post('telp'),
				'penanggungJawab' 	=> $this->input->post('penanggungJawab'),
				'tglPersetujuan' 	=> $this->input->post('tglPersetujuan'),
				'berkas'			=> $berkas
			];
			$this->customer_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function customer_check()
	{

		$post = $this->input->post(null, true);
		$query = $this->db->query("SELECT * FROM customer WHERE namaCustomer ='$post[namaCustomer]' AND id !='$post[id]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('customer_check', 'Nama Perusahaan sudah pernah digunakan');
			return false;
		} else {
			return true;
		}
	}

	public function delete($id)
	{
		$berkas=$this->customer_model->get_delete_berkas($id);
		$this->customer_model->delete($id);
		if($berkas->berkas != null){
			if(file_exists(FCPATH."upload/customer/".$berkas->berkas)) {
				unlink(FCPATH."upload/customer/".$berkas->berkas);
			}
		}
		echo json_encode(['status' => 'success']);
	}

	public function laporan()
	{
		$this->load->view('layout/header');
		$this->load->view('customer/laporan');
		$this->load->view('layout/footer');	
	}

	public function laporan_customer()
	{
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Ibnu Hasfinoza';
		$data['penanggung'] = $this->customer_model->penanggung_jawab($namaPersetujuan);
		$data['report_customer'] = $this->customer_model->get_laporan_customer($tglAwal, $tglAkhir);
		$this->load->view('customer/laporan_customer', $data);
	}
}