<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Rivaldy Setiawan, Adhitya Dwi Prasetyo
 * @license         Mazabuta Development System
 * @link            https://qloud.id
 */

use Restserver\Libraries\REST_Controller;
class Apps extends REST_Controller {

	function __construct(){
		parent::__construct();
		$this->methods['users_get']['limit'] = 5; // 500 requests per hour per user/key
		$this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
		$this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    $this->load->model('MASTER/M_APPS', 'MASTER_APPS');
		$this->load->model('MASTER/M_AUTH', 'AUTH');
	}

	function view_post(){
		$token=$this->post('acsess_token');
		if ($this->validate_user($token)==TRUE) {
			$message = [
				'eror'       => false,
				'messages'   => 'Completed',
				'raw_count'  => $this->MASTER_APPS->count_apps(),
				'raw_body'   => $this->MASTER_APPS->get_apps()
			];
		}elseif ($this->validate_user($token)==FALSE | $token='') {
			$message = [
				'eror'       => true,
				'messages'   => 'Acsess Denied Expired Or Wrong Token',
			];
		}

		$this->set_response($message, REST_Controller::HTTP_CREATED);
	}

	public function add_post(){
		$token=$this->post('acsess_token');
		$data = array(
								'KD_APPS'    => $this->post('KD_APPS'),
								'NM_APPS'    => $this->post('NM_APPS'),
								'VERSION'    => $this->post('VERSION'),
								'AUTHOR'     => $this->post('AUTHOR'),
								'KETERANGAN' => $this->post('KETERANGAN'),
								'TGL_DEV'    => $this->post('TGL_DEV'),
								'TGL_LAUNCH' => $this->post('TGL_LAUNCH'),
								'TGL_BUAT'   => $this->post('TGL_BUAT'),
								'ST_DATA'    => $this->post('ST_DATA'),
								'OPERATOR'   => $this->post('OPERATOR')
								);
		if ($this->validate_user($token)==TRUE) {
			if ($data['KD_APPS']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field KD_APPS Cannot Be Null'
				 ];
			 }elseif ($data['NM_APPS']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field NM_APPS Cannot Be Null'
				 ];
			 }elseif ($data['VERSION']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field VERSION Cannot Be Null'
				 ];
			 }elseif ($data['AUTHOR']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field AUTHOR Cannot Be Null'
				 ];
			 }elseif ($data['TGL_LAUNCH']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field TGL_LAUNCH Cannot Be Null'
				 ];
			 }elseif ($data['TGL_BUAT']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field TGL_BUAT Cannot Be Null'
				 ];
			 }elseif ($data['ST_DATA']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field ST_DATA Cannot Be Null'
				 ];
			 }elseif ($data['OPERATOR']=='') {
				 $message = [
					 'eror'     => true,
					 'messages'   => 'Field OPERATOR Cannot Be Null'
				 ];
			 }else {
				 $INSERT=$this->MASTER_APPS->SAVE($data);
						 if ($INSERT=FALSE) {
							 $message = [
								 'eror'       => true,
								 'messages'   => 'Failed Insert',
							 ];
						 }else {
							 $message = [
								 'eror'       => false,
								 'messages'   => 'Completed Insert',
							 ];
						 }
			 }
		}elseif ($this->validate_user($token)==FALSE | $token='') {
			$message = [
				'eror'       => true,
				'messages'   => 'Acsess Denied Expired Or Wrong Token',
			];
		}
			$this->set_response($message, REST_Controller::HTTP_CREATED);
	}

	function validate_user($token){
		$val=$this->AUTH->CEK_TOKEN($token);
		// var_dump($token);
		// exit();
		if ($val==TRUE) {
			return TRUE;
		}else {
			return FALSE;
		}
	}



}
