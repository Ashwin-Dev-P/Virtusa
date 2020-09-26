<?php
	session_start();
	require_once "pdo.php";
	if( !isset($_SESSION['username']) || strlen($_SESSION['username']) < 1){
		$_SESSION['error'] = "Login to continue";
		header('Location: index.php');
		return;
	}
	if( isset($_SESSION['position']) ){
		unset($_SESSION['position']);
		unset($_SESSION['positionc']);
		unset($_SESSION['entered']);
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
			Game
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
		<!--<script src="https://code.jquery.com/jquery-3.5.0.js"></script>-->
		<script src="js/downloadedjquery5.js"></script>
	</head>
	<body>
		<?php 
			
			if($darkmode == 1){
				echo "
				<style>
					
					#header.header-transparent {
					background-color: black;
		
					}
					.registration-form .form-icon {
						text-align: center;
						background-color: white;
						color: black;
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
					#right {
						background-color: black;
					}
				</style>
				";
			}
		?>
		
			<!--Date started:20.09.2020  time:12:17 pm--->
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
								<li><a href="game.php">Restart</a></li>
								<li><a href="accountsettings.php">My Profile</a></li>
								<li><a href="logout.php">Log Out</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<main>
		
			<div id="container2">
			<h1>Snake and Ladder</h1>
			
			<div id="result">
				
			</div>
			<table id="board">
			<tbody>
			<tr>
				<td id="25"></td>
				<td id="26"></td>
				<td id="27"></td>
				<td id="28"></td>
				<td id="29"></td>
				<td id="30"></td>
			</tr>
			<tr>
				<td id="24"></td>
				<td id="23"></td>
				<td id="22"></td>
				<td id="21"></td>
				<td id="20"></td>
				<td id="19"></td>
			
			</tr>
			<tr>
				<td id="13"></td>
				<td id="14"></td>
				<td id="15"></td>
				<td id="16"></td>
				<td id="17"></td>
				<td id="18"></td>
			</tr>
			<tr>
				<td id="12"></td>
				<td id="11"></td>
				<td id="10"></td>
				<td id="9"></td>
				<td id="8"></td>
				<td id="7"></td>
			</tr>
			<tr>
				<td id="1"></td>
				<td id="2"></td>
				<td id="3"></td>
				<td id="4"></td>
				<td id="5"></td>
				<td id="6"></td>
			
			</tr>
			</tbody>
			</table>
			
			
			<div id="right">
			
			<p class="divheadings">Comments:</p>
			<div id="comments" >
			
			</div>
			
			<p class="divheadings" class="dicevalues">dice value Player:</p>
			<div id="dicevaluefromjquery" class="dicevaluesbox">
				
			</div>
			
			<p class="divheadings" class="dicevalues">dice value Computer:</p>
			<div id="dicevaluefromjquery2" class="dicevaluesbox">
				
			</div>
			
			
			
			<div id= "instructions">Roll the Dice....</div>
			<div id="dicediv">
			<img id="rolling_dice" alt="rolling dice" src="images/source.gif" >
			
			<img id="static_dice" src="images/staticdice.jpg" alt="A dice" onclick="roll();rolldice();"><br/>
			</div>
			</div>
			</div>
		</main>
		
<script>


</script>

		
		
		<script src="js/rolldicejquery.js"></script>
		<!--Jquery link-->
		<script src="js/downloadedjquery.js"></script>
		<script src="js/downloadedjquery2.js"></script>
		<script src="js/downloadedjquery3.js"></script>
		<script src="js/downloadedjquery4ajax.js"></script>
		<script src="js/downloadedjquery5.js"></script>
		<!--
		<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		-->
		
		
		
		
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