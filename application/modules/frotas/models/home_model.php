<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Home_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function revisao(){
		$query = $this->db->query("select viaturas.id as idViaturas,viaturas.placa,viaturas.km_oleo,viaturas.km_revisa from viaturas");
		// var_dump($query);
		$data2=array();//este array está sendo inicalizado agora para funcionar a função array_push
		foreach ($query->result() as $row) {
			//var_dump($query);
			$query2 = $this->db->query("select  max( odometros.odometro) as maiorOdometroConclusao 
				from viaturas,tipo_servicos,servicos,odometros 
				where servicos.tipo_servicos_id=tipo_servicos.id and viaturas.id = servicos.viaturas_id and
	viaturas.id=odometros.viaturas_id AND odometros.id=servicos.odometro_id_conclusao and servicos.tipo_servicos_id=2 and viaturas.id=".$row->idViaturas)->row();
			//var_dump($query2);
			$query3=$this->db->query("select max(odometro) as 'maior' from odometros where viaturas_id=".$row->idViaturas)->row();
			//var_dump($query3);
			if($query2->maiorOdometroConclusao===NULL){
				$valor= $row->km_revisa - $query3->maior;
				if($valor<=500 && $valor>=0){
					array_push($data2,
						$data=array(
						'placa'=>$row->placa,
						'km_revisa'=>$row->km_revisa,
						'maior'=>$query3->maior,
						'opcao_revisa'=>1)
						);

					
				}elseif($valor<0){
					array_push($data2,
						$data=array(
						'placa'=>$row->placa,
						'km_revisa'=>$row->km_revisa,
						'maior'=>$query3->maior,
						'opcao_revisa'=>2)
					);
				}
			}else{

				$proxima=$query2->maiorOdometroConclusao + $row->km_revisa;
				$valor = $proxima-$query3->maior;
				
				if($valor<= 500 && $valor>= 0){ //No prazo, Alerta

					array_push($data2,
						$data=array(
							'placa'=>$row->placa,
							'km_revisa'=>$row->km_revisa,
							'proxima'=>$proxima,
							'maior'=>$query3->maior,
							'opcao_revisa'=>3
						)
					);
				}
				if( $valor < 0){
					array_push($data2,
						$data=array(
							'placa'=>$row->placa,
							'km_revisa'=>$row->km_revisa,
							'proxima'=>$proxima,
							'maior'=>$query3->maior,
							'opcao_revisa'=>4
						)
					);

				} 
			}
		}
		return $data2;
	}

	public function oleo(){
		$query = $this->db->query("select viaturas.id as idViaturas,viaturas.placa,viaturas.km_oleo,viaturas.km_revisa from viaturas");
		// var_dump($query);
		$data2=array();//este array está sendo inicalizado agora para funcionar a função array_push
		foreach ($query->result() as $row) {
			//var_dump($query);
			$query2 = $this->db->query("select max( odometros.odometro) as maiorOdometroConclusao , servicos.km_oleo 
				from viaturas,tipo_servicos,servicos,odometros
			 where servicos.tipo_servicos_id=tipo_servicos.id and viaturas.id = servicos.viaturas_id and viaturas.id=odometros.viaturas_id 
			 AND odometros.id=servicos.odometro_id_conclusao and servicos.km_oleo<>0 and viaturas.id=".$row->idViaturas)->row();
			//var_dump($query2);
			$query3=$this->db->query("select max(odometro) as 'maior' from odometros where viaturas_id=".$row->idViaturas)->row();
			//var_dump($query3);
			if($query2->maiorOdometroConclusao===NULL){
				$valor= $row->km_oleo - $query3->maior;
				if($valor<=500 && $valor>=0){
					array_push($data2,
						$data=array(
						'placa'=>$row->placa,
						'km_oleo'=>$row->km_oleo,
						'maior'=>$query3->maior,
						'opcao_oleo'=>1)
						);

					
				}elseif($valor<0){
					array_push($data2,
						$data=array(
						'placa'=>$row->placa,
						'km_oleo'=>$row->km_oleo,
						'maior'=>$query3->maior,
						'opcao_oleo'=>2)
					);
				}
			}else{

				$proxima=$query2->maiorOdometroConclusao + $row->km_oleo;
				$valor = $proxima-$query3->maior;
				
				if($valor<= 500 && $valor>= 0){ //No prazo, Alerta

					array_push($data2,
						$data=array(
							'placa'=>$row->placa,
							'km_oleo'=>$row->km_oleo,
							'proxima'=>$proxima,
							'maior'=>$query3->maior,
							'opcao_oleo'=>3
						)
					);
				}
				if( $valor < 0){
					array_push($data2,
						$data=array(
							'placa'=>$row->placa,
							'km_oleo'=>$row->km_oleo,
							'proxima'=>$proxima,
							'maior'=>$query3->maior,
							'opcao_oleo'=>4
						)
					);

				} 
			}
		}
		return $data2;
	}


	 public function pendentes(){
		$query = $this->db->query("SELECT servicos.id as idServico,  servicos.alteracao, servicos.data_abertura, servicos.data_inicio, servicos.autorizado, servicos.retroativo, servicos.justificado, empresas.nome_fantasia,servicos.situacao_id, viaturas.placa, tipo_servicos.nome, situacao.descricao as statusDescricao 
	      FROM empresas ,servicos, viaturas, tipo_servicos,situacao 
	      WHERE servicos.id_empresa = empresas.id and servicos.viaturas_id = viaturas.id and tipo_servicos.id = servicos.tipo_servicos_id and servicos.situacao_id=situacao.id");
	  	return $query;
	}

}