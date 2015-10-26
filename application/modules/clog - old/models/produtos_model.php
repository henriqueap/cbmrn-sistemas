<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Produtos_model extends CI_Model
{
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
		if (isset($filter['modelo'])) $this->db->like('produtos.modelo', $filter['modelo']);
		if (isset($filter['marcas_produtos_id'])) $this->db->like('produtos.marcas_produtos_id', $filter['marcas_produtos_id']);
		if (isset($filter['lotacoes_id'])) $this->db->like('estoques.lotacoes_id', $filter['lotacoes_id']);

		$query = $this->db->get();
		return $query;
	}

	public function consulta_produtos($filter) {
		$this->db->select('marcas_produtos.marca as marcas, produtos.id, produtos.modelo as nome_produtos, grupo_produtos.nome as grupo_produtos');
		$this->db->from('produtos');

		$this->db->join('grupo_produtos', 'produtos.grupo_produtos_id = grupo_produtos.id');
		$this->db->join('marcas_produtos', 'produtos.marcas_produtos_id = marcas_produtos.id');

		if (isset($filter['modelo'])) {
					$this->db->like('produtos.modelo', $filter['modelo']);
		}

		if (isset($filter['marcas_produtos_id'])) {
			$this->db->like('produtos.marcas_produtos_id', $filter['marcas_produtos_id']);
		}

		if (isset($filter['grupo_produtos'])) {
			$this->db->like('grupo_produtos.id', $filter['grupo_produtos']);
		}

		$query = $this->db->get();
		return $query;
	}

	public function produtoByTombo($tombo) {
		if (isset($tombo) && $tombo != "") {
			$_sql = "SELECT
								patrimonio.id,
								patrimonio.tombo,
								CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS produto,
								produtos.consumo,
								produtos.quantidade_estoque,
								produtos.quantidade_minima
								FROM
								patrimonio
								INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								WHERE 
									(patrimonio.tombo = '$tombo')";
			$query = $this->db->query($_sql);
			if (! is_bool($query)) return $query->row();
			else return FALSE;
		}
		else return FALSE;
	}

	public function detalheProdutos($id) {
		$sql = "SELECT
							produtos.id,
							produtos.quantidade_minima,
							produtos.quantidade_estoque,
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
							WHERE produtos.id = $id";
		$query = $this->db->query($sql);
		return $query;
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
								DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS dia,
								cautelas.setor_id,
								almoxarifado.sigla AS almoxarifado,
								lotacoes.sigla,
								destino.sigla AS destino,
								cautelas_has_produtos.destino_id,
								cautelas_has_produtos.ativo
								FROM
									cautelas_has_produtos
									INNER JOIN patrimonio ON cautelas_has_produtos.tombo_id = patrimonio.id
									INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
									INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
									INNER JOIN lotacoes AS almoxarifado ON almoxarifado.id = cautelas.estoques_id
									LEFT JOIN lotacoes AS destino ON destino.id = cautelas_has_produtos.destino_id
									LEFT JOIN lotacoes ON lotacoes.id = cautelas.setor_id
								WHERE 
									(cautelas.cancelada = 0)
									AND (cautelas.ativa = 1) 
									AND (cautelas.finalizada = 1) 
									AND (patrimonio.tombo = '$tombo')";
			$_ord = " ORDER BY cautelas_has_produtos.cautelas_id DESC";
			$query = $this->db->query($_sql.$_ord);
			if (! is_bool($query)) return $query;
			else return FALSE;
		}
		else return FALSE;
	}

}
