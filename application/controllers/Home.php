<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') == false){
            redirect('/auth');
        }
        $this->load->helper(['access_control', 'format_tanggal_indo']);

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
        $data['data_tagihan'] = [];

        $tempo = $this->tagihan_model->get_tanggal_jatuh_tempo();
        $i = 0;

        foreach ($tempo as $dt) {
            $data['data_tagihan'][$i]['kode_tagihan'] = $dt['kode_tagihan'];
            $data['data_tagihan'][$i]['tanggal'] = $dt['tgl_byr_selanjutnya'];
            $data['data_tagihan'][$i]['jatuh_tempo'] = $dt['jatuh_tempo'];
            $data['data_tagihan'][$i]['supplier'] = $dt['nama_supplier'];
            $data['data_tagihan'][$i]['telp'] = $dt['telp'];
            $data['data_tagihan'][$i]['kode_masuk'] = $dt['kode_masuk'];
            $i++;
        }

        $data['data_penagihan'] = [];
        $tempoPenagihan = $this->penagihan_model->get_tanggal_jatuh_tempo();
        $i = 0;

        foreach ($tempoPenagihan as $tp) {
            $data['data_penagihan'][$i]['kode_penagihan'] = $tp['kode_penagihan'];
            $data['data_penagihan'][$i]['tanggal'] = $tp['tgl_byr_selanjutnya'];
            $data['data_penagihan'][$i]['jatuh_tempo'] = $tp['jatuh_tempo'];
            $data['data_penagihan'][$i]['customer'] = $tp['nama_customer'];
            $data['data_penagihan'][$i]['telp'] = $tp['telp'];
            $data['data_penagihan'][$i]['kode_jual'] = $tp['kode_jual'];
            $i++;
        }



		$this->load->view('layout/header');
        if (is_admin()) {
            $this->load->view('home/index', $data);
        
        } else {
            $this->load->view('home/welcome', $data);
        }
		$this->load->view('layout/footer');
	}
}
