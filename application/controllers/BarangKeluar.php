<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangKeluar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}

		$this->load->helper(['access_control', 'format_rupiah', 'format_tanggal_indo']);
		$this->load->model('BarangKeluar_model');
		$this->load->model('barang_model');
		$this->load->model('karyawan_model');
	}

	public function index()
	{

		$data['barang_keluar'] = $this->BarangKeluar_model->get_all_barang_keluar();
		$this->load->view('layout/header');
		$this->load->view('BarangKeluar/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$data['barang'] = $this->barang_model->get_all_barang();
		$data['karyawan'] = $this->karyawan_model->get_all_karyawan();
		$this->load->view('layout/header');
		$this->load->view('BarangKeluar/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{
		$validation = [
			[
				'field' => 'tgl_keluar',
				'label' => 'Tanggal Barang Keluar',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'karyawan',
				'label' => 'Nama Karyawan',
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
			$id_keluar = $this->BarangKeluar_model->create_barang_keluar([
				'tgl_keluar' 		=> $this->input->post('tgl_keluar'),
				'id_karyawan' 		=> $this->input->post('karyawan'),
				'keterangan' 		=> $this->input->post('keterangan')
			]);

			$kode_keluar = $this->BarangKeluar_model->generate_kode_keluar($id_keluar);
            $data = $this->input->post('id_barang');

            $this->BarangKeluar_model->create_barang_keluar_detail($id_keluar, $data);			
			echo json_encode(['status' => 'success', 'data' => ['kode_keluar' => $kode_keluar]]);
		}
	}

	public function edit($id)
	{

		$data['barang'] = $this->barang_model->get_all_barang();
		$data['karyawan'] = $this->karyawan_model->get_all_karyawan();
		$data['edit_barang_keluar'] = $this->BarangKeluar_model->get_barang_keluar($id);
		if (empty($data['edit_barang_keluar'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('BarangKeluar/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{
		$validation = [
			[
				'field' => 'tgl_keluar',
				'label' => 'Tanggal Barang Keluar',
				'rules' => 'required',
				'errors' => [
					'required' => '%s harus diisi.'
				]
			],
			[
				'field' => 'karyawan',
				'label' => 'Nama Karyawan',
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
				'tgl_keluar' 		=> $this->input->post('tgl_keluar'),
				'id_karyawan' 		=> $this->input->post('karyawan'),
				'keterangan' 		=> $this->input->post('keterangan')
			];
			$this->BarangKeluar_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{
        if ($this->BarangKeluar_model->check_detail_barang_keluar($id) > 0) {
            echo json_encode(['status' => 'failed']);
        } else {
            $this->BarangKeluar_model->delete($id);
            echo json_encode(['status' => 'success']);
        }
	}

    public function detail($id)
    {
        $data['detail_barang_keluar'] = $this->BarangKeluar_model->detail_barang_keluar($id);
        $data['detail_barang_keluar_semua'] = $this->BarangKeluar_model->get_barang_keluar_detail($id);
        $this->load->view('layout/header');
        $this->load->view('BarangKeluar/detail', $data);
        $this->load->view('layout/footer');
    }	

    public function printDetailBarangKeluar($id)
    { 
        $data['print_barang_keluar'] = $this->BarangKeluar_model->detail_barang_keluar($id);
        $data['print_barang_keluar_detail'] = $this->BarangKeluar_model->get_barang_keluar_detail($id);
        $this->load->view('BarangKeluar/print_barang_keluar_detail', $data);
    }	

    public function getBarangKeluarDetail($id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data['data'] = $this->BarangKeluar_model->get_barang_keluar_detail($id);
        echo json_encode($data);
    }	

    public function createBarangKeluarDetail()
    {
        $data['id_keluar'] = $this->input->post('id_barang_keluar');
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_keluar'] = $this->input->post('qty');
        $this->BarangKeluar_model->create_barang_keluar_detail_satuan($data);
        echo json_encode(['status' => 'success']);
    }    

    public function updateBarangKeluarDetail($id)
    {
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_keluar'] = $this->input->post('qty');
        $this->BarangKeluar_model->update_barang_keluar_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteQtyBarang($id)
    {
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_keluar'] = $this->input->post('qty');
        $this->BarangKeluar_model->delete_qty_barang($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteBarangKeluarDetail($id)
    {
        $this->BarangKeluar_model->delete_barang_keluar_detail($id);
        echo json_encode(['status' => 'success']);
    }    

	public function laporan()
	{
		$this->load->view('layout/header');
		$this->load->view('BarangKeluar/laporan');
		$this->load->view('layout/footer');	
	}

	public function laporan_barang_keluar()
	{
		$data['data_barang_keluar'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$data['penanggung'] = $this->BarangKeluar_model->penanggung_jawab($namaPersetujuan);
		$barang_keluar = $this->BarangKeluar_model->get_laporan_barang_keluar($tglAwal, $tglAkhir);
		$i = 0;

		foreach ($barang_keluar as $keluar) {
			$data['data_barang_keluar'][$i]['kode_keluar'] = $keluar['kode_keluar'];
			$data['data_barang_keluar'][$i]['nama_karyawan'] = $keluar['nama_karyawan'];
			$data['data_barang_keluar'][$i]['tgl_keluar'] = $keluar['tgl_keluar'];
			$data['data_barang_keluar'][$i]['keterangan'] = $keluar['keterangan'];

			$data_barang_keluar_detail = $this->BarangKeluar_model->get_barang_keluar_detail_laporan($keluar['id_keluar']);
			$data['data_barang_keluar'][$i]['keluar'] = [];
			foreach ($data_barang_keluar_detail as $detail) {
				$data['data_barang_keluar'][$i]['keluar'][] = [
					'kode_barang' => $detail['kode_barang'],
					'nama_barang' => $detail['nama_barang'],
					'jumlah_keluar' => $detail['jumlah_keluar'],
					'satuan' => $detail['satuan'],
					'harga_beli' => $detail['harga_beli'],
					'subtotal' => $detail['subtotal']
				];
			}
			$i++;
		}
		
		$this->load->view('BarangKeluar/laporan_barang_keluar', $data);
	}
}