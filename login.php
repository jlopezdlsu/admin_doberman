<?php session_start(); /* Starts the session */
if(isset($_SESSION['UserData']['Username'])){
  header("location:index.php");
}

	/* Check Login form submitted */
	if(isset($_POST['Submit'])){
		/* Define username and associated password array */
		$logins = array('bruce_wayne' => 'D@m1AnW@yN3');

		/* Check and assign submitted Username and Password to new variable */
		$Username = isset($_POST['Username']) ? $_POST['Username'] : '';
		$Password = isset($_POST['Password']) ? $_POST['Password'] : '';

		/* Check Username and Password existence in defined array */
		if (isset($logins[$Username]) && $logins[$Username] == $Password){
			/* Success: Set session variables and redirect to Protected page  */
			$_SESSION['UserData']['Username']=$logins[$Username];
			header("location:index.php");
			exit;
		} else {
			/*Unsuccessful attempt: Set error message */
			$msg="<span style='color:red'>Invalid Login Details</span>";
		}
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>The Riddler</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<body style="background:#003b63;">
	<!-- Default form login -->
	<div class="col-lg-4" style="margin:auto;padding-top:10%;">
		<form class="text-center border border-light p-5" method="post" name="Login_Form" style="background:white;">
				<p class="h4 mb-4" style="color:#003b63;">Sign in</p>
				<?php if(isset($msg)){?>
		    <tr>
		      <td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
		    </tr>
		    <?php } ?>

				<!-- Email -->
				<input type="text" class="form-control mb-4" placeholder="Username" name="Username">

				<!-- Password -->
				<input type="password" class="form-control mb-4" placeholder="Password" name="Password">

				<!-- Sign in button -->
				<input name="Submit" type="submit" value="Login" class="btn btn-info btn-block my-4" style="background:#003b63 !important;">



		</form>
	</div>

</body>
</html>
