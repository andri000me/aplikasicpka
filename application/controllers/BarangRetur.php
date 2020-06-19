<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BarangRetur extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('logged_in') == false) {
			redirect('/auth');
		}
		$this->load->helper(['access_control', 'format_rupiah', 'format_tanggal_indo']);
		$this->load->model('BarangRetur_model');
		$this->load->model('barang_model');
		$this->load->model('supplier_model');
	}

	public function index()
	{
		$data['barang_retur'] = $this->BarangRetur_model->get_all_barang_retur();
		$this->load->view('layout/header');
		$this->load->view('BarangRetur/index', $data);
		$this->load->view('layout/footer');
	}

	public function baru()
	{
		$data['barang'] = $this->barang_model->get_all_barang();
		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$this->load->view('layout/header');
		$this->load->view('BarangRetur/baru', $data);
		$this->load->view('layout/footer');
	}

	public function create()
	{

		$validation = [
			[
				'field' => 'tgl_retur',
				'label' => 'Tanggal Retur',
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
			$id_retur = $this->BarangRetur_model->create_barang_retur([
				'tgl_retur' 		=> $this->input->post('tgl_retur'),
				'id_supplier' 		=> $this->input->post('supplier')
			]);

			$kode_retur = $this->BarangRetur_model->generate_kode_retur($id_retur);
            $data = $this->input->post('id_barang');

            $this->BarangRetur_model->create_barang_retur_detail($id_retur, $data);			
			echo json_encode(['status' => 'success', 'data' => ['kode_retur' => $kode_retur]]);
		}
	}

	public function edit($id)
	{

		$data['barang'] = $this->barang_model->get_all_barang();
		$data['supplier'] = $this->supplier_model->get_all_supplier();
		$data['edit_barang_retur'] = $this->BarangRetur_model->get_barang_retur($id);
		if (empty($data['edit_barang_retur'])) {
			show_404();
		}

		$this->load->view('layout/header');
		$this->load->view('BarangRetur/edit', $data);
		$this->load->view('layout/footer');
	}

	public function update($id)
	{

		$validation = [
			[
				'field' => 'tgl_retur',
				'label' => 'Tanggal Retur',
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
				'tgl_retur' 		=> $this->input->post('tgl_retur'),
				'id_supplier' 		=> $this->input->post('supplier')
			];
			$this->BarangRetur_model->update($id, $data);
			echo json_encode(['status' => 'success']);
		}
	}	

	public function delete($id)
	{
        if ($this->BarangRetur_model->check_detail_barang_retur($id) > 0) {
            echo json_encode(['status' => 'failed']);
        } else {
            $this->BarangRetur_model->delete($id);
            echo json_encode(['status' => 'success']);
        }
	}

    public function detail($id)
    {
        $data['detail_barang_retur'] = $this->BarangRetur_model->detail_barang_retur($id);
        $data['detail_barang_retur_semua'] = $this->BarangRetur_model->get_barang_retur_detail($id);
        $this->load->view('layout/header');
        $this->load->view('BarangRetur/detail', $data);
        $this->load->view('layout/footer');
    }	

    public function printDetailBarangRetur($id)
    { 
        $data['print_barang_retur'] = $this->BarangRetur_model->detail_barang_retur($id);
        $data['print_barang_retur_detail'] = $this->BarangRetur_model->get_barang_retur_detail($id);
        $this->load->view('BarangRetur/print_barang_retur_detail', $data);
    }    

    public function getBarangReturDetail($id)
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $data['data'] = $this->BarangRetur_model->get_barang_retur_detail($id);
        echo json_encode($data);
    }

    public function createBarangReturDetail()
    {
        $data['id_retur'] = $this->input->post('id_barang_retur');
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_retur'] = $this->input->post('qty');
        $data['keterangan'] = $this->input->post('keterangan');
        $this->BarangRetur_model->create_barang_retur_detail_satuan($data);
        echo json_encode(['status' => 'success']);
    }    

    public function updateBarangReturDetail($id)
    {
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_retur'] = $this->input->post('qty');
        $data['keterangan'] = $this->input->post('keterangan');
        $this->BarangRetur_model->update_barang_retur_detail($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteQtyBarang($id)
    {
        $data['id_barang'] = $this->input->post('id_barang');
        $data['jumlah_retur'] = $this->input->post('qty');
        $this->BarangRetur_model->delete_qty_barang($id, $data);
        echo json_encode(['status' => 'success']);
    }

    public function deleteBarangReturDetail($id)
    {
        $this->BarangRetur_model->delete_barang_retur_detail($id);
        echo json_encode(['status' => 'success']);
    }

	public function laporan()
	{
		$this->load->view('layout/header');
		$this->load->view('BarangRetur/laporan');
		$this->load->view('layout/footer');	
	}

	public function laporan_barang_retur()
	{
		$data['data_barang_retur'] = [];
		$tglAwal = $this->input->post('tglAwal');
		$tglAkhir = $this->input->post('tglAkhir');
		$namaPersetujuan = 'Fahrul Razzi';
		$data['penanggung'] = $this->BarangRetur_model->penanggung_jawab($namaPersetujuan);
		$barang_retur = $this->BarangRetur_model->get_laporan_barang_retur($tglAwal, $tglAkhir);
		$i = 0;

		foreach ($barang_retur as $retur) {
			$data['data_barang_retur'][$i]['kode_retur'] = $retur['kode_retur'];
			$data['data_barang_retur'][$i]['nama_supplier'] = $retur['nama_supplier'];
			$data['data_barang_retur'][$i]['tgl_retur'] = $retur['tgl_retur'];

			$data_barang_retur_detail = $this->BarangRetur_model->get_barang_retur_detail_laporan($retur['id_retur']);
			$data['data_barang_retur'][$i]['retur'] = [];
			foreach ($data_barang_retur_detail as $detail) {
				$data['data_barang_retur'][$i]['retur'][] = [
					'kode_barang' => $detail['kode_barang'],
					'nama_barang' => $detail['nama_barang'],
					'jumlah_retur' => $detail['jumlah_retur'],
					'satuan' => $detail['satuan'],
					'harga_beli' => $detail['harga_beli'],
					'subtotal' => $detail['subtotal'],
					'keterangan' => $detail['keterangan'],
				];
			}
			$i++;
		}
		
		$this->load->view('BarangRetur/laporan_barang_retur', $data);
	}
}