<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Lotacao extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('lotacao_model');
		# $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$this->cadastro();
	}

	public function cadastro($data = "") {
		# Exibe a página para cadastro de lotações no organograma.
		$lista_subordinados = $this->lotacao_model->getById();
		$conteudo = $this->load->view('lotacao/cadastro', array('data' => $data, 'lista_subordinados'=>$lista_subordinados), TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function editar($id) {
		# Exibe a página para editar lotações no organograma.
		$data = $this->lotacao_model->getById($id);
		$this->cadastro($data);
	}

	public function consulta() {
		# Exibe a página para consultar lotações no organograma.
		$conteudo = $this->load->view('lotacao/consulta', '', TRUE);
		$this->load->view('layout/index', array('layout' => $conteudo), FALSE);
	}

	public function excluir($id) {
		# Method respónsavel por exluir lotação no organograma.
		$this->lotacao_model->excluir($id);
		redirect('rh/lotacao/');
	}

	public function salvar() { 
		# Method respónsavel por salvar dados no organograma.
		if ($this->input->server('REQUEST_METHOD')  === 'POST') {
			$this->form_validation->set_rules('nome', 'Seção', 'required|max_length[80]');
			$this->form_validation->set_rules('sigla', 'Sigla', 'required|max_length[10]');
			$this->form_validation->set_rules('id_secao_superior', 'seção subordinada', 'required');

			if ($this->form_validation->run() === FALSE) {
				$this->cadastro();
			} else {
					$data = array(
						'id'=>$this->input->post('id'), 
						'nome'=>$this->input->post('nome'), 
						'sigla'=>$this->input->post('sigla'), 
						'superior_id'=>$this->input->post('id_secao_superior')
					); 

					if (empty($data['id'])) { 
						if ($this->lotacao_model->salvar($data)) {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
						} else {
							$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
						}
					} else {
							# Variável usada para debugar o envio de dados pelo method POST.
							# $debug="";
							if (isset($debug)) {
								print "<pre>";
									var_dump($data);
								print "</pre>";
							}

							if ($this->lotacao_model->atualizar($data)) {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
							} else {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
							}
					}

				redirect('rh/lotacao/consulta/'); 
			}
		}
	}

	public function construir_arvore($id_consulta) {
		# Method respónsavel por construir uma arvore de hierarquia da corporação.
		$var = $this->lotacao_model->consulta_lotacoes($id_consulta);
		$my_tree = NULL;
		foreach (array_reverse($var) as $key => $value) {
			$my_tree .= $key."(".$value.")/";
		}
		return $my_tree;
	}

	public function listar_lotacoes() {
		# Method respónsavel por ir ao lotacao_model fazer uma busca e listar todas as lotações.
		$filter = array();
		if ($this->input->get("nome") != "") {
			$filter['nome'] = $this->input->get("nome");
		}

		$lotacao = $this->lotacao_model->getLotacao($filter);
		$this->load->view('lotacao/resultado_consulta', array('lotacao' => $lotacao), FALSE);
	}
}