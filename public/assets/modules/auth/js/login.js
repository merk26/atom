$("form").submit(function(e) {
	var ph = $("#phone").val(),
		pass = $("#pass").val();
	app.post('/auth/auth_check', {phone: ph, password: pass}, function (e) {
		location.reload();
	});
	return false;
});