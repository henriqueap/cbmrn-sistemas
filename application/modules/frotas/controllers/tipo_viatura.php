<?php

if (!defined('BASEPATH'))
		exit('No direct script access allowed');

 /**
	* @version 1.0
	* @author CBM-RN
	* @link http://www.cbm.rn.gov.br/
	*/
class Tipo_viatura extends MX_Controller {

	function __construct() {
		parent::__construct();
		$_models = array(
			'frotas_model', 
			'tipo_viatura_model'
		);
		$this->load->model($_models);
	}

	public function cadastro($data = ''){
		$_viaturas = $this->tipo_viatura_model->listar();
		$tipo_viatura = $this->load->view('tipo_viatura/cadastro', array('data' => $data , 'listar_viaturas' => $_viaturas), TRUE);
		$this->load->view('layout/index', array('layout' => $tipo_viatura ), FALSE);
	}

	public function testes($id) {
		if ($this->tipo_viatura_model->testaExiste($id) === FALSE) { //Tem registro, não altera
			$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro, este tipo de viatura esta em uso, não é possível excluí-lo!'));
			} else { //Não tem registro, altera
					if ($this->tipo_viatura_model->excluir($id) === FALSE) { //Não alterou
						$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
						} else { //Alterou
							$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!'));
					}
		}
		redirect('frotas/tipo_viatura/cadastro');
	}

	public function editar($id){
		$data = $this->tipo_viatura_model->getById($id);
		$this->cadastro($data); //Precisa ajustyar se id inexistente?
	}

	public function salvar(){
		if ($this->input->server('REQUEST_METHOD') === 'POST') {
			$this->form_validation->set_rules('txtTipoViatura', 'o campo não foi preenchido corretamente' , 'required');
		
			if ($this->form_validation->run() === FALSE) {
				$this->cadastro();
				} else {
				$data  = array (
					'id' => $this->input->post('id'),
					'tipo' => $this->input->post('txtTipoViatura'),
				);
			}

			#tratar excessões
			if(empty($data['id'])) {
				if ($this->tipo_viatura_model->cadastrar($data) == FALSE) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao cadastrar!'));
				} else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Cadastrado com sucesso!'));
				}
			} else {
				if ($this->tipo_viatura_model->atualizar($data)) {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-success', 'msg' => 'Atualizado com sucesso!' ));
				} else {
					$this->session->set_flashdata('mensagem', array('type' => 'alert-danger', 'msg' => 'Erro ao atualizar!'));
				}
			}

			redirect('frotas/tipo_viatura/cadastro');     
		}
	}
}
