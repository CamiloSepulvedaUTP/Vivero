<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestUnit extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library("unit_test");

		$this->load->model('Usuarios_model');
		$this->load->model('Productores_model');
	}

	public function index(){
		echo "Test Unitarios módulo Usuarios";

		$test = $this->Usuarios_model->validar('1');
		$expected_result = '[{"UsuarioId":"1","Nombre":"Raul","Tipo":"A","Email":"administrador@gmail.com"}]';
		$test_name = "HU-6 / Validar Usuario";
		echo $this->unit->run($test,$expected_result,$test_name);

		$data = json_decode($expected_result)[0];
		$test = $this->Usuarios_model->crear('1', $data);
		$expected_result = 1;
		$test_name = "HU-6 / Editar Usuario";
		echo $this->unit->run($test,$expected_result,$test_name);

		//////////////////////////////////////////////////////////////////////////////////////////////////////
		echo "Test Unitarios módulo Productores";

		$test = $this->Productores_model->validar('1');
		$expected_result = '[{"ProductorId":"1","Nombre":"Camilo","Apellido":"Sepulveda"}]';
		$test_name = "HU-1 / Validar Productor";
		echo $this->unit->run($test,$expected_result,$test_name);

		$data = json_decode($expected_result)[0];
		$test = $this->Productores_model->crear('1', $data);
		$expected_result = 1;
		$test_name = "HU-1 / Editar Productor";
		echo $this->unit->run($test,$expected_result,$test_name);
	}
}
