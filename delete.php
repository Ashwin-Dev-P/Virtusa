<?php
	session_start();
	
	require_once "pdo.php";
	if ( ! isset($_SESSION['admin_name']) || strlen($_SESSION['admin_name']) < 1  ) {
		$_SESSION['error'] = "Login to continue";
		header('Location: index.php');
		return;
	}
	if ( isset($_POST['logout']) ) {
		header('Location: logout.php');
		return;
	}
if ( isset($_POST['delete']) && isset($_POST['account_id']) ) {
    $sql = "DELETE FROM accounts WHERE account_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['account_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: admin.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['account_id']) ) {
  $_SESSION['error'] = "Missing account_id";
  header('Location: admin.php');
  return;
}

$stmt = $pdo->prepare("SELECT username, account_id FROM accounts where account_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['account_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for account_id';
    header( 'Location: admin.php' ) ;
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
			#confirmation{
				color:white;
				font-size:30px;
			}
			#cancelbutton{
				color:black;
				background:white;
				    padding: 4px;
			}
		</style>
	</head>
	<body>
		
		<header id="header" class="header-transparent">
			<div class="container">
				<div id="logo" class="pull-left">
					<h1><a href="admin.php" id="Myname">Administration</a></h1>
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
				<p id="confirmation">Confirm: Deleting <?= htmlentities($row['username']) ?></p>

					<form method="post">
					<input type="hidden" name="account_id" value="<?= $row['account_id'] ?>">
					<input type="submit" value="Delete" name="delete">
					<a href="admin.php" id="cancelbutton">Cancel</a>
				</form>
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