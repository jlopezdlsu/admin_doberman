<?php session_start(); /* Starts the session */
include('dbcon.php');

if(!isset($_SESSION['UserData']['Username'])){
  header("location:login.php");
  exit;
}


$merchantID = $_SESSION['UserData']['UserID'];

$query = "SELECT SUM(tbl_payment.total) as total FROM tbl_order INNER JOIN tbl_payment ON tbl_payment.paymentID = tbl_order.paymentID LEFT JOIN tbl_product ON tbl_order.productID = tbl_product.productID WHERE tbl_product.merchantID = '$merchantID' AND  MONTH(tbl_payment.date_created) = MONTH(CURRENT_DATE())
AND YEAR(tbl_payment.date_created) = YEAR(CURRENT_DATE())";
$results = $con->query($query);
$total = mysqli_fetch_assoc($results);

$query2 = "SELECT COUNT(tbl_product.merchantID) as products FROM tbl_product WHERE tbl_product.merchantID = '$merchantID'";
$results2 = $con->query($query2);
$product = mysqli_fetch_assoc($results2);

$query3 = "SELECT SUM(tbl_payment.total) as total FROM tbl_order INNER JOIN tbl_payment ON tbl_payment.paymentID = tbl_order.paymentID LEFT JOIN tbl_product ON tbl_order.productID = tbl_product.productID";
$results3 = $con->query($query3);
$monthlyTotal = mysqli_fetch_assoc($results3);


//SALES PER MONTH
$query4 = "SELECT DATE_FORMAT(tbl_payment.date_created, '%b') AS Month, SUM(tbl_payment.total) as total FROM tbl_order INNER JOIN tbl_payment ON tbl_payment.paymentID = tbl_order.paymentID LEFT JOIN tbl_product ON tbl_order.productID = tbl_product.productID WHERE tbl_product.merchantID = '$merchantID' GROUP BY dATE_FORMAT(tbl_payment.date_created, '%m-%Y')";
$results4 = $con->query($query4);

//TOP Category

$query6 = "SELECT tbl_category.categoryName, SUM(tbl_payment.total) as total FROM tbl_order INNER JOIN tbl_payment ON tbl_payment.paymentID = tbl_order.paymentID LEFT JOIN tbl_product ON tbl_order.productID = tbl_product.productID LEFT JOIN tbl_category ON tbl_product.categoryID = tbl_category.categoryID WHERE tbl_product.merchantID = '$merchantID' GROUP BY tbl_product.categoryID";
$results6 = $con->query($query6);



//TOP PRODUCTS

$query5 = "SELECT tbl_product.productName,SUM(tbl_order.quantity) as total FROM tbl_order INNER JOIN tbl_payment ON tbl_payment.paymentID = tbl_order.paymentID LEFT JOIN tbl_product ON tbl_order.productID = tbl_product.productID LEFT JOIN tbl_category ON tbl_product.categoryID = tbl_category.categoryID WHERE tbl_product.merchantID = '$merchantID' GROUP BY tbl_order.productID";
$results5 = $con->query($query5);
//  $topProducts = mysqli_fetch_assoc($results5);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/12fc28d7cb.js"></script>
  <link rel="stylesheet" href="assets/css/style.css">

  <style>
  .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  @media (min-width: 768px) {
    .bd-placeholder-img-lg {
      font-size: 3.5rem;
    }
  }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php @include('sidebar.php') ?>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 font-weight-bold">Dashboard</h1>
        </div>
        <div class="row">
          <div class="col-6 col-lg-6 col-xl">

            <!-- Card -->
            <div class="card card-cebuana">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-cebuana-red font-weight-bold mb-2">
                      Income this Month
                    </h6>

                    <!-- Heading -->
                    <span class="h2 text-white mb-0">
                      ₱ <?php echo number_format($monthlyTotal['total'],2) ?>
                    </span>



                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <span class="h2 fe fe-dollar-sign text-cebuana-red mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>

          </div>
          <div class="col-6 col-lg-6 col-xl">

            <!-- Card -->
            <div class="card card-cebuana">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-cebuana-red font-weight-bold mb-2">
                      Number of Products

                    </h6>

                    <!-- Heading -->
                    <span class="h2 text-white mb-0">
                      <?php echo number_format($product['products']) ?>
                    </span>

                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <span class="h2 text-white fe fe-briefcase text-muted mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>

          </div>
          <div class="col-6 col-lg-6 col-xl">

            <!-- Card -->
            <div class="card card-cebuana">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-cebuana-red font-weight-bold mb-2">
                      Number of Products
                    </h6>

                    <div class="row align-items-center no-gutters">
                      <div class="col-auto">

                        <!-- Heading -->
                        <span class="h2 text-white mr-2 mb-0">
                          <?php echo number_format($product['products']) ?>
                        </span>

                      </div>
                      <div class="col">

                        <!-- Progress -->
                        <div class="progress progress-sm">
                          <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                      </div>
                    </div> <!-- / .row -->

                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <span class="h2 text-white fe fe-clipboard text-muted mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>

          </div>
          <div class="col-6 col-lg-6 col-xl">

            <!-- Card -->
            <div class="card card-cebuana">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-cebuana-red font-weight-bold mb-2">
                      Total Revenue
                    </h6>

                    <div class="row align-items-center no-gutters">
                      <div class="col-auto">

                        <!-- Heading -->
                        <span class="h2 text-white mr-2 mb-0">
                          ₱  <?php echo number_format($total['total'],2) ?>
                        </span>

                      </div>
                    </div> <!-- / .row -->

                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <span class="h2 text-white fe fe-clipboard text-muted mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div id="monthlySales" ></div>

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <div id="topCategory" ></div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div id="topProducts" ></div>

              </div>
            </div>
          </div>

<br><br>
      </main>
    </div>
  </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
$(document).ready(function($) {
  $(".table-row").click(function() {
    window.document.location = $(this).data("href");
  });



  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  // Draw the chart and set the chart values
  function drawChart() {
    //TOP Category
    var data = google.visualization.arrayToDataTable([
      ['Catgory', 'Revenue'],
      <?php
      while($row = mysqli_fetch_assoc($results6)) {
        // foreach ($topCategory as $category) {
        echo "['" . $row['categoryName'] . "'," . $row['total']  . "],";         }
        ?>
      ]);

      // Optional; add a title and set the width and height of the chart
      var options = {'title':'Top Categories'};
      // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('topCategory'));
      chart.draw(data, options);

      //TOP Products
      var data2 = google.visualization.arrayToDataTable([
        ['Product', 'Sold Items'],
        <?php
        while($row = mysqli_fetch_assoc($results5)) {
          // foreach ($topCategory as $category) {
          echo "['" . $row['productName'] . "'," . $row['total']  . "],";         }
          ?>
        ]);

        // Optional; add a title and set the width and height of the chart
        var options2 = {'title':'Top Products'};
        // Display the chart inside the <div> element with id="piechart"
        var chart2 = new google.visualization.ColumnChart(document.getElementById('topProducts'));
        chart2.draw(data2, options2);

        //SALES PER MONTH
        var data3 = google.visualization.arrayToDataTable([
          ['Month', 'Revenue'],
          <?php
          while($row = mysqli_fetch_assoc($results4)) {
            // foreach ($topCategory as $category) {
            echo "['" . $row['Month'] . "'," . $row['total']  . "],";         }
            ?>
          ]);

          // Optional; add a title and set the width and height of the chart
          var options3 = {'title':'Monthly Sales'};
          // Display the chart inside the <div> element with id="piechart"
          var chart3 = new google.visualization.LineChart(document.getElementById('monthlySales'));
          chart3.draw(data3, options3);
      }


    });

    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="assets/js/dashboard.js" charset="utf-8"></script>
