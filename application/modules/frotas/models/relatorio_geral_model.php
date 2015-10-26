<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Relatorio_geral_model extends CI_Model {

	function __construct() {
	parent::__construct();
	$this->load->database();	
	}
	public function relatorio(){
			$query = $this->db->query("select viaturas.id as idviaturas,viaturas.placa,viaturas.renavam,viaturas.chassis,viaturas.ano_modelo,viaturas.ano_fabricacao,viaturas.cor,viaturas.litros_combustivel,viaturas.km_oleo,viaturas.km_revisa,viaturas.prefixo,viaturas.tracao,viaturas.tipo_viaturas_id,viaturas.chip,viaturas.origem,viaturas.combustivel_id,viaturas.lotacoes_id,viaturas.modelo_veiculos_id,viaturas.operante as viaturasOperante,viaturas.ativo as viaturasAtivo,
		lotacoes.id as idlotacoes,lotacoes.nome as nomeLotacao,lotacoes.sigla,lotacoes.superior_id,lotacoes.ativo,marca_veiculos.id as idmarcas,marca_veiculos.nome as nomeMarca,modelo_veiculos.id as idmodelos,modelo_veiculos.modelo,modelo_veiculos.marca_veiculos_id, 
		combustiveis.id as idCombustivel,combustiveis.nome as nomeCombustivel
		from viaturas,lotacoes,marca_veiculos,modelo_veiculos,combustiveis
		where viaturas.lotacoes_id=lotacoes.id and viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id and viaturas.combustivel_id=combustiveis.id");
		return $query;
	}
	
	function relatorioFiltrar($data){	
		$query = $this->db->query("select viaturas.id as idviaturas,viaturas.placa,viaturas.renavam,viaturas.chassis,viaturas.ano_modelo,viaturas.ano_fabricacao,viaturas.cor,viaturas.litros_combustivel,viaturas.km_oleo,viaturas.km_revisa,viaturas.prefixo,viaturas.tracao,viaturas.tipo_viaturas_id,viaturas.chip,viaturas.origem,viaturas.combustivel_id,viaturas.lotacoes_id,viaturas.modelo_veiculos_id,viaturas.operante as viaturasOperante,viaturas.ativo as viaturasAtivo,
		lotacoes.id as idlotacoes,lotacoes.nome as nomeLotacao,lotacoes.sigla,lotacoes.superior_id,lotacoes.ativo,marca_veiculos.id as idmarcas,marca_veiculos.nome as nomeMarca,modelo_veiculos.id as idmodelos,modelo_veiculos.modelo,modelo_veiculos.marca_veiculos_id, 
		combustiveis.id as idCombustivel,combustiveis.nome as nomeCombustivel
		from viaturas,lotacoes,marca_veiculos,modelo_veiculos,combustiveis
		where viaturas.lotacoes_id=lotacoes.id and viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id and viaturas.combustivel_id=combustiveis.id and lotacoes.id like"."'%".$data['idLotacao']."%'"." and viaturas.tipo_viaturas_id like "."'%".$data['tipo']."%'");
		return $query;
	}
	
	public function listarLotacoes(){
		$query=$this->db->query("select * from lotacoes");
		return $query;
	}
}