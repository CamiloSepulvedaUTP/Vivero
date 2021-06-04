<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productores_model extends CI_Model {

	function validar($id){
		$consulta = $this->db->query("SELECT
			ProductorId
			,Nombre
			,Apellido
		FROM Productor WHERE ProductorId = '$id'")->result();

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
			$this->db->where('ProductorId', $id)
				->update('Productor', $data);
			return 1;
		}else{
			// crear
			$data->ProductorId = $id;
			$this->db->insert('Productor', $data);
			return 2;
		}
	}

	function eliminar($id){
		$this->db->where('ProductorId', $id)
				->delete('Productor');
		return 1;
	}
}
