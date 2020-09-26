<?php
    session_start();
	require_once "pdo.php";
    header('Content-Type: application/json; charset=utf-8');
	if(!isset($_SESSION['position'])){
		$firsttime = 1;
		$_SESSION['position'] = 0;
		$CurrentDiceValue = 0;
		$previous  = 0;
		$win = 0;
		
		$myarray = array(strval($_SESSION['position']),strval($CurrentDiceValue),strval($firsttime),strval($previous),true,strval($win));
		
		echo(json_encode($myarray,JSON_FORCE_OBJECT));

		return;
	}
	$firsttime = 0;
	$previous = 0;
	//Used ladder
	if($_SESSION['position'] == 3){
		$_SESSION['position'] = 22 ;
	}
	else if($_SESSION['position'] == 5){
		$_SESSION['position'] = 8;
	}
	else if($_SESSION['position'] == 11){
		$_SESSION['position'] = 26 ;
	}
	else if($_SESSION['position'] == 20){
		$_SESSION['position'] = 29;
	}
	else if($_SESSION['position'] == 17){
		$_SESSION['position'] = 4;
	}
	else if($_SESSION['position'] == 19){
		$_SESSION['position'] = 7;
	}
	else if($_SESSION['position'] == 21){
		$_SESSION['position'] = 9;
	}
	else if($_SESSION['position'] == 27){
		$_SESSION['position'] = 1;
	}
	
	$previous  = $_SESSION['position'];
	$CurrentDiceValue = rand(1,6);
	
	$win = 0;
	
	
	
	$_SESSION['result'] = "No result available.";
	//Boolean values are used to make sure that the values does not exceed 30. 
	$myarray = array(strval($_SESSION['position']),strval($CurrentDiceValue),strval($firsttime),strval($previous),false,strval($win));
	
	if(($_SESSION['position'] + $CurrentDiceValue) <= 30){
		
		
		$_SESSION['position'] = $_SESSION['position'] + $CurrentDiceValue ;
		
		if($_SESSION['position'] == 30){
			$win = 1;
			$_SESSION['result'] = "Congrats..You won the game.";
			
			$stmt = $pdo->prepare("SELECT score FROM accounts WHERE account_id = :account_id");
			$stmt -> execute(array(":account_id" => $_SESSION['account_id']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$score = $row['score'];
			
			$sql2 = "UPDATE accounts SET score = :score WHERE account_id = :account_id";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2->execute(array(
			':score' => $score + 1,
			':account_id' => $_SESSION['account_id']
			));
			
			
			
		}

		for ($x = $previous+1; $x < $_SESSION['position']; $x++) {
			$a[]=$x;
		}
		
		$myarray = array(strval($_SESSION['position']),strval($CurrentDiceValue),strval($firsttime),strval($previous),true,strval($win));
	}
	sleep(1.8);
	
	echo(json_encode($myarray,JSON_FORCE_OBJECT));