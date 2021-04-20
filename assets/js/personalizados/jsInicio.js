var dtLabores;
var dtViveros;

$(document).ready(function(){
	dtLabores = $('#dtLabores').DataTable({
		language: language
		,data: cLabores.data
		,columns:[
			{data: 'Vivero'}
			,{data: 'Fecha'}
			,{data: 'Descripcion'}
			,{data: 'Producto'}
		]
		,dom: 'Bfrtip'
		,buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});

	dtViveros = $('#dtViveros').DataTable({
		language: language
		,data: cViveros.data
		,columns:[
			{data: 'Productor'}
			,{data: 'Vivero'}
			,{data: 'Municipio'}
			,{data: 'Departamento'}
		]
		,dom: 'Bfrtip'
		,buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	});
});