<?php 
 session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require 'db_connection.php';

class Generate_report extends MY_Controller
{
	
	function __construct()
	{  
		parent::__construct(array('emp','stu'));
		$this->columns = array("adm_no","name","email",
				"session_year","session","course","branch","semester","category","pwd_status",
				"date_of_registration","total_fee"
			      );
		$this->numeric = array(
				"tution_fees","annual_charge","medical_fund",
				"sports_subscription_fee","house_rent",
				"semester_registration_fee","examination_fee",
				"computer_and_internet_charges","electricity_charges",
				"library_fee","training_and_placement_support_fee","miscellaneous_fee","late_fine","pending_amount","refundable_amount");
		
		$this->load->model("fee_structure/report_model","report_model");
	
	   	
	}

	function index()
	{
		$this->drawHeader('Generate Report');
	    	$data['rows']=array();//$this->report_model->getAllRows();
		$this->load->view('fee_structure/generate_report',$data);
		$this->drawFooter();
	}

	function generate()
	{
		$this->drawHeader('Generate Report');

          
		$session_year =  $this->input->post('session_year');
		$session =  $this->input->post('session');
		
		$data['session']=$session;
		$data['session_year']=$session_year;
		$data['rows']=$this->report_model->getRequiredRows($session_year, $session);
		$this->load->view('fee_structure/generate_report',$data);
		$this->drawFooter();
	}
	
	function excel()
	{ 
		$rows=array();
		$session_year =  $_SESSION["session"];
		$session =  $_SESSION["session_year"];
		$rows=$_SESSION["exported_rows"];
		
       

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment;
		filename=stu_details_'.$session_year.'_'.$session.'.csv');

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
		foreach($this->numeric as $key=>$value)
		{
			$curr_row[$value]=$row[$value];
			
		}
		
		 fputcsv($output, $curr_row);
	}


	 fclose($output);
	 
	
	}
	
	function edit()
	{ $this->drawHeader('Generate Report');
		$rows=$_SESSION["exported_rows"];
		$data['session']=$_SESSION["session"];
		$data['session_year']=$_SESSION["session_year"];
		$key1=(int)$this->input->post("index");
		
		$sum=0;
	foreach($this->columns as $key2=>$value)
	  {	
		$rows[$key1][$value]=$this->input->post($value);
		 
	  }
	  foreach($this->numeric as $key2=>$value)
	  {	
		$rows[$key1][$value]=$this->input->post($value);
		 $sum+=$rows[$key1][$value] ;
	  }
    
	    $rows[$key1]["total_fee"]=$sum-2*$rows[$key1]["refundable_amount"];
        
         $this->report_model->saveAllRows($rows);
         $data['rows']=$rows;
		$this->load->view('fee_structure/generate_report',$data);
		$this->drawFooter();

	}

	
}
