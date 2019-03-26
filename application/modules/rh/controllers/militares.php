<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Militares extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('militares_model');
		$this->load->model('patentes_model');
		$this->load->model('lotacao_model');
		$this->load->model('salas_model');
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$this->consulta();
	}

	public function cadastro($data = "") {
		# Exibe a página para cadastro de militares.
		$listPatentes = $this->patentes_model->listPatentes();
		$lista_subordinados = $this->lotacao_model->getById();
		$lista_salas = $this->salas_model->getById();

		$array = array(
			'data' => $data,
			'listPatentes' => $listPatentes, 
			'lista_subordinados' => $lista_subordinados, 
			'lista_salas' => $lista_salas
		);

		$conteudo = $this->load->view('militares/cadastro', $array, TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function editar($id) {
		# Exibe a página para editar informações de militares.
		$data = $this->militares_model->getById($id);
		$this->cadastro($data);
	}

	public function consulta() {
		# Exibe a página para consulta de militares.
		$conteudo = $this->load->view('militares/consulta', '', TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function excluir($id) {
		# Method respónsavel pela exclusão do militar no sistema.
		$this->militares_model->excluir($id);
		redirect('rh/militares/');
	}

	public function salvar() {
		# Salvar os registros!  
		if ($this->input->server('REQUEST_METHOD')  === 'POST') {
				# informações pessoais.
				$this->form_validation->set_rules('matricula', 'Matricula', 'required');
				$this->form_validation->set_rules('nome', 'Nome', 'required');
				$this->form_validation->set_rules('cpf', 'CPF', 'required');
				$this->form_validation->set_rules('rg', 'RG', 'required');
				
				# informações de militares.
				$this->form_validation->set_rules('nome_guerra', 'Nome de Guerra', 'required');
				$this->form_validation->set_rules('num_praca', 'Número', 'required');
				$this->form_validation->set_rules('patente_patentes_id', 'Patente', 'required');
				# $this->form_validation->set_rules('id_secao_superior', 'Seção Superior', 'required');
				
				# informações de contato.
				$this->form_validation->set_rules('email', 'E-Mail', 'required');
				
				# informações de acesso.
				# $this->form_validation->set_rules('senha', 'Senha', 'required|md5');

				if ($this->form_validation->run() === FALSE) {
						# Caso a validação tenho encontrado algum erro, exibirá na página de cadastro.
						$this->cadastro('');
				} else {
						# Pegar os dados enviados pelo method POST.
						$data = array(
								'id' => $this->input->post('id'),
								'matricula' => $this->input->post('matricula'),
								'nome' => $this->input->post('nome'),
								'cpf' => $this->input->post('cpf'),
								'rg' => $this->input->post('rg'),
								'nome_guerra' => $this->input->post('nome_guerra'),
								'num_praca' => $this->input->post('num_praca'),
								'patente_patentes_id' => $this->input->post('patente_patentes_id'),
								'sala_salas_id' => $this->input->post('sala_salas_id'),
								'email' => $this->input->post('email'),
								'senha' => md5($this->input->post('senha')), 
								'telefone' => $this->input->post('telefone')
						);

						# Verificação se foi passado algum id existente pelo method POST.
						if (empty($data['id'])) {
								if ($this->militares_model->salvar($data)) {
										$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao cadastrar!'));
										# $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
								} else {
										# $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao cadastrar!'));
										$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
								}
						} else {
								if ($this->militares_model->atualizar($data)) {
										$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
								} else {
										$this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
								}
						}

						# Redireciona a página quando a inserção dos dados forem concluídos.
						redirect('rh/militares/consulta/'); 
				}
		}
	}

	public function listar_militares() {
		# Method para listar os militares aplicando filtros.
		$filter = array();

		if ($this->input->get("nome") != "") {
			$filter['nome'] = $this->input->get("nome");
		}

		if ($this->input->get("matricula") != "") {
			$filter['matricula'] = $this->input->get("matricula");
		}

		$militares = $this->militares_model->getMilitares($filter);
		$this->load->view('militares/resultado_consulta', array('militares' => $militares), FALSE);
	}

	/**
	 * CONSULTAS VIA AJAX
	 */
	public function getMilitarByMatricula() {
		$militar = $this->militares_model->getByMatricula($this->input->get("matricula"));
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('militar' => $militar)));
	}
}
