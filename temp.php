<html>
<head>
	<script src='responsive.js'></script>
</head>
<body onload="first()">
	<script type="text/javascript">
		function first(){
		responsiveVoice.speak("Please check your login credentials");
	}
		setTimeout(move,3000);
		function move(){
			window.location="http://localhost/email/login.html";
		}
	</script>
</body>
</html>