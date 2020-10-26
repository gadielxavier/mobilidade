(function(){
	$('.form-prevent-multiple-submits').on('submit', function(){
		$('.button-prevent-multiple-submits').attr('disabled', 'true');
	})
})();

$(document).ready(function() {
    $("#btnFetch").click(function() {
      $(this).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
      );
    });
});