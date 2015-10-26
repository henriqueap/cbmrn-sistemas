<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */

class Locais extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ocorrencias_model');
	}

	public function index()
	{
		$this->cadastro();
	}

	public function cadastro($data="") 
	{
		$cidades = $this->ocorrencias_model->listar('cidades', NULL, 'cidade')->result();

		# var_dump($cidades);

		$layout = $this->load->view('locais/cadastro', array('data'=>$data, 'cidades'=>$cidades), TRUE);
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);	
	}

	public function editar($id) 
	{
		# Editar locais.
		$data = $this->ocorrencias_model->listar('gbs_locais', $id)->result();
		$this->cadastro($data);
	}

	public function consulta() 
	{
		# Lista de todos os loncais cadastrados.
		$this->ocorrencias_model->listar('gbs_locais', NULL, 'cidade')->result();

		$layout = $this->load->view('locais/consulta', '', TRUE );
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);	
	}

	public function salvar()
	{
		$data = array(
			'id'=>$this->input->post('id'), 
			'cidade'=>$this->input->post('cidade'), 
			'estado'=>'RN', 
			'localidade'=>$this->input->post('localidade')
		);

		if (!	$data['id'] != NULL) {
			$this->ocorrencias_model->salvar_locais('gbs_locais', $data);			
		} else {
			$this->ocorrencias_model->atualizar('gbs_locais', $data);
		}
		redirect('ocorrencias/locais/consulta');
	}

	public function consulta_localidades()
	{
		$filter = array();

		if (!$this->input->get('cidade') == "" ) {
			$filter['cidade'] = $this->input->get('cidade');
		}

		$consulta = $this->ocorrencias_model->consulta_localidades($filter)->result();
		return $this->load->view('ocorrencias/locais/resultado_consulta', array('consulta'=>$consulta), FALSE);
	}

	public function excluir($id)
	{
		if ($this->ocorrencias_model->excluir_locais($id) > 0) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Registro excluído com sucesso!'));
			redirect('ocorrencias/locais/consulta');
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao excluír registro!'));
			redirect('ocorrencias/locais/consulta');
		}
	}
}

