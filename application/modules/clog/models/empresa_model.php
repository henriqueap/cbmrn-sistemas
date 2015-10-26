<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Empresa_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function cadastroRetorno($data2) {	  
		if (is_array($data2)) {
			$query = $this->db->insert('enderecos', $data2); 
			return mysql_insert_id();
		} 
		else return FALSE;	
	}
	
	public function cadastroEmpresa($data) {	  
		if (is_array($data)) {
			$query = $this->db->insert('empresas', $data);
			return mysql_insert_id();
		} 
		else return FALSE;	
	}

	public function cadastroRetornoTelefone($data3) {	  
		if (is_array($data3)) {
			$query = $this->db->insert('telefones', $data3);
			return mysql_insert_id();
		} 
		else return FALSE;	
	}

	public function cadastroContato($data) {	  
		if (is_array($data)) {
			$query = $this->db->insert('contatos', $data);
			return mysql_insert_id();
		} 
		else return FALSE;
	}

	public function cadastroContatosEmpresa($data) {			
		if (is_array($data)) {
			$query = $this->db->insert('contatos_das_empresas', $data);
			return TRUE;
		} 
		else return FALSE;  
	}


	public function consultaEmpresa($filter) {
		if (is_array($filter)) {
			# $this->db->select('empresas.id as id_empresas, empresas.nome_fantasia, empresas.razao_social, empresas.cnpj, empresas.ativo, empresas.enderecos_id, telefones.id');
			$query = $this->db->query("select * , empresas.id as id_empresa, contatos.id as id_contatos, telefones.id as id_telefone, enderecos.id as id_endereços 
				from empresas,contatos,contatos_das_empresas, telefones, enderecos
				where contatos_das_empresas.empresas_id = empresas.id and contatos_das_empresas.contatos_id = contatos.id and contatos.telefones_id = telefones.id and empresas.enderecos_id = enderecos.id");
			//$this->db->from('empresas');
			//$this->db->join('enderecos', 'empresas.enderecos_id = enderecos.id');
			# $this->db->join('telefones', 'empresas.telefones_id = telefones.id');

			if (isset($filter['razao_social'])) {
				$this->db->like('empresas.razao_social', $filter['razao_social']);
			}

			if (isset($filter['nome_fantasia'])) {
				$this->db->like('empresas.nome_fantasia', $filter['nome_fantasia']);
			}

			if (isset($filter['cnpj'])) {
				$this->db->like('empresas.cnpj', $filter['cnpj']);
			}

			# $this->db->where('contatos.telefones_id=telefones.id and contatos_das_empresas.contatos_id=contatos.id and contatos_das_empresas.empresas_id=empresas.id and empresas.enderecos_id=enderecos.id');
			//$query = $this->db->get();
			return $query;
		}
		else return FALSE;
	}

	public function atualizaEndereco($data2) {   
		if (is_array($data2)) {
			$this->db->where('id', $data2['id']);
			$query = $this->db->update('enderecos', $data2);
			return $data2['id'];
		}
		else return FALSE;
	}
	
	public function atualizaEmpresa($data) {    
		if (is_array($data)) {
			$this->db->where('id', $data['id']);
			$query = $this->db->update('empresas', $data);
			return $data['id'];
		} 
		else return FALSE; 
	}
	
	public function atualizaTelefone($data3) {   
		if (is_array($data3)) {
			$this->db->where('id', $data3['id']);
			$query = $this->db->update('telefones', $data3);
			return $data3['id'];
		}
		else return FALSE; 
	}
	
	public function atualizaContato($data) {   
		if (is_array($data)) {
			$this->db->where('id', $data['id']);
			$query = $this->db->update('contatos', $data);
			return $data['id'];
		}
		else return FALSE;
	}

	public function atualizaAtivo($id) {   
		if (!is_null($id)) {
				$query = $this->db->query("select ativo from empresas where id=".$id)->row();     
				#var_dump($query);
			if ($query->ativo == 1) {
				$data = array('ativo'=>0);
							$query = $this->db->update('empresas', $data, array('id'=>$id));
				return TRUE;
			}
			else {
				$data=array('ativo'=>1);
				$query = $this->db->update('empresas', $data, array('id'=>$id));
				return TRUE;
			}
		}
		else return FALSE; 
	}
}