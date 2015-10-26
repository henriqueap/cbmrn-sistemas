<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Servicos_pendentes_model extends CI_Model {
  function __construct() {
    parent::__construct();
    $this->load->database();
  }

	public function listarServicos(){
		$query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.data_abertura, servicos.data_inicio, servicos.autorizado, servicos.retroativo, servicos.justificado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome, situacao.descricao as statusDescricao 
      FROM empresas ,servicos, viaturas, tipo_servicos,situacao 
      WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id");
  
		return $query;
	}
  public function listarServicosFiltrar($data){
    $query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.data_abertura, servicos.data_inicio, servicos.autorizado, servicos.retroativo, servicos.justificado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome, situacao.descricao as statusDescricao 
      FROM empresas ,servicos, viaturas, tipo_servicos,situacao 
      WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and servicos.data_abertura>=" ."'".$data['data_inicial']."'". " and servicos.data_abertura<="."'". $data['data_final']."'"." and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id");
  
    return $query;
  }
  public function detalhamentoServicos($idServicos){
    $query = $this->db->query("SELECT servicos.id as idServico, servicos.retroativo, servicos.alteracao, servicos.data_inicio, servicos.data_fim, servicos.autorizado, servicos.justificado, servicos.tipo_servicos_id,  empresas.nome_fantasia, empresas.id as idEmpresa, contatos.nome as nomeContato,servicos.situacao_id, viaturas.placa, viaturas.id as idViatura, modelo_veiculos.modelo, marca_veiculos.nome as nomeMarca, tipo_servicos.nome as nomeServicos, situacao.descricao as statusDescricao 
      FROM empresas ,servicos, viaturas, modelo_veiculos, marca_veiculos, tipo_servicos,situacao,contatos, contatos_das_empresas 
      WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id and contatos.id=contatos_das_empresas.contatos_id and empresas.id=contatos_das_empresas.empresas_id and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id and servicos.id=$idServicos");
  
    return $query->row();
  }
  public function carregaNotaFiscal($idServicos){
    $query = $this->db->query("SELECT  * from notas_fiscais, notas_fiscais_servico where notas_fiscais_servico.notas_fiscais_id=notas_fiscais.id and notas_fiscais_servico.servicos_id=$idServicos");
  
    return $query;
  }

 public function cadastroRetornoIdOdometroExecucao($data){ 
   $query = $this->db->query("select max(odometro) as 'maior' from odometros where viaturas_id=".$data['viaturas_id']); 
    foreach ($query->result() as $row)
    {
       echo $row->maior;
    }
    $query2 = $this->db->query("select data_abertura from servicos where servicos.id=".$data['id']); 
    foreach ($query2->result() as $row2)
    {
       echo $row2->data_abertura;
    }
    if($data['odometro']>=$row->maior && $data['data']>=$row2->data_abertura){
            $data2=array(
              'data'=>$data['data'],
              'viaturas_id'=>$data['viaturas_id'],
              'militares_id'=>$data['militares_id'],
              'odometro'=>$data['odometro'],
              'tipo'=>$data['tipo']); 
             $query = $this->db->insert('odometros', $data2);
        return mysql_insert_id();
          }else{
        return FALSE;
      } 
    }

    public function cadastroRetornoIdOdometroConclusao($data){ 
      $query = $this->db->query("select max(odometro) as 'maior' from odometros where viaturas_id=".$data['viaturas_id']); 
      foreach ($query->result() as $row)
      {
         echo $row->maior;
      }
      $query2 = $this->db->query("select data_inicio from servicos where servicos.id=".$data['id']); 
      foreach ($query2->result() as $row2)
      {
         echo $row2->data_inicio;
      }
      if($data['odometro']>=$row->maior && $data['data']>=$row2->data_inicio){
              $data2=array(
                'data'=>$data['data'],
                'viaturas_id'=>$data['viaturas_id'],
                'militares_id'=>$data['militares_id'],
                'odometro'=>$data['odometro'],
                'tipo'=>$data['tipo']); 
               $query = $this->db->insert('odometros', $data2);
          return mysql_insert_id();
            }else{
          return FALSE;
        } 
    }
  
   public function atualizarServico($data2){
     if(is_array($data2)){ 
      $this->db->where('id', $data2['id']);
      $query = $this->db->update('servicos', $data2);
      return TRUE;
    }else{
      return FALSE;
    }
  }

  #Apenas por enquanto que o SESSION nao esta funcionando
  public function getByIdMilitar() {
    $query = $this->db->get('militares');
    //$query->result_array();
    foreach ($query->result_array() as $row)
    {
       return $row['id'];
    }
  }

  public function atualizarCancelado($id){ 
    if (!is_null($id)) {      
      $query = $this->db->query("select situacao_id from servicos where id=".$id)->row();      
      if($query->situacao_id != 6){
        $data = array('situacao_id'=>6);
        $query = $this->db->update('servicos', $data, array('id'=>$id));        
      }
      return TRUE;
    }else{
      return FALSE;
    } 
  }

  public function atualizarAutorizacao($data){ 
    //var_dump($data);     
      $query = $this->db->query("select autorizado from servicos where id=".$data['id'])->row();      
      if($query->autorizado == 0){
        $query = $this->db->update('servicos', $data, array('id'=>$data['id']));        
      //}
      return TRUE;
    }else{
      return FALSE;
    } 
  }




}