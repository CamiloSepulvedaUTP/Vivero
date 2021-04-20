<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->session->userdata('UsuarioId') != null){

			$data['cLabores'] = '{"data":' . json_encode($this->db->query("SELECT
				V.Nombre AS Vivero
				,L.Fecha
				,L.Descripcion
				,P.Nombre AS Producto
			FROM Labor L
			LEFT JOIN Producto P ON L.ProductoId = P.ProductoId
			LEFT JOIN Vivero V ON L.ViveroId = V.ViveroId")->result()) . "}";

			$data['cViveros'] = '{"data":' . json_encode($this->db->query("SELECT
				CONCAT(P.Nombre,' ',P.Apellido) AS Productor
				,V.Nombre AS Vivero
				,M.Nombre AS Municipio
				,D.Nombre AS Departamento
			FROM Productor P
			LEFT JOIN Vivero V ON P.ProductorId = V.ProductorId
			LEFT JOIN Municipio M ON V.MunicipioId = M.MunicipioId
			LEFT JOIN Departamento D ON D.DepartamentoId = D.DepartamentoId")->result()) . "}";

			$data['js_adicional'] = array('personalizados/jsInicio.js');

			$data['content_view'] = 'vInicio';
			$this->load->view('UI/gestion', $data);
		}else{
			$this->load->view('vLogin');
		}
	}

	function cerrarSesion(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
