<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Listar_empresa_model extends CI_Model {

  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function listarContatosEmpresa($id=NULL, $ativo=NULL) {
  		if(is_null($id)) {
		  	if(is_null($ativo)) {
			   $query = $this->db->query("select empresas.id as idempresa,empresas.nome_fantasia, empresas.razao_social,empresas.cnpj,empresas.ativo, contatos.id as idcontato,contatos.nome, contatos.email, telefones.id as idtelefone,telefones.telefone,enderecos.logradouro,enderecos.numero,enderecos.bairro,enderecos.cidade,enderecos.cep,enderecos.complemento,enderecos.estado, contatos_das_empresas.empresas_id,contatos_das_empresas.contatos_id from empresas,contatos,telefones,enderecos,contatos_das_empresas where contatos.telefones_id=telefones.id and contatos_das_empresas.contatos_id=contatos.id and contatos_das_empresas.empresas_id=empresas.id and empresas.enderecos_id=enderecos.id");
			   if ($query->num_rows() > 0) return $query;
			   else return FALSE;
			}
			else {
			 	$query = $this->db->query("select empresas.id as idempresa,empresas.nome_fantasia, empresas.razao_social,empresas.cnpj,empresas.ativo, contatos.id as idcontato,contatos.nome, contatos.email, telefones.id as idtelefone,telefones.telefone,enderecos.logradouro,enderecos.numero,enderecos.bairro,enderecos.cidade,enderecos.cep,enderecos.complemento,enderecos.estado, contatos_das_empresas.empresas_id,contatos_das_empresas.contatos_id from empresas,contatos,telefones,enderecos,contatos_das_empresas where empresas.ativo=$ativo and contatos.telefones_id=telefones.id and contatos_das_empresas.contatos_id=contatos.id and contatos_das_empresas.empresas_id=empresas.id and empresas.enderecos_id=enderecos.id");
			 	if ($query->num_rows() > 0) return $query;
			 	else return FALSE;
			}
		}
		else {
			$query = $this->db->query("select empresas.id as idempresa,empresas.nome_fantasia, empresas.razao_social,empresas.cnpj,empresas.ativo, contatos.id as idcontato,contatos.nome, contatos.email, telefones.id as idtelefone,telefones.telefone,enderecos.id as idenderecos,enderecos.logradouro,enderecos.numero,enderecos.bairro,enderecos.cidade,enderecos.cep,enderecos.complemento,enderecos.estado, contatos_das_empresas.empresas_id,contatos_das_empresas.contatos_id from empresas,contatos,telefones,enderecos,contatos_das_empresas where contatos.telefones_id=telefones.id and contatos_das_empresas.contatos_id=contatos.id and contatos_das_empresas.empresas_id=empresas.id and empresas.enderecos_id=enderecos.id and empresas.id=".$id);
	  		if ($query->num_rows() > 0) return $query;
			else return FALSE;
		}
  	}
	public function atualizaEndereco($data2){	  
	   if (is_array($data2)) {
	    $this->db->where('id', $data2['id']);
      $query = $this->db->update('enderecos', $data2);
			return $data2['id'];
      } else {
			return FALSE;
		}	
  }
	
	public function atualizaEmpresa($data) {	  
  	if (is_array($data)) {
    	$this->db->where('id', $data['id']);
    	$query = $this->db->update('empresas', $data);
			return $data['id'];
    } else {
			return FALSE;
		}	
  }
	
	public function atualizaTelefone($data3){	  
	   if (is_array($data3)) {
		   $this->db->where('id', $data3['id']);
           $query = $this->db->update('telefones', $data3);
			return $data3['id'];
        }else{
			return FALSE;
		}	
    }
	
	public function atualizaContato($data){	  
	  if (is_array($data)) {
		   	$this->db->where('id', $data['id']);
      	$query = $this->db->update('contatos', $data);
			return $data['id'];
      } else {
			return FALSE;
		}	
  }

	public function atualizaAtivo($id){	  
	   if (!is_null($id)) {
		    $query = $this->db->query("select ativo from empresas where id=".$id)->row();			
			if($query->ativo == 1){
				$data = array('ativo'=>0);
           		$query = $this->db->update('empresas', $data, array('id'=>$id));
				return TRUE;
			}else{
				$data=array('ativo'=>1);
				$query = $this->db->update('empresas', $data, array('id'=>$id));
				return TRUE;
			}
        }else{
			return FALSE;
		}	
  }
}