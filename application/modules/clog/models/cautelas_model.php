<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

//ini_set('memory_limit', '256M');

class Cautelas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model(array('clog_model', 'produtos_model'));
	}

	# Alterado por Pereira
	public function validarTombo($tombo) {
		# Testa se existe o tombo
		$sql = "SELECT
							patrimonio.id,
							patrimonio.tombo,
							patrimonio.produtos_id,
							patrimonio.notas_id,
							patrimonio.estoques_id,
							produtos.modelo,
							marcas_produtos.marca,
							lotacoes.sigla AS setor
							FROM
							patrimonio
							INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
							INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
							INNER JOIN lotacoes ON patrimonio.estoques_id = lotacoes.id
							LEFT JOIN notas_fiscais ON notas_fiscais.id = patrimonio.notas_id";
		if (is_array($tombo)) {
			$sql .= " WHERE produtos_id = ".$tombo['produto_id']." AND tombo = ".$tombo['tombo']." AND estoques_id = ".$tombo['estoques_id'];
		}
		else {
			$sql .= " WHERE tombo = '$tombo'";
		}
		#echo "<pre>"; var_dump($sql); echo "</pre>";
		if ($this->db->query($sql)->num_rows() > 0) {
			$testaNota = $this->db->query($sql)->row();
			$sql .= (! is_null($testaNota->notas_id)) ? " AND notas_fiscais.ativo = 0" : "";
		}
		$tomboExists = $this->db->query($sql);
		# Se existir o tombo, testa se existe cautela, em aberto, com os dados passados
		if ($tomboExists->num_rows() > 0) {
			$tombo_info = $tomboExists->row();
			$sql = "SELECT
								cautelas.id AS cautelas_id,
								cautelas.distribuicao,
								cautelas.finalizada,
								produtos.modelo,
								marcas_produtos.marca,
								cautelas_has_produtos.id AS item_id,
								cautelas_has_produtos.tombo_id,
								patrimonio.tombo,
								patrimonio.produtos_id,
								lotacoes.sigla AS setor,
								CONCAT(patentes.sigla, ' ',militares.nome_guerra) AS militar,
								militares.matricula
								FROM
									cautelas
									INNER JOIN militares ON cautelas.militares_id = militares.id
									INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
									INNER JOIN cautelas_has_produtos ON cautelas_has_produtos.cautelas_id = cautelas.id
									INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									INNER JOIN patrimonio ON patrimonio.id = cautelas_has_produtos.tombo_id
									LEFT JOIN lotacoes ON cautelas.setor_id = lotacoes.id
								WHERE
									((cautelas.distribuicao = 0) OR (cautelas.distribuicao = 1)) AND
									cautelas.concluida = 0 AND
									cautelas.cancelada = 0 AND
									cautelas.ativa = 1 AND
									cautelas_has_produtos.tombo_id = $tombo_info->id
								ORDER BY
									cautelas.id DESC";
			$controle = $this->db->query($sql);
			if($controle->num_rows() > 0) return $controle->row();
			else return $tombo_info;
		}
		# Se não existir retorna falso
		else return FALSE;
	}

	#Alterado por Pereira
	public function add_itens($id, $data, $tombos) {
		#var_dump($data); die();
		# Testando se a cautela existe
		$err_count = 0;
		$cautelaExists = $this->db->get_where('cautelas', array('id' => $id, 'cancelada' => 0));
		if ($cautelaExists !== FALSE) {
			$cautela_info = $cautelaExists->row();
			# Se permanente
			if ($data['tipo_produto'] == 1) {
				$contador = intval($data['produtos_qde']);
				$i = 0;
				while ($contador > 0) {
					# Procura o tombo
					$numero_tombo = array(
							'produto_id' => $data["produtos_id"],
							'tombo' => $tombos[$i],
							'estoques_id' => $data['estoques_id']
					);
					# Testa se o tombo encontrado bate com o produto e se está disponível
					$tombo_info = $this->validarTombo($numero_tombo);
					//var_dump($tombo_info); die();
					if ($tombo_info === FALSE || isset($tombo_info->cautelas_id))
						$err_count++;
					else {
						$produto = array(
								'cautelas_id' => $data["cautelas_id"],
								'produtos_id' => $data["produtos_id"],
								'produtos_qde' => 1,
								'tombo_id' => $tombo_info->id,
								'destino_id'=> $cautela_info->setor_id
						);
						$controle = $this->db->insert('cautelas_has_produtos', $produto);
						if ($this->db->affected_rows() < 1)
							$err_count++;
					}
					$contador--;
					$i++;
				}
				# Retorno da função
				if ($err_count < 1)
					return TRUE;
				else
					return $err_count;
			}
			# Se consumo
			else {
				$produto = array(
						'cautelas_id' => $data["cautelas_id"],
						'produtos_id' => $data["produtos_id"],
						'produtos_qde' => $data["produtos_qde"]
				);
				# Testando se o produto já existe na cautela
				$produtoExists = $this->db->get_where('cautelas_has_produtos', array('cautelas_id' => $data["cautelas_id"], 'produtos_id' => $data["produtos_id"]));
				# Se não existir, inclui o novo item
				if ($produtoExists->num_rows() < 1)
					$this->db->insert('cautelas_has_produtos', $produto);
				# Se existir atualiza a quantidade
				else {
					foreach ($produtoExists->result() as $item) {
						if ($item->produtos_id == $produto['produtos_id']) {
							$quantidade = array(
								'produtos_qde' => $item->produtos_qde + $produto['produtos_qde']
							);
							$controle = $this->produtos_model->detalhaProduto(array('produtos_id'=>$item->produtos_id, 'estoques_id'=>$data['estoques_id']));
							if (count($controle) > 0) {
								if ($controle->quantidade >= $quantidade['produtos_qde']) {
									# Atualiza a quantidade
									$this->db->where('id', $item->id);
									$this->db->update('cautelas_has_produtos', $quantidade);
								}
								else return FALSE;
							}
						}
					}
				}
				# Retorno da função
				if ($this->db->affected_rows() < 1)
					return FALSE;
				else
					return TRUE;
			}
		}
		#Retorno se não existir a cautela
		else
			return FALSE;
	}

	public function inativa_item($tombo_id) {
		$sql = "SELECT
							cautelas_has_produtos.id,
							cautelas_has_produtos.ativo,
							cautelas_has_produtos.cautelas_id
							FROM
								cautelas_has_produtos
								INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
							WHERE
								cautelas.distribuicao = 2 AND
								cautelas_has_produtos.ativo = 1 AND
								cautelas_has_produtos.tombo_id = $tombo_id
							ORDER BY
								cautelas_has_produtos.cautelas_id ASC";
		$controle = $this->db->query($sql);
		if($controle->num_rows > 0) {
			$item_info = $controle->row();
			$this->db->where('id', $item_info->id);
			$this->db->update('cautelas_has_produtos', array('ativo' => 0));
			if ($this->db->affected_rows() > 0) return TRUE;
			else return FALSE;
		}
		else return FALSE;
	}

	#Alterado por Pereira
	public function atualiza_estoques($cautela_id) {
		//$err_count = 0; # Contagem de erros
		$info_cautela = $this->getCautela($cautela_id)->row();
		$itens_cautela = $this->getItens($cautela_id);
		# Testando se existe itens paera devolver
		if (FALSE !== $itens_cautela) {
			# Recuperando a quantidade do produto nos estoques
			foreach ($itens_cautela->result() as $item_cautela) {
					## Atualizando os estoques
					# Atualizando origem
					$origem = $this->db->get_where('estoques', array('produtos_id'=>$item_cautela->produtos_id, 'lotacoes_id'=>$info_cautela->origem_id))->row();
					$origem_atualizar = $origem->quantidade - $item_cautela->quantidade;
					$this->db->where(array('lotacoes_id' => $info_cautela->origem_id, 'produtos_id' => $item_cautela->produtos_id));
					$this->db->update('estoques', array('quantidade' => $origem_atualizar));
					# Atualizando destino
					$destinoExists = $this->db->get_where('estoques', array('produtos_id'=>$item_cautela->produtos_id, 'lotacoes_id'=>$info_cautela->setor_id));
					if (0 < $destinoExists->num_rows()) {
						$destino = $destinoExists->row();
						$destino_atualizar = $destino->quantidade + $item_cautela->quantidade;
						$this->db->where(array('lotacoes_id' => $info_cautela->setor_id, 'produtos_id' => $item_cautela->produtos_id));
						$this->db->update('estoques', array('quantidade' => $destino_atualizar));
					}
					else {
						$this->db->insert('estoques', array('lotacoes_id' => $info_cautela->setor_id, 'produtos_id' => $item_cautela->produtos_id, 'quantidade'=>$item_cautela->quantidade));
					}
					# Atualizando patrimônio
					if (!is_null($item_cautela->tombo_id)) {
						$this->db->where(array('id' => $item_cautela->tombo_id));
						$this->db->update('patrimonio', array('estoques_id' => $info_cautela->setor_id));
					}
			}
			return TRUE;
		}
		# Cautela vazia
		else
			return FALSE;
	}

	public function devolve_estoque($cautela_id) {
		# $err_count = 0; # Contagem de erros
		$produtos = Array();
		$atualize = Array();
		$info_cautela = $this->getCautela($cautela_id)->row();
		$itens_cautela = $this->getItens($cautela_id);
		# Testando se existe itens para devolver
		if (FALSE !== $itens_cautela) {
			# Recuperando a quantidade do produto nos estoques, testando o estoque e criando os arrays de atualização
			foreach ($itens_cautela->result() as $item_cautela) {
				# Pegando o estoque de origem e calculando o novo estoque
				$origem = $this->db->get_where('estoques', array('produtos_id'=>$item_cautela->produtos_id, 'lotacoes_id'=>$info_cautela->origem_id))->row();
				$origem_atualizar = $origem->quantidade + $item_cautela->quantidade;
				# Pegando o estoque de destino e calculando o novo estoque
				$destino = $this->db->get_where('estoques', array('produtos_id'=>$item_cautela->produtos_id, 'lotacoes_id'=>$info_cautela->setor_id))->row();
				$destino_atualizar = $destino->quantidade - $item_cautela->quantidade;
				# Testando se dá estoque negativo no destino e guardando os produtos que deram problema
				if ($destino_atualizar < 0) {
					# Criando o array de produtos
					$produtos[] = $item_cautela->produto;
				}
				# Tudo certo, cria os array de atualização
				else {
					# Destino
					$atualize_destino[] = array(
						'where' => array('lotacoes_id' => $info_cautela->setor_id, 'produtos_id' => $item_cautela->produtos_id),
						'quantidade' => array('quantidade' => $destino_atualizar)
					);
					# Origem
					$atualize_origem[] = array(
						'where' => array('lotacoes_id' => $info_cautela->origem_id, 'produtos_id' => $item_cautela->produtos_id),
						'quantidade' => array('quantidade' => $origem_atualizar)
					);
					# Patrimônio
					if (!is_null($item_cautela->tombo_id)) {
						$atualize_patrimonio[] = array(
							'where' => array('id' => $item_cautela->tombo_id),
							'estoque_id' => array('estoques_id' => $info_cautela->origem_id)
						);
					}
				} 
			}
			# Se não houve problema de estoque negativo no destino, atualiza os dois estoques e dá retorno
			if (count($produtos) < 1) {
				$err_count = 0;
				$i = count($atualize_destino) - 1;
				# Tentando atualizar o destino
				while ($i >= 0) {
					$atualiza = $atualize_destino[$i];
					# echo "<pre>"; var_dump($atualiza); echo "</pre>";
					$this->db->where($atualiza['where']);
					$this->db->update('estoques', $atualiza['quantidade']);
					if ($this->db->affected_rows() < 1) {
						$err_count += 1;
					}
					$i--;
				}
				# Testando se houve erro de atualização do destino e dando retorno
				if ($err_count > 0) {
					$retorno['status'] = FALSE;
					$retorno['msg'] = "O sistema não conseguiu atualizar o estoque de $err_count produtos no destino!";
					return $retorno;
				}
				# Se não houve erro no destino, tenta atualizar a origem e dá retorno
				else{
					$err_count = 0;
					$i = count($atualize_origem) - 1;
					# Tentando atualizar a origem
					while ($i >= 0) {
						$atualiza = $atualize_origem[$i];
						$this->db->where($atualiza['where']);
						$this->db->update('estoques', $atualiza['quantidade']);
						if ($this->db->affected_rows() < 1) {
							$err_count += 1;
						}
						$i--;
					}
					# Testando se houve erro de atualização da origem e dando retorno
					if ($err_count > 0) {
						$retorno['status'] = FALSE;
						$retorno['msg'] = "O sistema não conseguiu atualizar o estoque de $err_count produtos na origem!";
						return $retorno;
					}
					# Se não houve erro na origem, tenta atualizar o patrimônio e dá retorno
					else {
						$err_count = 0;
						$i = count($atualize_patrimonio) - 1;
						# Tentando atualizar o patrimônio
						while ($i >= 0) {
							$atualiza = $atualize_patrimonio[$i];
							$this->db->where($atualiza['where']);
							$this->db->update('patrimonio', $atualiza['estoque_id']);
							if ($this->db->affected_rows() < 1) {
								$err_count += 1;
							}
							$i--;
						}
						# Testando se houve erro de atualização do patrimônio e dá retorno
						if ($err_count > 0) {
							$retorno['status'] = FALSE;
							$retorno['msg'] = "O sistema não conseguiu atualizar a tabela patrimônio!";
							return $retorno;
						}
						# Ciclo concluído sem erros, retorna true
						else {
							# Retorno
							return TRUE;
						}
					}
				}
			}
			# Se houve, dá retorno
			else {
				$listaProdutos = rtrim(implode($produtos, ", "), ", ");
				$retorno['status'] = FALSE;
				$retorno['msg'] = "O sistema não conseguiu atualizar o estoque do(s) produto(s): $listaProdutos";
				return $retorno;
			}
		}
		# Se cautela vazia, retorna false
		else {
			# Retorno
			return TRUE;
		}
	}

	public function retira_material($cautela_id) {
		# Testando se existe a cautela
		if (FALSE !== $this->getCautela($cautela_id)) {
			# Recuperando os dados da cautela
			$cautela = $this->getCautela($cautela_id)->row();
			# Recuperando os ítens
			$itens = $this->getItens($cautela_id);
			if (FALSE !== $itens) {
				# Atualizando o estoque
				foreach ($itens->result() as $item) {
					# Recuperando em que estoque o tombo se encontra
					if (!is_null($item->tombo_id)) {
						$controle = $this->db->get_where('patrimonio', array('id'=>$item->tombo_id));
						 if (FALSE !== $controle) {
							$info_tombo = $controle->row();
							# Parâmetros do WHERE
							$params = array('lotacoes_id'=>$info_tombo->estoques_id, 'produtos_id'=>$item->produtos_id);
						}
					}
					else {
						# Parâmetros do WHERE
						$params = array('lotacoes_id'=>$cautela->origem_id, 'produtos_id'=>$item->produtos_id);
					}
					# Recuperando o estoque atual
					$estoque_atual = $this->db->get_where('estoques', $params)->row();
					# Atualizando o estoque
					$novo_estoque = (int) $estoque_atual->quantidade - (int) $item->quantidade;
					$this->db->where($params);
					$this->db->update('estoques', array('quantidade'=>$novo_estoque));
				}
				return TRUE;
			}
			else return FALSE;
		}
		else return FALSE;
	}

	public function devolve_material($cautela_id) {
		# Testando se existe a cautela
		if (FALSE !== $this->getCautela($cautela_id)) {
			# Recuperando os dados da cautela
			$cautela = $this->getCautela($cautela_id)->row();
			# Recuperando os ítens
			$itens = $this->getItens($cautela_id);
			if (FALSE !== $itens) {
				# Atualizando o estoque
				foreach ($itens->result() as $item) {
					# Recuperando em que estoque o tombo se encontra
					if (!is_null($item->tombo_id)) {
						$controle = $this->db->get_where('patrimonio', array('id'=>$item->tombo_id));
						 if (FALSE !== $controle) {
							$info_tombo = $controle->row();
							# Parâmetros do WHERE
							$params = array('lotacoes_id'=>$info_tombo->estoques_id, 'produtos_id'=>$item->produtos_id);
						}
					}
					else {
						# Parâmetros do WHERE
						$params = array('lotacoes_id'=>$cautela->origem_id, 'produtos_id'=>$item->produtos_id);
					}
					# Recuperando o estoque atual
					$estoque_atual = $this->db->get_where('estoques', $params)->row();
					# Atualizando o estoque
					$novo_estoque = (int) $estoque_atual->quantidade + (int) $item->quantidade;
					$this->db->where($params);
					$this->db->update('estoques', array('quantidade'=>$novo_estoque));
				}
				return TRUE;
			}
			else return FALSE;
		}
		else return FALSE;
	}

	 public function getByTombo($tombo) {
	 	$tmb = (is_array($tombo)) ? $tombo['tombo'] : $tombo;
	 	$sql = "SELECT
						 	patrimonio.id AS tombo_id,
						 	patrimonio.tombo,
						 	CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS produto,
						 	grupo_produtos.nome AS grupo,
						 	patrimonio.notas_id
						 	FROM
						 	patrimonio
						 	INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
						 	INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
						 	INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
						 	WHERE patrimonio.tombo = '$tmb'";
						 	#var_dump($sql);
		$tombo_info = $this->db->query($sql);
		return ($tombo_info->num_rows() > 0) ? $tombo_info->row() : FALSE;
	 }

	public function getTomboInfo($tombo) {
		$sql = "SELECT
							patrimonio.id,
							patrimonio.tombo,
							marcas_produtos.marca,
							produtos.modelo,
							cautelas_has_produtos.cautelas_id,
							cautelas.data_cautela,
							cautelas.finalizada,
							cautelas.concluida,
							cautelas.cancelada,
							cautelas.ativa,
							origem.sigla AS setor,
							destino.sigla AS destino,
							cautelas_has_produtos.ativo AS transferencia
							FROM
								cautelas_has_produtos
								INNER JOIN patrimonio ON patrimonio.id = cautelas_has_produtos.tombo_id
								INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
								LEFT JOIN lotacoes AS destino ON destino.id = cautelas_has_produtos.destino_id
								LEFT JOIN lotacoes AS origem ON cautelas.setor_id = origem.id";
		if (isset($tombo)) {
			if ($tombo != '') {
				$sql .= " WHERE
										patrimonio.tombo = '$tombo'
										AND cautelas.ativa = 1
										AND cautelas.cancelada = 0
									ORDER BY
										cautelas_has_produtos.cautelas_id DESC,
										patrimonio.id ASC";
			}
			$tombo_info = $this->db->query($sql);
			if ($tombo_info->num_rows() > 0)
				return $tombo_info->result();
			else
				return FALSE;
		}
		else
			return FALSE;
	}

	public function getTombobyCautela($id = NULL) {
		if (!is_null($id)) {
			$sql = "SELECT
								patrimonio.produtos_id,
								CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS modelo,
								patrimonio.tombo,
								patrimonio.id
								FROM
									patrimonio
									INNER JOIN cautelas_has_produtos ON cautelas_has_produtos.tombo_id = patrimonio.id
									INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								WHERE
									cautelas_has_produtos.cautelas_id = $id";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0)
				return $query;
			else
				return FALSE;
		}
	}

	#Alterado por Pereira
	public function getTombosProduto($produtos_id = NULL, $estoques_id = 23, $disp = TRUE) {
		$sql_all = "SELECT
									patrimonio.tombo
									FROM
										patrimonio";
		$sql_out = "SELECT
									patrimonio.tombo
									FROM
										patrimonio
										INNER JOIN cautelas_has_produtos ON patrimonio.id = cautelas_has_produtos.tombo_id
										INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
										INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
									WHERE
										cautelas.concluida = 0
										AND cautelas.distribuicao != 2
										AND cautelas.ativa = 1";
		# Testando se tem um ID
		if (is_null($produtos_id)) {
			$sql_all .= " ORDER BY patrimonio.tombo DESC";
			$tombos_all = $this->db->query($sql_all)->result();
			foreach ($tombos_all as $value) {
				$tombos[] = $value->tombo;
			}
		}
		else {
			$sql_all .= " WHERE produtos_id = $produtos_id ORDER BY patrimonio.tombo DESC";
			$sql_out .= " AND produtos.id = $produtos_id  ORDER BY patrimonio.tombo DESC";
			# Executando as consultas
			$all = $this->db->query($sql_all);
			if ($all->num_rows() > 0) {
				foreach ($all->result() as $value) {
					$tombos_all[] = $value->tombo;
				}
			}
			$out = $this->db->query($sql_out);
			if ($out->num_rows() > 0) {
				foreach ($out->result() as $value) {
					$tombos_out[] = $value->tombo;
				}
			}
			$i = 0;
			# Checa se criou o array com todos os tombos
			if (isset($tombos_all)) {
				if (is_array($tombos_all)) {
					# Mostra apenas os tombos disponíveis
					if ($disp === TRUE) {
						# Checando quais tombos estão disponíveis
						if (isset($tombos_out) && count($tombos_out) > 0)
							$disponiveis = array_diff($tombos_all, $tombos_out);
						else
							$disponiveis = $tombos_all;
						# Criando um array com apenas os tombos disponíveis
						if (count($disponiveis) > 0) {
							foreach ($disponiveis as $value) {
								$tombos[$i] = $value;
								$i++;
							}
						}
					} else
						return array_reverse($tombos_all);# Mostra todos os tombos
				} else
					return FALSE;
			} else
				return FALSE;
		}
		# Gerando o retorno
		if (count($tombos) < 1)
			return FALSE;
		else
			return $tombos;
	}

	public function getTombosEstoque($estoques_id, $produtos_id = NULL) {
		$sql = "SELECT
							patrimonio.tombo
							FROM
							patrimonio
							WHERE (patrimonio.estoques_id = $estoques_id)";
		# Filtrando pelo produto
		if (!is_null($produtos_id)) $sql .= " AND (patrimonio.produtos_id = $produtos_id)";
		# Ordenando pelo tombo
		$sql .= " ORDER BY patrimonio.tombo ASC";
		# Executando
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query->result();
		else return FALSE;
	}

	public function getProdutos($data = NULL) {
		#var_dump($data); die();
		if (!is_null($data)) {
			if (is_array($data)) {
				if (count($data) > 1) {
					$sql = "SELECT
										produtos.id,
										CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS modelo,
										estoques.quantidade
										FROM
										estoques
										INNER JOIN produtos ON produtos.id = estoques.produtos_id
										INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
										WHERE
										produtos.consumo = ".$data['consumo']." AND
										estoques.lotacoes_id = ".$data['estoques_id']." AND
										estoques.quantidade > 0";
				}
				else {
					$sql = "SELECT
										produtos.id,
										CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS modelo,
										estoques.quantidade
										FROM
										estoques
										INNER JOIN produtos ON produtos.id = estoques.produtos_id
										INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
										WHERE
										estoques.quantidade > 0 AND
										estoques.lotacoes_id = ".$data['estoques_id'];
				}
				$query = $this->db->query($sql);
				return ($query->num_rows() > 0) ? $query->result() : FALSE;
			}
			else {
				return FALSE;
			}
		}
		else {
			return FALSE;
		}
	}

	#Alterado por Pereira
	public function getCautela($id = NULL) {
		$sql = "SELECT
							cautelas.id,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							DATE_FORMAT(cautelas.data_prevista,'%d/%m/%Y') AS data_prevista,
							cautelas.finalizada,
							DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y') AS data_conclusao,
							DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S') AS hora_conclusao,
							cautelas.concluida,
							cautelas.distribuicao,
							cautelas.ativa,
							cautelas.cancelada,
							militares.matricula,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							cautelas.estoques_id AS origem_id,
							origem.sigla AS estoque_sigla,
							origem.nome AS estoque_origem,
							cautelas.setor_id,
							destino.sigla,
							destino.nome AS setor
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
								INNER JOIN lotacoes AS origem ON cautelas.estoques_id = origem.id
								LEFT JOIN lotacoes AS destino ON cautelas.setor_id = destino.id";
		# Acrescenta o where
		if (!is_null($id)) {
			$sql .= " WHERE cautelas.id = $id";
		}
		# Executa
		//echo $sql; die();
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getItens($cautela_id) {
		$sql = "SELECT
							cautelas_has_produtos.cautelas_id,
							cautelas_has_produtos.id AS id_item,
							cautelas_has_produtos.produtos_id,
							CONCAT(marcas_produtos.marca,' ',produtos.modelo) AS produto,
							cautelas_has_produtos.produtos_qde AS quantidade,
							cautelas_has_produtos.tombo_id,
							cautelas_has_produtos.ativo
							FROM
								cautelas_has_produtos
								INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
							WHERE cautelas_has_produtos.cautelas_id = $cautela_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getCautelas($id = NULL) {
		$sql = "SELECT
							cautelas.id,
							cautelas.militares_id,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							cautelas.setor_id,
							lotacoes.sigla,
							cautelas.ativa,
							cautelas.finalizada,
							cautelas.concluida,
							cautelas.cancelada,
							DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y') AS data_conclusao,
							DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S') AS hora_conclusao,
							cautelas.distribuicao
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								LEFT JOIN lotacoes ON cautelas.setor_id = lotacoes.id
							WHERE
								cautelas.cancelada = 0";
		# Acrescenta o where
		if (!is_null($id)) {
			$sql .= " AND cautelas.id = $id";
		}
		# Executa
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getDistros($id = NULL) {
		$sql = "SELECT
							cautelas.id,
							cautelas.militares_id,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							cautelas.setor_id,
							lotacoes.sigla,
							cautelas.ativa,
							cautelas.finalizada,
							cautelas.concluida,
							DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y') AS data_conclusao,
							DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S') AS hora_conclusao,
							cautelas.distribuicao
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								LEFT JOIN lotacoes ON cautelas.setor_id = lotacoes.id
							WHERE
								cautelas.distribuicao = 1
								AND cautelas.cancelada = 0";
		# Acrescenta o where
		if (!is_null($id)) {
			$sql .= " AND cautelas.id = $id";
		}
		# Executa
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getTransferidos($id = NULL) {
		$sql = "SELECT
							cautelas.id,
							cautelas.militares_id,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							cautelas.setor_id,
							lotacoes.sigla,
							cautelas.ativa,
							cautelas.finalizada,
							cautelas.concluida,
							DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y') AS data_conclusao,
							DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S') AS hora_conclusao,
							cautelas.distribuicao
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								LEFT JOIN lotacoes ON cautelas.setor_id = lotacoes.id
							WHERE
								cautelas.distribuicao = 2
								AND cautelas.cancelada = 0";
		# Acrescenta o where
		if (!is_null($id)) {
			$sql .= " AND cautelas.id = $id";
		}
		# Executa
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function consulta_cautela($filter) {
		$sql = "SELECT
							cautelas.id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ',militares.nome_guerra) AS militar,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							cautelas.distribuicao,
							DATE_FORMAT(cautelas.data_prevista,'%d/%m/%Y') AS data_prevista_fmt,
							cautelas.data_prevista,
							cautelas.finalizada,
							cautelas.concluida,
							CONCAT(DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y'), ' às ', DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S')) AS data_conclusao,
							cautelas.ativa
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
							WHERE
								(cautelas.ativa = 1)
								AND (cautelas.cancelada = 0)
								AND (cautelas.distribuicao = 0)";
		# Aplicação dos filtros
		if (!empty($filter)) {
			# Filtro de matrícula
			if (isset($filter['matricula']) && $filter['matricula'] !== FALSE && $filter['matricula'] != '') {
				$sql .= " AND (militares.matricula = '" . $filter['matricula'] . "')";
			}
			# Fim do filtro de matrícula
			# Filtro de datas inteligente
			if (isset($filter['data_inicio']) && $filter['data_inicio'] != '') {
				$dtIni = $filter['data_inicio'];
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '$dtIni' AND '$dtFim')";
			} else {
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '2014-06-01' AND '$dtFim')";
			}
			# Fim do filtro de datas
			# Filtro de concluídas
			if (isset($filter['concluida'])) {
				if ($filter['concluida'] !== FALSE) $sql .= " AND (cautelas.concluida = " . $filter['concluida'] . ")";
				else $sql .= " AND (cautelas.concluida = 1)";
			}
			# Fim do filtro de concluídas
		}
		# Fim dos filtros
		# $sql .= " LIMIT 50 OFFSET 0 ";
		$sql.= " ORDER BY cautelas.data_cautela DESC";

		# Retorno
		$cautela = $this->db->query($sql);
		return $cautela;
		#else return FALSE;
	}

	public function consulta_distro($filter) {
		$sql = "SELECT
							cautelas.id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ',militares.nome_guerra) AS militar,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							cautelas.distribuicao,
							DATE_FORMAT(cautelas.data_prevista,'%d/%m/%Y') AS data_prevista_fmt,
							cautelas.data_prevista,
							cautelas.finalizada,
							cautelas.concluida,
							CONCAT(DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y'), ' às ', DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S')) AS data_conclusao,
							cautelas.ativa
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
							WHERE
								(cautelas.ativa = 1)
								AND (cautelas.cancelada = 0)
								AND (cautelas.distribuicao = 1)";
		# Aplicação dos filtros
		if (!empty($filter)) {
			# Filtro de matrícula
			if (isset($filter['matricula']) && $filter['matricula'] !== FALSE && $filter['matricula'] != '') {
				$sql .= " AND (militares.matricula = '" . $filter['matricula'] . "')";
			}
			# Fim do filtro de matrícula
			# Filtro de datas inteligente
			if (isset($filter['data_inicio']) && $filter['data_inicio'] != '') {
				$dtIni = $filter['data_inicio'];
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '$dtIni' AND '$dtFim')";
			} else {
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '2014-06-01' AND '$dtFim')";
			}
			# Fim do filtro de datas
			# Filtro de concluídas
			if (isset($filter['concluida'])) {
				if ($filter['concluida'] !== FALSE) $sql .= " AND (cautelas.concluida = " . $filter['concluida'] . ")";
				else $sql .= " AND (cautelas.concluida = 1)";
			}
			# Fim do filtro de concluídas
		}
		# Fim dos filtros
		# $sql .= " LIMIT 50 OFFSET 0 ";
		$sql.= " ORDER BY cautelas.data_cautela DESC";

		# Retorno
		$cautela = $this->db->query($sql);
		return $cautela;
		#else return FALSE;
	}

	public function consulta_transferencia($filter) {
		$sql = "SELECT
							cautelas.id,
							militares.matricula,
							CONCAT(patentes.sigla, ' ',militares.nome_guerra) AS militar,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							cautelas.distribuicao,
							cautelas.setor_id,
							lotacoes.sigla,
							cautelas.finalizada,
							cautelas.concluida,
							CONCAT(DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y'), ' às ', DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S')) AS data_conclusao,
							cautelas.ativa
							FROM
								cautelas
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
								LEFT JOIN lotacoes ON cautelas.setor_id = lotacoes.id
							WHERE
								(cautelas.ativa = 1)
								AND (cautelas.distribuicao = 2)";
		# Aplicação dos filtros
		if (!empty($filter)) {
			# Filtro de setor
			if (isset($filter['setor_id']) && $filter['setor_id'] !== FALSE && $filter['setor_id'] != 0) {
				$sql .= " AND (cautelas.setor_id = '" . $filter['setor_id'] . "')";
			}
			# Fim do filtro de setor
			# Filtro de datas inteligente
			if (isset($filter['data_inicio']) && $filter['data_inicio'] != '') {
				$dtIni = $filter['data_inicio'];
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '$dtIni' AND '$dtFim')";
			} else {
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '2014-06-01' AND '$dtFim')";
			}
			# Fim do filtro de datas
			# Filtro de concluídas
			/* if (isset($filter['concluida'])) {
				if ($filter['concluida'] !== FALSE) $sql .= " AND (cautelas.concluida = ".$filter['concluida'].")";
				else $sql .= " AND (cautelas.concluida = 1)";
				} */
			# Fim do filtro de concluídas
		}
		# Fim dos filtros
		# $sql .= " LIMIT 50 OFFSET 0 ";
		$sql.= " ORDER BY cautelas.data_cautela DESC";

		# Retorno
		$cautela = $this->db->query($sql);
		return $cautela;
		#else return FALSE;
	}
	# Fim do model
}
