<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper('access_control');
		$this->load->model('user_model');
	}

	public function index()
	{

		$data['users'] = $this->user_model->get_all_user();
		$this->load->view('layout/header');
		$this->load->view('user/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$this->load->view('layout/header');
		$this->load->view('user/baru');
		$this->load->view('layout/footer');
	}

	public function create()
	{


		$validation = [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|min_length[3]|is_unique[user.username]',
				'errors' => [
					'is_unique' => '%s sudah pernah digunakan',
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|min_length[4]',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'role',
				'label' => 'Hak Akses',
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
			$hashed_password = md5($this->input->post('password'));
			$this->user_model->create([
				'password'		=> $hashed_password,	
				'username' 		=> $this->input->post('username'),
				'id_role' 		=> $this->input->post('role')
			]);
			echo json_encode(['status' => 'success']);
		}
	}

	public function edit($id)
	{

		$data['edit_user'] = $this->user_model->get_user_by_id($id);
		if (empty($data['edit_user'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('user/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{


		$validation = [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required|min_length[3]|callback_user_check',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'role',
				'label' => 'Hak Akses',
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
				'username' 		=> $this->input->post('username'),
				'id_role' 		=> $this->input->post('role')
			];

			if (!empty($this->input->post('password'))) {
                $data['password'] = md5($this->input->post('password'));
            }

			$this->user_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function user_check()
	{

		$post = $this->input->post(null, true);
		$query = $this->db->query("SELECT * FROM user WHERE username ='$post[username]' AND id !='$post[id]'");
		if ($query->num_rows() > 0) {
			$this->form_validation->set_message('user_check', 'Username sudah pernah digunakan');
			return false;
		} else {
			return true;
		}
	}

	public function delete($id)
	{

		$this->user_model->delete($id);
		echo json_encode(['status' => 'success']);
	}

}