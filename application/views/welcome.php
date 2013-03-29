<body>
	Hello <?php echo $user->first_name; ?><br />
	List of Friends: <br />
	<?php
		if ($friends === FALSE)
			echo "None <br />";
		else 
			foreach ($friends as $friend)
				echo $friend->first_name . ' <a href="/lunchplan/index.php/user/delete_friend/' . $friend->user_id . '">delete</a><br />';
	?>
	List of Non-Friends: <br />
	<?php
		if ($non_friends === FALSE)
			echo "None <br />";
		else
			foreach ($non_friends as $non_friend)
				echo $non_friend->first_name . ' <a href="/lunchplan/index.php/user/add_friend/' . $non_friend->user_id . '">add</a><br />';
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
		if ($groups === FALSE)
			echo "None <br />";
		else 
			foreach ($groups as $group)
				echo $group->name . ' <a href="/lunchplan/index.php/group/leave/' . $group->group_id . '">leave</a><br />';
	?>
	List of Available Groups: <br />
	<?php
		if ($non_groups === FALSE)
			echo "None <br />";
		else 
			foreach ($non_groups as $non_group)
				echo $non_group->name . ' <a href="/lunchplan/index.php/group/join/' . $non_group->group_id . '">join</a><br />';
	?>
	<br />
	<br />
	<?php  
		echo form_open("/group/create");
		echo form_input($input_group_name);
		echo form_submit($group_submit, "Submit");
		echo form_close();
	?>
	<br />
	<br />
	List of Events: <br />
	<?php
		if ($events === FALSE)
			echo "None <br />";
		else 
			foreach ($events as $event)
				echo $event->name . ' <a href="/lunchplan/index.php/event/leave/' . $event->event_id . '">leave</a><br />';
	?>
	List of Available Events: <br />
	<?php
		if ($non_events === FALSE)
			echo "None <br />";
		else 
			foreach ($non_events as $non_event)
				echo $non_event->name . ' <a href="/lunchplan/index.php/event/join/' . $non_event->event_id . '">join</a><br />';
	?>
	<br />
	<br />
	<?php  
		echo form_open("/event/create");
		echo form_input($input_event_name);
		echo form_input($input_event_loc);
		echo form_dropdown("start", $date_options, "today");
		echo form_dropdown("length", $length_options, "1hr");
		echo "<br />";
		echo "Invite groups:";
		echo "<br />";
		if ($groups === FALSE)
			echo "None <br />";
		else {
			$i = 1;
			foreach ($groups as $group):
				echo form_checkbox("group$i", $group->group_id, FALSE) . " " . $group->name . "<br />";
				$i++;
			endforeach;
		}
		echo "Invite friends:";
		echo "<br />";
		if ($friends === FALSE)
			echo "None <br />";
		else {
			$i = 1;
			foreach ($friends as $friend):
				echo form_checkbox("friend$i", $friend->user_id, FALSE) . " " . $friend->first_name . "<br />";
				$i++;
			endforeach;
		}
		echo form_submit($event_submit, "Submit");
		echo form_close();
	?>
	<script src="js/scripts.js"></script>
</body>
</html>