<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0" name="viewport">

		<title>Ashwin Dev</title>
		<meta content="" name="descriptison">
		<meta content="" name="keywords">

	
		<link href="assets/img/favicon.png" rel="icon">
		<link href="assets/img/apple-touch-icon2.png" rel="apple-touch-icon">

		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

		<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
		<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
		<link href="assets/vendor/aos/aos.css" rel="stylesheet">

		<link href="assets/css/style.css" rel="stylesheet">
		<style>
			body {
				overflow: hidden; /* Hide scrollbars */
			}
			#Myname{
				font-size:.6em;
			}
		</style>
	</head>
	<body >
		
		<section id="hero">
			<div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
				<h1>Snake and Ladder</h1>
				<h2>
					<?php
					session_start();
					if (isset($_SESSION['error'])) {
						echo '<p style="color: red;">'.$_SESSION['error']."</p>\n";
						unset($_SESSION['error']);
						session_destroy();
					}
					?>
				</h2>
				<a href="login.php" class="btn-get-started">Get Started</a>
			</div>
		</section>
		<script src="assets/vendor/jquery/jquery.min.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
		<script src="assets/vendor/php-email-form/validate.js"></script>
		<script src="assets/vendor/counterup/counterup.min.js"></script>
		<script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
		<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
		<script src="assets/vendor/superfish/superfish.min.js"></script>
		<script src="assets/vendor/hoverIntent/hoverIntent.js"></script>
		<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
		<script src="assets/vendor/venobox/venobox.min.js"></script>
		<script src="assets/vendor/aos/aos.js"></script>
		<script src="assets/js/main.js"></script>
	</body>
</html>