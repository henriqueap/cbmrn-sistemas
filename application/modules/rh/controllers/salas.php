<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Salas extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('salas_model', 'lotacao_model'));
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$this->consulta();
	}

	public function cadastro($data = "") {
		# Pega o array com os dados!
		$array = array(
			'data' => $data, 
			'secoes'=>$this->lotacao_model->getLotacoes()
		);

		$conteudo = $this->load->view('salas/cadastro', $array, TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function salvar() {
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$this->form_validation->set_rules('id_secao_superior', 'seção superior', 'required|max_length[40]');
			$this->form_validation->set_rules('nome', 'Sala', 'required|max_length[40]');

			if ($this->form_validation->run() === FALSE) {
				$this->cadastro();
			} else {
				$data = array(
					'id' => $this->input->post('id'),
					'nome' => $this->input->post('nome'), 
					'superior_id'=>$this->input->post('id_secao_superior')
				);

				if ($this->input->post('chefe_militares_id') != "") {
					$data['chefe_militares_id'] = $this->input->post('chefe_militares_id');
				}

				if (empty($data['id'])) {
						if ($this->salas_model->salvar($data)) {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
						} else {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao cadastrar!'));
						}
				} else {
						if ($this->salas_model->atualizar($data)) {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
						} else {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
						}
					}

					# Redirecionar para página de salas.
					redirect('rh/salas/');
			}
		}
	} 

	# Method para fazer consultas no model salas.
	public function consulta() {
		$conteudo = $this->load->view('salas/consulta', '', TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	# Method responsável pela edição dos dados da sala.
	public function editar($id) {
		$data = $this->salas_model->getById($id);
		$this->cadastro($data);
	}

	public function excluir($id) {
		$this->salas_model->excluir($id);
		redirect('rh/salas/');
	}

	# Listar todas  as salas cadastradas, filtrando pelo nome se for o caso.
	public function listar_salas() {
		$filter = array();

		if ($this->input->get("nome") != "") {
			$filter['nome'] = $this->input->get("nome");
		}

		$salas = $this->salas_model->getSalas($filter);
		$this->load->view('salas/resultado_consulta', array('salas' => $salas), FALSE);
	}

	# Method não usado na atual arquitetura do sistema.
	public function listBySetorToSelect() {
		$filter = array();
		if ($this->input->get("setor") != "") {
			$filter['setor_setores_id'] = $this->input->get("setor");
		}

		$getSalas = $this->salas_model->getSalas($filter);
		$this->load->view('salas/select', array('listSalas' => $getSalas), FALSE);
	}
}
