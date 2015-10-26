<?php

class Notas_model extends CI_Model {
	
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function dados_notas() {
		# Salvar primeiros dados da nota fiscal.
		$data = array(
			'numero'=>$this->input->post('numero'), 
			'empresas_id'=>$this->input->post('empresas_id'), 
			'tipo'=>$this->input->post('tipo_nota_fiscal'), 
			'data'=>$this->clog_model->formataData($this->input->post('data'))
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
		} 
		else {
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
		if (! empty($produtos_id)) $produtos_id = $this->input->post('produtos_id');
		else { 
			$produtos_id = NULL; 
			return FALSE;
		} 
		# Tratando o valor unitario
		$tam = count($this->input->post('valor_unitario'));
		$cents =  str_ireplace(',', '.', substr($this->input->post('valor_unitario'), - 3));
		$new_val = substr($this->input->post('valor_unitario'), 0, $tam - 4);
		$valor_unitario = str_ireplace('.', '', $new_val).$cents;
		# Criando o array para inserir no banco
		$data = array( 
			'notas_fiscais_id'=>$this->input->post('notas_fiscais_id'), 
			'valor_unitario'=>$valor_unitario, 
			'quantidade_item'=>$this->input->post('quantidade_item'), 
			'produtos_id'=>$produtos_id, 
			'tipo_servicos_id'=>$tipo_servicos_id
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
								$novo_arr[$t] = $n ;
								$n++;
								$t++; 
							}
						}
						else return FALSE;
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
						$controle = $this->db->insert('patrimonio', array('tombo'=>$tombo, 'produtos_id'=>$data['produtos_id'], 'notas_id'=>$data['notas_fiscais_id']));
						if ($this->db->affected_rows() < 1) {
							$fails[] = $tombo;
							$err_count++; 
						}
					}
				}
				else return FALSE; 
			}
		}
		# Inclui os ítens na nota
		if ($err_count == 0) {
			$query = $this->db->insert('itens_notas_fiscais', $data); 
			if ($this->db->affected_rows() > 0) {
				return $query;
			} 
			else return FALSE;
		}
		else return FALSE;
	}

	public function concluir_notas_fiscais($data) {
		if(is_array($data)){
			$concluir = array(
				'concluido'=>'1',	
				'valor'=>$data['valor_final']
				);
			$query = $this->db->update('notas_fiscais', $concluir, array('id'=>$data['id_nota_fiscal']));
			#var_dump($query); die();
			return true;
		}
		else{
			return false;	
		}
	}

	public function concluir_atualizar_estoque($id) {
		$err_count = 0;
		$this->db->select('*');
		$this->db->where('notas_fiscais_id', $id);
		$query = $this->db->get('itens_notas_fiscais');

		foreach ($query->result() as $query) {
			$this->db->select('quantidade');
			$this->db->where(array('id'=>$query->produtos_id, 'lotacoes_id'=>23));
			$estoque_atual = $this->db->get('estoques')->row();

			$estoque_atual = $estoque_atual->quantidade + $query->quantidade_item;
			$this->db->where(array('id'=>$query->produtos_id, 'lotacoes_id'=>23));
			$this->db->update('estoques', array('quantidade'=>$estoque_atual));


			# Havendo erro
			if ($this->db->affected_rows() < 1) {
				$produtos[$err_count] = $item->modelo;
				$err_count++;
			}

			/*!
				$estoque_atual = $estoque_atual->quantidade_estoque + $query->quantidade_item;
				$this->db->where('id', $query->produtos_id);
				$this->db->update('produtos', array('quantidade_disponivel'=>$estoque_atual));
			*/
		}
		if($err_count == 0) return TRUE;
		else return $produtos;
	}

	public function consulta_notas_fiscais($filter) {
		# Consulta de notas fiscais.
		$this->db->select("notas_fiscais.id as id_nota, notas_fiscais.valor, notas_fiscais.data, notas_fiscais.numero, empresas.nome_fantasia, notas_fiscais.id, notas_fiscais.concluido, notas_fiscais.ativo");
		$this->db->from("notas_fiscais");

		$this->db->join('empresas', 'empresas.id = notas_fiscais.empresas_id');

		# WHERE LIKES
    if (isset($filter['nota_fiscal'])) {
      $this->db->like('notas_fiscais.numero', $filter['nota_fiscal']);
    }

    if (isset($filter['data'])) {
      $this->db->like('notas_fiscais.data', $filter['data']);
    }

    if (isset($filter['empresas_id'])) {
      $this->db->like('notas_fiscais.empresas_id', $filter['empresas_id']);
    }

    $query = $this->db->get();
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
		$this->db->where('id', $id);
		$query = $this->db->get("notas_fiscais")->row();
		#var_dump($query);

		if ($query->tipo != 0) {
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
		else {
			$_sql = "SELECT 
								itens_notas_fiscais.id as id_itens, 
								itens_notas_fiscais.valor_unitario, 
								itens_notas_fiscais.quantidade_item, 
								produtos.modelo,
								notas_fiscais.concluido,
								itens_notas_fiscais.produtos_id 
								FROM 
									itens_notas_fiscais 
									INNER JOIN notas_fiscais ON itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id
									INNER JOIN produtos ON itens_notas_fiscais.produtos_id = produtos.id
								WHERE   
									itens_notas_fiscais.notas_fiscais_id = {$id}";
		}

		$query = $this->db->query($_sql)->row();
		#var_dump($query);
		//var_dump($query); //die();
		 if($query->concluido == 1){
		 	$data=array(
		 		'id'=>$id,
		 		'ativo'=>1
		 		);
		 	$query2 = $this->db->update('notas_fiscais', $data, "id = ".$data["id"]);
		 	if($query2 == true){
				$query3=$this->db->query("select quantidade_estoque from produtos where id = ".$query->produtos_id)->row();
		 		
		 		$data1=array(
			 		'id'=>$query->produtos_id,
			 		'quantidade_estoque'=>$query3->quantidade_estoque - $query->quantidade_item
		 		);
		 		$query4 = $this->db->update('produtos', $data1, "id = ".$data1["id"]);
		 		if ($query4 == true){
		 			return true;
		 		}else{
		 			return false;
		 		}
		 	}
		 	 
		
		 }
	}
}
