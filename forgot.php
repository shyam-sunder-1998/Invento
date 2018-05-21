<html>
	<head>
		<title>Login Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="login.css">
  
  <script src='responsive.js'></script>
  <script src='annyang.js'></script>
  <script src="bootstrap/js/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>

	</head>
	<body onload="fwelcome()">
		
		<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>                        
				</button>
				<img class="img-thumbnail" src="images/ic1.png" alt="logo">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="navbar-brand" href="#">Invento</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">FAQ</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="form-signin">
					<form method="post" action="email.php" name="forget">
						<center><h1 class="display-4">Forget Password?</h1></center>
						<div class="form-group">
							<label for="funame" class="sr-only">Username</label>
							<input type="text" id="funame" class="form-control input-lg" name="funame" placeholder="Username" required />
						</div>
						<div class="form-group">
							<label for="fques" class="sr-only">Secuity Question</label>
							<input type="text" id="fques" class="form-control input-lg" name="fques" placeholder="Security Question" required />
						</div>
						<div class="form-group">
							<label for="fans" class="sr-only">Secuity Answer</label>
							<input type="text" id="fans" class="form-control input-lg" name="fans" placeholder="Security Answer" required />
						</div>
						<button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button><br/>
						<br/><br/><br/><br/><br/>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal_forget" role="dialog">
    		<div class="modal-dialog modal-md">
      			<div class="modal-content">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Change Password</h4>
        			</div>
        		<form action="submit_pass.php" method="post" id="forgot">	
        		<div class="modal-body">
        			<div class="form-group">
						<label for="fcname" class="sr-only">Username</label>
						<input type="hidden"  class="form-control" name="fcname" id="fcname">
					</div>
					<div class="form-group" >
						<label for="fpass">Password</label>
						<input type="text" class="form-control" name="fpass" id="fpass">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
        		</div>
        		</form>
        		<div class="modal-footer">
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      			</div>
      			
    		</div>
  		</div>
	</div>

	<script type="text/javascript">

	    function fwelcome(){
	    	responsiveVoice.speak("enter your usename to get the security question");
	    	setTimeout(fusername,5000);
	    }
		var flag=0;
		function fusername(){
			if (window.hasOwnProperty('webkitSpeechRecognition')) 
				var recognition=new webkitSpeechRecognition();
				recognition.lang = "en-IN";
				recognition.start();
				recognition.onresult = function(event) {
					if (event.results.length > 0) {
						getname= event.results[0][0].transcript;
						getname=getname.toLowerCase();
						funame.value=getname;
						recognition.stop();
						if(flag==0){
							fread_check();
						}
						else{
							fspell_check();
						}
						
					}
				}	
			
			recognition.onend = function() {
				if(document.getElementById('funame').value==''){
					responsiveVoice.speak('can\'t recognize. please say again');
					recognition.start();
				}
			}
		}

		function fread_check(){
			var newname=getname.split('').join(' ');
			responsiveVoice.speak("The name you entered is.."+newname);
			responsiveVoice.speak("If the entered username is correct say yes, else no ");
			flag=1;
			funame_options();
		}
		
		function fspell_check(){
			newname=getname.replace(/\s+/g, '');
			responsiveVoice.speak("The name you entered is.."+newname);
			funame.value= newname;
			responsiveVoice.speak("If the entered username is correct say yes, else no");
			funame_options();
		}
		
		function funame_options(){
			if (annyang) {
				var commands = {
				'yes': function() { responsiveVoice.speak("Username entered Successfully"); annyang.abort(); fetch_fques(funame.value);},
				'no': function()  { responsiveVoice.speak("please spell again"); annyang.abort(); funame.value=""; fusername();},
				};
			annyang.debug(true);
			annyang.init(commands,true);
			annyang.addCommands(commands);
			annyang.start();
			}
		} 

		function fetch_fques(ffuname){
			$.ajax({
				url:'fetch_fques.php',
				type:'post',
				data:{
					'refer_name':ffuname,
				},
				success:function(response){
					var response = $.trim(response);
					console.log(response);
					if(response=='no'){
						responsiveVoice.speak("The username you entered is not valid....please say again");
						fusername();
					}
					else{
						fques.value=response;
						responsiveVoice.speak(response);	
						responsiveVoice.speak("say your security answer now..");
						setTimeout(get_fans,4000);
					}

				},
			});	
		}

		function get_fans(){
				if (window.hasOwnProperty('webkitSpeechRecognition')) 
				var recognition1=new webkitSpeechRecognition();
				recognition1.lang = "en-IN";
				recognition1.start();
				recognition1.onresult = function(event) {
					if (event.results.length > 0) {
						getname= event.results[0][0].transcript;
						getname=getname.toLowerCase();
						fans.value=getname;
						recognition1.stop();
						if(flag==0){
							fans_read_check();
						}
						else{
							fans_spell_check();
						}
						
					}
				}	
			
			recognition1.onend = function() {
				if(document.getElementById('fans').value==''){
					responsiveVoice.speak('can\'t recognize. please say again');
					recognition1.start();
				}
			}

		}

        function fans_read_check(){
			var newname=getname.split('').join(' ');
			responsiveVoice.speak("The answer you entered is.."+newname);
			responsiveVoice.speak("If the entered answer is correct say yes, else no ");
			flag=1;
			fans_options();
		}
		
		function fans_spell_check(){
			newname=getname.replace(/\s+/g, '');
			responsiveVoice.speak("The answer you entered is.."+newname);
			fans.value= newname;
			responsiveVoice.speak("If the entered answer is correct say yes, else no");
			fans_options();
		}
		
		function fans_options(){
			if (annyang) {
				var commands = {
				'yes': function() { responsiveVoice.speak("Checking the entered answer"); annyang.abort();check_fans(fans.value);},
				'no': function()  { responsiveVoice.speak("please say again"); annyang.abort(); fans.value=""; get_fans();},
				};
			annyang.debug(true);
			annyang.init(commands,true);
			annyang.addCommands(commands);
			annyang.start();
			}
		} 

		function check_fans(ffans){
			var final_name=funame.value
			$.ajax({
				url:'fetch_fans.php',
				type:'post',
				data:{
					'refer_uname':final_name,
					'refer_ans':ffans,
				},
				success:function(response){
					if(response==0){
						responsiveVoice.speak("The answer you entered is invalid....please say again");
						get_fans();
					}
					else if(response==1){
						responsiveVoice.speak("Checking success..");
						$('#modal_forget').modal('show');
						openmodal();
					}

				},
			});	

		}

		function openmodal(){
			$('#modal_forget').modal('show');
			responsiveVoice.speak("enter your password");
			fcname.value=funame.value;
			change_pass();
		}

		function change_pass(){
			if (window.hasOwnProperty('webkitSpeechRecognition')) 
				var recognition=new webkitSpeechRecognition();
				recognition.lang = "en-IN";
				recognition.start();
				recognition.onresult = function(event) {
					if (event.results.length > 0) {
						getname= event.results[0][0].transcript;
						getname=getname.toLowerCase();
						fpass.value=getname;
						recognition.stop();
						if(flag==0){
							cpass_check();
						}
						else{
							cpass_spell();
						}
						
					}
				}	
			
			recognition.onend = function() {
				if(document.getElementById('fpass').value==''){
					responsiveVoice.speak('can\'t recognize. please say again');
					recognition.start();
				}
			}

		}

		function cpass_check(){
			var newname=getname.split('').join(' ');
			responsiveVoice.speak("The password you entered is.."+newname);
			responsiveVoice.speak("If the entered password is correct say yes, else no ");
			flag=1;
			fpass_options();
		}
		
		function cpass_spell(){
			newname=getname.replace(/\s+/g, '');
			responsiveVoice.speak("The password you entered is.."+newname);
			fpass.value= newname;
			responsiveVoice.speak("If the entered password is correct say yes, else no");
			fpass_options();
		}

		function fpass_options(){
			if (annyang) {
				var commands = {
				'yes': function() { responsiveVoice.speak("Password updated Successfully"); annyang.abort();document.forms["forgot"].submit();  },
				'no': function()  { responsiveVoice.speak("please spell again"); annyang.abort(); fpass.value=""; change_pass();},
				};
			annyang.debug(true);
			annyang.init(commands,true);
			annyang.addCommands(commands);
			annyang.start();
			}
		} 
	
	</script>



	</body>
</html>