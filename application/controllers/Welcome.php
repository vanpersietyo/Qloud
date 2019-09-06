<?php defined('BASEPATH') OR exit('No direct script access allowed');

use Unirest\Request;

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index(){
		echo '
				<ol>
			<li><a href="'.site_url('api/user/users').'">Users</a> - defaulting to JSON</li>
			<li><a href="'.site_url('api/user/users/format/csv').'">Users</a> - get it in CSV</li>
			<li><a href="'.site_url('api/user/users/id/1').'">User #1</a> - defaulting to JSON  (users/id/1)</li>
			<li><a href="'.site_url('api/user/users/1').'">User #1</a> - defaulting to JSON  (users/1)</li>
			<li><a href="'.site_url('api/user/users/id/1.xml').'">User #1</a> - get it in XML (users/id/1.xml)</li>
			<li><a href="'.site_url('api/user/users/id/1/format/xml').'">User #1</a> - get it in XML (users/id/1/format/xml)</li>
			<li><a href="'.site_url('api/user/users/id/1?format=xml').'">User #1</a> - get it in XML (users/id/1?format=xml)</li>
			<li><a href="'.site_url('api/user/users/1.xml').'">User #1</a> - get it in XML (users/1.xml)</li>
			<li><a id="ajax" href="'.site_url('api/user/users/format/json').'">Users</a> - get it in JSON (AJAX request)</li>
			<li><a href="'.site_url('api/user/users.html').'">Users</a> - get it in HTML (users.html)</li>
			<li><a href="'.site_url('api/user/users/format/html').'">Users</a> - get it in HTML (users/format/html)</li>
			<li><a href="'.site_url('api/user/users?format=html').'">Users</a> - get it in HTML (users?format=html)</li>
		</ol>
		';
	}

	public function tes_unirest(){
		$headers	= array('Accept' => 'application/json');
		$query 		= array('name' => 'Adhitya', 'email' => 'barcelonitas.adhyt@gmail.com');
		$url		= site_url('api/user/users');

		$response 	= Request::post($url, $headers, $query);
		echo "<pre>";
		print_r ($response->body);
		echo "</pre>";
	}

	public function tes_pdf(){
		$this->load->library('PDF_JavaScript');
		$this->load->library('PDF_AutoPrint');

		$pdf = new PDF_AutoPrint();

		$pdf->SetMargins(1,2,1);
		$pdf->SetAutoPageBreak(false,0);
		$pdf->AddPage('P','A4');
		$pdf->SetFont('Arial','B',8);
		$pdf->SetFont('Arial','',5);
		$pdf->Cell(0,3,"No : 1",0,0,'L');
		$pdf->Cell(0,3,"Customer : 1",0,1,'R');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(0,1,"-----------------------------------------------------------",0,1,'C');
		$pdf->SetFont('Arial','I',5);
		$pdf->Cell(10,2,'QTY',0,0);
		$pdf->Cell(18,2,'PRODUK',0,0);
		$pdf->Cell(9,2,'HRG',0,0,'C');
		$pdf->Cell(8,2,'DISC',0,0,'C');
		$pdf->Cell(9,2,'TOTAL',0,1,'R');
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(0,1,"-----------------------------------------------------------",0,1,'C');

		$pdf->AutoPrint();
		$pdf->Output();
	}

}
