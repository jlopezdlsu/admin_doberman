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
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <?php @include('sidebar.php') ?>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2 font-weight-bold">Add Item</h1>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <?php include('dbcon.php') ?>

            <?php
            $currency           = '&#x20B1; '; //currency symbol
            $shipping_cost      = 50; //shipping cost
            $conn = new mysqli($db_host, $db_username, $db_password,$db_name); //connect to MySql
            if ($conn->connect_error) {//Output any connection error
              die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
            }

            if (isset($_POST['txtSpecs'])) {
              // Escape any html characters
              echo htmlentities($_POST['txtSpecs']);
            }

            if(isset($_POST['btnAddMenu'])){
              $productName = $_POST['txtproductname'];
              $Quantity = $_POST['txtquantity'];
              $itemPrice = $_POST['txtPrice'];
              $Ram = $_POST['txtram'];
              $Storage = $_POST['txtstorage'];
              $itemCategory = $_POST['category'];
              $Camera = $_POST['txtCamera'];
              $Processor = $_POST['txtprocessor'];
              $Description = $_POST['txtdescription'];
              $ShortDesc = $_POST['txtshort'];
              $Brand= $_POST['txtbrand'];
              $itemDate = date('Y/m/d A H:i:s');
              $target_dir = "themes/images/products/";
              $target_file = $target_dir . basename($_FILES["fileImage"]["name"]);
              $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
              $imageSrc = "themes/images/products/".$_POST['txtproductname'].".".$imageFileType; // Image src for database
              $fileName = $target_dir.$_POST['txtproductname'].".".$imageFileType;
              $check = getimagesize($_FILES["fileImage"]["tmp_name"]); // Returns false if file is not image

              if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo "Sorry, only JPG, JPEG and PNG files are allowed.";
              }
              else if($check == false) {
                echo "<center><div class='alert'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                Invalid image file.
                </div>";
              }
              else {
                if (file_exists("$fileName")) unlink("$fileName");
                if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $fileName)) {

                  $sql="INSERT INTO `tbl_product` (`productName`,`brandID`,`categoryID`,`merchantID`,`quantity`,`price`,`ram`,`storage`,`camera`,`processor`,`description`,`shortDescription`)
                  VALUES ('$productName','$Brand','$itemCategory','1','$Quantity','$itemPrice','$Ram','$Storage','$Camera','$Processor','$Description','$ShortDesc');";

                  if($conn->query($sql)){
                    echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    Item has successfully been updated!.
                    </div>";


                    $last_id = $conn->insert_id;
                    echo " New record created successfully. Last inserted ID is: " . $last_id;
                    $sql= "INSERT INTO `tbl_productimg` (`productID`,`imgName`,`imgSource`)
                    VALUES ('$last_id','$imageSrc','$fileName');";
                    if($conn->query($sql)){
                      $conn->close();
                      echo " sucess " ;
                    }
                  }else{
                    echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    ".$conn->error."
                    </div>";
                  }
                } else {
                  echo "<center><div class='alert warning'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                  Error uploading image.
                  </div>";
                }
              }
            }
            ob_end_flush();
            ?>
            <form name="addmenuForm" action="additem.php" method="post" enctype="multipart/form-data">
              <div class="card">

                <div class="card-body">
                  <table width="100%">
                    <tr>
                      <td  colspan=2 style="background-color:#353638; padding-bottom:10px;padding:20px;"><h1 style="color:#f7efc0;" align="center">Dobermann Add Item</h1></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;"> <br>Brand: </td>
                      <td><br><select name="txtbrand">
                        <option value="1">Apple</option>
                        <option value="2">samsung</option>
                        <option value="Mobile Phone">Mobile Phone</option>
                        <option value="Storage Devices">Storage Devices</option>
                        <option value="Sound & Vision">Sound & Vision</option>
                      </select>
                    </tr>
                    <tr>

                      <td style="padding-left:20px;"> <br>Product Name: </td>
                      <td><br><input type="text" class="texto"required name="txtproductname" maxlength="30"></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;"> <br>Quantity: </td>
                      <td><br><input type="number" class="texto"required name="txtquantity"></td>
                      <tr>
                        <td style="padding-left:20px;">Price: ₱ </td>
                        <td><input type="number" class="texto" required name="txtPrice"></td>

                      </tr>
                      <tr>

                        <td style="padding-left:20px;">Ram: </td>
                        <td><input type="number" class="texto" required name="txtram"></td>
                      </tr>
                      <tr>
                        <td style="padding-left:20px;">Storage: </td>
                        <td><input type="text" class="texto" required name="txtstorage"></td>
                      </tr>
                      <tr>
                        <td style="padding-left:20px;">Camera:  </td>
                        <td><input type="text" class="texto" required name="txtCamera"></td>
                      </tr>

                      <td style="padding-left:20px; font-size:20px;"><br>Category Type: </td>
                      <td><br><select name="category">
                        <option value="1">Camera</option>
                        <option value="2">Computers, Tablets & Laptops</option>
                        <option value="3">Mobile Phone</option>
                        <option value="4">Storage Devices</option>
                        <option value="5">Sound & Vision</option>
                      </select>
                    </td>
                    <tr>
                      <td style="padding-left:20px;"><br>Processor: </td>
                      <td><br><input type="text" class="texto" required name="txtprocessor"></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;cursor:pointer;"><br>Image:<br></td>
                      <td><br><input type="file" name="fileImage" id="fileImage" accept=".png, .jpg, .jpeg" required><br></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;"><br>Description:<br></td>
                      <td><textarea id = ""required name="txtdescription" style="height:220px;width:250px;"> </textarea></td>
                    </tr>
                    <td style="padding-left:20px;">Short Description:  </td>
                    <td><textarea  id="txtshort" class ="texto"required name= "txtshort" style="height:220px;width:250px;"> </textarea></td>
                  </tr>


                  <tr style="margin-top:20px;background-color:#353638;">
                    <td colspan=2 align=center><br><input class="buttones" type="submit" name="btnAddMenu" value="Add to Menu"><br><br></td>
                  </tr>
                </table>
                </div>
              </div>
          </form>


        </div>
      </div>
    </main>
  </div>
</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function($) {
  $(".table-row").click(function() {
    window.document.location = $(this).data("href");
  });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
