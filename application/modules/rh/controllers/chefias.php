<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

  /**
  * @version 1.0
  * @author CBM-RN
  * @link http://www.cbm.rn.gov.br/
  */
  
class Chefias extends MX_Controller {

	function __construct() {
		parent::__construct();
    $this->load->model('chefias_model');
    $this->load->model('lotacao_model');
    # $this->output->enable_profiler(TRUE);
	}

	public function index() {
		$this->consulta();
	}

	/**
	 * @param $data array
	 * Exibe a página para cadastro de lotações no organograma.
	 */
	public function cadastro($data="") {
    $lista_lotacoes = $this->lotacao_model->getById();
		
		$conteudo = $this->load->view('chefias/cadastro', array('lista_lotacoes'=>$lista_lotacoes, 'data'=>$data), TRUE);
		$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
	}

	/**
	 * @param empty
	 * Exibi página para consultar chefias.
	 */
	public function consulta() {
		$conteudo = $this->load->view('chefias/consulta', '', TRUE);
		$this->load->view('layout/index', array('layout'=>$conteudo), FALSE);
	}


	/**
	 * @param empty
	 * 
	 */
	public function editar($id) {
		$data = $this->chefias_model->getbyId($id);
		$this->cadastro($data);
	}

	public function salvar() {
		if ($this->input->server('REQUEST_METHOD') == "POST") {

			$this->form_validation->set_rules('secao', 'Seção', 'required');
			$this->form_validation->set_rules('chefe_militares_id_hidden', 'Matrícula', 'required');

		 	if ($this->form_validation->run() === FALSE) {
        $this->cadastro();
    	} else {

    		# Não pode cadastrar mais de um fez o mesmo setor!
    		$data = array(
    			'id'=>$this->input->post('id'),
    			'lotacoes_id'=>$this->input->post('secao'), 
    			'militares_id'=>$this->input->post('chefe_militares_id_hidden')
    		);

        if (empty($data['id'])) { 
          if ($this->chefias_model->salvar($data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao cadastrar!'));
          }
        } else {
          if ($this->chefias_model->atualizar($data)) {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
          } else {
            $this->session->set_flashdata('mensagem', array('type' => 'alert-error', 'msg' => 'Erro ao atualizar!'));
          }
        }
        redirect('rh/chefias/consulta/'); 
    	}
		}
	}

	public function excluir($id) {
		if ($this->chefias_model->excluir($id)) {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Chefia excluída com sucesso!'));
			redirect('rh/chefias/consulta/');
		} else {
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, não foi possível excluír!'));
			redirect('rh/chefias/consulta/');
		}
	}

	public function consultar_chefias() {
		# inicializar array.
		$filter = array();

		if ($this->input->get('chefe_militares_id_hidden') != "") {
			$filter['chefe_militares_id_hidden'] = $this->input->get('chefe_militares_id_hidden');
		}

		$consulta = $this->chefias_model->consulta_chefias($filter);
		$this->load->view('chefias/resultado_consulta', array('consulta'=>$consulta), FALSE);
	}
}
