
//TODO:remove postionvalue jquery code since the div is deleted.
window.onresize = AfterResize;
function AfterResize(){
var size = screen.width;

var w = window.innerWidth;

window.onresize = doALoadOfStuff;
function doALoadOfStuff() {
	var w = window.innerWidth;
	
	
}
if(w < 400 || size<400){
	document.getElementById('board').style.display = "block";
	document.getElementById('right').style.display = "block";
	document.getElementById('right').style.width = "60%";
	document.getElementById('right').style.marginRight = "20%";
	
}
}

function roll() {
	var x = document.getElementById("static_dice");
	var y = document.getElementById("rolling_dice");
	if (x.style.display == "none") {
		x.style.display = "none";
		y.style.display = "inline-block";
	} else {
		x.style.display = "none";
		y.style.display = "inline-block";
	}
	
	setTimeout(function () {
        if (x.style.display == "none") {
            x.style.display = "inline-block";
			y.style.display = "none";
			document.getElementById("static_dice").style.display="none";
        }
	}, 1200);
}

function rolldice() {
	window.console && console.log('Requesting JSON'); 
	$.getJSON('rolldice.php', function(rowz){
		window.console && console.log('JSON Received'); 
		window.console && console.log(rowz);
		$('#dicevaluefromjquery').empty();
		$('#dicevaluefromjquery2').empty();
		
		//checking if it is not first time.
		if(rowz['2'] == '0'){
			
			//Redirecting after win.
			function win(){
				location.replace("result.php")
				return 0;
			}
		
		
		function Climb(){
			
			//This is made in function to keep time between reaching ladder and climbing it.
			//Checking if the position is in ladder position.
			if(rowz['0'] == '3' || rowz['0'] == '5' || rowz['0'] == '11' || rowz['0'] == '20' || rowz['0'] == '17' || rowz['0'] == '19' || rowz['0'] == '21' || rowz['0'] == '27' ){
				
				//$('#comments').append('entered ladder \n ');
				if(rowz['0'] == '3'){
					$('#comments').prepend('<br/>Player Climbing ladder....');
					rowz['0'] = '22';
					rowz['3'] = '3';
				}
				else if(rowz['0'] == '5'){
					$('#comments').prepend('<br/>Player Climbing ladder....');
					rowz['0'] = '8';
					rowz['3'] = '5';
				}
				else if(rowz['0'] == '11'){
					$('#comments').prepend('<br/>Player Climbing ladder....');
					rowz['0'] = '26';
					rowz['3'] = '11';
				}
				else if(rowz['0'] == '20'){
					$('#comments').prepend('<br/>Player Climbing ladder....');
					rowz['0'] = '29';
					rowz['3'] = '20';
				}
				else if(rowz['0'] == '17'){
					$('#comments').prepend('<br/>Player bitten by snake....');
					rowz['0'] = '4';
					rowz['3'] = '17';
				}
				else if(rowz['0'] == '19'){
					$('#comments').prepend('<br/>Player bitten by snake....');
					rowz['0'] = '7';
					rowz['3'] = '19';
				}
				else if(rowz['0'] == '21'){
					$('#comments').prepend('<br/>Player bitten by snake....');
					rowz['0'] = '9';
					rowz['3'] = '21';
				}
				else if(rowz['0'] == '27'){
					$('#comments').prepend('<br/>Player bitten by snake....');
					rowz['0'] = '1';
					rowz['3'] = '27';
				}
				
				//Positions
				$('#positionvaluefromjquery').empty();
				$('#positionvaluefromjquery').append('<p>Player:'+rowz['0']+'</p>');
				
				//Creating image in board.
				var img3 = document.createElement("img");
				img3.src = "images/download.png";
				img3.id = "playericon1";

				
		
				//Removing the image from previous position.
				if(rowz['2'] == '0'){
					//document.getElementById(rowz['3']).innerHTML = '';
					var element1 = document.getElementById('playericon1');
					element1.parentNode.removeChild(element1);
				}
				//Putting the image in the required position.
				document.getElementById(rowz['0']).appendChild(img3);
				//document.getElementById("static_dice").style.display="inline-block";
				
				//Reroll
				if( rowz['1'] == '1' || rowz['1'] == '5' || rowz['1'] == '6'  ){
					document.getElementById("rolling_dice").style.display="none";
					document.getElementById('instructions').innerHTML = "Reroll the dice";
					document.getElementById('static_dice').style.display = "inline-block";
					return false;
				}
				
				
				//Instructions 
				document.getElementById('instructions').innerHTML = "Computer is playing its turn . Please wait....";
				
				//To roll dice when computer moves.
				document.getElementById("rolling_dice").style.display="inline-block";
				rolldicec();
				
				
				
			}
			else{
				if( rowz['1'] == '1' || rowz['1'] == '5' || rowz['1'] == '6'  ){
					document.getElementById("rolling_dice").style.display="none";
					document.getElementById('instructions').innerHTML = "Reroll the dice...";
					
					document.getElementById('static_dice').style.display = "inline-block";
					return false;
				}
				
				//To roll dice when computer moves.
				document.getElementById("rolling_dice").style.display="inline-block";
				
				//Instructions 
				document.getElementById('instructions').innerHTML = "Computer is playing its turn . Please wait....";
		
				rolldicec();
				
			}
		}
		
		
		//Dice
		$('#dicevaluefromjquery').empty();
		$('#dicevaluefromjquery').append('<p>'+rowz['1']+'</p>');
		
		
		if(rowz['4'] == true){
			
			//Creating image in board.
			var img3 = document.createElement("img");
			img3.src = "images/download.png";
			img3.id = "playericon1";
		
			
		
			//Removing the image from previous position.
			//This removes everything even if another player image is in this position.TODO:Fix this.
			if(rowz['2'] == '0' && rowz['3'] != '0'){
				
				var element1 = document.getElementById('playericon1');
				element1.parentNode.removeChild(element1);
			}
			//Putting the image in the required position.
			document.getElementById(rowz['0']).appendChild(img3);
			
			if(rowz['5'] == '1'){
				//Removing the instructions upon winning the game.
				document.getElementById('instructions').innerHTML = "";
				
				$('#instructions').append('<p> You won the game.</p>');
				setTimeout(win,3000);
				
				//Return is used to prevent the execution of the following code because it stops the game upon winning.
				return 0;
			}
			
			setTimeout(Climb,2000);
			
			
			
		}
		else{
			var integer = parseInt(rowz['0'], 10);
			var required = 30 - integer;
			$('#comments').prepend('<br/>Player needs '+required+' to win.');
			if( rowz['1'] == '1' || rowz['1'] == '5' || rowz['1'] == '6'  ){
				
				document.getElementById('instructions').innerHTML = "Reroll the dice....";
				document.getElementById("rolling_dice").style.display="none";
				document.getElementById('static_dice').style.display = "inline-block";
				return false;
			}
				
			//Instructions 
			document.getElementById('instructions').innerHTML = "Please wait . Computer is playing its turn....";
			
			//To roll dice when computer moves.
			document.getElementById("rolling_dice").style.display="inline-block";
			
			rolldicec();
				
			
		}
		
		
		
		}//Checking if not first time.
	});
	
}
function rolldicec() {
	
	window.console && console.log('Requesting JSON');
	
	$.getJSON('rolldicecomputer.php', function(rowz){
		window.console && console.log('JSON Received'); 
		window.console && console.log(rowz);
		if(rowz['2'] == '0'){
		//Redirecting after win.
		function win(){
			location.replace("result.php")
		}
		
		
		
		function Climb(){
			
			//This is made in function to keep time between reaching ladder and climbing it.
			//Checking if the position is in ladder position.
			if(rowz['0'] == '3' || rowz['0'] == '5' || rowz['0'] == '11' || rowz['0'] == '20' || rowz['0'] == '17' || rowz['0'] == '19' || rowz['0'] == '21' || rowz['0'] == '27' ){
				
				
				if(rowz['0'] == '3'){
					$('#comments').prepend('<br/>Computer Climbing ladder....');
					rowz['0'] = '22';
					rowz['3'] = '3';
				}
				else if(rowz['0'] == '5'){
					$('#comments').prepend('<br/>Computer Climbing ladder....');
					rowz['0'] = '8';
					rowz['3'] = '5';
				}
				else if(rowz['0'] == '11'){
					$('#comments').prepend('<br/>Computer Climbing ladder....');
					rowz['0'] = '26';
					rowz['3'] = '11';
				}
				else if(rowz['0'] == '20'){
					$('#comments').prepend('<br/>Computer Climbing ladder....');
					rowz['0'] = '29';
					rowz['3'] = '20';
				}
				else if(rowz['0'] == '17'){
					$('#comments').prepend('<br/>Computer bitten by snake....');
					rowz['0'] = '4';
					rowz['3'] = '17';
				}
				else if(rowz['0'] == '19'){
					$('#comments').prepend('<br/>Computer bitten by snake....');
					rowz['0'] = '7';
					rowz['3'] = '19';
				}
				else if(rowz['0'] == '21'){
					$('#comments').prepend('<br/>Computer bitten by snake....');
					rowz['0'] = '9';
					rowz['3'] = '21';
				}
				else if(rowz['0'] == '27'){
					$('#comments').prepend('<br/>Computer bitten by snake....');
					rowz['0'] = '1';
					rowz['3'] = '27';
				}
				
				//Positions
				$('#positionvaluefromjquery2').empty();
				$('#positionvaluefromjquery2').append('<p>'+rowz['0']+'</p>');
				
				//Creating image in board.
				var img4 = document.createElement("img");
				img4.src = "images/king.jpg";
				img4.id="computericon1";

				
		
				//Removing the image from previous position.
				if(rowz['2'] == '0'){
					//document.getElementById(rowz['3']).innerHTML = '';
					var element2 = document.getElementById('computericon1');
					element2.parentNode.removeChild(element2);
				}
				//Putting the image in the required position.
				document.getElementById(rowz['0']).appendChild(img4);
				
				
				if( rowz['1'] == '1' || rowz['1'] == '5' || rowz['1'] == '6'  ){
					document.getElementById("rolling_dice").style.display="inline-block";
					document.getElementById('instructions').innerHTML = "Computer rerolling the dice . Please wait...";
					document.getElementById('static_dice').style.display = "none";
					return rolldicec();
				}
				
				//Check removing the rolling_dice after computer finishes the move.
				document.getElementById("rolling_dice").style.display="none";
				
				document.getElementById("static_dice").style.display="inline-block";
				
				document.getElementById('instructions').innerHTML = "Roll the dice...";
			}
			else{
				
				if( rowz['1'] == '1' || rowz['1'] == '5' || rowz['1'] == '6'  ){
					
					document.getElementById("rolling_dice").style.display="inline-block";
					document.getElementById('instructions').innerHTML = "Computer rerolling the dice . Please wait...";
					document.getElementById('static_dice').style.display = "none";
					return rolldicec();
				}
				
				//Check removing the rolling_dice after computer finishes the move.
				document.getElementById("rolling_dice").style.display="none";
				
				document.getElementById("static_dice").style.display="inline-block";
				
				document.getElementById('instructions').innerHTML = "Roll the dice...";
			}
		}
		
		
		//Dice
		$('#dicevaluefromjquery2').empty();
		$('#dicevaluefromjquery2').append('<p>'+rowz['1']+'</p>');
		
		
		if(rowz['4'] == true){
			
			
		
			//Check removing the rolling_dice after computer finishes the move.
			document.getElementById("rolling_dice").style.display="none";
		
			//Creating image in board.
			var img4 = document.createElement("img");
			img4.src = "images/king.jpg";
			img4.id = "computericon1";
			
			
		
			//Removing the image from previous position.
			if(rowz['2'] == '0' && rowz['3'] != '0'){
				//document.getElementById(rowz['3']).innerHTML = '';
				var element2 = document.getElementById('computericon1');
				element2.parentNode.removeChild(element2);
			}
			
			
			//Putting the image in the required position.
			document.getElementById(rowz['0']).appendChild(img4);
			
			if(rowz['5'] == '1'){
				//Removing the instructions upon winning the game.
				document.getElementById('instructions').innerHTML = "";
				
				$('#instructions').append('<p> Oops..You lost the game.</p>');
				setTimeout(win,3000);
				
				//Return is used to prevent the execution of the following code because it stops the game upon winning.
				return 0;
			}
			
			
			
			setTimeout(Climb,2000);
			
			
		}
		else{
			var integer = parseInt(rowz['0'], 10);
			var required = 30 - integer;
			$('#comments').prepend('<br/>Computer needs '+required+' to win.');
			if( rowz['1'] == '1' || rowz['1'] == '5' || rowz['1'] == '6'  ){
				//$('#comments').prepend('<br/>Computer needs '+required+' to win.');
				document.getElementById("rolling_dice").style.display="inline-block";
				document.getElementById('instructions').innerHTML = "Computer rerolling the dice . Please wait...";
				document.getElementById('static_dice').style.display = "none";
				return rolldicec();
			}
			//Check removing the rolling_dice after computer finishes the move.
			document.getElementById("rolling_dice").style.display="none";
			
		
			document.getElementById("static_dice").style.display="inline-block";
			document.getElementById('instructions').innerHTML = "Roll the dice...";
		}
		
		
		
		}
	});
	
}
// Make sure JSON requests are not cached
$(document).ready(function() {
  $.ajaxSetup({ cache: false });
  rolldice();
  rolldicec();
});
