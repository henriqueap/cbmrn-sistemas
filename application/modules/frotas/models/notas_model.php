<?php

class Notas_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function dados_notas() 
	{
		# Salvar primeiros dados da nota fiscal.
		$data = array(
			'numero'=>$this->input->post('numero'), 
			'empresas_id'=>$this->input->post('empresas_id'), 
			'data'=>$this->input->post('data')
		);

		$this->db->insert('notas_fiscais', $data);
		return $this->db->insert_id();
	}

	# ID da nota fiscal, assim pegar todos os seus itens já cadastrados.
	public function itens_notas($id)
	{
		$query = $this->db->query("SELECT itens_notas_fiscais.valor_unitario, itens_notas_fiscais.quantidade_item, produtos.modelo FROM itens_notas_fiscais, notas_fiscais, produtos WHERE itens_notas_fiscais.produtos_id = produtos.id AND itens_notas_fiscais.notas_fiscais_id = notas_fiscais.id AND itens_notas_fiscais.notas_fiscais_id = {$id}");
		return $query;
	}

	public function add_item($id_nota)
	{
		$data = array(
			'notas_fiscais_id'=>$this->input->post('notas_fiscais_id'), 
			'valor_unitario'=>$this->input->post('valor_unitario'), 
			'quantidade_item'=>$this->input->post('quantidade_item'),
			'produtos_id'=>$this->input->post('produtos_id'), 
		);

		$tombos = explode(",", $this->input->post('numero_tombo'));

		for ($i = 0; $i <= sizeof($tombos); $i++) {
			$novo_arr = array('tombo'=>ltrim($tombos[$i]), 'produtos_id'=>$data['produtos_id']);
			$this->db->insert('patrimonio', $novo_arr);
		}

		# INSERT INTO itens_notas_fiscais;
		$query = $this->db->insert('itens_notas_fiscais', $data);
		return $query;
	}

	public function valor_notas()
	{
		# Somar valor dos itens da nota fiscal.
		# $query = $this->db->query("");
		# return $query;
	}
}
