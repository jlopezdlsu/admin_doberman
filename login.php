<?php session_start(); /* Starts the session */
include('dbcon.php');

require_once "vendor/autoload.php";

if(isset($_SESSION['UserData']['Username'])){
  header("location:index.php");
}

/* Check Login form submitted */
if(isset($_POST['Submit'])){
  /* Define username and associated password array */
  $basic  = new \Nexmo\Client\Credentials\Basic('220c329f', 'lEb5NS3N1mCqyGf1');
  $client = new \Nexmo\Client($basic);

  /* Check and assign submitted Username and Password to new variable */
  $Username = isset($_POST['Username']) ? $_POST['Username'] : '';
  $Password = isset($_POST['Password']) ? md5($_POST['Password']) : '';

  $query = "SELECT * FROM tbl_users WHERE username = '$Username' AND password = '$Password' AND userType = 1";
  $result = $con->query($query);
  /* Check Username and Password existence in defined array */
  if (mysqli_num_rows($result) > 0){
    $row = $result->fetch_assoc();
    /* Success: Set session variables and redirect to Protected page  */

    $code = substr(md5(uniqid(mt_rand(), true)) , 0, 4);
    $id = $row['userID'];
    $phoneNumber = $row['contactNumber'];

    $codeQuery = "UPDATE tbl_users SET loginCode = '$code' WHERE userID = '$id'";
    if($con->query($codeQuery)){

      if($phoneNumber){
        $message = $client->message()->send([
          'to' => $phoneNumber,
          'from' => 'Doberman',
          'text' => 'Your one-time password is '.$code
        ]);
        header("location:authenticate.php?s=".$id);
      }else{
        echo "Your mobile number is not registered with our system. Please contact the System Administrator";
      }

    }else{
      echo mysqli_error($con);
    }
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
