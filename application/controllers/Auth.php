<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('access_control');
        $this->load->model('user_model');
    }

    public function index()
    {        
        if ($this->session->userdata('logged_in') == true){
            redirect('/');
        }        
        $this->load->view('auth/index');
    }

    public function login()
    {
        if ($this->session->userdata('logged_in') == true){
            redirect('/');
        }
        
        $this->form_validation->set_rules('username','Username','required',['required' => '%s harus diisi.']);
        $this->form_validation->set_rules('password','Password','required',['required' => '%s harus diisi.']);
        if ($this->form_validation->run() == false){
            $errors = validation_errors();
            $errors = str_replace(["<p>","</p>"],"",$errors);
            $errors = explode("\n", rtrim($errors,"\n"));
            echo json_encode(['status' => 'error', 'msg' => $errors ] );
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->user_model->get_user($username, md5($password));
            if ($user) {
                $session = [ 
                    'name'      => $user['username'],
                    'role'      => $user['id_role'],
                    'id_user'   => $user['id'],
                    'logged_in' => true
                ];
                $this->session->set_userdata($session);
                echo json_encode(['status'  => 'success', 'msg' => ['Berhasil login.'] ] );
            } else {
                echo json_encode(['status' => 'error', 'msg' => ['Username dan password salah.'] ] );
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
