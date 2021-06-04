<?php if($this->session->userdata('Tipo') != 'A'){ ?>
	<style type="text/css">
		button.btnEliminar, button#btnCrear, button[type=submit] {
			display: none;
		}
	</style>
<?php } ?>

<h1 class="h3 mb-2 text-gray-800">Usuarios</h1>
<p class="mb-4">
	Módulo de gestión de usuarios del sistema
</p>
<button class="btn btn-success mb-4" id="btnCrear">Crear</button>
<div class="card shadow mb-4">
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dtCRUD" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th></th>
						<th>UsuarioId</th>
						<th>Nombre</th>
						<th>Tipo</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="myModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Crear</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form class="modal-body" id="frmCrear" autocomplete="off">
				<p>Documento</p>
				<input type="text" class="form-control" data-db="UsuarioId" required data-id autocomplete="off">
				<p>Nombre</p>
				<input type="text" class="form-control" data-db="Nombre" required autocomplete="off" maxlength="50">
				<p>Tipo</p>
				<select class="form-control" data-db="Tipo" required autocomplete="off">
					<option value="" disabled selected hidden></option>
					<option value="A">Administrador</option>
					<option value="E">Empleado</option>
				</select>
				<p>Email</p>
				<input type="text" class="form-control" data-db="Email" required autocomplete="off" maxlength="254">
				<p>Contrasena</p>
				<input type="password" class="form-control" data-db="Contrasena" required autocomplete="off" maxlength="25">
			</form>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" form="frmCrear">Guardar</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	var cUsuarios = <?= $cUsuarios ?>;
	<?php if($this->session->userdata('Tipo') != 'A'){ ?>
		window.onload = function() {
			if (window.jQuery) {  
				$(document).find('form input, form select').attr('readonly', true);
			}
		}
	<?php } ?>
</script>