<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Rivaldy Setiawan, Adhitya Dwi Prasetyo
 * @license         Mazabuta Development System
 * @link            https://qloud.id
 */

class Cloudways extends CI_Controller {

	function __construct(){
		parent::__construct();
    $this->load->model('MASTER/M_APPS', 'MASTER_APPS');
    $this->load->library("unirest");
	}

	function auth(){

    $auth_data = array(
      'email'               => 'dimasrakas@icloud.com',
      'api_key'              => 'mw2pf7ewruNGBzyIpnhQXKG3UGBsAE'
      );
    $bdy_auth=json_encode($auth_data, JSON_UNESCAPED_SLASHES);
    $url_auth="https://api.cloudways.com/api/v1/oauth/access_token";
    $response_auth = $this->unirest->post($url_auth, $headers = array('Content-Type'=>"application/json" ), $body=$bdy_auth );
    $auth=$response_auth->raw_body;
    $token_result=json_decode($auth);
    $token=$token_result->access_token;

    return $token;
	}

  function clone_apps($nama_apps){
    $clone_data = array(
      'server_id'          => '249264',
      'app_id'             => '952734',
      'app_label'          => $nama_apps,
      'access_token'       => $this->auth()
      );
    $bdy_clone=json_encode($clone_data, JSON_UNESCAPED_SLASHES);
    $url_clone="https://api.cloudways.com/api/v1/app/clone";
    $response_clone = $this->unirest->post($url_clone, $headers = array('Content-Type'=>"application/json" ), $body=$bdy_clone );
    $clone=$response_clone->raw_body;
    $clone_result=json_decode($clone);
    $clone_response=$clone_result->app_id;
      if ($clone_response=='' | $clone_response==null ) {
        return false;
      }else {
        return true;
      }

  }


}
