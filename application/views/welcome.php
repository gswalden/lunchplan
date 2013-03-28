<body>
	Hello <?php echo $row->first_name; ?><br />
	List of Friends: <br />
	<?php foreach ($friends as $friend):
		echo $friend->first_name . "<br />";
	endforeach; ?>
	<script src="js/scripts.js"></script>
</body>
</html>