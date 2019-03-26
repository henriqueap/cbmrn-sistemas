<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

 /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
class Afastamentos extends MX_Controller {

	function __construct() {
		parent::__construct();
    date_default_timezone_set('America/Recife');
    $this->load->model('afastamentos_model');
    # $this->output->enable_profiler(TRUE);
  }

	public function index() {
		$this->consulta();
	}

	/**
	 * @param $data
	 * Exibir página para cadastro de afastamentos.
	 */
	public function cadastro($data="") {
		# Listar tipo de afastamentos.
		$listar_afastamentos = $this->afastamentos_model->getByIdAfastamentos();
		
		# Exibir página cadastro de afastamentos.
		$conteudo = $this->load->view('afastamentos/cadastro', array('listar_afastamentos'=>$listar_afastamentos), TRUE);
		$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
	}

	/**
	 * @param $data
	 * Exibir página para cadastro de afastamentos.
	 */
	public function cadastro_tipo($data="") {
		# Listar tipo de afastamentos.
		$listar_afastamentos = $this->afastamentos_model->getByIdAfastamentos();
		# Carregando variáveis
		$vars = array('listar_afastamentos'=>$listar_afastamentos);
		if (! empty($data)) $vars['data'] = $data;
		# Exibir página para cadastrar/editar tipos de afastamentos.
		$conteudo = $this->load->view('afastamentos/cadastro_tipo', $vars, TRUE);
		$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
	}

	/**
	 * @param empty
	 * Exibe página de consulta.
	 */
	public function consulta() {
		# Listagem de todos os tipos de afastamentos.
		$tipo_afastamentos = $this->afastamentos_model->getByIdAfastamentos();

		# Exibir página consulta de afastamentos.
		$conteudo = $this->load->view('afastamentos/consulta', array('tipo_afastamentos'=>$tipo_afastamentos), TRUE);
		$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
	}

	/**
	 * @param empty
	 * Exibe página de consulta.
	 */
	public function consulta_tipo() {
		# Listagem de todos os tipos de afastamentos.
		$tipo_afastamentos = $this->afastamentos_model->getByIdAfastamentos();

		# Exibir página consulta de afastamentos.
		$conteudo = $this->load->view('afastamentos/consulta_tipo', array('tipo_afastamentos'=>$tipo_afastamentos), TRUE);
		$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
	}

	/**
	 * @param empty
	 * Salvar alterações enviadas nos formulários.
	 */
	public function salvar() {
		if ($this->input->server('REQUEST_METHOD') == "POST") {
			
			# Validação de formulários.
			$this->form_validation->set_rules('chefe_militares_id_hidden', 'Matrícula', 'required');
			$this->form_validation->set_rules('tipo_afastamentos_id', 'Tipo de Afastamento', 'required');
			$this->form_validation->set_rules('justificativas', 'Justificativas para  o Afastamento', 'required');
			$this->form_validation->set_rules('data_inicio', 'Data Início', 'required');
			$this->form_validation->set_rules('data_fim', 'Data Fim', 'required');

			if ($this->form_validation->run() == FALSE) {
				$this->cadastro();
			} else { 

				# Obter data final.
				$data_fim = date('Y-m-d', strtotime(" +".$this->input->post('data_fim')." days", strtotime($this->input->post('data_inicio'))));;
				
				# Capturar dados envidos pelo method POST.
				$data = array(
					'id'=>$this->input->post('id'),
					'militares_id'=>$this->input->post('chefe_militares_id_hidden'), 
					'tipo_afastamentos_id'=>$this->input->post('tipo_afastamentos_id'), 
					'justificativas'=>$this->input->post('justificativas'), 
					'data_inicio'=>$this->input->post('data_inicio'), 
					'data_fim'=>$data_fim, 
					'numero_processo'=>$this->input->post('numero_processo')
				);

				# Caso não tenha sido enviado nenhum id o afastamento será criado e não alterado.
				if (empty($data['id'])) { 
          # Caso não exista id no POST, executará esse bloco de código.
          if ($this->afastamentos_model->salvar($data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
          }
        } else {
          if ($this->afastamentos_model->atualizar($data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
          }
        }

        # Redirecionamento Final da Página.
        redirect('rh/afastamentos/cadastro/');
			}
		}
	}

	public function salvar_tipo() { 
		# Método responsável por salvar os tipos de afastamentos
		if ($this->input->server('REQUEST_METHOD')  === 'POST') {
			$this->form_validation->set_rules('nome', 'Tipo de Afastamento', 'required');
			$this->form_validation->set_rules('dias', 'Dias', 'required');

			if ($this->form_validation->run() === FALSE) {
				$tipo_afastamentos = $this->afastamentos_model->getByIdAfastamentos();
				$conteudo = $this->load->view('afastamentos/cadastro_tipo', array('tipo_afastamentos'=>$tipo_afastamentos), TRUE);
				$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
			} else {
					$data = array(
						'tabela'=>'tipo_afastamentos',
						'id'=>$this->input->post('id'),
						'nome'=>$this->input->post('nome'), 
						'dias'=>$this->input->post('dias')
					); 

					if (empty($data['id'])) { 
						if ($this->afastamentos_model->salvar($data)) {
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

							if ($this->afastamentos_model->atualizar($data)) {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
							} else {
								$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
							}
					}

				redirect('rh/afastamentos/cadastro_tipo/'); 
			}
		}
	}

	/**
	 * @param int $id
	 * Pega minformações que iram ser enviadas via parâmetro no method cadastro da mesma classe. 
	 */
	public function editar($id) {
		$data = $this->afastamentos_model->getById($id);
		$this->cadastro($data);
	}

	/**
	 * @param int $id
	 * Pega minformações que iram ser enviadas via parâmetro no method cadastro da mesma classe. 
	 */
	public function editar_tipo($id) {
		$data = $this->afastamentos_model->getById($id, 'tipo_afastamentos');
		#var_dump($data); die();
		$this->cadastro_tipo($data);
	}

	/**
	 * @param int $id
	 * Excluí o afastamentos pelo id na tabela.
	 */
	public function excluir($id) {
		$data = array('tabela'=>'tipo_afastamentos', 'id' => $id);
		$this->afastamentos_model->excluir($data);
		redirect('rh/afastamentos/consulta/');
	}

	/**
	 * @param int $id
	 * Excluí o afastamentos pelo id na tabela.
	 */
	public function excluir_tipo($id) {
		$data = array('tabela'=>'tipo_afastamentos', 'id' => $id);
		$this->afastamentos_model->excluir($data);
		redirect('rh/afastamentos/cadastro_tipo/');
	}
	
	public function consulta_afastamentos() {
		if ($this->input->server('REQUEST_METHOD') == 'GET') {
			# Inicialização de array.
			$filter = array();

			if ($this->input->get("chefe_militares_id_hidden") != "") {
	      $filter['chefe_militares_id_hidden'] = $this->input->get("chefe_militares_id_hidden");
	    }

	   	if ($this->input->get("numero_processo") != "") {
	      $filter['numero_processo'] = $this->input->get("numero_processo");
	   	}

	   	if ($this->input->get("tipo_afastamentos_id") != "") {
	   		$filter['tipo_afastamentos_id'] = $this->input->get("tipo_afastamentos_id");
	   	}

	   	if ($this->input->get("exercicio") != "") {
	   		$filter['exercicio'] = $this->input->get("exercicio");
	   	}

	   	if ($this->input->get("data_inicio") != "") {
	   		$filter['data_inicio'] = $this->input->get("data_inicio");
	   	}

	   	if ($this->input->get("data_fim") != "") {
	   		$filter['data_fim'] = $this->input->get("data_fim");
	   	}

	   	# Consulta ao model.
			$consulta = $this->afastamentos_model->getAfastamentosFilter($filter)->result();

			# $debug="";
			if (isset($debug)) {
				print "<pre>";
					var_dump($filter);
				print "</pre>";
			}

			$this->load->view('afastamentos/resultado_consulta', array('consulta'=>$consulta), FALSE);
		} # endif REQUEST_METHOD.
	}

	/**
	 * @param $id
	 * Cancelar afastamentos pelo $id do afastamento.
	 */
	public function cancelar_afastamentos($id) {
		if ($this->afastamentos_model->cancelar_afastamentos($id)) {
		 	$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Afastamentos cancelado com sucesso!'));
		 	redirect('rh/afastamentos/consulta');
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Afastamentos não foi cancelado!'));
		 	redirect('rh/afastamentos/consulta');
		}
	}

	# Method ainda não implementado...
	public function getAfastamentosById() {
		$afastamentos = $this->afastamentos_model->getById($this->input->get("id"));
		$this->output->set_content_type('application/json');
    $this->output->set_output(json_encode(array('afastamentos'=>$afastamentos)));
	}
}
