<?php
	/**
	 * @var Shops $product
	 * @var Shops $similar_products
	 * @var Shops $title
	 * @var Shops $carts_quantity
	 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tshirt | Lashopda</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>" />
    <script>

        /*  For pagination highlight    */
        function pageNumHighlight(pageNum){
            $(".pagination > a").css("background-color", "white").css("color", "blue");
            for(var i = 0; i < document.querySelectorAll(".pagination > a").length; i++){
                if(pageNum === $(".pagination > a:nth-child(" + i + ")").text()){
                    $(".pagination > a:nth-child(" + i + ")").css("background-color", "#1975ff").css("color", "white");
                }
            }
        }
        /**********************************************/

        $(document).ready(function(){
            /*  For submission of forms & updating of cart quantity    */
	        $.get('<?= base_url("shops/carts_quantity")?>', function (res) {
				if (parseInt(res) >= 0) {
					var cart_quantity = parseInt(res);
				} else {
					var cart_quantity = 0;
				}
				$(".cart_quantity").text(cart_quantity);

				$(document).on("submit", '.buy_item', function () {

					$(".item_added_confirm").show().fadeOut(3000);
					pageNumHighlight(pageNum);

					cart_quantity += parseInt($(".new_order_qty").val().split(" ")[0]);
					$(".cart_quantity").text(cart_quantity);

					$.post($(this).attr('action'), $(this).serialize(), function (res) {
						console.log(res);
					});

					return false;
				});
			});


			// $(document).on("click", ".buy_product", function () {
			// 	console.log()
			// 	// return false;
			// });

            // $(document).on("submit", "form", function(){
			//
            //     $(".item_added_confirm").show().fadeOut(3000);
            //     pageNumHighlight(pageNum);
			//
            //     cart_quantity += parseInt($(".new_order_qty").val().split(" ")[0]);
            //     $(".cart_quantity").text(cart_quantity);
			//
            //     return false;
            // });
            /**********************************************/

            /*  Pagination at footer    */
            var pageNum = 1;
            pageNumHighlight(pageNum);

            $(document).on("click", ".pagination > a:not(.next_page)", function(){
                pageNum = $(this).text();
                pageNumHighlight(pageNum);
                return false;
            });
            $(document).on("click", ".next_page", function(){
                pageNum++;
                pageNumHighlight(pageNum);
                return false;
            });
            /**********************************************/

            /*  For going back from previous page    */
            $(document).on("click", ".go_back", function(){
                history.back();
                return false;
            });
            /**********************************************/

            /*  For changing the big image    */
            $(".default_main_img").css("outline", "1px solid rgba(8, 0, 167, 0.7)");
            $(document).on("mouseover", ".sub_img", function(){
                $(".sub_img").css("outline", "none");
                $(".main_img").attr("src", $(this).attr("src"));
                $(this).css("outline", "1px solid rgba(8, 0, 167, 0.7)");
            });
            /**********************************************/
        });
    </script>
</head>
<body>
    <header>
        <a href="<?= base_url('products') ?>"><h2>Lashopda</h2></a>
        <a class="nav_end" href="<?= base_url('carts') ?>"><h3>Shopping Cart (<span class="cart_quantity">4</span>)</h3></a>
    </header>
    <main>
<?php
			$imgs = json_decode($product['img_url'], TRUE);
?>
        <section class="item_panel">
            <a class="go_back" href=""><p>Go Back</p></a>
            <div class="item_details">
                <aside class="img_section">
                    <img class="main_img" src="<?= base_url('assets/img/products/') . $imgs['imgid_no'][0] ?>.jpg" alt="<?= $product['name'] ?>"/>
                    <section>
<?php
                    foreach ($imgs['imgid_no'] as $key => $img) {
?>
                        <img class="sub_img" <?php if ($key == 0) echo 'default_main_img'?> src="<?= base_url('assets/img/products/') . $img . '.jpg' ?>" alt="T-shirt"/>
<?php
                    }
?>
<!--                    <img class="sub_img default_main_img" src="../../../application/views/assets/img/products/0/products.jpg" alt="T-shirt"/>-->
<!--	                <img class="sub_img" src="../../../application/views/assets/img/products/2/Shorts.jpg" alt="T-shirt"/>-->
<!--                    <img class="sub_img" src="../../../application/views/assets/img/products/3/Shoes.jpg" alt="T-shirt"/>-->
                    </section>
                </aside>
                <aside class="desc_section">
                    <h2><?= $product['name'] ?></h2>
                    <p><?= $product['description'] ?></p>
                    <form class="buy_item" action="<?= base_url('carts/process_order') ?>" method="post">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>"/>
                        <select class="new_order_qty" name="quantity">
	                        <option value="1">1 (P <?= $product['price'] ?>)</option>
	                        <option value="2">2 (P <?= $product['price'] * 2 ?>)</option>
	                        <option value="3">3 (P <?= $product['price'] * 3 ?>)</option>
                        </select>
                        <input class="buy_product" type="submit" value="Buy"/>
                        <p class="item_added_confirm">Item added to the cart.</p>
                    </form>
                </aside>
            </div>
        </section>
        <article class="similar_items_section">
            <h3>Similar Items</h3>
<?php
		        foreach ($similar_products as $similar_product) {
					if ($product['id'] == $similar_product['id']) continue;
			        $imgs = json_decode($similar_product['img_url'], TRUE);
?>
            <section class="products">
                <figure class="item">
                    <a href="<?= base_url('products/show/' . $similar_product['id']) ?>"><img src="<?= base_url('assets/img/products/') . $imgs['imgid_no'][0] ?>.jpg" alt="<?= $similar_product['name'] ?>"/></a>
                    <h4>P <?= $similar_product['price'] ?></h4>
                </figure>
                <p><?= $similar_product['name'] ?></p>
            </section>
<?php
	        }
?>
<!--            <section class="products">-->
<!--                <figure class="item">-->
<!--                    <a href="item_page.html"><img src="../../../application/views/assets/img/products/0/products.jpg" alt="Tshirt"/></a>-->
<!--                    <h4>$19.99</h4>-->
<!--                </figure>-->
<!--                <p>T-shirt</p>-->
<!--            </section>-->
<!--            <section class="products">-->
<!--                <figure class="item">-->
<!--                    <a href="item_page.html"><img src="../../../application/views/assets/img/products/0/products.jpg" alt="Tshirt"/></a>-->
<!--                    <h4>$19.99</h4>-->
<!--                </figure>-->
<!--                <p>T-shirt</p>-->
<!--            </section>-->
<!--            <section class="products">-->
<!--                <figure class="item">-->
<!--                    <a href="item_page.html"><img src="../../../application/views/assets/img/products/0/products.jpg" alt="Tshirt"/></a>-->
<!--                    <h4>$19.99</h4>-->
<!--                </figure>-->
<!--                <p>T-shirt</p>-->
<!--            </section>-->
<!--            <section class="products">-->
<!--                <figure class="item">-->
<!--                    <a href="item_page.html"><img src="../../../application/views/assets/img/products/0/products.jpg" alt="Tshirt"/></a>-->
<!--                    <h4>$19.99</h4>-->
<!--                </figure>-->
<!--                <p>T-shirt</p>-->
<!--            </section>-->
<!--            <section class="products">-->
<!--                <figure class="item">-->
<!--                    <a href="item_page.html"><img src="../../../application/views/assets/img/products/0/products.jpg" alt="Tshirt"/></a>-->
<!--                    <h4>$19.99</h4>-->
<!--                </figure>-->
<!--                <p>T-shirt</p>-->
<!--            </section>-->
<!--            <section class="products">-->
<!--                <figure class="item">-->
<!--                    <a href="item_page.html"><img src="../../../application/views/assets/img/products/0/products.jpg" alt="Tshirt"/></a>-->
<!--                    <h4>$19.99</h4>-->
<!--                </figure>-->
<!--                <p>T-shirt</p>-->
<!--            </section>-->
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
        </article>
    </main>
</body>
</html>
