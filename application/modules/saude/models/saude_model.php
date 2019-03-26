<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * @version 1.0
 * @author CBM-RN
 * @link http://www.cbm.rn.gov.br/
 */
class Saude_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function salvar($tabela = NULL, $data = NULL) {
		if (!is_null($tabela) OR ! is_null($data)) {
			if (is_array($data)) {
				$query = $this->db->insert($tabela, $data);
				return $query;
			}
		} return FALSE;
	}

	public function atualizar($tabela = NULL, $objeto = NULL) {
		if (!is_null($tabela) OR is_null($objeto)) {
			if (is_array($objeto)) {
				$this->db->where('id', $objeto['id']);
				$query = $this->db->update($tabela, $objeto);
				if ($this->db->affected_rows() > 0)
					return TRUE;
				else
					return FALSE;
			}
		} else
			return 0;
	}

	public function inserir($data, $tbl) {
		#$tbl = "os";
		$query = $this->db->insert($tbl, $data);
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	public function excluir($tabela = NULL, $id = NULL) {
		#var_dump($id); die();
		if (!(is_null($tabela)) && !(is_null($id))) {
			if (!is_array($id))
				$this->db->where('id', $id);
			else
				$this->db->where($id);
			$this->db->delete($tabela);
			#Testando se deletou
			if (!is_array($id))
				$query = $this->db->get_where($tabela, array('id' => $id));
			else
				$query = $this->db->get_where($tabela, $id);
			#Retorno da função
			if ($query->num_rows() > 0)
				return FALSE;
			else
				return TRUE;
		} else
			return FALSE;
	}

	public function listar($tabela, $id = NULL, $order = 'desc', $limit = NULL, $offset = NULL) {
		if (!is_null($id))
			$this->db->where('id', $id);

		$this->db->order_by('id', $order);
		$query = $this->db->get($tabela, $limit, $offset);
		if ($query->num_rows() > 0)
			return $query;
		else
			return FALSE;
	}

	public function getAll($tbl) {
		$query = $this->db->get($tbl);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	public function getByID($tbl, $id) {
		$data = array('id' => $id);
		$query = $this->db->get_where($tbl, $data);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	public function getMilitares() {
		$sql = "SELECT
							militares.id,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar
							FROM
							militares
							INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		$query = $this->db->query($sql);
		return ($query->num_rows() > 0)? $query->result() : FALSE;
	}

	public function getMilitar($id) {
		$sql = "SELECT
							militares.id,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar
							FROM
							militares
							INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
							WHERE
							militares.id = $id";
		$query = $this->db->query($sql);							
		return ($query->num_rows() > 0)? $query->row() : FALSE;
	}

	public function getPermutas($id = NULL) {
		$sql = "SELECT
							permutas.id,
							DATE_FORMAT(permutas.data_servico,'%d/%m/%Y') AS data_servico,
							CONCAT(patentes_permutados.sigla, ' ', permutados.nome_guerra) AS permutado,
							CONCAT(patentes_permutantes.sigla, ' ', permutantes.nome_guerra) AS permutante,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS autorizante
							FROM
								permutas
								INNER JOIN militares AS permutados ON permutas.permutados_id = permutados.id
								INNER JOIN militares AS permutantes ON permutas.permutantes_id = permutantes.id
								INNER JOIN militares ON permutas.militares_id = militares.id
								INNER JOIN patentes AS patentes_permutados ON permutados.patente_patentes_id = patentes_permutados.id
								INNER JOIN patentes AS patentes_permutantes ON permutantes.patente_patentes_id = patentes_permutantes.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		$sql .= (is_null($id))? '' : " WHERE permutas.permutados_id = $id";
		$query = $this->db->query($sql);
		return ($query->num_rows() > 0)? $query->result() : FALSE;
	}
	
	public function validaPermuta($id, $senha)	{
		if (is_null($id) || is_null($senha)) return FALSE;
		$militar = $this->getByID('militares', $id)->row();
		$data = array(  
			'matricula'=>$militar->matricula, 
			'senha'=>md5($senha)
		);
		$this->db->where('matricula', $data['matricula']);
		$this->db->where('senha', $data['senha']);
		$query = $this->db->get('militares');
		return ($query->num_rows() > 0)? TRUE : FALSE;
	}

	public function getGrupos($id = NULL) {
		$sql = "SELECT
							grupos_permissoes.id,
							grupos_permissoes.nome
							FROM
								grupos_permissoes";
		if (!is_null($id)) {
			$sql .= " WHERE grupos_permissoes.id = $id";
		}
		$grupos = $this->db->query($sql);
		if ($grupos->num_rows() > 0) {
			return $grupos;
		} else {
			return FALSE;
		}
	}

	public function getPermissoes($id = NULL, $json = FALSE) {
		if (!is_null($id)) {
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
			if (is_bool($json))
				$sql .= " WHERE grupos_permissoes_permissoes.grupos_permissoes_id = $id";
			else
				$sql .= "WHERE
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
		} else {
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
			if ($permissoes->num_rows() > 0)
				return TRUE;
			else
				return FALSE;
		} else
			return TRUE;
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
			if ($permissoes->num_rows() > 0)
				return TRUE;
			else
				return FALSE;
		} else
			return TRUE;
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
		if (!is_null($id)) {
			$sql .= " WHERE militares.id = $id";
			$permissoes = $this->db->query($sql);
			if ($permissoes->num_rows() > 0)
				return $permissoes;
			else
				return FALSE;
		} else
			return FALSE;
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
			if ($permissoes->num_rows() > 0)
				return FALSE;
			else
				return TRUE;
		} else
			return FALSE;
	}

	public function getLotacoes($id = NULL) {
		$tbl = "lotacoes";
		$id = (! $this->input->get('id'))? NULL : $this->input->get('id');
		if (! is_null($id)) $whr['id'] = $id;
		$whr['sala'] = 0;
		$this->db->where($whr);
		$query = $this->db->get($tbl);
		if ($query->num_rows() > 0) {
			return $query;
		} else {
			return FALSE;
		}
	}

	public function getLotacoesInfo($id = NULL) {
		$_sql = "SELECT
							responsavel_lotacoes.id,
							responsavel_lotacoes.lotacoes_id,
							lotacoes.sigla,
							lotacoes.nome,
							lotacoes.sala,
							responsavel_lotacoes.observacao,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS responsavel,
							responsavel_lotacoes.militares_id
							FROM
							lotacoes
							LEFT JOIN responsavel_lotacoes ON responsavel_lotacoes.lotacoes_id = lotacoes.id
							LEFT JOIN militares ON responsavel_lotacoes.militares_id = militares.id
							INNER JOIN patentes ON militares.patente_patentes_id = patentes.id";
		if (!is_null($id)) {
			$_sql .= " WHERE responsavel_lotacoes.lotacoes_id = ";
			$_sql .=  (is_array($id)) ? $id['id'] : "$id";
		}
		$_sql .= " ORDER BY lotacoes.sigla ASC";
		$query = $this->db->query($_sql);
		return ($query->num_rows() > 0)? $query : FALSE;
	}

	public function getLotacao($id) {
		$tbl = "lotacoes";
		$arvore = "";
		do {
			$busca_lotacoes = $this->db->get_where($tbl, array('id' => $id));
			if ($busca_lotacoes->num_rows() > 0) {
				$linha = $busca_lotacoes->row();
				$arvore .= "/" . $linha->sigla;
				$id = $linha->superior_id;
			} else {
				$arvore = $linha->sigla;
			}
		} while (!is_null($id));
		return $arvore;
	}

	public function is_sala($id) {
		$params = array('id' => $id, 'sala' => 1);
		$query = $this->db->get_where('lotacoes', $params);
		return ($query->num_rows() > 0)? TRUE : FALSE;
	}

	public function getSalas($id = NULL) {
		$tbl = "lotacoes";
		$filters['sala'] = 1;
		if (! is_null($id)) {
			$filters['id'] = $id;
		}
		$this->db->where($filters);
		$query = $this->db->get($tbl);
		return $query;
	}

	public function getSalasSetor($superior_id) {
		$tbl = "lotacoes";
		$filters = array(
			'sala' => 1,
			'superior_id' => $superior_id
		);
		$this->db->where($filters);
		$query = $this->db->get($tbl);
		return $query;
	}

	public function audita($data, $acao) {
		$tpAud = $this->db->query("SELECT * FROM tipo_auditoria WHERE tipo = '$acao'")->row();
		$sql = "INSERT INTO auditoria (`data`, auditoria, idtipo, idmilitar, idmodulo, ip) VALUES (now(), '" . $data['auditoria'] . "', " . $tpAud->id . "," . $data['idmilitar'] . "," . $data['idmodulo'] . ", '" . $_SERVER['REMOTE_ADDR'] . "')";
		$this->db->query($sql);
		if ($this->db->affected_rows() > 0)
			return TRUE;
		else
			return FALSE;
	}

	public function getAuditoria($params = NULL, $ini = NULL, $size = NULL) {
		#$dtIni = date('Y')."-01-01"; # Checar com o Tenente
		$dtIni = (date('Y')-1)."-01-01";
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

		if (!is_null($params)) {
			if (is_int($params))
				$size = $params;
			else {
				# Filtrar por intervalo de datas
				$dtIni = (isset($params['data_inicial']) && $params['data_inicial'] != '') ? $params['data_inicial'] : $dtIni;
				$dtFim = (isset($params['data_final']) && $params['data_final'] != '') ? date("Y-m-d", strtotime($params['data_final'] . " + 1 day")) : date("Y-m-d", strtotime($dtFim . " + 1 day"));
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
				# Filtrar por palavra-chave
				$auditoria = (isset($params['auditoria']) && $params['auditoria'] != '') ? $params['auditoria'] : "";
				$filters .= ($auditoria != '')? " AND (auditoria.auditoria LIKE '%$auditoria%')" : "";
				# .palavra-chave
				$sql .= $filters;
			}
		}
		# Sem filtro, limitado para paginação
		# Ordenando
		$sql .= "\n ORDER BY auditoria.id DESC";

		# Primeira linha
		$limiter = (!is_null($ini)) ? " LIMIT $ini, " : " LIMIT 0, ";

		# Quantidade de linhas
		$sql .= (!is_null($size)) ? $limiter . $size : "";

		# echo "<pre>"; var_dump($sql); echo "</pre>";
		# Executando a query
		$lista = $this->db->query($sql);
		if ($lista->num_rows() > 0)
			return $lista;
		else
			return FALSE;
	}

	public function formataData($data) {
		if (substr_count($data, "-") == 2) {
			$data = implode('/', array_reverse(explode('-', $data)));
		} else {
			$data = implode('-', array_reverse(explode('/', $data)));
		}
		return $data;
	}

	public function getOcorrencias() {
		$_data = array();
		$_sql = "SELECT
				  gbs_ocorrencias.tipo_ocorrencias_id,
				  gbs_tipo_ocorrencias.ocorrencia,
				  gbs_tipo_ocorrencias.codigo,
				  COUNT(gbs_tipo_ocorrencias.id) AS quantidade
				  FROM gbs_ocorrencias 
				  INNER JOIN gbs_tipo_ocorrencias ON gbs_ocorrencias.tipo_ocorrencias_id = gbs_tipo_ocorrencias.id
				  WHERE gbs_ocorrencias.ativo = 1 AND (gbs_tipo_ocorrencias.id NOT IN (9,13)) 
				  GROUP BY gbs_ocorrencias.tipo_ocorrencias_id";
		$_ocorrencias = $this->db->query($_sql);    
		foreach ($_ocorrencias->result() as $tipo_ocorrencia) {
		  
		  $_data[] =$tipo_ocorrencia;
		}
		/*echo "<pre>";
		  var_dump($_data);
		echo "</pre>"; 
		die();*/
		return $_data;
	}

  public function getQuantidade($id) {
    $_sql = "SELECT
              gbs_ocorrencias.tipo_ocorrencias_id,
              gbs_tipo_ocorrencias.ocorrencia,
              gbs_tipo_ocorrencias.codigo,
              COUNT(gbs_tipo_ocorrencias.id) AS quantidade
                FROM gbs_ocorrencias 
                INNER JOIN gbs_tipo_ocorrencias ON gbs_ocorrencias.tipo_ocorrencias_id = gbs_tipo_ocorrencias.id
                WHERE gbs_tipo_ocorrencias.id = $id";
    $_value = $this->db->query($_sql);
    return $_value->row();
  }
	
}
