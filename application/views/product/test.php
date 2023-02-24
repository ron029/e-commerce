<script>
	$(document).on("submit", '.buy_item', function () {
		$.post($(this).parent().attr('action'), $(this).serialize(), function (res) {
			console.log(res);
		});
	})
