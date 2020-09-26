
function roll() {
	var x = document.getElementById("static_dice");
	var y = document.getElementById("rolling_dice");
	if (x.style.display === "none") {
		x.style.display = "inline-block";
		y.style.display = "none";
	} else {
		x.style.display = "none";
		y.style.display = "inline-block";
	}
	setTimeout(function () {
        if (x.style.display == "none") {
            x.style.display = "inline-block";
			y.style.display = "none";
        }
		}, 1000
	);
	
}
function rolldice() {
	window.console && console.log('Requesting JSON'); 
	$.getJSON('rolldice.php', function(rowz){
		window.console && console.log('JSON Received'); 
		window.console && console.log(rowz);
		if(rowz['2'] == '0'){
		//Redirecting after win.
		function win(){
			location.replace("result.php")
		}
		if(rowz['5'] == '1'){
			$('#result').append('<p>win</p>'+rowz['5']);
			setTimeout(win,5000);
		}
		//document.getElementById('comments').innerHTML = rowz['6'];
		//Dice
		//$('#dicevaluefromjquery').empty();
		$('#dicevaluefromjquery').append('<p>'+rowz['1']+'</p>');
		
		
		if(rowz['4'] == true){
			
			$('#comments').append('entered true,  ');
			//Positions
			//$('#positionvaluefromjquery').empty();
			$('#positionvaluefromjquery').append('<p>'+rowz['0']+'</p>');
		
			//Creating image in board.
			var img3 = document.createElement("img");
			img3.src = "images/download.png";
		
			//Putting the image in the required position.
			document.getElementById(rowz['0']).appendChild(img3);
		
			//Removing the image from previous position.
			if(rowz['2'] == '0' && rowz['3'] != '0'){
				document.getElementById(rowz['3']).innerHTML = '';
			}
		
			$('#comments').append(', check ,');
		
			//Checking if the position is in ladder position.
			if(rowz['0'] == '3' || rowz['0'] == '5' || rowz['0'] == '11' || rowz['0'] == '20' || rowz['0'] == '17' || rowz['0'] == '19' || rowz['0'] == '21' || rowz['0'] == '27' ){
				
				$('#comments').append('entered ladder \n ');
				if(rowz['0'] == '3'){
					$('#comments').append('| 3 |');
					
					rowz['0'] = '22';
					rowz['3'] = '3';
					
				}
				else if(rowz['0'] == '5'){
					rowz['0'] = '8';
					rowz['3'] = '5';
				}
				else if(rowz['0'] == '11'){
					rowz['0'] = '26';
					rowz['3'] = '11';
				}
				else if(rowz['0'] == '20'){
					rowz['0'] = '29';
					rowz['3'] = '20';
				}
				else if(rowz['0'] == '17'){
					rowz['0'] = '4';
					rowz['3'] = '17';
				}
				else if(rowz['0'] == '19'){
					rowz['0'] = '7';
					rowz['3'] = '19';
				}
				else if(rowz['0'] == '21'){
					rowz['0'] = '9';
					rowz['3'] = '21';
				}
				else if(rowz['0'] == '27'){
					rowz['0'] = '1';
					rowz['3'] = '27';
				}
				
				//Positions
				$('#positionvaluefromjquery').empty();
				$('#positionvaluefromjquery').append('<p>'+rowz['0']+'</p>');
				
				//Creating image in board.
				var img3 = document.createElement("img");
				img3.src = "images/download.png";

				//Putting the image in the required position.
				document.getElementById(rowz['0']).appendChild(img3);
		
				//Removing the image from previous position.
				if(rowz['2'] == '0'){
					document.getElementById(rowz['3']).innerHTML = '';
				}
			}
			else{
				$('#comments').append('Did not enter ladder,because position=  ');
				$('#comments').append(rowz['0']);
			}
		}
		else{
			$('#comments').append('entered false,  ');
		}
		
		//setTimeout(ClimbOrGetDown,5000);
		
		}
	});
}
// Make sure JSON requests are not cached
$(document).ready(function() {
  $.ajaxSetup({ cache: false });
  rolldice();
});
