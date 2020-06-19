<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sms extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper('access_control');
		$this->load->library('SmsGateway');
	}

	public function index() 
	{
		$this->load->view('layout/header');
		$this->load->view('sms/baru');
		$this->load->view('layout/footer');

	}

	public function kirim_sms()
	{
		$validation = [
			[
				'field' => 'no_hp',
				'label' => 'Nomor Handphone',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'isi_pesan',
				'label' => 'Masukkan Pesan',
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
			$to = $this->input->post('no_hp');
			$message = $this->input->post("isi_pesan", true);
			$this->smsgateway->setIp('192.168.100.70:8080');
			$this->smsgateway->sendSMS($to, $message);
			echo json_encode(['status' => 'success']);
		}		
	}
}