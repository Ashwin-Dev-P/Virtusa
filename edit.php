<?php
	session_start();
	require_once "pdo.php";
	if(isset($updatedusername)){
		$_SESSION['username'] = $updatedusername;
	}
	if ( ! isset($_SESSION['admin_name']) || strlen($_SESSION['admin_name']) < 1  ) {
		$_SESSION['error'] = "Please log in to continue";
		header('Location: adminlogin.php');
		return;
	}
	else{
		$temp = $_SESSION["username"];
	}


	$stmt = $pdo->prepare("SELECT darkmode,score FROM accounts WHERE account_id= :account_id");
	$stmt -> execute(array(":account_id" => $_GET['account_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$darkmode = $row['darkmode'];
	$score = $row['score'];
	
	
	if(isset($_POST["edit"])){
		$_SESSION["editenabled"] ="";
	}
	else{
		$_SESSION["editenabled"] ="readonly";
	}

	if(   isset($_POST["fullname"]) && isset($_POST["username"]) && isset($_POST["email"])  &&isset($_POST["number"])   ){
		$email = $_POST["email"];
		if( strlen($_POST["fullname"]) < 1){
			$_SESSION["error"] = "Full name is required.";
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if(  strlen($_POST["username"]) < 1){
			$_SESSION["error"] = "User name is required";
			$_SESSION["fullname"]= $_POST["fullname"];
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if ( strlen($_POST["email"]) >= 1 and !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION["error"] = "Invalid email format";
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["email"]= $_POST["email"];
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if( strlen($_POST["number"]) > 0  && (strlen($_POST["number"]) != 10   && $_POST['number'] != 0 ) ){
			$_SESSION["error"] = "Enter a valid number.";
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["email"]= $_POST["email"];
			$_SESSION["number"]= $_POST["number"];
		}
		else{
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["email"]= $_POST["email"];
			$_SESSION["number"]= $_POST["number"];
			$stmt = $pdo->prepare("SELECT username FROM accounts WHERE username= :username");
			$stmt -> execute(array(":username" => $_POST['username']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if( $temp != $_POST["username"] && $row !== false){
				$_SESSION['error'] = 'User name '.'"'.$_POST["username"] .'"'.' has already been taken.Try another name.';
				header('Location: accountsettings.php');
				return;
			}
			if(isset($_POST['darkmode'])){
				$_POST['darkmode'] =1;
			}
			else{
				$_POST['darkmode'] =0;
			}
			$sql = "UPDATE accounts SET username = :username,
				fullname = :fullname, email = :email,number= :number ,darkmode= :darkmode
				WHERE account_id = :account_id";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(
			':account_id' => $_GET['account_id'],
			':username' => $_POST['username'],
			':fullname' => $_POST['fullname'],
			':email' => $_POST['email'],
			':number' => $_POST['number'],
			':darkmode' => $_POST['darkmode']
			));
			$updatedusername = $_POST['username'];
			$_SESSION['success'] = 'Account details updated';
			header( 'Location: accountsettings.php' ) ;
			return;
		}	
	}
	date_default_timezone_set('Asia/Kolkata');

	

	$stmt = $pdo->prepare("SELECT * FROM accounts where account_id = :account_id");
	$stmt->execute(array(":account_id" => $_GET['account_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if($row === false){
		$stmt = $pdo->prepare("SELECT * FROM accounts where account_id = :account_id");
		$stmt->execute(array(":account_id" => $_GET['account_id']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	$username = htmlentities($row['username']);
	$fullname = htmlentities($row['fullname']);
	$email = htmlentities($row['email']);
	$number = htmlentities($row['number']);
	$darkmode = htmlentities($row['darkmode']);
	$_SESSION["username"]=$username;
	$_SESSION["fullname"]=$fullname;
	$_SESSION["email"]=$email;
	$_SESSION["number"]=$number;
	$_SESSION["account_id"] = $row['account_id'];
	$_SESSION["darkmode"] = $row['darkmode'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta content="" name="descriptison">
		<meta content="" name="keywords">
		
		<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">
		<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		<link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
		<link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
		<link href="assets/vendor/aos/aos.css" rel="stylesheet">
		<link href="assets/css/style.css" rel="stylesheet">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>My Profile Settings</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/accountsettings.css">
		<link href="assets/img/favicon.png" rel="icon">
		
	</head>
	<body>
		<?php 
			if(isset($_POST["edit"])){
				echo"
				<style>
					#editform{
						display:none;
					}
				
					
				</style>
				";
			}
			else{
				echo"
				<style>
					#confirm{
						display:none;
					}
					
				</style>
				";
			}
		
			
		?>
		<header id="header" class="header-transparent">
			<div class="container">
				<div id="logo" class="pull-left">
					<h1><a href="admin.php" id="Myname">Administration</a></h1>
				</div>
				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li class="menu-has-children"><a href="admin.php">Home</a>
						<li class="menu-has-children"><a href=""><?= $_SESSION["admin_name"]?></a>
							
						</li>
					</ul>
				</nav>
			</div>
		</header>
		<main>
			<div class="registration-form">
				<form method="post">
					
					<div class="form-group">
						<label for="fullname">Full Name</label>
						<input type="text" class="form-control item" id="fullname" name="fullname" placeholder="Full Name" value="<?php echo $_SESSION["fullname"] ?>" <?= $_SESSION["editenabled"]?> required>
					</div>
					<div class="form-group">
						<label for="username">User Name</label>
						<input type="text" class="form-control item" id="username" name="username" placeholder="Username" value="<?php echo $_SESSION["username"] ?>" <?= $_SESSION["editenabled"]?> required>
					</div>
					<div class="form-group" id="detailsform">
						<label for="email">E-mail</label>
						<input type="text" class="form-control item" id="email" name="email" placeholder="Email"  value="<?php echo $_SESSION["email"] ?>" <?= $_SESSION["editenabled"]?>>
					</div>
					<div class="form-group">
						<label for="number">Phone Number</label>
						<input type="text" class="form-control item" id="number" name="number" placeholder="Phone Number" value="<?php echo $_SESSION["number"] ?>" <?= $_SESSION["editenabled"]?>>
					</div>
					
					<input type="date" value="<?php echo date('Y-m-d');?>" name="creationdate" id="creationdate" hidden>
							
					<input type="time" id="creationtime" name="creationtime" value="<?php echo date('h:i:s');?>" hidden >
							
					<input type="text" name="ampm" id="ampm" value="<?php echo date('A');?>" hidden>
					<label for="darkmode">Dark Mode</label>
					<label class="switch" for="darkmode">
					
					
				
					<input type="checkbox" id="darkmode" name="darkmode" 
						<?php 
							if($_SESSION['darkmode'] == 1){
								echo "checked ";
							}
							if($_SESSION["editenabled"] == 'readonly'){
								echo "disabled";
							}
						?>>
						<span class="slider round"></span>
					</label>
					<div class="form-group">
					Score:<?=$score?>
					</div>
					
					
					
					<div class="form-group">
						<button type="submit" name="confirm" id="confirm" class="btn btn-block create-account" >Confirm</button>
					</div>
			
					<?php
				
						if($darkmode == 1){
							if (isset($_SESSION['error'])) {
								echo '<p style="color: white;text-align:center;">'.$_SESSION['error']."</p>\n";
								unset($_SESSION['error']);
							}
							if (isset($_SESSION['success'])) {
								echo '<p style="color: white;text-align:center;">'.$_SESSION['success']."</p>\n";
								unset($_SESSION['success']);
							}
						}
						else{
							if (isset($_SESSION['error'])) {
								echo '<p style="color: red;text-align:center;">'.$_SESSION['error']."</p>\n";
								unset($_SESSION['error']);
							}
							if (isset($_SESSION['success'])) {
								echo '<p style="color: green;text-align:center;">'.$_SESSION['success']."</p>\n";
								unset($_SESSION['success']);
							}
						}
					?>
					
				</form>
				<form method="post" id="editform">
					<button type="Submit" name="edit" id="edit" class="btn btn-block create-account" >Edit Profile</button>
				</form>
			</div>
		</main>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
		<script src="assets/js/script.js"></script>
		<script src="js/login.js"></script>
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