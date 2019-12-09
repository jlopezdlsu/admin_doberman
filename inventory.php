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
            $currency           = '&#x20B1; '; //currency symbol
            $shipping_cost      = 50; //shipping cost

            if (isset($_POST['txtSpecs'])) {
              // Escape any html characters
              echo htmlentities($_POST['txtSpecs']);
            }
            // -=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
            //  PHP FOR EDITING Menu
            // -=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
            $editSuccess = false;
            if(isset($_POST["btnEditItem"])) {
              $itemCode = $_POST['txtCode'];
              $itemName = $_POST['txtName'];
              $itemDesc = $_POST['txtDescription'];
              $itemPrice = $_POST['txtPrice'];
              $itemBrand = $_POST['txtBrand'];
              $itemCategory = $_POST['category'];
              $itemDiscount = $_POST['txtDiscount'];

              $itemFeatured = $_POST['yesorno'];
              $itemQty = $_POST['txtQty'];
              $status = $_POST['status'];
              $fileName = "";

              $target_dir = "../themes/images/products/";
              $target_file = $target_dir . basename($_FILES["fileImage"]["name"]);
              $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
              $imageSrc = "themes/images/products/".$_POST['txtName'].".".$imageFileType; // Image src for database
              $fileName = $target_dir.$_POST['txtName'].".".$imageFileType;
              $check = getimagesize($_FILES["fileImage"]["tmp_name"]); // Returns false if file is not image

              $sql="SELECT * FROM products ;";
              $result=$con->query($sql);
              if ($result->num_rows >=1) {

                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                  echo "Sorry, only JPG, JPEG and PNG files are allowed.";
                }
                else if($check == false) {
                  echo "<center><div class='alert'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                  Invalid image file.
                  </div>";
                }
                if (file_exists("$fileName")) unlink("$fileName");
                if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $fileName)) {
                  $sql="";

                  $sql="UPDATE
                  products
                  SET
                  name = '$itemName',
                  description = '$itemDesc',
                  price = '$itemPrice',
                  brand = '$itemBrand',
                  category = '$itemCategory',
                  imgsrc = '$imageSrc',
                  discount = '$itemDiscount',
                  featured = '$itemFeatured',
                  qty = '$itemQty'
                  WHERE CODE
                  = '$itemCode';";

                  $con->query($sql);
                  $editSuccess = true;
                }
                else {
                  echo "<center><div class='alert'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                  Error uploading image.</div>";
                }
              }
              else {
                echo "<center><div class='alert'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                This item code doesn't exist. Please refer to list of all items.
                </div>";
              }
            }
            ?>
            <?php
            if (isset($_POST['statusupdate'])){
              // Update IF STATUSUPDATE has value
              //                                                                    eto naka ID lang
              $sql="update tbl_product SET status=".$_POST['statusupdate']." where productID=".$_POST['statusid']." ;";
              $con->query($sql);
            }
            if (isset($_POST["btnEditItem"])) {
              if ($editSuccess) {
                echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>Item successfully edited.</div>";
              }
              else {
                echo "<center><div class='alert warning'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                An error was encountered when editing the item's information.
                </div>";
              }
            }
            ?>
            <form name = 'viewAccounts' id='viewAccounts' method='POST' action='inventory.php'>
              <?php
              if(isset($_POST['delete'])){
                if(!empty($_POST['select'])) {
                  foreach($_POST['select'] as $status) {
                    $file_pattern = "../themes/images/products/"."$status"."*";
                    array_map( "unlink", glob( $file_pattern ) );
                    $sql = "DELETE FROM products WHERE name = '$status'";
                    $con->query($sql);
                  }
                }
                else{
                  echo "<center><div class='alert warning'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                  Please select an item to delete first.
                  </div>";
                }
              }

              if(isset($_POST['delete'])){
                if(!empty($_POST['select'])) {
                  echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                  Successfully deleted selected item(s).
                  </div>";
                }
              }

							$merchantID = $_SESSION['UserData']['UserID'];
              $sqlProducts = "SELECT * FROM tbl_product INNER JOIN tbl_productimg ON tbl_product.productID=tbl_productimg.productID WHERE tbl_product.merchantID = '$merchantID'";
              $resultProducts = $con->query($sqlProducts);
              if (mysqli_num_rows($resultProducts) > 0) {
                echo "
                <div class='card'>
                  <div class='card-body'>
                    <table border='1' class='table table-bordered table-responsive'>
                      <thead>
                        <tr>
                          <th scope='col'>Id</th>
                          <th scope='col'>Image</th>
                          <th scope='col'>Item Name</th>
                          <th scope='col'>Quantity</th>
                          <th scope='col'>Price</th>
													<th scope='col'>Short Description</th>
													<th scope='col'>Edit</th>
                          <th scope='col'>Status</th>
                        </tr>
                      </thead>
                    <tbody>
                ";

                while($row = $resultProducts->fetch_assoc()) {
                  echo "
                    <tr>
                      <td>
                        ".$row['productID']."
                      </td>
                      <td style='padding:5px'>
                        <img src='image/".$row['imgName']."' length='80' width='80' alt='".$row['productID']."'><br><br>
                      </td>
                      <td>
                        ".$row['productName']."
                      </td>
                      <td>
                        ".$row['quantity']."
                      </td>
                      <td>
                        ".$row['price']."
                      </td>
											<td>
												".$row['shortDescription']."
											</td>
											<td>
												<a class='btn btn-primary' href='edit.php?p=".$row['productID']."'>Edit</a>
											</td>
                      <td>
                        ";
                      // Mag lalagay ng property na checked pag yung status sa database ay true
                      if($row['status']){
                        $xString = 'checked';
                      }
                      else {
                        $xString = '';
                      }
                      //Gumagawa ng function kada checkbox para mag update ng status
                      echo "
                      <center><input type='checkbox' id='chk".$row['productID']."' onclick='myFunction(".$row['productID'].")' ".$xString."></center>
                      <script language='javascript'>
                      function myFunction(id) {
                        var ischeck=$('#chk'+ id).is(':checked',true);                                            //  naka product id to
                        $('#viewAccounts').append('<input type=\"hidden\" id=\"statusid\" name=\"statusid\" value=' + id + '>');
                        $('#viewAccounts').append('<input type=\"hidden\" id=\"statusupdate\" name=\"statusupdate\" value=' + ischeck + '>');
                        $('#viewAccounts').submit();
                      }
                      </script>
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
                </div>
                </center>
                ";
              }
              else {
                echo "<center><div class='alert'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>Sorry no menu found.<br>Please do press \"Search\" button once again to view all items.
                </div>";
              }
              $con->close();
              ob_end_flush();
              ?>
            </form>
      </main>
    </div>
  </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
		    $('table').DataTable();
});

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
