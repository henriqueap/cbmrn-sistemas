<?php

class Notas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function dados_notas() {
		# Salvar primeiros dados da nota fiscal.
		$data = array(
				'numero' => $this->input->post('numero'),
				'empresas_id' => $this->input->post('empresas_id'),
				'tipo' => $this->input->post('tipo_nota_fiscal'),
				'data' => $this->clog_model->formataData($this->input->post('data'))
		);

		$this->db->insert('notas_fiscais', $data);
		return $this->db->insert_id();
	}

	# ID da nota fiscal, assim pegar todos os seus itens já cadastrados.

	public function itens_notas($id) {
		$this->db->where('id', $id);
		$query = $this->db->get("notas_fiscais")->row();
		#var_dump($query);

		if ($query->tipo != 0) {
			$_sql = "SELECT
								itens_notas_fiscais.id AS id_itens,
								itens_notas_fiscais.valor_unitario,
								itens_notas_fiscais.quantidade_item,
								tipo_servicos.nome AS tipo_servicos
								FROM
									itens_notas_fiscais
									INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
									INNER JOIN tipo_servicos ON itens_notas_fiscais.tipo_servicos_id = tipo_servicos.id
								WHERE
									itens_notas_fiscais.notas_fiscais_id = {$id}";
		} else {
			$_sql = "SELECT
								itens_notas_fiscais.id as id_itens,
								itens_notas_fiscais.valor_unitario,
								itens_notas_fiscais.quantidade_item,
								produtos.modelo
								FROM
									itens_notas_fiscais
									INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
									INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
								WHERE
									itens_notas_fiscais.notas_fiscais_id = {$id}";
		}
		$query = $this->db->query($_sql);
		#var_dump($query);
		return $query;
	}

	public function add_item($id_nota) {
		$err_count = 0;
		// Add.
		if (FALSE !== $this->input->post('tipo_servicos_id')) $tipo_servicos_id = $this->input->post('tipo_servicos_id');
		else $tipo_servicos_id = NULL;
		// Código apresentou erro no servidor em produção do CBM-RN.
		$produtos_id = $this->input->post('produtos_id');
		// Empty Database.
		if (!empty($produtos_id)) $produtos_id = $this->input->post('produtos_id');
		else {
			$produtos_id = NULL;
			return FALSE;
		}
		# Tratando o valor unitario
		$tam = count($this->input->post('valor_unitario'));
		$cents = str_ireplace(',', '.', substr($this->input->post('valor_unitario'), - 3));
		$new_val = substr($this->input->post('valor_unitario'), 0, $tam - 4);
		$valor_unitario = str_ireplace('.', '', $new_val) . $cents;
		# Criando o array para inserir no banco
		$data = array(
				'notas_fiscais_id' => $this->input->post('notas_fiscais_id'),
				'valor_unitario' => $valor_unitario,
				'quantidade_item' => $this->input->post('quantidade_item'),
				'produtos_id' => $produtos_id,
				'tipo_servicos_id' => $tipo_servicos_id
		);
		// Checar depois
		//$tipo = array('select_tombo'=>$this->input->post('select_tombo'));
		if ($this->input->post('numero_tombo') !== "") {
			# Procura as vírgulas e quebra a string em array
			$tombos = explode(",", $this->input->post('numero_tombo'));
			if (count($tombos) > 0) {
				$t = 0;
				$novo_arr = array();
				# Loop para preeencher o novo array
				for ($i = 0; $i < sizeof($tombos); $i++) {
					# Procura hífen, se achar preenche o intervalo
					if (substr_count($tombos[$i], "-") > 0) {
						# Encontra as extremidades e preenche se o intervalo está coerente
						$tombos_group = explode("-", trim($tombos[$i]));
						if ($tombos_group[0] < $tombos_group[1]) {
							$n = (int) $tombos_group[0];
							while ($n <= $tombos_group[1]) {
								$novo_arr[$t] = $n;
								$n++;
								$t++;
							}
						} else
							return FALSE;
					}
					else {
						$novo_arr[$t] = trim($tombos[$i]);
						$t++;
					}
				}
				# Testa se a quantidade de  tombos equivale a de produtos
				if (count($novo_arr) == (int) $data['quantidade_item']) {
					$fails = array();
					foreach ($novo_arr as $tombo) {
						$controle = $this->db->insert('patrimonio', array('tombo' => $tombo, 'produtos_id' => $data['produtos_id'], 'notas_id' => $data['notas_fiscais_id']));
						if ($this->db->affected_rows() < 1) {
							$fails[] = $tombo;
							$err_count++;
						}
					}
				} else
					return FALSE;
			}
		}
		# Inclui os ítens na nota
		if ($err_count == 0) {
			$query = $this->db->insert('itens_notas_fiscais', $data);
			if ($this->db->affected_rows() > 0) {
				return $query;
			} else
				return FALSE;
		} else
			return FALSE;
	}

	public function incluiTombos($data) {
		# echo "<pre>"; var_dump($data);  echo "</pre>"; die();
		if ($data['tombos'] !== "") {
			# Procura as vírgulas e quebra a string em array
			$tombos = explode(",", $data['tombos']);
			if (count($tombos) > 0) {
				$t = 0;
				$novo_arr = array();
				# Loop para preeencher o novo array
				for ($i = 0; $i < sizeof($tombos); $i++) {
					# Procura hífen, se achar preenche o intervalo
					if (substr_count($tombos[$i], "-") > 0) {
						# Encontra as extremidades e preenche se o intervalo está coerente
						$tombos_group = explode("-", trim($tombos[$i]));
						if ($tombos_group[0] < $tombos_group[1]) {
							$n = (int) $tombos_group[0];
							while ($n <= $tombos_group[1]) {
								$novo_arr[$t] = $n;
								$n++;
								$t++;
							}
						} 
						# Caso o valor final não seja maior que o inicial
						else {
							return FALSE;
						} 
					}
					# Caso não seja intervalo para preencher
					else {
						$novo_arr[$t] = trim($tombos[$i]);
						$t++;
					}
				}
				# Testa se a quantidade de  tombos equivale a de produtos
				if (count($novo_arr) == $data['quantidade']) {
					$err_count = 0;
					$fails = array();
					# Loop para testar os tombos 
					foreach ($novo_arr as $tombo) {
						$controle = $this->db->get_where('patrimonio', array('tombo' => $tombo));
						if ($controle->num_rows() > 0) {
							$fails[] = $tombo;
							$err_count++;
						}
					}
					if (count($fails) == 0) {
						# Loop para incluir os tombos 
						foreach ($novo_arr as $tombo) {
							$controle = $this->db->insert('patrimonio', array('tombo' => $tombo, 'produtos_id' => $data['produtos_id'], 'notas_id' => $data['notas_fiscais_id'], 'avulsa_id' => $data['avulsa_id'], 'estoques_id' => $data['lotacoes_id'], 'tipo_tombo' => $data['tipo_tombo']));
							if ($this->db->affected_rows() < 1) {
								$fails[] = $tombo;
								$err_count++;
							}
						}
					}
					# Retorna TRUE se tudo der certo e o array com os que falharam se não
					return ($err_count == 0) ? TRUE : $fails;
				} 
				# Caso a quantidade não bata...
				else {
					return FALSE;
				}
			}
			else {
				return FALSE;
			}
		}
	}

	public function concluir_notas_fiscais($data) {
		if (is_array($data)) {
			$concluir = array(
					'concluido' => '1',
					'valor' => $data['valor_final']
			);
			$query = $this->db->update('notas_fiscais', $concluir, array('id' => $data['id_nota_fiscal']));
			#var_dump($query); die();
			return TRUE;
		} 
		else {
			return FALSE;
		}
	}

	public function concluir_atualizar_estoque($id) {
		$err_count = 0;
		$this->db->select('*');
		$this->db->where('notas_fiscais_id', $id);
		$query = $this->db->get('itens_notas_fiscais');
		foreach ($query->result() as $query) {
			$controle = $this->db->get_where('estoques', array('produtos_id' => $query->produtos_id, 'lotacoes_id' => 23));
			if (0 !== $controle->num_rows()) {
				$estoque_atual = $controle->row();
				$novo_estoque = $estoque_atual->quantidade + $query->quantidade_item;
				$this->db->where(array('produtos_id' => $query->produtos_id, 'lotacoes_id' => 23));
				$this->db->update('estoques', array('quantidade' => $novo_estoque));
				# Havendo erro
				if ($this->db->affected_rows() < 1) {
					$produtos[$err_count] = $query->modelo;
					$err_count++;
				}
			}
			else {
				$novo_estoque = $query->quantidade_item;
				$this->db->insert('estoques', array('produtos_id' => $query->produtos_id, 'lotacoes_id' => 23, 'quantidade' => $novo_estoque));
				# Havendo erro
				if ($this->db->affected_rows() < 1) {
					$produtos[$err_count] = $query->modelo;
					$err_count++;
				}
			}
		}
		if ($err_count == 0)
			return TRUE;
		else
			return $produtos;
	}

	public function consulta_notas_fiscais($filter) {
		# Consulta de notas fiscais.
		$_sql = "SELECT 
							notas_fiscais.id as id_nota, notas_fiscais.valor, notas_fiscais.data, notas_fiscais.numero, 
							empresas.nome_fantasia, notas_fiscais.id, notas_fiscais.concluido, notas_fiscais.ativo
							FROM notas_fiscais
							JOIN empresas ON empresas.id = notas_fiscais.empresas_id";
		# Filtros
		$_ftr = " WHERE notas_fiscais.ativo = 0";
		if ($this->input->get('empresas_id') > 0) $_ftr .= " AND (empresas_id = ".$this->input->get('empresas_id').")";
		if ($this->input->get('ano_nota') > 999) $_ftr .= " AND (notas_fiscais.data LIKE '".$this->input->get('ano_nota')."%')";
		if ($this->input->get('data') != '') $_ftr .= " OR (notas_fiscais.data = '".$this->input->get('data')."')";
		if ($this->input->get('nota_fiscal') != '') $_ftr .= " OR (notas_fiscais.numero LIKE '%".$this->input->get('nota_fiscal')."%')";
		# Execução
		$_sql .= $_ftr;
		# var_dump($_sql); die();
		$query = $this->db->query($_sql);
		return $query;
	}

	public function getInfoNotas() {
		$this->db->where('concluido', '0');
		$query = $this->db->get('notas_fiscais');
		return $query;
	}

	public function excluir_nota($id) {
		# Excluir notas fiscais, caso não tenha sido concluída!
		$this->db->where('concluido', '0');
		$this->db->where('id', $id);
		$query = $this->db->delete('notas_fiscais');
		return $this->db->affected_rows();
	}

	public function excluir_nota_concluida($id) {
		$err_count = 0;
		$produtos = Array();
		$listTombos = Array();
		# Recuperando os itens da nota
		$this->db->where('id', $id);
		$nota = $this->db->get("notas_fiscais")->row();
		# Testa se a nota está concluída
		if ($nota->concluido == 1) {
			# Se for serviço...
			if ($nota->tipo != 0) {
				$_sql = "SELECT
									itens_notas_fiscais.id AS id_itens,
									itens_notas_fiscais.valor_unitario,
									itens_notas_fiscais.quantidade_item,
									tipo_servicos.nome AS tipo_servicos,
									notas_fiscais.concluido,
									itens_notas_fiscais.produtos_id
									FROM
										itens_notas_fiscais
										INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
										INNER JOIN tipo_servicos ON itens_notas_fiscais.tipo_servicos_id = tipo_servicos.id
									WHERE
										itens_notas_fiscais.notas_fiscais_id = {$id}";
			} 
			# Se for produto...
			else {
				$_sql = "SELECT
									itens_notas_fiscais.id as id_itens,
									itens_notas_fiscais.valor_unitario,
									itens_notas_fiscais.quantidade_item,
									produtos.modelo,
									produtos.consumo,
									notas_fiscais.concluido,
									itens_notas_fiscais.produtos_id
									FROM
										itens_notas_fiscais
										INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
										INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
									WHERE
										itens_notas_fiscais.notas_fiscais_id = {$id}";
				#echo $_sql; die();
			}
			# Executando a query
			$query = $this->db->query($_sql);
			# Tendo itens
			if (! is_bool($query)) {
				# Lendo os itens da nota, lista os tombos que saíram do estoque e conta os erros para poder atualizar o estoque
				foreach ($query->result() as $itens_nota) {
					# Sendo material permanente, testa se houve saída de material
					if ($itens_nota->consumo == 1) {
						$saidas = "SELECT
												cautelas_has_produtos.cautelas_id,
												cautelas_has_produtos.tombo_id,
												patrimonio.tombo,
												cautelas.distribuicao, 
												cautelas.concluida
												FROM
												patrimonio
												INNER JOIN cautelas_has_produtos ON patrimonio.id = cautelas_has_produtos.tombo_id
												INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
												WHERE
												patrimonio.notas_id = $id AND patrimonio.produtos_id = $itens_nota->produtos_id AND cautelas.ativa = 1";
						$hasSaida =  $this->db->query($saidas);
						# Se houver alguma saída de material permanente, lista os tombos que saíram
						if (! is_bool($hasSaida)) {
							# Preenchendo a lista de tombos
							foreach ($hasSaida->result() as $saida) {
								# Distros e transferências
								if ($saida->distribuicao > 0) {
									$listTombos[] = $saida->tombo;
								}
								# Cautelas
								else {
									if ($saida->concluida == 0) {
										$listTombos[] = $saida->tombo;
									}
								}              
							}
						}          
					}
					# Testa se existe o produto no estoque e conta os erros
					$checaEstoque = "SELECT quantidade FROM estoques WHERE (produtos_id = " . $itens_nota->produtos_id . ") AND (lotacoes_id = 23)";
					$controle = $this->db->query($checaEstoque);
					if (! is_bool($controle->num_rows())) {
						$produto = $controle->row();
						# Testando se o estoque ficará negativo
						if (($produto->quantidade - $itens_nota->quantidade_item) >= 0) {
							# Se o estoque não ficar negativo, alimenta o array que irá atualizar o estoque...
							$produtos[$itens_nota->produtos_id] = ($produto->quantidade - $itens_nota->quantidade_item);
						}
						else {
							# Contando os erros de estoque negativo
							$err_count += 1;
						}
					}
					else {
						# Contando os erros de produto que não existe no estoque
						$err_count += 1;
					}
				}
				# Verificando os erros para poder atualizar o estoque
				if (count($listTombos) > 0) {
					# Retorno quando o erro é a existência de sáida de material permanente constante da nota
					$retorno = array( 
						'status' => FALSE,
						'tombos' => $listTombos
					);
					return $retorno;
				}
				if ($err_count > 0) {
					# Retorno quando o erro é alteração no estoque
					$retorno = array( 
						'status' => FALSE,
						'msg' => 'O sistema não consegue excluir a nota, estoque de '.$err_count.' produto(s) ficará negativo!'
					);
					return $retorno;
				}
				# Tentando atualizar o estoque, inativar/excluir a nota e dar o retorno
				else {
					if (count($produtos) > 0) {
						$err_count = 0;
						foreach ($produtos as $_id => $_qde) {
							$this->db->where(array('produtos_id'=>$_id, 'lotacoes_id'=>23));
							$this->db->update('estoques', array('quantidade'=>$_qde));
							# Contando os erros de atualização
							$err_count += (0 < $this->db->affected_rows()) ? 0 : 1;
						}
						# Se não houver nenhum erro de atualização do estoque, tenta inativar/excluir a nota e dá o retorno
						if ($err_count == 0) {
							$this->db->where('id', $id);
							$this->db->update('notas_fiscais', array('ativo' => 1));
							# Testa se inativou/excluiu a nota     
							if (0 == $this->db->affected_rows()) {
								# Retorno quando o erro é na inativação/exclusão da nota
								$retorno = array( 
									'status' => FALSE,
									'msg' => 'O sistema não conseguiu excluir a nota!'
								);
								return $retorno;
							}
							else {
								# Excluindo os tombos
								$this->db->where('notas_id', $id);
								$this->db->delete('patrimonio');
								if ($this->db->affected_rows() > 0) {
									# Retorno quando a inativação/exclusão da nota foi concluída
									return TRUE;
								}
								else {
									# Retorno quando o erro é na inativação/exclusão da nota
									$retorno = array( 
										'status' => FALSE,
										'msg' => 'O sistema não conseguiu excluir os tombos desta nota!'
									);
									return $retorno;
								}
							}
						}
						else{
							# Retorno quando houve erro na atualização do estoque de algum produto
							$retorno = array( 
								'status' => FALSE,
								'msg' => 'O sistema não conseguiu excluir a nota, o estoque de '.$err_count.' produto(s) não foi atualizado!'
							);
							return $retorno;
						}
					}
				}
			}
			# Se a nota não tem itens e foi concluída, dá o retorno (Se ocorrer, tem algo errado)
			else { 
				# Retorno quando o erro é uma nota concluída sem itens
				$retorno = array( 
					'status' => FALSE,
					'msg' => "Como uma nota foi concluída sem itens?"
				);
				return $retorno;
			}           
		}
		# Se a nota não está concluída (Se ocorrer, tem algo errado)
		else {
			# Retorno quando o erro é uma nota não concluída
			$retorno = array( 
				'status' => FALSE,
				'msg' => "Como uma nota não concluída chegou aqui?"
			);
			return $retorno;
		}
	}

	public function listarEntradasAvulsas($lim = 0) {
		$_sql = "SELECT
							entradas_avulsas.id,
							entradas_avulsas.idproduto,
							CONCAT(marcas_produtos.marca,' ', produtos.modelo) AS produto,
							produtos.consumo,
							entradas_avulsas.quantidade,
							entradas_avulsas.idmilitar,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
							DATE_FORMAT(entradas_avulsas.data_inclusao, '%d/%m/%Y') AS data_inclusao,
							entradas_avulsas.ativo
							FROM
								entradas_avulsas
								INNER JOIN militares ON entradas_avulsas.idmilitar = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								INNER JOIN produtos ON entradas_avulsas.idproduto = produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
							ORDER BY entradas_avulsas.id DESC";
		$_sql .= (is_integer($lim) && $lim > 0) ? " LIMIT 0, $lim" : "";
		$query = $this->db->query($_sql);
		return ($query->num_rows() > 0) ? $query : FALSE;
	}

	public function getEntradaAvulsa($id) {
		$_sql = "SELECT
							entradas_avulsas.id,
							entradas_avulsas.idproduto,
							CONCAT(marcas_produtos.marca,' ', produtos.modelo) AS produto,
							produtos.consumo,
							entradas_avulsas.quantidade,
							entradas_avulsas.idmilitar,
							CONCAT(patentes.sigla, ' ', militares.nome_guerra) AS militar,
							DATE_FORMAT(entradas_avulsas.data_inclusao, '%d/%m/%Y') AS data_inclusao,
							entradas_avulsas.estoque AS estoque_id,
							lotacoes.sigla AS estoque,
							entradas_avulsas.ativo
							FROM
								entradas_avulsas
								INNER JOIN militares ON entradas_avulsas.idmilitar = militares.id
								INNER JOIN patentes ON militares.patente_patentes_id = patentes.id
								INNER JOIN produtos ON entradas_avulsas.idproduto = produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
								INNER JOIN lotacoes ON entradas_avulsas.estoque = lotacoes.id
							WHERE entradas_avulsas.id = $id";
		$query = $this->db->query($_sql);
		return ($query->num_rows() > 0) ? $query : FALSE;
	}

	public function excluir_entrada_avulsa($id) {
		# Recuperando os dados da entrada avulsa
		$controle = $this->getEntradaAvulsa($id);
		if ($controle->num_rows() > 0) {
			$avulsa = $controle->row();
			# Filtro
			$filter = array(
				'lotacoes_id' => $avulsa->estoque_id,
				'produtos_id' => $avulsa->idproduto
			);
			# Recuperando a quantidade atual e retornando a quantidade ao valor inicial
			$qde = $this->db->get_where('estoques', $filter)->row();
			$data['quantidade'] = $qde->quantidade - $avulsa->quantidade;
			$this->db->where($filter);
			$this->db->update('estoques', $data);
			# Excluindo a entrada avulsa
			if ($this->db->affected_rows() > 0) {
				$this->db->where(array('id'=>$avulsa->id));
				$this->db->delete('entradas_avulsas');
				if ($this->db->affected_rows() > 0) {
					# Excluindo os tombos
					$this->db->where('avulsa_id', $id);
					$this->db->delete('patrimonio');
					return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
				}
				else return FALSE;
			}
			else return FALSE;
		}
		else return FALSE;
	}

}