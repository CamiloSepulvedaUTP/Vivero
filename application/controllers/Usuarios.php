<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->model('Usuarios_model');
	}

	function index(){
		$data['content_view'] = 'vUsuarios';
		$data['js_adicional'] = array('personalizados/jsUsuarios.js');
		$data['cUsuarios'] = '{"data":' . json_encode($this->db->query("
			SELECT
				'' AS Accion
				,UsuarioId
				,Nombre
				,CASE Tipo WHEN 'A' THEN 'Administrador' ELSE 'Empleado' END AS Tipo
				,Email
			FROM Usuario
		")->result()) . "}";
		$this->load->view('UI/gestion', $data);
	}

	function eliminar(){
		$id = $this->input->post('id');
		echo $this->Usuarios_model->eliminar($id);
	}

	function validar(){
		$id = $this->input->post('id');
		echo $this->Usuarios_model->validar($id);
	}

	function crear(){
		$id = $this->input->post('id');
		$data = $this->input->post('data');
		$data = json_decode($data);
		echo $this->Usuarios_model->crear($id, $data);
	}
}
