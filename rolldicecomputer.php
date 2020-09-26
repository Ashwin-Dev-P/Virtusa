<?php
    session_start();
    header('Content-Type: application/json; charset=utf-8');
	if(!isset($_SESSION['positionc'])){
		$firsttime = 1;
		$_SESSION['positionc'] = '0';
		$CurrentDiceValue = '0';
		$previous  = '0';
		$win = 0;
		
		$myarray = array(strval($_SESSION['positionc']),strval($CurrentDiceValue),strval($firsttime),strval($previous),true,strval($win));
		
		echo(json_encode($myarray,JSON_FORCE_OBJECT));

		return;
	}
	$firsttime = 0;
	
	//Used ladder
	if($_SESSION['positionc'] == 3){
		$_SESSION['positionc'] = 22 ;
	}
	else if($_SESSION['positionc'] == 5){
		$_SESSION['positionc'] = 8;
	}
	else if($_SESSION['positionc'] == 11){
		$_SESSION['positionc'] = 26 ;
	}
	else if($_SESSION['positionc'] == 20){
		$_SESSION['positionc'] = 29;
	}
	else if($_SESSION['positionc'] == 17){
		$_SESSION['positionc'] = 4;
	}
	else if($_SESSION['positionc'] == 19){
		$_SESSION['positionc'] = 7;
	}
	else if($_SESSION['positionc'] == 21){
		$_SESSION['positionc'] = 9;
	}
	else if($_SESSION['positionc'] == 27){
		$_SESSION['positionc'] = 1;
	}
	
	$previous  = $_SESSION['positionc'];
	$CurrentDiceValue = rand(1,6);
	
	$win = 0;
	
	$_SESSION['result'] = "No result available.";
	if($_SESSION['positionc'] == 30 ){
		$win = 1;
	}
	//Boolean values are used to make sure that the values does not exceed 30. 
	$myarray = array(strval($_SESSION['positionc']),strval($CurrentDiceValue),strval($firsttime),strval($previous),false,strval($win));
	
	if(($_SESSION['positionc'] + $CurrentDiceValue) <= 30){
		$_SESSION['positionc'] = $_SESSION['positionc'] + $CurrentDiceValue ;
		if($_SESSION['positionc'] == 30 ){
			$win = 1;
			$_SESSION['result'] = "Oops..You lost the game.";
			
		}
		$myarray = array(strval($_SESSION['positionc']),strval($CurrentDiceValue),strval($firsttime),strval($previous),true,strval($win));
	}
	sleep(1.8);
	sleep(3);
	echo(json_encode($myarray,JSON_FORCE_OBJECT));