<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') == false){
            redirect('/auth');
        }
        $this->load->helper('access_control');

        $this->load->model('BarangMasuk_model');
        $this->load->model('BarangKeluar_model');
        $this->load->model('BarangJual_model');
        $this->load->model('tagihan_model');
        $this->load->model('penagihan_model');
        $this->load->model('user_model');
    }

	public function index()
	{

        $data['total_barang_masuk'] = $this->BarangMasuk_model->total_barang_masuk();
        $data['total_barang_keluar'] = $this->BarangKeluar_model->total_barang_keluar();
        $data['total_barang_jual'] = $this->BarangJual_model->total_barang_jual();
        $data['total_tagihan'] = $this->tagihan_model->total_tagihan();

		$this->load->view('layout/header');
        if (is_admin()) {
            $this->load->view('home/index', $data);
        
        } else {
            $this->load->view('home/welcome', $data);
        }
		$this->load->view('layout/footer');
	}
}
