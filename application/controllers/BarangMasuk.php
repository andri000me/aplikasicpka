<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangMasuk extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}
		$this->load->helper(['access_control', 'format_rupiah','format_tanggal_indo']);
		$this->load->model('BarangMasuk_model');
		$this->load->model('barang_model');
		$this->load->model('supplier_model');
	}

	public function index()
	{
		$data['barang_masuk'] = $this->BarangMasuk_model->get_all_barang_masuk();
		$this->load->view('layout/header');
		$this->load->view('BarangMasuk/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$data['barang'] = $this->barang_model->get_all_barang();
		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$this->load->view('layout/header');
		$this->load->view('BarangMasuk/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{

		$validation = [
			[
				'field' => 'tgl',
				'label' => 'Tanggal Barang Masuk',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'tgl_tempo',
				'label' => 'Tanggal Jatuh Tempo',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'supplier',
				'label' => 'Supplier',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'id_barang[]',
				'label' => 'Barang',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'qty[]',
				'label' => 'Qty',
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
			$id_masuk = $this->BarangMasuk_model->create_barang_masuk([
				'tgl_masuk' 		=> $this->input->post('tgl'),
				'tgl_tempo' 		=> $this->input->post('tgl_tempo'),
				'id_supplier' 		=> $this->input->post('supplier')
			]);

			$kode_masuk = $this->BarangMasuk_model->generate_kode_masuk($id_masuk);
            $data = $this->input->post('id_barang');

            $this->BarangMasuk_model->create_barang_masuk_detail($id_masuk, $data);			
			echo json_encode(['status' => 'success', 'data' => ['kode_masuk' => $kode_masuk]]);
		}
	}

	public function edit($id)
	{

		$data['barang'] = $this->barang_model->get_all_barang();
		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$data['edit_barang_masuk'] = $this->BarangMasuk_model->get_barang_masuk($id);
		if (empty($data['edit_barang_masuk'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('BarangMasuk/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{

		$validation = [
			[
				'field' => 'tgl',
				'label' => 'Tanggal Barang Masuk',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'tgl_tempo',
				'label' => 'Tanggal Jatuh Tempo',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'supplier',
				'label' => 'Supplier',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'id_barang[]',
				'label' => 'Barang',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'qty[]',
				'label' => 'Qty',
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
				'tgl_masuk' 		=> $this->input->post('tgl'),
				'tgl_tempo' 		=> $this->input->post('tgl_tempo'),
				'id_supplier' 		=> $this->input->post('supplier')
			];
			$this->BarangMasuk_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{
        if ($this->BarangMasuk_model->check_detail_barang_masuk($id) > 0) {
            echo json_encode(['status' => 'failed']);
        } else {
            $this->BarangMasuk_model->delete($id);
            echo json_encode(['status' => 'success']);
        }
	}

    public function detail($id)
    {
        $data['detail_barang_masuk'] = $this->BarangMasuk_model->detail_barang_masuk($id);
        $data['detail_barang_masuk_semua'] = $this->BarangMasuk_model->get_barang_masuk_detail($id);
        $this->load->view('layout/header');
        $this->load->view('BarangMasuk/detail', $data);
        $this->load->view('layout/footer');
    }

    public function printDetailBarangMasuk($id)
    { 
        $data['print_barang_masuk'] = $this->BarangMasuk_model->detail_barang_masuk($id);
        $data['print_barang_masuk_detail'] = $this->BarangMasuk_model->get_barang_masuk_detail($id);
        $this->load->view('BarangMasuk/print_barang_masuk_detail', $data);
    }    

    public function getBarangMasukDetail($id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data['data'] = $this->BarangMasuk_model->get_barang_masuk_detail($id);
        echo json_encode($data);
    }

    public function createBarangMasukDetail()
    {
        $data['id_masuk'] = $this->input->post('id_barang_masuk');
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_masuk'] = $this->input->post('qty');
        $this->BarangMasuk_model->create_barang_masuk_detail_satuan($data);
        echo json_encode(['status' => 'success']);
    }    

    public function updateBarangMasukDetail($id)
    {
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_masuk'] = $this->input->post('qty');
        $this->BarangMasuk_model->update_barang_masuk_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteQtyBarang($id)
    {
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_masuk'] = $this->input->post('qty');
        $this->BarangMasuk_model->delete_qty_barang($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteBarangMasukDetail($id)
    {
        $this->BarangMasuk_model->delete_barang_masuk_detail($id);
        echo json_encode(['status' => 'success']);
    }

	public function laporan()
	{
		$this->load->view('layout/header');
		$this->load->view('BarangMasuk/laporan');
		$this->load->view('layout/footer');	
	}

	public function laporan_barang_masuk()
	{
		$data['data_barang_masuk'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$data['penanggung'] = $this->BarangMasuk_model->penanggung_jawab($namaPersetujuan);
		$barang_masuk = $this->BarangMasuk_model->get_laporan_barang_masuk($tglAwal, $tglAkhir);
		$i = 0;

		foreach ($barang_masuk as $masuk) {
			$data['data_barang_masuk'][$i]['kode_masuk'] = $masuk['kode_masuk'];
			$data['data_barang_masuk'][$i]['tgl_masuk'] = $masuk['tgl_masuk'];
			$data['data_barang_masuk'][$i]['tgl_tempo'] = $masuk['tgl_tempo'];
			$data['data_barang_masuk'][$i]['nama_supplier'] = $masuk['nama_supplier'];

			$data_barang_masuk_detail = $this->BarangMasuk_model->get_barang_masuk_detail_laporan($masuk['id']);
			$data['data_barang_masuk'][$i]['masuk'] = [];
			foreach ($data_barang_masuk_detail as $detail) {				
				$data['data_barang_masuk'][$i]['masuk'][] = [
					'kode_barang' => $detail['kode_barang'],
					'nama_barang' => $detail['nama_barang'],
					'jumlah_masuk' => $detail['jumlah_masuk'],
					'satuan' => $detail['satuan'],
					'harga_beli' => $detail['harga_beli'],
					'subtotal' => $detail['subtotal']
				];
			}
			$i++;
		}

		$this->load->view('BarangMasuk/laporan_barang_masuk', $data);
	}
}