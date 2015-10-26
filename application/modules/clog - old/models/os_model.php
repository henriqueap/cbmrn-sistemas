<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Os_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	public function getMilitares(){
		$sql = "SELECT militares.id AS idmilitar, CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar FROM militares INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query;
		} 
		else {
			return FALSE;
		}
	}

	public function getMilitar($id){
		$sql = "SELECT militares.id AS idmilitar, CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar FROM militares INNER JOIN patentes ON militares.patente_patentes_id = patentes.id  WHERE militares.id = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$row = $query->result();
			return $row->militar;
		} 
		else {
			return FALSE;
		}
	}

	public function getLotacoes(){
		$tbl = "lotacoes";
		$query = $this->db->get($tbl);
		if ($query->num_rows() > 0) {
			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function getLotacao($id){
		$tbl = "lotacoes";
		$arvore = "";
		do {
			$busca_lotacoes = $this->db->get_where($tbl,array('id'=>$id));
			if ($busca_lotacoes->num_rows() > 0) {
				$linha = $busca_lotacoes->row();
				$arvore .= "/".$linha->sigla;
				$id = $linha->superior_id;
			} 
			else {
				$arvore = $linha->sigla;
			}
		} 
		while (!is_null($id));
		return $arvore;
	}

	public function getOS($id=NULL){
		$sql = "SELECT 
						os.id, os.solicitante_militares_id AS idsolicitante, 
						CONCAT(patentes.sigla,' ',militares.nome_guerra) AS solicitante,
						os.descricao,
						os.data_solicitacao,
						os.data_inicio,
						os.observacao,
						os.concluido
					FROM
						os
					INNER JOIN 
						militares ON os.solicitante_militares_id = militares.id
					INNER JOIN 
						patentes ON militares.patente_patentes_id = patentes.id";
		if (! is_null($id)) {
			$sql .= " WHERE os.id = $id";
		}
		$os = $this->db->query($sql);
		if ($os->num_rows() > 0) {
			return $os;
		} 
		else {
			return FALSE;
		}
	}
	
	public function exists($data, $tbl) {
		$query = $this->db->get_where($tbl, $data);
		if ($query->num_rows() > 0) return FALSE;
		else return TRUE;
	}
	
	public function getEquipe($id=NULL){
		$sql = "SELECT
							equipe_os.id,
							militares.id AS idmilitar,
							patentes.sigla AS patente,
							militares.nome_guerra,
							lotacoes.sigla AS setor,
							lotacoes.id AS idsetor
							FROM
								equipe_os
								INNER JOIN militares ON equipe_os.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								INNER JOIN lotacoes ON equipe_os.lotacoes_id = lotacoes.id";
		if (! is_null($id)) {
			$sql .= " WHERE lotacoes.id = $id";
		}
		else {
			$sql .= " GROUP BY lotacoes.id";	
		}
		$query = $this->db->query($sql);
		#var_dump($query->num_rows());
		if ($query->num_rows() > 0) {
			return $query;
		} 
		else {
			return FALSE;
		}
	}

	public function inserir($data, $tbl){
		#$tbl = "os";
		$query = $this->db->insert($tbl, $data);
		if ($this->db->affected_rows() > 0) return TRUE;
		else return FALSE;
	}

	public function cancela($id, $tbl){
		if (($this->os_model->cancelado($id, $tbl) === TRUE) || ($this->os_model->concluido($id, $tbl) === TRUE)) return FALSE;
		else {
			$sql = "UPDATE $tbl SET cancelado = 1 WHERE id = $id";
			$query = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) return TRUE;
			else return FALSE;
		}
	}

	public function conclui($data, $tbl){
		#$tbl = "os";
		if (($this->os_model->cancelado($data['os_id'], $tbl) === TRUE) || ($this->os_model->concluido($data['os_id'], $tbl) === TRUE)) return FALSE;
		else {
			$sql = "UPDATE $tbl SET data_fim = now(), observacao = '".$data['observacao']."', concluido = 1 WHERE id = ".$data['os_id'];
			$query = $this->db->query($sql);
			if ($this->db->affected_rows() > 0) return TRUE;
			else return FALSE;
		}
	}

	public function cancelado($id, $tbl){
		$query = $this->db->get_where($tbl,array('id'=>$id));
		if ($query->num_rows() > 0) {
			$linha = $query->row();
			if ($linha->cancelado == 0) return FALSE;
			else return TRUE;
		}
		else return TRUE;
	}

	public function concluido($id, $tbl){
		$query = $this->db->get_where($tbl,array('id'=>$id));
		if ($query->num_rows() > 0) {
			$linha = $query->row();
			if ($linha->concluido == 0) return FALSE;
			else return TRUE;
		}
		else return TRUE;
	}

	public function getStatusOS($id){
		$tbl = "os";
		$query = $this->db->get_where($tbl,array('id'=>$id));
		if ($query->num_rows() > 0) {
			$linha = $query->row();
			#var_dump($linha);
			if ($linha->cancelado == 1) {
				$status = 'Serviço cancelado';
			}
			else {
				if (! is_null($linha->data_inicio)){
					$status = 'Serviço iniciado';
					if (is_null($linha->data_fim)){
						$status .= ', ainda não concluído';
					}
					else {
						$status = 'Serviço concluído';
					}
				}
				else $status = 'Serviço ainda não iniciado';
			}
			return $status;
		}
		else return FALSE;
	}

	public function audita($data, $acao) {
		$tbl="auditoria";
		$query=$this->db->get_where('tipo_auditoria',array('tipo'=>$acao))->row();
		$sql="INSERT INTO auditoria (data, auditoria, idtipo, idmilitar, idmodulo) VALUES (now(), '".$data['auditoria']."', ".$query->id.",".$data['idmilitar'].",".$data['idmodulo']." )";
		#var_dump($sql);
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0) return TRUE;
		else return FALSE;
	}
}