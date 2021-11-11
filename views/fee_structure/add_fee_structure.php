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
			 ->open();

		$form = $ui->form()
		   ->action('fee_structure/add_fee_structure/insert')
		   ->open();

		$row1 = $ui->row()->open();

		$ui->select()
		->width(3)
		->name('session_year')
		->label('Session Year')
		->required()
		->options(array(
			$ui->option()->value("")->text('Select')->disabled()->selected(),
			$ui->option()->value('2021-2022')->text('2021-2022'),
			$ui->option()->value('2020-2021')->text('2020-2021'),
			$ui->option()->value('2019-2020')->text('2019-2020'),
			$ui->option()->value('2018-2019')->text('2018-2019'),
			$ui->option()->value('2017-2018')->text('2017-2018'),
			$ui->option()->value('2016-2017')->text('2016-2017')))
		->required()
		->show();

		$ui->select()
		->width(3)
		->name('session')
		->label('Session')
		->id('session')
		->width(3)
		->required()
		->options(array(
			$ui->option()->value("")->text('Select')->disabled()->selected(),
			$ui->option()->value('monsoon')->text('Monsoon'),
			$ui->option()->value('winter')->text('Winter'),
			$ui->option()->value('summer')->text('Summer')))
		->required()
		->show();

		$courses = 	array("b.tech" =>"Bachelor of Technology",
					"be" =>	"Bachelor of Engineering",
					"comm" =>	"1st Year JEE Advanced",
					"dualdegree" =>	"Dual Degree",
					"execmba" =>	"Executive Master of Business Administration",
					"exemtech"=>	"Master of Technology (3 Years)",
					"honour"=> 	"Bachelor of Technology (Honours)",
					"int.m.sc"=> 	"Integrated Master of Science",
					"int.m.tech"=> 	"Integrated Master of Technology",
					"int.msc.tech"=> 	"Integrated Master of Science and Technology",
					"m.phil"=> 	"Master of Philosophy",
					"m.sc"=> 	"Master of Science",
					"m.sc.tech"=> 	"Master of Science and Technology",
					"m.tech"=> 	"Master of Technology",
					"mba" =>	"Master of Business Administration",
					"phd"=>	"Doctor of Philosophy");
		$course_options = array($ui->option()->value()->text('Select')->disabled()->selected());
		foreach($courses as $key => $value){
			array_push($course_options, 
			$ui->option()->value($key)->text($value));
		}
		$ui->select()
		->width(3)
		->name('course')
		->label('Course')
		->width(3)
		->required()
		->options($course_options)
		->required()
		->show();

		$ui->select()
		->width(3)
		->name('semester')
		->id('semester')
		->label('Semester')
		->width(3)
		->required()
		->options(array(
			$ui->option()->value('1')->text('1'),
			$ui->option()->value('2')->text('2'),
			$ui->option()->value('3')->text('3'),
			$ui->option()->value('4')->text('4'),
			$ui->option()->value('5')->text('5'),
			$ui->option()->value('6')->text('6'),
			$ui->option()->value('7')->text('7'),
			$ui->option()->value('8')->text('8'),
			$ui->option()->value('0')->text('NA')))
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
					"Training and Placement Support Fee"=>"training_and_placement_support_fee");

		$categories = array("General/Open", "OBC/OBC(NCL)", "EWS", "PWD", "SC", "ST");

		$table = $ui->table()->bordered()->responsive()->id("table1")->open();
		echo '<thead>';
		echo '<tr>';
		echo '<th>Category</th>';
		foreach($columns as $key=>$value)
		{
			echo '<th>'.$key.'</th>';
		}
		echo '</tr>';
		echo '</thead>';
		
		$category_options = array($ui->option()->value()->text('Select')->disabled()->selected());
		foreach($categories as $category){
			array_push($category_options, 
			$ui->option()->value($category)->text($category));
		}
		
		echo '<tbody>';
		echo '<tr>';
		echo '<th>';
		$ui->select()
		->width(3)
		->name('category')
		->width(100)
		->required()
		->options($category_options)
		->required()
		->show();
		echo '</th>';
		foreach($columns as $key => $value)
		{
			echo '<td>';
					$ui->input()->width(100)->placeholder($key)->type('number')
					->min('0')->max('1000000')->step('0.01')
					->name($value)->required ()->show();
			echo '</td>';
		}
		echo '</tr>';
		echo '</tbody>';
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
	        	$('#semester option[value="0"]').hide();
	        	$("#semester").val('1').change();
	        }
	        else if(selected_option == "winter"){
	        	$('#semester option:odd').show();
	        	$('#semester option:even').hide();
	        	$('#semester option[value="0"]').hide();
	        	$("#semester").val('2').change();
	        }
	        else{
	        	$('#semester option').hide();
	        	$('#semester option[value="0"]').show();
	        	$("#semester").val('0').change();
	        }
		});
	});
</script>
