<?php
	session_start();
	
	require_once "pdo.php";
	if ( ! isset($_SESSION['username']) || strlen($_SESSION['username']) < 1  ) {
		$_SESSION['error'] = "Login to continue";
		header('Location: index.php');
		return;
	}
	if ( isset($_POST['logout']) ) {
		header('Location: logout.php');
		return;
	}
	$stmt = $pdo->prepare("SELECT darkmode FROM accounts WHERE account_id= :account_id");
	$stmt -> execute(array(":account_id" => $_SESSION['account_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$darkmode = $row['darkmode'];
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title>
			LeaderBoard
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
	</head>
	<body>
		<?php
			if($darkmode == 1){
				echo "
				<style>
					#hero:before{
						background-color:black;
					}
					a:hover{
						color:#2dc997;
					}
					#mobile-nav {
						background: black;
					}
				</style>
				";
			}
		?>
		<header id="header" class="header-transparent">
			<div class="container">
				<div id="logo" class="pull-left">
					<h1><a href="" id="Myname">Leader Board</a></h1>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li><a href="home.php">Home</a></li>
					</ul>
				</nav>
			</div>
		</header>
		<section id="hero">
			<div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
				<h1 id="myheading">Guess The Number</h1>
				<?php
					$stmt = $pdo->query("SELECT username, score FROM accounts");
					echo('<table border="1" id="mytable">'."\n");
					echo "<tr><th>Username</th><th>Score</th></tr>";
					while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
						echo "<tr><td>";
						echo(htmlentities($row['username']));
						echo("</td><td>");
						echo(htmlentities($row['score']));
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