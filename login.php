<?php
	ini_set('display_errors',1);
	ini_set('log_errors',1);
	ini_set('error_log',dirname(__FILE__).'/log.txt');
	error_reporting(E_ALL);
	session_start();
	require_once "pdo.php";
	$salt = 'XyZzy12*_';
	$stored_hash = 'ac7cc39c493be9ccbd7548984d90185e';

	//This if statement won't get executed on opening this webpage the first time.It runs when the login button is pressed.
	if (isset($_POST['username']) && isset($_POST['password'])) {
		if( strlen($_POST['password']) < 1 && strlen($_POST['username']) < 1 ){
			$_SESSION['error'] = "Username and Password is required";
			header("Location: login.php");
			return;
		}
		else if (strlen($_POST['username']) < 1 ) {
			$_SESSION["password"]= $_POST["password"];
			$_SESSION['error'] = "Username is required";
			header("Location: login.php");
			return;
		}
		else if( strlen($_POST['password']) < 1  ){
			$_SESSION["username"]= $_POST["username"];
			$_SESSION['error'] = "Password is required";
			header("Location: login.php");
			return;
		}
		else {
			//The username and password entered by the user will be stored in session even before validating them.
			//So that it can be displayed for them to correct even if it is wrong. 
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			
			//For value
			$_SESSION["usernamevalue"]= $_POST["username"];
			$_SESSION["passwordvalue"]= $_POST["password"];
		
			$stmt = $pdo->prepare("SELECT username,password,account_id,darkmode,score FROM accounts WHERE username= :username");
			$stmt -> execute(array(":username" => $_POST['username']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
			if($row !== false){
			
				$RetrievedPasswordHash = $row["password"];
				$check = hash('md5', $salt.$_POST['password']);
				if ($check == $RetrievedPasswordHash) {
					$_SESSION['account_id'] = $row['account_id'];
					$_SESSION['darkmode'] = $row['darkmode'];
					$_SESSION['score'] = $row['score'];
					error_log("Login success ".$_POST['username']);
					$_SESSION['username'] = htmlentities($_POST['username']);
					header("Location: home.php");
					return;
				} 
				else {
					$pass = $_POST['password'];
				
					$_SESSION['error'] = "Sorry, your password was incorrect. Please double-check your password.";
					error_log(" || Login fail || account name =".$_POST['username']." || Password="." $pass"." || ");
					header("Location: login.php");
					return;
				}
			}
			else{
				$_SESSION["error"] = "The username you entered doesn't belong to an account. Please check your username and try again.";
				header("Location: login.php");
				return;
			}
	}
	}
	if(!isset($_SESSION['usernamevalue'])){
		$_SESSION["usernamevalue"]= "";
	}
	if(!isset($_SESSION['passwordvalue'])){
		$_SESSION["passwordvalue"]= "";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login</title>
		
		
		
		<link href="assets/img/favicon.png" rel="icon">
		
		
		<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	
	
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    
		<link rel="stylesheet" href="css/login.css">
		<style>
			#login{
				text-align:center;
				margin:40px;
			}
		</style>
	</head>
	<body>
		<div class="registration-form">
			<form method="post">
				<div id="login">
					<h1>LOGIN</h1>
				</div>
				<div class="form-group">
					<input type="text" class="form-control item" id="username" name="username" placeholder="USERNAME" value="<?= $_SESSION['usernamevalue']?>">
				</div>
				<div class="form-group ">
					<input type="password" class="form-control item passwordclass" id="password" name="password" placeholder="PASSWORD" value="<?= $_SESSION['passwordvalue']?>"><i class="far fa-eye" id="togglePassword"></i>
				</div>
            
				<div class="form-group">
					<button type="submit" class="btn btn-block create-account">LOG IN</button>
				</div>
				<div class="form-group">
					<?php
						//The session "username" and "password" will be unset only on page reload.
						//page reload will happen if you reload it or  If your input to the form is correct(and you will be reloaded to another page.)
						unset($_SESSION["username"]);
						unset($_SESSION["password"]);
						if (isset($_SESSION['error'])) {
							echo '<p style="color: red;text-align:center;">'.$_SESSION['error']."</p>\n";
							unset($_SESSION['error']);
						}
					?>
				</div>
			</form>
			<div class="social-media" id="linkdiv">
				<h5>DON'T HAVE AN ACCOUNT?<a  id="signuplink" href="signup.php">SIGN UP</a></h5>
			</div>
		</div>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
    
	<script src="js/login.js"></script>
	<script src="js/togglepassword.js"></script>
	</body>
</html>