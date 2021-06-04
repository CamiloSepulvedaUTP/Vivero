<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios_model extends CI_Model {

	function validar($id){
		$consulta = $this->db->query("SELECT
			UsuarioId
			,Nombre
			,Tipo
			,Email
		FROM Usuario WHERE UsuarioId = '$id'")->result();

		return json_encode($consulta);
	}

	function crear($id, $data){
		$validar = $this->validar($id);
		if(count(json_decode($validar)) > 0){
			$validar = 1;
		}else{
			$validar = 0;
		}
		if($validar == 1){
			// editar
			$this->db->where('UsuarioId', $id)
				->update('Usuario', $data);
			return 1;
		}else{
			// crear
			$data->UsuarioId = $id;
			$this->db->insert('Usuario', $data);
			return 2;
		}
	}

	function eliminar($id){
		$this->db->where('UsuarioId', $id)
				->delete('Usuario');
		return 1;
	}
}
