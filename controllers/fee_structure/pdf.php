<?php
session_start();

require_once("C:/xampp/htdocs/mis/application/libraries/tcpdf/tcpdf.php");
class MYPDF extends TCPDF {


	// Colored table
	public function ColoredTable($header,$data) {
		// Colors, line width and bold font
		$this->SetFillColor(224, 235, 255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// $this->SetDrawColor(128, 0, 0);
		$this->SetLineWidth(0.5);
		$this->SetFont('', 'B');
		// Header
		
		$num_headers = count($header);
		foreach($header as $key=>$value) {
			$this->Cell(58, 2, $key, 1, 0, 'C', 1);
		}
		$this->Ln();
		$fill = 0; $i=0;
		foreach($data as $row) {
            foreach($header as $key=>$value)
			{
			$this->Cell(58, 3, $row[$value], 'LR', 0, 'L', $fill);
			}
			
			$this->Ln();
			$fill=!$fill;
		}
		$this->Cell(58*$num_headers, 0, '', 'T');
	}
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, 'A0', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Admin');
$pdf->SetTitle('Student Details');
// $pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 011', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, PDF_MARGIN_TOP, 10);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array(
			"Admission No."=>"adm_no",
							"Name"=>"name",
							"Email"=>"email",
						 	"Session Year"=>"session_year",
							"Session"=>"session",
							"Course"=>"course",
							"Branch"=>"branch",
							"Semester"=>"semester",
							"Category"=>"category",
							"PWD Status"=>"pwd_status",
			"Tution Fees"=>"tution_fees", 
					"Annual Charges"=>"annual_charge",
					"Medical Fund"=>"medical_fund",
					"Sports Subscription Fee"=>"sports_subscription_fee",
					"Hostel Rent"=>"house_rent",
					"Semester Registration Fee"=>"semester_registration_fee",
					"Examination Fee"=>"examination_fee",
					"Computer and Internet Charges"=>"computer_and_internet_charges",
					"Electricity Charges"=>"electricity_charges",
					"Library Fee"=>"library_fee",
					"Training and Placement Support Fee"=>"training_and_placement_support_fee",
						   );
// data loading
$data = $_SESSION["exported_rows"];

// print colored table
$pdf->ColoredTable($header, $data);

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('example_011.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>