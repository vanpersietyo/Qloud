<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_user');
	}

	public function select_get()
	{
		$id = $this->get('id');

		if ($id === NULL)
		{
			$user = $this->M_user->find();
			if ($user)
			{
				$this->response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$this->response([
					'status' => FALSE,
					'message' => 'No user were found'
				], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
		else {
			$id = (int) $id;
			if ($id <= 0)
			{
				$this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
			}
			$user = $this->M_user->get_by_id($id);
			if ($user)
			{
				$this->set_response($user, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
			}
			else
			{
				$this->set_response([
					'status' 	=> FALSE,
					'message' 	=> 'User could not be found'
				], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
			}
		}
	}

	public function insert_post(){
		$data = [
			M_user::USERNAME 	=> $this->post(M_user::USERNAME),
			M_user::PASSWORD	=> $this->post(M_user::PASSWORD)
		];
		$this->_validate_insert();
		$insert = $this->M_user->save($data);
		if($insert){
			$message = [
				'status'	=> true,
				'data' 		=> $insert,
				'message'	=> 'Data Berhasil Disimpan'
			];
			$this->set_response($message, REST_Controller::HTTP_CREATED);
		}else{
			$message = [
				'status'	=> false,
				'data' 		=> null,
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
		$this->form_validation->set_rules(M_user::USERNAME, 'Username', 'required|trim|is_unique[user.USERNAME]');
		$this->form_validation->set_rules(M_user::PASSWORD, 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE){
			$data['status'] = FALSE;
			foreach ($this->form_validation->error_array() as $dtl => $value) {
				$data['inputerror'][]   = $dtl;
				$data['notiferror'][]   = $value;
			}
		}

		// Custom validation
//		if(empty($input[M_user::ID_USER])){
//			$data['inputerror'][]   = M_user::ID_USER;
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
			M_user::ID_USER 	=> $this->put(M_user::ID_USER),
			M_user::USERNAME 	=> $this->put(M_user::USERNAME),
			M_user::PASSWORD	=> $this->put(M_user::PASSWORD)
		];

		$update = [
			M_user::USERNAME	=> $data[M_user::USERNAME],
			M_user::PASSWORD	=> $data[M_user::PASSWORD],
		];
		$update = $this->M_user->update($data[M_user::ID_USER],$update);
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

		//validasi input

		//form validation
		$this->form_validation->set_rules(M_user::USERNAME, 'Username', 'required|trim');
		$this->form_validation->set_rules(M_user::PASSWORD, 'Password', 'required|trim');

		if ($this->form_validation->run() == FALSE){
			$data['status'] = FALSE;
			foreach ($this->form_validation->error_array() as $dtl => $value) {
				$data['inputerror'][]   = $dtl;
				$data['notiferror'][]   = $value;
			}
		}

		// Custom validation
//		if(empty($input[M_user::ID_USER])){
//			$data['inputerror'][]   = M_user::ID_USER;
//			$data['notiferror'][]   = 'Harga Tidak Boleh Kosong / 0';
//			$data['status']         = FALSE;
//		}

		if(!$data['status'])
		{
			$this->set_response($data, REST_Controller::HTTP_BAD_REQUEST);
		}

	}

	public function delete_delete()
	{
		$id_user = $this->input->get(M_user::ID_USER);
		// Validate the id.
		if (empty($id_user))
		{
			$data = [
				'status'	=> false,
				'data'		=> $id_user,
				'message' 	=> "ID User Yang Anda Masukkan Salah"
			];
			$this->response($data, REST_Controller::HTTP_BAD_REQUEST);
		}else{
			$user = $this->M_user->get_by_id($id_user);
			if($user){
				$this->M_user->delete_by_id($id_user);
				$message = [
					'status'	=> true,
					'data' 		=> $user,
					'message' 	=> 'Data User Berhasil Dihapus'
				];
				$this->set_response($message, REST_Controller::HTTP_OK);
			}else{
				$data = [
					'status'	=> false,
					'data'		=> $id_user,
					'message' 	=> "ID User Yang Anda Masukkan Tidak Ditemukan"
				];
				$this->response($data, REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}
}
