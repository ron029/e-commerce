<?php
/** @var Carts $carts_quantity
 *
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>All Products | Lashopda</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>"/>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>"/>
	<script>
		$(document).ready(function () {
			$('#search_product').hide();
		});

		/*  For pagination highlight    */
		function pageNumHighlight(pageNum) {
			$(".pagination > a").css("background-color", "white").css("color", "blue");
			for (let i = 0; i < document.querySelectorAll(".pagination > a").length; i++) {
				if (pageNum === $(".pagination > a:nth-child(" + i + ")").text()) {
					$(".pagination > a:nth-child(" + i + ")").css("background-color", "#1975ff").css("color", "white");
				}
			}
		}

		/**********************************************/
		$.get('<?= base_url("shops/index_html") ?>', function (res) {
			$('#shop').html(res);
		});

		$.get('<?= base_url("shops/carts_quantity")?>', function (res) {
			if (parseInt(res) >= 0) {
				var cart_quantity = parseInt(res);
			} else {
				var cart_quantity = 0;
			}
			$(".cart_quantity").text(cart_quantity);
		});

		$(document).ready(function () {


			$(document).on("change", ".sort", function () {
				$.post($('.sort_form').attr('action'), $(this).serialize(), function (res) {
					$('#shop').html(res);
				});
				return false;
			});
			/*  Product categories selection    */
			$(document).on("click", ".products_categories > a", function () {
				$.get($(this).attr('href'), function (res) {
					$('#shop').html(res);
				});
				categoryName = $(this).text().split("(")[0];
				document.title = categoryName + ' | Lashopda';
				$(".category_name").text(categoryName);
				// $(".products > p").text(categoryName);
				pageNumHighlight(pageNum);
				return false;
			});
			/**********************************************/

			/*  Pagination at footer    */
			var pageNum = 1;
			$(".page_number").text(pageNum);
			pageNumHighlight(pageNum);

			$(document).on("click", ".pagination > a:not(.next_page)", function () {
				pageNum = $(this).text();
				$(".page_number").text(pageNum);
				pageNumHighlight(pageNum);
				return false;
			});
			$(document).on("click", ".next_page", function () {
				pageNum++;
				$(".page_number").text(pageNum);
				pageNumHighlight(pageNum);
				return false;
			});
			/**********************************************/

			/*  Pagination at catalog header    */
			$(document).on("click", ".first_page", function () {
				pageNum = 1;
				$(".page_number").text(pageNum);
				pageNumHighlight(pageNum);
				return false;
			});
			$(document).on("click", ".prev_page", function () {
				if (pageNum > 1) {
					pageNum--;
				}
				$(".page_number").text(pageNum);
				pageNumHighlight(pageNum);
				return false;
			});
			/**********************************************/

			/*  For submission of forms    */
			$(document).on("submit", "form", function () {
				pageNumHighlight(pageNum);
				return false;
			});
			/**********************************************/
		});
	</script>
</head>
<body>
<header>
	<a href="<?= base_url('products') ?>"><h2>Lashopda</h2></a>
	<a class="nav_end" href="<?= base_url('carts') ?>"><h3>Shopping Cart (<span class="cart_quantity"></span>)</h3></a>
</header>
<main id="shop"></main>
</body>
</html>
