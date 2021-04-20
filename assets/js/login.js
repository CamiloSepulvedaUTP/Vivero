$('form').submit(function(e){
	e.preventDefault();
	$.ajax({
		url: base_url() + 'index.php/Login/Validacion',
		type: 'post',
		data: {
			u: $('[name=u]').val().trim()
			,p: $('[name=p]').val().trim()
		},
		success: function(res){
			if(res == 0){
				alertify.alert('Advertencia', 'La contraseña es incorrecta. Inténtalo de nuevo.', function(){
					setTimeout(function(){
						$('[name=p]').val('').focus();
					},0);
				});
			}else{
				location.reload();
			}
		}
		,error: function(error){
			console.error(error);
			alertify.alert('Error', error);
		}
	});
});