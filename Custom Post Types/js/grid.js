jQuery(document).ready(function($) {
	$("#immo-grid").on("click", "figure", function() {
		window.location.href = $(this).attr("href");
	});
});