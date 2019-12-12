<?php
include('conn.php'); //Database Connection

function getImage($img,$connect){
	$query2 = "
	SELECT * FROM tbl_productimg WHERE productID = '$img'
	";
	$statement = $connect->prepare($query2);
	$statement->execute();
	$result = $statement->fetchAll();
	return $result[0]["imgName"];
}

function getImage2($img,$connect){
	$query2 = "
	SELECT * FROM tbl_accessoriesimg WHERE productID = '$img'
	";
	$statement = $connect->prepare($query2);
	$statement->execute();
	$result = $statement->fetchAll();
	return $result[0]["imgName"];
}



if (isset($_POST["action"])) {
	$query = "SELECT * FROM tbl_product WHERE status = '1'";

	if(isset($_POST["search_query"]) && $_POST["search_query"] !== "")
	{
		$catsearch=  $_POST["search_query"];
		$query .= "
		AND shortDescription LIKE '%".$catsearch."%'
		";
	}
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= "
		AND price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		";
	}
	if(isset($_POST["category"]))
	{
		$cat_filter = implode("','", $_POST["category"]);
		$query .= "
		AND categoryID IN('".$cat_filter."')
		";
	}

	if(isset($_POST["brand"]))
	{
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= "
		AND brandID IN('".$brand_filter."')
		";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= "
		AND ram IN('".$ram_filter."')
		";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= "
		AND storage IN('".$storage_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result    = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output    = '';
	if ($total_row > 0) {
		foreach ($result as $row) {
			$output .= '
			<div class="col-md-4 col-sm-6">
			<div class="product-grid">
			<div class="product-image4">
			<a href="product.php?p='. $row['productID'] .'">
			<img class="pic-1" src="image/' . getImage($row['productID'],$connect) . '">
			<img class="pic-2" src="image/' . getImage($row['productID'],$connect) . '">
			</a>
			<ul class="social">
			<li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
			<li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
			<li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
			</ul>
			<span class="product-new-label">New</span>
			<span class="product-discount-label">-10%</span>
			</div>
			<div class="product-content">
			<h3 class="title"><a href="product.php?p='. $row['productID'] .'">' . $row['productName'] . '</a></h3>
			<div class="price">
			$' . $row['price'] . '
			<span>$' . $row['price'] . '</span>
			</div>

			</div>
			</div>
			</div>';
		}
	} else {
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>
