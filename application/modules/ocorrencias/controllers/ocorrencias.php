<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/

class Ocorrencias extends MX_Controller
{
	
	function __construct()
	{
		parent::__construct();
		#  $this->output->enable_profiler(TRUE);
		$this->load->model('ocorrencias_model');
		# $this->load->library('auth');
	}

	public function index()
	{
		$this->cadastro();
	}

	public function cadastro($data="") 
	{
		# $id = $this->session->userdata('id');
		$all = $this->session->all_userdata();
		# var_dump($all);
		$graphs = $this->ocorrencias_model->getOcorrencias();
		# Listar tipo de ocorrências.
		$tipo_ocorrencia = $this->ocorrencias_model->listar_tipos()->result();

		# Listar locais.
		$locais = $this->ocorrencias_model->listar('gbs_locais', NULL, 'cidade')->result();

		$layout = $this->load->view('ocorrencias/ocorrencias/cadastro', array('tipo_ocorrencia'=>$tipo_ocorrencia, 'locais'=>$locais, 'data'=>$data, 'graphs'=>$graphs), TRUE );
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);
	}

	public function consulta($data="") 
	{
		# Listar tipo de ocorrências.
		$tipo_ocorrencia = $this->ocorrencias_model->listar_tipos()->result();

		# Listar locais.
		$locais = $this->ocorrencias_model->listar('gbs_locais', NULL, 'cidade')->result();
		
		$layout = $this->load->view('ocorrencias/ocorrencias/consulta', array('tipo_ocorrencia'=>$tipo_ocorrencia, 'locais'=>$locais), TRUE );
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);	
	}

	public function editar($id) 
	{
		$ocorrencia = $this->ocorrencias_model->listar('gbs_ocorrencias', $id)->result();
		$this->cadastro($ocorrencia);
	}

	public function salvar()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			
			$data = array(
				'id'=>$this->input->post('id'), 
				'domicilio'=>$this->input->post('domicilio'),
				'gbs_locais_id'=>$this->input->post('localidade'),  
				'idade'=>$this->input->post('idade'), 
				'data'=>$this->input->post('data'), 
				'horario'=>$this->input->post('horario'), 
				'tipo_ocorrencias_id'=>$this->input->post('tipo_ocorrencia')
			);

			# $this->ocorrencias_model->salvar_ocorrencias('gbs_ocorrencias', $data);
			if (  !	$data['id'] != NULL ) {

				if ($data['idade'] == NULL ) {
					$data['idade'] = 0;
				}


				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
				$this->ocorrencias_model->salvar_ocorrencias('gbs_ocorrencias', $data);
			} else {
				
				if ($data['idade'] == NULL ) {
					$data['idade'] = 0;
				}

				$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
				$this->ocorrencias_model->atualizar('gbs_ocorrencias', $data);
			}

			redirect('ocorrencias/ocorrencias/consulta');
		} else exit();
	}

	public function tipo_ocorrencia($data="") 
	{
		$tipo_ocorrencia = $this->ocorrencias_model->listar_tipos()->result();
		$layout = $this->load->view('ocorrencias/ocorrencias/tipo_ocorrencia', array('tipo_ocorrencia'=>$tipo_ocorrencia, 'data'=>$data), TRUE );
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);	
	}

	public function salvar_tipo_ocorrencias()
	{
		# Salvar tipo de ocorrências.
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			# Validação de formulários.
			$this->form_validation->set_rules('ocorrencia', 'ocorrencia', 'trim|required|min_length[1]|max_length[45]|xss_clean');
			$this->form_validation->set_rules('codigo', 'codigo', 'trim|required|min_length[1]|max_length[45]|xss_clean');

			if ($this->form_validation->run() == TRUE) {
				# Capturar dados enviados pelo method post.
				$data = array(
					'id'=>$this->input->post('id'), 
					'ocorrencia'=>$this->input->post('ocorrencia'), 
					'codigo'=>$this->input->post('codigo')
				);

				# Executar insert banco de dados;
				if (!	$data['id'] != NULL) {
					if($this->ocorrencias_model->salvar_tipo_ocorrencias('gbs_tipo_ocorrencias', $data)) {
						redirect('ocorrencias/ocorrencias/tipo_ocorrencia');
					} else {}
				} else {
					# Ocorrências;
					if($this->ocorrencias_model->atualizar('gbs_tipo_ocorrencias', $data)) { redirect('ocorrencias/ocorrencias/tipo_ocorrencia'); }
				}
			}
		}
	}

	public function consulta_ocorrencias() 
	{
		$filter = array();

		if ($this->input->get('idade') != '') {
			$filter['idade'] = $this->input->get('idade');
		}

		if ($this->input->get('localidade') != '') {
			$filter['gbs_locais_id'] = $this->input->get('localidade');
		}

		if ($this->input->get('tipo_ocorrencia') != '') {
			$filter['tipo_ocorrencias_id'] = $this->input->get('tipo_ocorrencia');
		}

		if ($this->input->get('data_inicio') != '') {
			$filter['data_inicio'] = $this->input->get('data_inicio');
		}

		if ($this->input->get('data_fim') != '') {
			$filter['data_fim'] = $this->input->get('data_fim');
		}

		# var_dump($filter);
		$consulta = $this->ocorrencias_model->consulta_ocorrencias($filter)->result();  	
		$this->load->view('ocorrencias/resultado_consulta', array('consulta'=>$consulta), FALSE);
	}

	public function editar_tipo_ocorrencias($id) 
	{
		if (isset($id)) {
			$data = $this->ocorrencias_model->listar('gbs_tipo_ocorrencias', $id)->result(); 
			$this->tipo_ocorrencia($data);
		}
	}

	public function delete_tipo_ocorrencias($id)
	{
		if ($this->ocorrencias_model->excluir_tipo_ocorrencias($id)) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Exclusão concluida com sucesso!'));
			redirect('ocorrencias/ocorrencias/tipo_ocorrencia');
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao excluír tipo de ocorrência!'));
			redirect('ocorrencias/ocorrencias/tipo_ocorrencia');
		}
	}

	public function excluir($id)
	{
		if ($this->ocorrencias_model->excluir_ocorrencias($id) > 0) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Exclusão concluida com sucesso!'));
			redirect('ocorrencias/ocorrencias/consulta');
		}
	}

	/**
	 * Criar ocorrências de advertências.
	 * 
	 */
	public function prudencial($data="") 
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$data = array(
				'id'=>$this->input->post('id'),
				'data'=>$this->input->post('data'), 
				'gbs_locais_id'=>$this->input->post('localidade'), 
				'tipo_ocorrencias_id'=>$this->input->post('tipo_ocorrencia')
			);
			
			$quantidade = $this->input->post('quantidade'); 
			for($i=1; $i <= $quantidade; $i++) {
				# Array..
				$this->ocorrencias_model->salvar_ocorrencias_lotes('gbs_ocorrencias', $data);
			}
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastro em lotes concluída!'));
			redirect('/ocorrencias/ocorrencias/consulta');	
		}

		# Listar tipo de ocorrências.
		$tipo_ocorrencia = $this->ocorrencias_model->listar_tipos()->result();

		# Listar locais.
		$locais = $this->ocorrencias_model->listar('gbs_locais', NULL, 'cidade')->result();

		# Carregamento de páginas.
		$layout = $this->load->view('ocorrencias/ocorrencias/prudencial', array('tipo_ocorrencia'=>$tipo_ocorrencia, 'locais'=>$locais, 'data'=>$data), TRUE);
		$this->load->view('ocorrencias/layout/index', array('layout'=>$layout), FALSE);
	}

	public function dados_grafico() {
		$ocorrencias = $this->ocorrencias_model->getOcorrencias();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode(array('ocorrencias' => $ocorrencias)));
	}
	
	public function mostra_grafico() {
		$ocorrencias = $this->ocorrencias_model->getOcorrencias();
		$layout = $this->load->view('ocorrencias/ocorrencias/grafico_ocorrencias', '', TRUE );
		$this->load->view('layout/index', array('layout'=>$layout), FALSE);
	}
}
