<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/12fc28d7cb.js"></script>

  <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">

  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php @include('sidebar.php') ?>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 font-weight-bold">Inventory</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <?php include('dbcon.php') ?>

            <?php

            if(isset($_POST['delete'])){
              if(!empty($_POST['select'])) {
                echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                Successfully deleted selected item(s).
                </div>";
              }
            }

            //REFERENCE ['processing'=>1,'for delivery'=>'2',delivered => '3','completed'=>'4']
            $statusArray = ['Paid','Processing','Ready for Delivery','Delivered','Completed'];
            $statusArrayBtn = ['Process Now','Deliver','Delivered','Completed','Completed'];

            $merchantID = $_SESSION['UserData']['UserID'];
            $sqlProducts = "SELECT
            tbl_product.productName,tbl_product.price,tbl_product.productID,tbl_product.shortDescription,
            tbl_order.orderID,tbl_order.productID,tbl_order.buyerID, tbl_order.paymentID,tbl_order.quantity,tbl_order.orderStatus,
            tbl_productimg.imgSource,tbl_productimg.imgName,tbl_productimg.productID
            FROM tbl_order
            LEFT JOIN tbl_product ON tbl_product.productID=tbl_order.productID
            INNER JOIN tbl_productimg ON tbl_product.productID=tbl_productimg.productID
            WHERE tbl_product.merchantID = '$merchantID' AND  (tbl_order.orderStatus < 4 OR tbl_order.orderStatus is null) AND tbl_order.paymentID IS NOT NULL";

            $resultProducts = $con->query($sqlProducts);
            echo "
            <div class='card'>
            <div class='card-body'>
            <table border='1' class='table table-bordered table-responsive'>
            <thead>
            <tr>
            <th scope='col'>Order ID</th>
            <th scope='col'>Image</th>
            <th scope='col'>Item Name</th>
            <th scope='col'>Short Description</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Price</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Total Price</th>
            <th scope='col'>Status</th>
            <th scope='col'></th>
            </tr>
            </thead>
            <tbody>
            ";
            if (mysqli_num_rows($resultProducts) > 0) {

              while($row = $resultProducts->fetch_assoc()) {
                echo "
                <tr>
                <td>
                ".$row['orderID']."
                </td>
                <td style='padding:5px'>
                <img src='image/".$row['imgName']."' length='80' width='80' alt='".$row['productID']."'><br><br>
                </td>
                <td>
                ".$row['productName']."
                </td>
                <td>
                ".$row['shortDescription']."
                </td>
                <td>
                ".$row['quantity']."
                </td>
                <td>
                ".$row['price']."
                </td>
                <td>
                ".$row['quantity']."
                </td>
                <td>
                PHP ".number_format($row['quantity'] * $row['price'],2)."
                </td>
                <td>
                ".$statusArray[$row['orderStatus'] ? $row['orderStatus'] : 0 ]."
                </td>
                <td>
                <a class='btn btn-primary' href='orderStatus.php?p=".$row['orderID']."'>".$statusArrayBtn[$row['orderStatus'] ? $row['orderStatus'] : 0 ]."</a>

                </td>

                </tr>
                ";
              }
              echo "
              </tbody>
              <br>
              </table>
              </div>
              </div>

              ";
            }

            $sqlDelivered = "SELECT
            tbl_product.productName,tbl_product.price,tbl_product.productID,tbl_product.shortDescription,
            tbl_order.orderID,tbl_order.productID,tbl_order.buyerID, tbl_order.paymentID,tbl_order.quantity,tbl_order.orderStatus,
            tbl_productimg.imgSource,tbl_productimg.imgName,tbl_productimg.productID
            FROM tbl_order
            LEFT JOIN tbl_product ON tbl_product.productID=tbl_order.productID
            INNER JOIN tbl_productimg ON tbl_product.productID=tbl_productimg.productID
            WHERE tbl_product.merchantID = '$merchantID' AND  tbl_order.orderStatus = 4 AND tbl_order.paymentID IS NOT NULL";

            $resultDelivered = $con->query($sqlDelivered);
            echo "
            <div class='card'>
            <div class='card-body'>
            <table border='1' class='table table-bordered table-responsive'>
            <thead>
            <tr>
            <th scope='col'>Order ID</th>
            <th scope='col'>Image</th>
            <th scope='col'>Item Name</th>
            <th scope='col'>Short Description</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Price</th>
            <th scope='col'>Quantity</th>
            <th scope='col'>Total Price</th>
            <th scope='col'>Status</th>
            </tr>
            </thead>
            <tbody>
            ";
            if (mysqli_num_rows($resultDelivered) > 0) {

              while($row = $resultDelivered->fetch_assoc()) {
                echo "
                <tr>
                <td>
                ".$row['orderID']."
                </td>
                <td style='padding:5px'>
                <img src='image/".$row['imgName']."' length='80' width='80' alt='".$row['productID']."'><br><br>
                </td>
                <td>
                ".$row['productName']."
                </td>
                <td>
                ".$row['shortDescription']."
                </td>
                <td>
                ".$row['quantity']."
                </td>
                <td>
                ".$row['price']."
                </td>
                <td>
                ".$row['quantity']."
                </td>
                <td>
                PHP ".number_format($row['quantity'] * $row['price'],2)."
                </td>
                <td>
                ".$statusArray[$row['orderStatus'] ? $row['orderStatus'] : 0 ]."
                </td>


                </tr>
                ";
              }
              echo "
              </tbody>
              <br>
              </table>
              </div>
              </div>

              ";
            }

            $con->close();
            ob_end_flush();
            ?>
          </div>
        </center>
      </main>
    </div>
  </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" rossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

<script type="text/javascript">
$(document).ready(function($) {
  $(".table-row").click(function() {
    window.document.location = $(this).data("href");
  });
  $('table').DataTable({
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excelHtml5',
        title: 'Orders'
      },
      {
        extend: 'pdfHtml5',
        title: 'Orders'
      }
    ]
  });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
