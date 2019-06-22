<?php

if(isset($_POST['username'],$_POST['password'])){
	$uname = $_POST['username'];
	$pwd = $_POST['password'];
	if($uname == 'admin' && $pwd == 'admin'){
		echo '<h3 style="color:#9C61A2; padding-top: 40px">Successfully logged in</h1>';
		session_start();
		
		$myfile = fopen("Tokens.txt", "w") or die("Unable to open file!");
		
		$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
		$txt = $_SESSION['token'].",";
		fwrite($myfile, $txt);
		
		$session_id = session_id();
		setcookie('sessionCookie',$session_id,time()+ 60*60*24*365 ,'/');
		//echo $_COOKIE['sessionCookie'];
		//echo '<br>';
		//echo $_SESSION['token'];
		$txt1 = $session_id."\n";
		fwrite($myfile, $txt1);
		
		fclose($myfile);
	}
	else{
		echo 'Invalid Credentials';
		exit();
	}
}
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Cross Site Request Forgery Protection</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="style.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script>
	$(document).ready(function () {
		 $.ajax({
		 url: 'csrf_token.php',
		 type: 'post',
		 async: false,
					 data: {
						 //pass login session to validate request with the server
						 csrf_request: "<?php echo $_COOKIE['sessionCookie'] ?>"  
					 },
					 success: function (data) {
		 //alert(data);
						   //set returned token to hidden field value
						 document.getElementById("token_to_be_added").value = data;
						 $("#token_to_be_added").text(data);
					 },
					 error: function (xhr, ajaxOptions, thrownError) {
						 console.log("Error on Ajax call :: " + xhr.responseText);
					 }
				 });
			 });
</script>
	</head>
	<body>
		<div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div class="box">
                    <div class="shape1"></div>
                    <div class="shape2"></div>
                    <div class="shape3"></div>
                    <div class="shape4"></div>
                    <div class="shape5"></div>
                    <div class="shape6"></div>
                    <div class="shape7"></div>
                    <div class="float">
					
					<!--form-->
                      <form class="form" action="home.php" method="post">
                            <div class="form-group">
                                <label style="color:white; padding-top: 40px" for="username" class="text-white"><h4>Write Something<h4></label><br>
                                <input type="text" name="updatepost" class="form-control">
                            </div>
                            <div id="div1">
					              <input type="hidden" name="token" value="" id="token_to_be_added"/>
					        </div>
                            <div class="form-group">
                                <center><input type="submit"  class="btn btn-info btn-md" value="update" style="background-color:#9C61A2"></center>
                            </div>
                      </form>
					  
                    </div>
                </div>
            </div>
        </div>
    </div>

	</body> 
</html>
