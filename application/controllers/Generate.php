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

    public function tes($id,$username){
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


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://localhost/project/qloud/master/customer/update",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "PUT",
			CURLOPT_POSTFIELDS => "ID_APPS=1&KD_CUSTOMER=tes1212121212&NM_CUSTOMER=2&ALAMAT=1&KOTA=2&PROVINSI=2&NEGARA=3&SEKTOR=4&HP=5&TELP=6&TELP2=7&KETERANGAN=8&ST_DATA=9&ST_CUSTOMER=1&OPERATOR=2&TGL_BUAT=2019-09-05%2018%3A00%3A00&ID_CUSTOMER=1",
			CURLOPT_HTTPHEADER => array(
				"Accept: */*",
				"Accept-Encoding: gzip, deflate",
				"Cache-Control: no-cache",
				"Connection: keep-alive",
				"Content-Length: 211",
				"Content-Type: application/x-www-form-urlencoded",
				"Cookie: ci_session=egkej1f7t7dvo43m129o6p9lpjevnm3b",
				"Host: localhost",
				"Postman-Token: e0a62c9f-5701-4194-9468-12f5e47d0168,b5c6ac5b-8ad6-4f49-b38b-e6953734082e",
				"User-Agent: PostmanRuntime/7.15.2",
				"api_auth_key: oows0g8gck0occkscwcg84g8800go884c8o84084",
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
		} else {
			echo $response;
		}

	}

}

/* End of file Level.php */
