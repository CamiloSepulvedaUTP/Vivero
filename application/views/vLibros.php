<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Biblioteca</title>

	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/dataTables.bootstrap4.min.css" rel="stylesheet">

	<script type="text/javascript" src="assets/js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="assets/js/dataTables.bootstrap4.min.js"></script>
</head>

<style type="text/css">
	.clickeable{
		cursor: pointer;
	}
	footer {
	    position: fixed;
	    height: 25px;
	    bottom: 0;
	    width: 100%;
	}
</style>

<div class="col-sm-12" style="padding: 10px">

	<div class="btn btn-lg btn-info form-control">
		Catálogos de las Bibliotecas
	</div>

	<br/><br/>

	<table id="example" class="table table-striped table-bordered" style="width:100%">
		<thead>
			<tr>
				<th>ID</th>
				<th>Biblioteca</th>
				<th>Producto</th>
				<th>Categoría</th>
				<th>Tipo</th>
				<th>Prestamo</th>
				<th>Ubicación</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(count($Productos) > 0){
				foreach ($Productos as $key) {
					?>
					<tr>
						<td><?= $key->ID_Producto_Biblioteca ?></td>
						<td><?= $key->Biblioteca ?></td>
						<td><?= $key->Producto ?></td>
						<td><?= $key->Categoria ?></td>
						<td><?= $key->Tipo ?></td>
						<td><?= $key->Prestamo ?></td>
						<td><?= $key->Ubicacion ?></td>
					</tr>	
					<?php
				}
			}
			?>
		</tbody>
	</table>

	<button class="btn btn-primary" id="btnEntregar">Entregar Libro</button>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modalPrestamo">
	<div class="modal-dialog" role="document">
		<form id="formPrestamo" class="d-none">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Solicitar Prestamo</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label>*Cliente:</label>
					<select class="form-control" required id="selectCliente">
						<?php
						if(count($Clientes) > 0){
							foreach ($Clientes as $key) {
								?>
								<option value="<?= $key->ID_Usuario ?>"><?= $key->Nombre ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Solicitar Prestamo</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</form>
		<form id="formEntrega" class="d-none">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Entregar Libro</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<label>*ID Libro a Devolver:</label>
					<select class="form-control" required id="selectLibro">
						<?php
						if(count($LibrosPrestados) > 0){
							foreach ($LibrosPrestados as $key) {
								?>
								<option value="<?= $key->ID_Prestamo ?>"><?= $key->ID_Producto_Biblioteca ?> - <?= $key->Producto ?> - <?= $key->Nombre ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Entregar Libro</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	var libro = null;
	$(document).ready(function() {
	    $('#example').DataTable({
	    	language: {
		        "decimal": "",
		        "emptyTable": "No hay información",
		        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
		        "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
		        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
		        "infoPostFix": "",
		        "thousands": ",",
		        "lengthMenu": "Mostrar _MENU_ Entradas",
		        "loadingRecords": "Cargando...",
		        "processing": "Procesando...",
		        "search": "Buscar:",
		        "zeroRecords": "Sin resultados encontrados",
		        "paginate": {
		            "first": "Primero",
		            "last": "Ultimo",
		            "next": "Siguiente",
		            "previous": "Anterior"
		        }
		    },
		    createdRow:function(row,data,index){
		    	if(data[5] == 1){
		    		$(row).find('td:eq(5)').html('Sí').addClass('clickeable').click(function(){
		    			libro = data[0];
		    			$('#formPrestamo').removeClass('d-none');
						$('#formEntrega').addClass('d-none');
		    			$('#modalPrestamo').modal('show');
		    		});
		    	}else{
		    		$(row).find('td:eq(5)').html('No');
		    	}
		    }
	    });
	} );
	$(document).on('submit', '#formPrestamo', function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			data: {
				ID_Usuario: $('#selectCliente').val()
				,Libro: libro
			},
			url: 'index.php/Libros/Prestamo',
			success:function(res){
				location.reload();
			},
			error:function(error){
				alert('Ocurrió un error al momento de solicitar el prestamo');
				console.log(error);
			}
		})
	}).on('click', '#btnEntregar', function(e){
		e.preventDefault();
		$('#formPrestamo').addClass('d-none');
		$('#formEntrega').removeClass('d-none');
		$('#modalPrestamo').modal('show');
	}).on('submit', '#formEntrega', function(e){
		e.preventDefault();
		$.ajax({
			type: 'POST',
			data: {
				ID: $('#selectLibro').val()
			},
			url: 'index.php/Libros/Entrega',
			success:function(res){
				location.reload();
			},
			error:function(error){
				alert('Ocurrió un error al momento de solicitar el prestamo');
				console.log(error);
			}
		});
	});
</script>

<footer class="navbar-fixed-bottom">
Desarrollado por Ximena Uribe y Juan Camilo Sepúlveda
</footer>