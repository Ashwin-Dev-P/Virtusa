<?php
	session_start();
	require_once "pdo.php";
	if(   isset($_POST["fullname"]) && isset($_POST["username"]) && isset($_POST["password"])  &&isset($_POST["passwordconfirmation"])   ){
		$password = $_POST["password"];
		$email = $_POST["email"];
		
		$uppercase = preg_match('@[A-Z]@', $password);
		$lowercase = preg_match('@[a-z]@', $password);
		$number    = preg_match('@[0-9]@', $password);
		$specialChars = preg_match('@[^\w]@', $password);
	
		if( strlen($_POST["fullname"]) < 1){
			$_SESSION["error"] = "Full name is required.";
			if(strlen($_POST["username"]) > 0){
				$_SESSION["username"]= $_POST["username"];
			}
			if(strlen($_POST["password"]) > 0){
				$_SESSION["password"]= $_POST["passwordconfirmation"];
			}
			if(strlen($_POST["passwordconfirmation"]) > 0){
				$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			}
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
			if(strlen($_POST["password"]) > 0){
				$_SESSION["password"]= $_POST["passwordconfirmation"];
			}
			if(strlen($_POST["passwordconfirmation"]) > 0){
				$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			}
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if( strlen($_POST["password"]) < 1){
			$_SESSION["error"] = "password is required";
		
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["username"]= $_POST["username"];
			if(strlen($_POST["passwordconfirmation"]) > 0){
				$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			}
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if(  strlen($_POST["passwordconfirmation"]) < 1){
			$_SESSION["error"] = "password confirmation is required";
		
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["fullname"]= $_POST["fullname"];
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if( $_POST["password"] !== $_POST["passwordconfirmation"]  ){
			$_SESSION["error"] = "Both the passwords does not match.";
		
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			$_SESSION["fullname"]= $_POST["fullname"];
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if( strlen($_POST["password"]) < 8 ){
			$_SESSION["error"] ='Password should include at least one upper case letter, one number, and one special character.';
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			$_SESSION["fullname"]= $_POST["fullname"];
			if(strlen($_POST["email"]) > 0){
				$_SESSION["email"]= $_POST["email"];
			}
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if(!$uppercase || !$lowercase || !$number || !$specialChars ) {
			$_SESSION["error"] ='Password should include at least one upper case letter, one number, and one special character.';
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
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
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["email"]= $_POST["email"];
			if(strlen($_POST["number"]) > 0){
				$_SESSION["number"]= $_POST["number"];
			}
		}
		else if( strlen($_POST["number"]) > 0 && strlen($_POST["number"]) != 10 ){
			$_SESSION["error"] = "Enter a valid number.";
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["email"]= $_POST["email"];
			$_SESSION["number"]= $_POST["number"];
		}
		else{
			$_SESSION["username"]= $_POST["username"];
			$_SESSION["password"]= $_POST["password"];
			$_SESSION["passwordconfirmation"]= $_POST["passwordconfirmation"];
			$_SESSION["fullname"]= $_POST["fullname"];
			$_SESSION["email"]= $_POST["email"];
			$_SESSION["number"]= $_POST["number"];
			
			$stmt = $pdo->prepare("SELECT username FROM accounts WHERE username= :username");
			$stmt -> execute(array(":username" => $_POST['username']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row !== false){
				$_SESSION['error'] = 'User name '.'"'.$_POST["username"] .'"'.' has already been taken.Try another name.';
				header('Location: signup.php');
				return;
			
			}
		
		
			
			$salt = 'XyZzy12*_';
			$storage_password =  hash('md5', $salt.$_POST['password']);
			$sql = "INSERT INTO accounts (fullname,username, password, email,number,creationdate,creationtime,ampm) VALUES (:fullname,:username ,:password, :email,:number,:creationdate,:creationtime,:ampm)";
			
			$stmt = $pdo->prepare($sql);
			
			$stmt->execute(array(
			':fullname' => htmlentities($_POST['fullname']),
			':username' => htmlentities($_POST['username']),
			':password' => $storage_password,
			':email' => htmlentities($_POST['email']),
			':number' => htmlentities($_POST["number"]),
			':creationdate' => $_POST["creationdate"],
			':creationtime' => $_POST["creationtime"],
			':ampm' => $_POST['ampm']
			));
			
			$stmt = $pdo->query("SELECT fullname,username, password, email,number,creationdate,creationtime,ampm FROM accounts");
			$_SESSION['rows']=$stmt->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION["success"] = "Account created successfully.";
			header("Location: signup.php");
			return;
		
		}	
	}
	date_default_timezone_set('Asia/Kolkata');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Sign Up</title>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
		<link rel="stylesheet" href="css/login.css">
		<style>
			a{
				color: #7EAE5E;
			}
			#signup{
				text-align:center;
				margin:40px;
			}
		</style>
	</head>
	<body>
		<div class="registration-form">
			<form method="post">
				<?php
					//Used to check if the username and password is set(It will be set only if you have entered the wrong values already). 
					if(!isset($_SESSION["email"])){
						$_SESSION["email"]="";
					}
					if(!isset($_SESSION["number"])){
						$_SESSION["number"]="";
					}
					if(!isset($_SESSION["fullname"])){
						$_SESSION["fullname"]="";
					}
					if(!isset($_SESSION["username"])){
						$_SESSION["username"]="";
					}
					if(!isset($_SESSION["password"])){
						$_SESSION["password"]="";
					}
					if(!isset($_SESSION["passwordconfirmation"])){
						$_SESSION["passwordconfirmation"]="";
					}
					//They wont be set the first time on opening the webpage.
					//So we are setting a default empty value so that it can used as value attribute in the forms.
				?>
				
				<div class="form-group">
					<input type="text" class="form-control item" id="fullname" name="fullname" placeholder="FULL NAME" value="<?php echo $_SESSION["fullname"] ?>" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control item" id="username" name="username" placeholder="USERNAME" value="<?php echo $_SESSION["username"] ?>" required>
				</div>
				<div class="form-group">
					<input type="password" class="form-control item" id="password" name="password" placeholder="PASSWORD" value="<?php echo $_SESSION["password"] ?>" required >
				</div>
				<div class="form-group">
					<input type="password" class="form-control item" id="passwordconfirmation" name="passwordconfirmation" placeholder="PASSWORD CONFIRMATION" value="<?php echo $_SESSION["passwordconfirmation"] ?>" required>
				</div>
				<div class="form-group">
					<input type="text" class="form-control item" id="email" name="email" placeholder="EMAIL"  value="<?php echo $_SESSION["email"] ?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control item" id="number" name="number" placeholder="PHONE NUMBER" value="<?php echo $_SESSION["number"] ?>">
				</div>
			
				<input type="date" value="<?php echo date('Y-m-d');?>" name="creationdate" id="creationdate" hidden>
					
				<input type="time" id="creationtime" name="creationtime" value="<?php echo date('h:i:s');?>" hidden >
					
				<input type="text" name="ampm" id="ampm" value="<?php echo date('A');?>" hidden>
			
				<div class="form-group">
					<button type="submit" class="btn btn-block create-account">CREATE ACCOUNT</button>
				</div>
				<?php
					//The session "username" and "password" will be unset only on page reload.
					//page reload will happen if you reload it or  If your input to the form is correct(and you will be reloaded to another page.)
					unset($_SESSION["username"]);
					unset($_SESSION["password"]);
					unset($_SESSION["passwordconfirmation"]);
					unset($_SESSION["email"]);
					unset($_SESSION["number"]);
					unset($_SESSION["fullname"]);
					if (isset($_SESSION['error'])) {
						echo '<p style="color: red; text-align:center;" >'.$_SESSION['error']."</p>\n";
						unset($_SESSION['error']);
					}
					if (isset($_SESSION['success'])) {
						echo '<p style="color: green; text-align:center;" >'.$_SESSION['success']."</p>\n";
						unset($_SESSION['success']);
					}
				?>
			</form>
			<div class="social-media" id="linkdiv">
				<h5>HAVE AN ACCOUNT? <a href="login.php" >LOG IN</a></h5>
			</div>
		</div>
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
		<script src="assets/js/script.js"></script>
		<script src="js/login.js"></script>
	</body>
</html>