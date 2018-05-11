$(document).ready(function() {

	$('.use-ajax').click(function(e) {
		//alert('gu');
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href')
		})
		.done(function(data) {
			//console.log(data);
			$('#modal-content').html(data);
		});

	});

		
});