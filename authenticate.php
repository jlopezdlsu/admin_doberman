<?php session_start(); /* Starts the session */
include('dbcon.php');


if(isset($_SESSION['UserData']['Username'])){
  header("location:index.php");
}
if(isset($_POST['submit'])){
  /* Define username and associated password array */


  /* Check and assign submitted Username and Password to new variable */
  $id = $_GET['s'];
  $code = $_POST['code'];

  $query = "SELECT * FROM tbl_users WHERE userID = '$id' AND loginCode = '$code'";
  $result = $con->query($query);
  /* Check Username and Password existence in defined array */
  if (mysqli_num_rows($result) > 0){
    $row = $result->fetch_assoc();

    $query2 = "UPDATE tbl_users SET loginCode = null WHERE userID = '$id'";

    if($con->query($query2)){
      /* Success: Set session variables and redirect to Protected page  */
      $_SESSION['UserData']['Username']= $row['username'];
      $_SESSION['UserData']['UserID'] =$row['userID'];

      header("location:index.php");
    }

    exit;
  } else {
    /*Unsuccessful attempt: Set error message */
    $msg="<span style='color:red'>Invalid Code</span>";
  }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </head>
  <body style="background:#003b63;">
    <div class="col-lg-4" style="margin:auto;padding-top:10%;">
      <form method="post" class="text-center border border-light p-5"  style="background:white;">
        <p class="h4 mb-4" style="color:#003b63;">Authenticate</p>
        <input type="text" name="code" value=""  class="form-control mb-4 text-center" >
        <input type="submit" name="submit" value="Submit" class="btn btn-info btn-block my-4" style="background:#003b63 !important;">
      </form>
    </div>
  </body>

</html>
