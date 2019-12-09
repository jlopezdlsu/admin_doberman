<?php session_start(); /* Starts the session */
include('dbcon.php');
require_once "vendor/autoload.php";

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}


//REFERENCE ['processing'=>1,'for delivery'=>'2',delivered => '3','completed'=>'4']
if(isset($_GET['p'])){
  $orderID = $_GET['p'];

  $query = "UPDATE tbl_order SET orderStatus = IFNULL(orderStatus, 0) + 1 WHERE orderID = '$orderID'";
  if($con->query($query)){

    $selectQuery = "SELECT * from tbl_order LEFT JOIN tbl_users ON tbl_order.buyerID = tbl_users.userID WHERE tbl_order.orderID = '$orderID'";
    $result = $con->query($selectQuery);
    $row = $result->fetch_assoc();

    //IF STATUS IS DELIVERED
    if($row['orderStatus'] == 3){
      $basic  = new \Nexmo\Client\Credentials\Basic('220c329f', 'lEb5NS3N1mCqyGf1');
      $client = new \Nexmo\Client($basic);
      $buyerNumber = $row['contactNumber'];
      if($buyerNumber){
        $message = $client->message()->send([
          'to' => '639173038184',
          'from' => 'Doberman',
          'text' => 'Your package with order #'.$row['orderID'] .' has been delivered.'
        ]);
      }

    }

    $_SESSION['status_sucess'] = "Status successfully updated";
    header("location: orders.php");
  }
}

?>
