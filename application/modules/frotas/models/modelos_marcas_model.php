<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Modelos_marcas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function selecionar() {
		$query = $this->db->query('SELECT id FROM modelo_veiculos order by id asc');
		return $query;
	}

	public function atualizar($data) {
		#atualizar dados
		$this->db->where('id', $data['id']);
		return $this->db->update('modelo_veiculos', $data);
	}

	public function testaExiste($id) {
		$query = $this->db->query("SELECT modelo_veiculos_id from viaturas where modelo_veiculos_id=$id");
		if ($query->num_rows() < 1) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function excluir($id) {
		if (!is_null($id)) {
			$query = $this->db->query("SELECT ativo from modelo_veiculos where id=$id")->row();
			if ($query->ativo == 1) {
				$data = array('ativo'=>0);
				$query = $this->db->update('modelo_veiculos', $data, array('id'=>$id));
			} else {
				$data = array('ativo'=>1);
				$query = $this->db->update('modelo_veiculos', $data, array('id'=>$id));
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function getById($id) {
		#Pegar id de cada Modelo
		$this->db->where('id', $id);
		return $this->db->get('modelo_veiculos')->row();
	}

	# Retorna as marcas existentes na Tabela marca_veiculos
	public function getByIdMarcas($id=NULL) {
		if ($id==NULL) {
				$query = $this->db->get('marca_veiculos');
			} else {
				$this->db->where('id', $id);
				$query=$this->db->get('marca_veiculos');
			}
		return $query->result(); 
	}

	public function cadastrar($data) {
		if (is_array($data)) {
			$this->db->insert('modelo_veiculos', $data);
			return TRUE;
		}
		else return FALSE;
	}

	public function listar(){
		#Listar modelo e marca correspondente em ordem 
		$query = $this->db->query('SELECT modelo_veiculos.ativo, modelo_veiculos.id, marca_veiculos.nome , modelo_veiculos.modelo FROM marca_veiculos, modelo_veiculos WHERE modelo_veiculos.marca_veiculos_id = marca_veiculos.id order by id asc');
		return $query->result();
	}
}
