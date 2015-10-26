<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
ini_set('memory_limit', '256M');

class Cautelas_model extends CI_Model 
{

	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model(array('clog_model'));
	}

	# Alterado por Pereira
	public function validarTombo ($tombo) {
		$sql = "SELECT
								patrimonio.id,
								patrimonio.produtos_id,
								produtos.modelo,
								marcas_produtos.marca,
								cautelas.id AS cautela_id,
								lotacoes.sigla AS setor,
								cautelas.finalizada,
								cautelas.distribuicao,
								cautelas_has_produtos.id AS item_id
								FROM
									patrimonio
									INNER JOIN cautelas_has_produtos ON patrimonio.id = cautelas_has_produtos.tombo_id
									INNER JOIN cautelas ON cautelas_has_produtos.cautelas_id = cautelas.id
									INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
									INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
									INNER JOIN lotacoes ON lotacoes.id = cautelas.setor_id
								WHERE 
									cautelas.ativa = 1
									AND cautelas.concluida = 0
									AND	cautelas_has_produtos.ativo = 1";
		# Checar se foi a melhor solução depois
		if (! is_array($tombo)) {
			$sql .= " AND patrimonio.tombo = '$tombo' ORDER BY cautelas.id DESC"; 
			$controle = $this->db->query($sql);
			if ($controle->num_rows() > 0) return $controle->row();
			else {
				$tomboExists = $this->db->get_where('patrimonio', array('tombo'=>$tombo));
				if ($tomboExists->num_rows() > 0) return $tomboExists->row();
				else return FALSE;
			}
		}
		else {
			$tomboExists = $this->db->get_where('patrimonio', array('produtos_id'=>$tombo['produto_id'], 'tombo'=>$tombo['tombo']));
			# Testa se o tombo bate com o produto
			if ($tomboExists->num_rows() > 0) {
				$sql .= " AND patrimonio.tombo = '".$tombo['tombo']."' AND patrimonio.produtos_id = '".$tombo['produto_id']."' ORDER BY cautelas.id DESC";
				$controle = $this->db->query($sql);
				if ($controle->num_rows() < 1) return $tomboExists->row(); 
				else return $controle->row();
			}
			else return FALSE;
		}
	}	

	#Alterado por Pereira
	public function add_itens($id, $data, $tombos) {
		# Testando se a cautela existe
		$err_count = 0;
		$cautelaExists = $this->db->get_where('cautelas', array('id'=>$id,'cancelada'=>0));
		if ($cautelaExists !== FALSE) {
			# Se permanente
			if($data['tipo_produto'] == 1) {
				$contador = intval($data['produtos_qde']);
				$i = 0;
				while ($contador > 0) {
					# Procura o tombo
					$numero_tombo = array(
													'produto_id'=>$data["produtos_id"],	
													'tombo'=>$tombos[$i]	
												);
					# Testa se o tombo encontrado bate com o produto e se está disponível
					$tombo_info = $this->validarTombo($numero_tombo);
					if ($tombo_info === FALSE || isset($tombo_info->cautela_id)) $err_count++;
					else {
						$produto = array(
							'cautelas_id'=>$data["cautelas_id"],
							'produtos_id'=>$data["produtos_id"],					
							'produtos_qde'=>1,
							'tombo_id'=>$tombo_info->id
						);
						$controle = $this->db->insert('cautelas_has_produtos', $produto);
						if ($this->db->affected_rows() < 1) $err_count++;
					}
					$contador--;
					$i++;
				}
				# Retorno da função
				if ($err_count < 1)	return TRUE;
				else return $err_count;
			}
			# Se consumo
			else {
				$produto = array(
										'cautelas_id'=>$data["cautelas_id"],
										'produtos_id'=>$data["produtos_id"],					
										'produtos_qde'=>$data["produtos_qde"]
									);
				# Testando se o produto já existe na cautela
				$produtoExists = $this->db->get_where('cautelas_has_produtos', array('cautelas_id'=>$data["cautelas_id"], 'produtos_id'=>$data["produtos_id"]));
				# Se não existir, inclui o novo item
				if ($produtoExists->num_rows() < 1) $this->db->insert('cautelas_has_produtos', $produto);
				# Se existir atualiza a quantidade 
				else {
					foreach ($produtoExists->result() as $item) {
						if ($item->produtos_id == $produto['produtos_id']) {
							$quantidade = array(
								'produtos_qde' => $item->produtos_qde + $produto['produtos_qde']
							);
							# Atualiza a quantidade
							$this->db->where('id', $item->id);
							$this->db->update('cautelas_has_produtos', $quantidade);
						}
					}
				}
				# Retorno da função
				if ($this->db->affected_rows() < 1) return FALSE;
				else return TRUE;
			}
		}
		#Retorno se não existir a cautela
		else return FALSE;
	}

	#Alterado por Pereira
	/*public function atualiza_estoque($id) {
		$controle = array(); # Guarda o estoque atual de cada produto
		$produto = array(); # Guarda a quantidade de cada produto na cautela
		$err_count = 0; # Contagem de erros
		$sql = "SELECT
							cautelas_has_produtos.cautelas_id,
							cautelas_has_produtos.id AS item_id,
							cautelas_has_produtos.produtos_id,
							cautelas_has_produtos.produtos_qde,
							cautelas_has_produtos.tombo_id,
							produtos.quantidade_estoque,
							produtos.id, 
							produtos.modelo
							FROM
								produtos
								INNER JOIN cautelas_has_produtos ON cautelas_has_produtos.produtos_id = produtos.id
							WHERE
								cautelas_has_produtos.cautelas_id = $id";
		$result_id = $this->db->query($sql)->result();
		$cont = count($result_id);
		# Tentando alterar o estoque
		if($cont > 0) {
			# Garantindo o retorno ao estado inicial e juntando as quantidades dos produtos repetidos
			foreach ($result_id as $item) {
				$controle[$item->produtos_id] = $item->quantidade_estoque;
				# Testa se o produto já apareceu na cautela e soma as quantidades
				if (! isset($controle[$item->produtos_id])) $produto[$item->produtos_id] = (int) $item->produtos_qde;
				else $produto["$item->produtos_id"] = (int) $produto["$item->produtos_id"] + (int) $item->produtos_qde; 
			}
			# Atualizando o estoque
			foreach ($produto as $_id=>$_qde) {
				$estoque_atualizado = (int) $controle[$_id] + $_qde;
				$this->db->where('id', $_id);
				$this->db->update('produtos', array('quantidade_estoque'=>$estoque_atualizado));
				# Havendo erro
				if ($this->db->affected_rows() < 1) $err_count++;
			}	
		}
		# Cautela vazia
		else return FALSE; 
		# Estoque atualizado
		if($err_count > 0) {
			foreach ($controle as $key => $val) {
				$this->db->where('id', $key);
				$this->db->update('produtos', array('quantidade_estoque' => $val));
			}
			return FALSE;
		}
		# Retornando o estoque ao estado inicial em caso de erro
		else return TRUE;
	}*/

	public function atualiza_estoque($cautela_id) {
		$$origem = array(); # Guarda o estoque atual de cada produto no estoque de origem
		$produto = array(); # Guarda a quantidade de cada produto na cautela
		//$err_count = 0; # Contagem de erros
		$info_cautela = $this->getCautela($cautela_id)->row();
		//echo "<pre> Cautela: "; var_dump($info_cautela); echo "</pre>";
		$sql = "SELECT
							cautelas_has_produtos.id,
							cautelas_has_produtos.cautelas_id,
							cautelas_has_produtos.produtos_qde,
							cautelas_has_produtos.produtos_id,
							produtos.modelo AS produto,
							produtos.quantidade_minima,
							cautelas.distribuicao,
							cautelas.estoques_id AS origem,
							cautelas.setor_id AS destino,
							estoque_origem.quantidade AS origem_estoque,
							estoque_destino.quantidade AS destino_estoque
							FROM
								cautelas_has_produtos
								INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
								INNER JOIN cautelas ON cautelas.id = cautelas_has_produtos.cautelas_id
								INNER JOIN lotacoes AS origem ON cautelas.estoques_id = origem.id
								INNER JOIN lotacoes AS destino ON cautelas.setor_id = destino.id
								INNER JOIN estoques AS estoque_origem ON cautelas_has_produtos.produtos_id = estoque_origem.produtos_id AND origem.id = estoque_origem.lotacoes_id
								LEFT JOIN estoques AS estoque_destino ON cautelas_has_produtos.produtos_id = estoque_destino.produtos_id AND destino.id = estoque_destino.lotacoes_id
							WHERE
								cautelas_has_produtos.cautelas_id = $cautela_id";
		$result_id = $this->db->query($sql)->result();
		//echo "<pre>"; var_dump($result_id); echo "</pre>";
		$cont = count($result_id);
		# Tentando alterar o estoque
		if($cont > 0) {
			# Garantindo o retorno ao estado inicial e juntando as quantidades dos produtos repetidos
			foreach ($result_id as $item) {
				$origem[$item->produtos_id] = (int) $item->origem_estoque; # Estoque atual do produto na origem
				# Testa se o produto já apareceu na cautela e soma as quantidades
				if (! isset($produto[$item->produtos_id])) $produto[$item->produtos_id] = (int) $item->produtos_qde;
				else $produto[$item->produtos_id] = (int) $produto[$item->produtos_id] + (int) $item->produtos_qde; 
			}
			//echo "<pre> Origem: "; var_dump($origem); echo "</pre>";
			# Atualizando o estoque
			foreach ($produto as $_id=>$_qde) {
				$estoque_atualizar = (int) $origem[$_id] - $_qde;
				# Atualizando o estoque
				$controle = $this->db->get_where('estoques', array('lotacoes_id'=>23, 'produtos_id'=>$_id));
				//echo "<pre> Controle: "; var_dump($controle->num_rows); echo "</pre>";
				if ($controle->num_rows > 0) {
					$this->db->where(array('lotacoes_id'=>$info_cautela->setor_id, 'produtos_id'=>$_id));
					$this->db->update('estoques', array('quantidade'=>$estoque_atualizar));
					//if ($this->db->affected_rows() < 1) $err_count++; # Havendo erro
				}
				else {
					$this->db->insert('estoques', array('lotacoes_id'=>23, 'produtos_id'=>$_id,'quantidade'=>$estoque_atualizar));
					//if ($this->db->affected_rows() < 1) $err_count++; # Havendo erro
				}
			}
			return TRUE;
		}
		# Cautela vazia
		else return FALSE;
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
									ORDER BY
										cautelas_has_produtos.cautelas_id DESC,
										patrimonio.id ASC";
			}
			$tombo_info = $this->db->query($sql);
			if ($tombo_info->num_rows() > 0) return $tombo_info->result();
			else return FALSE;
		}
		else return FALSE;
	}

	public function getTombobyCautela($id=NULL) {
		if (! is_null($id)) {
			$sql = "SELECT 
								patrimonio.produtos_id,
								produtos.modelo,
								patrimonio.tombo, 
								patrimonio.id
								FROM 
									patrimonio  
									INNER JOIN cautelas_has_produtos ON cautelas_has_produtos.tombo_id = patrimonio.id
									INNER JOIN produtos ON patrimonio.produtos_id = produtos.id
								WHERE 
									cautelas_has_produtos.cautelas_id = $id";
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) return $query;
			else return FALSE;
		}
	}

	/*public function getTombosProduto($id = NULL) { 
		$sql = "SELECT
							patrimonio.tombo
							FROM
								patrimonio";
		# Testando se tem um ID
		if (! is_null($id)) $sql .= " WHERE produtos_id = $id";
		# Executando a consulta
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query->result_array();
		else return FALSE;
	}*/

	#Alterado por Pereira
	public function getTombosProduto($id=NULL, $disp=TRUE) { 
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
		if (is_null($id)) {
			$sql_all .= " ORDER BY patrimonio.tombo DESC";
			$tombos_all = $this->db->query($sql_all)->result();
			foreach ($tombos_all as $value) {
				$tombos[] = $value->tombo;
			}
		}
		else {
			$sql_all .= " WHERE produtos_id = $id ORDER BY patrimonio.tombo DESC";
			$sql_out .= " AND produtos.id = $id  ORDER BY patrimonio.tombo DESC";
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
						if (isset($tombos_out) && count($tombos_out) > 0) $disponiveis = array_diff($tombos_all, $tombos_out);
						else $disponiveis = $tombos_all;
						# Criando um array com apenas os tombos disponíveis
						if (count($disponiveis) > 0) {
							foreach ($disponiveis as $value) {
								$tombos[$i] = $value;
								$i++;
							}
						}
					}
					else return array_reverse($tombos_all); # Mostra todos os tombos
				}
				else return FALSE;
			}
			else return FALSE;
		}
		# Gerando o retorno
		if (count($tombos) < 1) return FALSE;
		else return $tombos;
	}

	public function getTombosEstoque($setor_id, $produtos_id = NULL) {
		$sql = "SELECT
							patrimonio.id,
							patrimonio.tombo,
							CONCAT(produtos.modelo,' ', marcas_produtos.marca) AS produto
							FROM
								cautelas
								INNER JOIN cautelas_has_produtos ON cautelas_has_produtos.cautelas_id = cautelas.id
								INNER JOIN patrimonio ON cautelas_has_produtos.tombo_id = patrimonio.id
								INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
								INNER JOIN marcas_produtos ON produtos.marcas_produtos_id = marcas_produtos.id
							WHERE
								(cautelas.distribuicao = 2) AND
								(cautelas.concluida = 1) AND
								(cautelas.cancelada = 0) AND
								(cautelas.setor_id = $setor_id)";
		if (! is_null($tipo)) $sql .= " AND (patrimonio.produtos_id = $produtos_id)";
		$sql .= " ORDER BY patrimonio.tombo ASC";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query->result();
		else return FALSE;
	}

	public function getProdutos($tipo=NULL) {
		if (! is_null($tipo)) { 
			$sql = "SELECT id, modelo FROM produtos WHERE consumo = ".$tipo["consumo"];
			$query = $this->db->query($sql);
			if ($query->num_rows() > 0) return $query->result();
			else return FALSE;
		}
	}

	#Alterado por Pereira
	public function getCautelas($id=NULL) {
		$sql = "SELECT
							cautelas.id,
							produtos.modelo AS produto,
							cautelas_has_produtos.produtos_id,
							DATE_FORMAT(cautelas.data_cautela,'%d/%m/%Y') AS data_cautela,
							DATE_FORMAT(cautelas.data_prevista,'%d/%m/%Y') AS data_prevista,
							cautelas.finalizada,
							DATE_FORMAT(cautelas.data_conclusao,'%d/%m/%Y') AS data_conclusao,
							DATE_FORMAT(cautelas.data_conclusao,'%H:%i:%S') AS hora_conclusao,
							cautelas.concluida,
							cautelas.distribuicao,
							cautelas.ativa,
							cautelas_has_produtos.id AS id_item,
							cautelas_has_produtos.produtos_qde AS quantidade,
							militares.matricula,
							cautelas_has_produtos.tombo_id,
							cautelas_has_produtos.ativo,
							CONCAT(patentes.sigla,' ',militares.nome_guerra) AS militar,
							lotacoes.sigla AS setor
							FROM
								cautelas
								INNER JOIN cautelas_has_produtos ON cautelas_has_produtos.cautelas_id = cautelas.id
								INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
								INNER JOIN militares ON cautelas.militares_id = militares.id
								INNER JOIN patentes ON patentes.id = militares.patente_patentes_id
								LEFT JOIN lotacoes ON cautelas_has_produtos.destino_id = lotacoes.id
							WHERE cautelas.distribuicao = 0";
		# Acrescenta o where
		if (! is_null($id)) {
			$sql .= " AND cautelas.id = $id";
		}
		# Executa
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getCautela($id=NULL) {
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
								INNER JOIN lotacoes AS destino ON cautelas.setor_id = destino.id";
		# Acrescenta o where
		if (! is_null($id)) {
			$sql .= " WHERE cautelas.id = $id";
		}
		# Executa
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getDistros($id=NULL) {
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
								INNER JOIN lotacoes ON cautelas.setor_id = lotacoes.id
							WHERE cautelas.distribuicao > 0";
		# Acrescenta o where
		if (! is_null($id)) {
			$sql .= " AND cautelas.id = $id";
		}
		# Executa
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	public function getItens($cautela_id) {
		$sql = "SELECT
							cautelas_has_produtos.cautelas_id,
							cautelas_has_produtos.id AS id_item,
							cautelas_has_produtos.produtos_id,
							produtos.modelo AS produto,
							produtos.quantidade_estoque AS estoque,
							cautelas_has_produtos.produtos_qde AS quantidade,
							cautelas_has_produtos.tombo_id,
							cautelas_has_produtos.ativo
						FROM
							cautelas_has_produtos
							INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
						WHERE cautelas_has_produtos.cautelas_id = $cautela_id";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) return $query;
		else return FALSE;
	}

	/**
	 * Concluir Cautela e atualizar o estoque atual.
	 * @param $id;
	 */

	#Alterado por Pereira
	/*public function concluir_saida($id) {
		$err_count = 0;
		$info_cautela = 
		$sql = "SELECT
							cautelas_has_produtos.id,
							cautelas_has_produtos.cautelas_id,
							cautelas_has_produtos.produtos_qde AS quantidade,
							cautelas_has_produtos.produtos_id AS item_id,
							produtos.modelo AS produto,
							produtos.quantidade_minima,
							cautelas.distribuicao,
							cautelas.estoques_id AS origem,
							cautelas.setor_id AS destino,
							estoque_origem.quantidade AS origem_estoque,
							estoque_destino.quantidade AS destino_estoque
							FROM
								cautelas_has_produtos
								INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
								INNER JOIN cautelas ON cautelas.id = cautelas_has_produtos.cautelas_id
								INNER JOIN lotacoes AS origem ON cautelas.estoques_id = origem.id
								INNER JOIN lotacoes AS destino ON cautelas.setor_id = destino.id
								INNER JOIN estoques AS estoque_origem ON cautelas_has_produtos.produtos_id = estoque_origem.produtos_id AND origem.id = estoque_origem.lotacoes_id
								LEFT JOIN estoques AS estoque_destino ON cautelas_has_produtos.produtos_id = estoque_destino.produtos_id AND destino.id = estoque_destino.lotacoes_id
							WHERE cautelas_has_produtos.cautelas_id = $id";
		$cautela = $this->db->query($sql);
		# Testa o estado do estoque
		foreach ($cautela->result() as $item) { 
			# Lendo os ítens
			$p = $item->item_id;
			$q = $item->quantidade;
			$origem = $this->db->get_where('estoques', array('lotacoes_id'=>$item->origem, 'produtos_id'=>$p))->row();
			# Checando se há produtos repetidos e somando as quantidades para atualizar o estoque origem
			if (! isset($data[$p])) $data[$p] = (int) $origem->quantidade - $q; 
			else $data[$p] -= $q;
			#Contando erros
			if ($data[$p] <= 0 || $data[$p] < $item->quantidade_minima) $err_count++;
			# Checando se há produtos repetidos e somando as quantidades para atualizar o estoque destino
			if (! isset($data[$p])) $data[$p] = (int) $item->estoque - $q; 
			else $data[$p] -= $q;
		}
		# Gerando o resultado da função
		if ($err_count > 0) return FALSE;
		else {
			# Lendo o array
			var_dump($data); die();
			foreach ($data as $key => $value) {  		
				# Update produtos no estoque.
				$this->db->where(array('produtos_id'=>$key, 'lotacoes_id'=>$origem);
				$this->db->update('estoques', array('quantidade_estoque'=>$value));
			}
			return $this->db->affected_rows();
		}
	}*/

	public function concluir_saida($cautela_id) {
		$origem = array(); # Guarda o estoque atual de cada produto no estoque de origem
		$destino = array(); # Guarda o estoque atual de cada produto no estoque destino
		$produto = array(); # Guarda a quantidade de cada produto na cautela
		//$err_count = 0; # Contagem de erros
		$info_cautela = $this->getCautela($cautela_id)->row();
		//echo "<pre> Cautela: "; var_dump($info_cautela); echo "</pre>";
		$sql = "SELECT
							cautelas_has_produtos.id,
							cautelas_has_produtos.cautelas_id,
							cautelas_has_produtos.produtos_qde,
							cautelas_has_produtos.produtos_id,
							produtos.modelo AS produto,
							produtos.quantidade_minima,
							cautelas.distribuicao,
							cautelas.estoques_id AS origem,
							cautelas.setor_id AS destino,
							estoque_origem.quantidade AS origem_estoque,
							estoque_destino.quantidade AS destino_estoque
							FROM
								cautelas_has_produtos
								INNER JOIN produtos ON cautelas_has_produtos.produtos_id = produtos.id
								INNER JOIN cautelas ON cautelas.id = cautelas_has_produtos.cautelas_id
								INNER JOIN lotacoes AS origem ON cautelas.estoques_id = origem.id
								INNER JOIN lotacoes AS destino ON cautelas.setor_id = destino.id
								INNER JOIN estoques AS estoque_origem ON cautelas_has_produtos.produtos_id = estoque_origem.produtos_id AND origem.id = estoque_origem.lotacoes_id
								LEFT JOIN estoques AS estoque_destino ON cautelas_has_produtos.produtos_id = estoque_destino.produtos_id AND destino.id = estoque_destino.lotacoes_id
							WHERE
								cautelas_has_produtos.cautelas_id = $cautela_id";
		$result_id = $this->db->query($sql)->result();
		//echo "<pre>"; var_dump($result_id); echo "</pre>";
		$cont = count($result_id);
		# Tentando alterar o estoque
		if($cont > 0) {
			# Garantindo o retorno ao estado inicial e juntando as quantidades dos produtos repetidos
			foreach ($result_id as $item) {
				$origem[$item->produtos_id] = (int) $item->origem_estoque; # Estoque atual do produto na origem
				$destino[$item->produtos_id] = (int) $item->destino_estoque; # Estoque atual do produto no destino
				# Testa se o produto já apareceu na cautela e soma as quantidades
				if (! isset($produto[$item->produtos_id])) $produto[$item->produtos_id] = (int) $item->produtos_qde;
				else $produto[$item->produtos_id] = (int) $produto[$item->produtos_id] + (int) $item->produtos_qde; 
			}
			//echo "<pre> Origem: "; var_dump($origem); echo "</pre>";
			//echo "<pre> Destino: "; var_dump($destino); echo "</pre>";
			# Atualizando o estoque
			foreach ($produto as $_id=>$_qde) {
				$origem_atualizar = (int) $origem[$_id] - $_qde;
				$destino_atualizar = (int) $destino[$_id] + $_qde;
				# Atualizando origem
				$this->db->where(array('lotacoes_id'=>$info_cautela->origem_id, 'produtos_id'=>$_id));
				$this->db->update('estoques', array('quantidade'=>$origem_atualizar));
				//if ($this->db->affected_rows() < 1) $err_count++; # Havendo erro
				# Atualizando destino
				$controle = $this->db->get_where('estoques', array('lotacoes_id'=>$info_cautela->setor_id, 'produtos_id'=>$_id));
				//echo "<pre> Controle: "; var_dump($controle->num_rows); echo "</pre>";
				if ($controle->num_rows > 0) {
					//echo "Update: this->db->update('estoque', array('quantidade'=>$destino_atualizar));";
					$this->db->where(array('lotacoes_id'=>$info_cautela->setor_id, 'produtos_id'=>$_id));
					$this->db->update('estoques', array('quantidade'=>$destino_atualizar));
					//if ($this->db->affected_rows() < 1) $err_count++; # Havendo erro
				}
				else {
					//echo "Insert: this->db->insert('estoque', array('lotacoes_id'=>$info_cautela->setor_id, 'produtos_id'=>$_id,'quantidade'=>$destino_atualizar))";
					$this->db->insert('estoques', array('lotacoes_id'=>$info_cautela->setor_id, 'produtos_id'=>$_id,'quantidade'=>$destino_atualizar));
					//if ($this->db->affected_rows() < 1) $err_count++; # Havendo erro
				}
			}
			return TRUE;
		}
		# Cautela vazia
		else return FALSE;
	}

	public function consulta_cautela($filter) {
		$sql =  "SELECT
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
							AND (cautelas.distribuicao = 0)";
		# Aplicação dos filtros
		if (! empty($filter)) {
			# Filtro de matrícula
			if (isset($filter['matricula']) && $filter['matricula'] !== FALSE && $filter['matricula'] != '') {
				$sql .= " AND (militares.matricula = '".$filter['matricula']."')";
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
			} 
			else {
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '2014-06-01' AND '$dtFim')";
			} 
			# Fim do filtro de datas
			
			# Filtro de concluídas
			if (isset($filter['concluida'])) {
				if ($filter['concluida'] !== FALSE) $sql .= " AND (cautelas.concluida = ".$filter['concluida'].")";
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
		$sql =  "SELECT
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
							INNER JOIN lotacoes ON cautelas.setor_id = lotacoes.id
						WHERE 
							(cautelas.ativa = 1)
							AND (cautelas.distribuicao > 0)";
		# Aplicação dos filtros
		if (! empty($filter)) {
			# Filtro de setor
			if (isset($filter['setor_id']) && $filter['setor_id'] !== FALSE && $filter['setor_id'] != 0) {
				$sql .= " AND (cautelas.setor_id = '".$filter['setor_id']."')";
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
			} 
			else {
				$dtFim = date("Y-m-d", strtotime("now"));
				if (isset($filter['data_fim']) && $filter['data_fim'] != '') {
					$dtFim = $filter['data_fim'];
				}
				$sql .= " AND (cautelas.data_cautela BETWEEN '2014-06-01' AND '$dtFim')";
			} 
			# Fim do filtro de datas
			
			# Filtro de concluídas
			/*if (isset($filter['concluida'])) {
				if ($filter['concluida'] !== FALSE) $sql .= " AND (cautelas.concluida = ".$filter['concluida'].")";
				else $sql .= " AND (cautelas.concluida = 1)";
			}*/
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
