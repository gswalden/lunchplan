<body>
	Hello <?php echo $user->first_name; ?><br />
	List of Friends: <br />
	<?php
		if ($friends === false)
			echo "None <br />";
		else 
			foreach ($friends as $friend)
				echo $friend->first_name . ' <a href="/lunchplan/index.php/user/delete_friend/' . $friend->user_id . '">delete</a><br />';
	?>
	List of Non-Friends: <br />
	<?php
		if ($nonfriends === false)
			echo "None <br />";
		else
			foreach ($nonfriends as $nonfriend)
				echo $nonfriend->first_name . ' <a href="/lunchplan/index.php/user/add_friend/' . $nonfriend->user_id . '">add</a><br />';
	?>
	<br />
	<br />
	<?php  
		echo form_open("/user/create");
		echo form_input($input_first) . form_input($input_last) . form_input($input_email);
		echo form_submit($name_submit, "Submit");
		echo form_close();
	?>
	<br />
	List of Groups: <br />
	<?php
		if ($groups === false)
			echo "None <br />";
		else 
			foreach ($groups as $group)
				echo $group->name . ' <a href="/lunchplan/index.php/group/leave/' . $group->group_id . '">leave</a><br />';
	?>
	List of Available Groups: <br />
	<?php
		if ($nongroups === false)
			echo "None <br />";
		else 
			foreach ($nongroups as $nongroup)
				echo $nongroup->name . ' <a href="/lunchplan/index.php/group/join/' . $nongroup->group_id . '">join</a><br />';
	?>
	<br />
	<br />
	<?php  
		echo form_open("/group/create");
		echo form_input($input_group_name);
		echo form_submit($group_submit, "Submit");
		echo form_close();
	?>
	<script src="js/scripts.js"></script>
</body>
</html>