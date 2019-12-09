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
  </head>
  <body>
    <form method="post">
      <input type="text" name="code" value="">
        <input type="submit" name="submit" value="Submit">
    </form>
  </body>
</html>
