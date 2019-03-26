<?php

class Notas_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function getAlmox() {
		$this->db->where('almox', 1);
		$almox = $this->db->get('lotacoes')->row();
		return (count($almox) > 0)? $almox->id : FALSE;
	}

	public function dados_notas($id = NULL) {
		if (is_null($id)) {
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
		else {
			$_sql = "SELECT
								notas_fiscais.id,
								notas_fiscais.numero,
								notas_fiscais.data,
								notas_fiscais.valor,
								empresas.nome_fantasia AS empresa,
								notas_fiscais.concluido
								FROM
								notas_fiscais
								INNER JOIN empresas ON notas_fiscais.empresas_id = empresas.id
								WHERE
								notas_fiscais.id = $id";
			$query = $this->db->query($_sql);
			#var_dump($query);
			return ($query->num_rows() > 0) ? $query->row() : FALSE;
		}
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
				$_sql = "SELECT
									produtos.id,
									produtos.modelo,
									marcas_produtos.marca,
									grupo_produtos.nome AS grupo_produto
									FROM
									produtos
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									INNER JOIN grupo_produtos ON produtos.grupo_produtos_id = grupo_produtos.id
									WHERE produtos.id = $produtos_id";
				$getItem = $this->db->query($_sql);
				return ($getItem->num_rows() > 0) ? $getItem->row() : FALSE;
			} 
			else
				return FALSE;
		} 
		else
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
		# Pegando o ID do Almoxarifado Principal
		$almox = $this->getAlmox();
		$err_count = 0;
		$this->db->select('*');
		$this->db->where('notas_fiscais_id', $id);
		$query = $this->db->get('itens_notas_fiscais');
		foreach ($query->result() as $query) {
			$controle = $this->db->get_where('estoques', array('produtos_id' => $query->produtos_id, 'lotacoes_id' => $almox));
			if (0 !== $controle->num_rows()) {
				$estoque_atual = $controle->row();
				$novo_estoque = $estoque_atual->quantidade + $query->quantidade_item;
				$this->db->where(array('produtos_id' => $query->produtos_id, 'lotacoes_id' => $almox));
				$this->db->update('estoques', array('quantidade' => $novo_estoque));
				# Havendo erro
				if ($this->db->affected_rows() < 1) {
					$produtos[$err_count] = $query->modelo;
					$err_count++;
				}
			}
			else {
				$novo_estoque = $query->quantidade_item;
				$this->db->insert('estoques', array('produtos_id' => $query->produtos_id, 'lotacoes_id' => $almox, 'quantidade' => $novo_estoque));
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

	public function getInfoNotas($id = NULL) {
		if (is_null($id)) {
			$this->db->where('concluido', '0');
			$query = $this->db->get('notas_fiscais');
		}
		else {
			$sql = "SELECT
								notas_fiscais.id,
								notas_fiscais.numero,
								notas_fiscais.data,
								notas_fiscais.valor,
								notas_fiscais.tipo,
								empresas.nome_fantasia AS empresa,
								CONCAT(
									enderecos.logradouro,
									', ',
									enderecos.numero,
									', ',
									enderecos.bairro,
									'. ',
									enderecos.cidade,
									'/',
									enderecos.estado) AS endereco,
								enderecos.cep,
								contatos.nome,
								contatos.telefones_id,
								contatos.email,
								telefones.telefone,
								IF (notas_fiscais.ativo = 0, 'válida','cancelada') AS situacao,
								notas_fiscais.ativo = 0
								FROM
									notas_fiscais
									INNER JOIN empresas ON notas_fiscais.empresas_id = empresas.id
									INNER JOIN enderecos ON empresas.enderecos_id = enderecos.id
									INNER JOIN contatos_das_empresas ON contatos_das_empresas.empresas_id = empresas.id
									INNER JOIN contatos ON contatos_das_empresas.contatos_id = contatos.id
									INNER JOIN telefones ON contatos.telefones_id = telefones.id
								WHERE notas_fiscais.ativo = 0 AND notas_fiscais.id = $id";
			$query = $this->db->query($sql);
		}
		return ($query->num_rows() > 0)? $query : FALSE;
	}

	public function getItensNota($id, $det = FALSE) {
		if ($id > 0) {
			if ($det === FALSE) {
				$sql = "SELECT
									itens_notas_fiscais.id AS id_itens,
									marcas_produtos.marca,
									produtos.modelo,
									itens_notas_fiscais.valor_unitario,
									itens_notas_fiscais.quantidade_item,
									itens_notas_fiscais.produtos_id,
									produtos.consumo
									FROM
									itens_notas_fiscais
									INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									WHERE
										itens_notas_fiscais.notas_fiscais_id = $id";
			}
			else {
				$sql = "SELECT
									itens_notas_fiscais.id AS id_itens,
									itens_notas_fiscais.produtos_id,
									marcas_produtos.marca,
									produtos.modelo,
									itens_notas_fiscais.quantidade_item,
									itens_notas_fiscais.valor_unitario,
									produtos.consumo,
									patrimonio.id AS tombo_id,
									patrimonio.tombo,
									notas_fiscais.concluido AS nota_concluida
									FROM
										itens_notas_fiscais
										INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
										INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
										INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
										LEFT JOIN patrimonio ON patrimonio.produtos_id = produtos.id AND itens_notas_fiscais.notas_fiscais_id = patrimonio.notas_id
									WHERE
										itens_notas_fiscais.notas_fiscais_id = $id";
			}
			$query = $this->db->query($sql);
			return ($query->num_rows() > 0)? $query->result() : FALSE;
		}
		else return FALSE;
	}

	public function getItemNota($id, $det = FALSE) {
		if (! $det) {
			$_sql = "SELECT
									itens_notas_fiscais.id,
									itens_notas_fiscais.produtos_id,
									produtos.consumo,
									marcas_produtos.marca,
									produtos.modelo,
									itens_notas_fiscais.quantidade_item,
									itens_notas_fiscais.valor_unitario
									FROM
											itens_notas_fiscais
											INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
											INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									WHERE
											itens_notas_fiscais.id = $id";
			$query = $this->db->query($_sql);
			return ($query->num_rows() > 0) ? $query->row() : FALSE;
		}
		else {
			$_sql = "SELECT
								itens_notas_fiscais.id,
								itens_notas_fiscais.produtos_id,
								marcas_produtos.marca,
								produtos.modelo,
								produtos.consumo,
								itens_notas_fiscais.quantidade_item,
								itens_notas_fiscais.valor_unitario,
								empresas.nome_fantasia AS empresa,
								itens_notas_fiscais.notas_fiscais_id,
								patrimonio.id AS tombo_id,
								patrimonio.tombo,
								notas_fiscais.numero
								FROM
									itens_notas_fiscais
									INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
									INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									INNER JOIN empresas ON notas_fiscais.empresas_id = empresas.id
									LEFT JOIN patrimonio ON patrimonio.produtos_id = produtos.id AND patrimonio.notas_id = itens_notas_fiscais.notas_fiscais_id
								WHERE itens_notas_fiscais.id = $id";
			$query = $this->db->query($_sql);
			return ($query->num_rows() > 0) ? $query->result() : FALSE;
		}
	}

	public function excluir_item_nota($id) {
		$err_count = 0;
		$item = $this->getItemNota($id, TRUE);
		# Se não existir o item...
		if (! $item) {
			return FALSE;
		}
		# Se existir...
		else {
			# Excluindo o patrimonio
			if (count($item) > 1) {
				foreach ($item as $row) {
					$whr = array('id' => $row->tombo_id);
					$this->db->where($whr);
					$this->db->delete('patrimonio');
					$err_count += ($this->db->affected_rows() > 0)? 0 : 1;
				}
				if ($err_count == 0) {
					$this->db->where('id', $id);
					$this->db->delete('itens_notas_fiscais');
					return ($this->db->affected_rows() > 0)? TRUE : FALSE;
				}
				else return FALSE;
			}
			else {
				$this->db->where('id', $id);
				$this->db->delete('itens_notas_fiscais');
				return ($this->db->affected_rows() > 0)? TRUE : FALSE;
			}
			return ($err_count == 0)? TRUE : FALSE;
		}
	}

	public function excluir_nota($id) {
		$err_count = 0;
		# Testa se existe a nota
		if (! $this->getInfoNotas($id)) {
			return FALSE;
		}
		else {
			# Testando se existe itens na nota
			$itens = $this->getItensNota($id);
			if ($itens !== FALSE) {
				foreach ($itens as $item) {
					$err_count += (! $this->excluir_item_nota($item->id_itens))? 1 : 0;
				}
			}
			if ($err_count < 1) {
				# Excluir notas fiscais, caso não tenha sido concluída!
				$this->db->where('concluido', '0');
				$this->db->where('id', $id);
				$query = $this->db->delete('notas_fiscais');
				return ($this->db->affected_rows() > 0)? $this->db->affected_rows() : FALSE;
			}
		}
	}

	public function excluir_nota_concluida($id) {
		# Pegando o ID do Almoxarifado Principal
		$almox = $this->getAlmox();
		# Excluindo itens se houver
		$controle = $this->getItensNota($id);
		/*echo "<pre>";
			var_dump($controle); 
		echo "</pre>";	die();*/
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
									itens_notas_fiscais.id AS id_itens,
									itens_notas_fiscais.valor_unitario,
									itens_notas_fiscais.quantidade_item,
									produtos.modelo,
									produtos.consumo,
									itens_notas_fiscais.produtos_id,
									patrimonio.id AS tombo_id,
									patrimonio.tombo,
									notas_fiscais.concluido
									FROM
										itens_notas_fiscais
										INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
										INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
										LEFT JOIN patrimonio ON patrimonio.produtos_id = produtos.id AND itens_notas_fiscais.notas_fiscais_id = patrimonio.notas_id
									WHERE
									itens_notas_fiscais.notas_fiscais_id = {$id}";
			}
			# Executando a query
			$query = $this->db->query($_sql);
			# Tendo itens
			if (! is_bool($query)) {
				# Lendo os itens da nota, lista os tombos que saíram do estoque e conta os erros para poder atualizar o estoque
				foreach ($query->result() as $itens_nota) {
					# Sendo material permanente, testa se houve saída de material
					if ($itens_nota->consumo == 1) {
						if (! isset($produtos[$itens_nota->produtos_id])) $produtos[$itens_nota->produtos_id] = $itens_nota->quantidade_item;
						$saidas = "SELECT
												itens_notas_fiscais.id AS item_id,
												itens_notas_fiscais.notas_fiscais_id,
												itens_notas_fiscais.produtos_id,
												produtos.modelo,
												cautelas_has_produtos.tombo_id,
												patrimonio.tombo,
												cautelas_has_produtos.cautelas_id,
												cautelas.distribuicao,
												cautelas.concluida
												FROM
												cautelas_has_produtos
												INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
												INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
												INNER JOIN patrimonio ON cautelas_has_produtos.tombo_id = patrimonio.id
												INNER JOIN itens_notas_fiscais ON patrimonio.notas_id = itens_notas_fiscais.notas_fiscais_id AND patrimonio.produtos_id = itens_notas_fiscais.produtos_id
												WHERE
												(cautelas.cancelada = 0 AND cautelas.ativa = 1) AND
												cautelas_has_produtos.tombo_id = $itens_nota->tombo_id";
						$hasSaida = $this->db->query($saidas);
						# Se houver alguma saída de material permanente, lista os tombos que saíram
						if ($hasSaida->num_rows() > 0) {
							$saida = $hasSaida->row();
							## Preenchendo a lista de tombos
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
						else $produtos[$itens_nota->produtos_id] = $produtos[$itens_nota->produtos_id] - 1;
					} # .permanente
					# Sendo consumo, testa se existe o produto no estoque e conta os erros
					else {	
						$checaEstoque = "SELECT quantidade FROM estoques WHERE (produtos_id = $itens_nota->produtos_id) AND (lotacoes_id = $almox)";
						$controle = $this->db->query($checaEstoque);
						if ($controle->num_rows() > 0) {
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
						/* else {
							# Contando os erros de produto que não existe no estoque
							$err_count += 1;
						}*/
					} # .consumo
				} # .foreach
				## Verificando os erros para poder atualizar o estoque
				if ($err_count > 0) {
					# Erro no material de consumo,alteração no estoque
					$retorno = array( 
						'status' => FALSE,
						'msg' => 'O sistema não consegue excluir a nota, estoque de '.$err_count.' produto(s) ficará negativo!'
					);
					return $retorno;
				}
				# Se não houver erro de estoque vazio...
				else {
					# Testando se dá erro no material permanente
					if (count($listTombos) > 0) {
						# Retorno quando o erro é a existência de saída de material permanente constante da nota
						$tombos = rtrim(implode($listTombos, ", "), ", ");
						$retorno = array( 
							'status' => FALSE,
							'msg' => "Existe saída de material com os seguintes tombos desta nota: $tombos"
						);
						return $retorno;
					}
					else {
						$err_count = 0;
						# var_dump($produtos); die();
						foreach ($produtos as $_id => $_qde) {
							$this->db->where(array('produtos_id' => $_id, 'lotacoes_id' => $almox));
							$this->db->update('estoques', array('quantidade'=>$_qde));
							# Contando os erros de atualização
							$err_count += (0 < $this->db->affected_rows()) ? 0 : 1;
						} # .foreach
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
						# Retorno quando o erro é na atualização do estoque
						else {
							$retorno = array( 
								'status' => FALSE,
								'msg' => 'O sistema não conseguiu atualizar o estoque dos produtos desta nota!'
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