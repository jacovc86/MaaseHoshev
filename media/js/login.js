$(document).ready(function() {
	$('#register_here').click(function() {
		if($('#login_top_div').hasClass('resize')) {
			$('#login_top_div').animate({
				height: '+=' + 300
			},function() {
				$(this).removeClass('resize');
				$('#registration_container').show();
			});
		}
	});
});