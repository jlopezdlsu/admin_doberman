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
              $uniq = uniqid();

              $productName = $_POST['txtproductname'];
              $Quantity = $_POST['txtquantity'];
              $itemPrice = $_POST['txtPrice'];
              $Ram = isset($_POST['txtram']) ? $_POST['txtram'] :  '';
              $Storage = isset($_POST['txtstorage']) ? $_POST['txtstorage'] : '';
              $itemCategory = $_POST['category'];
              $Camera = isset($_POST['txtCamera']) ? $_POST['txtCamera'] : '';
              $Processor = isset($_POST['txtprocessor']) ? $_POST['txtprocessor']  : '';
              $Description = $_POST['txtdescription'];
              $ShortDesc = $_POST['txtshort'];
              $Brand= $_POST['txtbrand'];
              $itemDate = date('Y/m/d A H:i:s');
              $target_dir = "image/";
              $target_file = $target_dir . basename($_FILES["fileImage"]["name"]);
              $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
              $name = $_POST['txtproductname']."-".$uniq.".".$imageFileType
              $imageSrc = "image/".$name; // Image src for database
              $fileName = $target_dir.$name;
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
                  $user = $_SESSION['UserData']['UserID'];
                  $sql = null;
                  //if accessory
                  if($itemCategory == '6'){
                    $sql="INSERT INTO `tbl_accessories` (`productName`,`brandID`,`categoryID`,`merchantID`,`quantity`,`price`,`description`,`shortDescription`,`status`)
                    VALUES ('$productName','$Brand','$itemCategory','$user','$Quantity','$itemPrice','$Description','$ShortDesc','1');";
                  }else{
                    $sql="INSERT INTO `tbl_product` (`productName`,`brandID`,`categoryID`,`merchantID`,`quantity`,`price`,`ram`,`storage`,`camera`,`processor`,`description`,`shortDescription`,`status`)
                    VALUES ('$productName','$Brand','$itemCategory','$user','$Quantity','$itemPrice','$Ram','$Storage','$Camera','$Processor','$Description','$ShortDesc','1');";
                  }

                  if($conn->query($sql)){
                    echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    Item has successfully been updated!.
                    </div>";


                    $last_id = $conn->insert_id;

                    $sql = null;
                      //if accessory
                    if($itemCategory == '6'){
                      $sql= "INSERT INTO `tbl_accessoriesimg` (`productID`,`imgName`,`imgSource`) VALUES ('$last_id','$name','$fileName');";
                    }else{
                      $sql= "INSERT INTO `tbl_productimg` (`productID`,`imgName`,`imgSource`) VALUES ('$last_id','$name','$fileName');";
                    }

                    if($conn->query($sql)){
                      $conn->close();
                      echo " sucess " ;
                    }
                  }else{
                    echo "<center><div class='alert success'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                    ".$conn->error.";
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
                    <td style="padding-left:20px;">Category Type: </td>
                    <td><select name="category" class="form-control mt-2">
                      <option value="1">Laptops</option>
                      <option value="2">Computers/Desktop</option>
                      <option value="3">Tablet</option>
                      <option value="4">Mobile Phones</option>
                      <option value="5">Camera</option>
                      <option value="6">Accessories</option>
                    </select>
                  </td>
                    <tr>
                      <td style="padding-left:20px;"> Brand: </td>
                      <td><select name="txtbrand" class="form-control mt-2">
                        <option value="1">Dell</option>
                        <option value="2">Microsoft</option>
                        <option value="3">Lenovo</option>
                        <option value="4">Apple</option>
                        <option value="5">ASUS</option>
                        <option value="6">PC Specialist</option>
                        <option value="7">HP</option>
                        <option value="8">ACER</option>
                        <option value="9">Amazon</option>
                        <option value="10">Samsung</option>

                      </select>
                    </tr>
                    <tr>

                      <td style="padding-left:20px;"> Product Name: </td>
                      <td><input type="text"  class="form-control mt-2" required name="txtproductname" maxlength="30"></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;"> Quantity: </td>
                      <td><input type="number" class="form-control mt-2" required name="txtquantity"></td>
                      <tr>
                        <td style="padding-left:20px;">Price: ₱ </td>
                        <td><input type="number" class="form-control mt-2"  required name="txtPrice"></td>

                      </tr>
                      <tr>

                        <td style="padding-left:20px;">Ram: </td>
                        <td><input type="number" class="form-control mt-2"  required name="txtram"></td>
                      </tr>
                      <tr>
                        <td style="padding-left:20px;">Storage: </td>
                        <td><input type="text" class="form-control mt-2"  required name="txtstorage"></td>
                      </tr>
                      <tr>
                        <td style="padding-left:20px;">Camera:  </td>
                        <td><input type="text" class="form-control mt-2"  required name="txtCamera"></td>
                      </tr>
                    <tr>
                      <td style="padding-left:20px;">Processor: </td>
                      <td><input type="text" class="form-control mt-2"  required name="txtprocessor"></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;cursor:pointer;">Image:</td>
                      <td><input type="file" name="fileImage" id="fileImage" accept=".png, .jpg, .jpeg" required class="mt-2"></td>
                    </tr>
                    <tr>
                      <td style="padding-left:20px;">Description:</td>
                      <td><textarea  class="form-control mt-2" required name="txtdescription" style="height:220px;width:100%;"> </textarea></td>
                    </tr>
                    <td style="padding-left:20px;">Short Description:  </td>
                    <td><textarea   class="form-control mt-2" class ="texto"required name= "txtshort" style="height:220px;width:100%;"> </textarea></td>
                  </tr>


                  <tr>
                    <td colspan=2 align=center><input class="mt-3 btn btn-primary float-right" type="submit" name="btnAddMenu" value="Submit"></td>
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

  $('select[name="category"]').on("change",function(e){
    if($(this).val() === '6'){
$('input[name="txtram"],input[name="txtstorage"],input[name="txtCamera"],input[name="txtprocessor"]').attr('disabled',true).closest('tr').hide();
    }else{
      $('input[name="txtram"],input[name="txtstorage"],input[name="txtCamera"],input[name="txtprocessor"]').attr('disabled',false).closest('tr').show();

    }
  });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
