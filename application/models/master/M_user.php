<?php defined('BASEPATH') OR exit('No direct script access allowed');


class M_user extends CI_Model
{
	//Models
	const ID_USER = "ID_USER";
	const ID_CUSTOMER = "ID_CUSTOMER";
	const USERNAME = "USERNAME";
	const PASSWORD = "PASSWORD";
	const EXPIRED_TOKEN = "EXPIRED_TOKEN";
	const LAST_GET_TOKEN = "LAST_GET_TOKEN";
	const TOKEN = "TOKEN";

	//for inisialisasi.
	public $ID_USER;
	public $ID_CUSTOMER;
	public $USERNAME;
	public $PASSWORD;
	public $EXPIRED_TOKEN;
	public $LAST_GET_TOKEN;
	public $TOKEN;

	var $table = 'm_user';
	var $primary_key = 'ID_USER';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//Insert, Update, Delete
	/**
	 * @param $data
	 * @return bool|int
	 */
	public function save($data)
	{
		$this->db->insert($this->table, $data);
		$success = $this->db->conn_id->insert_id;
		return empty($success) ? FALSE : $success;
	}

	public function update($valueid,$data)
	{
		$this->db->where($this->primary_key,$valueid);
		$this->db->update($this->table,$data);

		$db = $this->db->conn_id;
		list($row,$change,$warning) = explode("  ",$db->info);
		$row 	= (int) str_replace('Rows matched: ','',$row);
		$change	= (int) str_replace('Changed: ','',$change);
		if(empty($row)){
			return 0; // tidak ditemukan data nya
		}else{
			if($change && $db->affected_rows){ //cek apakah update nya berhasil change dan affected rows != 0
				return 2; //berhasil di update datanya
			}else{
				return 1; // data ditemukan, tetapi tidak dilakukan perubahan
			}
		}
	}

	public function delete_by_id($id)
	{
		$this->db->where($this->primary_key, $id);
		$this->db->delete($this->table);
		return $this->db->conn_id->affected_rows ? true : false;
	}

	/**
	 * @param $where
	 */
	public function delete_where($where = [])
	{
		$this->db->where($where);
		$this->db->delete($this->table);
		return $this->db->conn_id->affected_rows ? true : false;
	}

	//Selecting Data

	/**
	 * @param int $id
	 * @return bool|M_user
	 */
	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where($this->primary_key,$id);
		$query = $this->db->get();
		return $query->num_rows() == 0 ? FALSE : $query->row();
	}
	/**
	 * @param array $data
	 * @return array | M_user
	 */
	public function select($data = []){
		if(empty($data)){
			$data = $this->db->get($this->table);
		}else{
			if(isset($data['column'])){
				$this->db->select($data['column']);
			}

			if(isset($data['order'])){
				foreach ($data['order'] as $key => $value) {
					$this->db->order_by($key,$value);
				}
			}

			if(isset($data['limit'])){
				$this->db->limit($data['limit']);
			}

			$data = isset($data['where']) ? $this->db->get_where($this->table, $data['where']) : $this->db->get($this->table);
		}
		return $data->result();
	}

	/**
	 * @param array $data
	 * @return array | M_user
	 */
	public function select_first($data = []){
		if(empty($data)){
			$data = $this->db->get($this->table);
		}else{
			if(isset($data['column'])){
				$this->db->select($data['column']);
			}

			if(isset($data['order'])){
				foreach ($data['order'] as $key => $value) {
					$this->db->order_by($key,$value);
				}
			}
			$this->db->limit(1);
			$data = $data['where'] ? $this->db->get_where($this->table, $data['where']) : $this->db->get($this->table);
		}
		return $data->row();
	}

	/**
	 * @param null|array|string $where
	 * @param array $order
	 * @return array|bool|M_user
	 */
	public function find_first($where = null, $order = []){
		//cek order
		if($order){
			foreach ($order as $key => $value) {
				$this->db->order_by($key,$value);
			}
		}
		//cek where
		$data = $where ? $this->db->get_where($this->table, $where) : $this->db->get($this->table);
		$result	= $data->num_rows();
		return empty($result) ? FALSE : $data->row();
	}

	/**
	 * @param null|array|string $where
	 * @param array $order
	 * @return array|bool|M_user
	 */
	public function find($where = null, $order = [],$limit = null){
		//cek order
		if($order){
			foreach ($order as $key => $value) {
				$this->db->order_by($key,$value);
			}
		}

		if(!empty($limit)){
			$this->db->limit($limit);
		}

		//cek where
		$data = $where ? $this->db->get_where($this->table, $where) : $this->db->get($this->table);
		$result	= $data->num_rows();
		//return
		return empty($result) ? FALSE : $data->result();
	}

	/**
	 * @param null $where
	 * @param array $order
	 * @return int
	 */
	public function count($where = null){
		//cek where
		$data = $where ? $this->db->get_where($this->table, $where) : $this->db->get($this->table);
		//return
		return $data->num_rows();
	}

	/**
	 * @param null 	$column
	 * @param null 	$where
	 * @return int
	 */
	public function sum($column = null,$where = null){
		//cek where
		$this->db->select_sum($column,'total');
		$data = $where ? $this->db->get_where($this->table, $where) : $this->db->get($this->table);
		//return
		return $data->row()->total;
	}

	public function get_comment($column,$type = NULL){
		$database 	= $this->db->database;
		$result 	= $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA = '{$database}' and TABLE_NAME = '{$this->table}' and COLUMN_NAME = '{$column}' ");
		if($result->num_rows() == 0){
			return '';
		}else{
			$comment 	= $result->row()->COLUMN_COMMENT;
			$pos 		= strpos($comment,'|');
			if(!empty($pos)){
				list($comment1,$comment2) = explode('|',$comment);

				if($type==null){
					return ucwords($comment1);
				}else{
					if($comment2){
						return ucwords($comment2);
					}else{
						return ucwords($comment);
					}
				}
			}
			return ucwords($comment);
		}
	}


	function CEK_USER($a,$b){
		$query=$this->db->query("select * from m_user where USERNAME='$a' and PASSWORD='$b'");
		$response=$query->num_rows();
		if ($response>0) {
			return TRUE;
		}else {
			return FALSE;
		}
	}

	public function UPDATE_TOKEN($where, $data){
		$this->db->trans_begin();
		$this->db->update('m_user', $data, $where);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return FALSE;
		}
		else{
			$this->db->trans_commit();
			return TRUE;
		}
	}

}


