<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productores extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Productores_model');
	}

	function index(){
		$data['content_view'] = 'vProductores';
		$data['js_adicional'] = array('personalizados/jsProductores.js');
		$data['cData'] = '{"data":' . json_encode($this->db->query("
			SELECT
				'' AS Accion
				,ProductorId
				,CONCAT(Nombre,' ',Apellido) AS Nombre
			FROM Productor
		")->result()) . "}";
		$this->load->view('UI/gestion', $data);
	}

	function eliminar(){
		$id = $this->input->post('id');
		echo $this->Productores_model->eliminar($id);
	}

	function validar(){
		$id = $this->input->post('id');
		echo $this->Productores_model->validar($id);
	}

	function crear(){
		$id = $this->input->post('id');
		$data = $this->input->post('data');
		$data = json_decode($data);
		echo $this->Productores_model->crear($id, $data);
	}
}
