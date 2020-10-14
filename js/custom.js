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
var id = $(this).attr('val');
// alert(id);
		$.get('returnbook?id='+id,function(data) {
		$('#returnbook').modal('show')
		 		.find('#returnbookContent')

			.html(data)

});
});

$('.borrowedbook').click(function(e){
	e.preventDefault();
	var id = $(this).attr('val');
// alert(id);
$.get('borrowedbook?id='+id,function(data) {
$('#borrowedbook').modal('show')
		 .find('#borrowedbookContent')

	.html(data)

});
});



$('.approvebtn').click(function(e){
	e.preventDefault();

$.get('approvebook',function(data) {
	$('#approvebook').modal('show')
			 .find('#approvebookContent')

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


	$('.approvebook').click(function(e){
		e.preventDefault();
		var id = $(this).attr("val");
	   $.get('approvebook?id='+id,function(data){
			$('#approvebook').modal('show')
				 .find('#approvebookContent')
				 .html(data);
	});

});

$('.borrowbook').click(function(e){
	e.preventDefault();
	var id = $(this).attr("val");
   $.get('borrowbook?id='+id,function(data){
		$('#borrowbook').modal('show')
			 .find('#borrowbookContent')
			 .html(data);
});
});


});