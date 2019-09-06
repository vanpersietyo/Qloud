<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Unirest\Request;

class Generate extends CI_Controller
{
	public function index(){
		$tabel = $this->db->list_tables();
		echo 'Generate Tabel :<br>';
		foreach ($tabel as $i => $item)
		{
			echo '<a href="'.site_url('generate/tabel/').$item.'" target="_blank">';
			echo $item;
			echo '</a>';
			echo '<br>';
		}
		$user = $this->db->get('api_user')->result();
		$data = [];
		foreach ($user as $item)
		{
			$data[$item->username] = $item->password;
		}
		var_dump($data);
	}

    public function tabel($table = null){
    	$this->load->library('conversion');
        $primarykey = $this->conversion->get_primary_key($table);
        $query      = $this->db->list_fields($table);
        echo "//Models<br>";

		foreach ($query as $value){
			echo 'const '.$value.'   =   "'.$value.'";<br>';
		}
		echo '<br>';
		echo '//for inisialisasi.<br>';
		foreach ($query as $value){
			echo 'public $'.$value.';<br>';
		}

        echo '<br>var $table        = '."'".$table."';";
        echo '<br>';
        echo 'var $primary_key  = '."'".$primarykey."';";
        echo '<br>';

        echo "<br><br>//Controllers<br>";
        echo "private".'$layout'."     = 'template/layout';";
        echo '<br>';
        echo "private".'$index_path'." = 'master/".strtolower(str_replace("V_","",$table))."/';";
        echo '<br>';
        echo "private".'$path_view'."  = 'pages/master/".strtolower(str_replace("V_","",$table))."/';<br><br>";

        echo '$INPUT = [<br>'."'UPDATE'          =>".'$this->input->post'."('UPDATE'),<br>";
        foreach ($query as $value){
            echo 'M_'.strtolower(str_replace('V_','',$table)).'::T_'.$value.'=>$this->input->post'."(".'M_'.strtolower(str_replace('V_','',$table)).'::T_'.$value."),<br>";
        }
        echo "];";

    }

    public function tes($id = null,$username = null){
//		$api_key = [
//			'api_auth_key' => 'oows0g8gck0occkscwcg84g8800go884c8o84084'
//		];
//		Conversion::show_debug(
//			Request::delete('http://localhost/project/qloud/master/user/delete/12',$api_key)
//	);
//		$this->load->model('master/M_user');
//		$data = [
//			M_user::USERNAME => $username,
//			M_user::PASSWORD => 1,
//		];
//		$delete = $this->M_user->delete_by_id($id);
//		$db = $this->db->conn_id;
//
//		if($db->info){
//			list($row,$change,$warning) = explode("  ",$db->info);
//			$row 	= str_replace('Rows matched: ','',$row);
//			$change	= str_replace('Changed: ','',$change);
//			$warning= str_replace('Warnings: ','',$warning);
//			Conversion::show_debug($row);
//			Conversion::show_debug($change);
//			Conversion::show_debug($warning);
//		}
//		Conversion::show_debug($db->affected_rows);
//		Conversion::show_debug($delete);
//		$this->load->config('rest');
//		Conversion::show_debug($this->config->item('rest_valid_logins'));
		$this->load->config('rest');
		var_dump($this->config->item('rest_enable_keys'));
	}

}

/* End of file Level.php */
