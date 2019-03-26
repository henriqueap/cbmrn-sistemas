<?php
if (!defined('BASEPATH'))
		exit('No direct script access allowed');
 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Odometro_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function cadastrar($data, $last=FALSE){
		date_default_timezone_set('America/Sao_Paulo');
		if (is_array($data)) {
			if (! $last) {
				$this->db->insert('odometros', $data);
				return ($this->db->affected_rows() > 0)? TRUE: FALSE;
			}
			else {
				$this->db->insert('odometros', $data);
				return ($this->db->affected_rows() > 0)? $this->db->insert_id(): FALSE;
			} 
		} 
		else return FALSE;
	}	

	/*public function listarOdometros($viaturas_id = NULL) {
		$_sql = "SELECT
							odometros.id,
							odometros.`data`,
							odometros.odometro,
							tipo_saida.tipo_saida,
							viaturas.placa,
							CONCAT(marca_veiculos.nome, ' ', modelo_veiculos.modelo) AS viatura,
							odometros.destino,
							odometros.alteracao,
							militares.matricula,
							CONCAT(patentes.sigla, ' ',militares.nome_guerra) AS militar,
							odometros.id_tipo,
							odometros.viaturas_id,
							odometros.militares_id
							FROM
							odometros
							INNER JOIN tipo_saida ON odometros.id_tipo = tipo_saida.id
							INNER JOIN viaturas ON odometros.viaturas_id = viaturas.id
							INNER JOIN modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
							INNER JOIN marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
							INNER JOIN militares ON odometros.militares_id = militares.id
							INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		$_sql .= (is_null($viaturas_id))? "" : " WHERE odometros.viaturas_id = $viaturas_id";
		$_query = $this->db->query($_sql);
		return ($this->db->query($_sql)->num_rows() > 0)? $_query->result() : FALSE;
	}*/

	public function atualizar($data) {
		$this->db->where('id', $data['id']);
		$_query = $this->db->update('odometros', $data);
		return ($_query->affected_rows() > 0)? TRUE: FALSE;
	}

	/*public function excluir($id) {
		$this->db->where('id', $id);
		$_query = $this->db->delete('odometros');
		return ($_query->affected_rows() > 0)? TRUE: FALSE;
	}*/

	public function getById($id) {
		return ($_query->num_rows() > 0)? $_query: FALSE;
	}

	public function getLast($data){
		if (is_array($data)) {
			$this->db->where('viaturas_id', $data['viaturas_id']);
			$this->db->select_max('odometro', 'max_odometro');
			$_query= $this->db->get('odometros');
			return ($_query->num_rows() > 0)? $_query->row()->max_odometro : false;
		}
		else return false;
	}

	public function getLastAction($viatura_id, $abastecimento=FALSE){
		$this->db->limit(1);
		$this->db->order_by('odometros.id', 'DESC');
		if (! $abastecimento)
			$this->db->where(array('viaturas_id'=>$viatura_id, 'tipo !='=>7));
		else
			$this->db->where(array('viaturas_id'=>$viatura_id));
		$_query= $this->db->get('odometros');
		return ($_query->num_rows() > 0)? $_query->row() : FALSE;
	}

	/* public function getInfoLastAction($viatura_id){
		$_sql = "SELECT
							viaturas.id AS viatura_id,
							viaturas.placa,
							CONCAT(modelo_veiculos.modelo, ' ', marca_veiculos.ativo) AS viatura,
							viaturas.ativo AS viatura_ativo,
							viaturas.tipo_viaturas_id AS tipo_viatura_id,
							odometros.id AS odometro_ultimo,
							odometros.`data`,
							odometros.odometro,
							odometros.alteracao,
							odometros.destino,
							odometros.tipo AS odometro_tipo,
							odometros.militares_id AS motorista_id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS motorista
							FROM
								odometros
								INNER JOIN viaturas ON odometros.viaturas_id = viaturas.id
								INNER JOIN modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
								INNER JOIN marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
								INNER JOIN militares ON odometros.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
							WHERE viaturas.id = $viatura_id
							ORDER BY
							odometros.odometro DESC
							LIMIT 1";
							#var_dump($sql); die();
		$_query = $this->db->query($_sql);
		return ($_query->num_rows() > 0)? $_query->row() : FALSE;
	} */

	/*public function validaOdometro($data_odo) {
		if (is_array($data_odo)) {
			$this->db->where('viaturas_id', $data_odo['viaturas_id']);
			$this->db->select_max('odometro', 'max_odometro');
			$_query= $this->db->get('odometros');
			return ($data_odo['odometro'] <  $_query->row()->max_odometro)? false : true;
		}
		else return false;
	}*/
}