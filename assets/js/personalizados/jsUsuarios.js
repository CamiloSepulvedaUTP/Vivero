var crear = null;

var dtCRUD;

$(document).ready(function(){
	dtCRUD = $('#dtCRUD').DataTable({
		language: language
		,data: cUsuarios.data
		,columns:[
			{data: 'Accion', orderable: false}
			,{data: 'UsuarioId'}
			,{data: 'Nombre'}
			,{data: 'Tipo'}
			,{data: 'Email'}
		]
		,createdRow: function ( row, data, index ) {
			$(row).find('td:eq(0)').html(`<div class="btn-group btn-group-sm" role="group">
				<button type="button" class="btn btn-success btnEditar"><i class="fas fa-pen"></i></button>
    			<button type="button" class="btn btn-danger btnEliminar"><i class="fas fa-trash-alt"></i></button>
			</div>`);
			$(row).on('click', '.btnEditar', function(e){
				e.preventDefault();
				
			})
			.on('click', '.btnEliminar', function(e){
				e.preventDefault();
				alertify.confirm('¿Está seguro de eliminar el usuario?', function(){
					$.ajax({
						type: 'POST',
						data: {
							id: data['UsuarioId']
						},
						url: 'Usuarios/Eliminar',
						success:function(res){
							if(res == 1){
								alertify.alert('Advertencia', 'Registro eliminado satisfactoriamente', function(){
									location.reload();
								});
							}else{
								alertify.error('Ocurrió un problema al momento de eliminar el registro');
							}
						},
						error:function(error){
							alert('Ocurrió un error al momento de eliminar el registro');
							console.error(error);
						}
					});
				},function(){});
			})
			.on('click', '.btnEditar', function(e){
				e.preventDefault();
				crear = data['UsuarioId'];
				$('#myModal').modal();
			});
		}
		,dom: 'Bfrtip'
		,buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
});

$('#btnCrear').click(function(e){
	e.preventDefault();
	crear = null;
	$('#myModal').modal();
});

$('#frmCrear').on('submit', function(e){
	e.preventDefault();
	var data = {};
	$('#frmCrear').find('[data-db]').each(function(){
		data[$(this).attr('data-db')] = $(this).val();
	});

	$.ajax({
			type: 'POST',
			data: {
				id: crear
				,data: JSON.stringify(data)
			},
			url: 'Usuarios/Crear',
			success:function(res){
				switch(res){
					case '1':
						alertify.alert('Advertencia', 'Usuario actualizado éxitosamente', function(){
							location.reload();
						});
					break;
					case '2':
						alertify.alert('Advertencia', 'Usuario creado éxitosamente', function(){
							location.reload();
						});
					break;
					default:
						alertify.alert('Advertencia', 'Al parecer no se pudo crear el registro por un error inesperado');
						console.error(res);
					break;
				}
			},
			error:function(error){
				alert('Ocurrió un error al momento de eliminar el registro');
				console.error('Error', error);
			}
		});
});

$(document).on('shown.bs.modal', function(){
	$('#frmCrear').trigger('reset');
	if(crear != null){
		$(this).find('[data-id]').val(crear).change();
	}
});

$(document).on('change', '[data-id]', function(){
	crear = $(this).val();
	$('#frmCrear').trigger('reset');
	if(crear == null || crear == ''){
	}else{
		$(this).val(crear);
		$.ajax({
			type: 'POST',
			data: {
				id: crear
			},
			url: 'Usuarios/Validar',
			success:function(res){
				var respuesta = JSON.parse(res);
				if(respuesta.length > 0){
					var object = respuesta[0];
					for (const property in object) {
						$('[data-db="'+property+'"]').val(`${object[property]}`);
					}
				}
			},
			error:function(error){
				alert('Ocurrió un error al momento de eliminar el registro');
				console.log(error);
			}
		});
	}
});