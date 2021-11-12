

<?php
// session_start();
$_SESSION["session"] = $session;
$_SESSION["session_year"] = $session_year;
$_SESSION["exported_rows"] = $rows;

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0");
$ui = new UI();

$form = $ui->form()
->multipart()
->action('fee_structure/generate_report/generate')
->open();
$row = $ui->row()->open();

$ui->select()
->width(3)
->name('session_year')
->label('Session Year')
// ->addonLeft($ui->icon("bars"))
->required()
->options(array(
	$ui->option()->value()->text('Select')->disabled()->selected($session_year==""),
	$ui->option()->value('2019-2020')->text('2019-2020')->selected($session_year=="2019-2020"),
	$ui->option()->value('2020-2021')->text('2020-2021')->selected($session_year=="2020-2021"),
	$ui->option()->value('2021-2022')->text('2021-2022')->selected($session_year=="2021-2022")))
    
->required()
->show();

$ui->select()
->width(3)
->name('session')
->label('Session')
// ->addonLeft($ui->icon("bars"))
->width(3)
->required()
->options(array(
	$ui->option()->value()->text('Select')->disabled()->selected($session==""),
	$ui->option()->value('monsoon')->text('Monsoon')->selected($session=="monsoon"),
	$ui->option()->value('winter')->text('Winter')->selected($session=="winter"),
	$ui->option()->value('summer')->text('Summer')->selected($session=="summer")))
->required()
->show();
 



?>
</br>
<p style="text-indent :2em;">
	<?
	$ui->button()
	->id('getStudent_btn')
	->value('Get Student')
	->uiType('primary')
	->submit()
	->name('getStudent')
	->show();
     $row->close();
$form->close();
	?>
</p>
<br/>
<?
	


echo '<div class="row">
	
	
	<div class="col-md-5"></div>
	<form method="post"action="'.site_url('fee_structure/generate_report/excel').'">

	<div class="col-md-1"><button type="submit" class="btn" id="btn_download">Download Excel File</button></div>
	</form>
	<div class="col-md-5"></div>
	
</div> </br>';

// <form method="post"action="'.site_url('fee_structure/pdf').'">
          
// 	<button type="submit" class="print" id="pdf" ><img src="https://img.icons8.com/material-outlined/24/000000/pdf.png"/>  </button>
// </form>
// <button type="submit" class="print" id="print"><img src="https://img.icons8.com/material-outlined/24/000000/print.png"/>  </button>
$numeric = array("Tution Fees"=>"tution_fees", 
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
					"Miscellaneous Fee" => "miscellaneous_fee",
					"Late Fine" => "late_fine",
					"Pending Amount" => "pending_amount",
					"Refundable Amount" => "refundable_amount",
					 
					);

					$details = array(
							
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
							"Total Fee" => "total_fee"
							
							);
							
	$columns = array_merge($details, $numeric);


	$row = $ui->row()->open();

	$col1 = $ui->col()
				 ->width(1)
	             ->open();
	$col1->close();

	$col2 = $ui->col()
				 ->width(12)
	             ->open();

	$box = $ui->box()
			 //->uiType('primary')
			 //->title('EDC Room Allotment Form')
			 //->solid()
			 ->open();

$table = $ui->table()->hover()->bordered()->responsive()
							->sortable()->searchable()->paginated()
						    ->open();
						


echo '<thead>';
	echo '<tr> <th>Action </th>';
	foreach($columns as $key=>$value)
	 {   
		echo '<th>'.$key.'</th>';
	}
	echo '</tr>';
	echo '</thead>';
echo '<tbody>';
	foreach($rows as $key1=>$cur_row)
	{   
		echo '<tr> <form method="post"action="'.site_url('fee_structure/generate_report/edit').'"><td>';
		$form = $ui->form()
		   ->action('fee_structure/generate_report/edit')
		   ->open();
		$ui->button()
		   ->id('save')
		   ->value('Save')
		   ->uiType('primary')
		   ->submit()
		   ->name('save')
		   ->show();
		 echo '</td>';
		
		foreach($details as $key2=>$value)
		{
			
			echo '<td> <input type="hidden" name="index" value="'.$key1.'"/>';
			$ui->input()->value($cur_row[$value])
					->name($value)->required ()->show();
			 
			 echo'</td>';
		}
		foreach($numeric as $key2=>$value)
		{
			echo '<td>';
			$ui->input()->value($cur_row[$value])
					->type('number')->min('0')->max('1000000')->step('0.01')
					->name($value)->required ()->show();
			 
			 echo'</td>';
		}
		$form->close();
			echo '</tr>';
		
	}
	echo '</tbody>';
			$table->close();
			$box->close();
			$col2->close();
			$row->close();
			

	
	?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<style>
	
	   #btn_download
	   {
       font-weight: bold;
	  } 

</style>	
<!-- <script>
	$(document).ready(function(){
		$('#print').click(function(){
			$(this).hide();
			window.print();
			$(this).show();
		});

	});
</script> -->
