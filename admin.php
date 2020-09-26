<?php
	session_start();
	
	require_once "pdo.php";
	if ( ! isset($_SESSION['admin_name']) || strlen($_SESSION['admin_name']) < 1  ) {
		$_SESSION['error'] = "Login to continue";
		header('Location: adminlogin.php');
		return;
	}
	if ( isset($_POST['logout']) ) {
		header('Location: logout.php');
		return;
	}
	
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title>
			Admin
		</title>
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
		<link href="css/leaderboard.css" rel="stylesheet">
		<style>
			body{
				overflow:scroll;
			}
		</style>
	</head>
	<body>
		
		<header id="header" class="header-transparent">
			<div class="container">
				<div id="logo" class="pull-left">
					<h1><a href="" id="Myname">Administration</a></h1>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li class="menu-has-children"><a href="admin.php">Home</a>
						<li><a href="admin.php"><?=$_SESSION['admin_name']?></a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<section id="hero">
			<div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
				<h1 id="myheading">Accounts</h1>
				<?php
					$stmt = $pdo->query("SELECT account_id,fullname,username,email,number,password,creationdate,creationtime,ampm, darkmode,score FROM accounts");
					echo('<table border="1" id="mytable">'."\n");
					echo "<tr><th>account_id</th><th>fullname</th><th>username</th><th>email</th><th>number</th><th>password</th><th>creationdate</th><th>creationtime</th><th>ampm</th><th>Score</th><th>Dark Mode</th><th>Edit</th><th>Delete</th></tr>";
					
					
					while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
						echo "<tr><td>";
						echo(htmlentities($row['account_id']));
						echo("</td><td>");
						echo(htmlentities($row['fullname']));
						echo("</td><td>");
						echo(htmlentities($row['username']));
						echo("</td><td>");
						echo(htmlentities($row['email']));
						echo("</td><td>");
						echo(htmlentities($row['number']));
						echo("</td><td>");
						echo(htmlentities($row['password']));
						echo("</td><td>");
						echo(htmlentities($row['creationdate']));
						echo("</td><td>");
						echo(htmlentities($row['creationtime']));
						echo("</td><td>");
						echo(htmlentities($row['ampm']));
						echo("</td><td>");
						echo(htmlentities($row['score']));
						echo("</td><td>");
						echo(htmlentities($row['darkmode']));
						echo("</td><td>");
						echo('<a href="edit.php?account_id='.$row['account_id'].'">edit</a>');
						echo("</td><td>");
						echo('<a href="delete.php?account_id='.$row['account_id'].'">Delete</a>');
						echo("</td></tr>\n");
					}
				?>
				</table>
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