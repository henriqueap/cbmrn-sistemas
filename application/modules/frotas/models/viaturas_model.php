<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Viaturas_model extends CI_Model {

	function __construct() {
	parent::__construct();
	$this->load->database();
	}

	public function cadastrar($data) {
		# Salvar viaturas
		if (is_array($data)) {
			//var_dump($data);
			$this->db->insert("viaturas", $data);
			return TRUE;
		}
		else {
			return FALSE;
			}
	}

	# Retorna as viaturas existentes
	public function getInfoViaturas($ativo=1) {
		$_sql = "SELECT
							viaturas.id as idviaturas,
							viaturas.placa,
							viaturas.prefixo,
							viaturas.tipo_viaturas_id,
							tipo_viaturas.tipo,
							viaturas.lotacoes_id,
							lotacoes.sigla,
							lotacoes.nome as lotacao,
							modelo_veiculos.marca_veiculos_id,
							marca_veiculos.nome as marca,
							viaturas.modelo_veiculos_id,
							modelo_veiculos.modelo,
							viaturas.ativo,
							viaturas.operante
							FROM
								viaturas
								INNER JOIN tipo_viaturas ON viaturas.tipo_viaturas_id = tipo_viaturas.id
								INNER JOIN lotacoes ON viaturas.lotacoes_id = lotacoes.id
								INNER JOIN modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
								INNER JOIN marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
							WHERE viaturas.ativo = $ativo";
		return $this->db->query($_sql);
	}

	#Retorna os dados da viatura by id.
	public function getViatura($id) {
		$sql = "SELECT
							viaturas.id,
							viaturas.prefixo,
							viaturas.placa,
							CONCAT(marca_veiculos.nome, ' ', modelo_veiculos.modelo) AS modelo,
							CONCAT(viaturas.ano_fabricacao, '/',viaturas.ano_modelo) AS ano,
							tipo_viaturas.tipo,
							lotacoes.sigla AS lotacao,
							viaturas.operante,
							viaturas.chip,
							viaturas.tipo_viaturas_id,
							viaturas.lotacoes_id
							FROM
							viaturas
							INNER JOIN tipo_viaturas ON viaturas.tipo_viaturas_id = tipo_viaturas.id
							INNER JOIN modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
							INNER JOIN marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
							INNER JOIN lotacoes ON viaturas.lotacoes_id = lotacoes.id
							WHERE viaturas.id = $id";
		$query = $this->db->query($sql);
		return ($query->num_rows() == 1)? $query->row() : FALSE;
	}

	# Retorna as viaturas existentes em um setor.
	public function getViaturaBySetor($setor_id) {
		if (! is_null($setor_id)) {
			$this->db->where('id', $id);
			$_query = $this->db->get('viaturas');
			return ($_query->num_rows() > 0)? $_query->result(): FALSE;
		}
		else return FALSE;
	}

	# Retorna os modelos cadastrados.
	public function getByIdModelo($id=NULL) {
		if ($id==NULL) {
			return $query = $this->db->get('modelo_veiculos');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('modelo_veiculos')->row(); 
		}
	}

	# Retorna as lotações existentes.
	public function getByIdSetor($id=NULL) {
		if ($id == NULL) {
			return $query = $this->db->get('lotacoes');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('lotacoes')->row(); 
		}
	}

	#Retorna os tipos de viaturas existentes.
	public function getByIdTipoViaturas($id=NULL) {
		if ($id==NULL) {
			return $query =$this->db->get('tipo_viaturas');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('tipo_viaturas')->row();
		}
	}

	# Retorna os tipos de combustiveis existentes.
	public function getByIdCombustiveis($id=NULL) {
		if ($id==NULL) {
			return $query = $this->db->get('combustiveis');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('combustiveis')->row(); 
		}
	}

	# Retorna as marcas existentes.
	public function getByIdMarcas($id=NULL) {
		if ($id==NULL) {
			return $query = $this->db->get('marca_veiculos');
		} else {
			$this->db->where('id', $id);
			return $this->db->get('marca_veiculos')->row();
		}
	}

	# Retorna os modelos existentes pela marca.
	public function getModeloVeiculos($id) {
		$query = $this->db->query("SELECT * FROM modelo_veiculos WHERE marca_veiculos_id = $id;");
		return $query->result();
	}

}