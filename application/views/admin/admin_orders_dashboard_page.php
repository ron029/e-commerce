<?php
/** @var Orders $orders */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>(Dashboard Orders)</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>"/>
	<script>
		/*  For pagination highlight    */
		function pageNumHighlight(pageNum) {
			$(".pagination > a").css("background-color", "white").css("color", "blue");
			for (var i = 0; i < document.querySelectorAll(".pagination > a").length; i++) {
				if (pageNum == $(".pagination > a:nth-child(" + i + ")").text()) {
					$(".pagination > a:nth-child(" + i + ")").css("background-color", "#1975ff").css("color", "white");
				}
			}
		}

		/**********************************************/

		$(document).ready(function () {

			/*  Submitting of forms will redirect to specified page based on action attribute    */
			$(document).on("submit", "form", function () {
				window.location = $(this).attr("action");
				return false;
			});
			/**********************************************/

			/*  Pagination at footer    */
			var pageNum = 1;
			pageNumHighlight(pageNum);

			$(document).on("click", ".pagination > a:not(.next_page)", function () {
				pageNum = $(this).text();
				pageNumHighlight(pageNum);
				return false;
			});
			$(document).on("click", ".next_page", function () {
				pageNum++;
				pageNumHighlight(pageNum);
				return false;
			});
			/**********************************************/

		});
	</script>
</head>
<body>
<header class="header_admin">
	<a href="<?= base_url('dashboard/orders') ?>"><h2>Dashboard</h2></a>
	<a href="<?= base_url('dashboard/orders') ?>"><h3>Orders</h3></a>
	<a href="<?= base_url('dashboard/products') ?>"><h3>Products</h3></a>
	<a class="nav_end" href="<?= base_url('users/logout') ?>"><h3>Log off</h3></a>
</header>
<main>
	<p class="message_admin_orders"></p>
	<form class="form_admin_orders" action="" method="post">
		<input type="search" name="admin_orders_search" placeholder="&#x1F50D; search"/>
		<select name="admin_orders_status">
			<option value="0">Show All</option>
			<option>Order in process</option>
			<option>Shipped</option>
			<option>Cancelled</option>
		</select>
	</form>
	<table class="admin_orders_table">
		<thead>
		<tr>
			<th>Order ID</th>
			<th>Name</th>
			<th>Date</th>
			<th>Billing Address</th>
			<th>Total</th>
			<th>Status</th>
		</tr>
		</thead>
		<tbody>
<?php
		foreach ($orders as $order) {
?>
			<tr>
				<td><a href="<?= base_url('orders/show/') . $order['id'] ?>"><?= $order['id'] ?></a></td>
				<td><?= ucwords($order['full_name']) ?></td>
				<td><?= $order['created_at'] ?></td>
				<td><?= ucwords($order['billing']['address_bill'] . ' ' . $order['billing']['address2_bill'] . ' ' . $order['billing']['city_bill'] . ' ' . $order['billing']['state_bill'] . ' ' . $order['billing']['zipcode_bill']) ?></td>
				<td>P <?= number_format($order['carts_total_price'], 2) ?></td>
				<td>
					<form action="" method="post">
						<input type="hidden" name="product_id" value="product_id"/>
						<select name="admin_orders_update">
							<option>Order in process</option>
							<option selected>Shipped</option>
							<option>Cancelled</option>
						</select>
					</form>
				</td>
			</tr>
<?php
		}
?>
		</tbody>
	</table>
	<section class="pagination">
		<a href="">1</a><!--
         --><a href="">2</a><!--
         --><a href="">3</a><!--
         --><a href="">4</a><!--
         --><a href="">5</a><!--
         --><a href="">6</a><!--
         --><a href="">7</a><!--
         --><a href="">8</a><!--
         --><a href="">9</a><!--
         --><a href="">10</a><!--
         --><a class="next_page" href="">&rsaquo;</a>
	</section>
</main>
</body>
</html>
