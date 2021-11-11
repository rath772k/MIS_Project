<?php 
//session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require 'db_connection.php';

class Generate_report extends MY_Controller
{
	
	function __construct()
	{  
		parent::__construct(array('emp','stu'));
		$this->columns = array(
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
		$this->load->model("fee_structure/report_model","report_model");
	   	
	}

	function index()
	{
		$this->drawHeader('Generate Report');
         	/*$query ="
		SELECT a.*,b.* FROM stu_details_project AS a 
		JOIN
		stu_fee_structure AS b
		ON a.session_year = b.session_year AND a.session = b.session AND a.category = b.category 
		AND b.is_deleted='NO';";
		$rows=array();
		if ($is_query_run = mysql_query($query))
		{
         while ($query_executed = mysql_fetch_assoc ($is_query_run))
  		  	{ 
             $rows[]=$query_executed;
    		}

		}  
		
	    $data['rows']=$rows;
	    */
	    $data['rows']=$this->report_model->getAllRows();
		$this->load->view('fee_structure/generate_report',$data);
		$this->drawFooter();
	}

	function generate()
	{
		$this->drawHeader('Generate Report');

          
		$session_year =  $this->input->post('session_year');
		$session =  $this->input->post('session');
		
         /*		$query ="
		SELECT a.*,b.* FROM stu_details_project AS a 
		JOIN
		stu_fee_structure AS b
		ON a.session_year = b.session_year AND a.session = b.session AND a.category = b.category 
		AND a.session_year='".$session_year."' AND a.session='".$session."' AND b.is_deleted='NO';";
		$rows=array();
		if ($is_query_run = mysql_query($query))
		{
         while ($query_executed = mysql_fetch_assoc ($is_query_run))
  		  	{ 
             $rows[]=$query_executed;
    		}

		}   
		$data['rows']=$rows;
		*/
		$data['rows']=$this->report_model->getRequiredRows($session_year, $session);
		$this->load->view('fee_structure/generate_report',$data);
		$this->drawFooter();
	}
	
	function excel()
	{ 
		$rows=array();
		$rows=$_SESSION["exported_rows"];
		
     if($rows)
	 {

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment;
		filename=stu_details.csv');

     $header=array();
	foreach($this->columns as $key=>$value)
		$header[]=$key;
		
	$output = fopen("php://output", "w");
     fputcsv($output, $header);

	foreach($rows as $row) {
         $curr_row=array();
		foreach($this->columns as $key=>$value)
		{
			$curr_row[$value]=$row[$value];
		}
		
		fputcsv($output, $curr_row);
	}


	fclose($output);
	 }
		
	}
	

	
}