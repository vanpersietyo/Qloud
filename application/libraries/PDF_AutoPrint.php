<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: PC-06
 * Date: 07/02/2019
 * Time: 15:37
 * @property CI_Controller CI
 */

class PDF_AutoPrint extends PDF_JavaScript
{
	function __construct()
	{
		parent::__construct();
		$this->CI =& get_instance();
		date_default_timezone_set("Asia/Bangkok");
	}

	function AutoPrint($printer='')
    {
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
    }
}
?>
