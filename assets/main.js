$(document).ready(function () {

	$(function () {

		$("#search").keyup(function (e) {
			e.preventDefault();



			var value = $("#search").val();

			$.ajax({
				type: 'GET',
				url: 'check_price_ajax.php',
				data: 's=' + value,
				success: function (data) {
					$('.list-item').html(data);


				}

			});

		});
		return false;
	});

});
