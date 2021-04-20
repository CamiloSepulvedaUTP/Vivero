<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Consultas</h1>
<p class="mb-4">
	Módulo de consultas del sistema
</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Labores realizadas en un vivero</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dtLabores" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Vivero</th>
						<th>Fecha</th>
						<th>Descripción</th>
						<th>Producto</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Consulta de viveros por productor</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dtViveros" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Productor</th>
						<th>Vivero</th>
						<th>Municipio</th>
						<th>Departamento</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	var cLabores = <?= $cLabores ?>;
	var cViveros = <?= $cViveros ?>;
</script>