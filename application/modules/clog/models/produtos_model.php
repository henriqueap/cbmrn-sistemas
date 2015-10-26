<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Produtos_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * @param $filter Array.
	 *
	 */
	public function consulta_produtos_estoque($filter) {
		$this->db->select('marcas_produtos.marca AS marcas, produtos.modelo AS nome_produtos, estoques.quantidade AS quantidade_estoque, grupo_produtos.nome AS grupo, lotacoes.sigla AS almoxarifado, estoques.lotacoes_id');
		$this->db->from('produtos');
		// Joins
		$this->db->join('grupo_produtos', 'produtos.grupo_produtos_id = grupo_produtos.id');
		$this->db->join('marcas_produtos', 'produtos.marcas_produtos_id = marcas_produtos.id');
		$this->db->join('estoques', 'produtos.id = estoques.produtos_id');
		$this->db->join('lotacoes', 'estoques.lotacoes_id = lotacoes.id');
		// Filtros inteligentes
		if (isset($filter['zerados']))
			$this->db->where('estoques.quantidade >', 0);
		if (isset($filter['modelo']))
			$this->db->like('produtos.modelo', $filter['modelo']);
		if (isset($filter['marcas_produtos_id']))
			$this->db->like('produtos.marcas_produtos_id', $filter['marcas_produtos_id']);
		if (isset($filter['lotacoes_id']))
			$this->db->like('estoques.lotacoes_id', $filter['lotacoes_id']);

		$query = $this->db->get();
		return $query;
	}

	public function consulta_produtos($filter) {
		$sql = "SELECT
							marcas_produtos.marca AS marcas,
							produtos.modelo AS nome_produtos,
							grupo_produtos.nome AS grupo_produtos,
							produtos.id
							FROM
								produtos
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id";
		if (count($filter) > 0) {
			$sql .= " WHERE";
			foreach ($filter as $key => $value) {
				if ($key == "modelo") {
					$sql .= " (produtos.modelo LIKE '%$value%') AND";
				}
				else {
					$sql .= " ($key LIKE '$value') AND";
				}
			}
			$sql = rtrim($sql, " AND");
		}
		$sql .= " ORDER BY grupo_produtos.id ASC";
		$query = $this->db->query($sql);
		return $query;
	}

	public function getTombosProduto($produtos_id = NULL) {
		if(NULL !== $produtos_id) {
			$sql = "SELECT
							patrimonio.tombo,
							patrimonio.produtos_id,
							marcas_produtos.marca,
							produtos.modelo
							FROM
							patrimonio
							INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
							INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
							INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
							WHERE patrimonio.produtos_id = $produtos_id";
			$tombos = $this->db->query($sql);
			return (0 < $tombos->num_rows()) ? $tombos->result() : FALSE;
		}
		else return FALSE;
	}

	public function produtoByTombo($tombo) {
		if (isset($tombo) && $tombo != "") {
			$_sql = "SELECT
								patrimonio.id,
								patrimonio.tombo,
								produtos.id AS produtos_id,
								CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS produto,
								produtos.consumo,
								produtos.quantidade_minima
								FROM
									patrimonio
									INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								WHERE
									(patrimonio.tombo = '$tombo')";
			$query = $this->db->query($_sql);
			if (!is_bool($query))
				return $query->row();
			else
				return FALSE;
		} else
			return FALSE;
	}

	public function getProdutos() {
		$sql = "SELECT
							CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS modelo,
							produtos.id,
							produtos.quantidade_minima,
							produtos.consumo
							FROM
							produtos
							INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id";
		$query = $this->db->query($sql);
		return $query;
	}
		

	public function detalheProdutos($id) {
		$sql = "SELECT
							produtos.id,
							produtos.quantidade_minima,
							SUM(estoques.quantidade) as quantidade_estoque,
							produtos.modelo,
							produtos.consumo,
							produtos.grupo_produtos_id,
							produtos.marcas_produtos_id,
							produtos.imagem,
							marcas_produtos.marca,
							grupo_produtos.nome AS grupo
							FROM
								produtos
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
								INNER JOIN estoques ON estoques.produtos_id = produtos.id
							WHERE
								produtos.id = $id";
		$query = $this->db->query($sql);
		return $query;
	}

	public function detalhaProduto($produto = NULL) {
		$sql = "SELECT
							produtos.id,
							marcas_produtos.marca,
							produtos.modelo,
							estoques.quantidade,
							lotacoes.sigla
							FROM
								estoques
								INNER JOIN produtos ON produtos.id = estoques.produtos_id
								INNER JOIN lotacoes ON estoques.lotacoes_id = lotacoes.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id";
		if (NULL != $produto) {
			if (is_array($produto)) {
				$sql .= " WHERE produtos_id = ".$produto['produtos_id']." AND lotacoes_id = ".$produto['estoques_id'];
				$query = $this->db->query($sql);
				return $query->row();
			}
			else {
				$sql .= " WHERE produtos_id = $produto";
				$query = $this->db->query($sql);
				return $query->result();
			}
		}
		else return FALSE;
	}

	public function historicoByTombo($tombo) {
		if (isset($tombo) && $tombo != "") {
			$_sql = "SELECT
								cautelas_has_produtos.produtos_id,
								cautelas_has_produtos.tombo_id,
								patrimonio.tombo,
								CONCAT(marcas_produtos.marca, ' ', produtos.modelo) AS produto,
								produtos.grupo_produtos_id,
								grupo_produtos.nome AS grupo,
								cautelas_has_produtos.cautelas_id,
								DATE_FORMAT(cautelas.data_cautela, '%d/%m/%Y') AS dia,
								CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
								cautelas.setor_id,
								almoxarifado.sigla AS almoxarifado,
								lotacoes.sigla,
								destino.sigla AS destino,
								cautelas_has_produtos.destino_id,
								cautelas_has_produtos.ativo,
								cautelas.distribuicao
								FROM
									cautelas_has_produtos
									INNER JOIN patrimonio ON cautelas_has_produtos.tombo_id = patrimonio.id
									INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
									INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
									INNER JOIN militares ON cautelas.militares_id = militares.id
									INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
									INNER JOIN lotacoes AS almoxarifado ON almoxarifado.id = cautelas.estoques_id
									LEFT JOIN lotacoes AS destino ON destino.id = cautelas_has_produtos.destino_id
									LEFT JOIN lotacoes ON lotacoes.id = cautelas.setor_id
								WHERE
									(cautelas.cancelada = 0)
									AND (cautelas.ativa = 1)
									AND (patrimonio.tombo = '$tombo')";
			$_ord = " ORDER BY cautelas_has_produtos.cautelas_id DESC";
			$query = $this->db->query($_sql . $_ord);
			if (!is_bool($query))
				return $query;
			else
				return FALSE;
		} else
			return FALSE;
	}

}
