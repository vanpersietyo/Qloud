<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_APPS extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function count_apps(){
		$query=$this->db->query("select count(KD_APPS) as tot_data from m_apps");
		$response=$query->row();
		return $response->tot_data;
	}

	function get_apps(){
		$query=$this->db->query("select * from m_apps");
		return $query->result();
	}

	public function save($data){
    $this->db->trans_begin();
      $this->db->insert('m_apps', $data);
    if ($this->db->trans_status() === FALSE){
      $this->db->trans_rollback();
      return FALSE;
    }
    else{
      $this->db->trans_commit();
      return TRUE;
    }

	}

	public function update($where, $data){
		$this->db->update('m_gaji', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id){
		$this->db->where('id', $id);
		$this->db->delete('m_gaji');
	}


}
