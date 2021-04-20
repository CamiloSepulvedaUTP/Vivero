<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function Validacion(){
		$u = $this->input->post('u');
		$p = $this->input->post('p');

		$consulta = $this->db->query("SELECT UsuarioId, Tipo, Nombre FROM Usuario WHERE Email = '{$u}' AND Contrasena = '{$p}'")->result();

		if (count($consulta) > 0) {
			$this->session->set_userdata(array(
				'UsuarioId' => $consulta[0]->UsuarioId
				,'Tipo' => $consulta[0]->Tipo
				,'Nombre' => $consulta[0]->Nombre
			));

			echo json_encode($consulta);
		}else{
			echo 0;
		}
	}
}
