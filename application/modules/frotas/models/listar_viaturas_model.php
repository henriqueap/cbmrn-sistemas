<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/

class Listar_viaturas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function excluir($id) {
		if (!is_null($id)) {			
			$query = $this->db->query("select ativo from viaturas where id=".$id)->row();			
			if($query->ativo == 1){
				$data = array('ativo'=>0);
				$query = $this->db->update('viaturas', $data, array('id'=>$id));
			} else{
					$data=array('ativo'=>1);
					$query = $this->db->update('viaturas', $data, array('id'=>$id));
			}
			return TRUE;
		} else{
			return FALSE;
		}	
	}

	/*public function listar($ativo = 1, $id = NULL) {	
		$_sql = "SELECT
							viaturas.id, viaturas.placa,
							tipo_viaturas.tipo AS tipo_viatura,
							viaturas.prefixo, lotacoes.sigla AS setor_sigla,
							lotacoes.nome AS setor, marca_veiculos.nome AS marca,
							modelo_veiculos.modelo, viaturas.ano_fabricacao,
							viaturas.ano_modelo, viaturas.litros_combustivel,
							combustiveis.nome AS combustivel, viaturas.chip,
							viaturas.km_oleo, viaturas.km_revisa, viaturas.origem,
							viaturas.cor, viaturas.chassis, viaturas.renavam,
							viaturas.operante, viaturas.ativo, 
							viaturas.tipo_viaturas_id, viaturas.combustivel_id,
							viaturas.lotacoes_id, viaturas.modelo_veiculos_id
							FROM viaturas
							INNER JOIN tipo_viaturas ON viaturas.tipo_viaturas_id = tipo_viaturas.id
							INNER JOIN combustiveis ON viaturas.combustivel_id = combustiveis.id
							INNER JOIN 
								lotacoes ON viaturas.lotacoes_id = lotacoes.id
							INNER JOIN 
								modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
							INNER JOIN 
								marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
							WHERE viaturas.ativo = $ativo";
		$_sql .= (! is_null($id))? " AND viaturas.id = $id": "";
		$_viaturas = $this->db->query($_sql);
		return ($_viaturas->num_rows() > 0)? $_viaturas: FALSE;
	} */

	public function listar() {
		$_fields= array('viaturas.id', 'viaturas.placa',
							'tipo_viaturas.tipo AS tipo_viatura',
							'viaturas.prefixo', 'lotacoes.sigla AS setor_sigla',
							'lotacoes.nome AS setor', 'marca_veiculos.nome AS marca',
							'modelo_veiculos.modelo', 'viaturas.ano_fabricacao',
							'viaturas.ano_modelo', 'viaturas.litros_combustivel',
							'combustiveis.nome AS combustivel', 'viaturas.chip',
							'viaturas.km_oleo', 'viaturas.km_revisa', 'viaturas.origem',
							'viaturas.cor', 'viaturas.chassis', 'viaturas.renavam',
							'viaturas.operante', 'viaturas.ativo', 
							'viaturas.tipo_viaturas_id', 'viaturas.combustivel_id',
							'viaturas.lotacoes_id', 'viaturas.modelo_veiculos_id', 'DATEDIFF(now(), Max(odometros.`data`)) AS atualizado');
	
		$this->db->select($_fields);
		$this->db->from('viaturas');
		$this->db->join('tipo_viaturas', 'viaturas.tipo_viaturas_id = tipo_viaturas.id');
		$this->db->join('combustiveis', 'viaturas.combustivel_id = combustiveis.id');
		$this->db->join('lotacoes', 'viaturas.lotacoes_id = lotacoes.id');
		$this->db->join('modelo_veiculos', 'viaturas.modelo_veiculos_id = modelo_veiculos.id');
		$this->db->join('marca_veiculos', 'modelo_veiculos.marca_veiculos_id = marca_veiculos.id');
		$this->db->join('odometros', 'odometros.viaturas_id = viaturas.id', 'left');
		$this->db->group_by('viaturas.id');
		$this->db->order_by('atualizado', 'DESC');

		$_viaturas = $this->db->get();
		//echo $this->db->last_query(); die('SQL');
		return ($_viaturas->num_rows() > 0)? $_viaturas: FALSE;
	} 
	
	/*function listarViaturas($id=NULL, $ativo=NULL){	
		if(is_null($id)) {
			if(is_null($ativo)) {
					$_sql = "SELECT viaturas.id as idviaturas,viaturas.placa,viaturas.renavam,viaturas.chassis,viaturas.ano_modelo,viaturas.ano_fabricacao,viaturas.cor,viaturas.litros_combustivel,viaturas.km_oleo,viaturas.km_revisa,viaturas.prefixo,viaturas.tracao,viaturas.tipo_viaturas_id,viaturas.chip,viaturas.origem,viaturas.combustivel_id,viaturas.lotacoes_id,viaturas.modelo_veiculos_id,viaturas.operante,viaturas.ativo as viaturasAtivo,
						lotacoes.id as idlotacoes,lotacoes.nome as nomeLotacao,lotacoes.sigla,lotacoes.superior_id,lotacoes.ativo,marca_veiculos.id as idmarcas,marca_veiculos.nome as nomeMarca,modelo_veiculos.id as idmodelos,modelo_veiculos.modelo,modelo_veiculos.marca_veiculos_id, 
						combustiveis.id as idCombustivel,combustiveis.nome as nomeCombustivel, tipo_viaturas.id as idTipoViatura, tipo_viaturas.tipo as nomeTipoViatura
						from viaturas,lotacoes,marca_veiculos,modelo_veiculos,combustiveis, tipo_viaturas
						where viaturas.lotacoes_id=lotacoes.id and viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id and viaturas.combustivel_id=combustiveis.id  and viaturas.tipo_viaturas_id=tipo_viaturas.id";
					$query = $this->db->query($_sql);
					if ($query->num_rows() > 0) return $query;
					else return FALSE;
			}
			else {
				$query = $this->db->query("SELECT viaturas.id as idviaturas, viaturas.placa, viaturas.renavam, viaturas.chassis,viaturas.ano_modelo, viaturas.ano_fabricacao, viaturas.cor,viaturas.litros_combustivel, viaturas.km_oleo, viaturas.km_revisa, viaturas.prefixo, viaturas.tracao, viaturas.tipo_viaturas_id, viaturas.chip, viaturas.origem, viaturas.combustivel_id, viaturas.lotacoes_id, viaturas.modelo_veiculos_id, viaturas.operante,viaturas.ativo as viaturasAtivo, lotacoes.id as idlotacoes, lotacoes.nome as nomeLotacao, lotacoes.sigla,lotacoes.superior_id,lotacoes.ativo, marca_veiculos.id as idmarcas, marca_veiculos.nome as nomeMarca,modelo_veiculos.id as idmodelos, modelo_veiculos.modelo, modelo_veiculos.marca_veiculos_id, combustiveis.id as idCombustivel, combustiveis.nome as nomeCombustivel, tipo_viaturas.id as idTipoViatura, tipo_viaturas.tipo as nomeTipoViatura 		from viaturas, lotacoes,marca_veiculos,modelo_veiculos, combustiveis, tipo_viaturas where viaturas.ativo=$ativo and viaturas.lotacoes_id=lotacoes.id and viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id and viaturas.combustivel_id=combustiveis.id and viaturas.tipo_viaturas_id=tipo_viaturas.id");
				if ($query->num_rows() > 0) return $query;
				else return FALSE;
			}
		}
		else {
			$query = $this->db->query("SELECT viaturas.id as idviaturas, viaturas.placa, viaturas.renavam,viaturas.chassis, viaturas.ano_modelo, viaturas.ano_fabricacao, viaturas.cor,viaturas.litros_combustivel, viaturas.km_oleo, viaturas.km_revisa, viaturas.prefixo,viaturas.tracao, viaturas.tipo_viaturas_id,viaturas.chip, viaturas.origem, viaturas.combustivel_id, viaturas.lotacoes_id, viaturas.modelo_veiculos_id, viaturas.operante, viaturas.ativo as viaturasAtivo, lotacoes.id as idlotacoes, lotacoes.nome as nomeLotacao, lotacoes.sigla, lotacoes.superior_id,lotacoes.ativo, marca_veiculos.id as idmarcas, marca_veiculos.nome as nomeMarca, modelo_veiculos.id as idmodelos, modelo_veiculos.modelo, modelo_veiculos.marca_veiculos_id, combustiveis.id as idCombustivel, combustiveis.nome as nomeCombustivel, tipo_viaturas.id as idTipoViatura, tipo_viaturas.tipo as nomeTipoViatura from viaturas,lotacoes, marca_veiculos, modelo_veiculos, combustiveis, tipo_viaturas where viaturas.lotacoes_id = lotacoes.id and viaturas.modelo_veiculos_id = modelo_veiculos.id and modelo_veiculos.marca_veiculos_id = marca_veiculos.id and viaturas.combustivel_id = combustiveis.id and viaturas.tipo_viaturas_id = tipo_viaturas.id and viaturas.id = ".$id);
				if ($query->num_rows() > 0) return $query;
				else return FALSE;
		}
	} */

	public function listarPorSetor($setor_id = NULL) {	
		if (! is_null($setor_id)) {
			$_sql = "SELECT
							viaturas.id, viaturas.placa,
							tipo_viaturas.tipo AS tipo_viatura,
							viaturas.prefixo, lotacoes.sigla AS setor_sigla,
							lotacoes.nome AS setor, marca_veiculos.nome AS marca,
							modelo_veiculos.modelo, viaturas.ano_fabricacao,
							viaturas.ano_modelo, viaturas.litros_combustivel,
							combustiveis.nome AS combustivel, viaturas.chip,
							viaturas.km_oleo, viaturas.km_revisa, viaturas.origem,
							viaturas.cor, viaturas.chassis, viaturas.renavam,
							viaturas.operante, viaturas.ativo, 
							viaturas.tipo_viaturas_id, viaturas.combustivel_id,
							viaturas.lotacoes_id, viaturas.modelo_veiculos_id
							FROM viaturas
							INNER JOIN tipo_viaturas ON viaturas.tipo_viaturas_id = tipo_viaturas.id
							INNER JOIN combustiveis ON viaturas.combustivel_id = combustiveis.id
							INNER JOIN 
								lotacoes ON viaturas.lotacoes_id = lotacoes.id
							INNER JOIN 
								modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
							INNER JOIN 
								marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
							WHERE viaturas.ativo = 1
								AND viaturas.lotacoes_id = $setor_id";
			# var_dump($_sql); die();
			$_viaturas = $this->db->query($_sql);
			return ($_viaturas->num_rows() > 0)? $_viaturas: FALSE;
		} 
		else return FALSE;
	}
	
	/*public function listarViaturasFiltrar($data) {	
		$query = $this->db->query("select viaturas.id as idviaturas,viaturas.placa,viaturas.renavam,viaturas.chassis,viaturas.ano_modelo,viaturas.ano_fabricacao,viaturas.cor,viaturas.litros_combustivel,viaturas.km_oleo,viaturas.km_revisa,viaturas.prefixo,viaturas.tracao,viaturas.tipo_viaturas_id,viaturas.chip,viaturas.origem,viaturas.combustivel_id,viaturas.lotacoes_id,viaturas.modelo_veiculos_id,viaturas.operante,viaturas.ativo as viaturasAtivo,
		lotacoes.id as idlotacoes,lotacoes.nome as nomeLotacao,lotacoes.sigla,lotacoes.superior_id,lotacoes.ativo,marca_veiculos.id as idmarcas,marca_veiculos.nome as nomeMarca,modelo_veiculos.id as idmodelos,modelo_veiculos.modelo,modelo_veiculos.marca_veiculos_id, 
		combustiveis.id as idCombustivel,combustiveis.nome as nomeCombustivel
		from viaturas,lotacoes,marca_veiculos,modelo_veiculos,combustiveis
		where viaturas.ativo=1 and viaturas.lotacoes_id=lotacoes.id and viaturas.modelo_veiculos_id=modelo_veiculos.id and modelo_veiculos.marca_veiculos_id=marca_veiculos.id and viaturas.combustivel_id=combustiveis.id and lotacoes.id like"."'%".$data['idLotacao']."%'"." and viaturas.tipo_viaturas_id like "."'%".$data['tipo']."%'");
		if ($query->num_rows() > 0) return $query;
				else return FALSE;
	}*/


	/*public function listarViaturasFiltrar($data) {
		$this->input->get
		$_fields= array('viaturas.id', 'viaturas.placa',
							'tipo_viaturas.tipo AS tipo_viatura',
							'viaturas.prefixo', 'lotacoes.sigla AS setor_sigla',
							'lotacoes.nome AS setor', 'marca_veiculos.nome AS marca',
							'modelo_veiculos.modelo', 'viaturas.ano_fabricacao',
							'viaturas.ano_modelo', 'viaturas.litros_combustivel',
							'combustiveis.nome AS combustivel', 'viaturas.chip',
							'viaturas.km_oleo', 'viaturas.km_revisa', 'viaturas.origem',
							'viaturas.cor', 'viaturas.chassis', 'viaturas.renavam',
							'viaturas.operante', 'viaturas.ativo', 
							'viaturas.tipo_viaturas_id', 'viaturas.combustivel_id',
							'viaturas.lotacoes_id', 'viaturas.modelo_veiculos_id', 'DATEDIFF(now(), Max(odometros.`data`)) AS atualizado');
		
		$this->db->select($_fields);
		$this->db->from('viaturas');
		$this->db->join('tipo_viaturas', 'viaturas.tipo_viaturas_id = tipo_viaturas.id');
		$this->db->join('combustiveis', 'viaturas.combustivel_id = combustiveis.id');
		$this->db->join('lotacoes', 'viaturas.lotacoes_id = lotacoes.id');
		$this->db->join('modelo_veiculos', 'viaturas.modelo_veiculos_id = modelo_veiculos.id');
		$this->db->join('marca_veiculos', 'modelo_veiculos.marca_veiculos_id = marca_veiculos.id');
		$this->db->join('odometros', 'odometros.viaturas_id = viaturas.id');
		$this->db->group_by('viaturas.id');
		$this->db->order_by('atualizado', 'DESC');

	}*/
	
	public function atualizaOperante($id){	  
		if (!is_null($id)) {			
			$query = $this->db->query("select operante from viaturas where id=".$id)->row();			
			if($query->operante == 1){
				$data = array('operante'=>0);
				$query = $this->db->update('viaturas', $data, array('id'=>$id));				
			} else{
					$data=array('operante'=>1);
					$query = $this->db->update('viaturas', $data, array('id'=>$id));				
			}
			return TRUE;
		} else{
				return FALSE;
		}	
	}

	public function atualizaDados($data){
		if (is_array($data)){
			$this->db->where('id', $data['id']);
			$query = $this->db->update('viaturas', $data);
			return TRUE;
		}else{
			return FALSE;
		}		
	}
	 
	/*public function listarOdometros($id){	  	
		$query = $this->db->query("select odometros.id as idodometros,odometros.`data`, odometros.odometro, odometros.tipo, odometros.alteracao, odometros.destino,odometros.militares_id, odometros.viaturas_id, viaturas.id as idviaturas,viaturas.placa, modelo_veiculos.modelo, marca_veiculos.nome, militares.id as idmilitares, militares.nome_guerra, militares.patente_patentes_id, patentes.id as idpatentes, patentes.sigla from odometros,viaturas,militares,patentes,modelo_veiculos,marca_veiculos where militares.id=odometros.militares_id and militares.patente_patentes_id = patentes.id and odometros.viaturas_id = viaturas.id and viaturas.modelo_veiculos_id = modelo_veiculos.id and modelo_veiculos.marca_veiculos_id = marca_veiculos.id and viaturas.id = ".$id);
		return $query;		
	}*/

	public function listarOdometros($id = NULL) {
		$_sql = "SELECT
							viaturas.id,
							viaturas.placa,
							CONCAT(marca_veiculos.nome, ' ', modelo_veiculos.modelo) AS viatura,
							viaturas.tipo_viaturas_id,
							tipo_viaturas.tipo AS tipo_viatura,
							lotacoes.sigla AS lotacao,
							viaturas.litros_combustivel,
							viaturas.chip,
							odometros.odometro,
							odometros.`data` AS dia,
							odometros.destino,
							odometros.alteracao,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
							odometros.militares_id,
							odometros.id AS odometros_id,
							odometros.tipo AS tipo_odometro
							FROM
								odometros
								INNER JOIN viaturas ON odometros.viaturas_id = viaturas.id
								INNER JOIN modelo_veiculos ON viaturas.modelo_veiculos_id = modelo_veiculos.id
								INNER JOIN marca_veiculos ON modelo_veiculos.marca_veiculos_id = marca_veiculos.id
								INNER JOIN tipo_viaturas ON viaturas.tipo_viaturas_id = tipo_viaturas.id
								INNER JOIN lotacoes ON viaturas.lotacoes_id = lotacoes.id
								INNER JOIN militares ON odometros.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		$_sql .=  (is_null($id))? "": " WHERE viaturas.id = $id";
		$query = $this->db->query($_sql);
		return ($query->num_rows() > 0)? $query->result(): false;		
	}
	 
	public function listarOdometrosFiltrar($data){	
		/*
		$data_inicial = date('Y-m-d', strtotime($data['data_inicial']));
		$data_final = date('Y-m-d',strtotime($data['data_final']));*/
		
		$query=$this->db->query("select odometros.id as idodometros,odometros.`data`, odometros.odometro,odometros.alteracao, odometros.destino, odometros.militares_id, odometros.viaturas_id, viaturas.id as idviaturas, viaturas.placa, modelo_veiculos.modelo, marca_veiculos.nome, militares.id as idmilitares, militares.nome_guerra, militares.patente_patentes_id, patentes.id as idpatentes, patentes.sigla from  odometros, viaturas, militares, patentes, modelo_veiculos, marca_veiculos where  militares.id=odometros.militares_id and militares.patente_patentes_id = patentes.id and odometros.viaturas_id = viaturas.id and viaturas.modelo_veiculos_id = modelo_veiculos.id and modelo_veiculos.marca_veiculos_id = marca_veiculos.id and viaturas.id = "."'".$data['id']."'"." and odometros.`data`>="."'".$data['data_inicial']."'"." and odometros.`data`<="."'".$data['data_final']."'");				
		return $query;				
	}
	 
	public function atualizaDadosOdometro($data){
		if (is_array($data)){
			$this->db->where('id', $data['id']);
			$query = $this->db->update('odometros', $data);
			return TRUE;
		} else{
			return FALSE;
		}		
	}
	
	public function listarServicos($id){
		$query=$this->db->query("select servicos.id as idservicos, servicos.data_inicio, servicos.data_fim, servicos.alteracao,servicos.tipo_servicos_id, servicos.viaturas_id, viaturas.id as idviaturas, viaturas.placa, tipo_servicos.id as idtipos, tipo_servicos.nome from servicos, viaturas, tipo_servicos where servicos.tipo_servicos_id = tipo_servicos.id and viaturas.id = servicos.viaturas_id and viaturas.id = ".$id);
		return $query;
	}
	
	public function listarServicosFiltrar($data){
		if($data['idTipo']==""){
			$query=$this->db->query("select servicos.id as idservicos, servicos.data_inicio, servicos.data_fim, servicos.alteracao, servicos.tipo_servicos_id, servicos.viaturas_id, viaturas.id as idviaturas, viaturas.placa, tipo_servicos.id as idtipos, tipo_servicos.nome from servicos, viaturas, tipo_servicos where servicos.tipo_servicos_id = tipo_servicos.id and viaturas.id = servicos.viaturas_id and viaturas.id = "."'".$data['id']."'"." and servicos.data_inicio >= "."'".$data['data_inicial']."'"." and servicos.data_inicio <= "."'".$data['data_final']."'"." like tipo_servicos.id='%%'");
			return $query;
		} else{
			$query=$this->db->query("select servicos.id as idservicos, servicos.data_inicio, servicos.data_fim, servicos.alteracao, servicos.tipo_servicos_id, servicos.viaturas_id, viaturas.id as idviaturas, viaturas.placa, tipo_servicos.id as idtipos, tipo_servicos.nome from servicos, viaturas, tipo_servicos where servicos.tipo_servicos_id = tipo_servicos.id and viaturas.id = servicos.viaturas_id and viaturas.id = "."'".$data['id']."'"." and servicos.data_inicio >= "."'".$data['data_inicial']."'"." and servicos.data_inicio <= "."'".$data['data_final']."'"."and tipo_servicos.id = "."'".$data['idTipo']."'");
			return $query;
		}
	}
			
	public function getByIdTipoServicos(){
		$query=$this->db->query("select id, nome from tipo_servicos");
		return $query;
	}
	
	public function listarAbastecimentos($id){
		$query=$this->db->query("select abastecimento.id as idabastecimentos, abastecimento.`data`, abastecimento.`data`, abastecimento.litros, abastecimento.odometros_id, abastecimento.viaturas_id, viaturas.id as idviaturas, viaturas.placa, odometros.id as idodometros, odometros.odometro from abastecimento, viaturas, odometros where viaturas.id = abastecimento.viaturas_id and abastecimento.odometros_id = odometros.id and viaturas.id = ".$id);
		return $query;
	}
	
	public function listarAbastecimentosFiltrar($data){
		$query=$this->db->query("select abastecimento.id as idabastecimentos, abastecimento.`data`, abastecimento.`data`, abastecimento.litros, abastecimento.odometros_id, abastecimento.viaturas_id, viaturas.id as idviaturas,viaturas.placa, odometros.id as idodometros, odometros.odometro from abastecimento, viaturas, odometros where viaturas.id = abastecimento.viaturas_id and abastecimento.odometros_id = odometros.id and viaturas.id = "."'".$data['id']."'"." and abastecimento.`data` >= "."'".$data['data_inicial']."'"." and abastecimento.`data` <= "."'".$data['data_final']."'");
		return $query;
	}
	 
}