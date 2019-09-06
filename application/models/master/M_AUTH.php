<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_AUTH extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

  function CEK_TOKEN($token){
		$query=$this->db->query("select * from m_user where TOKEN='$token' and EXPIRED_TOKEN>NOW()");
		$response=$query->num_rows();
      if ($response>0) {
        return TRUE;
      }else {
        return FALSE;
      }
	}



}
