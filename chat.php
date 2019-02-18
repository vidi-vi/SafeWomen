
<!DOCTYPE html>
<html>
        <head>
		<title>Safe Women</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
                <script
  src="http://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

<script>

function submitChat() {
	if(form1.uname.value == '' || form1.msg.value == '') {
		alert("ALL FIELDS ARE MANDATORY!!!");
		return;
	}
	var uname = form1.uname.value;
	var msg = form1.msg.value;
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('chatlogs').innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET','insert.php?uname='+uname+'&msg='+msg,true);
	xmlhttp.send();
	form1.msg.value = '';
}

$(document).ready(function(e){
	$.ajaxSetup({
		cache: false
	});
	$( "#msg_area" ).keyup(function(e) {
		  var code = e.keyCode || e.which;
		 if(code == 13) { //Enter keycode
		   submitChat();
		 }
	});
	setInterval( function(){ $('#chatlogs').load('logs.php'); }, 2000 );
});

</script>

	</head>
    <body>
        <?php require_once 'header.php'; ?>
        <?php require_once 'menu.php'; ?>
        <div id="content">
            <br>
            <br>
            <br>
            <br>
            <h2 align="center">Chat Box</h2>
            <form name="form1" class="center">
Enter Your Chatname: <input type="text" name="uname" /> <br />
Your Message: <br />
<textarea id="msg_area" name="msg"></textarea><br />
<button onclick="submitChat()">Send</button><br /><br />
</form>
<div align="center" id="chatlogs">
LOADING CHATLOG...
</div>
           
        </div>
        <?php require_once 'footer.php'; ?>
    </body>
</html>

