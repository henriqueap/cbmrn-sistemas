<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Clog_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function salvar($tabela=NULL, $objeto=NULL) {
		if (!is_null($tabela) OR !is_null($objeto)) {
			//var_dump($objeto); die();
			if (is_array($objeto)) {
				$query = $this->db->insert($tabela, $objeto);
				return $query;
			}
		}	return 0;
	}

	public function atualizar($tabela=NULL, $objeto=NULL) {
		if (!is_null($tabela) OR is_null($objeto)) {
			if (is_array($objeto)) {
				$this->db->where('id', $objeto['id']);
				$query = $this->db->update($tabela, $objeto);
				if ($this->db->affected_rows() > 0) return TRUE;
				else return FALSE;
			}
		}
		else return 0;
	}

	/*
	public function excluir($tabela=NULL, $id=NULL) {
		if (is_string($tabela)) { 
			if (!is_null($tabela) OR !is_null($id)) {
				$this->db->where('id', $id);
				$this->db->delete($tabela);
			}
		} return 0;
	}
	*/

	#Alterado por Pereira
	public function excluir($tabela=NULL, $id=NULL) {
		#var_dump($id); die();
		if (!(is_null($tabela)) && !(is_null($id))) {
			if (! is_array($id)) $this->db->where('id', $id);
			else  $this->db->where($id);
			$this->db->delete($tabela);
			#Testando se deletou
			if (! is_array($id)) $query = $this->db->get_where($tabela, array('id'=>$id));
			else $query = $this->db->get_where($tabela, $id);
			#Retorno da função
			if ($query->num_rows() > 0) return FALSE;
			else return TRUE;
		}
		else return FALSE;
	}

	public function excluirPorra($tabela=NULL, $id=NULL) {
		if (is_string($tabela)) { 
			if (!is_null($tabela) OR !is_null($id)) {
				$this->db->where('cautelas_id', $id);
				$this->db->delete($tabela);
			}
		} return 0;
	}

	public function listar($tabela, $id=NULL, $order = 'desc', $limit=NULL, $offset=NULL) {
		if (!is_null($id))
			$this->db->where('id', $id);

		$this->db->order_by('id', $order);
		$query = $this->db->get($tabela, $limit, $offset);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	#by Pereira
	public function getAll($tbl) {
		$query = $this->db->get($tbl);
		if ($query->num_rows() > 0) {
			return $query;
		} 
		else {
			return FALSE;
		}
	}

	public function getByID($tbl, $id) {
		$data = array('id'=>$id);
		$query = $this->db->get_where($tbl, $data);
		if ($query->num_rows() > 0) {
			return $query;
		} 
		else {
			return FALSE;
		}
	}

	public function getByIDporra($tbl, $id) {
		$data = array('cautelas_id'=>$id);
		$query = $this->db->get_where($tbl, $data);
		if ($query->num_rows() > 0) {
			return $query;
		} 
		else {
			return FALSE;
		}
	}

	public function inserir($data, $tbl) {
		#$tbl = "os";
		$query = $this->db->insert($tbl, $data);
		if ($this->db->affected_rows() > 0) return TRUE;
		else return FALSE;
	}

	public function getGrupos($id=NULL) {
		$sql = "SELECT
							grupos_permissoes.id,
							grupos_permissoes.nome
							FROM
								grupos_permissoes";
		if (! is_null($id)) {
			$sql .= " WHERE grupos_permissoes.id = $id";
		}
		$grupos = $this->db->query($sql);
		if ($grupos->num_rows() > 0) {
			return $grupos;
		} 
		else {
			return FALSE;
		}
	}

	public function getPermissoes($id=NULL, $json=FALSE) {
		if (! is_null($id)) {
			$sql = "SELECT
								grupos_permissoes_permissoes.grupos_permissoes_id,
								grupos_permissoes.nome AS grupo,
								permissoes.id AS permissoes_id,
								permissoes.nome AS permissao,
								modulos.nome AS modulo,
								modulos.sigla AS sigla_modulo,
								permissoes.pagina
								FROM
									grupos_permissoes
									INNER JOIN grupos_permissoes_permissoes ON grupos_permissoes_permissoes.grupos_permissoes_id = grupos_permissoes.id
									RIGHT JOIN permissoes ON grupos_permissoes_permissoes.permissoes_id = permissoes.id
									INNER JOIN modulos ON permissoes.modulos_id = modulos.id ";
			if (is_bool($json)) $sql .= " WHERE grupos_permissoes_permissoes.grupos_permissoes_id = $id";
			else $sql .= "WHERE 
											grupos_permissoes_permissoes.grupos_permissoes_id != $id 
											OR ISNULL(grupos_permissoes_permissoes.grupos_permissoes_id) 
										GROUP BY
											permissoes.id";
		}
		else {
			$sql = "SELECT
							permissoes.id AS permissoes_id,
							permissoes.nome AS permissao,
							modulos.nome AS modulo,
							modulos.sigla AS sigla_modulo,
							permissoes.pagina
							FROM
								permissoes
								INNER JOIN modulos ON permissoes.modulos_id = modulos.id";
		}
		$grupos = $this->db->query($sql);
		if ($grupos->num_rows() > 0) {
			return $grupos;
		} 
		else {
			return FALSE;
		}
	}

	public function grupoHasPermissao($group_id, $permission_id) {
	 	$sql = "SELECT
							grupos_permissoes_permissoes.grupos_permissoes_id,
							grupos_permissoes.nome AS grupo,
							grupos_permissoes_permissoes.permissoes_id,
							permissoes.nome AS permissao,
							permissoes.modulos_id,
							modulos.nome AS modulo,
							modulos.sigla AS sigla_modulo
							FROM
							grupos_permissoes_permissoes
							INNER JOIN permissoes ON grupos_permissoes_permissoes.permissoes_id = permissoes.id
							INNER JOIN modulos ON permissoes.modulos_id = modulos.id
							INNER JOIN grupos_permissoes ON grupos_permissoes_permissoes.grupos_permissoes_id = grupos_permissoes.id";
		if (!(is_null($group_id)) && !(is_null($permission_id))) {
			$sql .= " WHERE
									grupos_permissoes.id = $group_id 
									AND permissoes.id = $permission_id";
			$permissoes = $this->db->query($sql);
			if ($permissoes->num_rows() > 0) return TRUE;
			else return FALSE;
		}
		else return TRUE;
	}

	public function grupoHasMilitar($group_id, $militar_id) {
	 	$sql = "SELECT
							militares_grupos_permissoes.grupos_permissoes_id,
							grupos_permissoes.nome AS grupo,
							militares_grupos_permissoes.militares_id,
							militares.matricula,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar
							FROM
								militares_grupos_permissoes
								INNER JOIN grupos_permissoes ON militares_grupos_permissoes.grupos_permissoes_id = grupos_permissoes.id
								INNER JOIN militares ON militares_grupos_permissoes.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id";
		if (!(is_null($group_id)) && !(is_null($militar_id))) {
			$sql .= " WHERE
									grupos_permissoes.id = $group_id 
									AND militares.id = $militar_id";
			$permissoes = $this->db->query($sql);
			if ($permissoes->num_rows() > 0) return TRUE;
			else return FALSE;
		}
		else return TRUE;
	}

	public function getPermissoesUsuario($id) {
		$sql = "SELECT
							grupos_permissoes_permissoes.permissoes_id,
							permissoes.nome AS permissao,
							grupos_permissoes_permissoes.grupos_permissoes_id,
							grupos_permissoes.nome AS grupo,
							permissoes.modulos_id,
							modulos.nome AS modulo,
							modulos.sigla AS sigla_modulo,
							permissoes.pagina,
							militares_grupos_permissoes.militares_id,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar
							FROM
								grupos_permissoes_permissoes
								INNER JOIN grupos_permissoes ON grupos_permissoes_permissoes.grupos_permissoes_id = grupos_permissoes.id
								INNER JOIN permissoes ON grupos_permissoes_permissoes.permissoes_id = permissoes.id
								INNER JOIN modulos ON permissoes.modulos_id = modulos.id
								INNER JOIN militares_grupos_permissoes ON militares_grupos_permissoes.grupos_permissoes_id = grupos_permissoes.id
								INNER JOIN militares ON militares_grupos_permissoes.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id";
		if (! is_null($id)) {
			$sql .= " WHERE militares.id = $id";
			$permissoes = $this->db->query($sql);
			if ($permissoes->num_rows() > 0) return $permissoes;
			else return FALSE;
		}
		else return FALSE;
	}

	public function usuarioHasPermissao($user_id, $permission_id) {
	 	$sql = "SELECT
	 							militares_grupos_permissoes.militares_id,
	 							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
	 							grupos_permissoes_permissoes.grupos_permissoes_id,
	 							grupos_permissoes.nome AS grupo,
	 							grupos_permissoes_permissoes.permissoes_id,
	 							permissoes.nome AS permissao,
	 							permissoes.modulos_id,
	 							modulos.nome AS modulo,
	 							modulos.sigla AS sigla_modulo
	 							FROM
	 								militares_grupos_permissoes
	 								INNER JOIN militares ON militares_grupos_permissoes.militares_id = militares.id
	 								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
	 								INNER JOIN grupos_permissoes_permissoes ON militares_grupos_permissoes.grupos_permissoes_id = grupos_permissoes_permissoes.grupos_permissoes_id
	 								INNER JOIN permissoes ON grupos_permissoes_permissoes.permissoes_id = permissoes.id
	 								INNER JOIN modulos ON permissoes.modulos_id = modulos.id
	 								INNER JOIN grupos_permissoes ON grupos_permissoes_permissoes.grupos_permissoes_id = grupos_permissoes.id";
		if (!(is_null($user_id)) && !(is_null($permission_id))) {
			$sql .= " WHERE
									militares.id = $user_id 
									AND permissoes.id = $permission_id";
			$permissoes = $this->db->query($sql);
			if ($permissoes->num_rows() > 0) return FALSE;
			else return TRUE;
		}
		else return FALSE;
	}

	public function getLotacoes() {
		$tbl = "lotacoes";
		$query = $this->db->get($tbl);
		if ($query->num_rows() > 0) {
			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function getLotacao($id) {
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

	public function getEstoques() {
		$sql = "SELECT DISTINCT
							estoques.lotacoes_id,
							lotacoes.sigla AS almoxarifado
							FROM
								estoques
								INNER JOIN lotacoes ON estoques.lotacoes_id = lotacoes.id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query;
		}
		else {
			return FALSE;
		}
	}

	public function getEstoque($id = 23) {
		$sql = "SELECT
							produtos.id,
							marcas_produtos.marca AS marcas,
							produtos.modelo AS nome_produtos,
							estoques.quantidade AS quantidade_estoque,
							grupo_produtos.nome AS grupo,
							lotacoes.sigla AS almoxarifado,
							estoques.lotacoes_id
							FROM
								produtos
								INNER JOIN estoques ON produtos.id = estoques.produtos_id
								INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								INNER JOIN lotacoes ON estoques.lotacoes_id = lotacoes.id
							WHERE estoques.lotacoes_id = $id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query;
		}
		else {
			return FALSE;
		}
	}

	/*
	public function inserir($data, $tbl, $retornaID=FALSE) {
		#$tbl = "os";
		$query = $this->db->insert($tbl, $data);
		if ($this->db->affected_rows() > 0) {
			if ($retornaID === FALSE) return TRUE;
			else return $this->db->insert_id();
		}
		else return FALSE;
	}
	*/

	public function audita($data, $acao) {
		$tpAud = $this->db->query("SELECT * FROM tipo_auditoria WHERE tipo = '$acao'")->row();
		$sql = "INSERT INTO auditoria (`data`, auditoria, idtipo, idmilitar, idmodulo, ip) VALUES (now(), '".$data['auditoria']."', ".$tpAud->id.",".$data['idmilitar'].",".$data['idmodulo'].", '".$_SERVER['REMOTE_ADDR']."')";
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0) return TRUE;
		else return FALSE;
	}

	public function getAuditoria($params = NULL, $ini = NULL, $size = NULL) {
		#$dtIni = date('Y')."-01-01"; # Checar com o Tenente
		$dtIni = "2014-01-01"; # Temp
		$dtFim = date('Y-m-d');
		$filters = "\n WHERE (auditoria.idmodulo = 3)";
		$order_by = '';
		$sql = "SELECT
							auditoria.id,
							DATE_FORMAT(auditoria.data,'%Y-%m-%d') AS data_auditoria,
							DATE_FORMAT(auditoria.data,'%d/%m/%Y') AS dia,
							DATE_FORMAT(auditoria.data,'%H:%i:%S') AS hora,
							tipo_auditoria.tipo,
							auditoria.auditoria,
							auditoria.idmilitar,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							modulos.sigla AS modulo,
							auditoria.ip
							FROM
								auditoria
								INNER JOIN tipo_auditoria ON auditoria.idtipo = tipo_auditoria.id
								INNER JOIN modulos ON auditoria.idmodulo = modulos.id
								INNER JOIN militares ON auditoria.idmilitar = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		
		if (! is_null($params)) {
			if (is_int($params)) $size = $params;
			else {
				# Filtrar por intervalo de datas
				$dtIni = (isset($params['data_inicial']) && $params['data_inicial'] != '') ? $params['data_inicial'] : $dtIni;
				$dtFim = (isset($params['data_final']) && $params['data_final'] != '') ? date("Y-m-d", strtotime($params['data_final']." + 1 day")) : date("Y-m-d", strtotime($dtFim." + 1 day")) ;
				$filters .= " AND (auditoria.data BETWEEN '$dtIni' AND '$dtFim')";
				# .datas

				# Filtrar por tipo
				if (isset($params['idtipo']) && $params['idtipo'] != 0) {
					$idtipo = $params['idtipo'];
					$filters .= " AND (auditoria.idtipo = $idtipo)";
				}
				# .tipo

				# Filtrar por militar
				if (isset($params['idmilitar']) && $params['idmilitar'] != 0) {
					$idmilitar = $params['idmilitar'];
					$filters .= " AND (auditoria.idmilitar = $idmilitar)";
				}
				# .militar
				$sql .= $filters;
			}
		}
		# Sem filtro, limitado para paginação
		
		# Ordenando
		$sql .= "\n ORDER BY auditoria.id DESC";

		# Primeira linha 
		$limiter = (! is_null($ini)) ? " LIMIT $ini, " : " LIMIT 0, ";

		# Quantidade de linhas 
		$sql .= (! is_null($size)) ? $limiter.$size : "";

		#echo "<pre>"; var_dump($sql); echo "</pre>";

		# Executando a query
		$lista = $this->db->query($sql);
		if ($lista->num_rows() > 0) return $lista;
		else return FALSE;
	}

	public function formataData($data) {
		if(substr_count($data, "-") == 2){
			$data = implode('/',array_reverse(explode('-',$data)));
		}else{
			$data = implode('-',array_reverse(explode('/',$data)));
		}
		return $data;
	}

	public function povoaCLOG() {
		$produtos = $this->db->get('produtos');
		foreach ($produtos->result() as $produto) {
			# Atualizando o estoque
			$controle = $this->db->get_where('estoques', array('lotacoes_id'=>23, 'produtos_id'=>$produto->id));
			//echo "<pre> Controle: "; var_dump($controle->row()); echo "</pre>";
			if ($controle->num_rows > 0) {
				$this->db->where(array('lotacoes_id'=>23, 'produtos_id'=>$produto->id));
				$this->db->update('estoques', array('quantidade'=>$produto->quantidade_estoque));
			}
			else $this->db->insert('estoques', array('lotacoes_id'=>23, 'produtos_id'=>$produto->id,'quantidade'=>$produto->quantidade_estoque));
		}
	}
}