<?php
	/** @var Shops $categories
	 * @var Products $products
	 * @var Shops $category_name
	 */
?>
<aside class="category_panel">
	<form class="form_product_search" action="#" method="post">
		<input  type="search" id="search_product" name="product_name" placeholder="Product name" />
		<button type="submit">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 17 17">
				<path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
			</svg>
		</button>
	</form>
	<h4>Categories</h4>
	<section class="products_categories">
<?php
		foreach ($categories as $category) {
?>
		<a href="<?= base_url('products/category/' . $category['id']) ?>"><?= $category['category'] ?> ( <?= $category['category_count'] ?> )</a>
<?php
		}
?>
	<!--	<a href="">Shoes(30)</a>-->
	<!--	<a href="">Shorts(30)</a>-->
		<a class="show_all_products" href="<?= base_url('products/category/0') ?>">All Products</a>
	</section>
</aside>
<article class="catalog">
	<div class="subheader">
		<h2><span class="category_name"><?= (isset($category_name['name'])) ? $category_name['name'] : 'All Products' ?></span> (page <span class="page_number">1</span>)</h2>
		<section class="pagination_top">
			<a class="first_page" href="">first</a><!--
                ---><a class="prev_page" href="">prev</a><!--
                ---><p><span class="page_number">1</span></p><!--
                ---><a class="next_page" href="">next</a>
		</section>
	</div>
	<form class="sort_form" action="<?=base_url('shops/category') ?>" method="post">
		<label for="sort">Sorted by </label>
		<select class="sort" name="sort_by" id="sort">
			<option value="0" <?php if ($this->session->flashdata('sort') !== null && ($this->session->flashdata('sort') == 0)) echo 'selected'; ?>>Price: Low to High</option>
			<option value="1" <?php if ($this->session->flashdata('sort') == 1) echo 'selected'; ?>>Price: High to Low</option>
			<option value="2" <?php if ($this->session->flashdata('sort') == 2) echo 'selected'; ?>>Most Popular</option>
		</select>
	</form>
	<div class="products_container">
<?php
		foreach ($products as $key => $product) {
			$imgs = json_decode($product['img_url'], TRUE);

?>
		<section class="products">
			<figure class="item">
				<a href="<?= base_url('products/show/' . $product['id']) ?>"><img src="<?= base_url('assets/img/products/' . $imgs['imgid_no'][0] . '.jpg') ?>" alt="<?= $product['name'] ?>"/></a>
				<h4>P <?= $product['price']?></h4>
			</figure>
			<p><?= $product['name'] ?></p>
		</section>
<?php
		}
?>
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
<!--		<section class="products">-->
<!--			<figure class="item">-->
<!--				<a href="--><?php //= base_url('products/show') ?><!--"><img src="--><?php //= base_url('assets/img/products/0/products.jpg') ?><!--" alt="Tshirt"/></a>-->
<!--				<h4>$19.99</h4>-->
<!--			</figure>-->
<!--			<p>T-shirt</p>-->
<!--		</section>-->
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
