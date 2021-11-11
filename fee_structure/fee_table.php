<?php
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
	$table = $ui->table()->hover()->bordered()->responsive()
							->sortable()->searchable()->paginated()
							->id("table2")->open();
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
	
	$extra_columns = array("Session Year"=>"session_year",
							"Session"=>"session",
							"Course"=>"course",
							"Semester"=>"semester",
							"Category"=>"category");
	$columns = array_merge($extra_columns, $columns);
	
	echo '<thead>';
	echo '<tr>';
	foreach($columns as $key=>$value)
	{
		echo '<th>'.$key.'</th>';
	}
	echo '<th>Action</th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';
	foreach($rows as $cur_row)
	{
		echo '<tr>';
		
		foreach($columns as $key=>$value)
		{
			if($value == 'semester' && $cur_row[$value] == '0') $cur_row[$value]='NA';
			echo '<td>'.$cur_row[$value].'</td>';
		}
		echo '<td>';
		echo '<div class="actionBtns">';
		echo '<form
				method="post"
				action="'.site_url("fee_structure/add_fee_structure/edit").'">';
		foreach($extra_columns as $key=>$value)
		{
			echo '<input type="hidden" name="'.$value.'"
				value="'.$cur_row[$value].'"/>';
		}
		$edit = $ui->button()
		   //->id('booking_form')
		   ->value('Edit')
		   ->uiType('primary')
		   ->mini()
		   ->submit()
		   ->name('edit')
		   ->show();
		echo '</form>';
		
		echo '<form
				onsubmit="return confirm(\'Do you really want to delete this entry?\');"
				method="post"
				action="'.site_url('fee_structure/add_fee_structure/delete').'">';

		foreach($extra_columns as $key=>$value)
		{
			echo '<input type="hidden" name="'.$value.'"
				value="'.$cur_row[$value].'"/>';
		}
		$delete = $ui->button()
		   //->id('booking_form')
		   ->value('Delete')
		   ->uiType('primary')
		   ->mini()
		   ->submit()
		   ->name('delete')
		   ->show();
		echo '</form>';
		echo '</div>';
		echo '</td>';
		echo '</tr>';
	}
	echo '</tbody>';

	$table->close();
	$box->close();
	$col2->close();
	$row->close();
?>

<style>

	.actionBtns
	{
		display: flex;
		gap:4px;
	}
</style>