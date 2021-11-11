<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Add_fee_structure extends MY_Controller
{
	public $column;
	function __construct()
	{
		parent::__construct(array('emp','stu'));
		$this->columns = array(
				"session_year","session","course","semester","category",
				"tution_fees","annual_charge","medical_fund",
				"sports_subscription_fee","house_rent",
				"semester_registration_fee","examination_fee",
				"computer_and_internet_charges","electricity_charges",
				"library_fee","training_and_placement_support_fee");
		$this->load->model('fee_structure/fee_structure_model','fee_model');
	}

	function index()
	{
		$this->drawHeader('Add Fee Structure');
		
		$this->load->view('fee_structure/add_fee_structure');
		$data["rows"] = $this->fee_model->getAllRows();
		$this->load->view('fee_structure/fee_table',$data);
		$this->drawFooter();
	}

	function insert()
	{
		$row = array();

		foreach($this->columns as $column)
		{
			$row[$column] = $this->input->post($column);
		}

		//insert the row through model;
		$success = $this->fee_model->insert($row);

		if($success){
			echo '<script>alert("You Have Successfully inserted this Record!");location="'
			.site_url("fee_structure/add_fee_structure")
			.'";</script>';
		}
		else{
			echo '<script>alert("This Record exists already!");location="'
			.site_url("fee_structure/add_fee_structure")
			.'";</script>';
		}
	}

	function edit()
	{
		$edit_row['session_year'] = $this->input->post('session_year');
		$edit_row['session'] = $this->input->post('session');
		$edit_row['course'] = $this->input->post('course');
		$edit_row['semester'] = $this->input->post('semester');
		$edit_row['category'] = $this->input->post('category');
		$data['edit_row'] = $this->fee_model->getRow($edit_row);

		$this->drawHeader('Edit Fee Structure');
		$this->load->view('fee_structure/edit_fee_structure', $data);
		$data = array();
		$data['rows'] = $this->fee_model->getAllRows();;
		$this->load->view('fee_structure/fee_table', $data);
		$this->drawFooter();
		
	}

	function update()
	{
		$row = array();

		foreach($this->columns as $column)
		{
			$row[$column] = $this->input->post($column);
		}

		//update the row through model;
		$row['is_deleted'] = 'NO';
		$success = $this->fee_model->update($row);

		if($success){
			echo '<script>alert("You Have Successfully updated this Record!");location="'
			.site_url("fee_structure/add_fee_structure")
			.'";</script>';
		}
		else{
			echo '<script>alert("Error occurred while updating, please enter valid details!");location="'
			.site_url("fee_structure/add_fee_structure")
			.'";</script>';
		}
	}

	function delete()
	{
		$delete_row = array();
		$delete_row['session_year'] = $this->input->post('session_year');
		$delete_row['session'] = $this->input->post('session');
		$delete_row['course'] = $this->input->post('course');
		$delete_row['semester'] = $this->input->post('semester');
		$delete_row['category'] = $this->input->post('category');
		//echo $delete_row;
		
		$success = $this->fee_model->delete($delete_row);

		if($success){
			echo '<script>alert("You Have Successfully deleted this Record!");location="'
			.site_url("fee_structure/add_fee_structure")
			.'";</script>';
		}
		else{
			echo '<script>alert("Error occurred while deleting, please enter valid details!");location="'
			.site_url("fee_structure/add_fee_structure")
			.'";</script>';
		}
	}
}