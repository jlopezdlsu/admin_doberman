<?php session_start(); /* Starts the session */

if(!isset($_SESSION['UserData']['Username'])){
	header("location:login.php");
	exit;
}

//include "header.php";
include ('conn.php');
include ('fetch_data.php');

if(isset($_POST['edit_submit'])){
	$productName = isset($_POST['productName']) ? $_POST['productName'] : '';
	$price = isset($_POST['price']) ? $_POST['price'] : '';
	$shortDescription = isset($_POST['shortDescription']) ? $_POST['shortDescription'] : '';
	$description = isset($_POST['description']) ? $_POST['description'] : '';

	$query = $connect->prepare("UPDATE tbl_product SET productName = :productName, price = :price, description = :description, shortDescription = :shortDescription WHERE productID = :product_id");
	$query->execute(['productName'=>$productName,'price'=>$price,'description'=>$description,'shortDescription'=>$shortDescription,'product_id' => $_GET['p']]);

	if($query){
		echo 'yey';
	}

	if(isset($_FILES['fileImage'])) {

		$target_dir = "image/";
		$target_file = $target_dir . basename($_FILES["fileImage"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$imageSrc = "image/".$productName.".".$imageFileType; // Image src for database
		$fileName = $target_dir.$productName.".".$imageFileType;
		$name = $productName.".".$imageFileType;
		$check = getimagesize($_FILES["fileImage"]["tmp_name"]); // Returns false if file is not image


		if($check == false) {
			echo "<center><div class='alert'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
			Invalid image file.
			</div>";
		}
		else {
			if (file_exists("$fileName")) unlink("$fileName");
			if (move_uploaded_file($_FILES["fileImage"]["tmp_name"], $fileName)) {
				$query2 = $connect->prepare("UPDATE tbl_productimg SET imgName = :imgName, imgSource = :imgSource WHERE productID = :product_id");
				$query2->execute(['imgName'=>$name,'imgSource'=>$name,'product_id' => $_GET['p']]);

				if($query2){
					echo 'imageUploaded';
				}
			}
			else {
				echo "<center><div class='alert warning'><span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
				Error uploading image.
				</div>";
			}
		}
	}
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
		<link href="css/jquery-ui.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">

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
						<h1 class="h2 font-weight-bold">Edit Product</h1>
					</div>
					<div class="col-lg-12">
						<div class="row">
							<!-- Product main img -->

							<?php
							$query = $connect->prepare("SELECT product.productID,product.productName, product.quantity, product.price, product.ram, product.storage, product.camera, product.processor, product.description, product.shortDescription, category.categoryID, product.categoryID, category.categoryName  FROM tbl_product product INNER JOIN tbl_category category ON category.categoryID = product.categoryID WHERE productID = :product_id");
							$query->execute(['product_id' => $_GET['p']]);
							while ($row = $query->fetch()){

								// do stuff here
								echo '
								<div class="col-md-5 col-md-push-2">
								<div id="product-main-img">
								<div class="product-preview">
								<img src="image/'.getImage($row['productID'],$connect).'" alt="">
								</div>
								</div>
								</div>
								<div class="col-md-2  col-md-pull-5">
								<div id="product-imgs">
								<div class="product-preview">
								<img src="image/'.getImage($row['productID'],$connect).'" alt="">
								</div>
								</div>

								</div>

								';
								?>
								<!-- FlexSlider -->
								<?php
								echo '
								<form method="post" name="edit_form" enctype="multipart/form-data">
								<div class="col-md-5">
								<div class="product-details">

								<input type="text" class="product-name form-control" name="productName" value="'.$row['productName'].'" style="width:100%;">
								<div>
								<input type="text" class="product-price form-control" name="price" value="$'.$row['price'].'" style="width:100%;">

								</div>
								<textarea class="form-control" style="width:100%;" name="shortDescription" rows="8">'.$row['shortDescription'].'</textarea>

								<ul class="product-links">
								<li>Category:</li>
								<li><a href="#">'.$row['categoryName'].'</a></li>
								</ul>
								</div>
								</div>
								<br>
								<div class="col-md-12">
								<h3>Upload Image</h3>
								<input type="file" name="fileImage" id="fileImage" accept=".png, .jpg, .jpeg"  class="form-control" style="width:58%">
								</div>
								<!-- /Product main img -->
								<!-- Product thumb imgs -->
								<!-- /Product thumb imgs -->
								<!-- Product details -->
								<!-- /Product details -->
								<!-- Product tab -->
								<div class="col-md-12">
								<div id="product-tab">
								<!-- product tab nav -->
								<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1" role="tab">Description</a></li>
								<li><a data-toggle="tab" href="#tab2" role="tab">Details</a></li>
								</ul>
								<!-- /product tab nav -->
								<!-- product tab content -->
								<div class="tab-content">
								<!-- tab1  -->
								<div class="tab-pane active" id="tab1" role="tabpanel">
								<div class="row">
								<div class="col-md-12">
								<textarea class="form-control" style="width:100%;" name="description" rows="8">'.strip_tags($row['description']).'</textarea>
								</div>
								</div>
								</div>
								<!-- /tab1  -->
								<!-- tab2  -->
								<div class="tab-pane fade in" id="tab2"  role="tabpanel">
								<div class="row">
								<div class="col-md-12">
								<textarea class="form-control" style="width:100%;"  rows="8">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
								</textarea>
								</div>
								</div>
								</div>
								<!-- /tab2  -->

								</div>
								<!-- /product tab content  -->
								</div>
								</div>
								<!-- /product tab -->
								<br>
								<button type="submit" name="edit_submit" class="btn btn-primary">Submit</button>
								<br><br>
								</form>
								</div>
								<!-- /row -->

								</div>
								<!-- /container -->

								<!-- /SECTION -->



								';

								//
								//$_SESSION['product_id'] = $row['product_id'];
							}

							?>


							<!-- /product -->

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
<script src="assets/js/dashboard.js" charset="utf-8"></script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/jquery-ui.js"></script>
