<?php
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
	header("Pragma: no-cache"); // HTTP 1.0.
	header("Expires: 0");
	$ui = new UI();

	$row = $ui->row()->open();

	$col1 = $ui->col()
				 ->width(1)
	             ->open();
	$col1->close();

	$col2 = $ui->col()
				 ->width(10)
	             ->open();

	$box = $ui->box()
			 //->uiType('primary')
			 //->title('EDC Room Allotment Form')
			 //->solid()
			 ->open();

		$form = $ui->form()
		   //->multipart()
		   ->action('fee_structure/add_fee_structure/update')
		   ->open();

		$row1 = $ui->row()->open();

		$ui->select()
		->width(3)
		->name('session_year')
		->label('Session Year')
		// ->addonLeft($ui->icon("bars"))
		->required()
		->options(array(
			$ui->option()->value($edit_row['session_year'])->text($edit_row['session_year'])->selected()))

		->required()
		->show();

		$ui->select()
		->width(3)
		->name('session')
		->label('Session')
		->id('session')
		// ->addonLeft($ui->icon("bars"))
		->width(3)
		->required()
		->options(array(
			$ui->option()->value($edit_row['session'])->text($edit_row['session'])->selected()))
		->required()
		->show();

		$ui->select()
		->width(3)
		->name('course')
		->label('Course')
		// ->addonLeft($ui->icon("bars"))
		->width(3)
		->required()
		->options(array(
			$ui->option()->value($edit_row['course'])->text($edit_row['course'])->selected()))
		->required()
		->show();

		$sem_value = $edit_row['semester'];
		$sem_text = $sem_value;
		if($sem_text=='0') $sem_text = 'NA'; 
		
		$ui->select()
		->width(3)
		->name('semester')
		->id('semester')
		->label('Semester')
		// ->addonLeft($ui->icon("bars"))
		->width(3)
		->required()
		->options(array(
			$ui->option()->value($sem_value)->text($sem_text)->selected()))
		->required()
		->show();

		$row1->close();

		$columns = array("Tution Fees"=>"tution_fees", 
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
					"Miscellaneous Fee"=>"miscellaneous_fee");

		//$categories = array("General/Open", "OBC/OBC(NCL)", "EWS", "PWD", "SC", "ST");

		$table = $ui->table()->bordered()->responsive()->id("table1")->open();
		
		echo '<tr>';
		echo '<th>Category</th>';
		foreach($columns as $key=>$value)
		{
			echo '<th>'.$key.'</th>';
		}
		echo '</tr>';
		
		//$category_options = array($ui->option()->value()->text('Select')->disabled()->selected());
		//foreach($categories as $category){
		//	array_push($category_options, 
		//	$ui->option()->value($category)->text($category));
		//}
		echo '<tr>';
		echo '<th>';
		$ui->select()
		->width(3)
		->name('category')
		// ->addonLeft($ui->icon("bars"))
		->width(100)
		->required()
		->options(array($ui->option()->value($edit_row['category'])->text($edit_row['category'])->selected()))
		->required()
		->show();
		echo '</th>';
		foreach($columns as $key => $value)
		{
			echo '<td>';
					$ui->input()->width(100)->placeholder($key)->value($edit_row[$value])
					->type('number')->min('0')->max('1000000')->step('0.01')
					->name($value)->required ()->show();
			echo '</td>';
		}
		echo '</tr>';
		$table->close();
?>


<center>
<?
		$ui->button()
		   ->id('booking_form')
		   ->value('Submit')
		   ->uiType('primary')
		   ->submit()
		   ->name('submit')
		   ->show();
?>
</center>
<?
		$form->close();

	$box->close();

	$col2->close();

	$row->close();
?>

<style>
	#table1{
		width: 300%;
		max-width: 300%;
	}
</style>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	$(document).ready(function(){
		$('#session').change(function(){
			var selected_option = $('#session option:selected').val();
			//console.log("hello");
	    	if(selected_option == "monsoon"){
	    		$('#semester option:odd').hide();
	        	$('#semester option:even').show();
	        	$("#semester").val('1').change();
	        }
	        else{
	        	$('#semester option:odd').show();
	        	$('#semester option:even').hide();
	        	$("#semester").val('2').change();
	        }
		});
	});
</script>
