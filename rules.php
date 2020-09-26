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
	$stmt = $pdo->prepare("SELECT score,darkmode FROM accounts WHERE account_id= :account_id");
	$stmt -> execute(array(":account_id" => $_SESSION['account_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$_SESSION['score'] = $row['score'];
	$darkmode = $row['darkmode'];
	
	
?>
<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta charset="UTF-8">
		<meta content="" name="descriptison">
		<meta content="" name="keywords">
		<title>
			Home
		</title>
		
		<link href="assets/img/favicon.png" rel="icon">
		<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">
		<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
		<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
		<link href="assets/vendor/aos/aos.css" rel="stylesheet">
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="css/rps2.css" rel="stylesheet">
		
		<link rel="stylesheet" href="css/game.css">
		<link rel="stylesheet" href="css/rules.css">
		<script src="js/downloadedjquery5.js"></script>
		
	</head>
	<body>
		<?php 
			
			if($darkmode == 1){
				echo "
				<style>
					body{
						background:black;
					}
					#menucenter {
						background: black;
					}
					#header.header-transparent {
					background-color: black;
		
					}
					.registration-form .form-icon {
						text-align: center;
						background-color: white;
						color: black;
					}
					p{
						color:white;
						background:black;
					}

					#hero:before{
						background-color:black;
					}
					a:hover{
						color:#2dc997;
					}
					input:checked + .slider {
						background-color: #ccc;
					}
					.registration-form .create-account {
						background-color: black;
						color: white;
					}
					label{
							color:white;
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
				<div id="logo " class="pull-left score" style="font-size: 2rem;">
					Score:<?=$_SESSION['score']?>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li><a href="home.php">Home</a></li>
						<li><a href="leaderboard.php">LeaderBoard</a></li>
						<li class="menu-has-children"><a><?=$_SESSION['username']?></a>
							<ul>
								<li><a href="accountsettings.php">My Profile</a></li>
								<li><a href="logout.php">Log Out</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		
		
		<section id="hero">
			<div class="hero-container" data-aos="zoom-in" data-aos-delay="100" id="menucenter">
				<div class="registration-form" id="ruleswidth" >
					
				<p  id="rulesparagraph" >
					<br/>
					<span id="rulesheading" >Snake and ladder Rules and Regulations</span>
					<br/><br/>
					Rule 1:<br/>
					If you roll one  or  five or six, then you get an extra turn.<br/><br/>
					Rule 2:<br/>
					If your piece lands at the bottom (not at the middle or top) of a ladder, you can move up to the top of the ladder.<br/><br/>
					Rule 3:<br/>
					If your  piece lands on the head of a snake, you must slide down to the bottom of the snake.<br/><br/>
					Rule 4:<br/>
					The first person who reach the highest square  on the board wins, usually square 30. <br/><br/>
					BUT THERE'S A TWIST<br/>
					If you roll too high than the highest square (30th square) your piece will not move. <br/>
					You can only win by rolling the exact number needed to land on the last square.<br/>
					For example :  if you are on square 29 and roll a four, your piece will be remain at same position (29th square). <br/>
					<br/>
					ALL THE BEST<br/>
				</p>
				</div>
			</div>
		</section>
		
		
		
		
		
		<!--Jquery link-->
		<script src="js/downloadedjquery.js"></script>
		<script src="js/downloadedjquery2.js"></script>
		<script src="js/downloadedjquery3.js"></script>
		<script src="js/downloadedjquery4ajax.js"></script>
		<script src="js/downloadedjquery5.js"></script>
		
		
		
		
		
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