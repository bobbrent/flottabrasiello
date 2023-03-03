<?php
	include('config/struct.php');
	include('ses.php');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<?php require('parts/head.php')?>
	</head>
	<body>
		<section id="container">
			<?php require('parts/header.php')?>
			<?php require('parts/sidebar.php')?>
			<section id="main-content">
			</section>
			<?php require('parts/footer.php')?>
		</section>
		<?php require('parts/script.php')?>
		<div class="modal"></div>
	</body>
</html>
