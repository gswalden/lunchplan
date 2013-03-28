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
	<?php foreach ($nonfriends as $nonfriend):
		echo $nonfriend->first_name . ' <a href="/lunchplan/index.php/user/add_friend/' . $nonfriend->user_id . '">add</a><br />';
	endforeach; ?>
	<script src="js/scripts.js"></script>
</body>
</html>