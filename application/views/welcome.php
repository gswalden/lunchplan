<body>
	Hello <?php echo $user->first_name; ?><br />
	List of Friends: <br />
	<?php foreach ($friends as $friend):
		echo $friend->first_name . ' <a href="index.php/user/delete_friend/' . $friend->user_id . '">delete</a><br />';
	endforeach; ?>
	<script src="js/scripts.js"></script>
</body>
</html>