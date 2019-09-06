<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class Customer extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_customer');
	}

	public function select_get()
	{
		$id = $this->get(M_customer::ID_CUSTOMER);

		if (empty($id))
		{
			$customer = $this->M_customer->find();
			if ($customer)
			{
				$this->response($customer, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$this->response([
					'status' => FALSE,
					'message' => 'Customer Tidak Ditemukan'
				], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
		else {
			$id = (int) $id;
			if ($id <= 0)
			{
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
			$customer = $this->M_customer->get_by_id($id);
			if ($customer)
			{
				$this->set_response($customer, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$this->set_response([
					'status' 	=> FALSE,
					'message' 	=> 'Customer could not be found'
				], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
	}

	public function insert_post(){
		$data = [
			M_customer::ID_APPS			=> $this->post(M_customer::ID_APPS),
			M_customer::KD_CUSTOMER 	=> $this->post(M_customer::KD_CUSTOMER),
			M_customer::NM_CUSTOMER		=> $this->post(M_customer::NM_CUSTOMER),
			M_customer::ALAMAT			=> $this->post(M_customer::ALAMAT),
			M_customer::KOTA			=> $this->post(M_customer::KOTA),
			M_customer::SEKTOR			=> $this->post(M_customer::SEKTOR),
			M_customer::HP				=> $this->post(M_customer::HP),
			M_customer::TELP			=> $this->post(M_customer::TELP),
			M_customer::TELP2			=> $this->post(M_customer::TELP2),
			M_customer::NEGARA			=> $this->post(M_customer::NEGARA),
			M_customer::PROVINSI		=> $this->post(M_customer::PROVINSI),
			M_customer::KETERANGAN		=> $this->post(M_customer::KETERANGAN),
			M_customer::ST_CUSTOMER		=> $this->post(M_customer::ST_CUSTOMER),
			M_customer::ST_DATA			=> $this->post(M_customer::ST_DATA),
			M_customer::OPERATOR		=> $this->post(M_customer::OPERATOR),
			M_customer::TGL_BUAT		=> $this->post(M_customer::TGL_BUAT),
		];
		$this->_validate_insert();
		$insert = $this->M_customer->save($data);
		if($insert){
			$message = [
				'status'	=> true,
				'data' 		=> $data,
				'message'	=> 'Data Berhasil Disimpan'
			];
			$this->set_response($message, REST_Controller::HTTP_CREATED);
		}else{
			$message = [
				'status'	=> false,
				'data' 		=> $data,
				'message'	=> 'Data Gagal Simpan'
			];
			$this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
		}

	}

	private function _validate_insert()
	{
		$this->conversion->translate_error_form_validation();
		$data = $data['inputerror'] = $data['notiferror'] = []; //inisialisasi
		$data['status']	= TRUE; // TRUE = validation lolos | FALSE = validation gagal

		//validasi input

		//form validation
		$this->form_validation->set_rules(M_customer::ID_APPS, 'ID Aplikasi', 'required|trim');
		$this->form_validation->set_rules(M_customer::KD_CUSTOMER, 'Kode Customer', 'required|trim|is_unique[m_customer.KD_CUSTOMER]');
		$this->form_validation->set_rules(M_customer::NM_CUSTOMER, 'Nama Customer', 'required|trim');

		if ($this->form_validation->run() == FALSE){
			$data['status'] = FALSE;
			foreach ($this->form_validation->error_array() as $dtl => $value) {
				$data['inputerror'][]   = $dtl;
				$data['notiferror'][]   = $value;
			}
		}

		// Custom validation
//		if(empty($input[M_customer::ID_USER])){
//			$data['inputerror'][]   = M_customer::ID_USER;
//			$data['notiferror'][]   = 'Harga Tidak Boleh Kosong / 0';
//			$data['status']         = FALSE;
//		}

		if(!$data['status'])
		{
			$this->set_response($data, REST_Controller::HTTP_BAD_REQUEST);
		}

	}

	public function update_put(){
		$data = [
			M_customer::ID_APPS			=> $this->put(M_customer::ID_APPS),
			M_customer::KD_CUSTOMER 	=> $this->put(M_customer::KD_CUSTOMER),
			M_customer::NM_CUSTOMER		=> $this->put(M_customer::NM_CUSTOMER),
			M_customer::ALAMAT			=> $this->put(M_customer::ALAMAT),
			M_customer::KOTA			=> $this->put(M_customer::KOTA),
			M_customer::SEKTOR			=> $this->put(M_customer::SEKTOR),
			M_customer::HP				=> $this->put(M_customer::HP),
			M_customer::TELP			=> $this->put(M_customer::TELP),
			M_customer::TELP2			=> $this->put(M_customer::TELP2),
			M_customer::NEGARA			=> $this->put(M_customer::NEGARA),
			M_customer::PROVINSI		=> $this->put(M_customer::PROVINSI),
			M_customer::KETERANGAN		=> $this->put(M_customer::KETERANGAN),
			M_customer::ST_CUSTOMER		=> $this->put(M_customer::ST_CUSTOMER),
			M_customer::ST_DATA			=> $this->put(M_customer::ST_DATA),
			M_customer::OPERATOR		=> $this->put(M_customer::OPERATOR),
			M_customer::TGL_BUAT		=> $this->put(M_customer::TGL_BUAT),
		];
		$id = $this->put(M_customer::ID_CUSTOMER);
		$this->_validate_update();
		$update = $this->M_customer->update($id,$data);
		if(!$update){
			$message = [
				'status'	=> false,
				'data' 		=> $data,
				'message'	=> 'Data Tidak Ditemukan'
			];
			$this->set_response($message, REST_Controller::HTTP_NOT_FOUND);
		}else{
			if($update == 2){
				$message = [
					'status'	=> true,
					'data' 		=> $data,
					'message'	=> 'Data Berhasil Diupdate'
				];
				$this->set_response($message, REST_Controller::HTTP_OK);
			}else{
				$message = [
					'status'	=> true,
					'data' 		=> $data,
					'message'	=> 'Data Ditemukan, Tetapi Tidak Ada Perubahan Data'
				];
				$this->set_response($message, REST_Controller::HTTP_OK);
			}
		}
	}

	private function _validate_update()
	{
		$this->conversion->translate_error_form_validation();
		$data = $data['inputerror'] = $data['notiferror'] = []; //inisialisasi
		$data['status']	= TRUE; // TRUE = validation lolos | FALSE = validation gagal


		// Custom validation
		if(empty($this->put(M_customer::ID_CUSTOMER))){
			$data['inputerror'][]   = M_customer::ID_CUSTOMER;
			$data['notiferror'][]   = 'ID Customer Harus Diisi';
			$data['status']         = FALSE;
		}
		if(empty($this->put(M_customer::KD_CUSTOMER))){
			$data['inputerror'][]   = M_customer::KD_CUSTOMER;
			$data['notiferror'][]   = 'Kode Customer Harus Diisi';
			$data['status']         = FALSE;
		}

		if(!$data['status'])
		{
			$this->set_response($data, REST_Controller::HTTP_BAD_REQUEST);
		}

	}

	public function delete_delete()
	{
		$id_cust = $this->input->get(M_customer::ID_CUSTOMER);
		// Validate the id.
		if (empty($id_cust))
		{
			$data = [
				'status'	=> false,
				'data'		=> $id_cust,
				'message' 	=> "ID Customer Yang Anda Masukkan Salah"
			];
			$this->response($data, REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$customer = $this->M_customer->get_by_id($id_cust);
			if($customer){
				$this->M_customer->delete_by_id($id_cust);
				$message = [
					'status'	=> true,
					'data' 		=> $customer,
					'message' 	=> 'Data Customer Berhasil Dihapus'
				];
				$this->set_response($message, REST_Controller::HTTP_OK);
			}else{
				$data = [
					'status'	=> false,
					'data'		=> [M_customer::ID_CUSTOMER => $id_cust],
					'message' 	=> "ID Customer Yang Anda Masukkan Tidak Ditemukan"
				];
				$this->response($data, REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}


}
