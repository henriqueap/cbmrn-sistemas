<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Abastecimento_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function cadastrar($data){
	 	date_default_timezone_set('America/Sao_Paulo');
		if (is_array($data)) {
			if ($data['data'] == date('Y-m-d')){
				$this->db->insert("abastecimentos", $data);
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
		else return FALSE;
	}

	public function listarAbastecimentos($viaturas_id = NULL) {
		$_sql = "SELECT
							abastecimentos.id,
							viaturas.prefixo,
							viaturas.placa,
							CONCAT(marca_veiculos.nome, ' ', modelo_veiculos.modelo) AS viatura,
							lotacoes.sigla AS setor,
							odometros.odometro,
							abastecimentos.`data`,
							abastecimentos.litros,
							viaturas.litros_combustivel AS tanque,
							viaturas.chip,
							militares.matricula,
							CONCAT(patentes.sigla, ' ',militares.nome_guerra) AS militar,
							abastecimentos.viaturas_id,
							abastecimentos.lotacoes_id,
							abastecimentos.odometros_id,
							odometros.militares_id
							FROM
							abastecimentos
							INNER JOIN viaturas ON abastecimentos.viaturas_id = viaturas.id
							INNER JOIN modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id AND '' = viaturas.id
							INNER JOIN marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
							INNER JOIN combustiveis ON viaturas.combustivel_id = combustiveis.id
							INNER JOIN odometros ON abastecimentos.odometros_id = odometros.id
							INNER JOIN militares ON odometros.militares_id = militares.id
							INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
							INNER JOIN lotacoes ON viaturas.lotacoes_id = lotacoes.id";
		$_sql .= (is_null($viaturas_id))? "" : " WHERE abastecimentos.viaturas_id = $viaturas_id";
		$_query = $this->db->query($_sql);
		return ($this->db->query($_sql)->num_rows() > 0)? $_query->result() : FALSE;
	}

	/*public function atualizar($data) {
		$this->db->where('id', $data['id']);
		$_query = $this->db->update('abastecimentos', $data);
		return ($_query->affected_rows() > 0)? TRUE: FALSE;
	}*/

	/*public function excluir($id) {
		$this->db->where('id', $id);
		$_query = $this->db->delete('abastecimentos');
		return ($_query->affected_rows() > 0)? TRUE: FALSE;
	}*/

	/*public function getById($id) {
		$this->db->where('id', $id)
		$_query = $this->db->get('abastecimentos');
		return ($_query->num_rows() > 0)? $_query: FALSE;
	}*/

}