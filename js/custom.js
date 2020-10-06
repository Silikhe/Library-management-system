//loads the assign form //
$(document).ready(function() {
	
	$('.assignbook').click(function(e){
			e.preventDefault();
			
		$.get('create',function(data) {
		$('#assignbook').modal('show')
		 		.find('#assignbookContent')

			.html(data)
			
	});
	});
	$('.addauthor').click(function(e){
			e.preventDefault();
			
		$.get('addauthor',function(data) {
		$('#addauthor').modal('show')
		 		.find('#addauthorContent')

			.html(data)
			
});
});

	$('.returnbook').click(function(e){
			
			e.preventDefault();
			
		$.get('returnbook',function(data) {
		$('#returnbook').modal('show')
		 		.find('#returnbookContent')

			.html(data)

});
});




});