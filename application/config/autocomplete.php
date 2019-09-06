<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 *
 *   _________ Codeigniter 3 Autocomplete for PHPStorm ____________
 *
  1) Controllers
  2) Models
  3) Create named properties for your application Models,
  can then access the model methods from the controller.

  WORK IN PROGRESS, this is still rough but does work for CI 3

*/

/**
 *
 *                         * ************** for Controllers *****************
 *============ Codeigniter Core System ================
 * @property CI_Benchmark $benchmark              Benchmarks
 * @property CI_Config $config                    This class contains functions that enable config files
 * @property CI_Controller $controller            This class object is the super class that every library in.
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Hooks $hooks                      Provides a mechanism to extend the base system
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Profiler $profiler                Display benchmark results, queries you have run, etc
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_URI $uri                          Retrieve information from URI strings
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 *
 *
 * @property CI_Model $model                      Codeigniter Model Class
 *
 * @property CI_Driver $driver                    Codeigniter Drivers
 *
 *
 *============ Codeigniter Libraries ================
 *
 * @property CI_Cache $cache                      Caching
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encryption $encryption            The Encryption Library provides two-way data encryption.
 * @property CI_Upload $upload                    File Uploading class
 * @property CI_Form_validation $form_validation  Form Validation class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Migration $migration              Tracks & saves updates to database structure
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Template parser
 * @property CI_Security $security                Processing input data for security.
 * @property CI_Session $session                  Session Class
 * @property CI_Table $table                      HTML table generation
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_User_agent $agent            Identifies the platform, browser, robot, or mobile
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 *
 *
 *                          *============ Database Libraries ================
 *
 *
 * @property CI_DB_query_builder $db   Database
 * @property CI_DB_forge $dbforge     Database
 * @property CI_DB_result $result                 Database
 *
 *
 *
 *
 *                            *============ Codeigniter Depracated  Libraries ================
 *
 * @property CI_Javascript $javascript            Javascript (not supported
 * @property CI_Jquery $jquery                    Jquery (not supported)
 * @property CI_Encrypt $encrypt                  Its included but move over to new Encryption Library
 *
 *
 *                            *============ Codeigniter Project Models ================
 *  Models that are in your project. if the model is in a folder, still just use the model name.
 *
 *  load the model with Capital letter $this->load->model('People') ;
 *  $this->People-> will show all the methods in the People model
 *
 * Custom Models
 *
 * //Master
 * @property M_user         	$M_user
 * @property M_customer			$M_customer

 * Custom  Libraries
 * @property Conversion         $conversion
 *
 */
class CI_Controller
{
    public function __construct()
    {

    }
};

/**
 *
 * ************** For Models  *****************
 *
 *
 *============ Codeigniter Core System ================
 * @property CI_Benchmark $benchmark              Benchmarks
 * @property CI_Config $config                    This class contains functions that enable config files
 * @property CI_Controller $controller            This class object is the super class that every library in.
 * @property CI_Exceptions $exceptions            Exceptions Class
 * @property CI_Hooks $hooks                      Provides a mechanism to extend the base system
 * @property CI_Input $input                      Pre-processes global input data for security
 * @property CI_Lang $lang                        Language Class
 * @property CI_Loader $load                      Loads views and files
 * @property CI_Log $log                          Logging Class
 * @property CI_Output $output                    Responsible for sending final output to browser
 * @property CI_Profiler $profiler                Display benchmark results, queries you have run, etc
 * @property CI_Router $router                    Parses URIs and determines routing
 * @property CI_URI $uri                          Retrieve information from URI strings
 * @property CI_Utf8 $utf8                        Provides support for UTF-8 environments
 *
 *
 * @property CI_Model $model                      Codeigniter Model Class
 *
 * @property CI_Driver $driver                    Codeigniter Drivers
 *
 *
 *============ Codeigniter Libraries ================
 *
 * @property CI_Cache $cache                      Caching
 * @property CI_Calendar $calendar                This class enables the creation of calendars
 * @property CI_Email $email                      Permits email to be sent using Mail, Sendmail, or SMTP.
 * @property CI_Encryption $encryption            The Encryption Library provides two-way data encryption.
 * @property CI_Upload $upload                    File Uploading class
 * @property CI_Form_validation $form_validation  Form Validation class
 * @property CI_Ftp $ftp                          FTP Class
 * @property CI_Image_lib $image_lib              Image Manipulation class
 * @property CI_Migration $migration              Tracks & saves updates to database structure
 * @property CI_Pagination $pagination            Pagination Class
 * @property CI_Parser $parser                    Template parser
 * @property CI_Security $security                Processing input data for security.
 * @property CI_Session $session                  Session Class
 * @property CI_Table $table                      HTML table generation
 * @property CI_Trackback $trackback              Trackback Sending/Receiving Class
 * @property CI_Typography $typography            Typography Class
 * @property CI_Unit_test $unit_test              Simple testing class
 * @property CI_User_agent $agent                 Identifies the platform, browser, robot, or mobile
 * @property CI_Xmlrpc $xmlrpc                    XML-RPC request handler class
 * @property CI_Xmlrpcs $xmlrpcs                  XML-RPC server class
 * @property CI_Zip $zip                          Zip Compression Class
 *
 *
 *                          *============ Database Libraries ================
 *
 *
 * @property CI_DB_query_builder $db   Database
 * @property CI_DB_forge $dbforge     Database
 * @property CI_DB_result $result                 Database
 *
 *                            *============ Codeigniter Project Models ================
 *  Models that are in your project. if the model is in a folder, still just use the model name.
 *
 *  load the model with Capital letter $this->load->model('People') ;
 *  $this->People-> will show all the methods in the People model
 *
 * Custom Models
 *
 * //Master
 * @property M_login            				$M_login
 * @property M_user             				$M_user
 * @property M_customer         				$M_customer
 * @property M_supplier         				$M_supplier
 * @property M_satuan_produk   					$M_satuan_produk
 * @property M_produk   						$M_produk
 * @property M_kategori_produk   				$M_kategori_produk
 * @property M_set_satuan_product   			$M_set_satuan_product
 * @property M_set_dtl_satuan_product   		$M_set_dtl_satuan_product
 * @property M_master_harga         			$M_master_harga
 * @property M_list_harga           			$M_list_harga
 * @property M_v_konversi_satuan    			$M_v_konversi_satuan
 * @property M_ukuran_produk        			$M_ukuran_produk
 * @property M_config 							$M_config
 * @property M_menutree 						$M_menutree
 * @property M_menutree_user 					$M_menutree_user
 * @property M_level 							$M_level
 * @property M_bank		                        $M_bank
 *
 * Transaksi
 *
 * //PEMBELIAN
 * @property M_trans_pembelian_a    			$M_trans_pembelian_a
 * @property M_trans_pembelian_b    			$M_trans_pembelian_b
 * @property M_v_detail_transaksi_pembelian    	$M_v_detail_transaksi_pembelian
 * @property M_trans_pembayaran_pembelian		$M_trans_pembayaran_pembelian
 * @property M_v_header_transaksi_pembelian		$M_v_header_transaksi_pembelian
 * @property M_v_histori_harga_pembelian		$M_v_histori_harga_pembelian
 *
 * //PEENAMBAHAN
 * @property M_trans_penambahan_a 				$M_trans_penambahan_a
 * @property M_trans_penambahan_b 				$M_trans_penambahan_b
 *
 * //PENJUALAN
 * @property M_trans_penjualan_a				$M_trans_penjualan_a
 * @property M_trans_penjualan_b				$M_trans_penjualan_b
 * @property M_trans_pembayaran_penjualan		$M_trans_pembayaran_penjualan
 * @property M_v_header_trans_penjualan		    $M_v_header_trans_penjualan
 * @property M_v_trans_pembayaran_penjualan		$M_v_trans_pembayaran_penjualan
 * @property M_v_detail_trans_penjualan         $M_v_detail_trans_penjualan
 *
 * // Opname
 * @property M_trans_opname_a         			$M_trans_opname_a
 * @property M_trans_opname_b         			$M_trans_opname_b
 * @property M_v_trans_opname_b_detail          $M_v_trans_opname_b_detail
 *
 * //STOK
 * @property M_v_stok_product         			$M_v_stok_product
 * @property M_v_list_stok_harga_konversi_produk $M_v_list_stok_harga_konversi_produk
 *
 * //Retur
 * @property M_trans_retur_a_hdr         		$M_trans_retur_a_hdr
 * @property M_trans_retur_b_dtl         		$M_trans_retur_b_dtl
 * @property M_trans_retur_c_pembayaran         $M_trans_retur_c_pembayaran
 *
 * //Retur Penjualan
 * @property M_v_trans_retur_penjualan_header 	$M_v_trans_retur_penjualan_header
 * @property M_v_trans_retur_penjualan_detail 	$M_v_trans_retur_penjualan_detail
 *
 * Custom  Libraries
 * @property Unirest        	$unirest
 * @property Conversion         $conversion
 * @property PDF_AutoPrint      $PDF_AutoPrint
 */
class CI_Model
{
    public function __construct()
    {
    }
};

/* End of file autocomplete.php */
/* Location: ./application/config/autocomplete.php */
