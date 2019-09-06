<?php

use TelegramBot\Api\BotApi;
use Unirest\Request;

/**
 * Created by PhpStorm.
 * User: PC-06
 * Date: 07/02/2019
 * Time: 15:37
 * @property CI_Controller CI
 */

class Conversion
{

	const CHANNEL_NUHAPOS 	= 'nuhapos';
	const CHANNEL_DEVS 		= 'devs';

    /**
     * Conversion constructor.
     */
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    //====================================================Convert Tanggal==============================================//

    /**
     * @param $tanggal
     * @param int $jenis
     * @return string
     */
    public static function dateIndo($tanggal, $jenis = 0){
        $iMonth= date('n',strtotime($tanggal));
        if($jenis)
        {
            $bulan= array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
        }
        else
        {
            $bulan = array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nop','Des');
        }
            $hari  = date('d',strtotime($tanggal));
            $bln   = $bulan[$iMonth];
            $tahun = date('Y',strtotime($tanggal));

        return $hari." ".$bln." ".$tahun;
    }

    /**
     * @param $kode
     * @param int $jenis
     * @return mixed
     */
    public static function monthIndo($kode, $jenis = 0){
        if($jenis)
        {$bulan= array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');}
        else
        {$bulan= array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nop','Des');}

        return $bulan[intval($kode)];
    }

    /**
     * @param $kode
     * @param int $jenis
     * @return mixed
     */
    public static function dayIndo($date = null){
    	if(empty($date)){
    		$hari = self::dayIndo(date('Y-m-d'));
		}else{
			if(self::convert_date($date,'l')=='Monday'){
				$hari = 'Senin';
			}elseif(self::convert_date($date,'l')=='Tuesday'){
				$hari = 'Selasa';
			}elseif(self::convert_date($date,'l')=='Wednesday'){
				$hari = 'Rabu';
			}elseif(self::convert_date($date,'l')=='Thursday'){
				$hari = 'Kamis';
			}elseif(self::convert_date($date,'l')=='Friday'){
				$hari = 'Jumat';
			}elseif(self::convert_date($date,'l')=='Saturday'){
				$hari = 'Sabtu';
			}elseif(self::convert_date($date,'l')=='Sunday'){
				$hari = 'Minggu';
			}else{
				self::dayIndo();
			}
		}
        return $hari;
    }

    /**
     * @param $tgl
     * @param $format
     * @return false|string
     */
    public static function convert_date($tgl, $format = 'd-m-Y H:i'){
        if($tgl == '0000-00-00 00:00:00'){
            return '-';
        }else{
            $date = date_create($tgl);
            return date_format($date,$format);
        }
    }

    /**
     * @param $tgl
     * @param $format
     * @return false|string
     */
    public static function get_date($format = null){
        if(empty($format)){
            return date('d-m-Y H:i:s');
        }else{
            return date($format);
        }
    }

    /**
     * @param $value
     * @return string
     */
    public static function datePlusDays($date,$hari)
    {
    	$date = self::convert_date($date,'Y-m-d');
		return date('Y-m-d', strtotime($date. ' + '.$hari.' days'));
    }

    /**
     * @param $date
     * @param $hari
     * @return false|string
     */
    public static function dateMinusDays($date, $hari)
    {
		$date = self::convert_date($date,'Y-m-d');
		return date('Y-m-d', strtotime($date. ' - '.$hari.' days'));
    }

    /**
     * @param $tgl
     * @param $wkt
     * @return string
     */
    public static function combine_tanggal_waktu($tgl, $wkt){
        return $tgl.' '.$wkt.':'.Conversion::get_date('s');
    }

    //====================================================Convert Number==============================================//

    /**
     * @param $value
     * @return string
     * Function spell untuk mengeja nominal uang
     */
    public static function spell($value){
        $str = '';
        if ($value == 0) {
            $str = "nihil";
        } else {
            $basic = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
            $number = array(1000000000000,1000000000,1000000,1000,100,10,1);
            $unit = array('triliun','milyar','juta','ribu','ratus','puluh','');

            $i=0;
            while($value!=0){
                $count = (int)($value/$number[$i]);
                if($count>=10) $str .=  self::spell($count). " ".$unit[$i]." ";
                else if($count > 0 && $count < 10)
                    $str .= $basic[$count] . " ".$unit[$i]." ";
                $value -= $number[$i] * $count;
                $i++;
            }
            $str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
            $str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","se\\1",$str);
        }
        return ucwords($str);
    }
    /**
     * @param $value
     * @return string
     */
    public static function numberFormat($value)
    {
        return number_format($value, 0, ',', '.');
    }
    /**
     * @param $value
     * @return string
     */
    public static function rupiahFormat($value)
    {
        return 'Rp. '.number_format($value, 0, '.', ',');
    }
    /**
     * @param $nilai
     * @return string
     */
    public static function formatMinus($nilai){
        if($nilai>0){
            return self::numberFormat($nilai);
        }else if($nilai==0){
            return "-";
        }else{
            $nilai = substr($nilai,1, strlen($nilai));
            return '('.self::numberFormat($nilai).')';
        }
    }
    /**
     * @param string|int|float $value
     * @return int */
    public static function toInteger($value) {
        $array      = explode('.', $value);
        $separator   = ( strlen(end($array)) !== 2 ) ? '.' : ',';
        $decimal     = ( strlen(end($array)) === 2 ) ? '.' : ',';
        return (int) str_replace($decimal, '.', str_replace($separator, '',  $value));
    }

    /**
     * @param $num
     * @return string
     */
    public static function romawi($num){
        $n = intval($num);
        $res = '';
        /*** roman_numerals array  ***/
        $roman_numerals = array(
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C'  => 100,
            'XC' => 90,
            'L'  => 50,
            'XL' => 40,
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1);
        foreach ($roman_numerals as $roman => $number){
            /*** divide to get  matches ***/
            $matches = intval($n / $number);
            /*** assign the roman char * $matches ***/
            $res .= str_repeat($roman, $matches);
            /*** substract from the number ***/
            $n = $n % $number;
        }
        /*** return the res ***/
        return $res;
    }

    /**
     * @param $money
     * @return int
     */
    public static function unmasked_money($money){
        $return = self::toInteger(str_replace(['Rp.',','],'',$money));
        return $return;
    }

    /**
     * @param $number
     * @return mixed
     */
    public static function unmasked_phone($number){
        $return = str_replace(['(',')','_'],'',$number);
        return $return;
    }

    //=======================================================Database=================================================//

    /**
     * @param null $table
     * @return string
     */
    public function column_search($table = null){
        $result = $this->CI->db->list_fields($table);
        $i=1;
        foreach ($result as $item) {
            $column ="'".$item."'";
            if($i!=sizeof($result)){
                $separator = ',';
            }else{
                $separator = '';
            };
            $i++;
            $implode[] = $column.$separator;
        }
        return implode($implode,'');
    }

    /**
     * @param null $table
     * @return string
     */
    public function column_order($table = null){
        $result = $this->CI->db->list_fields($table);
        $i=1;
        foreach ($result as $item) {
            $column ="'".$item."'";
            if($i!=sizeof($result)){
                $separator = ',';
            }else{
                $separator = '';
            };
            $i++;
            $implode[] = $column.$separator;
        }
        return 'null,'.implode($implode,'').',null';
    }

    /**
     * @param null $table
     * @return mixed
     */
    public function get_primary_key($table = null){
        $result = $this->CI->db->list_fields($table);
        return $result[0];
    }

    //=====================================================Templating HTML============================================//

    /**
     * @param null $messages
     * @return string
     */
    public static function template_error($messages=null){
        return '<p class="badge-default badge-danger block-tag text-center" style="margin-bottom: 0.25rem !important;margin-top: 0.25rem !important;"><small class="block-area white">'.$messages.'</small></p>';
    }

    /**
     * @param null $messages
     * @return string
     */
    public static function alert_danger($messages=null){
        return '<div class="alert alert-icon-left alert-danger alert-dismissible mb-2" role="alert">
				<span class="alert-icon"><i class="la la-warning"></i></span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<strong style="color: white">'.$messages.'</strong>.
			</div>';
    }

    /**
     * @param null $messages
     * @return string
     */
    public static function alert_success($messages=null){
        return '<div class="alert alert-icon-left alert-success alert-dismissible mb-2" role="alert">
				<span class="alert-icon"><i class="la la-check"></i></span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<strong style="color: white">'.$messages.'</strong>.
			</div>';
    }

    /**
     * @param null $messages
     * @return string
     */
    public static function tooltip($messages){
        return 'data-toggle="tooltip" data-original-title="'.$messages.'"';
    }

    /**
     * @param string $messages
     * @return string
     */
    public static function template_success($messages='Berhasil'){
        return '<p class="badge-default badge-success block-tag text-center" style="margin-bottom: 0.25rem !important;margin-top: 0.25rem !important;"><small class="block-area white">'.$messages.'</small></p>';
    }

	/**
	 * @param mixed ...$args
	 * @return string
	 */
	public static function template_button_dropdown(...$args){
		$prefix = '	<button type="button" class="btn btn-blue bg-accent-4 dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-menu"></i></button>
					<div class="dropdown-menu">';
		$suffix = ' </div>';
		$button = '';
		foreach ($args as $tes){
			$button = $button.$tes;
		}
		return $prefix.$button.$suffix;
    }

	/**
	 * @param null $messages
	 * @return string
	 */
	public static function error_notif_input($name){
		return '<div id="error_messages" class="NOTIF_ERROR_'.$name.'"></div>';
	}

    /**
     * @param $data
     * @param bool $die
     */
    public static function show_debug($data, $die = false){
        echo "<pre>";
        print_r ($data);
        echo "</pre>";
        if($die){
            die();
        }
    }

    /**
     *
     */
    public function translate_error_form_validation(){
        $this->CI->load->library('form_validation');
        $this->CI->form_validation->set_message('required', '{field} Tidak Boleh Kosong.');
        $this->CI->form_validation->set_message('min_length', '{field} Minimal {param} Karakter.');
        $this->CI->form_validation->set_message('max_length', '{field} Panjang Maksimal {param} Karakter.');
        $this->CI->form_validation->set_message('exact_length', '{field} Minimal {param} Karakter.');
        $this->CI->form_validation->set_message('greater_than', '{field} Harus Lebih Besar Dari {param}');
        $this->CI->form_validation->set_message('greater_than_equal_to', '{field} Harus Lebih Besar Sama Dengan {param}');
        $this->CI->form_validation->set_message('less_than', '{field} Harus Lebih Kecil Dari {param}');
        $this->CI->form_validation->set_message('less_than_equal_to', '{field} Harus Lebih Kecil Sama Dengan {param}');
        $this->CI->form_validation->set_message('numeric', '{field} Harus Angka.');
        $this->CI->form_validation->set_message('alpha_numeric', '{field} Hanya Boleh Huruf Dan Angka.');
        $this->CI->form_validation->set_message('alpha_numeric_spaces', '{field} Hanya Boleh Huruf Dan Angka.');
        //is_unique	Yes	Returns FALSE if the form element is not unique to the table and field name in the parameter. Note: This rule requires Query Builder to be enabled in order to work. is_unique[table.field]
        $this->CI->form_validation->set_message('is_unique', '{field} Sudah Digunakan.');
        //matches	Yes	Returns FALSE if the form element does not match the one in the parameter.	matches[form_item]
        $this->CI->form_validation->set_message('matches', '{field} Tidak Sama Dengan {param}.');
    }

    /**
     * @param null|int $code
     * @param null|string $message
     */
    public function show_error_custom($code = null, $message = null,$title = null){
		$this->CI->load->model('master/M_profile', 'M_profile');
		$profile = $this->CI->M_profile->get_by_id(1);
		$logo    = base_url('assets/profile/'.$profile->LOGO_TOKO);
        $data = [
            'code'      => $code ?: '404',
            'message'   => $message ?: 'Page Not Found',
			'title'     => $title,
			'logo'		=> $logo
		];
        $this->CI->load->view('error_custom/error_page',$data);
    }

    //================================================== Get link Path ===============================================//

    /**
     * @param null $file_name
     * @return string
     */
    public function getPath($file_name = null){
    	if($file_name){
			return $this->CI->router->directory.$file_name;
		}else{
			return $this->CI->router->directory;
		}
	}

    /**
     * @param null $file_name
     * @param bool $link
     * @return string
     */
    public function getController($file_name = null, $link = false){
		$path	= $this->CI->router->directory.$this->CI->router->class;
        return $link ? ($file_name ? site_url() . $path . '/' . $file_name : site_url() . $path . '/') : ($file_name ? $path . '/' . $file_name : $path . '/');
	}

    /**
     * @param null $file_name
     * @return string
     */
    public function getFunction($file_name = null){
		$path	= strtolower($this->CI->router->directory.$this->CI->router->class.'/'.$this->CI->router->method);
		return $file_name ? $path.'/'.$file_name : $path.'/';
	}

    //=========================================================CONFIG=================================================//

    /**
     * @param $id
     * @return mixed
     */
    public function getConfig($id){
        $this->CI->load->model('config/M_config');
        return $this->CI->M_config->get_by_id($id)->VALUE;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getConfigByName($name){
        $this->CI->load->model('config/M_config');
        return $this->CI->M_config->find_first([M_config::NAMA => $name])->VALUE;
    }

    //====================================================STOK dan HARGA==============================================//

    /**
	 * @param $kd_prd
	 * @param null $satuan_tujuan
	 * @return int
	 */
	public function get_stok($kd_prd,$satuan_tujuan = null){
		$this->CI->load->model('transaksi/stok/M_v_stok_product');
		$this->CI->load->model('master/M_v_konversi_satuan');
		$stok = $this->CI->M_v_stok_product->get_by_id($kd_prd);
		if(empty($satuan_tujuan)){
			return $stok->STOK + 0;
		}else{
			if(empty($stok->KD_SET_SATUAN))
			{
				return $stok->STOK +0;
			}else{
				return $this->CI->M_v_konversi_satuan->konversi($stok->KD_SET_SATUAN,$stok->KD_SATUAN,$satuan_tujuan,$stok->STOK);
			}
		}
	}

	/**
	 * @param $kd_prd
	 * @param $kd_satuan
	 * @param null $kd_master_harga
	 * @return array|bool|int
	 */
	public function get_hpp_pembelian($kd_prd,$kd_satuan,$kd_master_harga = null){
		$this->CI->load->model('master/harga/M_list_harga');

		$kd_master_harga 	= empty($kd_master_harga) ? "MSTRHRGPRC0001" : $kd_master_harga;

		$list_harga 		= $this->CI->M_list_harga->find_first([
			M_list_harga::KD_PRD 			=> $kd_prd,
			M_list_harga::KD_SATUAN			=> $kd_satuan,
			M_list_harga::KD_MASTER_HARGA	=> $kd_master_harga
		]);
		return $list_harga ? $list_harga->HARGA : 0;
	}

    //======================================================== Telegram ==============================================//

    /**
     * @param string $messages
     * @param string $chanel
     */
    function send_telegram($messages='', $chanel='nuhapos'){
	$keyboard = [
		'inline_keyboard' => [
			[
				['text' => 'tes', 'callback_data' => 'someString'],
				['text' => 'cuk', 'callback_data' => 'someString']
			]
		]
	];
	$encodedKeyboard = json_encode($keyboard);

		if($chanel== self::CHANNEL_NUHAPOS){
			$telegram_chat_id   = '-1001320408015';
			$username			= "@nuhapos";
		}elseif($chanel==self::CHANNEL_DEVS){
//			$telegram_chat_id	= '-1001333526500';
			$telegram_chat_id	= '-396391281';
			$username			= "@devschatbot";
		}

		$telegram_token       = '710184082:AAHnSUgubt6_b_fF0dlxOxRxJMVYU5rwEK4';
		$bot = new BotApi($telegram_token);
		try {
			$bot->sendMessage($telegram_chat_id, $messages,'HTML');
		} catch (Exception $e) {
			show_error('Sending Message Via Telegram Error '.' '.$e->getMessage(),$e->getCode());
		}
	}

	public function send_api($message,$id=NULL){
		//239718013
		//{"ok":true,"result":[{"update_id":455333433,
		//"message":{"message_id":962,"from":{"id":239718013,"is_bot":false,"first_name":"Adhitya","last_name":"Prasetyo","username":"vanpersietyo","language_code":"id"},"chat":{"id":-354438689,"title":"tes","type":"group","all_members_are_administrators":true},"date":1565942306,"group_chat_created":true}}]}


		$telegram_token       	= '710184082:AAHnSUgubt6_b_fF0dlxOxRxJMVYU5rwEK4';
		$chat_id_vanpersietyo 	= 239718013;
		$chat_id_dimas 			= 311951658;
		$chat_id_selomed 		= 776526607;
		$data = [
			'chat_id'   => $chat_id_selomed,
			'text'      => $message
		];
		$response = "https://api.telegram.org/bot{$telegram_token}/sendMessage?".http_build_query($data);
		Request::get($response);

		$data2 = [
			'chat_id'   => $chat_id_dimas,
			'text'      => $message
		];
		$response2 = "https://api.telegram.org/bot{$telegram_token}/sendMessage?".http_build_query($data2);
		return Request::get($response2);
	}

	public function send_manual($message = null){

		$telegram_token       	= '710184082:AAHnSUgubt6_b_fF0dlxOxRxJMVYU5rwEK4';
		$chat_id 				= 239718013;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot{$telegram_token}/sendMessage");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chat_id={$chat_id}&text=".$message);
		curl_setopt($ch, CURLOPT_POST, 1);

		$headers = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
	}

	//===========================================================ACL==================================================//

    /**
     *
     */
    function isLogin(){
        if($this->CI->session->userdata('isLogin') != true){
            $url=$this->CI->uri->uri_string();
            $this->CI->session->set_userdata('url',$url);
            redirect('auth');
        }
    }

    /**
     * @return bool
     */
    public function get_user_login(){
		return $this->CI->session->userdata('yangLogin') ?: false;
	}

    /**
     * @return bool
     */
    public function get_jabatan_login(){
		return $this->CI->session->userdata('jabatan') ?: false;
	}

    /**
     *
     */
    public function roleAndPermissionsACL(){
        if($this->CI->session->userdata('isLogin') != true){
            $url    = $this->CI->uri->uri_string();
            $this->CI->session->set_userdata('url',$url);
            redirect('auth');
        }else{
            $controller	= strtolower($this->CI->router->directory.$this->CI->router->class);
            $level      = $this->CI->session->userdata('jabatan');
            if($level=='SYS' || $level == 'PEMILIK'){

            }else{
                $menu_user  = $this->CI->M_menutree_user->find_view([
                    M_menutree_user::V_LEVEL_NAME               => $level,
                    M_menutree_user::V_CONTROLLERLINK.' like '  => $controller.'%'
                ]);
                if(empty($menu_user->num_rows())){
                    redirect('auth/show_error_custom/400');
                }
            }
        }
    }

}
