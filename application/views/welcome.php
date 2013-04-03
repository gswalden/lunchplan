<body>
	Hello <?php echo $user->first_name; ?><br />
	List of Friends: <br />
	<?php
		if ($friends === FALSE)
			echo "None <br />";
		else 
			foreach ($friends as $friend)
				echo $friend->first_name . ' <a href="/lunchplan/index.php/user/delete_friend/' . $friend->user_id . '">delete</a>' 
					. ' <a href="/lunchplan/index.php/' . $friend->user_id . '">be</a><br />';
	?>
	List of Requests: <br />
	<?php
		if ($invites === FALSE)
			echo "None <br />";
		else 
			foreach ($invites as $invite)
				echo $invite->first_name . ' <a href="/lunchplan/index.php/user/invite/' . $invite->user_id . '/yes">yes</a>'
					. ' <a href="/lunchplan/index.php/user/invite/' . $invite->user_id . '/no">no</a><br />';
	?>
	List of Sent (Pending) Requests: <br />
	<?php
		if ($requests === FALSE)
			echo "None <br />";
		else 
			foreach ($requests as $request)
				echo $request->first_name . ' <a href="/lunchplan/index.php/' . $request->user_id . '">be</a><br />';
	?>
	List of Non-Friends: <br />
	<?php
		if ($non_friends === FALSE)
			echo "None <br />";
		else
			foreach ($non_friends as $non_friend)
				echo $non_friend->first_name . ' <a href="/lunchplan/index.php/user/add_friend/' . $non_friend->user_id . '">add</a>'
					. ' <a href="/lunchplan/index.php/' . $non_friend->user_id . '">be</a><br />';
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
			foreach ($events as $event):
				echo $event->name . ' <a href="/lunchplan/index.php/event/leave/' . $event->event_id . '">leave</a>';
				if ($event->user_id == $user->user_id)
					echo ' <a href="/lunchplan/index.php/event/delete/' . $event->event_id . '">delete</a>';
				echo "<br />";
			endforeach;
	?>
	List of Invitations: <br />
	<?php
		if ($event_invites === FALSE)
			echo "None <br />";
		else 
			foreach ($event_invites as $event_invite):
				echo $event_invite->name . ' <a href="/lunchplan/index.php/event/invite/' . $event_invite->event_id . '/yes">accept</a>'
					. ' <a href="/lunchplan/index.php/event/invite/' . $event_invite->event_id . '/no">reject</a>';
				echo "<br />";
			endforeach;
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