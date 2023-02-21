<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(Products Page) Tshirts (page 1) | Lashopda</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>" />
    <script>

        /*  For pagination highlight    */
        function pageNumHighlight(pageNum){
            $(".pagination > a").css("background-color", "white").css("color", "blue");
            for(let i = 0; i < document.querySelectorAll(".pagination > a").length; i++){
                if(pageNum === $(".pagination > a:nth-child(" + i + ")").text()){
                    $(".pagination > a:nth-child(" + i + ")").css("background-color", "#1975ff").css("color", "white");
                }
            }
        }
        /**********************************************/

        $(document).ready(function(){

            /*  Product categories selection    */
            $(document).on("click", ".products_categories > a", function(){
                categoryName = $(this).text().split("(")[0];
                $(".category_name").text(categoryName);
                $(".products > p").text(categoryName);
                pageNumHighlight(pageNum);
                return false;
            });
            /**********************************************/

            /*  Pagination at footer    */
            var pageNum = 1;
            $(".page_number").text(pageNum);
            pageNumHighlight(pageNum);

            $(document).on("click", ".pagination > a:not(.next_page)", function(){
                pageNum = $(this).text();
                $(".page_number").text(pageNum);
                pageNumHighlight(pageNum);
                return false;
            });
            $(document).on("click", ".next_page", function(){
                pageNum++;
                $(".page_number").text(pageNum);
                pageNumHighlight(pageNum);
                return false;
            });
            /**********************************************/

            /*  Pagination at catalog header    */
            $(document).on("click", ".first_page", function(){
                pageNum = 1;
                $(".page_number").text(pageNum);
                pageNumHighlight(pageNum);
                return false;
            });
            $(document).on("click", ".prev_page", function(){
                if(pageNum > 1){
                    pageNum--;
                }
                $(".page_number").text(pageNum);
                pageNumHighlight(pageNum);
                return false;
            });
            /**********************************************/

            /*  For submission of forms    */
            $(document).on("submit", "form", function(){
                pageNumHighlight(pageNum);
                return false;
            });
            /**********************************************/
        });
    </script>
</head>
<body>
    <header>
        <a href="products_page.html"><h2>Lashopda</h2></a>
        <a class="nav_end" href="<?= base_url('carts') ?>"><h3>Shopping Cart (<span class="cart_quantity">4</span>)</h3></a>
    </header>
    <main>
        <aside class="category_panel">
            <form action="" method="post">
                <input type="search" name="product_name" placeholder="Product name" />
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 17 17">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </form>
            <section class="products_categories">
                <h4>Categories</h4>
                <a href="">T-shirts(30)</a>
                <a href="">Shoes(30)</a>
                <a href="">Shorts(30)</a>
                <a class="show_all_products" href="">All Products</a>
            </section>
        </aside>
        <article class="catalog">
            <div class="subheader">
                <h2><span class="category_name">T-shirts</span> (page <span class="page_number">1</span>)</h2>
                <section class="pagination_top">
                    <a class="first_page" href="">first</a><!--
                ---><a class="prev_page" href="">prev</a><!--
                ---><p><span class="page_number">1</span></p><!--
                ---><a class="next_page" href="">next</a>
                </section>
            </div>
            <form action="" method="post">
                <label>Sorted by </label>
                <select name="sort_by">
                    <option value="0">Price: Low to High</option>
                    <option value="1">Price: High to Low</option>
                    <option value="2">Most Popular</option>
                </select>
            </form>
            <div class="products_container">
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
                    <figure class="item">
                        <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
                        <h4>$19.99</h4>
                    </figure>
                    <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
                <section class="products">
	                <figure class="item">
		                <a href="<?= base_url('products/show') ?>"><img src="<?= base_url('assets/img/products/0/products.jpg') ?>" alt="Tshirt"/></a>
		                <h4>$19.99</h4>
	                </figure>
	                <p>T-shirt</p>
                </section>
            </div>
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
