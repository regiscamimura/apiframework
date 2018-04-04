$(function () {
	$('#view_form form').submit(function () {
		$.post("/explorer/view", $("#view_form form").serialize(), function(data) { $('#result').html(data) } );
		return false;
	})
})