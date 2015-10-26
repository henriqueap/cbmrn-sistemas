<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servicos_concluidos_model extends CI_Model {
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

  public function listarServicos(){
    $query1=$this->db->query("SELECT id from servicos");
    $var=$query1->num_rows();
    $i=0;
    foreach($query1->result() as $row):
      
      $query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.data_inicio, servicos.data_entrega,servicos.data_fim, servicos.data_entrega, servicos.autorizado, servicos.justificado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome as nomeServico, situacao.descricao as statusDescricao, SUM(CAST(valor AS DECIMAL(10,2))) as valorNotas
     FROM empresas ,servicos, viaturas, tipo_servicos, situacao, notas_fiscais,notas_fiscais_servico 
      WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id and notas_fiscais_servico.servicos_id = servicos.id and notas_fiscais_servico.notas_fiscais_id = notas_fiscais.id and servicos.id=". $row->id)->result_array();
    foreach ($query as $value) {
      # code...
      $data[$i]=$value;
    }
    $i++;
    endforeach;
    return $data;
  }

  public function listarServicosFiltrar($data2){
    $query1=$this->db->query("SELECT id from servicos");
    $var=$query1->num_rows();
    $i=0;
    foreach($query1->result() as $row):
      $query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.data_inicio, servicos.data_entrega, servicos.data_fim, servicos.data_entrega, servicos.autorizado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome as nomeServico, situacao.descricao as statusDescricao, SUM(CAST(valor AS DECIMAL(10,2))) as valorNotas
      FROM empresas ,servicos, viaturas, tipo_servicos, situacao, notas_fiscais,notas_fiscais_servico 
      WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and servicos.viaturas_id = "."'".$data2['viaturas_id']."'"." and servicos.data_inicio>="."'".$data2['data_inicio']."'"." and servicos.data_inicio<="."'".$data2['data_fim']."'"." and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id and notas_fiscais_servico.servicos_id = servicos.id and notas_fiscais_servico.notas_fiscais_id = notas_fiscais.id and servicos.id=". $row->id)->result_array();
        foreach ($query as $value) {
        # code...
        $data[$i]=$value;
      }
    $i++;
    endforeach;
    return $data;
  }

  public function listarServicosFiltrarCanceladosNaoAutorizados($data){
   
    if(is_array($data)){
      if($data['intTipo']==""){
        //echo "entrou";
        $query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.justificado, servicos.data_inicio, servicos.data_entrega, servicos.data_fim, servicos.data_entrega, servicos.autorizado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome as nomeServico, situacao.descricao as statusDescricao
        FROM empresas ,servicos, viaturas, tipo_servicos, situacao
        WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and servicos.data_inicio>="."'".$data['data_inicio']."'"." and servicos.data_inicio<="."'".$data['data_fim']."'"." and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id ");
        
       return $query;
      }
      elseif($data['intTipo']==1){
        $query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.justificado, servicos.data_inicio, servicos.data_entrega, servicos.data_fim, servicos.data_entrega, servicos.autorizado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome as nomeServico, situacao.descricao as statusDescricao
        FROM empresas ,servicos, viaturas, tipo_servicos, situacao
        WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and servicos.data_inicio>="."'".$data['data_inicio']."'"." and servicos.data_inicio<="."'".$data['data_fim']."'"." and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id and servicos.situacao_id=6 ");
       return $query;
      } 
      elseif($data['intTipo']==2){
        $query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.justificado, servicos.data_inicio, servicos.data_entrega, servicos.data_fim, servicos.data_entrega, servicos.autorizado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome as nomeServico, situacao.descricao as statusDescricao
        FROM empresas ,servicos, viaturas, tipo_servicos, situacao
        WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and servicos.data_inicio>="."'".$data['data_inicio']."'"." and servicos.data_inicio<="."'".$data['data_fim']."'"." and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id and servicos.autorizado=0");
       return $query;
      }
      else{
        return false;
      }
    }
  }

  public function atualizarEntrega($data){ 
    
     $query = $this->db->query("select data_fim from servicos where servicos.id=".$data['id']); 
      foreach ($query->result() as $row)
      {
         echo $row->data_fim;
      }
      
      if($data['data_entrega']>=$row->data_fim){
        $query = $this->db->update('servicos', $data, array('id'=>$data['id']));   
      return TRUE;
    }else{
      return FALSE;
    } 
  }

  public function listarNenhumServico(){
    $query = $this->db->query("select * from servicos")->result(); 
    if(is_array($query)==""){
      return false;
    } else
    return true;
  }

  public function listarViaturas(){
    $query = $this->db->query("select * from viaturas")->result(); 
    if(is_array($query)==""){
      return false;
    } else
    return $query;
  }

}