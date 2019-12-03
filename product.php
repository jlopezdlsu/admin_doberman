<?php

//header.php
session_start();

//include "header.php";
include ('conn.php');
include ('fetch_data.php');

?>
<!-- /BREADCRUMB -->

<script type="text/javascript">
jQuery(document).ready(function($) {
	$(".scroll").click(function(event){
		event.preventDefault();
		$('html,body').animate({scrollTop:$(this.hash).offset().top},900);
	});
});
</script>

<script>

(function (global) {
	if(typeof (global) === "undefined")
	{
		throw new Error("window is undefined");
	}
	var _hash = "!";
	var noBackPlease = function () {
		global.location.href += "#";
		// making sure we have the fruit available for juice....
		// 50 milliseconds for just once do not cost much (^__^)
		global.setTimeout(function () {
			global.location.href += "!";
		}, 50);
	};
	// Earlier we had setInerval here....
	global.onhashchange = function () {
		if (global.location.hash !== _hash) {
			global.location.hash = _hash;
		}
	};
	global.onload = function () {
		noBackPlease();
		// disables backspace on page except on input fields and textarea..
		document.body.onkeydown = function (e) {
			var elm = e.target.nodeName.toLowerCase();
			if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
				e.preventDefault();
			}
			// stopping event bubbling up the DOM tree..
			e.stopPropagation();
		};
	};
})(window);
</script>

<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>Specific Product</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link href="css/jquery-ui.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>

<body>
	<?php include('header.php') ?>

	<!-- SECTION -->
	<div class="section " style="margin-top:100px;">
		<!-- container -->
		<div class="container">
			<!-- row -->
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
					<div class="col-md-5">
					<div class="product-details">
					<h2 class="product-name">'.$row['productName'].'</h2>
					<div>
					<div class="product-rating">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o"></i>
					</div>
					<a class="review-link" href="#review-form">10 Review(s) | Add your review</a>
					</div>
					<div>
					<h3 class="product-price">$'.$row['price'].'</h3>
					<span class="product-available">In Stock</span>
					</div>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>


					<form method="post" action="checkout.php?p='.$row['productID'].'#!">
						<div class="add-to-cart">
						<div class="btn-group" style="margin-left: 25px; margin-top: 15px">
						<button class="add-to-cart-btn pc_data" id="'.$row['productID'].'" data-dataid='.$row['productID'].' ><i class="fa fa-shopping-cart"></i> Buy</button>
						</div>
						</div>
					</form>
					<form method="post" id="add-to-cart-form" action="addtocart.php?p='.$row['productID'].'#!">
						<div class="add-to-cart">
						<div class="btn-group" style="margin-left: 25px; margin-top: 15px">
						<button class="add-to-cart-btn pc_data" type="submit" id="'.$row['productID'].'" data-dataid='.$row['productID'].' ><i class="fa fa-shopping-cart"></i> Add to Cart</button>
						</div>
						</div>
					</form>
					<ul class="product-links">
					<li>Category:</li>
					<li><a href="#">'.$row['categoryName'].'</a></li>
					</ul>
					<ul class="product-links">
					<li>Share:</li>
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
					<li><a href="#"><i class="fa fa-envelope"></i></a></li>
					</ul>
					</div>
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
					<li><a data-toggle="tab" href="#tab3" role="tab">Reviews (3)</a></li>
					</ul>
					<!-- /product tab nav -->
					<!-- product tab content -->
					<div class="tab-content">
					<!-- tab1  -->
					<div class="tab-pane active" id="tab1" role="tabpanel">
					<div class="row">
					<div class="col-md-12">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					</div>
					</div>
					<!-- /tab1  -->
					<!-- tab2  -->
					<div class="tab-pane fade in" id="tab2"  role="tabpanel">
					<div class="row">
					<div class="col-md-12">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
					</div>
					</div>
					</div>
					<!-- /tab2  -->
					<!-- tab3  -->
					<div class="tab-pane fade in" id="tab3"  role="tabpanel">
					<div class="row">
					<!-- Rating -->
					<div class="col-md-3">
					<div id="rating">
					<div class="rating-avg">
					<span>4.5</span>
					<div class="rating-stars">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o"></i>
					</div>
					</div>
					<ul class="rating">
					<li>
					<div class="rating-stars">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					</div>
					<div class="rating-progress">
					<div style="width: 80%;"></div>
					</div>
					<span class="sum">3</span>
					</li>
					<li>
					<div class="rating-stars">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o"></i>
					</div>
					<div class="rating-progress">
					<div style="width: 60%;"></div>
					</div>
					<span class="sum">2</span>
					</li>
					<li>
					<div class="rating-stars">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o"></i>
					<i class="fa fa-star-o"></i>
					</div>
					<div class="rating-progress">
					<div></div>
					</div>
					<span class="sum">0</span>
					</li>
					<li>
					<div class="rating-stars">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o"></i>
					<i class="fa fa-star-o"></i>
					<i class="fa fa-star-o"></i>
					</div>
					<div class="rating-progress">
					<div></div>
					</div>
					<span class="sum">0</span>
					</li>
					<li>
					<div class="rating-stars">
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o"></i>
					<i class="fa fa-star-o"></i>
					<i class="fa fa-star-o"></i>
					<i class="fa fa-star-o"></i>
					</div>
					<div class="rating-progress">
					<div></div>
					</div>
					<span class="sum">0</span>
					</li>
					</ul>
					</div>
					</div>
					<!-- /Rating -->
					<!-- Reviews -->
					<div class="col-md-9">
					<div id="reviews">
					<ul class="reviews">
					<li>
					<div class="review-heading">
					<h5 class="name">John</h5>
					<p class="date">27 DEC 2018, 8:0 PM</p>
					<div class="review-rating">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o empty"></i>
					</div>
					</div>
					<div class="review-body">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
					</div>
					</li>
					<li>
					<div class="review-heading">
					<h5 class="name">John</h5>
					<p class="date">27 DEC 2018, 8:0 PM</p>
					<div class="review-rating">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o empty"></i>
					</div>
					</div>
					<div class="review-body">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
					</div>
					</li>
					<li>
					<div class="review-heading">
					<h5 class="name">John</h5>
					<p class="date">27 DEC 2018, 8:0 PM</p>
					<div class="review-rating">
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star"></i>
					<i class="fa fa-star-o empty"></i>
					</div>
					</div>
					<div class="review-body">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>
					</div>
					</li>
					</ul>

					</div>
					</div>
					<!-- /Reviews -->
					</div>
					</div>
					<!-- /tab3  -->
					</div>
					<!-- /product tab content  -->
					</div>
					</div>
					<!-- /product tab -->
					</div>
					<!-- /row -->
					</div>
					<!-- /container -->
					</div>
					<!-- /SECTION -->

					<!-- Section -->
					<div class="section">
					<!-- container -->
					<div class="container">
					<!-- row -->
					<div class="row">
					<div class="col-md-12">
					<div class="section-title text-center">
					<h3 class="title">Related Products</h3>

					</div>
					</div>
					';

					//
					//$_SESSION['product_id'] = $row['product_id'];
				}

				?>
				<?php
				$product_id = $_GET['p'];

				$query = $connect->prepare("SELECT * FROM tbl_product WHERE categoryID = categoryID LIMIT 4" );
				$query->execute();
				while ($row = $query->fetch()){
					$pro_id    = $row['productID'];
					$pro_cat   = $row['categoryID'];
					$pro_brand = $row['brandID'];
					$pro_title = $row['productName'];
					$pro_price = $row['price'];
					//$pro_image = $row['prd_image'];

					//$cat_name = $row["cat_title"];


					echo "
					<div class='col-md-3 col-xs-6'>
					<a href='product.php?p=$pro_id'><div class='product'>
					<div class='product-img'>
					<img src='image/". getImage($row['productID'],$connect) ."' style='max-height: 170px;' alt='' class='img-responsive'>
					<div class='product-label'>
					<span class='sale'>-30%</span>
					<span class='new'>NEW</span>
					</div>
					</div></a>
					<div class='product-body'>
					<p class='product-category'>$pro_cat</p>
					<h3 class='product-name header-cart-item-name'><a href='product.php?p=$pro_id'>$pro_title</a></h3>
					<h4 class='product-price header-cart-item-info'>$pro_price<del class='product-old-price'>$990.00</del></h4>
					<div class='product-rating'>
					<i class='fa fa-star'></i>
					<i class='fa fa-star'></i>
					<i class='fa fa-star'></i>
					<i class='fa fa-star'></i>
					<i class='fa fa-star'></i>
					</div>
					<div class='product-btns'>
					<button class='add-to-wishlist'><i class='fa fa-heart-o'></i><span class='tooltipp'>add to wishlist</span></button>
					<button class='add-to-compare'><i class='fa fa-exchange'></i><span class='tooltipp'>add to compare</span></button>
					<button class='quick-view'><i class='fa fa-eye'></i><span class='tooltipp'>quick view</span></button>
					</div>
					</div>
					<div class='add-to-cart'>
					<button pid='$pro_id' id='product' class='add-to-cart-btn block2-btn-towishlist' href='#'><i class='fa fa-shopping-cart'></i> add to cart</button>
					</div>
					</div>
					</div>
					";
				}




				?>

				<!-- product -->

				<!-- /product -->

			</div>
			<!-- /row -->

		</div>
		<!-- /container -->
	</div>
	<!-- /Section -->

	<!-- NEWSLETTER -->

	<!-- /NEWSLETTER -->

	<!-- FOOTER -->
	<?php include('footer.php') ?>
</body>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script src="js/jquery-ui.js"></script>
</html>
<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
	e.preventDefault();

	fieldName = $(this).attr('data-field');
	type      = $(this).attr('data-type');
	var input = $("input[name='"+fieldName+"']");
	var currentVal = parseInt(input.val());
	if (!isNaN(currentVal)) {
			if(type == 'minus') {

					if(currentVal > input.attr('min')) {
							input.val(currentVal - 1).change();
					}
					if(parseInt(input.val()) == input.attr('min')) {
							$(this).attr('disabled', true);
					}

			} else if(type == 'plus') {

					if(currentVal < input.attr('max')) {
							input.val(currentVal + 1).change();
					}
					if(parseInt(input.val()) == input.attr('max')) {
							$(this).attr('disabled', true);
					}

			}
	} else {
			input.val(0);
	}
});
$('.input-number').focusin(function(){
 $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {

	minValue =  parseInt($(this).attr('min'));
	maxValue =  parseInt($(this).attr('max'));
	valueCurrent = parseInt($(this).val());

	name = $(this).attr('name');
	if(valueCurrent >= minValue) {
			$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
	} else {
			alert('Sorry, the minimum value was reached');
			$(this).val($(this).data('oldValue'));
	}
	if(valueCurrent <= maxValue) {
			$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
	} else {
			alert('Sorry, the maximum value was reached');
			$(this).val($(this).data('oldValue'));
	}


});
$(".input-number").keydown(function (e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) ||
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
							 // let it happen, don't do anything
							 return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
					e.preventDefault();
			}
	});
</script>
<script type="text/javascript">

		$(document).ready(function (){
				$('.submitpro').on('submit', function(e){
						var product_num = $(this).find('.pc_data').data('dataid');
						var product_qty = $(this).find('.pro-qty').val();
						//alert("product Num = "+product_num+" Product Qty "+product_qty);
						if(product_num == '' || product_qty == ''){
								alert("Data Key Not Found");
								console.log("Data Key Not Found");
						}
						else{
								$.ajax({
										type: "POST",
										url: "ajax/cart-process.php",
										data: { 'product_num' : product_num, 'product_qty' : product_qty },
										success: function (response) {
												var get_val = JSON.parse(response);
												if(get_val.status == 100){
														alert(get_val.msg);
														console.log(get_val.msg);
														location.reload();
												}
												else if(get_val.status == 103){
														alert(get_val.msg);
														console.log(get_val.msg);
												}
												else{
														console.log(get_val.msg);
												}
										}
								});
						}
				});

				//ADD TO CART
				$('#add-to-cart-form').on('submit',function(e){
					e.preventDefault();
					var product_num = $(this).find('.pc_data').data('dataid');
					var product_qty = $(this).find('.pro-qty').val();
					//alert("product Num = "+product_num+" Product Qty "+product_qty);
					if(product_num == '' || product_qty == ''){
							alert("Data Key Not Found");
							console.log("Data Key Not Found");
					}
					else{
							$.ajax({
									type: "POST",
									url: "ajax/add-to-cart.php",
									data: { 'product_num' : product_num, 'product_qty' : product_qty },
									success: function (response) {
										console.log(response);
											// var get_val = JSON.parse(response);
											// if(get_val.status == 100){
											// 		alert(get_val.msg);
											// 		console.log(get_val.msg);
											// 		location.reload();
											// }
											// else if(get_val.status == 103){
											// 		alert(get_val.msg);
											// 		console.log(get_val.msg);
											// }
											// else{
											// 		console.log(get_val.msg);
											// }
									}
							});
					}
				});
		});

</script>
