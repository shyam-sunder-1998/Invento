<?php 
	include ("../session.php");
	if(!isset($_SESSION)){
		session_start();
	}
	$query = "SELECT * from inbox where reciever='$login_user' ";
	$result = mysqli_query($connection,$query);
	$query1="SELECT * from inbox where read_msg=1 and reciever='$login_user'";
	$result1 = mysqli_query($connection,$query1);
	$roww=mysqli_num_rows($result1);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Inbox</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  	

</head>
<body onload="welcome()">
	<div class="container-fluid">
	<nav class="navbar navbar-default">
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
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Hey! &nbsp;<?php echo "$login_user"; ?></a></li>
					<li><a href="logout.php" id="logout">Logout</a></li>
				</ul>
			</div>
		</div>
	</nav><br/><br/>
		<div class="row">
			<div class="col-md-2">
				<a href="#" class="btn btn-danger btn-md btn-block" role="button" id="compose" onclick="open_compose()"><i class="glyphicon glyphicon-edit"></i>&nbsp;COMPOSE</a>
            <hr />
				<ul class="nav nav-pills nav-stacked">
    				<li class="active"><a href="#">Inbox<span id="unread" class="badge pull-right"><?php echo "$roww"; ?></span></a></li>
    				<li><a href="#">Sent Mail</a></li>
    				<li><a href="#">Trash</a></li>
    				<li><a href="#">Spam</a></li>
    				<li><a href="#">Starred</a></li>
  				</ul>
			</div>
			<div class="col-md-10">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#primary" data-toggle="tab"><i class="glyphicon glyphicon-inbox"></i>&nbsp;Primary</a></li>
					<li><a href="#social" data-toggle="tab"><i class="glyphicon glyphicon-user"></i>&nbsp;Social</a></li>
					<li><a href="#forums" data-toggle="tab"><i class="glyphicon glyphicon-retweet"></i>&nbsp;Forums</a></li>	
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="primary">
						<div class="list-group">
						<?php while( $row = mysqli_fetch_row($result)){ ?>
							<a href="#" class="list-group-item" id="<?php echo $row[0]; ?>" onclick="open_modal(this.id)">
								<span style="min-width: 140px; display: inline-block;"><?php echo $row[1]; ?></span>
								<span style="min-width: 140px; display: inline-block;"><?php echo $row[3]; ?></span>
								<span style="min-width: 140px; display: inline-block;" class="pull-right badge"><?php echo $row[5]; ?></span>
							</a>
						<?php } ?>
						</div>
					</div>
					<div class="tab-pane fade in" id="social">
                    <div class="list-group">
                        <div class="list-group-item">
                            <h4 class="text-center">This tab is empty..</h4>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade in" id="forums">
                    <div class="list-group">
                        <div class="list-group-item">
                            <h4 class="text-center">This tab is empty..</h4>
                        </div>
                    </div>
                </div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="mymodal" role="dialog">
    		<div class="modal-dialog modal-md">
      			<div class="modal-content">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Message</h4>
        			</div>
        		<div class="modal-body">
          			<strong>From:</strong><p id="from"></p><br />
            		<strong>Date:</strong><p id="date"></p><br />
            		<strong>Subject:</strong><p id="subject"></p><br />
            		<strong>Message:</strong><p id="msg"></p><br/>
        		</div>
        		<div class="modal-footer">
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      			</div>
    		</div>
  		</div>
		
		<div class="modal fade" id="modal_compose" role="dialog">
    		<div class="modal-dialog modal-md">
    		
      			<div class="modal-content">
        			<div class="modal-header">
          				<button type="button" class="close" data-dismiss="modal">&times;</button>
          				<h4 class="modal-title">Compose</h4>
        			</div>
        		<form action="send_mail.php" method="post" id="compose_form">	
        		<div class="modal-body">
					<div class="form-group" >
						<label for="from" class="sr-only">From</label>
						<input type="hidden" class="form-control" name="sender" id="from" value="<?=htmlspecialchars($login_user);?>">
					</div>
					<div class="form-group">
						<label for="to">To:</label>
						<input type="text"  class="form-control" name="reciever" id="to" >
					</div>
					<div class="form-group">
						<label for="subject">Subject:</label>
						<input type="text"  class="form-control" name="subj" id="subj" >
					</div>
					<div class="form-group">
						<label for="message">Message:</label>
						<textarea class="form-control" id="message" name="message" rows="6"></textarea>
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
		var success=0;
		function open_modal(id){
			var get_id=id;
			$.ajax({
				url:'fetch_msg_m.php',
				type:'post',
				dataType:'json',
				data:{
					'id':get_id ,
				},
				success: function(response){
					$('#mymodal').modal('show');
					$('#from').html(response[0]);
					$('#date').html(response[1]);
					$('#subject').html(response[2]);
					$('#msg').html(response[3]);	
					$('#unread').html(response[4]);	
				}
			});

		}
		
		function open_compose(){
			$('#modal_compose').modal('show');
		}

		function welcome(){
			responsiveVoice.speak("Welcome <?php echo "$login_user"; ?>, you are successfully logged in to your account");
			responsiveVoice.speak("You have <?php if($roww>0){echo "$roww";}else{echo "no";} ?> new messages");
			responsiveVoice.speak("Do you want to compose email or go to inbox?");
			frst_command();
		}

		function frst_command(){
			if (annyang) {
				var commands = {
					'compose': function() { $('#compose').click(); compose_sender(); annyang.abort();},
					'inbox': function()  { inbox_names(); annyang.abort();},
					'ok logout':function(){responsiveVoice.speak("Successfully Logged Out!"); document.getElementById('logout').click();},
				};
			annyang.debug(true);
			annyang.init(commands,true);
			annyang.addCommands(commands);
			annyang.start();
			}
		}
		var n= <?php echo "$roww"; ?>;
		var names=[];

		function inbox_names(){
			var i;
			$.ajax({
				url:'recieved_mails.php',
				type:'post',
				dataType: 'json',
				success: function(response){
					names=response;
					if(names.length>0){
						responsiveVoice.speak("You have recieved messages from");
						for(i=0;i<names.length;i++){
							responsiveVoice.speak(names[i]);
						}
						setTimeout(inbox_msg,4000);
					}
					else{
						responsiveVoice.speak("You have no new messages to be read");
					}
				}
			});
		}

		function update_names(name){
			var name=name.toLowerCase();
			var index=names.lastIndexOf(name);
			if(index>-1){
				names.splice(index,1);
				$.ajax({
					url:'update_read_msg.php',
					type:'post',
					data:{
					'del_name':name,
					},
					success:function(response){
						$('#unread').html(response);
					}
				});
			show_inbox(name);
			}
			else{
				responsiveVoice.speak("no messages from the said recipient.. please say again");
				inbox_msg();
			}
		}

		function inbox_msg(){
			if (annyang) {	
				var showFlickr = function(tag) {
    			  update_names(tag);
    			  annyang.abort();
    			}; 
    			var commands = {
      				'open *search':showFlickr,
      				'ok logout':function(){responsiveVoice.speak("Successfully Logged Out!"); document.getElementById('logout').click();},
    			};
    			annyang.debug();
    			annyang.init(commands,true);
    			annyang.addCommands(commands);
    			annyang.start();
  			}	
		}

		var sender,date,subject,message;
		function show_inbox(uname){
			$.ajax({
				url:'fetch_msg_v.php',
				type:'post',
				dataType:'json',
				data:{
					'del_msg':uname ,
				},
				success: function(response){
					if(response[0]!='null'){
						$('#mymodal').modal('show');
						$('#from').html(response[0]);
						$('#date').html(response[1]);
						$('#subject').html(response[2]);
						$('#msg').html(response[3]);
						sender=response[0];
						date=response[1];
						subject=response[2];
						message=response[3];
					}
				}
			});
			setTimeout(read_inbox,3000);
		}

		function read_inbox(){
			listen_commands1();
			responsiveVoice.speak("E-mail sent from.. "+sender);
			responsiveVoice.speak("Sent on.. "+date);
			responsiveVoice.speak("Reading the subject.. "+subject);
			responsiveVoice.speak("Reading the mail contents.. "+message);
		}

		function listen_commands1(){
			if(annyang){
				var commands={
					'ok back':function(){$('#mymodal').modal('hide');responsiveVoice.cancel();responsiveVoice.speak("Message terminated successfully");listen_commands2();annyang.abort();},
					'invento delete':function(){},
					'ok logout':function(){responsiveVoice.speak("Successfully Logged Out!"); document.getElementById('logout').click();},
				};
				annyang.debug();
				annyang.init(commands,true);
    			annyang.addCommands(commands);
    			annyang.start();
			}
		}
		
		function listen_commands2(){
			responsiveVoice.speak("If you want me to read all those sender\'s name say yes or say no for reading specific message");
			if(annyang){
				var commands={
					'yes':function(){inbox_names();annyang.abort();},
					'no':function(){inbox_msg();annyang.abort();},
					'ok logout':function(){responsiveVoice.speak("Successfully Logged Out!"); document.getElementById('logout').click();},
					'compose':function(){$('#compose').click();compose_sender();annyang.abort();}
				};
				annyang.debug();
				annyang.init(commands,true);
    			annyang.addCommands(commands);
    			annyang.start();
			}
		}

		var getname,newname;

		function compose_sender(){
			responsiveVoice.speak("Ready to compose.Enter recipient address");
			if (window.hasOwnProperty('webkitSpeechRecognition')) {
				var recognition=new webkitSpeechRecognition();
				recognition.lang = "en-IN";
				recognition.start();
				recognition.onresult = function(event) {
					if (event.results.length > 0) {
						getname= event.results[0][0].transcript;
						getname=getname.toLowerCase();
						recognition.stop();
						sender_check();
					}
			    }	
			}
			recognition.onend = function() {
				if(document.getElementById('to').value==''){
					responsiveVoice.speak('can\'t recognize. please say again');
					recognition.start();
				}
			}
		}

		function sender_check(){
			newname=getname.replace(/\s+/g, '');
			to.value=newname;
			responsiveVoice.speak("The email id you entered is"+newname);
			responsiveVoice.speak("If the entered email id is correct say yes, else no ");
			sender_options();
		}

		function sender_options(){
			if (annyang) {
				var commands = {
				'yes': function() { responsiveVoice.speak("E-mail id entered Successfully"); annyang.abort(); compose_subject();},
				'no': function()  { annyang.abort(); to.value=""; compose_sender();},
				'ok back': function() {$('#mymodal').modal('hide');window.location.reload();},
				'okback': function() {$('#mymodal').modal('hide');window.location.reload();},
				'ok logout':function(){responsiveVoice.speak("Successfully Logged Out!"); document.getElementById('logout').click();},
				};
			annyang.debug(true);
			annyang.init(commands,true);
			annyang.addCommands(commands);
			annyang.start();
			}
		}

		function compose_subject(){
			responsiveVoice.speak("say the subject of the mail..");
			if (window.hasOwnProperty('webkitSpeechRecognition')) {
				var recognition= new webkitSpeechRecognition();
				recognition.lang = "en-IN";
				recognition.start();
				recognition.onresult = function(event) {
					if (event.results.length > 0) {
						getname= event.results[0][0].transcript;
						getname=getname.toLowerCase();
						recognition.stop();
						subject_check();
					}
			    }	
			}
			recognition.onend = function() {
				if(document.getElementById('subj').value==''){
					responsiveVoice.speak('can\'t recognize. please say again');
					recognition.start();
				}
			}
		}

		function subject_check(){
			subj.value=getname;
			responsiveVoice.speak("The subject you entered is"+getname);
			responsiveVoice.speak("If the entered subject is correct say yes, else no ");
			subject_options();
		}

		function subject_options(){
			if (annyang) {
				var commands = {
				'yes': function() { responsiveVoice.speak("subject entered Successfully"); annyang.abort(); compose_message();},
				'no': function()  { responsiveVoice.speak("please say again"); annyang.abort(); subj.value=""; compose_subject();},
				'ok back': function(){$('#mymodal').modal('hide');window.location.reload();},
				'okback': function() {$('#mymodal').modal('hide');window.location.reload();},
				'ok logout':function(){responsiveVoice.speak("Successfully Logged Out!"); document.getElementById('logout').click();},
				};
			annyang.debug(true);
			annyang.init(commands,true);
			annyang.addCommands(commands);
			annyang.start();
			}
		}

		function compose_message(){
			responsiveVoice.speak("say the body of the mail");
			if (window.hasOwnProperty('webkitSpeechRecognition')) {
				var recognition=new webkitSpeechRecognition();
				recognition.continuous=true;
				recognition.lang = "en-IN";
				recognition.start();
				recognition.onresult = function(event) { 
					for (var j = event.resultIndex; j < event.results.length; ++j) {
						if (event.results[j].isFinal) {
							string=event.results[j][0].transcript;
							string=string.toLowerCase();
							var dot=string.indexOf('ok period');
							var send=string.indexOf('ok send');
							var back=string.indexOf('ok back');
							var terminate=string.indexOf('ok period');
							if(dot>-1){
          						document.getElementById('message').value +='.';
          					}
          					else if(terminate>-1){
          						$('#modal_compose').modal('hide');
          						document.getElementById('to').value="";
          						document.getElementById('subj').value="";
          						document.getElementById('message').value="";
          					}
          					else if(send>-1){
          						document.forms['compose_form'].submit();
          					}
          					else if(back>-1){
          						window.location.reload();
          					}
          					else{
          						document.getElementById('message').value += string;
          					}
        				}
        					
      				}
			    }	
			}
			recognition.onend = function() {
				recognition.start();
			}
		}
	</script>
	<script src="responsive.js"></script>
  	<script src="annyang.js"></script>
	<script src="bootstrap/js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html> 